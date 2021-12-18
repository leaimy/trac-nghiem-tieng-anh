{% extends admin/master.html.php %}

{% block title %}<?= $shop_name ?? 'SSF' ?> - Admin - Lịch sử các bài kiểm tra{% endblock %}

{% block content %}

<div class="my-5">
    <h1 class="h2">Danh sách các bài kiểm tra đã thực hiện</h1>
</div>

<div class="min-vh-100">
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Người dùng</th>
            <th scope="col">Bài trắc nghiệm</th>
            <th scope="col">Kết quả</th>
            <th scope="col">Kết quả</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($histories as $idx => $history): ?>
            <tr>
                <th scope="row"><?= $idx + 1 ?></th>
                <td><?= $history->get_user()->fullname ?></td>
                <td>
                    <a class="text-decoration-none" href="/admin/quiz/edit?id=<?= $history->get_quiz()->id ?>"
                       target="_blank"><?= $history->get_quiz()->title ?>
                    </a>
                </td>
                <td><?= $history->correct_quantity ?> / <?= $history->get_quiz()->question_quantity ?></td>
                <td>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($history->get_histories() as $c => $detail): ?>
                            <li class="list-group-item">
                                <a href="/quizzes/histories/show?quiz_history_id=<?= $detail->id ?>" target="_blank" class="text-decoration-none">
                                    Lần: <?= $c + 1 ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </td>
                <td>
                    <a href="#" class="text-decoration-none btn-delete-question">
                        <i data-feather="trash-2" class="text-danger"></i>
                    </a>
                </td>
            </tr
        <?php endforeach; ?>
        </tbody>
    </table>
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
