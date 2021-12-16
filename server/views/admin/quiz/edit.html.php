{% extends admin/master.html.php %}

{% block title %}<?= $shop_name ?? 'SSF' ?> - Admin - Chỉnh sửa bài trắc nghiệm{% endblock %}

{% block content %}

<div class="my-5">
    <h1 class="h2">Chỉnh sửa bài trắc nghiệm</h1>
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
        <?php foreach ($quiz->get_questions() as $idx => $question): ?>
            <tr>
                <th scope="row"><?= $idx + 1 ?></th>
                <td title="<?= $question->title ?>"><?= $question->get_truncate_title() ?></td>
                <td><?= $question->type ?></td>
                <td><?= $question->topic_id ?></td>
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
</div>

{% endblock %}
