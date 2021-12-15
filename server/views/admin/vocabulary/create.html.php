{% extends admin/master.html.php %}

{% block title %}<?= $shop_name ?? 'SSF' ?> - Admin - Thêm từ vựng{% endblock %}

{% block custom_styles %}
<link href="/static/vendor/select2/select2.min.css" rel="stylesheet" />
{% endblock %}

{% block content %}

<?php
$english = $english ?? '';
$vietnamese = $vietnamese ?? '';
$description = $description ?? '';
$error = $error ?? false;
$message = $message ?? '';
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Thêm từ vựng mới</h1>
</div>

<div class="min-vh-100">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <?php if ($error == true) : ?>
                <div class="alert alert-danger my-4"><?= $message ?></div>
            <?php endif; ?>

            <form action="" method="post" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-header">
                        Điền thông tin của chủ đề, các trường bắt buộc có dấu*
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="" class="form-label">Tiếng Anh*</label>
                            <input name="english" type="text" class="form-control" autocomplete="off" value="<?= $english ?>">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Tiếng Việt*</label>
                            <input name="vietnamese" type="text" class="form-control" autocomplete="off" value="<?= $vietnamese ?>">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Chủ đề*</label>
                            <select name="topic_ids[]" class="form-select" id="topic_select" multiple>
                                <option value="1">Danh từ</option>
                                <option value="2">Tính từ</option>
                                <option value="3">Động từ</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Mô tả*</label>
                            <textarea name="description" id="" rows="5" class="form-control"><?= $description ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Hình ảnh</label>
                            <div class="row">
                                <div class="col-10">
                                    <input type="text" name="image_name" id="name" class="form-control" disabled>
                                </div>
                                <div class="col-2">
                                    <label class="border rounded p-2 bg-info text-white" for="file_upload">Chọn ảnh</label>
                                    <input class="" accept="image/*" hidden name="file_upload" id="file_upload" type="file" onchange="hienthianh(this); ">
                                </div>
                            </div>
                        </div>
                        <div class="text-center mb-1"><img id="image" src="" alt="" name="image_path"></div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-success">Thêm mới</button>
                        <a href="/admin/vocabularies" class="btn btn-secondary">Quay lại</a>
                    </div>
                </div>
            </form>

        </div>

    </div>
</div>
{% endblock %}

{% block custom_scrips %}
<script src="/static/vendor/jquery/jquery.min.js"></script>
<script src="/static/vendor/select2/select2.min.js"></script>
<script>
    function hienthianh(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            const name = document.getElementById('name');
            name.setAttribute('value', input.files[0].name);

            reader.onload = function(e) {
                const image = document.getElementById('image');
                image.setAttribute('src', e.target.result);
                image.setAttribute('height', 200);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $(document).ready(function() {
        $('#topic_select').select2();
    });
</script>
{% endblock %}


