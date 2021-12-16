{% extends admin/master.html.php %}

{% block title %}<?= $shop_name ?? 'SSF' ?> - Admin - Bài trắc nghiệm{% endblock %}

{% block custom_styles %}
<link rel="stylesheet" href="/static/vendor/select2/select2.min.css">
<script src="/static/vendor/jquery/jquery.min.js"></script>
<script src="/static/vendor/select2/select2.min.js"></script>
{% endblock %}

{% block content %}

<div class="my-5">
    <h1 class="h2">Quản lý bài trắc nghiệm</h1>
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
        <button class="btn btn-success me-2 " type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample"
                aria-expanded="false" aria-controls="collapseExample">Tạo từ ngân hàng câu hỏi
        </button>
        <a href="/admin/quiz/create" class="btn btn-primary">Thêm mới</a>
    </div>
</div>

<div class="min-vh-100">

    <div class="row my-5">
        <div class="col">
            <div class="collapse" id="collapseExample">
                <div class="card card-body">
                    <form action="/admin/quiz/generate/from-question-bank" method="POST">
                        <div class="mb-3">
                            <label for="title" class="form-label">Tiêu đề</label>
                            <input value="Auto generated <?= (new \DateTime())->format('d-m-Y h:i:s') ?>" type="text"
                                   class="form-control" id="title" name="title">
                        </div>
                        <div class="mb-3">
                            <label for="question_quantity" class="form-label">Số lượng câu hỏi</label>
                            <input value="20" type="number" min="1" class="form-control" id="question_quantity"
                                   name="question_quantity">
                        </div>
                        <div class="mb-3">
                            <label for="question_type" class="form-label">Loại câu hỏi</label>
                            <select name="question_types[]" id="question_type" class="form-select" multiple
                                    style="width: 100%">
                                <?php foreach ($question_types as $key => $type): ?>
                                    <option value="<?= $key ?>"><?= $type ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="question_topic" class="form-label">Chủ đề câu hỏi</label>
                            <select name="question_topics[]" id="question_topic" class="form-select" multiple
                                    style="width: 100%">
                                <?php foreach ($topics as $topic): ?>
                                    <option value="<?= $topic->id ?>"><?= $topic->title ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <hr class="my-4">
                        <div class="mb-3">
                            <input type="submit" value="Tạo bài trắc nghiệm" class="btn btn-success">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Tiêu đề</th>
            <th scope="col">Câu hỏi</th>
            <th scope="col">Chủ đề</th>
            <th scope="col">Người tạo</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($quizzes as $idx => $quiz): ?>
            <tr>
                <th scope="row"><?= $idx + 1 ?></th>
                <td><?= $quiz->title ?></td>
                <td><?= $quiz->question_quantity ?></td>
                <td><?= implode("<br>", $quiz->get_topic_titles()) ?></td>
                <td><?= $quiz->author_id ?></td>
                <td>
                    <a href="/admin/quiz/edit?id=<?= $quiz->id ?>" class="me-2 text-decoration-none">
                        <i data-feather="edit-2" class="text-warning"></i>
                    </a>
                    <a href="#" class="text-decoration-none btn-delete-question" data-id="<?= $quiz->id ?>"
                       data-title="<?= $quiz->title ?>">
                        <i data-feather="trash-2" class="text-danger"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

{% endblock %}

{% block custom_scrips %}
<script>
    $(document).ready(function () {
        $('#question_type').select2();
        $('#question_topic').select2();
    });
</script>
{% endblock %}
