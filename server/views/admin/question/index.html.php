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
        <button class="btn btn-outline-primary me-2">Nhập</button>
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
        <?php foreach ($all_questions as $idx => $question): ?>
            <tr>
                <th scope="row"><?= ($current_page - 1) * $limit + ($idx + 1) ?></th>
                <td title="<?= $question->title ?>"><?= $question->get_truncate_title() ?></td>
                <td><?= $question->get_type() ?></td>
                <td><?= $question->get_topic()->title ?></td>
                <td title="<?= $question->corrects ?>"><?= $question->get_truncate_correct_answer() ?></td>
                <td>
                    <a href="/admin/questions/edit?id=<?= $question->id ?>" class="me-2 text-decoration-none">
                        <i data-feather="edit-2" class="text-warning"></i>
                    </a>
                    <a href="#" class="text-decoration-none btn-delete-question" data-id="<?= $question->id ?>" data-title="<?= $question->title ?>">
                        <i data-feather="trash-2" class="text-danger"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center flex-wrap">
            <?php for ($i = 0; $i <= $number_of_page; $i++): ?>
                <li class="page-item <?= ($i + 1) == $current_page ? 'active' : '' ?>">
                    <a class="page-link" href="/admin/questions?page=<?= $i + 1 ?>"><?= $i + 1 ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>

{% endblock %}

{% block custom_scrips %}
<script src="/static/vendor/sweetalert2/sweetalert2@11.js"></script>

<script>
    document.querySelectorAll('.btn-delete-question').forEach(function (buttonElement) {
        buttonElement.addEventListener('click', function (e) {
            e.preventDefault();
            
            var id = e.currentTarget.dataset.id;
            var title = e.currentTarget.dataset.title;

            Swal.fire({
                title: 'Xác nhận xóa?',
                text: "Không thể khôi phục câu hỏi đã xóa, vẫn muốn xóa: \"" + title + "\" ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Xác nhận'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        'Xóa bỏ!',
                        'Câu hỏi nãy đã được xóa bỏ!',
                        'success'
                    )
                }
            })
        })
    })
</script>
{% endblock %}
