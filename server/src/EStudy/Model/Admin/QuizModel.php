<?php

namespace EStudy\Model\Admin;

use EStudy\Entity\Admin\QuestionEntity;
use EStudy\Entity\Admin\QuizEntity;
use EStudy\Entity\Admin\TopicEntity;
use EStudy\Entity\Admin\VocabularyEntity;
use EStudy\Model\Admin\Pivot\QuestionQuizModel;
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

    function __construct(DatabaseTable $quiz_table, QuestionModel $question_model, QuestionQuizModel $question_quiz_model, Authentication $authentication_helper, VocabularyModel $vocabulary_model, MediaModel $media_model)
    {
        $this->quiz_table = $quiz_table;
        $this->question_model = $question_model;
        $this->question_quiz_model = $question_quiz_model;
        $this->authentication_helper = $authentication_helper;
        $this->vocabulary_model = $vocabulary_model;
        $this->media_model = $media_model;
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
    
    function get_by_topic($topic_id): array
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
        
        return $filtered;
    }

    /**
     * @throws NinjaException
     */
    function create_new_quiz($args)
    {
        if (is_null($args[QuizEntity::KEY_TITLE]))
            throw new NinjaException('Vui lòng nhập tiêu đề');

        $args[QuizEntity::KEY_AUTHOR_ID] = $this->authentication_helper->getUserId();
        return $this->quiz_table->save($args);
    }

    /**
     * @throws NinjaException
     */
    function update_general_info($id, $args)
    {
        if (is_null($id))
            throw new NinjaException('Mã định danh bài trắc nghiệm không hợp lệ');

        if (is_null($args[QuizEntity::KEY_TITLE]))
            throw new NinjaException('Vui lòng nhập tiêu đề');

        $args[QuizEntity::KEY_ID] = $id;
        return $this->quiz_table->save($args);
    }

    /**
     * @throws NinjaException
     */
    function add_question($quiz_id, $question_id)
    {
        if (is_null($quiz_id))
            throw new NinjaException('Mã định danh bài trắc nghiệm không hợp lệ');
        
        if (is_null($question_id))
            throw new NinjaException('Mã định danh câu hỏi không hợp lệ');

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
    public function generate_from_question_bank(string $title, int $quantity, array $topics, array $types, bool $is_random = false)
    {
        if (empty($title))
            throw new NinjaException('Nhập tiêu đề cho bài kiểm tra');
        
        if ($quantity <= 0)
            throw new NinjaException('Số lượng câu hỏi không hợp lệ');

        if (count($types) == 0)
            throw new NinjaException('Vui lòng chọn loại câu hỏi');

        if (count($topics) == 0)
            throw new NinjaException('Vui lòng chọn chủ đề của câu hỏi');

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
            throw new NinjaException('Số lượng câu hỏi trong ngân hàng câu hỏi không đủ');

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
        $quiz_descriptions[] = '<strong>Tiêu đề</strong>: ' . $title;
        $quiz_descriptions[] = '<strong>Chủ đề</strong>: ' . implode(", ", $topic_titles);
        $quiz_descriptions[] = '<strong>Số câu hỏi</strong>: ' . $quantity;
        
        $new_quiz = $this->quiz_table->save([
            QuizEntity::KEY_TITLE => $title,
            QuizEntity::KEY_DESCRIPTION => implode("<br>", $quiz_descriptions),
            QuizEntity::KEY_QUESTION_QUANTITY => $quantity,
            QuizEntity::KEY_AUTHOR_ID => $this->authentication_helper->isLoggedIn() ? $this->authentication_helper->getUserId() : null,
            QuizEntity::KEY_RANDOM_AT => $is_random ? (new \DateTime()) : null,
            QuizEntity::KEY_MEDIA_ID => $media_id 
        ]);
        
        foreach ($results as $question_id => $question) {
            $this->question_quiz_model->create_new_connection($question_id, $new_quiz->id);
        }
        
        return $new_quiz;
    }

    /**
     * @throws NinjaException
     */
    public function generate_from_vocabulary_bank(string $title, int $quantity, array $topics, array $types, bool $is_random = false)
    {
        if (empty($title))
            throw new NinjaException('Nhập tiêu đề cho bài kiểm tra');

        if ($quantity <= 0)
            throw new NinjaException('Số lượng câu hỏi không hợp lệ');

        if (count($types) == 0)
            throw new NinjaException('Vui lòng chọn loại câu hỏi');

        if (count($topics) == 0)
            throw new NinjaException('Vui lòng chọn chủ đề của câu hỏi');

        $number_of_anwser_per_question = 4;

        $vocabularies = $this->vocabulary_model->get_random_number_of_vocabularies($topics, $quantity * $number_of_anwser_per_question) ?? [];
        
        $real_number_of_question = floor(count($vocabularies) / $number_of_anwser_per_question);
        $total_of_vocabularies = count($vocabularies);
        
        if ($real_number_of_question < $quantity)
            throw new NinjaException('Số lượng từ vựng không đủ để tạo bài ôn tập');

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

            for ($j = 0; $j < $number_of_anwser_per_question; $j++) {
                $answers[] = $vocabularies[$i + $j]->vietnamese;
                
                if ($j == $correct_answer) {
                    $question_args[QuestionEntity::KEY_TITLE] = $vocabularies[$i + $j]->english;
                    $question_args[QuestionEntity::KEY_CORRECTS] = $vocabularies[$i + $j]->vietnamese;
                    $media_id = $vocabularies[$i + $j]->media_id ?? null;
                }
            }
            
            shuffle($answers);
            $question_args[QuestionEntity::KEY_ANSWERS] = implode("\n", $answers);
            $question_args[QuestionEntity::KEY_QUESTION_TYPE] = QuestionEntity::TYPE_TEXT_WITH_ONE_CORRECT;
            $question_args[QuestionEntity::KEY_TOPIC] = 14; // TODO: Topic ID for ôn tập từ vựng
            $question_args[QuestionEntity::KEY_RANDOM_AT] = new \DateTime();
            $question_args[QuestionEntity::KEY_MEDIA_ID] = $media_id;
            $new_question = $this->question_model->create_new_question($question_args);
            
            $questions[] = $new_question;
        }
        
        $quiz_descriptions = [];
        $quiz_descriptions[] = '<strong>Tiêu đề</strong>: ' . $title;
        $quiz_descriptions[] = '<strong>Chủ đề</strong>: ôn tập từ vựng' ;
        $quiz_descriptions[] = '<strong>Số câu hỏi</strong>: ' . $quantity;

        $new_quiz = $this->quiz_table->save([
            QuizEntity::KEY_TITLE => $title,
            QuizEntity::KEY_DESCRIPTION => implode("<br>", $quiz_descriptions),
            QuizEntity::KEY_QUESTION_QUANTITY => $quantity,
            QuizEntity::KEY_AUTHOR_ID => $this->authentication_helper->isLoggedIn() ? $this->authentication_helper->getUserId() : null,
            QuizEntity::KEY_RANDOM_AT => $is_random ? (new \DateTime()) : null
        ]);

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
}
