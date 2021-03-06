<?php

namespace EStudy\Utils;

use EStudy\Entity\Admin\QuestionEntity;

class QuestionRenderHelper
{
    private $counter = 1;
    private $question;

    public function set_question($question)
    {
        $this->question = $question;
        
        if ($this->question instanceof QuestionEntity) {
            $this->question->answers = str_replace("\r", "", $this->question->answers);
            $this->question->corrects = str_replace("\r", "", $this->question->corrects);
            
            switch ($question->type) {
                case QuestionEntity::TYPE_TEXT_WITH_ONE_CORRECT:
                    return $this->render_text_with_one_correct();

                case QuestionEntity::TYPE_TEXT_WITH_MULTIPLE_CORRECTS:
                    return $this->render_question_with_multiple_corrects();

                case QuestionEntity::TYPE_FILL_IN_BLANK:
                    return $this->render_quesion_fill_in_blank();

                case QuestionEntity::TYPE_SORT_SENTENCE:
                    return 'sort';

                default:
                    return 'Question type is not valid';
            }
        }

        $this->question['corrects'] = str_replace("\r", "", $this->question['corrects']);
        switch ($question['type']) {
            case QuestionEntity::TYPE_TEXT_WITH_ONE_CORRECT:
                return $this->render_text_with_one_correct_for_review();

            case QuestionEntity::TYPE_TEXT_WITH_MULTIPLE_CORRECTS:
                return $this->render_question_with_multiple_corrects_review();

            case QuestionEntity::TYPE_FILL_IN_BLANK:
                return $this->render_quesion_fill_in_blank_review();

            case QuestionEntity::TYPE_SORT_SENTENCE:
                return 'sort';

            default:
                return 'Question type is not valid';
        }
    }

