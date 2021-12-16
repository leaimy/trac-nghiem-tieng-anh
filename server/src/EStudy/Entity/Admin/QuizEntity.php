<?php

namespace EStudy\Entity\Admin;

use EStudy\Model\Admin\MediaModel;
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
    const KEY_CREATED_AT = 'created_at';

    public $id;
    public $title;
    public $question_quantity;
    public $media_id;
    public $description;
    public $author_id;
    public $created_at;
    
    private $author_entity;
    private $author_model;
    
    private $question_entities;
    private $question_model;
    
    private $media_entity;
    private $media_model;
    
    public function __construct(QuestionModel $question_model, UserModel $user_model, MediaModel $media_model)
    {
        $this->author_model = $user_model;
        $this->question_model = $question_model;
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
    
    function get_questions()
    {
        return [];
    }

    function get_media()
    {
        if (is_null($this->media_id)) return null;
        
        if (!$this->media_entity) 
            $this->media_entity = $this->media_model->get_by_id($this->media_id);

        return $this->media_entity;
    }
}
