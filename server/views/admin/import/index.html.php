{% extends admin/master.html.php %}

{% block title %}<?= $shop_name ?? 'SSF' ?> - Admin - Nhập dữ liệu mẫu{% endblock %}

{% block content %}

<div class="my-5">
    <h1 class="h2">Nhập dữ liệu mẫu</h1>
</div>

<div class="min-vh-100">
    <form action="/admin/import-sample-data/ict" method="POST">
        <input class="btn btn-primary" type="submit" value="Nhập bộ trắc nghiệm tin học ICT" name="import_ict">
    </form>

    <hr>

    <form action="/admin/import-sample-data/quizlet" method="POST">
        <input class="btn btn-success" type="submit" value="Nhập bộ trắc nghiệm tiếng Anh Quizlet" name="import_quizlet">
    </form>

    <hr>

    <form action="/admin/import-sample-data/lac_viet" method="POST">
        <input class="btn btn-warning" type="submit" value="Nhập từ điển Lạc Việt" name="import_lac_viet">
    </form>
</div>

{% endblock %}
