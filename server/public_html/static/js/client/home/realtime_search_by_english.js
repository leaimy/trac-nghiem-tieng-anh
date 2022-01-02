window.addEventListener('DOMContentLoaded', function () {
  var form_en = document.getElementById('search_form_en');
  var input_en = document.getElementById('txtEnglish');
  var container = document.getElementById('container');
  var isShow = true;

  var apiUrl_en = `/api/v1/vocabularies/search/english?keyword=`;

  form_en.addEventListener('submit', function (e) {
    e.preventDefault();
  })

  var timeOutID;
  input_en.addEventListener('input', function (e) {

    var value_en = input_en.value;
    isShow = true;

    if (!value_en) {
      clearTimeout(timeOutID);
      container.innerHTML = '';
      isShow = false;
      return;
    }

    var api = apiUrl_en + value_en;

    clearTimeout(timeOutID);
    timeOutID = setTimeout(function () {
      container.innerHTML = `
        <div class="d-flex justify-content-center">
            <div class="spinner-grow text-success" role="status">
                <span class="visually-hidden">Đang tìm kiếm...</span>
            </div>
        </div>            
      `;
      
      container.style = ``;

      fetch(api, {
        method: 'GET',
      })

        .then(response => response.json()) // biến thành một đối tượng
        .then(result => {
          console.log(result);

          var results = result.data.results;

          container.style = '';

          if (results.length >= 4) {
            container.style = `max-height: 400px; overflow-y: scroll; padding-right: 15px;`;
          }

          var html = '';

          if (results.length <= 0) {
            html = `<div class="alert alert-danger text-center" id="not-found-box">Không tìm thấy kết quả</div>`;
          } else {
            for (var item of results) {
              var itemHTML = `
                            <div class="accordion-item">
                 <h2 class="accordion-header" id="flush-heading${item.id}">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse${item.id}" aria-expanded="false" aria-controls="flush-collapse${item.id}">
                       <div class="d-flex w-100 align-items-center justify-content-start">
                          <div class="">
                             <img class="me-3"
                                src="${item.media.media_path}"
                                width="50" height="50" alt="">
                          </div>
                          <div class="">
                             ${item.english}
                          </div>
                       </div>
                    </button>
                 </h2>
                 <div id="flush-collapse${item.id}" class="accordion-collapse collapse" aria-labelledby="flush-heading${item.id}" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">${item.description.toString().replaceAll("\n", "<br>")}</div>
                 </div>
              </div>      
                    `;

              html += itemHTML;
            }
          }

          if (isShow) {
            container.innerHTML = html;
          }
        })
        .catch(err => {
          alert(err.message)
        })

    }, 500)
  })
})
