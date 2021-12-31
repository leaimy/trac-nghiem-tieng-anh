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

    <form action="" method="POST">
        <input type="hidden" name="quiz_id" value="<?= $quiz_id ?>">
        <div class="row mt-3 justify-content-center">
            <div class="col-sm-10">

                <?php foreach ($questions as $index => $question): ?>
                    <?= $question_render_helper->set_question($question) ?>
                    <div class="mb-3"></div>
                <?php endforeach; ?>

                <hr class="mt-5 my-3">
                <input type="submit" value="Hoàn thành" class="btn btn-success w-100">
            </div>
        </div>
    </form>

</div>

{% endblock %}

{% block custom_scrips %}

{% endblock %}
