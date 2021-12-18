<?php

namespace EStudy\Entity\Admin;

use EStudy\Model\Client\Pivot\UserQuizModel;

class UserEntity
{
    const PRIMARY_KEY = 'id';
    const TABLE = 'user';
    const CLASS_NAME = '\\EStudy\\Entity\\Admin\\UserEntity';

    const GUEST = "GUEST";
    const ADMIN = "ADMIN";

    const KEY_ID = 'id';
    const KEY_USERNAME = 'username';
    const KEY_PASSWORD = 'password';
    const KEY_FULL_NAME = 'fullname';
    const KEY_EMAIL = 'email';
    const KEY_USER_TYPE = 'type';
    const KEY_CREATED_AT = 'created_at';

    public $id;
    public $username;
    public $password;
    public $fullname;
    public $email;
    public $user_type;
    public $created_at;

    private $user_quiz_entities;
    private $user_quiz_model;

    public function __construct(UserQuizModel $user_quiz_model)
    {
        $this->user_quiz_model = $user_quiz_model;
    }

    public function is_admin()
    {
        return $this->user_type == self::ADMIN;
    }

    public function is_guest()
    {
        return $this->user_type == self::GUEST;
    }

    public function get_completed_quizzes_logs()
    {
        if (!$this->user_quiz_entities)
            $this->user_quiz_entities = $this->user_quiz_model->get_all_completed_by_user($this->id);

        return $this->user_quiz_entities;
    }
    
    public function get_completed_quizzes_entities()
    {
        if (!$this->user_quiz_entities)
            $this->get_completed_quizzes_logs();

        $result = [];
        
        foreach ($this->user_quiz_entities as $log)
            $result[] = $log->get_quiz();
        
        return $result;
    }
}
