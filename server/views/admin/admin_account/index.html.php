{% extends admin/master.html.php %}

{% block title %}<?= $shop_name ?? 'SSF' ?> - Admin - Danh sach tai khoan{% endblock %}

{% block content %}

<div class="my-5">
    <h1 class="h2">Quản lý tài khoản</h1>
</div>

<div class="row my-4">
    <div class="col-md-6"></div>
    <div class="col-md-6 d-flex justify-content-end">
        <a href="/admin/accounts/new_user" class="btn btn-primary">Tạo mới</a>
    </div>
</div>

<div class="min-vh-100">
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Tên đầy đủ</th>
            <th scope="col">Tên đăng nhập>
            <th scope="col">Vai trò</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $index => $user): ?>
        <tr>
            <th scope="row"><?= $index + 1 ?></th>
            <td><?= $user->fullname ?? 'N/A' ?></td>
            <td><?= $user->username ?? 'N/A' ?></td>
            <td><?= $user->type ?? 'GUEST' ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

{% endblock %}
