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
    const KEY_RANDOM_AT = 'random_at';
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
    public $random_at;
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
                return 'C??u h???i 1 ????p ??n';

            case self::TYPE_TEXT_WITH_MULTIPLE_CORRECTS:
                return 'C??u h???i nhi???u ????p ??n';

            case self::TYPE_FILL_IN_BLANK:
                return 'C??u h???i ??i???n v??o ch??? tr???ng';

            case self::TYPE_SORT_SENTENCE:
                return 'C??u h???i s???p x???p l???i c??u';

            default:
                return 'Ch??a ph??n lo???i';
        }
    }
    
    public static function get_type_text($type): string
    {
        switch ($type) {
            case self::TYPE_TEXT_WITH_ONE_CORRECT:
                return 'C??u h???i 1 ????p ??n';

            case self::TYPE_TEXT_WITH_MULTIPLE_CORRECTS:
                return 'C??u h???i nhi???u ????p ??n';

            case self::TYPE_FILL_IN_BLANK:
                return 'C??u h???i ??i???n v??o ch??? tr???ng';

            case self::TYPE_SORT_SENTENCE:
                return 'C??u h???i s???p x???p l???i c??u';

            default:
                return 'Ch??a ph??n lo???i';
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
        $tmp = [];
        foreach (explode("\n", $this->answers) as $item)
            $tmp[] = trim($item);
        
        return $tmp;
    }

    function get_correct_answers()
    {
        $tmp = [];
        foreach (explode("\n", $this->corrects) as $item)
            $tmp[] = trim($item);

        return $tmp;
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
    
    public function to_json_for_mobile()
    {
        $results = [];
        
        $results[self::KEY_ID] = $this->id;
        $results[self::KEY_TITLE] = $this->title;
        $results[self::KEY_RANDOM_AT] = $this->random_at;
        $results[self::KEY_MEDIA_ID] = $this->get_media();
        $results[self::KEY_CREATED_AT] = $this->created_at;
        $results[self::KEY_TOPIC] = $this->get_topic();
        $results[self::KEY_QUESTION_TYPE] = $this->type;
        $results[self::KEY_AUDIO_PATH] = $this->audio_path;
        
        $answers = [];
        
        foreach ($this->get_answers() as $answer) {
            $answers[] = [
                'content' => $answer, 
                'isTrue' => $answer == $this->corrects
            ];
        }
        
        $results[self::KEY_ANSWERS] = $answers;
        
        return $results;
    }
}
