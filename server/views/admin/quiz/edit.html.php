{% extends admin/master.html.php %}

{% block title %}<?= $shop_name ?? 'SSF' ?> - Admin - Chỉnh sửa bài trắc nghiệm{% endblock %}

{% block custom_styles %}
<link rel="stylesheet" href="/static/vendor/select2/select2.min.css">
<script src="/static/vendor/jquery/jquery.min.js"></script>
<script src="/static/vendor/select2/select2.min.js"></script>
{% endblock %}

{% block content %}

<div class="my-5">
    <h1 class="h2">Chỉnh sửa bài trắc nghiệm</h1>
</div>

<div class="min-vh-100">
    <div class="row my-5">
        <div class="col">
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="title" class="form-label">Tiêu đề</label>
                    <input type="text" name="title" id="title" class="form-control" value="<?= $quiz->title ?>">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Mô tả</label>
                    <textarea name="description" id="description" rows="10"
                              class="form-control"><?= $quiz->description ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="media" class="form-label">Ảnh minh họa</label>
                    <input type="file" name="media" id="media" class="form-control">
                </div>
                <div class="mb-3 mt-4">
                    <div class="d-flex justify-content-end">
                        <input type="submit" value="Cập nhật thông tin cơ bản" class="btn btn-primary">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <h2 class="h5">Danh sách <?= count($quiz->get_questions()) ?> câu hỏi</h2>

    <div class="row my-2">
        <div class="col d-flex justify-content-end">
            <button class="btn btn-success" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample"
                    aria-expanded="false" aria-controls="collapseExample">Thêm câu hỏi
            </button>
        </div>
    </div>
    
    <div class="row my-2">
        <div class="col">
            <div class="collapse" id="collapseExample">
                <div class="card card-body">
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="questions" class="form-label">Chọn câu hỏi</label>
                            <select name="questions[]" id="questions" class="form-select w-100" style="width: 100%" multiple>
                                <?php foreach ($questions as $question): ?>
                                    <option value="<?= $question->id ?>"><?= $question->title ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <input type="submit" value="Thêm câu hỏi đã chọn" class="btn btn-info">
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
                    <a href="#" class="text-decoration-none btn-delete-question" data-id="<?= $question->id ?>"
                       data-title="<?= $question->title ?>">
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
    $(document).ready(function() {
        $('#questions').select2();
    });
</script>
{% endblock %}
