{% extends client/master.html.php %}

{% block title %}<?= $shop_name ?? 'SSF' ?> - Trang cá nhân{% endblock %}

{% block content %}
<div class="container my-5 min-vh-100">
    <div class="row justify-content-center">
        <div class="col-sm-8 col-lg-3 mb-5 mb-lg-0">
            <div class="list-group">
                <a href="/me" class="list-group-item list-group-item-action active" aria-current="true">
                    Thông tin cá nhân
                </a>
                <a href="/me/quizzes" class="list-group-item list-group-item-action">Lịch sử kiểm tra</a>
                <a href="/auth/logout" class="list-group-item list-group-item-action">Đăng xuất</a>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="card">
                <div class="card-header">Thông tin cá nhân</div>
                <div class="card-body">
                    <form action="" method="POST">
                        <input type="hidden" name="id" value="<?= $logged_in_user->id ?>">
                        <div class="mb-3 row">
                            <label for="fullname" class="col-md-3 col-form-label">Tên đầy đủ *</label>
                            <div class="col-md-9">
                                <input name="fullname" type="text" class="form-control" placeholder="Nhập tên" autocomplete="off" value="<?= $logged_in_user->fullname ?>" id="fullname" required="">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="username" class="col-md-3 col-form-label">Tên đăng nhập *</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" autocomplete="off" value="<?= $logged_in_user->username ?>" id="username" disabled="" required="">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="email" class="col-md-3 col-form-label">Email</label>
                            <div class="col-md-9">
                                <input name="email" type="email" class="form-control" placeholder="Nhập email" autocomplete="off" value="<?= $logged_in_user->email ?? '' ?>" id="email">
                            </div>
                        </div>

                        <div class="row justify-content-end mt-4">
                            <div class="col-md-9">
                                <input type="submit" value="Cập nhật" class="btn btn-primary">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
{% endblock %}
