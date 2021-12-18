<?php

namespace EStudy\Controller\Client;

use EStudy\Model\Admin\QuizModel;
use EStudy\Model\Admin\TopicModel;
use Ninja\NJBaseController\NJBaseController;

class HomeController extends NJBaseController
{
    private $topic_model;
    private $quiz_model;
    
    public function __construct(TopicModel $topic_model, QuizModel $quiz_model)
    {
        parent::__construct();
        
        $this->topic_model = $topic_model;
        $this->quiz_model = $quiz_model;
    }

    public function index()
    {
        $topics = $this->topic_model->get_all_topic();
        $quizzes = $this->quiz_model->get_all();
        
        $this->view_handler->render('client/home.html.php', [
            'topics' => $topics,
            'quizzes' => $quizzes
        ]);
    }
}
