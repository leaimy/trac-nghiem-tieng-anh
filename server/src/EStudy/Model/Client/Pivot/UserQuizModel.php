<?php

namespace EStudy\Model\Client\Pivot;

use EStudy\Entity\Client\Pivot\UserQuizEntity;
use Ninja\Authentication;
use Ninja\DatabaseTable;

class UserQuizModel
{
    private $user_quiz_table;
    private $authentication_helper;

    public function __construct(DatabaseTable $user_quiz_table, Authentication $authentication_helper)
    {
        $this->user_quiz_table = $user_quiz_table;
        $this->authentication_helper = $authentication_helper;
    }

    public function get_all_completed_by_user($user_id)
    {
        return $this->user_quiz_table->find(UserQuizEntity::KEY_USER_ID, $user_id);
    }

    public function create_new_connection($user_id, $quiz_id, $args)
    {
        if (!$this->authentication_helper->isLoggedIn())
            return $this->user_quiz_table->save([
                UserQuizEntity::KEY_USER_ID => null,
                UserQuizEntity::KEY_QUIZ_ID => $quiz_id,
                UserQuizEntity::BEGIN_TIME => $args[UserQuizEntity::BEGIN_TIME] ?? null,
                UserQuizEntity::FINISH_TIME => $args[UserQuizEntity::FINISH_TIME] ?? null,
                UserQuizEntity::CORRECT_QUANTITY => $args[UserQuizEntity::CORRECT_QUANTITY]
            ]);

        $existings = $this->user_quiz_table->find(UserQuizEntity::KEY_USER_ID, $user_id);
        foreach ($existings as $existing) {
            if ($existing->{UserQuizEntity::KEY_QUIZ_ID} == $quiz_id)
                return $existing;
        }

        return $this->user_quiz_table->save([
            UserQuizEntity::KEY_USER_ID => $user_id,
            UserQuizEntity::KEY_QUIZ_ID => $quiz_id,
            UserQuizEntity::BEGIN_TIME => $args[UserQuizEntity::BEGIN_TIME] ?? null,
            UserQuizEntity::FINISH_TIME => $args[UserQuizEntity::FINISH_TIME] ?? null,
            UserQuizEntity::CORRECT_QUANTITY => $args[UserQuizEntity::CORRECT_QUANTITY]
        ]);
    }

    public function get_all($orderBy = null, $orderDirection = null, $limit = null, $offset = null)
    {
        return $this->user_quiz_table->findAll($orderBy, $orderDirection, $limit, $offset);
    }
    
    public function count()
    {
        return $this->user_quiz_table->total();
    }

    public function update($id, $args)
    {
        $args[UserQuizEntity::KEY_ID] = $id;
        $this->user_quiz_table->save($args);
    }

    public function test_sql()
    {
        $sql = 'call AnalyseQuizzesQuantityByAuthor()';
        
        $query = $this->user_quiz_table->raw($sql);
        return $query->fetchObject();
    }

    public function clear()
    {
        $this->user_quiz_table->deleteAll();
    }
}
