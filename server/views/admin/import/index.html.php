{% extends admin/master.html.php %}

{% block title %}<?= $shop_name ?? 'SSF' ?> - Admin - Nhập dữ liệu mẫu{% endblock %}

{% block content %}

<div class="my-5">
    <h1 class="h2">Nhập dữ liệu mẫu</h1>
</div>

<div class="min-vh-100">
    <table class="table table-hover table-borderless my-5">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Tiêu đề</th>
            <th scope="col">Mô tả</th>
            <th scope="col" class="w-25">Hành động</th>
        </tr>
        </thead>
        <tbody>
        <tr class="table-info">
            <th scope="row">0</th>
            <td>Nhập dữ liệu hình ảnh</td>
            <td>Đưa ảnh mẫu từ thư mục sample_images vào bảng media</td>
            <td>
                <a href="#" class="btn btn-info w-100 mb-2" data-title="Nhập dữ liệu hình ảnh"
                   data-action="import_sample_image">Nhập</a>
                <a href="#" class="btn btn-danger w-100 mb-2" data-title="Xóa toàn bộ ảnh trong thư mục uploads"
                   data-action="delete_images_in_upload">Xóa ảnh</a>
            </td>
        </tr>
        <tr class="table-secondary">
            <th scope="row">1</th>
            <td>Nhập chủ đề</td>
            <td>Nhập danh sách chủ đề và gắn ảnh ngẫu nhiên</td>
            <td>
                <a href="#" class="btn btn-secondary w-100 mb-2" data-title="Nhập danh sách chủ đề"
                   data-action="import_sample_topic">Nhập</a>
                <a href="#" class="btn btn-secondary w-100 mb-2" data-title="Gắn ảnh vào chủ đề"
                   data-action="attach_media_to_topic">Gắn ảnh</a>
            </td>
        </tr>
        <tr class="table-success">
            <th scope="row">2</th>
            <td>Từ điển Lạc Việt</td>
            <td>
                Bộ từ điển Lạc Việt, bao gồm: <br>
                - 1.000 bộ từ vựng Anh - Việt đầu tiên để test nhanh <br>
                - 50.000 bộ từ vựng Anh - Việt phần 1 <br>
                - 50.000 bộ từ vựng Anh - Việt phần 2 <br>
                - 50.000 bộ từ vựng Anh - Việt phần 3 <br>
                - 50.000 bộ từ vựng Anh - Việt phần 4 <br>
                - Tùy chọn: 50.000 bộ từ vựng Việt - Anh phần 1 <br>
                - Tùy chọn: 50.000 bộ từ vựng Việt - Anh phần 2 <br>
                - Trích xuất nghĩa tiếng Việt gắn vào từ vựng để tạo câu hỏi trắc nghiệm <br>
                - Tùy chọn: gắn ảnh ngẫu nhiên vào từ vựng (tỉ lệ 1/3)
            </td>
            <td>
                <a href="#" class="btn btn-success w-100 mb-2"
                   data-title="Nhập 1000 bộ từ vựng Anh - Việt để test nhanh" data-action="import_first_1000">1.000
                    AV</a>
                <a href="#" class="btn btn-outline-success mb-2 w-100"
                   data-title="Nhập 50.000 bộ từ vựng Anh - Việt phần 1" data-action="import_en_1">50.000 AV - 1</a>
                <a href="#" class="btn btn-outline-success mb-2 w-100"
                   data-title="Nhập 50.000 bộ từ vựng Anh - Việt phần 2" data-action="import_en_2">50.000 AV - 2</a>
                <a href="#" class="btn btn-outline-success mb-2 w-100"
                   data-title="Nhập 50.000 bộ từ vựng Anh - Việt phần 3" data-action="import_en_3">50.000 AV - 3</a>
                <a href="#" class="btn btn-outline-success mb-2 w-100"
                   data-title="Nhập 50.000 bộ từ vựng Anh - Việt phần 4" data-action="import_en_4">50.000 AV - 4</a>
                <a href="#" class="btn btn-outline-success mb-2 w-100"
                   data-title="Nhập 50.000 bộ từ vựng Việt - Anh phần 1" data-action="import_vi_1">50.000 VA - 1</a>
                <a href="#" class="btn btn-outline-success mb-2 w-100"
                   data-title="Nhập 50.000 bộ từ vựng Việt - Anh phần 2" data-action="import_vi_2">50.000 VA - 2</a>
                <a href="#" class="btn btn-success w-100 mb-2" data-title="Trích xuất nghĩa tiếng Việt"
                   data-action="attach_vietnamese_meaning">Tạo nghĩa tiếng
                    Việt</a>
                <a href="#" class="btn btn-success w-100 mb-2" data-title="Gắn ảnh ngẫu nhiên vào từ vựng"
                   data-action="attach_media_to_vocabulary">Gắn ảnh</a>
            </td>
        </tr>
        <tr class="table-warning">
            <th scope="row">3</th>
            <td>Trắc nghiệm ICT</td>
            <td>Bộ trắc nghiệm 400 câu hỏi ôn tập từ trung tâm CNTT.<br>Tùy chọn gắn ảnh ngẫu nhiên vào câu hỏi (tỉ lệ
                1/3)
            </td>
            <td>
                <a href="#" class="btn btn-warning w-100 mb-2" data-title="Nhập bộ câu hỏi ICT"
                   data-action="import_ict">Nhập</a>
                <a href="#" class="btn btn-outline-warning w-100" data-title="Gắn ảnh ngẫu nhiên vào bộ câu hỏi ICT"
                   data-action="attach_media_to_ict">Gắn
                    ảnh</a>
            </td>
        </tr>
        <tr class="table-info">
            <th scope="row">4</th>
            <td>Trắc nghiệm Quizlet</td>
            <td>Bộ 400 câu hỏi trắc nghiệm tiếng Anh Quizlet. <br>Tùy chọn gắn ảnh ngẫu nhiên vào câu hỏi (tỉ lệ 1/3)
            </td>
            <td>
                <a href="#" class="btn btn-info w-100 mb-2" data-title="Nhập bộ câu hỏi Quizlet"
                   data-action="import_quizlet">Nhập</a>
                <a href="#" class="btn btn-outline-info w-100" data-title="Gắn ảnh ngẫu nhiên vào bộ câu hỏi Quizlet"
                   data-action="attach_media_to_quizlet">Gắn
                    ảnh</a>
            </td>
        </tr>
        <tr class="table-danger">
            <th scope="row">5</th>
            <td>Tài khoản người dùng</td>
            <td>Bộ 5.000 tài khoản người dùng</td>
            <td>
                <a href="#" class="btn btn-danger w-100 mb-2" data-title="Nhập tài khoản người dùng"
                   data-action="import_user_account">Nhập</a>
            </td>
        </tr>
        <tr class="table-dark">
            <th scope="row">6</th>
            <td>Tạo bài trắc nghiệm</td>
            <td>Tạo nhanh chóng 10 bài trắc nghiệm từ ngân hàng câu hỏi, tác giả của bài trắc nghiệm là các tài khoản
                Admin. Có thể nhấn tạo nhiều lần để tạo ra nhiều bài trắc nghiệm hơn
            </td>
            <td>
                <a href="#" class="btn btn-light w-100 mb-2" data-title="Tạo 10 bài trắc nghiệm"
                   data-action="gen_10_quizzes">Tạo 10 bài</a>
            </td>
        </tr>
        <tr class="table-primary">
            <th scope="row">7</th>
            <td>Tạo dữ liệu người dùng</td>
            <td>
                Tạo dữ liệu người dùng, bao gồm: <br>
                - Tạo 1.000 bài kiểm tra từ danh sách bài trắc nghiệm có sẵn <br>
                - Tạo 1.000 bài kiểm tra ngẫu nhiên từ ngân hàng câu hỏi <br>
                - Tạo 1.000 bài kiểm tra ngẫu nhiên từ kho từ vựng <br>
            </td>
            <td>
                <a href="#" class="btn btn-primary w-100 mb-2" data-title="Tạo 1000 bài kiểm tra từ người dùng"
                   data-action="gen_1000_quizzes">1000 có
                    sẵn</a>
                <a href="#" class="btn btn-primary w-100 mb-2"
                   data-title="Tạo 1000 bài kiểm tra từ bộ câu hỏi ngẫu nhiên"
                   data-action="gen_1000_quizzes_from_questions">1000 ngẫu nhiên (câu hỏi)</a>
                <a href="#" class="btn btn-primary w-100 mb-2" data-title="Tạo 1000 bài kiểm tra từ kho từ vựng"
                   data-action="gen_1000_quizzes_from_vocabularies">1000
                    ngẫu nhiên (từ vựng)</a>
            </td>
        </tr>
        <tr class="table-warning">
            <th scope="row">8</th>
            <td>Xóa dữ liệu</td>
            <td>Xóa sạch dữ liệu trong CSDL</td>
            <td>
                <a href="#" class="btn btn-danger w-100 mb-2" data-title="Xóa toàn bộ dữ liệu tại các bảng"
                   data-action="delete_data">Xóa</a>
            </td>
        </tr>
        </tbody>
    </table>
