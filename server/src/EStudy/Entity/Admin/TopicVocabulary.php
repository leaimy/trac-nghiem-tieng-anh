<?php

namespace EStudy\Entity\Admin;

use EStudy\Model\Admin\TopicModel;
use EStudy\Model\Admin\VocabularyModel;

class TopicVocabulary
{
    const PRIMARY_KEY = 'id';
    const TABLE = 'topic_vocabulary';
    const CLASS_NAME = '\\EStudy\\Entity\\Admin\\TopicVocabulary';

    const KEY_ID = 'id';
    const KEY_TOPIC_ID = 'topic_id';
    const KEY_VOCABULARY_ID = 'vocabulary_id';
    const KEY_CREATED_AT = 'created_at';

    public $id;
    public $topic_id;
    public $vocabulary_id;
    public $created_at;
    
    private $topic_model;
    private $topic_entity;
    
    private $vocabulary_model;
    private $vocabulary_entity;
    
    public function __construct(TopicModel $topic_model, VocabularyModel $vocabulary_model)
    {
        $this->topic_model = $topic_model;
        $this->vocabulary_model = $vocabulary_model;
    }
    
    public function get_topic()
    {
        if (!$this->topic_entity)
            $this->topic_entity = $this->topic_model->get_by_id($this->topic_id);
        
        return $this->topic_entity;
    }
    
    public function get_vocabulary()
    {
        if (!$this->vocabulary_entity)
            $this->vocabulary_entity = $this->vocabulary_model->get_by_id($this->vocabulary_id);
        
        return $this->vocabulary_entity;
    }
}
