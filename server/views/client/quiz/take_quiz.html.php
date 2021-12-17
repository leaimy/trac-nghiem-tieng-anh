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
        <?= $question_render_helper->set_question($question) ?>
        
    <?php endforeach; ?>
</div>

{% endblock %}

