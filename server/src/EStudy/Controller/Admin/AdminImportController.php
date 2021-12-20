<?php

namespace EStudy\Controller\Admin;

use EStudy\Controller\EStudyBaseController;
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
    private $quiz_model;

    public function __construct(DatabaseTable $vocabulary_table, QuizModel $quiz_model)
    {
        parent::__construct();

        $this->vocabulary_table = $vocabulary_table;
        $this->quiz_model = $quiz_model;
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
