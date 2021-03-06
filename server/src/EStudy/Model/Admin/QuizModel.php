<?php

namespace EStudy\Model\Admin;

use EStudy\Entity\Admin\QuestionEntity;
use EStudy\Entity\Admin\QuizEntity;
use EStudy\Entity\Admin\TopicEntity;
use EStudy\Entity\Admin\VocabularyEntity;
use EStudy\Entity\Client\Pivot\UserQuizEntity;
use EStudy\Model\Admin\Pivot\QuestionQuizModel;
use EStudy\Model\Client\Pivot\UserQuizModel;
use Ninja\Authentication;
use Ninja\DatabaseTable;
use Ninja\NinjaException;

class QuizModel
{
    private $quiz_table;

    private $question_model;
    private $vocabulary_model;
    private $question_quiz_model;
    private $authentication_helper;
    private $media_model;
    private $user_quiz_model;

    function __construct(DatabaseTable $quiz_table, QuestionModel $question_model, QuestionQuizModel $question_quiz_model, Authentication $authentication_helper, VocabularyModel $vocabulary_model, MediaModel $media_model, UserQuizModel $user_quiz_model)
    {
        $this->quiz_table = $quiz_table;
        $this->question_model = $question_model;
        $this->question_quiz_model = $question_quiz_model;
        $this->authentication_helper = $authentication_helper;
        $this->vocabulary_model = $vocabulary_model;
        $this->media_model = $media_model;
        $this->user_quiz_model = $user_quiz_model;
    }

    function get_all($orderBy = null, $orderDirection = null, $limit = null, $offset = null)
    {
        $all = $this->quiz_table->findAll($orderBy, $orderDirection, $limit, $offset);

        $filter = [];
        foreach ($all as $item)
            if (is_null($item->{QuizEntity::KEY_RANDOM_AT}))
                $filter[] = $item;

        return $filter;
    }

    function get_all_include_random_quiz()
    {
        return $this->quiz_table->findAll();
    }

    function get_by_id($id)
    {
        return $this->quiz_table->findById($id);
    }

    function get_by_topic($topic_id, $limit = null, $offset = null): array
    {
        $quizzes = $this->get_all();

        $filtered = [];

        foreach ($quizzes as $quiz) {
            $topics = $quiz->get_topics();

            $topic_ids = array_map(function ($topic) {
                return $topic->id;
            }, $topics);

            if (in_array($topic_id, $topic_ids))
                $filtered[] = $quiz;
        }
        
        if (!is_null($limit) && !is_null($offset))
            return array_slice($filtered, $offset, count($filtered) > $limit ? $limit : count($filtered));

        return $filtered;
    }
    
    function find($column_name, $value)
    {
        return $this->quiz_table->find($column_name, $value);
    }

    /**
     * @throws NinjaException
     */
    function create_new_quiz($args)
    {
        if (is_null($args[QuizEntity::KEY_TITLE]))
            throw new NinjaException('Vui l??ng nh???p ti??u ?????');

        $args[QuizEntity::KEY_AUTHOR_ID] = $this->authentication_helper->getUserId();
        return $this->quiz_table->save($args);
    }

    /**
     * @throws NinjaException
     */
    function update_general_info($id, $args)
    {
        if (is_null($id))
            throw new NinjaException('M?? ?????nh danh b??i tr???c nghi???m kh??ng h???p l???');

        if (is_null($args[QuizEntity::KEY_TITLE]))
            throw new NinjaException('Vui l??ng nh???p ti??u ?????');

        $args[QuizEntity::KEY_ID] = $id;
        return $this->quiz_table->save($args);
    }

