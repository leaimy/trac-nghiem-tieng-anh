<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>{% yield title %}</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/static/css/bootstrap.min.css">

    <title>Website trắc nghiệm</title>

    <!-- Feather icon -->
    <script src="/static/js/feather.min.js"></script>

    {% yield custom_styles %}
</head>

<body>
<div class="row">
    <div class="col" style="z-index: 999">
        <nav class="navbar navbar-expand-md navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="/giao-dien/client/index.html">2NTH</a>
                <button
                    class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                >
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a
                                class="nav-link active"
                                aria-current="page"
                                href="/giao-dien/client/index.html"
                            >Trang chủ</a
                            >
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Trắc nghiệm chủ đề</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Làm bài thi</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <!--
                        <li class="nav-item ms-auto">
                          <a class="nav-link" href="#">Đăng nhập</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#">Tạo tài khoản</a>
                        </li>
                        -->
                        <li class="nav-item dropdown">
                            <a
                                class="nav-link dropdown-toggle"
                                href="#"
                                id="navbarDropdown"
                                role="button"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                            >
                                Xin chào Nguyễn Thị Hà
                            </a>
                            <ul class="dropdown-menu d" aria-labelledby="navbarDropdown">
                                <li>
                                    <a
                                        class="dropdown-item"
                                        href="/giao-dien/client/nguoi-dung/trang-ca-nhan/thong-tin-ca-nhan.html"
                                    >Tài khoản</a
                                    >
                                </li>
                                <li>
                                    <a
                                        class="dropdown-item"
                                        href="/giao-dien/client/nguoi-dung/trang-ca-nhan/lich-su-kiem-tra.html"
                                    >Lịch sử kiểm tra</a
                                    >
                                </li>
                                <li>
                                    <a
                                        class="dropdown-item"
                                        href="/giao-dien/client/nguoi-dung/trang-ca-nhan/doi-mat-khau.html"
                                    >Đổi mật khẩu</a
                                    >
                                </li>
                                <li>
                                    <hr class="dropdown-divider"/>
                                </li>
                                <li>
                                    <a
                                        class="dropdown-item"
                                        href="/giao-dien/client/nguoi-dung/dang-nhap.html"
                                    >Đăng xuất</a
                                    >
                                </li>
                            </ul>
                        </li>
                        <li
                            class="
                nav-item
                ms-2
                d-flex
                justify-content-center
                align-items-center
              "
                        >
                            <a href="#">
                                <img
                                    src="https://picsum.photos/200/200"
                                    height="35"
                                    class="rounded-circle"
                                    alt="Avatar"
                                />
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        
    </div>
</div>

{% yield content %}

<footer class="pt-5 pb-3" style="background-color: rgba(0, 0, 0, 0.3)">
    <div class="container">
        <h3>Website Trắc Nghiệm</h3>
        <p>Đơn giản hóa việc ôn tập kiến thức</p>
        <hr/>
        <p>&copy;2021 Bản quyền thuộc về: Nguyễn Thị Hà - Nguyễn Trọng Hiếu - Nguyễn Ngọc Quang</p>
    </div>
</footer>

<script src="/static/js/bootstrap.bundle.min.js"></script>

<script>
    window.feather.replace({'aria-hidden': 'true'});

</script>

{% yield custom_scrips %}

</body>

</html>
