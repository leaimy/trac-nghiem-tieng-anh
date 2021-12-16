<?php

namespace EStudy\Model\Admin;

use EStudy\Entity\Admin\QuestionEntity;
use EStudy\Entity\Admin\QuizEntity;
use EStudy\Entity\Admin\TopicEntity;
use EStudy\Model\Admin\Pivot\QuestionQuizModel;
use Ninja\DatabaseTable;
use Ninja\NinjaException;

class QuizModel
{
    private $quiz_table;

    private $question_model;
    private $question_quiz_model;

    function __construct(DatabaseTable $quiz_table, QuestionModel $question_model, QuestionQuizModel $question_quiz_model)
    {
        $this->quiz_table = $quiz_table;
        $this->question_model = $question_model;
        $this->question_quiz_model = $question_quiz_model;
    }
    
    function get_all()
    {
        return $this->quiz_table->findAll();
    }

    function get_by_id($id)
    {
        return $this->quiz_table->findById($id);
    }
    
    function update_general_info($id, $args)
    {
        $args[QuizEntity::KEY_ID] = $id;
        return $this->quiz_table->save($args);
    }
    
    function add_question($quiz_id, $question_id)
    {
        $questions = $this->question_quiz_model->get_questions_by_quiz_id($quiz_id);
        
        $existing = false;
        foreach ($questions as $question) {
            if ($question->id == $question_id) {
                $existing = true;
                break;
            }
        }
        
        if ($existing) return null;
        
        return $this->question_quiz_model->create_new_connection($question_id, $quiz_id);
    }
    
    /**
     * Generate quiz from the question bank
     * @param int $quantity number of questions of the quiz
     * @param array $topics array of question topics
     * @param array $types array of question types
     * @throws NinjaException
     */
    public function generate_from_question_bank(string $title, int $quantity, array $topics, array $types)
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
            
            $topic_titles[] = $topic_entity->{TopicEntity::KEY_TITLE}; 
        }
        
        $quiz_descriptions = [];
        $quiz_descriptions[] = '<strong>Tiêu đề</strong>: ' . $title;
        $quiz_descriptions[] = '<strong>Chủ đề</strong>: ' . implode(", ", $topic_titles);
        $quiz_descriptions[] = '<strong>Số câu hỏi</strong>: ' . $quantity;
        
        $new_quiz = $this->quiz_table->save([
            QuizEntity::KEY_TITLE => $title,
            QuizEntity::KEY_DESCRIPTION => implode("\n", $quiz_descriptions),
            QuizEntity::KEY_QUESTION_QUANTITY => $quantity,
            
            // TODO: Get logged in user id
            QuizEntity::KEY_AUTHOR_ID => 1, 
        ]);
        
        foreach ($results as $question_id => $question) {
            $this->question_quiz_model->create_new_connection($question_id, $new_quiz->id);
        }
        
        return $results;
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

        $idx = array_rand($questions, 1);
        return $questions[$idx];
    }
}