    /**
     * @throws NinjaException
     */
    function add_question($quiz_id, $question_id)
    {
        if (is_null($quiz_id))
            throw new NinjaException('M?? ?????nh danh b??i tr???c nghi???m kh??ng h???p l???');

        if (is_null($question_id))
            throw new NinjaException('M?? ?????nh danh c??u h???i kh??ng h???p l???');

        $questions = $this->question_quiz_model->get_questions_by_quiz_id($quiz_id);

        $existing = false;
        foreach ($questions as $question) {
            if ($question->id == $question_id) {
                $existing = true;
                break;
            }
        }

        if ($existing) return null;

        // TODO: add MySQL trigger for automating increase question_quantity in question table
        return $this->question_quiz_model->create_new_connection($question_id, $quiz_id);
    }

    /**
     * Generate quiz from the question bank
     * @param int $quantity number of questions of the quiz
     * @param array $topics array of question topics
     * @param array $types array of question types
     * @throws NinjaException
     */
    public function generate_from_question_bank(string $title, int $quantity, array $topics, array $types, bool $is_random = false, $author_id = null)
    {
        if (empty($title))
            throw new NinjaException('Nh???p ti??u ????? cho b??i ki???m tra');

        if ($quantity <= 0)
            throw new NinjaException('S??? l?????ng c??u h???i kh??ng h???p l???');

        if (count($types) == 0)
            throw new NinjaException('Vui l??ng ch???n lo???i c??u h???i');

        if (count($topics) == 0)
            throw new NinjaException('Vui l??ng ch???n ch??? ????? c???a c??u h???i');

        $questions = [];

        $total = 0;
        foreach ($topics as $topic_id) {
            if (!array_key_exists($topic_id, $questions))
                $questions[$topic_id] = [];

            $results = $this->question_model->get_by_topic($topic_id);
            foreach ($types as $type_id) {
                $questions[$topic_id][$type_id] = $this->filter_by_type($results, $type_id);

                $total += count($questions[$topic_id][$type_id]) ?? 0;
            }
        }

        if ($total < $quantity)
            throw new NinjaException('S??? l?????ng c??u h???i trong ng??n h??ng c??u h???i kh??ng ?????');

        $results = [];

        while (true) {
            foreach ($topics as $topic_id) {
                foreach ($types as $type) {
                    $question = $this->get_random_question_by_topic_and_type($questions, $topic_id, $type);
                    if (is_null($question)) continue;

                    $results[$question->id] = $question;
                }
            }

            if (count(array_keys($results)) >= $quantity)
                break;
        }

        $topic_titles = [];
        foreach ($results as $question) {
            $topic_entity = $question->get_topic() ?? null;
            if (!$topic_entity) continue;

            $topic_titles[$question->topic_id] = $topic_entity->{TopicEntity::KEY_TITLE};
        }

        $medias = $this->media_model->get_all_media();
        $media_id = null;

        $random_index = null;
        if (count($medias) > 0)
            $random_index = array_rand($medias) ?? null;

        if (!is_null($random_index))
            $media_id = $medias[$random_index]->id;

        $quiz_descriptions = [];
        $quiz_descriptions[] = '<strong>Ti??u ?????</strong>: ' . $title;
        $quiz_descriptions[] = '<strong>Ch??? ?????</strong>: ' . implode(", ", $topic_titles);
        $quiz_descriptions[] = '<strong>S??? c??u h???i</strong>: ' . $quantity;

        $quiz_args = [
            QuizEntity::KEY_TITLE => $title,
            QuizEntity::KEY_DESCRIPTION => implode("<br>", $quiz_descriptions),
            QuizEntity::KEY_QUESTION_QUANTITY => $quantity,
            QuizEntity::KEY_RANDOM_AT => $is_random ? (new \DateTime()) : null,
            QuizEntity::KEY_MEDIA_ID => $media_id
        ];

        if ($author_id) {
            $quiz_args[QuizEntity::KEY_AUTHOR_ID] = $author_id;
        } else {
            $quiz_args[QuizEntity::KEY_AUTHOR_ID] = $this->authentication_helper->isLoggedIn() ? $this->authentication_helper->getUserId() : null;
        }

        $new_quiz = $this->quiz_table->save($quiz_args);

        foreach ($results as $question_id => $question) {
            $this->question_quiz_model->create_new_connection($question_id, $new_quiz->id);
        }

        return $new_quiz;
    }

