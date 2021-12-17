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
        <input class="btn btn-warning mb-2" type="submit" value="Nhập từ điển Lạc Việt (Anh - Việt) - 1000 từ đầu tiên" name="en_0">
        <input class="btn btn-warning mb-2" type="submit" value="Nhập từ điển Lạc Việt (Anh - Việt) - 1" name="en_1">
        <input class="btn btn-warning mb-2" type="submit" value="Nhập từ điển Lạc Việt (Anh - Việt) - 2" name="en_2">
        <input class="btn btn-warning mb-2" type="submit" value="Nhập từ điển Lạc Việt (Anh - Việt) - 3" name="en_3">
        <input class="btn btn-warning mb-2" type="submit" value="Nhập từ điển Lạc Việt (Anh - Việt) - 4" name="en_4">
        <input class="btn btn-warning mb-2" type="submit" value="Nhập từ điển Lạc Việt (Việt - Anh) - 1" name="vi_1">
        <input class="btn btn-warning mb-2" type="submit" value="Nhập từ điển Lạc Việt (Việt - Anh) - 2" name="vi_2">
    </form>
  
    <hr>

    <form action="/admin/import-sample-data/fullname" method="POST">
        <input class="btn btn-success" type="submit" value="Nhập dữ liệu tên" name="import_fullname">
    </form>  
</div>

{% endblock %}
