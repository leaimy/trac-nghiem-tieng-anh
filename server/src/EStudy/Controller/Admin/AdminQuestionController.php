<?php

namespace EStudy\Controller\Admin;

use EStudy\Model\Admin\QuestionModel;
use Ninja\NJBaseController\NJBaseController;

class AdminQuestionController extends NJBaseController
{
    private $question_model;
    
    public function __construct(QuestionModel $question_model)
    {
        parent::__construct();
        $this->question_model = $question_model;
    }

    public function index()
    {
        $all_questions = $this->question_model->get_all_questions();
        $this->view_handler->render('admin/question/index.html.php', [
            'all_questions' => $all_questions
        ]);
    }
    
    public function create()
    {
        $question_types = $this->question_model->get_all_question_types();
        $topics = [
            0 => 'Xã hội',
            1 => 'Trường học',
            2 => 'Văn phòng',
            3 => 'Công sở',
            4 => 'Nhà ăn',
        ];
        
        $this->view_handler->render('admin/question/create.html.php', [
            'question_types' => $question_types,
            'topics' => $topics,
        ]);
    }
}
