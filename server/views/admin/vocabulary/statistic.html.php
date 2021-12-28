{% extends admin/master.html.php %}

{% block title %}<?= $shop_name ?? 'SSF' ?> - Admin - Câu hỏi{% endblock %}

{% block content %}

<?php
$all_questions = $all_questions ?? [];
?>

<div class="my-5">
    <h1 class="h2">Thống kê từ vựng</h1>
</div>

<div class="row my-4">
    <div class="col-md-6">
        <a href="/admin/vocabularies" class="btn btn-secondary">Quay lại</a>
    </div>
</div>

<div class="min-vh-100">
    <h3 class="h5 text-center">Biểu đồ từ vựng theo chủ đề</h3>
    <canvas class="my-4 w-100" id="chart_statistic_by_topic" width="900" height="380"></canvas>

    <table class="table table-bordered text-center">
        <thead>
        <tr class="table-primary">
            <th scope="col">Chủ đề</th>
            <th scope="col">Số lượng (Câu)</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($statistic as $key => $value): ?>
            <tr>
                <td><?= ucfirst($key) ?></td>
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
        const statistic_data_by_topic = <?= json_encode($statistic) ?>;
        const labels = Object.keys(statistic_data_by_topic);

        const data = {
            labels: labels,
            datasets: [
                {
                    label: 'Lượng câu hỏi theo chủ đề',
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
            document.getElementById('chart_statistic_by_topic'),
            config
        );

    })()
</script>

{% endblock %}
