{% extends admin/master.html.php %}

{% block title %}<?= $shop_name ?? 'SSF' ?> - Admin - Thống kê người dùng{% endblock %}

{% block content %}

<?php
$all_questions = $all_questions ?? [];
?>

<div class="my-5">
    <h1 class="h2">Thống kê người dùng</h1>
</div>

<div class="row my-4">
    <div class="col-md-6">
        <a href="/admin/accounts" class="btn btn-secondary">Quay lại</a>
    </div>
</div>

<div class="min-vh-100">
    <h3 class="h5 text-center">Biểu đồ lượng người dùng theo vai trò</h3>
    <canvas class="my-4 w-100" id="chart_statistic_by_roles" width="900" height="380"></canvas>

    <table class="table table-bordered text-center">
        <thead>
        <tr class="table-primary">
            <th scope="col">Vai trò</th>
            <th scope="col">Lượng tài khoản</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($statistic_by_roles as $key => $value): ?>
            <tr>
                <td><?= $key ?></td>
                <td><?= $value ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <div class="my-5"></div>

    <h3 class="h5 text-center">Biểu đồ lượng người dùng theo nhóm</h3>
    <canvas class="my-4 w-100" id="chart_statistic_by_genders" width="900" height="380"></canvas>

    <table class="table table-bordered text-center">
        <thead>
        <tr class="table-primary">
            <th scope="col">Phân loại</th>
            <th scope="col">Lượng tài khoản</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($statistic_by_genders as $key => $value): ?>
            <tr>
                <td><?= $key ?></td>
                <td><?= $value ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

</div>

{% endblock %}

{% block custom_scrips %}
<script src="/static/js/Chart.min.js"></script>
<script>
    (function () {
        const statistic_data_by_topic = <?= json_encode($statistic_by_roles) ?>;
        const labels = Object.keys(statistic_data_by_topic);

        const data = {
            labels: labels,
            datasets: [
                {
                    label: 'Lượng người dùng theo vai trò',
                    data: Object.values(statistic_data_by_topic),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(201, 203, 207, 0.2)'
                    ],
                    borderColor: [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(201, 203, 207)'
                    ],
                    borderWidth: 1
                },
            ],
        };

        const config = {
            type: 'pie',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Chart.js Pie Chart'
                    }
                }
            }
        };

        const myChart = new Chart(
            document.getElementById('chart_statistic_by_roles'),
            config
        );
    })()
</script>
<script>
    (function () {
        const statistic_data_by_topic = <?= json_encode($statistic_by_genders) ?>;
        const labels = Object.keys(statistic_data_by_topic);

        const data = {
            labels: labels,
            datasets: [
                {
                    label: 'Lượng người dùng theo giới tính',
                    data: Object.values(statistic_data_by_topic),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(201, 203, 207, 0.2)'
                    ],
                    borderColor: [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(201, 203, 207)'
                    ],
                    borderWidth: 1
                },
            ],
        };

        const config = {
            type: 'pie',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Chart.js Pie Chart'
                    }
                }
            }
        };

        const myChart = new Chart(
            document.getElementById('chart_statistic_by_genders'),
            config
        );
    })()
</script>

{% endblock %}
