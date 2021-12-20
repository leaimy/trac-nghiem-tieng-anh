<?php

namespace EStudy\Controller\Client;

use EStudy\Controller\EStudyBaseController;
use EStudy\Entity\Admin\QuizEntity;
use EStudy\Model\Admin\QuestionModel;
use EStudy\Model\Admin\QuizModel;
use EStudy\Model\Admin\TopicModel;
use EStudy\Model\Admin\VocabularyModel;

class HomeController extends EStudyBaseController
{
    private $topic_model;
    private $question_model;
    private $quiz_model;
    private $vocabulary_model;

    public function __construct(TopicModel $topic_model, QuizModel $quiz_model, QuestionModel $question_model, VocabularyModel $vocabulary_model)
    {
        parent::__construct();

        $this->topic_model = $topic_model;
        $this->quiz_model = $quiz_model;
        $this->question_model = $question_model;
        $this->vocabulary_model = $vocabulary_model;
    }

    public function index()
    {
        $topics = $this->topic_model->get_all_topic();
        $quizzes = $this->quiz_model->get_all(QuizEntity::KEY_CREATED_AT, 'desc', 12, 0);
        $types = $this->question_model->get_all_question_types();

        $page_number = $_GET['page'] ?? 1;
        $page_limit = $_GET['limit'] ?? 50;

        $keyword = $_GET['keyword'] ?? null;

        $vocabulary_all = $this->vocabulary_model->search_english($keyword, $page_limit, ($page_number - 1) * $page_limit);

        $this->view_handler->render('client/home.html.php', [
            'topics' => $topics,
            'quizzes' => $quizzes,
            'types' => $types,
            'vocabulary_all' => $vocabulary_all,
            'current_page' => $page_number,
            'limit' => $page_limit
        ]);
    }

    public function show_vocabulary()
    {
        $id = $_GET['id'];
        $vocabulary = $this->vocabulary_model->show_vocabulary($id);

        $this->view_handler->render('client/vocabulary/show_vocabulary.html.php',[
            'vocabulary' => $vocabulary
        ]);
    }
}
