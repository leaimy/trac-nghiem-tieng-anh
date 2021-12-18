{% extends admin/master.html.php %}

{% block title %}<?= $shop_name ?? 'SSF' ?> - Admin - Lịch sử các bài kiểm tra{% endblock %}

{% block content %}

<div class="my-5">
    <h1 class="h2">Danh sách các bài kiểm tra đã thực hiện</h1>
</div>

<div class="row my-4">
    <div class="col">
        <a href="/admin/quiz-history/statistic" class="btn btn-primary">Thống kê</a>
    </div>
</div>

<div class="min-vh-100">
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Người dùng</th>
            <th scope="col">Bài trắc nghiệm</th>
            <th scope="col">Kết quả cao nhất</th>
            <th scope="col">Chi tiết</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($histories as $idx => $history): ?>
            <tr>
                <th scope="row"><?= $idx + 1 ?></th>
                <td><?= $history->get_user() ? $history->get_user()->fullname : 'Ẩn danh' ?></td>
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
            </tr
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

{% endblock %}

