{% extends admin/master.html.php %}

{% block title %}<?= $shop_name ?? 'SSF' ?> - Admin - Từ vựng{% endblock %}

{% block content %}

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Quản lý từ vựng</h1>
</div>

<div class="min-vh-100">
    <div class="d-flex justify-content-end">
        <a href="/admin/vocabularies/create" type="button" class="btn btn-outline-success">Thêm mới</a>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Tiếng Anh</th>
            <th scope="col">Tiếng Việt</th>
            <th scope="col">Chủ đề</th>
            <th scope="col">Hình ảnh</th>
            <th scope="col">Hành động</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($vocabulary_all as $index => $vocabulary) : ?>
            <tr>
                <th scope="row"><?= ($current_page - 1) * $limit + ($index + 1) ?></th>
                <td><?= $vocabulary->english; ?></td>
                <td><?= str_replace("\n", "<br>", $vocabulary->description); ?></td>
                <td>
                    <?php foreach ($vocabulary->get_topics() as $topic): ?>
                        <div class="d-block m-2 badge rounded-pill py-2 px-3 bg-primary"><?= $topic->title ?></div>
                    <?php endforeach; ?>
                </td>
                <td>
                    <img style="height: 100px;"
                         src="<?= $vocabulary->get_media_path() == null ? '/uploads/macdinh.jpg' : $vocabulary->get_media_path() ?>"
                         alt="">
                </td>
                <td>
                    <a class="text-info" href="#"><i data-feather="folder"></i></a>
                    <a class="text-warning" href="/admin/vocabularies/edit?id=<?= $vocabulary->id ?>"><i
                            data-feather="edit"></i></a>
                    <a class="text-danger" href="/admin/vocabularies/delete?id=<?= $vocabulary->id ?>"><i
                            data-feather="trash-2"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center flex-wrap">
            <?php for ($i = 0; $i <= $number_of_page; $i++): ?>
                <li class="page-item <?= ($i + 1) == $current_page ? 'active' : '' ?>">
                    <a class="page-link" href="/admin/vocabularies?page=<?= $i + 1 ?>"><?= $i + 1 ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>

{% endblock %}
