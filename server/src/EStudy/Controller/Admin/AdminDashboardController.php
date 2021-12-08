<?php

namespace EStudy\Controller\Admin;

use Ninja\NJBaseController\NJBaseController;

class AdminDashboardController extends NJBaseController
{
    public function index()
    {
        $this->view_handler->render('admin/dashboard.html.php');
    }
}
