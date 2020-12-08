function onPrivate() {
  let imagesPublic = document.querySelectorAll('.container');
  let imagesPrivate = document.querySelectorAll('.container__private');

  let images = [...imagesPublic, ...imagesPrivate];

  images.forEach((image) => {
    let img = image.querySelector('.card__image');
    if (img) {
      let src = img.getAttribute('src');

      let btn = image.querySelector('.container__btn-submit');
      btn.addEventListener('click', () => {
        let tab = window.open();
        tab.document.body.innerHTML = "<img src='" + src + "'>";
      });
    }
  });
}

export { onPrivate };
