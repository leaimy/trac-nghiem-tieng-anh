<?php

namespace EStudy\Controller\Admin;

use EStudy\Entity\Admin\TopicEntity;
use EStudy\Model\Admin\MediaModel;
use EStudy\Model\Admin\TopicModel;
use Exception;
use Ninja\NinjaException;
use Ninja\NJBaseController\NJBaseController;

class AdminTopicController extends NJBaseController
{
    private $topic_model;
    private $media_model;
    public function __construct(TopicModel $topic_model, MediaModel $media_model)
    {
        $this->topic_model= $topic_model;
        $this->media_model = $media_model;
    }
    public function index()
    {
        $topic_all = $this->topic_model->get_all_topic();
        $this->view_handler->render('admin/topic/index.html.php', [
            'topic_all' => $topic_all
        ]);
        
    }

    public function create()
    {
        $this->view_handler->render('admin/topic/create.html.php');
    }

    public function store()
    {
        try {
            $topic = $_POST;

            if (isset($_FILES['file_upload'])) {
               $new_media = $this->media_model->create_new_media($_FILES);
               $media_id = $new_media->id;
               $topic[TopicEntity::KEY_MEDIA_ID] = $media_id;
            }

            $this->topic_model->create_new_topic($topic);
    
            $this->route_redirect('/admin/topics');
        }
        catch (NinjaException $e) {
            // Xử lý lỗi do mình tự ném ra

            $this->view_handler->render('admin/topic/create.html.php', [
                'title' => $_POST['title'] ?? null,
                'description' => $_POST['description'] ?? null,
                'error' => true,
                'message' => $e->getMessage(),
            ]);
        }
        catch (Exception $e) {
            // Xử lý lỗi từ hệ thống server / PHP
        }
    }

    public function edit()
    {
        $id = $_GET['id'];
        $topic = $this->topic_model->get_by_id($id);

        $this->view_handler->render('admin/topic/edit.html.php', [
            'topic' => $topic
        ]);
    }

    public function update()
    {

    }
}
