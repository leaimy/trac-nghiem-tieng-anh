<?php

namespace EStudy\Entity\Admin;

use EStudy\Model\Admin\TopicModel;

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
    
    public function __construct(TopicModel $topic_model)
    {
        $this->topic_model = $topic_model;
    }
    
    public function get_topic()
    {
        return $this->topic_model->get_by_id($this->topic_id);
    }
}
