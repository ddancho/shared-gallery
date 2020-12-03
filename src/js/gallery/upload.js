function onUpload(action) {
  let uploadForm = document.getElementById('uploadForm');
  uploadForm.setAttribute('action', action);

  uploadForm.addEventListener('submit', function (e) {
    e.preventDefault();

    document
      .getElementById('upload_success')
      .style.setProperty('visibility', 'hidden');

    document
      .getElementById('file_error')
      .style.setProperty('visibility', 'hidden');

    let fileInput = document.getElementById('file');

    let formData = new FormData(this);
    formData.append('file', fileInput.files[0]);

    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function () {
      if (this.readyState === XMLHttpRequest.DONE) {
        if (this.status === 200) {
          const response = JSON.parse(this.response);

          const { msg, errors } = response;

          if (msg) {
            document
              .getElementById('upload_success')
              .style.setProperty('visibility', 'visible');
            document.getElementById('upload_success').innerText = msg;
            document.querySelector('.container__btn-submit').disabled = true;
            window.setTimeout(function () {
              setUploadSuccessHidden();
            }, 3 * 1000);
          }

          if (errors) {
            Object.keys(errors).forEach((element) => {
              let elementId = element + '_error';
              let message = errors[element];

              document
                .getElementById(elementId)
                .style.setProperty('visibility', 'visible');
              document.getElementById(elementId).innerText = message[0];
            });
          }
        } else {
          console.log('Ajax error');
        }
      }
    };

    xmlhttp.open('POST', action);
    xmlhttp.send(formData);
  });
}

const setUploadSuccessHidden = () => {
  document
    .getElementById('upload_success')
    .style.setProperty('visibility', 'hidden');
  document.getElementById('upload_success').innerText = '';
  document.querySelector('.container__btn-submit').disabled = false;
};

export { onUpload };
