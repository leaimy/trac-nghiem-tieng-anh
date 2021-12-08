<?php

namespace EStudy\Controller\Admin;

use Ninja\NJBaseController\NJBaseController;

class AdminTopicController extends NJBaseController
{
    public function index()
    {
        $this->view_handler->render('admin/topic/index.html.php');
    }
}
