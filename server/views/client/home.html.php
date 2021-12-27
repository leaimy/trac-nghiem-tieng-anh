{% extends client/master.html.php %}

{% block title %}<?= $shop_name ?? 'SSF' ?> - Trang chủ{% endblock %}

{% block custom_styles %}
<link rel="stylesheet" href="/static/vendor/select2/select2.min.css">
<script src="/static/vendor/jquery/jquery.min.js"></script>
<script src="/static/vendor/select2/select2.min.js"></script>
{% endblock %}

{% block content %}
<div class="container-fluid mx-0 px-0 d-none d-md-block">
    <div
        id="carouselExampleIndicators"
        class="carousel slide"
        data-bs-ride="carousel"
    >
        <div class="carousel-indicators">
            <button
                type="button"
                data-bs-target="#carouselExampleIndicators"
                data-bs-slide-to="0"
                class="active"
                aria-current="true"
                aria-label="Slide 1"
            ></button>
            <button
                type="button"
                data-bs-target="#carouselExampleIndicators"
                data-bs-slide-to="1"
                aria-label="Slide 2"
            ></button>
            <button
                type="button"
                data-bs-target="#carouselExampleIndicators"
                data-bs-slide-to="2"
                aria-label="Slide 3"
            ></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img
                    style="object-fit: cover"
                    src="/static/images/slider1.jpg"
                    class="d-block w-100"
                    height="400px"
                    alt="..."
                />
            </div>
            <div class="carousel-item">
                <img
                    style="object-fit: cover"
                    src="/static/images/slider2.jpg"
                    class="d-block w-100"
                    height="400px"
                    alt="..."
                />
            </div>
            <div class="carousel-item">
                <img
                    style="object-fit: cover"
                    src="/static/images/slider3.jpg"
                    class="d-block w-100"
                    height="400px"
                    alt="..."
                />
            </div>
        </div>
        <button
            class="carousel-control-prev"
            type="button"
            data-bs-target="#carouselExampleIndicators"
            data-bs-slide="prev"
        >
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button
            class="carousel-control-next"
            type="button"
            data-bs-target="#carouselExampleIndicators"
            data-bs-slide="next"
        >
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>

