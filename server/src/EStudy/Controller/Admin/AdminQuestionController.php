<?php

namespace EStudy\Controller\Admin;

use EStudy\Controller\EStudyBaseController;
use EStudy\Entity\Admin\QuestionEntity;
use EStudy\Model\Admin\MediaModel;
use EStudy\Model\Admin\QuestionModel;
use EStudy\Model\Admin\TopicModel;
use Ninja\NinjaException;

class AdminQuestionController extends EStudyBaseController
{
    private $question_model;
    private $topic_model;
    private $media_model;
    
    public function __construct(QuestionModel $question_model, TopicModel $topic_model, MediaModel $media_model)
    {
        parent::__construct();
        
        $this->question_model = $question_model;
        $this->topic_model = $topic_model;
        $this->media_model = $media_model;
    }

    public function index()
    {
        $page_number = $_GET['page'] ?? 1;
        $page_limit = $_GET['limit'] ?? 50;
        
        $all_questions = $this->question_model->get_all_questions(null, null, $page_limit, ($page_number - 1) * $page_limit);
        $total = $this->question_model->count();
        
        $number_of_page = floor($total / $page_limit);
        
        $this->view_handler->render('admin/question/index.html.php', [
            'all_questions' => $all_questions,
            'total' => $total,
            'number_of_page' => $number_of_page,
            'current_page' => $page_number,
            'limit' => $page_limit,
        ]);
    }
    
    public function create()
    {
        $question_types = $this->question_model->get_all_question_types();
        $topics = $this->topic_model->get_all_topic();
        
        $this->view_handler->render('admin/question/create.html.php', [
            'question_types' => $question_types,
            'topics' => $topics,
        ]);
    }
    
    public function store()
    {
        try {
            $new_question = $_POST['question'] ?? null;
            if (is_null($new_question))
                throw new NinjaException('Vui lòng điền đủ thông tin của câu hỏi');

            if (!empty($_FILES['file_upload']['name'])) {
                $new_media = $this->media_model->create_new_media($_FILES);
                $media_id = $new_media->id;
                $new_question[QuestionEntity::KEY_MEDIA_ID] = $media_id;
            }
            
            $this->question_model->create_new_question($new_question);
            
            $this->route_redirect('/admin/questions');
        }
        catch (NinjaException $exception) {
            // TODO: Handle store new question exception
            die($exception->getMessage());
        }
    }

    public function edit()
    {
        $question_types = $this->question_model->get_all_question_types();
        $topics = $this->topic_model->get_all_topic();
        
        $entity = null;
        if (!is_null($_GET['id'] ?? null)) {
            $entity = $this->question_model->get_by_id($_GET['id']);
        }

        $this->view_handler->render('admin/question/edit.html.php', [
            'question_types' => $question_types,
            'topics' => $topics,
            'entity' => $entity
        ]);
    }

    public function update()
    {
        try {
            $updated_question = $_POST['question'] ?? null;
            if (is_null($updated_question))
                throw new NinjaException('Vui lòng điền đủ thông tin của câu hỏi');
            
            if (!empty($_FILES['file_upload']['name'])) {
                $new_media = $this->media_model->create_new_media($_FILES);
                $media_id = $new_media->id;
                $updated_question[QuestionEntity::KEY_MEDIA_ID] = $media_id;
                $this->question_model->update_question($updated_question['id'], $updated_question);
            }
            else {
                $this->question_model->update_question($updated_question['id'], $updated_question);
            }

            $this->route_redirect('/admin/questions');
        }
        catch (NinjaException $exception) {
            // TODO: Handle store new question exception
            die($exception->getMessage());
        }
    }
    
    public function show_statistic()
    {
        $statistic = $this->question_model->get_statistic();
        
        $statistic_by_topic = $statistic['by_topic'];
        $statistic_by_type = $statistic['by_type'];
        
        foreach ($statistic_by_type as $key => $value) {
            $statistic_by_type[QuestionEntity::get_type_text($key)] = $value;
            unset($statistic_by_type[$key]);
        }
        
        $this->view_handler->render('admin/question/statistic.html.php', [
            'statistic_by_topic' => $statistic_by_topic,
            'statistic_by_type' => $statistic_by_type
        ]);
    }
}