    /**
     * @throws NinjaException
     */
    public function generate_from_vocabulary_bank(string $title, int $quantity, array $topics, array $types, bool $is_random = false, $author_id = null)
    {
        if (empty($title))
            throw new NinjaException('Nh???p ti??u ????? cho b??i ki???m tra');

        if ($quantity <= 0)
            throw new NinjaException('S??? l?????ng c??u h???i kh??ng h???p l???');

        if (count($types) == 0)
            throw new NinjaException('Vui l??ng ch???n lo???i c??u h???i');

        if (count($topics) == 0)
            throw new NinjaException('Vui l??ng ch???n ch??? ????? c???a c??u h???i');

        $number_of_anwser_per_question = 4;

        $vocabularies = $this->vocabulary_model->get_random_number_of_vocabularies($topics, $quantity * $number_of_anwser_per_question) ?? [];

        $real_number_of_question = floor(count($vocabularies) / $number_of_anwser_per_question);
        $total_of_vocabularies = count($vocabularies);

        if ($real_number_of_question < $quantity)
            throw new NinjaException('S??? l?????ng t??? v???ng kh??ng ????? ????? t???o b??i ??n t???p');

        $questions = [];

        for ($i = 0; $i < $total_of_vocabularies; $i += $number_of_anwser_per_question) {
            $question_args = [];
            $answers = [];
            $media_id = null;

            try {
                $correct_answer = random_int(0, $number_of_anwser_per_question - 1);
            } catch (\Exception $e) {
                $correct_answer = 0;
            }

            $v_topics = [];
            for ($j = 0; $j < $number_of_anwser_per_question; $j++) {
                $answers[] = $vocabularies[$i + $j]->vietnamese;

                if ($j == $correct_answer) {
                    $question_args[QuestionEntity::KEY_TITLE] = $vocabularies[$i + $j]->english;
                    $question_args[QuestionEntity::KEY_CORRECTS] = $vocabularies[$i + $j]->vietnamese;
                    $media_id = $vocabularies[$i + $j]->media_id ?? null;
                    $v_topics = $vocabularies[$i + $j]->get_topic_ids() ?? [];
                }
            }

            shuffle($answers);
            $question_args[QuestionEntity::KEY_ANSWERS] = implode("\n", $answers);
            $question_args[QuestionEntity::KEY_QUESTION_TYPE] = QuestionEntity::TYPE_TEXT_WITH_ONE_CORRECT;
            $question_args[QuestionEntity::KEY_TOPIC] = count($v_topics) > 0 ? $v_topics[0] : 12; 
            $question_args[QuestionEntity::KEY_RANDOM_AT] = new \DateTime();
            $question_args[QuestionEntity::KEY_MEDIA_ID] = $media_id;
            $new_question = $this->question_model->create_new_question($question_args);

            $questions[] = $new_question;
        }

        $quiz_descriptions = [];
        $quiz_descriptions[] = '<strong>Ti??u ?????</strong>: ' . $title;
        $quiz_descriptions[] = '<strong>Ch??? ?????</strong>: ??n t???p t??? v???ng';
        $quiz_descriptions[] = '<strong>S??? c??u h???i</strong>: ' . $quantity;
        
        $quiz_args = [
            QuizEntity::KEY_TITLE => $title,
            QuizEntity::KEY_DESCRIPTION => implode("<br>", $quiz_descriptions),
            QuizEntity::KEY_QUESTION_QUANTITY => $quantity,
            QuizEntity::KEY_AUTHOR_ID => $this->authentication_helper->isLoggedIn() ? $this->authentication_helper->getUserId() : null,
            QuizEntity::KEY_RANDOM_AT => $is_random ? (new \DateTime()) : null
        ];
        
        if (!empty($author_id))
            $quiz_args[QuizEntity::KEY_AUTHOR_ID] = $author_id;

        $new_quiz = $this->quiz_table->save($quiz_args);

        foreach ($questions as $question) {
            $this->question_quiz_model->create_new_connection($question->id, $new_quiz->id);
        }

        return $new_quiz;
    }

