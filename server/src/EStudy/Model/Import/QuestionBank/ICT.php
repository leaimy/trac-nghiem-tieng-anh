<?php

namespace EStudy\Model\Import\QuestionBank;

use EStudy\Entity\Admin\QuestionEntity;
use Ninja\DatabaseTable;

class ICT
{
    public function populate()
    {
        $myfile = fopen(__DIR__ . '/json/ict.json', "r") or die("Unable to open json/ict.json file!");
        $json_raw = fread($myfile, filesize(__DIR__ . '/json/ict.json'));

        fclose($myfile);

        $question_table = new DatabaseTable(QuestionEntity::TABLE, QuestionEntity::PRIMARY_KEY);

        $decoded = json_decode($json_raw);

        $course = $decoded->courses[0];
        $questions = $course->questions;

        foreach ($questions as $item) {
            $answers = [];
            $correct = '';

            foreach ($item->answer as $answer) {
                $answers[] = $answer->text;

                if ($answer->isCorrect)
                    $correct = $answer->text;
            }

            $question_table->save([
                QuestionEntity::KEY_TOPIC => 777,
                QuestionEntity::KEY_CREATED_AT => (new \DateTime()),
                QuestionEntity::KEY_AUDIO_NAME => null,
                QuestionEntity::KEY_AUDIO_PATH => null,
                QuestionEntity::KEY_MEDIA_ID => null,
                QuestionEntity::KEY_QUESTION_TYPE => QuestionEntity::TYPE_TEXT_WITH_ONE_CORRECT,
                QuestionEntity::KEY_TITLE => $item->question,
                QuestionEntity::KEY_CORRECTS => $correct,
                QuestionEntity::KEY_ANSWERS => implode("\n", $answers)
            ]);
        }
    }
}
