window.addEventListener('DOMContentLoaded', function () {
  var form = document.getElementById('search_form_vn');
  var input = document.getElementById('txtVietnamese');
  var resultContainer = document.getElementById('result-container');
  var isShow = true;

  var apiUrl = `/api/v1/vocabularies/search/vietnamese?keyword=`;

  form.addEventListener('submit', function (e) {
    e.preventDefault();
  })

  // Realtime search | debouce 
  var timeOutID;
  input.addEventListener('input', function (e) {
    var value = input.value;
    isShow = true

    if (value.length === 0) {
      clearTimeout(timeOutID)
      resultContainer.innerHTML = '';
      isShow = false;
      return;
    }

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
          if (results.length === 0) {
          }
          resultContainer.style = '';

          if (results.length >= 4) {
            resultContainer.style = `max-height: 400px; overflow-y: scroll; padding-right: 15px;`;
          }

          var html = '';

          if (results.length === 0) {
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

          if (isShow)
            resultContainer.innerHTML = html;
        })
        .catch(err => {
          alert(err.message)
        })
    }, 500)
  })
})
