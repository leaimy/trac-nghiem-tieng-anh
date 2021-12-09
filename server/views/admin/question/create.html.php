{% extends admin/master.html.php %}

{% block title %}<?= $shop_name ?? 'SSF' ?> - Admin - Thêm câu hỏi mới{% endblock %}

{% block content %}

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h3">Thêm câu hỏi mới 🐹</h1>
</div>

<div class="min-vh-100">
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Thông tin chung
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="" class="form-label">Câu hỏi*</label>
                            <input name="question[title]" type="text" class="form-control" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Câu trả lời*</label>
                            <textarea name="question[answers]" id="" rows="5" class="form-control"></textarea>
                            <small class="text-muted">Mỗi câu trả lời phải trên mỗi dòng riêng biệt</small>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Đáp án đúng*</label>
                            <textarea name="question[corrects]" id="" rows="5" class="form-control"></textarea>
                            <small class="text-muted">Copy những dòng đáp án đúng từ phần danh sách câu trả lời</small>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Thêm mới</button>
                        <button class="btn btn-secondary">Quay lại</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        Nhóm
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="" class="form-label">Loại*</label>
                            <select name="question[type]" id="" class="form-select">
                                <option value="">Chọn loại câu hỏi</option>
                                <?php foreach ($question_types as $key => $type): ?>
                                    <option value="<?= $key ?>"><?= $type ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Chủ đề *</label>
                            <select name="question[topic_id]" id="" class="form-select">
                                <option value="">Chọn chủ đề</option>
                                <?php foreach ($topics as $key => $title): ?>
                                    <option value="<?= $key ?>"><?= $title ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card mt-5">
                    <div class="card-header">
                        Thông tin đa phương tiện
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="" class="form-label">Tập tin âm thanh</label>
                            <input type="file" name="audio_path" id="" class="form-control form-control-sm" accept="audio/*">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Tập tin hình ảnh</label>
                            <input type="file" name="audio_picture" id="" class="form-control form-control-sm" accept="image/*">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

{% endblock %}
