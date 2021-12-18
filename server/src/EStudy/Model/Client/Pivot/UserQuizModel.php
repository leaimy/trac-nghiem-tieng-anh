<?php

namespace EStudy\Model\Client\Pivot;

use EStudy\Entity\Client\Pivot\UserQuizEntity;
use Ninja\DatabaseTable;

class UserQuizModel
{
    private $user_quiz_table;

    public function __construct(DatabaseTable $user_quiz_table)
    {
        $this->user_quiz_table = $user_quiz_table;
    }
    
    public function create_new_connection($user_id, $quiz_id, $args)
    {
        return $this->user_quiz_table->save([
            UserQuizEntity::KEY_USER_ID => $user_id,
            UserQuizEntity::KEY_QUIZ_ID => $quiz_id,
            UserQuizEntity::BEGIN_TIME => $args[UserQuizEntity::BEGIN_TIME] ?? null,
            UserQuizEntity::FINISH_TIME => $args[UserQuizEntity::FINISH_TIME] ?? null,
            UserQuizEntity::CORRECT_QUANTITY => $args[UserQuizEntity::CORRECT_QUANTITY]
        ]);
    }
    
    public function get_all()
    {
        return $this->user_quiz_table->findAll();
    }
}
