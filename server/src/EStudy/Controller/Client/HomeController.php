<?php

namespace EStudy\Controller\Client;

use EStudy\Model\Admin\TopicModel;
use Ninja\NJBaseController\NJBaseController;

class HomeController extends NJBaseController
{
    private $topic_model;
    
    public function __construct(TopicModel $topic_model)
    {
        $this->topic_model = $topic_model;
    }

    public function index()
    {
        $topics = $this->topic_model->get_all_topic();
        
        $this->view_handler->render('client/home.html.php', [
            'topics' => $topics
        ]);
    }
}
