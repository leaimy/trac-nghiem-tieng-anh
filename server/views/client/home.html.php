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
                Ôn tập từ vựng thông qua các bài trắc nghiệm ngẫu nhiên
            </h1>

            <div class="row mt-5 justify-content-center justify-content-lg-start">
                <div class="col-sm-10 col-md-6 col-lg-5 col-xxl-3 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Danh từ</h5>
                            <p class="card-text">
                                Danh từ trong tiếng Anh dùng để chỉ ...
                            </p>
                            <a href="/quiz/quizzes" class="btn btn-primary">Ôn tập ngay</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-10 col-md-6 col-lg-5 col-xxl-3 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Động từ</h5>
                            <p class="card-text">
                                Làm các bài trắc nghiệm liên quand đến từ vựng thuộc loại
                                động từ
                            </p>
                            <a href="#" class="btn btn-primary">Ôn tập ngay</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-10 col-md-6 col-lg-5 col-xxl-3 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Tính từ</h5>
                            <p class="card-text">
                                With supporting text below as a natural lead-in to
                                additional content.
                            </p>
                            <a href="#" class="btn btn-primary">Ôn tập ngay</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-10 col-md-6 col-lg-5 col-xxl-3 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Giới từ</h5>
                            <p class="card-text">
                                With supporting text below as a natural lead-in to
                                additional content.
                            </p>
                            <a href="#" class="btn btn-primary">Ôn tập ngay</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-10 col-md-6 col-lg-5 col-xxl-3 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Đại từ</h5>
                            <p class="card-text">
                                With supporting text below as a natural lead-in to
                                additional content.
                            </p>
                            <a href="#" class="btn btn-primary">Ôn tập ngay</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-10 col-md-6 col-lg-5 col-xxl-3 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Đại từ</h5>
                            <p class="card-text">
                                With supporting text below as a natural lead-in to
                                additional content.
                            </p>
                            <a href="#" class="btn btn-primary">Ôn tập ngay</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4 mb-3">
                <div class="col d-flex justify-content-center">
                    <a href="" class="btn btn-primary">Xem thêm các chủ đề khác...</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-5 mb-5">
    <div class="card">
        <div class="card-body">
            <h1 class="text-center my-4">Giải đề trắc nghiệm tiếng Anh</h1>

            <div class="row mt-5 justify-content-center justify-content-lg-start">
                <div class="col-sm-10 col-md-6 col-lg-5 col-xxl-3 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Đề 01</h5>
                            <p class="card-text">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                Similique provident debitis sapiente harum distinctio
                                nesciunt, dolore neque et natus. Dicta.
                            </p>
                            <a href="#" class="btn btn-primary">Làm ngay</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-10 col-md-6 col-lg-5 col-xxl-3 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Đề 02</h5>
                            <p class="card-text">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                Quisquam maiores facilis numquam commodi saepe? Vel!
                            </p>
                            <a href="#" class="btn btn-primary">Làm ngay</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-10 col-md-6 col-lg-5 col-xxl-3 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Đề 03</h5>
                            <p class="card-text">
                                With supporting text below as a natural lead-in to
                                additional content.
                            </p>
                            <a href="#" class="btn btn-primary">Làm ngay</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-10 col-md-6 col-lg-5 col-xxl-3 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Đề 04</h5>
                            <p class="card-text">
                                With supporting text below as a natural lead-in to
                                additional content.
                            </p>
                            <a href="#" class="btn btn-primary">Làm ngay</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-10 col-md-6 col-lg-5 col-xxl-3 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Đề 05</h5>
                            <p class="card-text">
                                With supporting text below as a natural lead-in to
                                additional content.
                            </p>
                            <a href="#" class="btn btn-primary">Làm ngay</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-10 col-md-6 col-lg-5 col-xxl-3 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Đề 06</h5>
                            <p class="card-text">
                                With supporting text below as a natural lead-in to
                                additional content.
                            </p>
                            <a href="#" class="btn btn-primary">Làm ngay</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4 mb-3">
                <div class="col d-flex justify-content-center">
                    <a href="" class="btn btn-primary"
                    >Xem thêm các đề trắc nghiệm khác...</a
                    >
                </div>
            </div>
        </div>
    </div>
</div>
{% endblock %}

