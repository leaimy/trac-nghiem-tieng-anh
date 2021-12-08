<?php

namespace EStudy\Controller\Admin;

use Ninja\NJBaseController\NJBaseController;

class AdminQuizController extends NJBaseController
{
    public function index()
    {
        $this->view_handler->render('admin/quiz/index.html.php');
    }
}
