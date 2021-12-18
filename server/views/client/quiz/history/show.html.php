{% extends client/master.html.php %}

{% block title %}<?= $shop_name ?? 'SSF' ?> - Trang chủ{% endblock %}

{% block content %}
<div class="container mt-5 mb-5">
    <h1 class="text-center my-4"><?= $quiz_info['title'] ?></h1>

    <div class="row my-5 justify-content-center">
        <div class="col-sm-10 col-md-8 col-lg-8 col-xxl-6 mb-6">
            <div class="card">
                <div class="card-header">Thông tin đề</div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Kết quả: <?= $quiz_result['correct'] ?> / <?= $quiz_result['total'] ?></li>
                </ul>
            </div>
        </div>
    </div>

        <div class="row mt-3 justify-content-center">
            <div class="col-sm-10">
                
                <?php foreach ($questions as $index => $question): ?>
                    <?= $question_render_helper->set_question($question) ?>
                    <div class="mb-3"></div>
                <?php endforeach; ?>
                
            </div>
        </div>

</div>

{% endblock %}

