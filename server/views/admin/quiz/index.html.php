{% extends admin/master.html.php %}

{% block title %}<?= $shop_name ?? 'SSF' ?> - Admin - Bài trắc nghiệm{% endblock %}

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
        <a href="/admin/questions/create" class="btn btn-primary">Thêm mới</a>
    </div>
</div>

<div class="min-vh-100">

    <div class="row my-5">
        <div class="col">
            <div class="collapse" id="collapseExample">
                <div class="card card-body">
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="question_quantity" class="form-label">Số lượng câu hỏi</label>
                            <input value="20" type="number" min="1" class="form-control" id="question_quantity">
                        </div>
                        <div class="mb-3">
                            <label for="question_type" class="form-label">Loại câu hỏi</label>
                            <select name="" id="question_type" class="form-select" multiple>
                                <?php foreach ($question_types as $key => $type): ?>
                                    <option value="<?= $key ?>"><?= $type ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="question_topic" class="form-label">Chủ đề câu hỏi</label>
                            <select name="" id="question_topic" class="form-select" multiple>
                                <?php foreach ($topics as $key => $type): ?>
                                    <option value="<?= $key ?>"><?= $type ?></option>
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
            <th scope="col">Loại</th>
            <th scope="col">Chủ đề</th>
            <th scope="col">Đáp án đúng</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th scope="row">104</th>
            <td title="Hướng Portrait hiển thị văn bản theo:">Hướng Portrait hiển thị văn bản theo:</td>
            <td>0</td>
            <td>777</td>
            <td title="Hướng dọc">Hướng dọc</td>
            <td>
                <a href="/admin/questions/edit?id=106" class="me-2 text-decoration-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-edit-2 text-warning" aria-hidden="true">
                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                    </svg>
                </a>
                <a href="#" class="text-decoration-none btn-delete-question" data-id="106"
                   data-title="Hướng Portrait hiển thị văn bản theo:">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-trash-2 text-danger" aria-hidden="true">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                        <line x1="10" y1="11" x2="10" y2="17"></line>
                        <line x1="14" y1="11" x2="14" y2="17"></line>
                    </svg>
                </a>
            </td>
        </tr>
        </tbody>
    </table>
</div>

{% endblock %}
