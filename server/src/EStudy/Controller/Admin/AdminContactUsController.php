<?php

namespace EStudy\Controller\Admin;

use EStudy\Controller\EStudyBaseController;

class AdminContactUsController extends EStudyBaseController
{
    public function index()
    {
        $this->view_handler->render('admin/contact_us/index.html.php');
    }
}
