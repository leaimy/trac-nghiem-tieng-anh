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

    <script src="/static/vendor/sweetalert2/sweetalert2@11.js"></script>

    {% yield custom_styles %}
</head>

<body>
<nav class="navbar navbar-expand-md navbar-light bg-light">
    <div class="container" style="z-index: 999;">
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
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?= $route == '/' ? 'active' : '' ?>" href="/">Trang chủ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $route == '/quizzes' ? 'active' : '' ?>" href="/quizzes">Bài trắc nghiệm</a>
                </li>
                <?php if ($is_logged_in && $logged_in_user->is_admin()): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin">Admin</a>
                    </li>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <?php if ($is_logged_in): ?>
                    <li class="nav-item dropdown">
                        <a
                            class="nav-link dropdown-toggle"
                            href="/me"
                            id="navbarDropdown"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                        >
                            Xin chào <?= $logged_in_user->fullname ?>
                        </a>
                        <ul class="dropdown-menu d" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item" href="/me">Tài khoản</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/me/quizzes">Lịch sử kiểm tra</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider"/>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/auth/logout">Đăng xuất</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item ms-auto">
                        <a class="nav-link" href="/auth/sign-in">Đăng nhập</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/auth/sign-up">Tạo tài khoản</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

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


<script>
    function clearSelection() {
        if (window.getSelection) {
            if (window.getSelection().empty) {  // Chrome
                window.getSelection().empty();
            } else if (window.getSelection().removeAllRanges) {  // Firefox
                window.getSelection().removeAllRanges();
            }
        } else if (document.selection) {  // IE?
            document.selection.empty();
        }
    }

    var t = '';

    function gText(e) {
        t = (document.all) ? document.selection.createRange().text : document.getSelection();
        if(!t.toString().trim())
            return;

        var api = '/api/v1/vocabularies/search/english?keyword=' + t.toString().trim();

        var reg = new RegExp('[ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂẾưăạảấầẩẫậắằẳẵặẹẻẽềềểếỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ]');
        var isVietnamese = false;

        if (reg.test(t)) {
            api = '/api/v1/vocabularies/search/vietnamese?keyword=' + t.toString().trim();
            isVietnamese = true;
        }

        fetch(api)

            .then(function (response) {
                return response.json(); // Bien doi ve doi tuong
            })
            .then(function (result) {
                console.log(result);

                if (result.data.results.length > 0) {
                    if (isVietnamese) {
                        var tmp = '';
                        for (var item of result.data.results) {
                            tmp += item.english + "<br>";
                        }

                        Swal.fire({
                            icon: "success",
                            title: result.data.results.length > 1 ? "Danh sách kết quả" : "Kết quả",
                            html: tmp
                        });
                    }
                    else {
                        Swal.fire({
                            icon: "success",
                            title: "Kết quả",
                            text: result.data.results[0].vietnamese
                        })
                    }
                }
                else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Thông báo',
                        text: `Không tìm thấy từ khóa "${t}"`,
                    })
                }

                clearSelection();
            })
            .catch(function (erro) {
                alert(erro.message);

                clearSelection();
            })


    }

    document.onmouseup = gText;
    if (!document.all) document.captureEvents(Event.MOUSEUP);


</script>

{% yield custom_scrips %}

</body>

</html>
