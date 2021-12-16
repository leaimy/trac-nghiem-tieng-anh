{% extends client/master.html.php %}

{% block title %}<?= $shop_name ?? 'SSF' ?> - Trang chủ{% endblock %}

{% block content %}
<div class="container mt-5 mb-5">
    <h1 class="text-center my-4">Trắc nghiệm ngẫu nhiên</h1>

    <div class="row my-5 justify-content-center">
        <div class="col-sm-10 col-md-8 col-lg-8 col-xxl-6 mb-6">
            <div class="card">
                <div class="card-header">Thông tin đề</div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Số lượng câu hỏi: 40</li>
                    <li class="list-group-item">Điểm cao nhất đã đạt: 650</li>
                    <li class="list-group-item">Mô tả thêm về đề</li>
                </ul>
            </div>
        </div>
    </div>
    
    <?php foreach ($questions as $index => $question): ?>
        <div class="row mt-3 justify-content-center">
            <div class="col-sm-10">
                <div class="card">
                    <div class="card-header">
                        Câu <?= $index + 1 ?>: <?= $question->title ?>
                    </div>
                    <div class="card-body">
                        <?php foreach ($question->get_answers() as $answer_counter => $answer): ?>
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="radio"
                                    name="question-<?= $question->id ?>"
                                    id="question-<?= $question->id ?>-<?= $answer_counter ?>"
                                />
                                <label class="form-check-label" for="question-<?= $question->id ?>-<?= $answer_counter ?>">
                                    <?= $answer ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

{% endblock %}

