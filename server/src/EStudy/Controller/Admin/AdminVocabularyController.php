<?php

namespace EStudy\Controller\Admin;

use EStudy\Entity\Admin\VocabularyEntity;
use EStudy\Model\Admin\MediaModel;
use EStudy\Model\Admin\VocabularyModel;
use Ninja\NinjaException;
use Ninja\NJBaseController\NJBaseController;

class AdminVocabularyController extends NJBaseController
{
    private $vocabulary_model;
    private $media_model;
    public function __construct(VocabularyModel $vocabulary_model, MediaModel $media_model)
    {
        $this->vocabulary_model = $vocabulary_model;
        $this->media_model = $media_model;
    }
    public function index()
    {
      $vocabulary_all = $this->vocabulary_model->get_all_vocabulary();
        $this->view_handler->render('admin/vocabulary/index.html.php',[
            'vocabulary_all' => $vocabulary_all
        ]);
    }
    
    public function create()
    {
        $this->view_handler->render('admin/vocabulary/create.html.php');
    }
    
    public  function  store()
    {
        try {
            $vocabulary = $_POST;

            if (isset($_FILES['file_upload'])) {
                $new_media = $this->media_model->create_new_media($_FILES);
                $media_id = $new_media->id;
                $vocabulary[VocabularyEntity::KEY_MEDIA_ID] = $media_id;
            }

            $this->vocabulary_model->create_new_vocabulary($vocabulary);

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
}
