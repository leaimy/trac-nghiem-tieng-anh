<?php

namespace EStudy\Controller\Admin;

use EStudy\Controller\EStudyBaseController;
use EStudy\Entity\Admin\MediaEntity;
use EStudy\Entity\Admin\QuestionEntity;
use EStudy\Entity\Admin\QuizEntity;
use EStudy\Entity\Admin\TopicEntity;
use EStudy\Entity\Admin\UserEntity;
use EStudy\Entity\Admin\VocabularyEntity;
use EStudy\Model\Admin\MediaModel;
use EStudy\Model\Admin\Pivot\QuestionQuizModel;
use EStudy\Model\Admin\QuestionModel;
use EStudy\Model\Admin\QuizModel;
use EStudy\Model\Admin\TopicModel;
use EStudy\Model\Admin\TopicVocabularyModel;
use EStudy\Model\Admin\UserModel;
use EStudy\Model\Admin\VocabularyModel;
use EStudy\Model\Client\Pivot\UserQuizModel;
use EStudy\Model\Client\QuizHistoryModel;
use EStudy\Model\Import\QuestionBank\ICT;
use EStudy\Model\Import\QuestionBank\Quizlet;
use EStudy\Model\Import\Vocabulary\LacViet;
use EStudy\Model\Import\User\FullName;
use Ninja\NinjaException;
use Ninja\NJTrait\Jsonable;

class AdminImportController extends EStudyBaseController
{
    use Jsonable;

    private $media_model;
    private $question_model;
    private $quiz_model;
    private $topic_model;
    private $pivot_topic_vocabulary_model;
    private $user_model;
    private $vocabulary_model;
    private $pivot_question_quiz_model;
    private $quiz_history_model;
    private $pivot_user_quiz_model;

    public function __construct(
        MediaModel           $media_model,
        QuestionModel        $question_model,
        QuizModel            $quiz_model,
        TopicModel           $topic_model,
        TopicVocabularyModel $pivot_topic_vocabulary_model,
        UserModel            $user_model,
        VocabularyModel      $vocabulary_model,
        QuestionQuizModel    $pivot_question_quiz_model,
        QuizHistoryModel     $quiz_history_model,
        UserQuizModel        $pivot_user_quiz_model
    )
    {
        parent::__construct();

        $this->media_model = $media_model;
        $this->question_model = $question_model;
        $this->quiz_model = $quiz_model;
        $this->topic_model = $topic_model;
        $this->pivot_topic_vocabulary_model = $pivot_topic_vocabulary_model;
        $this->user_model = $user_model;
        $this->vocabulary_model = $vocabulary_model;
        $this->pivot_question_quiz_model = $pivot_question_quiz_model;
        $this->quiz_history_model = $quiz_history_model;
        $this->pivot_user_quiz_model = $pivot_user_quiz_model;
    }


    public function index()
    {
        $this->view_handler->render('admin/import/index.html.php');
    }

