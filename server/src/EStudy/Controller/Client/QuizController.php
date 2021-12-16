<?php

namespace EStudy\Controller\Client;

use EStudy\Model\Admin\QuizModel;
use Ninja\NJBaseController\NJBaseController;

class QuizController extends NJBaseController
{
    private $quiz_model;
    
    public function __construct(QuizModel $quiz_model)
    {
        $this->quiz_model = $quiz_model;
    }

    public function index()
    {
        $this->view_handler->render('client/quiz/index.html.php');
    }
    
    public function show_quizzes_by_topic()
    {
        $this->view_handler->render('client/quiz/index.html.php');
    }
    
    public function take_quiz()
    {
        $this->view_handler->render('client/quiz/take_quiz.html.php');
    }
}
