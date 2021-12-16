<?php

namespace EStudy\Controller\Admin;

use EStudy\Model\Admin\QuestionModel;
use EStudy\Model\Admin\QuizModel;
use Ninja\NinjaException;
use Ninja\NJBaseController\NJBaseController;

class AdminQuizController extends NJBaseController
{
    private $quiz_model;
    private $question_model;

    public function __construct(QuizModel $quiz_model, QuestionModel $question_model)
    {
        parent::__construct();
        
        $this->quiz_model = $quiz_model;
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
        $quizzes = $this->quiz_model->get_all();

        $this->view_handler->render('admin/quiz/index.html.php', [
            'question_types' => $question_types,
            'topics' => $topics,
            'quizzes' => $quizzes
        ]);
    }
    
    public function generate_from_question_bank()
    {
        try {
            $question_quantity = $_POST['question_quantity'] ?? 0;
            $question_types = $_POST['question_types'] ?? [];
            $question_topics = $_POST['question_topics'] ?? [];
            $quiz_title = $_POST['title'] ?? '';
            
            $this->quiz_model->generate_from_question_bank($quiz_title, $question_quantity, $question_topics, $question_types);
            
            $this->route_redirect('/admin/quiz');
        }
        catch (NinjaException $e) {
            // TODO: Handle error
            
            die($e->getMessage());
        }
    }
}
