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

    public function get_by_id($id)
    {
        return $this->question_table->findById($id);
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

    public function get_by_type($type_id)
    {
        return $this->question_table->find(QuestionEntity::KEY_QUESTION_TYPE, $type_id) ?? [];
    }

    public function get_by_topic($topic_id)
    {
        return $this->question_table->find(QuestionEntity::KEY_TOPIC, $topic_id) ?? [];
    }

    /**
     * @throws NinjaException
     */
    public function create_new_question($args)
    {
        if (empty($args[QuestionEntity::KEY_TITLE]))
            throw new NinjaException('Vui lòng nhập tiêu đề câu hỏi');
        
        if ($args[QuestionEntity::KEY_QUESTION_TYPE] != QuestionEntity::TYPE_FILL_IN_BLANK) {
            if (empty($args[QuestionEntity::KEY_ANSWERS]))
                throw new NinjaException('Vui lòng nhập danh sách câu trả lời câu hỏi');
        }

        if (empty($args[QuestionEntity::KEY_CORRECTS]))
            throw new NinjaException('Vui lòng nhập câu trả lời đúng của câu hỏi');

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

    public function update_question($id, $args)
    {
        $args[QuestionEntity::PRIMARY_KEY] = $id;
        $this->question_table->save($args);
    }

    public function clear()
    {
        $this->question_table->deleteAll();
    }
    
    public function get_statistic()
    {
        $number_of_questions = $this->question_table->total();

        $counter = 0;
        $page = 0;
        $limit = 1000;
        
        $statistic = [
            'by_topic' => [],
            'by_type' => []
        ];
        
        while (true) {
            $question_chunks = $this->question_table->findAll(null, null, $limit, $page * $limit);
            
            /** @var $question QuestionEntity */
            foreach ($question_chunks as $question) {
                if (!isset($statistic['by_topic'][$question->get_topic()->title])) {
                    $statistic['by_topic'][$question->get_topic()->title] = 0;
                }
                $statistic['by_topic'][$question->get_topic()->title] += 1;
                
                if (!isset($statistic['by_type'][$question->type])) {
                    $statistic['by_type'][$question->type] = 0;
                }
                $statistic['by_type'][$question->type] += 1;

                $counter ++;
            }
            
            if ($counter >= $number_of_questions) break;
            
            $page += 1;
        }
        
        return $statistic;
    }
}
