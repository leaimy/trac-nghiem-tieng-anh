<?php

namespace EStudy\Controller\Admin;

use EStudy\Model\Admin\QuestionModel;
use Ninja\NinjaException;
use Ninja\NJBaseController\NJBaseController;

class AdminQuestionController extends NJBaseController
{
    private $question_model;
    
    public function __construct(QuestionModel $question_model)
    {
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
    
    public function store()
    {
        $data = $_POST['question'];
        try {
            $this->question_model->create_new_question($data);
            
            $this->route_redirect('/admin/questions');
        } catch (NinjaException $e) {
            // Handle error
        }
    }
}
