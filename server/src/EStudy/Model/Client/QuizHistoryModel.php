<?php

namespace EStudy\Model\Client;

use EStudy\Entity\Client\QuizHistoryEntity;
use Ninja\DatabaseTable;

class QuizHistoryModel
{
    private $quiz_history_table;

    public function __construct(DatabaseTable $quiz_history_table)
    {
        $this->quiz_history_table = $quiz_history_table;
    }
    
    public function get_by_id($id)
    {
        return $this->quiz_history_table->findById($id);
    }
    
    public function add_history_log($quiz_id, $content)
    {
        $serialized = serialize($content);
        
        return $this->quiz_history_table->save([
            QuizHistoryEntity::KEY_USER_QUIZ_ID => $quiz_id,
            QuizHistoryEntity::KEY_CONTENT => $serialized
        ]);
    }
    
    public function get_histories_by_user_quiz_id($user_quiz_id)
    {
        return $this->quiz_history_table->find(QuizHistoryEntity::KEY_USER_QUIZ_ID, $user_quiz_id);
    }
}
