<?php

namespace EStudy\Controller\Admin;

use Ninja\NJBaseController\NJBaseController;

class AdminSettingController extends NJBaseController
{
    public function index()
    {
        $this->view_handler->render('admin/setting/index.html.php');
    }
}
