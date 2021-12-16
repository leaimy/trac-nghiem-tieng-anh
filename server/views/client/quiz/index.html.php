{% extends client/master.html.php %}

{% block title %}<?= $shop_name ?? 'SSF' ?> - Trang chủ{% endblock %}

{% block content %}
<div class="container mt-5 mb-5">
    <h1 class="text-center my-4 h3">Trắc nghiệm ngẫu nhiên</h1>

    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h1 class="text-center my-4">
                    Ôn tập từ vựng thông qua các bài trắc nghiệm ngẫu nhiên
                </h1>

                <div class="row mt-5 justify-content-center justify-content-lg-start">
                    <?php foreach ($quizzes as $quiz): ?>
                        <div class="col-sm-10 col-md-6 col-lg-5 col-xxl-3 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $quiz->title ?></h5>
                                    <p class="card-text"><?= $quiz->description ?></p>

                                    <a href="/quizzes/by_topic?topic_id=<?= $quiz->id ?>" class="btn btn-primary">Ôn tập ngay</a>
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

