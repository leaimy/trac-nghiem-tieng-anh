<?php

namespace EStudy\Api;

use EStudy\Entity\Admin\QuestionEntity;
use EStudy\Entity\Admin\QuizEntity;
use EStudy\Model\Admin\QuizModel;
use EStudy\Model\Admin\TopicModel;
use Ninja\NJTrait\Jsonable;

class QuizApi
{
    use Jsonable;
    
    private $topic_model;
    private $quiz_model;
    
    public function __construct(TopicModel $topic_model, QuizModel $quiz_model)
    {
        $this->topic_model = $topic_model;
        $this->quiz_model = $quiz_model;
    }

    public function get_all_quizzes_total()
    {
        $all_topics = $this->topic_model->get_all_topic();
        
        $results = [];
        
        foreach ($all_topics as $topic) {
            $quizzes = $this->quiz_model->get_by_topic($topic->id, 5, 0);
            $topic_bak = $topic->to_json();
            
            $quizzes_data = [];
            /* @var $quiz QuizEntity */
            foreach ($quizzes as $quiz) {
                $quiz_data = $quiz->to_json();
                
                $questions = $quiz->get_questions();
                
                $question_data = [];
                /* @var $question QuestionEntity */
                foreach ($questions as $question) {
                    $question_data[] = $question->to_json_for_mobile();
                }
                
                $quiz_data['questions'] = $question_data;
                $quizzes_data[] = $quiz_data;
            }
            
            $topic_bak['quizzes'] = $quizzes_data;
            $results[] = $topic_bak;
        }
        
        $this->response_json([
            'status' => 'success',
            'data' => $results
        ]);
    }
}
