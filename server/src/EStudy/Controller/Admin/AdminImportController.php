<?php

namespace EStudy\Controller\Admin;

use EStudy\Controller\EStudyBaseController;
use EStudy\Entity\Admin\MediaEntity;
use EStudy\Entity\Admin\QuestionEntity;
use EStudy\Entity\Admin\VocabularyEntity;
use EStudy\Model\Admin\QuizModel;
use EStudy\Model\Import\QuestionBank\ICT;
use EStudy\Model\Import\QuestionBank\Quizlet;
use EStudy\Model\Import\Vocabulary\LacViet;
use EStudy\Model\Import\User\FullName;
use Ninja\DatabaseTable;
use Ninja\NinjaException;

class AdminImportController extends EStudyBaseController
{
    private $vocabulary_table;
    private $media_table;
    private $quiz_model;

    public function __construct(DatabaseTable $vocabulary_table, DatabaseTable $media_table, QuizModel $quiz_model)
    {
        parent::__construct();

        $this->vocabulary_table = $vocabulary_table;
        $this->media_table = $media_table;
        $this->quiz_model = $quiz_model;
    }

    public function index()
    {
        $this->view_handler->render('admin/import/index.html.php');
    }
    
    public function import_media()
    {
        $image_path = __DIR__ . '/../../../../sample_images';
        
        $files = array_diff(scandir($image_path), array('.', '..'));
        
        foreach ($files as $file) {
            $parts = explode(".", $file);
            
            if (count($parts) < 2)
                continue;
            
            $extension = $parts[count($parts) - 1];

            try {
                $bytes = random_bytes(20);
            } catch (\Exception $e) {
                $bytes = uniqid();
            }

            $random_name = bin2hex($bytes);
            
            $new_media = $this->media_table->save([
                MediaEntity::KEY_MEDIA_ORIGIN_NAME => $file,
                MediaEntity::KEY_MEDIA_PATH => '/uploads/' . $random_name . '.' . $extension
            ]);
           
            if ($new_media)
                copy($image_path . '/' . $file, ROOT_DIR . '/public/uploads/' . $random_name . '.' . $extension);
        }

        $this->route_redirect('/admin/import-sample-data');
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
        } else if (isset($_POST['en_1'])) {
            $instance->set_part('en_1');
        } else if (isset($_POST['en_2'])) {
            $instance->set_part('en_2');
        } else if (isset($_POST['en_3'])) {
            $instance->set_part('en_3');
        } else if (isset($_POST['en_4'])) {
            $instance->set_part('en_4');
        } else if (isset($_POST['vi_1'])) {
            $instance->set_part('vi_1');
        } else if (isset($_POST['vi_2'])) {
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

            $page += 1;
        }

        $this->route_redirect('/admin/import-sample-data');
    }

    public function generate_quiz_from_question_bank()
    {
        for ($i = 0; $i < 1000; $i++) {
            $title = 'Trắc nghiệm ngẫu nhiên: ' . '#' . uniqid();
            try {
                $question_quantity = random_int(5, 30);
            } catch (\Exception $e) {
                $question_quantity = 20;
            }

            try {
                $this->quiz_model->generate_from_question_bank($title, $question_quantity, [12], [QuestionEntity::TYPE_TEXT_WITH_ONE_CORRECT]);
            } catch (NinjaException $e) {
                continue;
            }
        }

        $this->route_redirect('/admin/import-sample-data');
    }

    public function generate_quiz_from_vocabulary_bank()
    {

    }
}
