<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>{% yield title %}</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="/static/css/bootstrap.min.css">
    <link rel="stylesheet" href="/static/css/dashboard.css">

    <!-- Feather icon -->
    <script src="/static/js/feather.min.js"></script>

    {% yield custom_styles %}
</head>

<body>
<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="/">EStudy - English For Future</a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
            aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-nav">
        <?php if ($is_logged_in) : ?>
            <div class="d-sm-flex">
                <div class="nav-item text-nowrap">
                    <a class="nav-link px-3" href="">Xin chào <?= $logged_in_user->display_name ?></a>
                </div>
                <div class="nav-item text-nowrap">
                    <a class="nav-link px-3" href="/auth/logout">Đăng xuất</a>
                </div>
            </div>
        <?php else : ?>
            <div class="d-sm-flex">
                <div class="nav-item text-nowrap">
                    <a class="nav-link px-3" href="/auth/register">Tạo tài khoản</a>
                </div>
                <div class="nav-item text-nowrap">
                    <a class="nav-link px-3" href="/auth/login">Đăng nhập</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</header>

<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?= strpos($route, '/admin/dashboard') !== false ? 'active' : '' ?>" href="/admin/dashboard">
                    <span data-feather="home"></span>
                    Tổng quan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= strpos($route, '/admin/topics') !== false ? 'active' : '' ?>" href="/admin/topics">
                    <span data-feather="file"></span>
                    Chủ đề
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= strpos($route, '/admin/vocabularies') !== false ? 'active' : '' ?>" href="/admin/vocabularies">
                    <span data-feather="shopping-cart"></span>
                    Từ vựng
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= strpos($route, '/admin/quiz') !== false ? 'active' : '' ?>" href="/admin/quiz">
                    <span data-feather="users"></span>
                    Bài trắc nghiệm
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= strpos($route, '/admin/questions') !== false ? 'active' : '' ?>" href="/admin/questions">
                    <span data-feather="bar-chart-2"></span>
                    Câu hỏi
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= strpos($route, '/admin/accounts') !== false ? 'active' : '' ?>" href="/admin/accounts">
                    <span data-feather="layers"></span>
                    Quản lý người dùng
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= strpos($route, '/admin/quiz-history') !== false ? 'active' : '' ?>" href="/admin/quiz-history">
                    <span data-feather="layers"></span>
                    Lịch sử kiểm tra
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= strpos($route, '/admin/settings') !== false ? 'active' : '' ?>" href="/admin/settings">
                    <span data-feather="layers"></span>
                    Cấu hình
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= strpos($route, '/admin/media') !== false ? 'active' : '' ?>" href="/admin/media">
                    <span data-feather="layers"></span>
                    Hình ảnh
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= strpos($route, '/admin/contact-us') !== false ? 'active' : '' ?>" href="/admin/contact-us">
                    <span data-feather="layers"></span>
                    Liên hệ chúng tôi
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= strpos($route, '/admin/import-sample-data') !== false ? 'active' : '' ?>" href="/admin/import-sample-data">
                    <span data-feather="layers"></span>
                    Tải dữ liệu mẫu
                </a>
            </li>
        </ul>
    </div>
</nav>


