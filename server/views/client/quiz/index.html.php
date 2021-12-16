{% extends client/master.html.php %}

{% block title %}<?= $shop_name ?? 'SSF' ?> - Trang chủ{% endblock %}

{% block content %}
<div class="container mt-5 mb-5 min-vh-100">
    <h1 class="text-center mt-4 h4">Chủ đề: <?= $topic->title ?></h1>
    <p class="text-center mb-4">Số bài trắc nghiệm: <?= count($quizzes) ?></p>

    <div class="mt-5">
        <div class="card">
            <div class="card-body">
                <div class="row mt-5 justify-content-center justify-content-lg-start">
                    <?php foreach ($quizzes as $quiz): ?>
                        <div class="col-sm-10 col-md-6 col-lg-5 col-xxl-3 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $quiz->title ?></h5>
                                    <p class="card-text"><?= $quiz->description ?></p>

                                    <a href="/quizzes/take-quiz?quiz_id=<?= $quiz->id ?>" class="btn btn-primary">Làm ngay</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

{% endblock %}

