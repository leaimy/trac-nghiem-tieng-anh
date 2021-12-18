<?php

namespace EStudy\Controller\Admin;

use EStudy\Entity\Admin\QuizEntity;
use EStudy\Model\Admin\QuestionModel;
use EStudy\Model\Admin\QuizModel;
use EStudy\Model\Admin\TopicModel;
use http\Exception\InvalidArgumentException;
use Ninja\NinjaException;
use Ninja\NJBaseController\NJBaseController;

class AdminQuizController extends NJBaseController
{
    private $quiz_model;
    private $question_model;
    private $topic_model;

    public function __construct(QuizModel $quiz_model, QuestionModel $question_model, TopicModel $topic_model)
    {
        parent::__construct();
        
        $this->quiz_model = $quiz_model;
        $this->question_model = $question_model;
        $this->topic_model = $topic_model;
    }

    public function index()
    {
        $question_types = $this->question_model->get_all_question_types();
        $topics = $this->topic_model->get_all_topic();
        $quizzes = $this->quiz_model->get_all();

        $this->view_handler->render('admin/quiz/index.html.php', [
            'question_types' => $question_types,
            'topics' => $topics,
            'quizzes' => $quizzes
        ]);
    }
    
    public function create()
    {
        $this->view_handler->render('admin/quiz/create.html.php', [
            'questions' => $this->question_model->get_all_questions()
        ]);
    }
    
    public function store()
    {
        try {
            $title = $_POST['title'] ?? null;
            $description = $_POST['description'] ?? '';
            $question_ids = $_POST['questions'] ?? [];
            
            $new_quiz = $this->quiz_model->create_new_quiz([
                QuizEntity::KEY_TITLE => $title,
                QuizEntity::KEY_DESCRIPTION => $description,
                QuizEntity::KEY_QUESTION_QUANTITY => count($question_ids),
            ]);
            
            foreach ($question_ids as $question_id) 
                $this->quiz_model->add_question($new_quiz->id, $question_id);
            
            $this->route_redirect('/admin/quiz');
        }
        catch (NinjaException $e) {
            // TODO: Handle quiz error page
            die($e->getMessage());
        }
    }
    
    public function edit()
    {
        try {
            $quiz_id = $_GET['id'] ?? null;
            
            if (is_null($quiz_id))
                throw new NinjaException('Mã định danh bài trắc nghiệm không hợp lệ');
            
            $quiz = $this->quiz_model->get_by_id($quiz_id);
            if (empty($quiz))
                throw new NinjaException('Không tìm thấy bài trắc nghiệm');
            
            $this->view_handler->render('admin/quiz/edit.html.php', [
                'quiz' => $quiz,
                'questions' => $this->question_model->get_all_questions()
            ]);
        }
        catch (NinjaException $e) {
            // TODO: Handle quiz error page
            die($e->getMessage());
        }
    }
    
    public function update()
    {
        try {
            $quiz_id = $_POST['id'] ?? null;
            $action = $_POST['action'] ?? null;
            
            if (is_null($action))
                throw new NinjaException('Hành động không hợp lệ');
            
            if ($action == 'update_general_info') {
                $this->update_general_info();
            }
            else if ($action == 'add_questions') {
                $this->add_more_question();
            }
            
            $this->route_redirect('/admin/quiz/edit?id=' . $quiz_id);
        }
        catch (NinjaException $e) {
            // TODO: Handle quiz error page
            die($e->getMessage());
        }
    }

    /**
     * @throws NinjaException
     */
    private function update_general_info()
    {
        $quiz_id = $_POST['id'] ?? null;
        $quiz_title = $_POST['title'] ?? null;
        $quiz_description = $_POST['description'] ?? '';
        
        $this->quiz_model->update_general_info($quiz_id, [
            QuizEntity::KEY_TITLE => $quiz_title,
            QuizEntity::KEY_DESCRIPTION => $quiz_description
        ]);
    }

    /**
     * @throws NinjaException
     */
    private function add_more_question()
    {
        $quiz_id = $_POST['id'] ?? null;
        $question_ids = $_POST['questions'] ?? [];
        
        if (count($question_ids) == 0)
            return;
        
        foreach ($question_ids as $question_id)
            $this->quiz_model->add_question($quiz_id, $question_id);
    }

    public function generate_from_question_bank()
    {
        try {
            $question_quantity = $_POST['question_quantity'] ?? 0;
            $question_types = $_POST['question_types'] ?? [];
            $question_topics = $_POST['question_topics'] ?? [];
            $quiz_title = $_POST['title'] ?? '';
            
            $this->quiz_model->generate_from_question_bank($quiz_title, $question_quantity, $question_topics, $question_types);
            
            $this->route_redirect('/admin/quiz');
        }
        catch (NinjaException $e) {
            // TODO: Handle error
            
            die($e->getMessage());
        }
    }
}
