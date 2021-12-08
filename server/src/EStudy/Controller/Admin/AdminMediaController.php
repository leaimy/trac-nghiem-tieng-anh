<?php

namespace EStudy\Controller\Admin;

use Ninja\NJBaseController\NJBaseController;

class AdminMediaController extends NJBaseController
{
    public function index()
    {
        $this->view_handler->render('admin/media/index.html.php');
    }
}
