<?php

namespace EStudy\Controller\Admin;

use Ninja\NJBaseController\NJBaseController;

class AdminAccountController extends NJBaseController
{
    public function index()
    {
        $this->view_handler->render('admin/admin_account/index.html.php');
    }
}
