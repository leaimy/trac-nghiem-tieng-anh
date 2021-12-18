<?php

namespace EStudy\Controller\Admin;

use EStudy\Controller\EStudyBaseController;
use EStudy\Entity\Admin\VocabularyEntity;
use EStudy\Model\Admin\MediaModel;
use EStudy\Model\Admin\TopicModel;
use EStudy\Model\Admin\TopicVocabularyModel;
use EStudy\Model\Admin\VocabularyModel;
use Exception;
use Ninja\NinjaException;

class AdminVocabularyController extends EStudyBaseController
{
    private $vocabulary_model;
    private $topic_model;
    private $media_model;
    private $topic_vocabulary_model;

    public function __construct(VocabularyModel $vocabulary_model, MediaModel $media_model, TopicVocabularyModel $topic_vocabulary_model, TopicModel  $topic_model)
    {
        parent::__construct();
        
        $this->vocabulary_model = $vocabulary_model;
        $this->media_model = $media_model;
        $this->topic_vocabulary_model = $topic_vocabulary_model;
        $this->topic_model = $topic_model;
    }

    public function index()
    {
        $page_number = $_GET['page'] ?? 1;
        $page_limit = $_GET['limit'] ?? 50;

        $total = $this->vocabulary_model->count();

        $number_of_page = floor($total / $page_limit);
        
        $vocabulary_all = $this->vocabulary_model->get_all_vocabulary(null, null, $page_limit, ($page_number - 1) * $page_limit);

        $this->view_handler->render('admin/vocabulary/index.html.php', [
            'vocabulary_all' => $vocabulary_all,
            'total' => $total,
            'number_of_page' => $number_of_page,
            'current_page' => $page_number,
            'limit' => $page_limit
        ]);
    }

    public function create()
    {
        $topic_all = $this->topic_model->get_all_topic();
        $this->view_handler->render('admin/vocabulary/create.html.php',[
            'topic_all' => $topic_all
        ]);
    }

    public function store()
    {
        try {
            $vocabulary = $_POST;

            if (isset($_FILES['file_upload'])) {
                $new_media = $this->media_model->create_new_media($_FILES);
                $media_id = $new_media->id;
                $vocabulary[VocabularyEntity::KEY_MEDIA_ID] = $media_id;
            }

            $new_vocabulary = $this->vocabulary_model->create_new_vocabulary($vocabulary);
            $vocabulary_id = $new_vocabulary->id;
            
            foreach ($_POST['topic_ids'] as $topic_id) {
                $this->topic_vocabulary_model->add_connection($topic_id, $vocabulary_id);
            }

            $this->route_redirect('/admin/vocabularies');
        } catch (NinjaException $e) {
            // Xử lý lỗi do mình tự ném ra

            $this->view_handler->render('admin/vocabularies/create.html.php', [
                'english' => $_POST['english'] ?? null,
                'vietnamese' => $_POST['vietnamese'] ?? null,
                'description' => $_POST['description'] ?? null,
                'error' => true,
                'message' => $e->getMessage(),
            ]);
        } catch (Exception $e) {
            // Xử lý lỗi từ hệ thống server / PHP
        }
    }
    
    public function edit()
    {
        $topic_all = $this->topic_model->get_all_topic();
        $id = $_GET['id'];
        $vocabulary = $this->vocabulary_model->get_by_id($id);
        
        $topic_ids = $vocabulary->get_topic_ids() ?? [];
        
        $this->view_handler->render('admin/vocabulary/edit.html.php', [
            'topic_all' => $topic_all,
            'vocabulary' => $vocabulary,
            'topic_ids' => $topic_ids
        ]);
    }
    
    public function update()
    {
        try {
            $vocabulary = $_POST;
            $id = $_POST['id'];

            if (!empty($_FILES['file_upload']['name'])) {
                // Người dùng cập nhật ảnh mới

                $new_media = $this->media_model->create_new_media($_FILES);
                $media_id = $new_media->id;
                $vocabulary[VocabularyEntity::KEY_MEDIA_ID] = $media_id;
                $this->vocabulary_model->update_vocabulary($id, $vocabulary);
            } else {
                // Người dùng chỉ cập nhật thông tin cơ bản
                $this->vocabulary_model->update_vocabulary($id, $vocabulary);
            }
            
            $this->topic_vocabulary_model->clear_all_connections($id);

            foreach ($_POST['topic_ids'] as $topic_id) {
                $this->topic_vocabulary_model->add_connection($topic_id, $id);
            }

            $this->route_redirect('/admin/vocabularies');
        } catch (NinjaException $e) {
            // Xử lý lỗi do mình tự ném ra

            $this->view_handler->render('admin/vocabulary/edit.html.php', [
                'english' => $_POST['english'] ?? null,
                'vietnamese' => $_POST['vietnamese'] ?? null,
                'description' => $_POST['description'] ?? null,
                'error' => true,
                'message' => $e->getMessage(),
            ]);
        } catch (Exception $e) {
            // Xử lý lỗi từ hệ thống server / PHP
        }
    }
}
