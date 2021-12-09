<?php

namespace EStudy\Controller\Admin;

use EStudy\Model\Admin\TopicModel;
use Ninja\NinjaException;
use Ninja\NJBaseController\NJBaseController;

class AdminTopicController extends NJBaseController
{
    private $topic_model;
    public function __construct(TopicModel $topic_model)
    {
        $this->topic_model= $topic_model;
    }
    public function index()
    {
        $this->view_handler->render('admin/topic/index.html.php');
    }

    public function create()
    {
        $this->view_handler->render('admin/topic/create.html.php');
    }

    public function store()
    {
        try {
            $topic = $_POST;

            $this->topic_model->create_new_topic($topic);
    
            $this->route_redirect('/admin/topics');
        }
        catch (NinjaException $e) {
            // Xử lý lỗi

            $this->view_handler->render('admin/topic/create.html.php', [
                'title' => $_POST['title'] ?? null,
                'description' => $_POST['description'] ?? null,
                'error' => true,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
