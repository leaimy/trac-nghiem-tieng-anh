<?php

namespace EStudy\Controller\Client;

use Ninja\NJBaseController\NJBaseController;

class QuizController extends NJBaseController
{
    public function take_quiz()
    {
        $this->view_handler->render('client/quiz/take_quiz.html.php');
    }
}
