<?php

namespace EStudy\Controller\Admin;

use Ninja\NJBaseController\NJBaseController;

class AdminQuizHistoryController extends NJBaseController
{
    public function index()
    {
        $this->view_handler->render('admin/quiz_history/index.html.php');
    }
}
