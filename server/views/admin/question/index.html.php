{% extends admin/master.html.php %}

{% block title %}<?= $shop_name ?? 'SSF' ?> - Admin - Câu hỏi{% endblock %}

{% block content %}

<?php
$all_questions = $all_questions ?? [];
?>

<div class="my-5">
    <h1 class="h2">Quản lý câu hỏi</h1>
</div>

<div class="row my-4">
    <div class="col-md-6">
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Nhập từ khóa" autocomplete="off">
            <button class="btn btn-outline-primary" type="button"><i data-feather="search"></i></button>
        </div>
    </div>
    <div class="col-md-6 d-flex justify-content-end align-items-start">
        <a href="/admin/questions/create" class="btn btn-primary">Thêm mới</a>
    </div>
</div>

<div class="min-vh-100">
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Tiêu đề</th>
            <th scope="col">Loại</th>
            <th scope="col">Chủ đề</th>
            <th scope="col">Đáp án đúng</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($all_questions as $question): ?>
            <tr>
                <th scope="row"><?= $question->id ?></th>
                <td><?= $question->title ?></td>
                <td><?= $question->type ?></td>
                <td><?= $question->topic_id ?></td>
                <td><?= $question->corrects ?></td>
                <td></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

{% endblock %}
