{% extends admin/master.html.php %}

{% block title %}<?= $shop_name ?? 'SSF' ?> - Admin - Thêm chủ đề{% endblock %}

{% block content %}

<?php 
    $title = $title ?? '';
    $description = $description ?? '';
    $error = $error ?? false;
    $message = $message ?? '';
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Thêm chủ đề mới</h1>
</div>

<div class="min-vh-100">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <?php if ($error == true): ?>
                <div class="alert alert-danger my-4"><?= $message ?></div>
            <?php endif; ?>

            <form action="" method="post" enctype="multipart/form-data">
            <div class="card">
                <div class="card-header">
                    Điền thông tin của chủ đề, các trường bắt buộc có dấu*
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="" class="form-label">Tên*</label>
                        <input name="title" type="text" class="form-control" autocomplete="off" value="<?= $title ?>">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Mô tả</label>
                        <textarea name="description" id="" rows="5" class="form-control"><?= $description ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Hình ảnh*</label>
                        <input name="media" type="text" class="form-control" autocomplete="off">
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary">Thêm mới</button>
                    <button class="btn btn-secondary">Quay lại</button>
                </div>
            </div>
            </form>
          
        </div>
      
    </div>
</div>
{% endblock %}