<div class="container-fluid">
    <div class="row">
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            {% yield content %}
        </main>
    </div>

    <div class="row">
        <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <footer class="bd-footer py-5 mt-5 bg-light">
                <div class="container py-5">
                    <div class="row">
                        <div class="col-lg-3 mb-3">
                            <a class="d-inline-flex align-items-center mb-2 link-dark text-decoration-none" href="/"
                               aria-label="Bootstrap">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="32" class="d-block me-2"
                                     viewBox="0 0 118 94" role="img">
                                    <title>EStudy</title>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M24.509 0c-6.733 0-11.715 5.893-11.492 12.284.214 6.14-.064 14.092-2.066 20.577C8.943 39.365 5.547 43.485 0 44.014v5.972c5.547.529 8.943 4.649 10.951 11.153 2.002 6.485 2.28 14.437 2.066 20.577C12.794 88.106 17.776 94 24.51 94H93.5c6.733 0 11.714-5.893 11.491-12.284-.214-6.14.064-14.092 2.066-20.577 2.009-6.504 5.396-10.624 10.943-11.153v-5.972c-5.547-.529-8.934-4.649-10.943-11.153-2.002-6.484-2.28-14.437-2.066-20.577C105.214 5.894 100.233 0 93.5 0H24.508zM80 57.863C80 66.663 73.436 72 62.543 72H44a2 2 0 01-2-2V24a2 2 0 012-2h18.437c9.083 0 15.044 4.92 15.044 12.474 0 5.302-4.01 10.049-9.119 10.88v.277C75.317 46.394 80 51.21 80 57.863zM60.521 28.34H49.948v14.934h8.905c6.884 0 10.68-2.772 10.68-7.727 0-4.643-3.264-7.207-9.012-7.207zM49.948 49.2v16.458H60.91c7.167 0 10.964-2.876 10.964-8.281 0-5.406-3.903-8.178-11.425-8.178H49.948z"
                                          fill="currentColor"/>
                                </svg>
                                <span class="fs-5">EStudy</span>
                            </a>
                            <ul class="list-unstyled small text-muted">
                                <li class="mb-2">EStudy - Website hỗ trợ sinh viên ôn thi tiếng Anh</li>
                                <hr>
                                <li class="mb-2">1812751 - Nguyễn Thị Hà</li>
                                <li class="mb-2">1812756 - Nguyễn Trọng Hiếu</li>
                                <li class="mb-2">1812832 - Nguyễn Ngọc Quang</li>
                                <hr>
                                <li class="mb-2">Phiên bản hiện tại: v1.0</li>
                            </ul>
                        </div>
                        <div class="col-sm-6 col-lg-2 offset-lg-1 mb-3">
                            <h5>Ôn tập từ vựng</h5>
                            <ul class="list-unstyled">
                                <li class="mb-2"><a href="/">Home</a></li>
                                <li class="mb-2"><a href="/docs/5.0/">Docs</a></li>
                                <li class="mb-2"><a href="/docs/5.0/examples/">Examples</a></li>
                                <li class="mb-2"><a href="https://themes.getbootstrap.com/">Themes</a></li>
                                <li class="mb-2"><a href="https://blog.getbootstrap.com/">Blog</a></li>
                            </ul>
                        </div>
                        <div class="col-sm-6 col-lg-2 mb-3">
                            <h5>Ôn tập chủ đề</h5>
                            <ul class="list-unstyled">
                                <li class="mb-2"><a href="/docs/5.0/getting-started/">Getting started</a></li>
                                <li class="mb-2"><a href="/docs/5.0/examples/starter-template/">Starter template</a>
                                </li>
                                <li class="mb-2"><a href="/docs/5.0/getting-started/webpack/">Webpack</a></li>
                                <li class="mb-2"><a href="/docs/5.0/getting-started/parcel/">Parcel</a></li>
                            </ul>
                        </div>
                        <div class="col-sm-6 col-lg-2 mb-3">
                            <h5>Đề thi</h5>
                            <ul class="list-unstyled">
                                <li class="mb-2"><a href="https://github.com/twbs/bootstrap">Bootstrap 5</a></li>
                                <li class="mb-2"><a href="https://github.com/twbs/bootstrap/tree/v4-dev">Bootstrap 4</a>
                                </li>
                                <li class="mb-2"><a href="https://github.com/twbs/icons">Icons</a></li>
                                <li class="mb-2"><a href="https://github.com/twbs/rfs">RFS</a></li>
                                <li class="mb-2"><a href="https://github.com/twbs/bootstrap-npm-starter">npm starter</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-sm-6 col-lg-2 mb-3">
                            <h5>Trắc nghiệm ngẫu nhiên</h5>
                            <ul class="list-unstyled">
                                <li class="mb-2"><a href="https://github.com/twbs/bootstrap/issues">Issues</a></li>
                                <li class="mb-2"><a href="https://github.com/twbs/bootstrap/discussions">Discussions</a>
                                </li>
                                <li class="mb-2"><a href="https://github.com/sponsors/twbs">Corporate sponsors</a></li>
                                <li class="mb-2"><a href="https://opencollective.com/bootstrap">Open Collective</a></li>
                                <li class="mb-2"><a href="https://bootstrap-slack.herokuapp.com/">Slack</a></li>
                                <li class="mb-2"><a href="https://stackoverflow.com/questions/tagged/bootstrap-5">Stack
                                        Overflow</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</div>

<script src="/static/js/bootstrap.bundle.min.js"></script>

<script>
    window.feather.replace({ 'aria-hidden': 'true' });

</script>

{% yield custom_scrips %}

</body>

</html>
