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
            <th scope="col">Tên đăng nhập</th>
            <th scope="col">Vai trò</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($all_users as $index => $user): ?>
        <tr>
            <th scope="row"><?= ($current_page - 1) * $limit + ($index + 1) ?></th>
            <td><?= $user->fullname ?? 'N/A' ?></td>
            <td><?= $user->username ?? 'N/A' ?></td>
            <td><?= $user->type ?? 'GUEST' ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center flex-wrap">
            <?php for ($i = 0; $i <= $number_of_page; $i++): ?>
                <li class="page-item <?= ($i + 1) == $current_page ? 'active' : '' ?>">
                    <a class="page-link" href="/admin/accounts?page=<?= $i + 1 ?>"><?= $i + 1 ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>


{% endblock %}
