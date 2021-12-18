{% extends client/master.html.php %}

{% block title %}<?= $shop_name ?? 'SSF' ?> - Trang chủ{% endblock %}

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

                                <a href="" class="btn btn-outline-primary btn-sm">Ngẫu nhiên</a>
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
                                <a href="/quizzes/take-quiz?quiz_id=<?= $quiz->id ?>" class="btn btn-primary">Làm ngay</a>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
{% endblock %}

