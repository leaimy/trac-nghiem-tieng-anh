<?php

namespace EStudy\Entity\Admin;

use EStudy\Model\Admin\MediaModel;
use EStudy\Model\Admin\TopicModel;
use Ninja\Utils\NJStringUtils;

class QuestionEntity
{
    const PRIMARY_KEY = 'id';
    const TABLE = 'question';
    const CLASS_NAME = '\\EStudy\\Entity\\Admin\\QuestionEntity';

    const TYPE_TEXT_WITH_ONE_CORRECT = 0;
    const TYPE_TEXT_WITH_MULTIPLE_CORRECTS = 1;
    const TYPE_FILL_IN_BLANK = 2;
    const TYPE_SORT_SENTENCE = 3;

    public static function get_types(): array
    {
        return [
            self::TYPE_TEXT_WITH_ONE_CORRECT => self::TYPE_TEXT_WITH_ONE_CORRECT,
            self::TYPE_TEXT_WITH_MULTIPLE_CORRECTS => self::TYPE_TEXT_WITH_MULTIPLE_CORRECTS,
            self::TYPE_FILL_IN_BLANK => self::TYPE_FILL_IN_BLANK,
            self::TYPE_SORT_SENTENCE => self::TYPE_SORT_SENTENCE,
        ];
    }

    const KEY_ID = 'id';
    const KEY_TITLE = 'title';
    const KEY_ANSWERS = 'answers';
    const KEY_CORRECTS = 'corrects';
    const KEY_MEDIA_ID = 'media_id';
    const KEY_QUESTION_TYPE = 'type';
    const KEY_TOPIC = 'topic_id';
    const KEY_USER_ANSWERS = 'user_answers';
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
    public $user_answers;
    public $audio_path;
    public $audio_name;
    public $created_at;

    private $topic_entity;
    private $topic_model;

    private $media_entity;
    private $media_model;

    function __construct(TopicModel $topic_model, MediaModel $media_model)
    {
        $this->topic_model = $topic_model;
        $this->media_model = $media_model;
    }

    function get_truncate_title()
    {
        return NJStringUtils::truncate($this->title, 50);
    }

    function get_truncate_correct_answer()
    {
        return NJStringUtils::truncate($this->corrects, 50);
    }

    function get_type(): string
    {
        switch ($this->type) {
            case self::TYPE_TEXT_WITH_ONE_CORRECT:
                return 'Câu hỏi 1 đáp án';

            case self::TYPE_TEXT_WITH_MULTIPLE_CORRECTS:
                return 'Câu hỏi nhiều đáp án';

            case self::TYPE_FILL_IN_BLANK:
                return 'Câu hỏi điền vào chỗ trống';

            case self::TYPE_SORT_SENTENCE:
                return 'Câu hỏi sắp xếp lại câu';

            default:
                return 'Chưa phân loại';
        }
    }

    function get_topic()
    {
        if (!$this->topic_entity)
            $this->topic_entity = $this->topic_model->get_by_id($this->topic_id);

        return $this->topic_entity;
    }

    function get_media()
    {
        if (!$this->media_entity)
            $this->media_entity = $this->media_model->get_by_id($this->media_id);

        return $this->media_entity;
    }

    function get_answers()
    {
        return explode("\n", $this->answers);
    }

    function get_correct_answers()
    {
        return explode("\n", $this->corrects);
    }

    function to_json(): array
    {
        return [
            self::KEY_ID => $this->id,
            self::KEY_TITLE => $this->title,
            self::KEY_QUESTION_TYPE => $this->type,
            self::KEY_TOPIC => $this->topic_id,
            self::KEY_ANSWERS => $this->answers,
            self::KEY_CORRECTS => $this->corrects,
            self::KEY_MEDIA_ID => $this->media_id,
            MediaEntity::KEY_MEDIA_PATH => $this->get_media()->{MediaEntity::KEY_MEDIA_PATH} ?? null,
            self::KEY_AUDIO_PATH => $this->audio_path,
            self::KEY_AUDIO_NAME => $this->audio_name,
            self::KEY_USER_ANSWERS => $this->user_answers,
        ];
    }
}
