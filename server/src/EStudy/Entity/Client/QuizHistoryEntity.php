<?php

namespace EStudy\Entity\Client;

use EStudy\Model\Admin\QuizModel;
use EStudy\Model\Admin\UserModel;

class QuizHistoryEntity
{
    const PRIMARY_KEY = 'id';
    const TABLE = 'quiz_history';
    const CLASS_NAME = '\\EStudy\\Entity\\Client\\QuizHistoryEntity';

    const KEY_ID = 'id';
    const KEY_CONTENT = 'content';
    const KEY_USER_QUIZ_ID = 'user_quiz_id';
    const KEY_CREATED_AT = 'created_at';

    public $id;
    public $content;
    public $user_quiz_id;
    public $created_at;
    
    public function get_content()
    {
        return unserialize($this->content);
    }
}
