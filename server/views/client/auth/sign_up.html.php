<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/static/css/bootstrap.min.css">

    <title>Đăng ký</title>

    <!-- Feather icon -->
    <script src="/static/js/feather.min.js"></script>

    {% yield custom_styles %}
</head>
<body>
<div class="d-flex flex-column" style="min-height: 100vh">
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
                        <h3 class="text-center">Tạo tài khoản</h3>

                        <div class="text-center mb-5">
                            <p>
                                Để tiện lợi trong việc trải nghiệm trang web, cũng như xem
                                lại các bài trắc nghiệm đã làm.<br/>
                                Bạn hãy đăng ký tài khoản ngay
                            </p>
                        </div>

                        <form action="" method="POST">
                            <div class="mb-3 row">
                                <label for="first-name" class="col-sm-4 col-form-label"
                                >Tên</label
                                >
                                <div class="col-sm-8">
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Nhập tên"
                                        autocomplete="off"
                                        id="first-name"
                                        name="first_name"
                                        required
                                    />
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="last-name" class="col-sm-4 col-form-label"
                                >Họ đệm</label
                                >
                                <div class="col-sm-8">
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Nhập họ đệm"
                                        name="last_name"
                                        autocomplete="off"
                                        id="last-name"
                                        required
                                    />
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="email" class="col-sm-4 col-form-label"
                                >Tên đăng nhập</label
                                >
                                <div class="col-sm-8">
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Nhập email"
                                        autocomplete="off"
                                        id="user_name"
                                        name="user_name"
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
                                        name="password"
                                        required
                                    />
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="re-password" class="col-sm-4 col-form-label"
                                >Xác nhận mật khẩu</label
                                >
                                <div class="col-sm-8">
                                    <input
                                        type="password"
                                        class="form-control"
                                        placeholder="Nhập lại mật khẩu để xác nhận"
                                        id="re-password"
                                        name="re_password"
                                        required
                                    />
                                </div>
                            </div>

                            <div class="mb-3 row justify-content-end">
                                <div class="col-sm-8">
                                    <input
                                        type="submit"
                                        value="Tạo tài khoản ngay"
                                        class="btn btn-primary w-100 my-3"
                                    />

                                    <hr/>

                                    <p class="text-center">Bạn đã có tài khoản?</p>
                                    <a href="/auth/sign-in" class="btn btn-secondary w-100">Đăng nhập ngay</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"
    ></script>
</body>


