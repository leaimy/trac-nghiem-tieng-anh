<?php

namespace EStudy\Model\Import\QuestionBank;

// Ref: https://github.com/mocmeo/english-quiz

use EStudy\Entity\Admin\QuestionEntity;
use Ninja\DatabaseTable;

class Quizlet
{
    public function populate()
    {
        $myfile = fopen(__DIR__ . '/json/quizlet.json', "r") or die("Unable to open json/quizlet.json file!");
        $json_raw = fread($myfile, filesize(__DIR__ . '/json/quizlet.json'));

        fclose($myfile);

        $question_table = new DatabaseTable(QuestionEntity::TABLE, QuestionEntity::PRIMARY_KEY);

        $decoded = json_decode($json_raw);
        
        foreach ($decoded as $item) {
            $title = $item->question;
            $correct_code = $item->correct_answer;
            
            if (empty($correct_code)) continue;
            
            $tmp = [];
            foreach ($item->answers as $answer) {
                if (array_key_exists($answer->key, $tmp))
                    $tmp[$answer->key] = [];
                
                $tmp[$answer->key] = $answer->content;
            }
            
            if (!isset($tmp[$correct_code])) continue;
            
            $question_table->save([
                QuestionEntity::KEY_TOPIC => 12,
                QuestionEntity::KEY_CREATED_AT => (new \DateTime()),
                QuestionEntity::KEY_AUDIO_NAME => null,
                QuestionEntity::KEY_AUDIO_PATH => null,
                QuestionEntity::KEY_MEDIA_ID => null,
                QuestionEntity::KEY_QUESTION_TYPE => QuestionEntity::TYPE_TEXT_WITH_ONE_CORRECT,
                QuestionEntity::KEY_TITLE => $title,
                QuestionEntity::KEY_CORRECTS => $tmp[$correct_code],
                QuestionEntity::KEY_ANSWERS => implode("\n", array_values($tmp))
            ]);
        }
    }
}