    public function process_sample_data_request()
    {
        $valid_actions = [
            'import_sample_image',
            'delete_images_in_upload',
            'import_sample_topic',
            'attach_media_to_topic',
            'import_first_1000',
            'import_en_1',
            'import_en_2',
            'import_en_3',
            'import_en_4',
            'import_vi_1',
            'import_vi_2',
            'attach_vietnamese_meaning',
            'attach_media_to_vocabulary',
            'import_ict',
            'attach_media_to_ict',
            'import_quizlet',
            'attach_media_to_quizlet',
            'import_user_account',
            'gen_10_quizzes',
            'gen_1000_quizzes',
            'gen_1000_quizzes_from_questions',
            'gen_1000_quizzes_from_vocabularies',
            'delete_data'
        ];

        try {
            $action = $_GET['action'] ?? null;

            if (is_null($action))
                throw new NinjaException('Vui lòng chọn hành động');

            if (!in_array($action, $valid_actions))
                throw new NinjaException('Lựa chọn không hợp lệ');

            switch ($action) {
                case 'import_sample_image':
                    $this->import_sample_media();
                    break;

                case 'delete_images_in_upload':
                    $this->delete_image_in_upload_folder();
                    break;

                case 'import_sample_topic':
                    $this->import_sample_topic();
                    break;

                case 'attach_media_to_topic':
                    $this->attach_media_to_topic();
                    break;

                case 'import_first_1000':
                    $this->import_lacviet_vocabulary('en_0');
                    break;

                case 'import_en_1':
                    $this->import_lacviet_vocabulary('en_1');
                    break;

                case 'import_en_2':
                    $this->import_lacviet_vocabulary('en_2');
                    break;

                case 'import_en_3':
                    $this->import_lacviet_vocabulary('en_3');
                    break;

                case 'import_en_4':
                    $this->import_lacviet_vocabulary('en_4');
                    break;

                case 'import_vi_1':
                    $this->import_lacviet_vocabulary('vi_1');
                    break;

                case 'import_vi_2':
                    $this->import_lacviet_vocabulary('vi_2');
                    break;

                case 'attach_vietnamese_meaning':
                    $this->attach_simple_vietnamese();
                    break;

                case 'attach_media_to_vocabulary':
                    $this->attach_media_to_vocabulary();
                    break;

                case 'import_ict':
                    $this->import_ict();
                    break;

                case 'attach_media_to_ict':
                    $this->attach_media_to_ict();
                    break;

                case 'import_quizlet':
                    $this->import_quizlet();
                    break;

                case 'attach_media_to_quizlet':
                    $this->attach_media_to_quizlet();
                    break;

                case 'import_user_account':
                    $this->import_user_account();
                    break;

                case 'gen_10_quizzes':
                    $this->gen_quizzes_by_admin(10);
                    break;

                case 'gen_1000_quizzes':
                    $this->gen_quizzes_from_question_bank_by_random_user(1000);
                    break;

                case 'gen_1000_quizzes_from_questions':
                    $this->gen_random_quizzes_from_question_bank_by_random_user(1000);
                    break;

                case 'gen_1000_quizzes_from_vocabularies':
                    $this->gen_random_quizzes_from_vocabularies_by_random_user(1000);
                    break;

                case 'delete_data':
                    $this->delete_all_user_data();
                    break;

                default:
                    throw new NinjaException('Lựa chọn không hợp lệ');
            }

            $this->response_json([
                'status' => 'success',
                'data' => null
            ]);
        } catch (NinjaException $exception) {
            $this->response_json([
                'status' => 'fail',
                'data' => null,
                'message' => $exception->getMessage()
            ], 400);
        }
    }

    public function import_sample_media()
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

            $new_media = $this->media_model->create_new_media_with_out_upload([
                MediaEntity::KEY_MEDIA_ORIGIN_NAME => $file,
                MediaEntity::KEY_MEDIA_PATH => '/uploads/' . $random_name . '.' . $extension
            ]);

