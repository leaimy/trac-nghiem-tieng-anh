<?php

namespace EStudy\Controller\Admin;

use EStudy\Model\Admin\QuestionModel;
use http\Exception\InvalidArgumentException;
use Ninja\NinjaException;
use Ninja\NJBaseController\NJBaseController;

class AdminQuizController extends NJBaseController
{
    private $question_model;

    public function __construct(QuestionModel $question_model)
    {
        parent::__construct();
        $this->question_model = $question_model;
    }

    public function index()
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


        $this->view_handler->render('admin/quiz/index.html.php', [
            'question_types' => $question_types,
            'topics' => $topics,
        ]);
    }
    
    public function generate_from_question_bank()
    {
        try {
            $question_quantity = $_POST['question_quantity'] ?? 0;
            $question_types = $_POST['question_types'] ?? [];
            $question_topics = $_POST['question_topics'] ?? [];
            
            $this->question_model->generate_from_question_bank($question_quantity, $question_topics, $question_types);
        }
        catch (NinjaException $e) {
            // TODO: Handle error
        }
    }
}
