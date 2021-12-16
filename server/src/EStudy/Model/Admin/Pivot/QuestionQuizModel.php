<?php

namespace EStudy\Model\Admin\Pivot;

use EStudy\Entity\Admin\Pivot\QuestionQuizEntity;
use Ninja\DatabaseTable;

class QuestionQuizModel
{
    private $question_quiz_table;

    public function __construct(DatabaseTable $question_quiz_table)
    {
        $this->question_quiz_table = $question_quiz_table;
    }
    
    public function create_new_connection($question_id, $quiz_id)
    {
        return $this->question_quiz_table->save([
            QuestionQuizEntity::KEY_ID => null,
            QuestionQuizEntity::KEY_QUESTION_ID => $question_id,
            QuestionQuizEntity::KEY_QUIZ_ID => $quiz_id,
        ]);
    }
    
    public function get_questions_by_quiz_id($quiz_id): array
    {
        $pivots = $this->question_quiz_table->find(QuestionQuizEntity::KEY_QUIZ_ID, $quiz_id);
        
        $results = [];
        foreach ($pivots as $pivot) {
            $question_entity = $pivot->get_question() ?? null;
            if (!$question_entity) continue;
            
            $results[] = $question_entity;
        }
        
        return $results;
    }
    
    public function get_quizzes_by_question_id($question_id)
    {
        $pivots = $this->question_quiz_table->find(QuestionQuizEntity::KEY_QUESTION_ID, $question_id);

        $results = [];
        foreach ($pivots as $pivot) {
            $quiz_entity = $pivot->get_quiz() ?? null;
            if (!$quiz_entity) continue;

            $results[] = $quiz_entity;
        }

        return $results;
    }
}
