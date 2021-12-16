{% extends client/master.html.php %}

{% block title %}<?= $shop_name ?? 'SSF' ?> - Trang chủ{% endblock %}

{% block content %}
<div class="container mt-5 mb-5">
    <h1 class="text-center my-4">Trắc nghiệm ngẫu nhiên</h1>

    <div class="row mt-5 justify-content-center">
        <div class="col-sm-10 col-md-8 col-lg-8 col-xxl-6 mb-6">
            <div class="card">
                <div class="card-header">Thông tin đề</div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Số lượng câu hỏi: 40</li>
                    <li class="list-group-item">Điểm cao nhất đã đạt: 650</li>
                    <li class="list-group-item">Mô tả thêm về đề</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row mt-5 justify-content-center">
        <div class="col-sm-10 col-md-8 col-lg-8 col-xxl-6 mb-6">
            <div class="card">
                <div class="card-header">
                    Câu 01: I was sickened _____ the sight.
                </div>
                <div class="card-body">
                    <div class="form-check">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="flexRadioDefault"
                            id="flexRadioDefault1"
                            checked
                        />
                        <label class="form-check-label" for="flexRadioDefault1">
                            Default radio
                        </label>
                    </div>
                    <div class="form-check">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="flexRadioDefault"
                            id="flexRadioDefault2"
                        />
                        <label class="form-check-label" for="flexRadioDefault2">
                            Default checked radio
                        </label>
                    </div>
                    <div class="form-check">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="flexRadioDefault"
                            id="flexRadioDefault3"
                        />
                        <label class="form-check-label" for="flexRadioDefault3">
                            Default checked radio
                        </label>
                    </div>
                    <div class="form-check">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="flexRadioDefault"
                            id="flexRadioDefault4"
                        />
                        <label class="form-check-label" for="flexRadioDefault4">
                            Default checked radio
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5 justify-content-center">
        <div class="col-sm-10 col-md-8 col-lg-8 col-xxl-6 mb-6">
            <div class="card">
                <div class="card-header">
                    Câu 02: I was sickened _____ the sight.
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <img src="https://picsum.photos/id/231/150/150" alt=""/>
                        </div>
                        <div class="col-7 align-self-center">
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="radio"
                                    name="flexRadioDefault1"
                                    id="cau2a"
                                    checked
                                />
                                <label class="form-check-label" for="cau2a">
                                    Default radio
                                </label>
                            </div>
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="radio"
                                    name="flexRadioDefault1"
                                    id="cau2b"
                                />
                                <label class="form-check-label" for="cau2b">
                                    Default checked radio
                                </label>
                            </div>
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="radio"
                                    name="flexRadioDefault1"
                                    id="cau2c"
                                />
                                <label class="form-check-label" for="cau2c">
                                    Default checked radio
                                </label>
                            </div>
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="radio"
                                    name="flexRadioDefault1"
                                    id="cau2d"
                                />
                                <label class="form-check-label" for="cau2d">
                                    Default checked radio
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-5 justify-content-center">
        <div class="col-sm-10 col-md-8 col-lg-8 col-xxl-6 mb-6">
            <div class="card">
                <div class="card-header">
                    Câu 03: I was sickened _____ the sight.
                    <button><i class="fas fa-volume-up"></i></button>
                </div>
                <div class="card-body">
                    <div class="form-check">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="cau3"
                            id="cau3-1"
                            checked
                        />
                        <label class="form-check-label" for="cau3-1">
                            Default radio
                        </label>
                    </div>
                    <div class="form-check">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="cau3"
                            id="cau3-2"
                        />
                        <label class="form-check-label" for="cau3-2">
                            Default checked radio
                        </label>
                    </div>
                    <div class="form-check">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="cau3"
                            id="cau3-3"
                        />
                        <label class="form-check-label" for="cau3-3">
                            Default checked radio
                        </label>
                    </div>
                    <div class="form-check">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="cau3"
                            id="cau3-4"
                        />
                        <label class="form-check-label" for="cau3-4">
                            Default checked radio
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-5 justify-content-center">
        <div class="col-sm-10 col-md-8 col-lg-8 col-xxl-6 mb-6">
            <div class="card">
                <div class="card-header">Câu 04: Fill blank.</div>
                <div class="card-body">
                    <div class="text-center">
                        Lorem ipsum
                        <input type="text" class="form-control d-inline-block mx-2" style="width: 100px;"/> donor
                        sit hamet
                        <input type="text" class="form-control d-inline-block mx-2" style="width: 100px;"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-5 justify-content-center">
        <div class="col-sm-10 col-md-8 col-lg-8 col-xxl-6 mb-6">
            <div class="card">
                <div class="card-header">
                    Câu 05: I was sickened _____ the sight.
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <img src="https://picsum.photos/id/222/150/150" alt=""/>
                        </div>
                        <div class="col-7 align-self-center">
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    value=""
                                    id="flexCheckChecked"
                                    checked
                                />
                                <label class="form-check-label" for="flexCheckChecked">
                                    Checked checkbox
                                </label>
                            </div>
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    value=""
                                    id="flexCheckChecked2"
                                />
                                <label class="form-check-label" for="flexCheckChecked2">
                                    Checked checkbox
                                </label>
                            </div>
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    value=""
                                    id="flexCheckChecked3"
                                    checked
                                />
                                <label class="form-check-label" for="flexCheckChecked3">
                                    Checked checkbox
                                </label>
                            </div>
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    value=""
                                    id="flexCheckChecked4"
                                />
                                <label class="form-check-label" for="flexCheckChecked4">
                                    Checked checkbox
                                </label>
                            </div>
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    value=""
                                    id="flexCheckChecked5"
                                />
                                <label class="form-check-label" for="flexCheckChecked5">
                                    Checked checkbox
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-5 justify-content-center">
        <div class="col-sm-10 col-md-8 col-lg-8 col-xxl-6 mb-6">
            <div class="card">
                <div class="card-header">
                    Câu 06: Sắp xếp lại thứ tự để tạo ra câu đúng.
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-2 border border-secondary rounded">One</div>
                        <div class="col-2 border border-secondary rounded">Two</div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-2 border border-secondary rounded">Five</div>
                        <div class="col-2 border border-secondary rounded">Four</div>
                        <div class="col-2 border border-secondary rounded">Six</div>
                        <div class="col-2 border border-secondary rounded">Three</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4 mb-3">
        <div class="col d-flex justify-content-center">
            <nav aria-label="...">
                <ul class="pagination">
                    <li class="page-item ">
                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true"><<</a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item " aria-current="page">
                        <a class="page-link" href="#">2</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">>></a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>

{% endblock %}

