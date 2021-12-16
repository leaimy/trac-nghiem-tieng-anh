<?php

namespace EStudy\Entity\Admin\Pivot;

use EStudy\Model\Admin\MediaModel;
use EStudy\Model\Admin\QuestionModel;
use EStudy\Model\Admin\QuizModel;
use EStudy\Model\Admin\UserModel;
use Ninja\Utils\NJStringUtils;

class QuestionQuizEntity
{
    const PRIMARY_KEY = 'id';
    const TABLE = 'question_quiz';
    const CLASS_NAME = '\\EStudy\\Entity\\Admin\\Pivot\\QuestionQuizEntity';

    const KEY_ID = 'id';
    const KEY_QUESTION_ID = 'question_id';
    const KEY_QUIZ_ID = 'quiz_id';
    const KEY_CREATED_AT = 'created_at';

    public $id;
    public $question_id;
    public $quiz_id;
    public $created_at;
    
    private $question_entity;
    private $question_model;
    
    private $quiz_entity;
    private $quiz_model;
    
    public function __construct(QuestionModel $question_model, QuizModel $quiz_model)
    {
        $this->question_model = $question_model;
        $this->quiz_model = $quiz_model;
    }

    function get_quiz()
    {
        if (!$this->quiz_entity)
            $this->quiz_entity = $this->quiz_model->get_by_id($this->quiz_id);
        
        return $this->quiz_entity;
    }
    
    function get_question()
    {
        if (!$this->question_entity)
            $this->question_entity = $this->question_model->get_by_id($this->question_id);

        return $this->question_entity;
    }
}
