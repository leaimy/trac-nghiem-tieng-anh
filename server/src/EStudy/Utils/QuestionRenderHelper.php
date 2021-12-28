<?php

namespace EStudy\Utils;

use EStudy\Entity\Admin\QuestionEntity;

class QuestionRenderHelper
{
    private $counter = 1;
    private QuestionEntity $question;

    public function set_question(QuestionEntity $question)
    {
        $this->question = $question;
        
        if ($this->question instanceof QuestionEntity) {
            switch ($question->type) {
                case QuestionEntity::TYPE_TEXT_WITH_ONE_CORRECT:
                    return $this->render_text_with_one_correct();

                case QuestionEntity::TYPE_TEXT_WITH_MULTIPLE_CORRECTS:
                    return $this->render_question_with_multiple_corrects();

                case QuestionEntity::TYPE_FILL_IN_BLANK:
                    return 'fill_blank';
                    break;

                case QuestionEntity::TYPE_SORT_SENTENCE:
                    return 'sort';
                    break;

                default:
                    return 'Question type is not valid';
            }
        }

        switch ($question['type']) {
            case QuestionEntity::TYPE_TEXT_WITH_ONE_CORRECT:
                return $this->render_text_with_one_correct_for_review();

            case QuestionEntity::TYPE_TEXT_WITH_MULTIPLE_CORRECTS:
                return 'multiple_correct';
                break;

            case QuestionEntity::TYPE_FILL_IN_BLANK:
                return 'fill_blank';
                break;

            case QuestionEntity::TYPE_SORT_SENTENCE:
                return 'sort';
                break;

            default:
                return 'Question type is not valid';
        }
    }

    private function render_text_with_one_correct()
    {
        ob_start();
        ?>
        <div class="card">
            <div class="card-header">
                Câu <?= $this->counter++ ?>: <?= $this->question->title ?>
            </div>
            <div class="card-body">
                <?php if (is_null($this->question->media_id)): ?>
                    <?php foreach ($this->question->get_answers() as $answer_counter => $answer): ?>
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="radio"
                                value="<?= $answer ?>"
                                name="answers-<?= QuestionEntity::TYPE_TEXT_WITH_ONE_CORRECT ?>[<?= $this->question->id ?>][]"
                                id="question-<?= $this->question->id ?>-<?= $answer_counter ?>"
                            />
                            <label class="form-check-label"
                                   for="question-<?= $this->question->id ?>-<?= $answer_counter ?>">
                                <?= $answer ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="row">
                        <div class="col-lg-4 col-xl-3 d-flex justify-content-center align-items-center mb-3 mb-lg-0">
                            <img width="150px" src="<?= $this->question->get_media()->media_path ?? '#' ?>"
                                 alt="question figure">
                        </div>
                        <div class="col-lg-8 col-xl-9 d-flex justify-content-start align-items-center">
                            <div>
                                <?php foreach ($this->question->get_answers() as $answer_counter => $answer): ?>
                                    <div class="form-check">
                                        <input
                                            class="form-check-input"
                                            type="radio"
                                            value="<?= $answer ?>"
                                            name="answers-<?= QuestionEntity::TYPE_TEXT_WITH_ONE_CORRECT ?>[<?= $this->question->id ?>][]"
                                            id="question-<?= $this->question->id ?>-<?= $answer_counter ?>"
                                        />
                                        <label class="form-check-label"
                                               for="question-<?= $this->question->id ?>-<?= $answer_counter ?>">
                                            <?= $answer ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
    
    private function render_text_with_one_correct_for_review()
    {
        $is_correct = json_encode($this->question['corrects']) == json_encode($this->question['user_answers']);

        ob_start();
        ?>
        <div class="card <?= $is_correct ? 'border border-success' : 'border border-danger' ?>">
            <div class="card-header text-white <?= $is_correct ? 'bg-success' : 'bg-danger' ?>">
                Câu <?= $this->counter++ ?>: <?= $this->question['title'] ?>
            </div>
            <div class="card-body">
                <?php if (is_null($this->question['media_id'])): ?>
                    <?php foreach (explode("\n", $this->question['answers']) as $answer_counter => $answer): ?>
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="radio"
                                <?= $answer == $this->question['corrects'] ? 'checked': 'disabled' ?>
                                value="<?= $answer ?>"
                            />
                            <label class="form-check-label <?= $answer == $this->question['corrects'] ? 'text-success': ($answer == $this->question['user_answers'] ? 'text-danger' : '') ?>">
                                <?= $answer ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="row">
                        <div class="col-lg-4 col-xl-3 d-flex justify-content-center align-items-center mb-3 mb-lg-0">
                            <img width="150px" src="<?= $this->question['media_path'] ?? '#' ?>"
                                 alt="question figure">
                        </div>
                        <div class="col-lg-8 col-xl-9 d-flex justify-content-start align-items-center">
                            <div>
                                <?php foreach (explode("\n", $this->question['answers']) as $answer_counter => $answer): ?>
                                    <div class="form-check">
                                        <input
                                            class="form-check-input"
                                            type="radio"
                                            <?= $answer == $this->question['corrects'] ? 'checked': 'disabled' ?>
                                            value="<?= $answer ?>"
                                        />
                                        <label class="form-check-label <?= $answer == $this->question['corrects'] ? 'text-success': ($answer == $this->question['user_answers'] ? 'text-danger' : '') ?>">
                                            <?= $answer ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
    
    private function render_question_with_multiple_corrects()
    {
        ob_start();
        ?>
        <div class="card">
            <div class="card-header">
                Câu <?= $this->counter++ ?>: <?= $this->question->title ?> (Chọn <?= count($this->question->get_correct_answers()) ?> đáp án)
            </div>
            <div class="card-body">
                <?php if (is_null($this->question->media_id)): ?>
                    <?php foreach ($this->question->get_answers() as $answer_counter => $answer): ?>
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                value="<?= $answer ?>"
                                name="answers-<?= QuestionEntity::TYPE_TEXT_WITH_MULTIPLE_CORRECTS ?>[<?= $this->question->id ?>][]"
                                id="question-<?= $this->question->id ?>-<?= $answer_counter ?>"
                            />
                            <label class="form-check-label"
                                   for="question-<?= $this->question->id ?>-<?= $answer_counter ?>">
                                <?= $answer ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="row">
                        <div class="col-lg-4 col-xl-3 d-flex justify-content-center align-items-center mb-3 mb-lg-0">
                            <img width="150px" src="<?= $this->question->get_media()->media_path ?? '#' ?>"
                                 alt="question figure">
                        </div>
                        <div class="col-lg-8 col-xl-9 d-flex justify-content-start align-items-center">
                            <div>
                                <?php foreach ($this->question->get_answers() as $answer_counter => $answer): ?>
                                    <div class="form-check">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            value="<?= $answer ?>"
                                            name="answers-<?= QuestionEntity::TYPE_TEXT_WITH_MULTIPLE_CORRECTS ?>[<?= $this->question->id ?>][]"
                                            id="question-<?= $this->question->id ?>-<?= $answer_counter ?>"
                                        />
                                        <label class="form-check-label"
                                               for="question-<?= $this->question->id ?>-<?= $answer_counter ?>">
                                            <?= $answer ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
    
    private function render_question_with_multiple_corrects_review()
    {
        
    }
}