    private function render_text_with_one_correct()
    {
        if (!$this->question instanceof QuestionEntity) return 'Not a question!';
        ob_start();

        ?>
        <div class="card">
            <div class="card-header">
                C??u <?= $this->counter++ ?>: <?= $this->question->title ?>
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
                C??u <?= $this->counter++ ?>: <?= $this->question['title'] ?>
            </div>
            <div class="card-body">
                <?php if (is_null($this->question['media_id'])): ?>
                    <?php foreach (explode("\n", $this->question['answers']) as $answer_counter => $answer): ?>
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="radio"
                                <?= $answer == $this->question['corrects'] ? 'checked' : 'disabled' ?>
                                value="<?= $answer ?>"
                            />
                            <label
                                class="form-check-label <?= $answer == $this->question['corrects'] ? 'text-success' : ($answer == $this->question['user_answers'] ? 'text-danger' : '') ?>">
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
                                            <?= $answer == $this->question['corrects'] ? 'checked' : 'disabled' ?>
                                            value="<?= $answer ?>"
                                        />
                                        <label
                                            class="form-check-label <?= $answer == $this->question['corrects'] ? 'text-success' : ($answer == $this->question['user_answers'] ? 'text-danger' : '') ?>">
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
        if (!$this->question instanceof QuestionEntity) return 'Not a valid question';

        ob_start();
        ?>
        <div class="card">
            <div class="card-header">
                C??u <?= $this->counter++ ?>: <?= $this->question->title ?>
                (Ch???n <?= count($this->question->get_correct_answers()) ?> ????p ??n)
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
        $correct_answers = str_replace("\r", "", $this->question['corrects']);
        $user_answers = $this->question['user_answers'];
        $is_correct = json_encode($correct_answers) == json_encode($user_answers);

        ob_start();
        ?>
        <div class="card <?= $is_correct ? 'border border-success' : 'border border-danger' ?>">
            <div class="card-header text-white <?= $is_correct ? 'bg-success' : 'bg-danger' ?>">
                C??u <?= $this->counter++ ?>: <?= $this->question['title'] ?>
                (Ch???n <?= count(explode("\n", $this->question['corrects'])) ?> ????p ??n)
            </div>
            <div class="card-body">
                <?php if (is_null($this->question['media_id'])): ?>
                    <?php foreach (explode("\n", $this->question['answers']) as $answer_counter => $answer): ?>
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                <?= strpos($correct_answers, trim($answer)) !== false ? 'checked' : 'disabled' ?>
                                value="<?= $answer ?>"
                            />
                            <label
                                class="form-check-label <?= strpos($correct_answers, trim($answer)) !== false ? 'text-success' : (strpos($user_answers, trim($answer)) !== false ? 'text-danger' : '') ?>">
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
                                            type="checkbox"
                                            <?= strpos($correct_answers, trim($answer)) !== false ? 'checked' : 'disabled' ?>
                                            value="<?= $answer ?>"
                                        />
                                        <label
                                            class="form-check-label <?= strpos($correct_answers, trim($answer)) !== false ? 'text-success' : (strpos($user_answers, trim($answer)) !== false ? 'text-danger' : '') ?>">
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

    private function render_quesion_fill_in_blank()
    {
        if (!$this->question instanceof QuestionEntity) return 'Not a valid question';

        $parts = explode('___', $this->question->title);

        ob_start();
        ?>
        <div class="card">
            <div class="card-header">
                C??u <?= $this->counter++ ?>: ??i???n v??o ch??? tr???ng ????? ho??n th??nh c??u
            </div>
            <div class="card-body">
                <?php if (is_null($this->question->media_id)): ?>
                    <div>
                        <?php foreach ($parts as $index => $part): ?>
                            <?= $part ?> &nbsp;

                            <?php if ($index < count($parts) - 1): ?>
                                <input type="text" autocomplete="off"
                                       class="mb-1 form-control form-control-sm d-inline-block w-auto"
                                       name="answers-<?= QuestionEntity::TYPE_FILL_IN_BLANK ?>[<?= $this->question->id ?>][]"
                                >
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="row">
                        <div class="col-lg-4 col-xl-3 d-flex justify-content-center align-items-center mb-3 mb-lg-0">
                            <img width="150px" src="<?= $this->question->get_media()->media_path ?? '#' ?>"
                                 alt="question figure">
                        </div>
                        <div class="col-lg-8 col-xl-9 d-flex justify-content-start align-items-center">
                            <div>
                                <?php foreach ($parts as $index => $part): ?>
                                    <?= $part ?> &nbsp;

                                    <?php if ($index < count($parts) - 1): ?>
                                        <input type="text" autocomplete="off"
                                               class="mb-1 form-control form-control-sm d-inline-block w-auto"
                                               name="answers-<?= QuestionEntity::TYPE_FILL_IN_BLANK ?>[<?= $this->question->id ?>][]"
                                        >
                                    
                                    <?php endif; ?>
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

    private function render_quesion_fill_in_blank_review()
    {
        $correct_answers = str_replace("\r", "", $this->question['corrects']);
        $user_answers = $this->question['user_answers'];

        $parts = explode('___', $this->question['title']);
        
        $correct_answer_parts = explode("\n", $correct_answers);
        $user_answer_parts = explode("\n", $user_answers);

        $is_correct = json_encode($correct_answers) == json_encode($user_answers);

        ob_start();
        ?>
        <div class="card <?= $is_correct ? 'border border-success' : 'border border-danger' ?>">
            <div class="card-header text-white <?= $is_correct ? 'bg-success' : 'bg-danger' ?>">
                C??u <?= $this->counter++ ?>: ??i???n v??o ch??? tr???ng ????? ho??n th??nh c??u
            </div>
            <div class="card-body">
                <?php if (is_null($this->question['media_id'])): ?>
                    <div>
                        <?php foreach ($parts as $index => $part): ?>
                            <?= $part ?>

                            <?php if ($index < count($parts) - 1): ?>
                                <div class="badge bg-success"><?= $correct_answer_parts[$index] ?></div>

                                <?php if ($user_answer_parts[$index] != $correct_answer_parts[$index]): ?>
                                    <div class="badge bg-danger"><?= $user_answer_parts[$index] ?? '' ?></div>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="row">
                        <div class="col-lg-4 col-xl-3 d-flex justify-content-center align-items-center mb-3 mb-lg-0">
                            <img width="150px" src="<?= $this->question['media_path'] ?? '#' ?>"
                                 alt="question figure">
                        </div>
                        <div class="col-lg-8 col-xl-9 d-flex justify-content-start align-items-center">
                            <div>
                                <?php foreach ($parts as $index => $part): ?>
                                    <?= $part ?>

                                    <?php if ($index < count($parts) - 1): ?>
                                        <div class="badge bg-success"><?= $correct_answer_parts[$index] ?></div>

                                        <?php if ($user_answer_parts[$index] != $correct_answer_parts[$index]): ?>
                                            <div class="badge bg-danger"><?= $user_answer_parts[$index] ?? '' ?></div>
                                        <?php endif; ?>
                                    <?php endif; ?>
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
}
