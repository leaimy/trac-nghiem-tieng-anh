{% extends client/master.html.php %}

{% block title %}<?= $shop_name ?? 'SSF' ?> - Trang cá nhân{% endblock %}

{% block content %}
<div class="container my-5 min-vh-100">
    <div class="row justify-content-center">
        <div class="col-sm-8 col-lg-3 mb-5 mb-lg-0">
            <div class="list-group">
                <a href="/me" class="list-group-item list-group-item-action" aria-current="true">
                    Thông tin cá nhân
                </a>
                <a href="/me/quizzes" class="list-group-item list-group-item-action active">Lịch sử kiểm tra</a>
                <a href="/auth/logout" class="list-group-item list-group-item-action">Đăng xuất</a>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="card">
                <div class="card-header">
                    Danh sách các bài kiểm tra của <?= $logged_in_user->fullname ?>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    Số bài kiểm tra đã thực
                                    hiện: <?= count($logged_in_user->get_completed_quizzes_logs()) ?>
                                </li>
                                <li class="list-group-item">
                                    Điểm cao nhất đạt được: 700
                                </li>
                                <li class="list-group-item">
                                    Thời gian trung bình: 30 phút
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-group">
                                <li class="list-group-item">An item</li>
                                <li class="list-group-item">A second item</li>
                                <li class="list-group-item">And a fifth one</li>
                            </ul>
                        </div>
                    </div>

                    <div class="row justify-content-around mt-4">
                        <?php foreach ($logged_in_user->get_completed_quizzes_logs() as $log): ?>
                            <div class="col-sm-9 col-md-6 col-lg-5 mb-3">
                                <div class="card">
                                    <!--<img src="https://via.placeholder.com/286x180" class="card-img-top" alt="...">-->
                                    <div class="card-body">
                                        <h5 class="card-title"><?= $log->get_quiz()->title ?></h5>
                                        <p class="card-text">
                                            Ngày làm: <?= $log->get_finish_datetime() ?><br>
                                            Số câu đúng: <?= $log->get_correct_on_total() ?><br>
                                        </p>

                                        <a href="/quizzes/take-quiz?quiz_id=<?= $log->get_quiz()->id ?>"
                                           class="btn btn-primary">Làm lại</a>

                                        <?php foreach ($log->get_histories() as $index => $detail): ?>
                                            <a href="/quizzes/histories/show?quiz_history_id=<?= $detail->id ?>"
                                               class="btn btn-outline-primary">Lần <?= $index + 1 ?></a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{% endblock %}
