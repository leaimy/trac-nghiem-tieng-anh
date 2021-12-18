<?php

namespace EStudy\Entity\Admin;

use EStudy\Model\Admin\MediaModel;
use EStudy\Model\Admin\Pivot\QuestionQuizModel;
use EStudy\Model\Admin\QuestionModel;
use EStudy\Model\Admin\UserModel;
use Ninja\Utils\NJStringUtils;

class QuizEntity
{
    const PRIMARY_KEY = 'id';
    const TABLE = 'quiz';
    const CLASS_NAME = '\\EStudy\\Entity\\Admin\\QuizEntity';

    const KEY_ID = 'id';
    const KEY_TITLE = 'title';
    const KEY_QUESTION_QUANTITY = 'question_quantity';
    const KEY_MEDIA_ID = 'media_id';
    const KEY_DESCRIPTION = 'description';
    const KEY_AUTHOR_ID = 'author_id';
    const KEY_RANDOM_AT = 'random_at';
    const KEY_CREATED_AT = 'created_at';

    public $id;
    public $title;
    public $question_quantity;
    public $media_id;
    public $description;
    public $author_id;
    public $random_at;
    public $created_at;
    
    private $author_entity;
    private $author_model;
    
    private $media_entity;
    private $media_model;
    
    private $question_quiz_model;
    
    public function __construct(QuestionQuizModel $question_quiz_model, UserModel $user_model, MediaModel $media_model)
    {
        $this->question_quiz_model = $question_quiz_model;
        $this->author_model = $user_model;
        $this->media_model = $media_model;
    }

    function get_truncate_title(): string
    {
        return NJStringUtils::truncate($this->title, 50);
    }
    
    function get_truncate_description(): string
    {
        return NJStringUtils::truncate($this->description ?? '', 50);
    }
    
    function get_author()
    {
        if (!$this->author_entity)
            $this->author_entity = $this->author_model->get_user_by_id($this->author_id);
        
        return $this->author_entity;
    }
    
    function get_questions() : array
    {
        return $this->question_quiz_model->get_questions_by_quiz_id($this->id) ?? [];
    }

    function get_media()
    {
        if (is_null($this->media_id)) return null;
        
        if (!$this->media_entity) 
            $this->media_entity = $this->media_model->get_by_id($this->media_id);

        return $this->media_entity;
    }
    
    function get_topics(): array
    {
        $questions = $this->get_questions();
        
        $topics = [];
        
        foreach ($questions as $question) {
            if (!array_key_exists($question->topic_id, $topics))
                $topics[$question->topic_id]= $question->get_topic();
        }
        
        return $topics;
    }

    function get_topic_titles() : array
    {
        $titles = [];
        
        foreach ($this->get_topics() as $topic)
            $titles[] = $topic->title;
        
        return $titles;
    }
}
