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
                    src="https://picsum.photos/id/28/1200/300"
                    class="d-block w-100"
                    alt="..."
                />
            </div>
            <div class="carousel-item">
                <img
                    src="https://picsum.photos/id/256/1200/300"
                    class="d-block w-100"
                    alt="..."
                />
            </div>
            <div class="carousel-item">
                <img
                    src="https://picsum.photos/id/266/1200/300"
                    class="d-block w-100"
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

            <div class="row mt-5 justify-content-center justify-content-lg-start">
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
{% endblock %}
