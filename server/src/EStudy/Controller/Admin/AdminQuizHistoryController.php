<?php

namespace EStudy\Controller\Admin;

use EStudy\Controller\EStudyBaseController;
use EStudy\Model\Client\Pivot\UserQuizModel;

class AdminQuizHistoryController extends EStudyBaseController
{
    private $user_quiz_model;
    
    public function __construct(UserQuizModel $user_quiz_model)
    {
        parent::__construct();
        
        $this->user_quiz_model = $user_quiz_model;
    }

    public function index()
    {
        $page_number = $_GET['page'] ?? 1;
        $page_limit = $_GET['limit'] ?? 50;

        $histories = $this->user_quiz_model->get_all(null, null, $page_limit, ($page_number - 1) * $page_limit);

        $total = $this->user_quiz_model->count();

        $number_of_page = floor($total / $page_limit);

        $this->view_handler->render('admin/quiz_history/index.html.php', [
            'histories' => $histories,
            'total' => $total,
            'number_of_page' => $number_of_page,
            'current_page' => $page_number,
            'limit' => $page_limit
        ]);
    }
    
    public function show_statistic()
    {
        $result = $this->user_quiz_model->test_sql();
        
        $this->view_handler->render('/admin/quiz_history/statistic.html.php', [
            'result' => $result
        ]);
    }
}
