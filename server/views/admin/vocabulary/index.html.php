{% extends admin/master.html.php %}

{% block title %}<?= $shop_name ?? 'SSF' ?> - Admin - Từ vựng{% endblock %}

{% block content %}

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Quản lý từ vựng</h1>
</div>

<div class="row my-4">
    <div class="col-md-6">
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Nhập từ khóa" autocomplete="off">
            <button class="btn btn-outline-primary" type="button"><i data-feather="search"></i></button>
        </div>
    </div>
    <div class="col-md-6 d-flex justify-content-end align-items-start">
        <a href="/admin/vocabularies" class="btn btn-outline-danger me-2">Xem toàn bộ</a>
        <a href="/admin/vocabularies/create" class="btn btn-outline-success">Thêm mới</a>
    </div>
</div>

<div class="row my-4">
    <div class="col">
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Lọc nâng cao
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                     data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="row col-md-4">
                            <form action="/admin/vocabularies" method="GET">
                                <input type="hidden" name="filter_by" value="topic">
                                <div class="mb-3">
                                    <label for="" class="form-label">Chọn loại từ</label>
                                    <select name="topic_id" id="" class="form-select">
                                        <?php foreach ($topic_all as $topic): ?>
                                            <option value="<?= $topic->id ?>"><?= $topic->title ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <input type="submit" class="btn btn-info w-100" value="Lọc">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="min-vh-100">
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
                        <?= $topic->get_html_box() ?>
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
                    <a class="page-link" href="/admin/vocabularies?<?= $parameters ?>&page=<?= $i + 1 ?>"><?= $i + 1 ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>

{% endblock %}
