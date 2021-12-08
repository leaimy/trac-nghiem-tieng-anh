<?php

class QuestionEntity
{
    const PRIMARY_KEY = 'id';
    const TABLE = 'question';
    const CLASS_NAME = '\\EStudy\\Entity\\Admin\\QuestionEntity';
    
    const TYPE_TEXT_WITH_ONE_CORRECT = 0;
    const TYPE_TEXT_WITH_MULTIPLE_CORRECTS = 1;
    const TYPE_FILL_IN_BLANK = 2;
    const TYPE_SORT_SENTENCE = 3;

    const KEY_ID = 'id';
    const KEY_TITLE = 'title';
    const KEY_ANSWERS = 'answers';
    const KEY_CORRECTS = 'corrects';
    const KEY_MEDIA_ID = 'media_id';
    const KEY_QUESTION_TYPE = 'type';
    const KEY_NAME = 'topic_id';
    const KEY_AUDIO_PATH = 'audio_path';
    const KEY_AUDIO_NAME = 'audio_name';
    const KEY_CREATED_AT = 'created_at';

    public $id;
    public $title;
    public $answers;
    public $corrects;
    public $media_id;
    public $type;
    public $topic_id;
    public $audio_path;
    public $audio_name;
    public $created_at;
}
