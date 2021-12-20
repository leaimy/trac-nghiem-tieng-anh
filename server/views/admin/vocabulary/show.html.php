{% extends admin/master.html.php %}

{% block title %}<?= $shop_name ?? 'SSF' ?> - Admin - Chi tiết từ vựng{% endblock %}

{% block content %}

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Chi tiết từ vựng</h1>
</div>


<div class="min-vh-100">
    <div class="d-flex justify-content-end">
        <a href="/admin/vocabularies" class="btn btn-outline-info">Quay lại</a>
    </div>
    <div class="row justify-content-center">
        <div class="col-6">
            <div class="accordion" id="accordionPanelsStayOpenExample">
                <div class="accordion-item ">
                    <h2 class="accordion-header" id="panelsStayOpen-headingOne" >
                        <button style="color: #c926c7; font-weight: bold;" class="accordion-button " type="button" data-bs-toggle="collapse"
                                data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true"
                                aria-controls="panelsStayOpen-collapseOne">
                            Tiếng anh
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show"
                         aria-labelledby="panelsStayOpen-headingOne">
                        <div class="accordion-body text-secondary fs-6">
                            <?= $vocabulary->english ?>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header " id="panelsStayOpen-headingSix">
                        <button style="color: #417ff2; font-weight: bold;" class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#panelsStayOpen-collapseSix" aria-expanded="false"
                                aria-controls="panelsStayOpen-collapseSix">
                            Tiếng Việt
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseSix" class="accordion-collapse collapse"
                         aria-labelledby="panelsStayOpen-headingSix">
                        <div class="accordion-body text-secondary fs-6">
                           <?= $vocabulary->vietnamese!=null?$vocabulary->vietnamese:'[Không có dữ liệu]'; ?>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                        <button style="color: #41f2ae; font-weight: bold;" class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false"
                                aria-controls="panelsStayOpen-collapseThree">
                            Loại từ
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse"
                         aria-labelledby="panelsStayOpen-headingThree">
                        <div class="accordion-body">
                            <?php foreach ($vocabulary->get_topics() as $topic): ?>
                                <?= $topic->get_html_box() ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="panelsStayOpen-headingFour">
                        <button style="color: #eb6aa1; font-weight: bold;" class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="false"
                                aria-controls="panelsStayOpen-collapseFour">
                            Mô tả
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse"
                         aria-labelledby="panelsStayOpen-headingFour">
                        <div class="accordion-body text-secondary fs-6">
                           <?= $vocabulary->description ?>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="panelsStayOpen-headingFive">
                        <button style="color: #c94426; font-weight: bold;" class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#panelsStayOpen-collapseFive" aria-expanded="true"
                                aria-controls="panelsStayOpen-collapseFive">
                            Hình ảnh
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseFive" class="accordion-collapse collapse show"
                         aria-labelledby="panelsStayOpen-headingFive">
                        <div class="accordion-body d-flex justify-content-center">
                            <img style="height: 100px;"
                                 src="<?= $vocabulary->get_media_path() == null ? '/uploads/macdinh.jpg' : $vocabulary->get_media_path() ?>"
                                 alt="">
                        </div>
                    </div>
                </div>
              
            </div>
        </div>
    </div>

</div>

{% endblock %}