</div>

{% endblock %}

{% block custom_scrips %}
<script src="/static/vendor/sweetalert2/sweetalert2@11.js"></script>

<script>
    document.querySelectorAll('td a.btn').forEach(function (buttonElement) {
        buttonElement.addEventListener('click', function (e) {
            e.preventDefault();

            var title = e.currentTarget.dataset.title;
            var action = e.currentTarget.dataset.action;

            Swal.fire({
                title: 'Thông báo',
                text: "Bạn sẽ thực hiện quá trình: \"" + title + "\" vui lòng đợi (dữ liệu nhiều có thể mất vài phút)",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Xác nhận'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('/generate-sample-data?action=' + action, {
                        method: 'GET'
                    })
                        .then(res => res.json())
                        .then(result => {
                            console.log(result)
                            if (result.status === "success") {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Thực hiện thao tác thành công',
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Có lỗi xảy ra',
                                    text: result.message
                                })
                            }
                        })
                        .catch(err => {
                            console.log(err)
                            Swal.fire({
                                icon: 'error',
                                title: 'Có lỗi xảy ra, vui lòng thử lại sau',
                                text: err
                            })
                        })

                    Swal.fire({
                        title: 'Đang thực hiện',
                        didOpen: () => {
                            Swal.showLoading()
                        },
                    })
                }
            })
        })
    })
</script>
{% endblock %}
