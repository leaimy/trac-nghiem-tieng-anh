{% extends admin/master.html.php %}

{% block title %}<?= $shop_name ?? 'SSF' ?> - Admin - Chỉnh sửa bài trắc nghiệm{% endblock %}

{% block custom_styles %}
<link rel="stylesheet" href="/static/vendor/select2/select2.min.css">
<script src="/static/vendor/jquery/jquery.min.js"></script>
<script src="/static/vendor/select2/select2.min.js"></script>
{% endblock %}

{% block content %}

<div class="my-5">
    <h1 class="h2">Thêm bài trắc nghiệm mới</h1>
</div>

<div class="min-vh-100">
    <div class="row my-5">
        <div class="col">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="title" class="form-label">Tiêu đề</label>
                    <input type="text" name="title" id="title" class="form-control" value="">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Mô tả</label>
                    <textarea name="description" id="description" rows="10"
                              class="form-control"></textarea>
                </div>
                <div class="mb-3">
                    <label for="media" class="form-label">Ảnh minh họa</label>
                    <input type="file" name="media" id="media" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="questions" class="form-label">Chọn câu hỏi</label>
                    <select name="questions[]" id="questions" class="form-select w-100" style="width: 100%" multiple>
                        <?php foreach ($questions as $question): ?>
                            <option value="<?= $question->id ?>"><?= $question->title ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3 mt-4">
                    <div class="d-flex justify-content-end">
                        <a href="/admin/quiz" class="btn btn-secondary me-2">Quay lại</a>
                        <input type="submit" value="Tạo mới" class="btn btn-primary">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{% endblock %}

{% block custom_scrips %}
<script>
    $(document).ready(function () {
        $('#questions').select2();
    });
</script>
{% endblock %}
