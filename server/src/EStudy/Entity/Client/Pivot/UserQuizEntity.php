<?php

namespace EStudy\Entity\Client\Pivot;

use EStudy\Entity\Admin\QuizEntity;
use EStudy\Entity\Admin\UserEntity;
use EStudy\Model\Admin\QuizModel;
use EStudy\Model\Admin\UserModel;
use EStudy\Model\Client\QuizHistoryModel;

class UserQuizEntity
{
    const PRIMARY_KEY = 'id';
    const TABLE = 'user_quiz';
    const CLASS_NAME = '\\EStudy\\Entity\\Client\\Pivot\\UserQuizEntity';

    const KEY_ID = 'id';
    const KEY_USER_ID = 'user_id';
    const KEY_QUIZ_ID = 'quiz_id';
    const BEGIN_TIME = 'begin_time';
    const FINISH_TIME = 'finish_time';
    const CORRECT_QUANTITY = 'correct_quantity';
    const KEY_CREATED_AT = 'created_at';

    public $id;
    public $user_id;
    public $quiz_id;
    public $begin_time;
    public $finish_time;
    public $correct_quantity;
    public $created_at;
    
    private $user_entity;
    private $user_model;
    
    private $quiz_entity;
    private $quiz_model;
    
    private $history_model;
    
    public function __construct(UserModel $user_model, QuizModel $quiz_model, QuizHistoryModel $history_model)
    {
        $this->user_model = $user_model;
        $this->quiz_model = $quiz_model;
        $this->history_model = $history_model;
    }

    public function get_user()
    {
        if (!$this->user_entity)
            $this->user_entity = $this->user_model->get_user_by_id($this->user_id);
        
        return $this->user_entity;
    }
    
    public function get_quiz()
    {
        if (!$this->quiz_entity)
            $this->quiz_entity = $this->quiz_model->get_by_id($this->quiz_id);
        
        return $this->quiz_entity;
    }
    
    public function add_history($question_entities)
    {
        $to_write = [];
        
        $quiz = $this->get_quiz();
        
        // TODO: write user information
         $user = $this->get_user();
        
        $to_write['quiz'] = [
            self::KEY_ID => $this->id,
            self::KEY_QUIZ_ID => $this->quiz_id,
            self::KEY_USER_ID => $this->user_id,
            self::KEY_CREATED_AT => ($this->created_at instanceof \DateTime) ? $this->created_at->format('Y-m-d H:i:s') : null,
            'quiz_detail' => [
                QuizEntity::KEY_ID => $quiz->id ?? null, // TODO: Check quiz id
                QuizEntity::KEY_MEDIA_ID => $quiz->{QuizEntity::KEY_MEDIA_ID} ?? null,
                QuizEntity::KEY_TITLE => $quiz->{QuizEntity::KEY_TITLE} ?? '',
                QuizEntity::KEY_DESCRIPTION => $quiz->{QuizEntity::KEY_DESCRIPTION} ?? '',
                QuizEntity::KEY_QUESTION_QUANTITY => $quiz->{QuizEntity::KEY_QUESTION_QUANTITY} ?? 0,
                QuizEntity::KEY_AUTHOR_ID => $quiz->{QuizEntity::KEY_AUTHOR_ID} ?? 1 // TODO: Check user id
            ],
            'user' => [
                UserEntity::KEY_ID => $user->{UserEntity::KEY_ID} ?? '',
                UserEntity::KEY_EMAIL => $user->{UserEntity::KEY_EMAIL} ?? '',
                UserEntity::KEY_USERNAME => $user->{UserEntity::KEY_USERNAME} ?? '',
                UserEntity::KEY_FULL_NAME => $user->{UserEntity::KEY_FULL_NAME}
            ],
            'result' => [
                'correct' => $this->correct_quantity ?? 0,
                'total' => $quiz->{QuizEntity::KEY_QUESTION_QUANTITY} ?? 0
            ]
        ];
        
        $to_write['questions'] = [];
        
        foreach ($question_entities as $question_entity)
            $to_write['questions'][] = $question_entity->to_json();
        
        return $this->history_model->add_history_log($this->id, $this->correct_quantity, $to_write);
    }
    
    public function get_histories()
    {
        return $this->history_model->get_histories_by_user_quiz_id($this->id);
    }
}
