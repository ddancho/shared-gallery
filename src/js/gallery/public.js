function onPublic(orgAction, cb) {
  cb();

  if (document.getElementById('view_type').disabled) {
    document.getElementById('view_type').disabled = false;
    document.getElementById('sort_type').disabled = false;
    document.getElementById('img_per_page_type').disabled = false;
  }

  let sort = document.getElementById('sort_type');
  let options = Array.from(sort.options);
  let option = options.find((option) => option.value === 'uploader');
  if (option === undefined) {
    sort.add(new Option('Uploader', 'uploader'));
  }

  let images = document.querySelectorAll('.container');
  let action = orgAction.replace('publicGallery', 'getImage');

  images.forEach((image) => {
    let img = image.querySelector('.card__image');

    if (img) {
      let id = img.getAttribute('id');

      let btn = image.querySelector('.container__btn-submit');
      btn.addEventListener('click', () => {
        let tab = window.open();

        request(action, 'POST', id, tab);
      });
    }
  });
}

const request = (action, type, id, tab) => {
  app.request({
    data: {
      id,
    },
    type,
    action,
    success: (res) => {
      const { src } = res;

      tab.document.body.innerHTML =
        "<img src='" + src + '\' alt="Image Resource Not Found" >';
    },
    error: (res) => {
      alert(res);
    },
  });
};

export { onPublic };
