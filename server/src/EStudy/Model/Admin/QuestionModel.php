<?php

namespace EStudy\Model\Admin;

use EStudy\Entity\Admin\QuestionEntity;
use Ninja\DatabaseTable;
use Ninja\NinjaException;

class QuestionModel
{
    private $question_table;

    public function __construct(DatabaseTable $question_table)
    {
        $this->question_table = $question_table;
    }

    public function get_all_questions($orderBy = null, $orderDirection = null, $limit = null, $offset = null)
    {
        return $this->question_table->findAll($orderBy, $orderDirection, $limit, $offset);
    }
    
    public function count()
    {
        return $this->question_table->total();
    }
    
    public function get_all_question_types()
    {
        return [
            QuestionEntity::TYPE_TEXT_WITH_ONE_CORRECT => 'Câu hỏi 1 đáp án',
            QuestionEntity::TYPE_TEXT_WITH_MULTIPLE_CORRECTS => 'Câu hỏi nhiều đáp án',
            QuestionEntity::TYPE_FILL_IN_BLANK => 'Câu hỏi điền vào chỗ trống',
            QuestionEntity::TYPE_SORT_SENTENCE => 'Câu hỏi sắp xếp lại câu',
        ];
    }

    public function get_by_type($type)
    {
        return $this->question_table->find(QuestionEntity::KEY_QUESTION_TYPE, $type) ?? [];
    }

    /**
     * @throws NinjaException
     */
    public function create_new_question($args)
    {
        if (empty($args[QuestionEntity::KEY_TITLE]))
            throw new NinjaException('Vui lòng nhập tiêu đề câu hỏi');
        
        if (empty($args[QuestionEntity::KEY_ANSWERS]))
            throw new NinjaException('Vui lòng nhập danh sách câu trả lời câu hỏi');

        if (empty($args[QuestionEntity::KEY_CORRECTS]))
            throw new NinjaException('Vui lòng nhập câu trả lời đúng của câu hỏi');

        if ($args[QuestionEntity::KEY_QUESTION_TYPE] == "")
            throw new NinjaException('Vui lòng chọn loại câu hỏi');

        if ($args[QuestionEntity::KEY_TOPIC] == "")
            throw new NinjaException('Vui lòng chọn chủ đề của câu hỏi');
        
        return $this->question_table->save([
            QuestionEntity::KEY_TITLE => $args[QuestionEntity::KEY_TITLE],
            QuestionEntity::KEY_ANSWERS => $args[QuestionEntity::KEY_ANSWERS],
            QuestionEntity::KEY_CORRECTS => $args[QuestionEntity::KEY_CORRECTS],
            QuestionEntity::KEY_MEDIA_ID => $args[QuestionEntity::KEY_MEDIA_ID] ?? null,
            QuestionEntity::KEY_QUESTION_TYPE => $args[QuestionEntity::KEY_QUESTION_TYPE],
            QuestionEntity::KEY_TOPIC => $args[QuestionEntity::KEY_TOPIC],
            QuestionEntity::KEY_AUDIO_PATH => $args[QuestionEntity::KEY_AUDIO_PATH] ?? null,
            QuestionEntity::KEY_AUDIO_NAME => $args[QuestionEntity::KEY_AUDIO_NAME] ?? null,
        ]);
    }
}
