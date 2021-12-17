<?php

namespace EStudy\Entity\Client\Pivot;

use EStudy\Model\Admin\QuizModel;
use EStudy\Model\Admin\UserModel;

class UserQuiz
{
    const PRIMARY_KEY = 'id';
    const TABLE = 'user_quiz';
    const CLASS_NAME = '\\EStudy\\Entity\\Client\\Pivot\\UserQuiz';

    const KEY_ID = 'id';
    const KEY_USER_ID = 'user_id';
    const KEY_QUIZ_ID = 'quiz_id';
    const BEGIN_TIME = 'begin_time';
    const FINISH_TIME = 'finish_time';
    const CORRECT_QUANTITY = 'correct_quantity';
    const QUIZ_HISTORY_ID = 'quiz_history_id';
    const KEY_CREATED_AT = 'created_at';

    public $id;
    public $user_id;
    public $quiz_id;
    public $begin_time;
    public $finish_time;
    public $correct_quantity;
    public $quiz_history_id;
    public $created_at;
    
    private $user_entity;
    private $user_model;
    
    private $quiz_entity;
    private $quiz_model;
    
    private $history_entity;
    private $history_model;

    public function get_user()
    {
        return null;
    }
    
    public function get_quiz()
    {
        return null;
    }
    
    public function get_history()
    {
        return null;
    }
}
