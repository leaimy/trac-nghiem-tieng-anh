{% extends admin/master.html.php %}

{% block title %}<?= $shop_name ?? 'SSF' ?> - Admin - Tạo tài khoản mới{% endblock %}

{% block content %}

<div class="my-5">
    <h1 class="h2">Tạo tài khoản mới</h1>
</div>

<div class="min-vh-100">
    <form action="" method="post">
        <div class="row justify-content-center ">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        Thông tin chung
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="" class="form-label">Vai trò*</label>
                            <select class="form-select" aria-label="Chọn vai trò" name="type">
                                <option selected value="GUEST">GUEST</option>
                                <option value="ADMIN">ADMIN</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Họ và tên*</label>
                            <input type="text" name="fullname" class="form-control" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Tên người dùng*</label>
                            <input type="text" name="username" class="form-control" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Mật khẩu*</label>
                            <input type="text" name="password" class="form-control" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">E-mail</label>
                            <input type="text" name="email" class="form-control" autocomplete="off">
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary" type="submit">Thêm mới</button>
                        <button class="btn btn-secondary">Quay lại</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

{% endblock %}
