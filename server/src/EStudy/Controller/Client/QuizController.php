<?php

namespace EStudy\Controller\Client;

use EStudy\Model\Admin\QuizModel;
use Ninja\NinjaException;
use Ninja\NJBaseController\NJBaseController;

class QuizController extends NJBaseController
{
    private $quiz_model;
    
    public function __construct(QuizModel $quiz_model)
    {
        parent::__construct();
        
        $this->quiz_model = $quiz_model;
    }

    public function index()
    {
        $this->view_handler->render('client/quiz/index.html.php');
    }
    
    public function show_quizzes_by_topic()
    {
        try {
            $topic_id = $_GET['topic_id'] ?? null;
            
            if (is_null($topic_id))
                throw new NinjaException('Chủ đề không hợp lệ');
            
            $quizzes = $this->quiz_model->get_by_topic($topic_id);
            
            $this->view_handler->render('client/quiz/index.html.php', [
                'quizzes' => $quizzes
            ]);
        }
        catch (NinjaException $exception) {
            $this->route_redirect('/quizzes');
        }
    }
    
    public function take_quiz()
    {
        $this->view_handler->render('client/quiz/take_quiz.html.php');
    }
}
