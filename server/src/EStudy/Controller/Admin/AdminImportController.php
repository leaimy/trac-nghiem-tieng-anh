<?php

namespace EStudy\Controller\Admin;

use EStudy\Model\Import\QuestionBank\ICT;
use EStudy\Model\Import\QuestionBank\Quizlet;
use EStudy\Model\Import\Vocabulary\LacViet;
use Ninja\NJBaseController\NJBaseController;
use EStudy\Model\Import\User\FullName;

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
    
    public function import_lacviet_vocabulary()
    {
        $instance = new LacViet();
        
        if (isset($_POST['en_0'])) {
            $instance->set_part('en_0');
        }
        else if (isset($_POST['en_1'])) {
            $instance->set_part('en_1');
        }
        else if (isset($_POST['en_2'])) {
            $instance->set_part('en_2');
        }
        else if (isset($_POST['en_3'])) {
            $instance->set_part('en_3');
        }
        else if (isset($_POST['en_4'])) {
            $instance->set_part('en_4');
        }
        else if (isset($_POST['vi_1'])) {
            $instance->set_part('vi_1');
        }
        else if (isset($_POST['vi_2'])) {
            $instance->set_part('vi_2');
        }
        
        $instance->populate();

        $this->route_redirect('/admin/import-sample-data');
    }
  
    public function import_fullname() 
    {
        $instance = new FullName();
        $instance->populate();

        $this->route_redirect('/admin/import-sample-data');
    }
}
