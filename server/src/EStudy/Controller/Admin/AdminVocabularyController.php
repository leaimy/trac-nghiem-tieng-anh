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
        $vocabulary_all = $this->vocabulary_model->get_all_vocabulary(null, null, $page_limit, ($page_number - 1) * $page_limit);
        $parameters = '';
        
        $action = $_GET['action'] ?? null;
        
        if ($action == 'search') {
            $keyword = $_GET['keyword'] ?? null;
            
            if (!is_null($keyword)) {
                
                $search_by = $_GET['by'] ?? null;
                
                if ($search_by == 'english') {
                    $vocabulary_all = $this->vocabulary_model->search_english($keyword, $page_limit,($page_number - 1) * $page_limit);
                    $total = $this->vocabulary_model->search_english_get_total($keyword) ?? 0;
                    $parameters = 'action=search&by=english&keyword=' . $keyword;
                }
                else if ($search_by == 'vietnamese') {
                    $vocabulary_all = $this->vocabulary_model->fulltextsearch_vocabulary($keyword, $page_limit, ($page_number - 1) * $page_limit);
                    $total = $this->vocabulary_model->fulltextsearch_vocabulary_get_total($keyword) ?? 0;
                    $parameters = 'action=search&by=vietnamese&keyword=' . $keyword;
                }
            }
        }
        else if ($action == 'filter') {
            $filter_action = $_GET['by'] ?? null;

            if ($filter_action == 'topic') {
                $topic_id = $_GET['topic_id'] ?? null;

                if (!is_null($topic_id)) {
                    $vocabulary_all = $this->vocabulary_model->filter_by_topic($topic_id, $page_limit, ($page_number - 1) * $page_limit);
                    $total = $this->vocabulary_model->filter_by_topic_get_total($topic_id) ?? 0;
                    $parameters = 'action=filter&by=topic&topic_id=' . $topic_id;
                }
            }
            else if ($filter_action == 'first_character') {
                // Filter by first character
                $char = $_GET['first_character'] ?? null;
                
                if (!is_null($char)) {
                    $vocabulary_all = $this->vocabulary_model->filter_by_first_character($char, $page_limit, ($page_number - 1) * $page_limit);
                    $total = $this->vocabulary_model->filter_by_first_character_get_total($char) ?? 0;
                    $parameters = 'action=filter&by=first_character&first_character=' . $char;
                }
            }
        }
        
        $number_of_page = floor($total / $page_limit);
        
        $topic_all = $this->topic_model->get_all_topic();

        $this->view_handler->render('admin/vocabulary/index.html.php', [
            'vocabulary_all' => $vocabulary_all,
            'topic_all' => $topic_all,
            'total' => $total,
            'number_of_page' => $number_of_page,
            'current_page' => $page_number,
            'limit' => $page_limit,
            'parameters' => $parameters
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
    
    public function filter_by_topic()
    {
        try {
            $id = $_GET['topic_id'] ?? null;
            $topic_all = $this->topic_model->get_all_topic();

            if (is_null($id))
                throw new NinjaException('Vui lòng chọn chủ đề');

            // Trang hien tai la trang nao
            $current_page = $_GET['page'] ?? 1;
            
            // Moi trang co bao nhieu phan tu
            $limit = 50;
            
            // Tong so phan tu 
            $total = $this->vocabulary_model->filter_by_topic_get_total($id);
            
            $filter_vocabularies = $this->vocabulary_model->filter_by_topic($id, $limit, $limit * ($current_page - 1));
            
            $this->view_handler->render('admin/vocabulary/filter.html.php',[
                'filter_vocabularies' => $filter_vocabularies,
                'topic_all' => $topic_all,
                'number_of_page' => floor($total / $limit),
                'current_page' => $current_page,
                'filtered_topic_id' => $id,
                'limit' => $limit
            ]);
            
        } catch (NinjaException $e){
            die($e->getMessage());
        }
    }
}
