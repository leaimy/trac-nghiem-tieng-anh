<?php

namespace EStudy\Controller\Client;

use EStudy\Controller\EStudyBaseController;
use EStudy\Entity\Admin\QuestionEntity;
use EStudy\Entity\Client\Pivot\UserQuizEntity;
use EStudy\Model\Admin\QuestionModel;
use EStudy\Model\Admin\QuizModel;
use EStudy\Model\Admin\TopicModel;
use EStudy\Model\Client\Pivot\UserQuizModel;
use EStudy\Model\Client\QuizHistoryModel;
use EStudy\Utils\QuestionRenderHelper;
use Ninja\Authentication;
use Ninja\NinjaException;

class QuizController extends EStudyBaseController
{
    private $quiz_model;
    private $topic_model;
    private $question_model;

    private $user_quiz_model;
    private $quiz_history_model;

    private $authentication_helper;

    public function __construct(QuizModel $quiz_model, TopicModel $topic_model, QuestionModel $question_model, UserQuizModel $user_quiz_model, QuizHistoryModel $quiz_history_model, Authentication $authentication_helper)
    {
        parent::__construct();

        $this->quiz_model = $quiz_model;
        $this->topic_model = $topic_model;
        $this->question_model = $question_model;
        $this->user_quiz_model = $user_quiz_model;
        $this->quiz_history_model = $quiz_history_model;

        $this->authentication_helper = $authentication_helper;
    }

    public function index()
    {
        $quizzes = $this->quiz_model->get_all();

        $this->view_handler->render('client/quiz/index.html.php', [
            'quizzes' => $quizzes,
            'topic' => null
        ]);
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
        } catch (NinjaException $exception) {
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
            if (!$quiz)
                throw new NinjaException('Bài trắc nghiệm không tồn tại', 404);

            $questions = $quiz->get_questions();

            $this->view_handler->render('client/quiz/take_quiz.html.php', [
                'quiz_id' => $quiz->id,
                'questions' => $questions,
                'question_render_helper' => new QuestionRenderHelper()
            ]);
        } catch (NinjaException $exception) {
            if ($exception->get_status_code() == 404) {
                parent::handle_on_page_not_found([]);
                exit();
            }

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

            $user_id = null;
            if ($this->authentication_helper->isLoggedIn())
                $user_id = $this->authentication_helper->getUserId();

            $answers_with_one_correct = $_POST['answers-' . QuestionEntity::TYPE_TEXT_WITH_ONE_CORRECT] ?? [];
            $now = new \DateTime();

            $correct_count = 0;
            $questions = [];

            foreach ($answers_with_one_correct as $question_id => $answers) {
                $question = $this->question_model->get_by_id($question_id);
                $corrects = $question->get_correct_answers();
                $question->user_answers = count($answers) > 0 ? implode("\n", $answers) : '';

                if (json_encode($corrects) == json_encode($answers)) {
                    $correct_count++;
                }

                $questions[] = $question;
            }

            $new_record = $this->user_quiz_model->create_new_connection($user_id, $quiz_id, [
                UserQuizEntity::CORRECT_QUANTITY => $correct_count,
                UserQuizEntity::FINISH_TIME => $now
            ]);

            $history = $new_record->add_history($questions, $correct_count);

            $this->route_redirect('/quizzes/histories/show?quiz_history_id=' . $history->id);
        } catch (NinjaException $exception) {
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
                'question_render_helper' => new QuestionRenderHelper(),
                'absolutely_correct' => $content['quiz']['result']['correct'] == $content['quiz']['result']['total']
            ]);
        } catch (NinjaException $exception) {
            // TODO: Handle show quiz history detail
            die('Handle show quiz history detail');
        }
    }

    public function generate_random_quiz()
    {
        try {
            $topic_ids = $_POST['topics'] ?? [];
            $types = $_POST['types'] ?? [];
            $question_quantity = $_POST['question_quantity'];

            if (count($topic_ids) == 0)
                throw new NinjaException('Vui lòng chọn chủ đề');

            if (count($types) == 0)
                throw new NinjaException('Vui lòng chọn Loại câu hỏi');

            if ($question_quantity <= 0 || $question_quantity > 100)
                throw new NinjaException('Số lượng câu hỏi quá lớn');

            $title = 'Trắc nghiệm ngẫu nhiên: ' . (new \DateTime())->format('d-m-Y H:i:s');
            $new_quiz = $this->quiz_model->generate_from_question_bank($title, $question_quantity, $topic_ids, $types, true);

            $this->route_redirect('/quizzes/take-quiz?quiz_id=' . $new_quiz->id);
        } catch (NinjaException $exception) {
            // TODO: handle random quiz generation
            die($exception->getMessage());
        }
    }

    public function generate_practice_quiz()
    {
        try {
            $topic_id = $_POST['topic'] ?? null;
            if (is_null($topic_id))
                throw new NinjaException('Vui lòng chọn chủ đề');

            $quantity = $_POST['question_quantity'] ?? 0;
            if ($quantity <= 0 || $quantity > 100)
                throw new NinjaException('Số lượng câu hỏi không hợp lệ');

            $title = 'Ôn tập từ vựng: ' . (new \DateTime())->format('d-m-Y H:i:s');
            $quiz = $this->quiz_model->generate_from_vocabulary_bank($title, $quantity, [intval($topic_id)], [QuestionEntity::TYPE_TEXT_WITH_ONE_CORRECT], true, true);
            
            $this->route_redirect('/quizzes/take-quiz?quiz_id=' . $quiz->id);
        } catch (NinjaException $exception) {
            // TODO: handle practice quiz generation
            die($exception->getMessage());
        }
    }
}
