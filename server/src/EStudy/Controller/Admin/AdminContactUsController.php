<?php

namespace EStudy\Controller\Admin;

use Ninja\NJBaseController\NJBaseController;

class AdminContactUsController extends NJBaseController
{
    public function index()
    {
        $this->view_handler->render('admin/contact_us/index.html.php');
    }
}
