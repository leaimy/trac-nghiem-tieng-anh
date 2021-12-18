<?php

namespace EStudy\Controller\Client;

use EStudy\Entity\Admin\QuestionEntity;
use EStudy\Entity\Client\Pivot\UserQuizEntity;
use EStudy\Model\Admin\QuestionModel;
use EStudy\Model\Admin\QuizModel;
use EStudy\Model\Admin\TopicModel;
use EStudy\Model\Client\Pivot\UserQuizModel;
use EStudy\Model\Client\QuizHistoryModel;
use EStudy\Utils\QuestionRenderHelper;
use Ninja\NinjaException;
use Ninja\NJBaseController\NJBaseController;

class QuizController extends NJBaseController
{
    private $quiz_model;
    private $topic_model;
    private $question_model;
    
    private $user_quiz_model;
    private $quiz_history_model;
    
    public function __construct(QuizModel $quiz_model, TopicModel $topic_model, QuestionModel $question_model, UserQuizModel $user_quiz_model, QuizHistoryModel $quiz_history_model)
    {
        parent::__construct();
        
        $this->quiz_model = $quiz_model;
        $this->topic_model = $topic_model;
        $this->question_model = $question_model;
        $this->user_quiz_model = $user_quiz_model;
        $this->quiz_history_model = $quiz_history_model;
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
            $topic = $this->topic_model->get_by_id($topic_id);
            
            $this->view_handler->render('client/quiz/index.html.php', [
                'quizzes' => $quizzes,
                'topic' => $topic
            ]);
        }
        catch (NinjaException $exception) {
            $this->route_redirect('/quizzes');
        }
    }
    
    public function take_quiz()
    {
        try {
            $quiz_id = $_GET['quiz_id'] ?? null;
            if (is_null($quiz_id))
                throw new NinjaException('Mã định danh bài trắc nghiệm không hợp lệ');
            
            $quiz = $this->quiz_model->get_by_id($quiz_id);
            $questions = $quiz->get_questions();
            
            $this->view_handler->render('client/quiz/take_quiz.html.php', [
                'quiz_id' => $quiz->id,
                'questions' => $questions,
                'question_render_helper' => new QuestionRenderHelper()
            ]);
        }
        catch (NinjaException $exception) {
            $this->route_redirect('/quizzes');
        }
    }
    
    public function process_quiz()
    {
        try {
            $quiz_id = $_POST['quiz_id'] ?? null;
            if (is_null($quiz_id))
                throw new NinjaException('Bài trắc nghiệm không hợp lệ');
            
            $quiz = $this->quiz_model->get_by_id($quiz_id);
            if (empty($quiz))
                throw new NinjaException('Bài trắc nghiệm không tồn tại');
           
            // TODO: replace with logged in user
            $user_id = 1;
            
            $answers_with_one_correct = $_POST['answers-' . QuestionEntity::TYPE_TEXT_WITH_ONE_CORRECT] ?? [];
            $now = new \DateTime();
            
            $correct_count = 0;
            $questions = [];
            
            foreach ($answers_with_one_correct as $question_id => $answers) {
                $question = $this->question_model->get_by_id($question_id);
                $corrects = $question->get_correct_answers();
                $question->user_answers = count($answers) > 0 ? implode("\n", $answers) : '';
                
                if (json_encode($corrects) == json_encode($answers)) {
                    $correct_count ++;
                }
                
                $questions[] = $question;
            }
            
            $new_record = $this->user_quiz_model->create_new_connection($user_id, $quiz_id, [
                UserQuizEntity::CORRECT_QUANTITY => $correct_count,
                UserQuizEntity::FINISH_TIME => $now
            ]);
            
            $history = $new_record->add_history($questions, $correct_count);
            
            $this->route_redirect('/quizzes/histories/show?quiz_history_id=' . $history->id);
        }
        catch (NinjaException $exception) {
            // TODO: Handle process quiz error
            die($exception->getMessage());
        }
    }
    
    public function show_history()
    {
        try {
            $history_id = $_GET['quiz_history_id'] ?? null;
            if (is_null($history_id))
                throw new NinjaException('Không tìm thấy bài trắc nghiệm');
            
            $history = $this->quiz_history_model->get_by_id($history_id);
            $content = $history->get_content();
            
            $this->view_handler->render('client/quiz/history/show.html.php', [
                'quiz_info' => $content['quiz']['quiz_detail'],
                'quiz_result' => $content['quiz']['result'],
                'questions' => $content['questions'],
                'question_render_helper' => new QuestionRenderHelper()
            ]);
        }
        catch (NinjaException $exception) {
            // TODO: Handle show quiz history detail
            die('Handle show quiz history detail');
        }
    }
}
