<?php

namespace EStudy\Controller\Admin;

use EStudy\Controller\EStudyBaseController;

class AdminCustomerController extends EStudyBaseController
{
    public function index()
    {
        $this->view_handler->render('admin/customer/index.html.php');
    }
}