            if ($new_media)
                copy($image_path . '/' . $file, ROOT_DIR . '/public/uploads/' . $random_name . '.' . $extension);
        }
    }

    public function delete_image_in_upload_folder()
    {
        $files = glob(ROOT_DIR . '/public/uploads/*'); // get all file names
        foreach ($files as $file) { // iterate files
            if (is_file($file)) {
                unlink($file); // delete file
            }
        }
    }

    /**
     * @throws NinjaException
     */
    public function import_sample_topic()
    {
        $topics = [
            'danh từ',
            'động từ',
            'tính từ',
            'giới từ',
            'phó từ',
            'liên từ',
            'thán từ',
            'đại từ',
            'thành ngữ',
            'viết tắt',
            'hậu tố',
            'tổng hợp',
            'ict'
        ];

        foreach ($topics as $topic) {
            $this->topic_model->create_new_topic([
                TopicEntity::KEY_TITLE => $topic
            ]);
        }
    }

    /**
     * @throws NinjaException
     */
    public function attach_media_to_topic()
    {
        $medias = $this->media_model->get_all_media();

        if (count($medias) == 0)
            throw new NinjaException('Vui lòng nhập ảnh vào trước');

        $topics = $this->topic_model->get_all_topic();

        foreach ($topics as $topic) {
            $media_idx = array_rand($medias);

            $id = null;
            if (isset($medias[$media_idx]) && ($medias[$media_idx] instanceof MediaEntity))
                $id = $medias[$media_idx]->id;

            $this->topic_model->update_topic_with_custom_args($topic->id, [
                TopicEntity::KEY_MEDIA_ID => $id
            ]);
        }
    }

    public function import_quizlet()
    {
        $instance = new Quizlet();
        $instance->populate();
    }

    public function attach_media_to_quizlet()
    {
        $this->attach_media_to_questions();
    }

    public function import_ict()
    {
        $instance = new ICT();
        $instance->populate();
    }

    public function attach_media_to_ict()
    {
        $this->attach_media_to_questions();
    }

    public function import_user_account()
    {
        $instance = new FullName();
        $instance->populate();
    }

    public function import_lacviet_vocabulary($part)
    {
        $instance = new LacViet();
        $instance->set_part($part);

        $instance->populate();
    }

    public function attach_simple_vietnamese()
    {
        $total_vocabularies = $this->vocabulary_model->count();

        $counter = 0;
        $page = 0;
        while (true) {
            $vocabularies = $this->vocabulary_model->get_all_vocabulary(null, null, 1000, 1000 * $page);

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

                        $this->vocabulary_model->update_vocabulary_with_custom_args($vocabulary->id, [
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
    }

    public function attach_media_to_vocabulary()
    {
        try {
            $medias = $this->media_model->get_all_media();

            if (count($medias) == 0)
                throw new NinjaException('Chưa có ảnh nào trong CSDL, vui lòng chọn tính năng nhập ảnh trước');

            $total_vocabularies = $this->vocabulary_model->count();

            $counter = 0;
            $page = 0;
            while (true) {
                $vocabularies = $this->vocabulary_model->get_all_vocabulary(null, null, 1000, 1000 * $page);

                foreach ($vocabularies as $vocabulary) {
                    $counter += 1;

                    try {
                        $random_index = random_int(0, count($medias) - 1);
                    } catch (\Exception $e) {
                        $random_index = 0;
                    }

                    $this->vocabulary_model->update_vocabulary_with_custom_args($vocabulary->id, [
                        VocabularyEntity::KEY_MEDIA_ID => $medias[$random_index]->id,
                    ]);
                }

                if ($counter >= $total_vocabularies)
                    break;

                $page += 1;
            }
        } catch (NinjaException $exception) {
            die($exception->getMessage());
        }
    }

    public function attach_media_to_questions($topic_id = null)
    {
        try {
            $medias = $this->media_model->get_all_media();

            if (count($medias) == 0)
                throw new NinjaException('Chưa có ảnh nào trong CSDL, vui lòng chọn tính năng nhập ảnh trước');

            $questions = $this->question_model->get_all_questions();

            foreach ($questions as $question) {
                try {
                    $random_index = random_int(0, count($medias) - 1);
                } catch (\Exception $e) {
                    $random_index = 0;
                }

                if ($random_index % 3 == 0) {
                    $this->question_model->update_question($question->id, [
                        QuestionEntity::KEY_MEDIA_ID => $medias[$random_index]->id
                    ]);
                }
            }
        } catch (NinjaException $exception) {
            die($exception->getMessage());
        }
    }

    public function generate_quiz_from_question_bank()
    {
        for ($i = 0; $i < 100; $i++) {
            $title = 'Trắc nghiệm EStudy: ' . '#' . uniqid();

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

    public function gen_quizzes_by_admin($quantity)
    {
        for ($i = 0; $i < $quantity; $i++) {
            $title = "Trắc nghiệm EStudy: " . uniqid();

            try {
                $question_quantity = random_int(5, 30);
            } catch (\Exception $e) {
                $question_quantity = 20;
            }

            try {
                // Default topic ID = 12
                $this->quiz_model->generate_from_question_bank($title, $question_quantity, [12], [QuestionEntity::TYPE_TEXT_WITH_ONE_CORRECT]);
            } catch (NinjaException $e) {
                continue;
            }
        }
    }

    /**
     * @throws NinjaException
     */
    public function gen_quizzes_from_question_bank_by_random_user($quantity)
    {
        $users = $this->user_model->get_all_user();
        if (count($users) == 0)
            throw new NinjaException('Vui lòng nhập người dùng vào trước');

        $quizzes = $this->quiz_model->get_all();
        if (count($quizzes) == 0)
            throw new NinjaException('Vui lòng nhập bộ trắc nghiệm trước');

        for ($i = 0; $i < $quantity; $i++) {
            $random_index = array_rand($users);
            $random_user = $users[$random_index];

            if (!$random_user instanceof UserEntity) continue;

            $random_q = array_rand($quizzes);
            $random_quiz = $quizzes[$random_q];

            if (!$random_quiz instanceof QuizEntity) continue;

            $user_answers_list = [];

            /* @var $question QuestionEntity */
            foreach ($random_quiz->get_questions() as $question) {
                $q_answers = $question->get_answers();

                try {
                    $r = random_int(0, count($q_answers) - 1);
                } catch (\Exception $e) {
                    $r = 0;
                }
                
                $user_answers_list[$question->id] = [$q_answers[$r]];
            }
            
            $this->quiz_model->process_exam($random_quiz->id, $user_answers_list, $random_user->id);
        }
    }

    public function gen_random_quizzes_from_question_bank_by_random_user($quantity)
    {

    }

    public function gen_random_quizzes_from_vocabularies_by_random_user($quantity)
    {

    }

    public function delete_all_user_data()
    {
        $this->media_model->clear();
        $this->question_model->clear();
        $this->quiz_model->clear();
        $this->topic_model->clear();
        $this->pivot_topic_vocabulary_model->clear();
        $this->user_model->clear();
        $this->vocabulary_model->clear();
        $this->pivot_question_quiz_model->clear();
        $this->quiz_history_model->clear();
        $this->pivot_user_quiz_model->clear();
    }
}
