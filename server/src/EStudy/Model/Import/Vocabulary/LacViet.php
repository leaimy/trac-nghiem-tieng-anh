<?php

namespace EStudy\Model\Import\Vocabulary;

use EStudy\Entity\Admin\TopicVocabulary;
use EStudy\Entity\Admin\VocabularyEntity;
use Ninja\DatabaseTable;

class LacViet
{
    public function populate()
    {
        $myfile = fopen(__DIR__ . '/json/lacvietdata.json', "r") or die("Unable to open json/lac_viet.json file!");
        $json_raw = fread($myfile, filesize(__DIR__ . '/json/lacvietdata.json'));

        fclose($myfile);

        $vocabulary_table = new DatabaseTable(VocabularyEntity::TABLE, VocabularyEntity::PRIMARY_KEY);
        $topic_vocabulary_table = new DatabaseTable(TopicVocabulary::TABLE, TopicVocabulary::PRIMARY_KEY);

        $decoded = json_decode($json_raw);
        $total = get_object_vars($decoded);

        $unicodeRegexp = '([*#0-9](?>\\xEF\\xB8\\x8F)?\\xE2\\x83\\xA3|\\xC2[\\xA9\\xAE]|\\xE2..(\\xF0\\x9F\\x8F[\\xBB-\\xBF])?(?>\\xEF\\xB8\\x8F)?|\\xE3(?>\\x80[\\xB0\\xBD]|\\x8A[\\x97\\x99])(?>\\xEF\\xB8\\x8F)?|\\xF0\\x9F(?>[\\x80-\\x86].(?>\\xEF\\xB8\\x8F)?|\\x87.\\xF0\\x9F\\x87.|..(\\xF0\\x9F\\x8F[\\xBB-\\xBF])?|(((?<zwj>\\xE2\\x80\\x8D)\\xE2\\x9D\\xA4\\xEF\\xB8\\x8F\k<zwj>\\xF0\\x9F..(\k<zwj>\\xF0\\x9F\\x91.)?|(\\xE2\\x80\\x8D\\xF0\\x9F\\x91.){2,3}))?))';

        foreach ($total as $key => $value) {
            $content = strip_tags($value);

            $content = $this->clean_string($content);

            preg_match($unicodeRegexp, $content, $match_emos);

            $is_contain = in_array('✪', $match_emos);

            $topic_id = 999;
            if ($is_contain) {
                if (preg_match('/danh từ/', $content)) {
                    $topic_id = 1;
                }

                if (preg_match('/động từ/', $content)) {
                    $topic_id = 2;
                }

                if (preg_match('/tính từ/', $content)) {
                    $topic_id = 3;
                }

                if (preg_match('/giới từ/', $content)) {
                    $topic_id = 4;
                }

                if (preg_match('/phó từ/', $content)) {
                    $topic_id = 5;
                }

                if (preg_match('/liên từ/', $content)) {
                    $topic_id = 6;
                }

                if (preg_match('/thán từ/', $content)) {
                    $topic_id = 7;
                }

                if (preg_match('/đại từ/', $content)) {
                    $topic_id = 8;
                }

                if (preg_match('/thành ngữ/', $content)) {
                    $topic_id = 9;
                }

                if (preg_match('/viết tắt/', $content)) {
                    $topic_id = 10;
                }
                
                if (preg_match('/hậu tố/', $content)) {
                    $topic_id = 11;
                }
            }

            $vocabulary = $vocabulary_table->save([
                VocabularyEntity::KEY_ENGLISH => $key,
                VocabularyEntity::KEY_DESCRIPTION => $content,
                VocabularyEntity::KEY_VIETNAMESE => '',
            ]);
            
            $topic_vocabulary_table->save([
                TopicVocabulary::KEY_TOPIC_ID => $topic_id,
                TopicVocabulary::KEY_VOCABULARY_ID => $vocabulary->id
            ]);
        }
    }

    private function clean_string($origin)
    {
        $replaces = [
            "[m]",
            "[m0]",
            "[m1]",
            "[m2]",
            "[m3]",
            "[m4]",
            "[m5]",
            "[m6]",
            "[m7]",
            "[m8]",
            "[m9]",
            "[/m]",
            "[/m0]",
            "[/m1]",
            "[/m2]",
            "[/m3]",
            "[/m4]",
            "[/m5]",
            "[/m6]",
            "[/m7]",
            "[/m8]",
            "[/m9]",
        ];

        return str_replace($replaces, "", $origin);
    }
}
