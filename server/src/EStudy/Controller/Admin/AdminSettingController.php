<?php

namespace EStudy\Controller\Admin;

use EStudy\Controller\EStudyBaseController;

class AdminSettingController extends EStudyBaseController
{
    public function index()
    {
        $this->view_handler->render('admin/setting/index.html.php');
    }
}
