<?php

namespace EStudy\Controller\Admin;

use Ninja\NJBaseController\NJBaseController;

class AdminQuestionController extends NJBaseController
{
    public function index()
    {
        $this->view_handler->render('admin/question/index.html.php');
    }
    
    public function create()
    {
        $this->view_handler->render('admin/question/create.html.php');
    }
}
