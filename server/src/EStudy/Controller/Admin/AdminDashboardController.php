<?php

namespace EStudy\Controller\Admin;

use EStudy\Controller\EStudyBaseController;

class AdminDashboardController extends EStudyBaseController
{
    public function index()
    {
        $this->view_handler->render('admin/dashboard.html.php');
    }
}
