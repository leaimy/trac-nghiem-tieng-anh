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
        $page_number = $_GET['page'] ?? 1;
        $page_limit = $_GET['limit'] ?? 50;
        
        $all_questions = $this->question_model->get_all_questions(null, null, $page_limit, ($page_number - 1) * $page_limit);
        $total = $this->question_model->count();
        
        $number_of_page = floor($total / $page_limit);
        
        $this->view_handler->render('admin/question/index.html.php', [
            'all_questions' => $all_questions,
            'total' => $total,
            'number_of_page' => $number_of_page,
            'current_page' => $page_number,
            'limit' => $page_limit
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
            666 => 'Quizlet',
            777 => 'Tin học VP'
        ];
        
        $this->view_handler->render('admin/question/create.html.php', [
            'question_types' => $question_types,
            'topics' => $topics,
        ]);
    }

    public function edit()
    {
        $question_types = $this->question_model->get_all_question_types();
        $topics = [
            0 => 'Xã hội',
            1 => 'Trường học',
            2 => 'Văn phòng',
            3 => 'Công sở',
            4 => 'Nhà ăn',
            666 => 'Quizlet',
            777 => 'Tin học VP'
        ];
        
        $entity = null;
        if (!is_null($_GET['id'] ?? null)) {
            $entity = $this->question_model->get_by_id($_GET['id']);
        }

        $this->view_handler->render('admin/question/edit.html.php', [
            'question_types' => $question_types,
            'topics' => $topics,
            'entity' => $entity
        ]);
    }
}
