<?php

namespace EStudy\Controller\Admin;

use EStudy\Model\Client\Pivot\UserQuizModel;
use Ninja\NJBaseController\NJBaseController;

class AdminQuizHistoryController extends NJBaseController
{
    private $user_quiz_model;
    
    public function __construct(UserQuizModel $user_quiz_model)
    {
        parent::__construct();
        
        $this->user_quiz_model = $user_quiz_model;
    }

    public function index()
    {
        $histories = $this->user_quiz_model->get_all();
        $this->view_handler->render('admin/quiz_history/index.html.php', [
            'histories' => $histories,
            'current_page' => 1,
            'limit' => 50,
            'number_of_page' => 10
        ]);
    }
}
