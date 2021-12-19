{% extends admin/master.html.php %}

{% block title %}<?= $shop_name ?? 'SSF' ?> - Admin - Tạo tài khoản mới{% endblock %}

{% block content %}

<div class="my-5">
    <h1 class="h2">Thống kê</h1>
    <h1 class="h3"><?= $total_user ?> Users</h1>
    <h1 class="h3"><?= $total_admin ?> Admins</h1>
    <h1 class="h3"><?= $total_guest ?> Subscribers</h1>
    <h1 class="h3"><?= $total_male ?> Male</h1>
    <h1 class="h3"><?= $total_user - $total_male ?> Female</h1>
    <h1 class="h3"><?= $total_total_married_females ?> Married Females</h1>
</div>
<div id="chart-container">
    <canvas id="graph"></canvas>
</div>


{% endblock %}

{% block custom_scrips %}
<script src="/static/js/Chart.min.js"></script>
<script src="/static/js/dashboard.js"></script>
{% endblock %}
