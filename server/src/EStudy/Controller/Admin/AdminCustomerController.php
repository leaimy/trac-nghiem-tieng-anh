<?php

namespace EStudy\Controller\Admin;

use Ninja\NJBaseController\NJBaseController;

class AdminCustomerController extends NJBaseController
{
    public function index()
    {
        $this->view_handler->render('admin/customer/index.html.php');
    }
}