<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <h1 class="text-center my-4">
                Tra cứu từ vựng
            </h1>

            <div class="row my-4 justify-content-center">
                <div class="col-md-6">
                    <form action="/" method="GET" class="input-group mb-3">
                        <input type="hidden" name="action" value="search">
                        <input type="hidden" name="by" value="english">
                        <input type="text" class="form-control me-2" name="keyword"
                               placeholder="Nhập từ khóa tiếng anh..." autocomplete="off">
                        <button class="btn btn-outline-danger" type="submit">Tìm kiếm</button>
                    </form>
                </div>
            </div>

            <div class="row my-4 justify-content-center">
                <div class="col-md-6">
                    <div class="list-group">
                        <?php foreach ($vocabulary_all as $vocabulary): ?>
                            <a href="/vocabulary/show?id=<?= $vocabulary->id ?>"
                               class="text-decoration-none">
                                <div class="alert alert-primary d-flex align-items-center" role="alert">
                                    <img class="me-3"
                                         src="<?= $vocabulary->get_media_path() == null ? '/uploads/macdinh.jpg' : $vocabulary->get_media_path() ?>"
                                         width="50" height="50" alt="">
                                    <div>
                                        <?= ucfirst($vocabulary->english) ?>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <h1 class="text-center my-4">
                Tra cứu theo mô tả
            </h1>

            <div class="row my-4 justify-content-center">
                <div class="col-md-6">
                    <form action="/" method="GET" class="input-group mb-3" id="search_form_vn">
                        <input type="hidden" name="action" value="search">
                        <input type="hidden" name="by" value="english">
                        <input id="txtVietnamese" type="text" class="form-control me-2" name="keyword"
                               placeholder="Nhập mô tả tiếng việt..." autocomplete="off">
                    </form>
                </div>
            </div>

            <div class="row my-4 justify-content-center">
                <div class="col-md-6">
                    <div class="list-group" id="result-container">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <h1 class="text-center my-4">
                Chủ đề
            </h1>

            <div class="row mt-5 justify-content-center justify-content-lg-start">
                <?php foreach ($topics as $topic): ?>
                    <div class="col-sm-10 col-md-6 col-lg-5 col-xxl-3 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-capitalize"><?= $topic->title ?></h5>
                                <p class="card-text"><?= $topic->description ?></p>

                                <a href="/quizzes/by_topic?topic_id=<?= $topic->id ?>" class="btn btn-primary btn-sm">Giải
                                    đề</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <h1 class="text-center my-4">
                Tạo bài trắc nghiệm ngẫu nhiên
            </h1>

            <div class="row mt-5 justify-content-center">
                <div class="col-sm-10 col-md-8">
                    <form action="/quizzes/random" method="POST">
                        <div class="mb-3">
                            <label for="topics" class="form-label">Chọn chủ đề</label>
                            <select name="topics[]" id="topics" class="form-select" multiple>
                                <?php foreach ($topics as $topic): ?>
                                    <option value="<?= $topic->id ?>"><?= $topic->title ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="types" class="form-label">Chọn loại câu hỏi</label>
                            <select name="types[]" id="types" class="form-select" multiple>
                                <?php foreach ($types as $key => $value): ?>
                                    <option value="<?= $key ?>"><?= $value ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="question_quantity" class="form-label">Số câu hỏi</label>
                            <input min="1" max="100" type="number" name="question_quantity" id="question_quantity"
                                   class="form-control" value="10">
                        </div>

                        <button class="mt-4 mb-5 btn btn-success">Tạo và làm ngay</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <h1 class="text-center my-4">
                ôn tập từ vựng
            </h1>

            <div class="row mt-5 justify-content-center">
                <div class="col-sm-10 col-md-8">
                    <form action="/quizzes/vocabulary_practice" method="POST">
                        <div class="mb-3">
                            <label for="v_topic" class="form-label">Chọn chủ đề</label>
                            <select name="topic" id="v_topic" class="form-select">
                                <?php foreach ($topics as $topic): ?>
                                    <option value="<?= $topic->id ?>"><?= $topic->title ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="question_quantity" class="form-label">Số câu hỏi</label>
                            <input min="1" max="100" type="number" name="question_quantity" id="question_quantity"
                                   class="form-control" value="10">
                        </div>

                        <button class="mt-4 mb-5 btn btn-success">Tạo và làm ngay</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-5 mb-5">
    <div class="card">
        <div class="card-body">
            <h1 class="text-center my-4">Giải đề trắc nghiệm</h1>

            <div class="row mt-5 justify-content-center">
                <?php foreach ($quizzes as $index => $quiz): ?>

                    <div class="col-sm-10 col-md-6 col-lg-5 col-xxl-3 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Đề <?= $index + 1 ?> <?= $quiz->title ?></h5>
                                <p class="card-text"><?= $quiz->description ?></p>
                                <a href="/quizzes/take-quiz?quiz_id=<?= $quiz->id ?>" class="btn btn-primary">Làm
                                    ngay</a>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
{% endblock %}

{% block custom_scrips %}
<script>
    $(document).ready(function () {
        $('#topics').select2();
        $('#v_topic').select2();
        $('#types').select2();
    });
</script>

<script>
    window.addEventListener('DOMContentLoaded', function () {
        var form = document.getElementById('search_form_vn');
        var input = document.getElementById('txtVietnamese');
        var resultContainer = document.getElementById('result-container');

        var apiUrl = `/api/v1/vocabularies/search/vietnamese?keyword=`;

        form.addEventListener('submit', function (e) {
            e.preventDefault();
        })

        // Realtime search | debouce 
        var timeOutID;
        input.addEventListener('input', function (e) {
            var value = input.value;
            
            if (value.length === 0) return;

            var api = apiUrl + value;

            clearTimeout(timeOutID);
            timeOutID = setTimeout(function () {
                resultContainer.innerHTML = `
                        <div class="d-flex justify-content-center">
                            <div class="spinner-grow text-info" role="status">
                                <span class="visually-hidden">Đang tìm kiếm...</span>
                            </div>
                        </div>            
                `;
                resultContainer.style = ``;

                fetch(api, {
                    method: 'GET',
                })
                    .then(response => response.json())
                    .then(result => {
                        console.log(result);

                        var results = result.data.results;
                        if (results.length === 0) resultContainer.style = '';

                        var html = '';

                        for (var item of results) {
                            var itemHTML = `
                            <a href="/vocabulary/show?id=${item.id}"
                               class="text-decoration-none">
                                <div class="alert alert-primary d-flex align-items-center" role="alert">
                                    <img class="me-3"
                                         src="${item.media.media_path}"
                                         width="50" height="50" alt="">
                                    <div>
                                        ${item.english}
                                    </div>
                                </div>
                            </a>                    
                    `;

                            html += itemHTML;
                        }

                        resultContainer.innerHTML = html;
                        resultContainer.style = `height: 400px; overflow-y: scroll; padding-right: 15px;`;
                    })
                    .catch(err => {
                        alert(err.message)
                    })
            }, 500)
        })
    })
</script>
{% endblock %}
