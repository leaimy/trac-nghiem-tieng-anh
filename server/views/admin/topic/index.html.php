{% extends admin/master.html.php %}

{% block title %}<?= $shop_name ?? 'SSF' ?> - Admin - Chủ đề{% endblock %}

{% block content %}
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Quản lý chủ đề</h1>
</div>

<div class="min-vh-100">
    <div class="d-flex justify-content-end">
    <a href="/admin/topics/create" type="button" class="btn btn-outline-success">Thêm mới</a>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Description</th>
                <th scope="col">Số lượng từ</th>
                <th scope="col">Media</th>
                <th scope="col">Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php $count = 1; ?>
            <?php foreach ($topic_all as $topic) : ?>
                <tr>
                    <th scope="row"><?= $count++; ?></th>
                    <td><?= $topic->title; ?></td>
                    <td><?= $topic->description; ?></td>
                    <td><?= $topic->total_vocabulary(); ?></td>
                    <td>
                        <img style="height: 100px;" src="<?= $topic->get_media_path() == null ? '/uploads/macdinh.jpg' : $topic->get_media_path() ?>" alt="">
                    </td>
                    <td>
                        <a class="text-warning" href="/admin/topics/edit?id=<?= $topic->id ?>"><i data-feather="edit"></i></a>
                        <a class="text-danger" href="/admin/topics/delete?id=<?= $topic->id ?>"><i data-feather="trash-2"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

{% endblock %}
