{% extends admin/master.html.php %}

{% block title %}<?= $shop_name ?? 'SSF' ?> - Admin - Hình ảnh{% endblock %}

{% block content %}

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Quản lý hình ảnh</h1>
</div>

<div class="min-vh-100">
    <div class="container-fluid">
        <form class="d-flex justify-content-center">
            <input style="width:18rem" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
    </div>

    <div class="row my-3">
        <?php for ($i = 0; $i < 20; $i++) : ?>
            <div class="col-3">
                <div class="card m-3">
                    <img  src="https://cdn.pixabay.com/photo/2015/04/23/22/00/tree-736885__480.jpg" class="card-img-top" alt="...">
                </div>
            </div>
        <?php endfor; ?>
    </div>
</div>

{% endblock %}