    private function filter_by_type(array $questions, $type): array
    {
        $filtered = [];

        foreach ($questions as $question) {
            if ($question->{QuestionEntity::KEY_QUESTION_TYPE} == $type)
                $filtered[] = $question;
        }

        return $filtered;
    }

    private function get_random_question_by_topic_and_type($aggretate, $topic, $type)
    {
        $questions = $aggretate[$topic][$type] ?? [];

        if (count($questions) == 0) return null;

        $idx = array_rand($questions, 1);
        return $questions[$idx];
    }

    public function clear()
    {
        $this->quiz_table->deleteAll();
    }

    /**
     * @throws NinjaException
     */
    public function process_exam($quiz_id, $user_answer_list = [], $user_id = null)
    {
        $quiz = $this->quiz_table->findById($quiz_id);
        if (!$quiz instanceof QuizEntity)
            throw new NinjaException('Kh??ng t??m th???y b??i tr???c nghi???m');

        $quiz_questions = $quiz->get_questions();

        $question_logs = [];
        $correct_count = 0;

        /* @var $question QuestionEntity */
        foreach ($quiz_questions as $question) {
            $question_logs[$question->id] = $question;

            if (!isset($user_answer_list[$question->id])) {
                $question->user_answers = '';
                continue;
            }

            $correct_answers = $question->get_correct_answers();
            $user_answers = $user_answer_list[$question->id];

            if (json_encode($correct_answers) == json_encode($user_answers))
                $correct_count += 1;

            if (is_array($user_answers))
                $question->user_answers = implode("\n", $user_answers);
            else
                $question->user_answers = '';
        }

        $new_log_record = $this->user_quiz_model->create_new_connection($user_id, $quiz_id, [
            UserQuizEntity::CORRECT_QUANTITY => $correct_count,
            UserQuizEntity::FINISH_TIME => new \DateTime()
        ]);

        if (!$new_log_record instanceof UserQuizEntity) 
            throw new NinjaException('C?? l???i trong qu?? tr??nh l??u k???t qu??? b??i ki???m tra');
        
        return $new_log_record->add_history($question_logs, $correct_count);
    }
    
    public function get_statistic()
    {
        $number_of_quizzes = $this->quiz_table->total();

        $counter = 0;
        $page = 0;
        $limit = 1000;

        $statistic = [
            '1-5' => 0,
            '6-10' => 0,
            '11-15' => 0,
            '16-20' => 0,
            '21-30' => 0,
            '31-40' => 0,
            '41-50' => 0,
            '>50' => 0
        ];

        while (true) {
            $quiz_chunks = $this->quiz_table->findAll(null, null, $limit, $page * $limit);

            /** @var $quiz QuizEntity */
            foreach ($quiz_chunks as $quiz) {
                $questions = $quiz->get_questions() ?? [];
                $question_count = count($questions);
                
                if ($question_count < 6) {
                    $statistic['1-5'] += 1;
                }
                else if ($question_count < 11) {
                    $statistic['6-10'] += 1;
                }
                else if ($question_count < 16) {
                    $statistic['11-15'] += 1;
                }
                else if ($question_count < 21) {
                    $statistic['16-20'] += 1;
                }
                else if ($question_count < 31) {
                    $statistic['21-30'] += 1;
                }
                else if ($question_count < 41) {
                    $statistic['31-40'] += 1;
                }
                else {
                    $statistic['>50'] += 1;
                }
                
                $counter ++;
            }

            if ($counter >= $number_of_quizzes) break;

            $page += 1;
        }

        return $statistic;
    }
}
