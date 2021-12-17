<?php

namespace EStudy\Entity\Client;

class QuizHistory
{
    const PRIMARY_KEY = 'id';
    const TABLE = 'quiz_history';
    const CLASS_NAME = '\\EStudy\\Entity\\Client\\QuizHistory';

    const KEY_ID = 'id';
    const KEY_CONTENT = 'content';
    const KEY_CREATED_AT = 'created_at';

    public $id;
    public $content;
    public $created_at;
    
    public function get_content()
    {
        return unserialize($this->content);
    }
}
