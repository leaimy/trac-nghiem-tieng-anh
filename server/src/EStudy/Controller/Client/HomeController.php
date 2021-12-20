<?php

namespace EStudy\Controller\Client;

use EStudy\Controller\EStudyBaseController;
use EStudy\Entity\Admin\QuizEntity;
use EStudy\Model\Admin\QuestionModel;
use EStudy\Model\Admin\QuizModel;
use EStudy\Model\Admin\TopicModel;

class HomeController extends EStudyBaseController
{
    private $topic_model;
    private $question_model;
    private $quiz_model;
    
    public function __construct(TopicModel $topic_model, QuizModel $quiz_model, QuestionModel $question_model)
    {
        parent::__construct();
        
        $this->topic_model = $topic_model;
        $this->quiz_model = $quiz_model;
        $this->question_model = $question_model;
    }

    public function index()
    {
        $topics = $this->topic_model->get_all_topic();
        $quizzes = $this->quiz_model->get_all(QuizEntity::KEY_CREATED_AT, 'desc', 12, 0);
        $types = $this->question_model->get_all_question_types();
        
        $this->view_handler->render('client/home.html.php', [
            'topics' => $topics,
            'quizzes' => $quizzes,
            'types' => $types
        ]);
    }
}
