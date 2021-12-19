<?php

namespace EStudy\Controller\Admin;

use EStudy\Controller\EStudyBaseController;
use EStudy\Entity\Admin\VocabularyEntity;
use EStudy\Model\Import\QuestionBank\ICT;
use EStudy\Model\Import\QuestionBank\Quizlet;
use EStudy\Model\Import\Vocabulary\LacViet;
use EStudy\Model\Import\User\FullName;
use Ninja\DatabaseTable;

class AdminImportController extends EStudyBaseController
{
    private $vocabulary_table;
    
    public function __construct(DatabaseTable $vocabulary_table)
    {
        parent::__construct();
        
        $this->vocabulary_table = $vocabulary_table;
    }

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
    
    public function attach_simple_vietnamese()
    {
        $total_vocabularies = $this->vocabulary_table->total();
        
        $counter = 0;
        $page = 0;
        while (true) {
            $vocabularies = $this->vocabulary_table->findAll(null, null, 1000, 1000 * $page);
            
            foreach ($vocabularies as $vocabulary) {
                $counter += 1;
                
                $parts = explode("\n", $vocabulary->description);
                foreach ($parts as $part) {
                    if (strpos(' ' . $part, "❏") > 0 || strpos(' ' . $part, "•") > 0) {
                        $position = strpos(' ' . $part, "❏");
                        
                        if ($position == 0)
                            $position = strpos(' ' . $part, "•");

                        $part = substr(' ' . $part, $position);
                        $part = str_replace("❏", "", $part);
                        $part = str_replace("•", "", $part);
                        $part = trim($part);
                        
                        $this->vocabulary_table->save([
                            VocabularyEntity::KEY_ID => $vocabulary->id,
                            VocabularyEntity::KEY_VIETNAMESE => $part
                        ]);
                        
                        break;
                    }
                }
            }
            
            if ($counter >= $total_vocabularies)
                break;
        }

        $this->route_redirect('/admin/import-sample-data');
    }
}
