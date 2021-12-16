<?php

namespace EStudy\Controller\Admin;

use EStudy\Model\Import\QuestionBank\ICT;
use EStudy\Model\Import\QuestionBank\Quizlet;
use Ninja\NJBaseController\NJBaseController;

class AdminImportController extends NJBaseController
{
    public function index()
    {
        $this->view_handler->render('admin/import/index.html.php');
    }
    
    public function import_ict()
    {
        $instance = new ICT();
        $instance->populate();
        
        $this->route_redirect('/admin/import-sample-data');
    }
    
    public function import_quizlet()
    {
        $instance = new Quizlet();
        $instance->populate();

        $this->route_redirect('/admin/import-sample-data');
    }
}
