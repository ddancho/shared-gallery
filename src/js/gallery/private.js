import { getImagesPerPageValue } from './helpers.js';

function onPrivate(pageAction, records, cb) {
  cb();

  if (document.getElementById('view_type').disabled) {
    document.getElementById('view_type').disabled = false;
    document.getElementById('sort_type').disabled = false;
    document.getElementById('img_per_page_type').disabled = false;
  }

  const { page, totalRecords } = records;
  const ipp = getImagesPerPageValue();
  let pageDown = document.getElementById('west_arrow');
  let pageUp = document.getElementById('east_arrow');

  if (page > 1) {
    pageDown
      .closest('.nav__select-arrow-l-r')
      .style.setProperty('visibility', 'visible');
  } else {
    pageDown
      .closest('.nav__select-arrow-l-r')
      .style.setProperty('visibility', 'hidden');
  }

  if (page * ipp < totalRecords) {
    pageUp
      .closest('.nav__select-arrow-l-r')
      .style.setProperty('visibility', 'visible');
  } else {
    pageUp
      .closest('.nav__select-arrow-l-r')
      .style.setProperty('visibility', 'hidden');
  }

  let sort = document.getElementById('sort_type');
  let options = Array.from(sort.options);
  let option = options.find((option) => option.value === 'uploader');
  if (option) {
    option.remove();
  }

  let imagesPublic = document.querySelectorAll('.container');
  let imagesPrivate = document.querySelectorAll('.container__private');
  let base = pageAction.replace('privateGallery', '');

  let images = [...imagesPublic, ...imagesPrivate];

  images.forEach((image) => {
    let img = image.querySelector('.card__image');
    if (img) {
      let id = img.getAttribute('id');

      let btns = Array.from(
        image.querySelectorAll(
          '.container__btn-submit.container__btn-submit-row'
        )
      );

      btns.forEach((btn) => {
        if (btn.name === 'view') {
          btn.addEventListener('click', () => {
            let tab = window.open();
            let action = base + 'getImage';

            request(action, 'POST', id, tab);
          });
        } else {
          // let modal = document.querySelector('.gallery__content__modal');
          // modal.style.setProperty('visibility', 'visible');
          // modal.style.setProperty('opacity', '1');
          // document.body.style.setProperty('overflow-y', 'hidden');
          btn.addEventListener('click', () => {
            let action = base + 'updateImageView';

            request(action, 'POST', id);
          });
        }
      });
    }
  });
}

const request = (action, type, id, tab = null) => {
  app.request({
    data: {
      id,
    },
    type,
    action,
    success: (res) => {
      const { src, msg } = res;
      if (msg) {
        console.log(msg);
      }

      if (src) {
        tab.document.body.innerHTML =
          "<img src='" + src + '\' alt="Image Resource Not Found" >';
      }
    },
    error: (res) => {
      alert(res);
    },
  });
};

export { onPrivate };
