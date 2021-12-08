<?php

namespace EStudy\Controller\Admin;

use Ninja\NJBaseController\NJBaseController;

class AdminVocabularyController extends NJBaseController
{
    public function index()
    {
        $this->view_handler->render('admin/vocabulary/index.html.php');
    }
}
