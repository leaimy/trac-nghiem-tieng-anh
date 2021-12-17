<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/static/css/bootstrap.min.css">

    <title>Đăng nhập</title>

    <!-- Feather icon -->
    <script src="/static/js/feather.min.js"></script>

    {% yield custom_styles %}
</head>
<body>
<nav class="navbar navbar-expand-md navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="/">2NTH</a>
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

</nav>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xxl-6">
            <div class="card">
                <div class="card-body">
                    <h3 class="text-center">Đăng nhập</h3>

                    <div class="text-center mb-5">
                        <p>
                            Đăng nhập ngay để cùng đắm chìm vào thế giới của những bài
                            trắc nghiệm
                        </p>
                    </div>

                    <form action="#">
                        <div class="mb-3 row">
                            <label for="email" class="col-sm-4 col-form-label"
                            >Email</label
                            >
                            <div class="col-sm-8">
                                <input
                                    type="email"
                                    class="form-control"
                                    placeholder="Nhập tên người dùng"
                                    autocomplete="off"
                                    id="email"
                                    required
                                />
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="password" class="col-sm-4 col-form-label"
                            >Mật khẩu</label
                            >
                            <div class="col-sm-8">
                                <input
                                    type="password"
                                    class="form-control"
                                    placeholder="Nhập mật khẩu"
                                    id="password"
                                    required
                                />
                            </div>
                        </div>

                        <div class="mb-3 row justify-content-end">
                            <div class="col-sm-8">
                                <input
                                    type="submit"
                                    value="Đăng nhập ngay"
                                    class="btn btn-primary w-100 my-3"
                                />

                                <hr/>

                                <p class="text-center">
                                    Tạo tài khoản nhanh trong tích tắc
                                </p>
                                <a href="/auth/sign-up" class="btn btn-secondary w-100"
                                >Tạo tài khoản ngay</a
                                >
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script src="/static/js/bootstrap.bundle.min.js"></script>

<script>
    window.feather.replace({'aria-hidden': 'true'});

</script>

