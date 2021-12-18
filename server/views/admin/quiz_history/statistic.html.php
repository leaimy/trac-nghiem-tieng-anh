{% extends admin/master.html.php %}

{% block title %}<?= $shop_name ?? 'SSF' ?> - Admin - Thống kê lịch sử kiểm tra{% endblock %}

{% block content %}

<div class="my-5">
    <h1 class="h2">Thống kê lịch sử kiểm tra</h1>
</div>

<div class="min-vh-100">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Thống kê số bài trắc nghiệm bởi loại người dùng</div>

                <div class="card-body">
                    <div class="card-text">Tổng: <?= $result->total ?></div>
                    <div class="card-text">Tạo bởi admin: <?= $result->by_admin ?></div>
                    <div class="card-text">Tạo bởi người dùng: <?= $result->by_anonymous ?></div>
                </div>

            </div>
        </div>
    </div>
</div>

{% endblock %}

