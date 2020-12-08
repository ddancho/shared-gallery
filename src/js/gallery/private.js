function onPrivate() {
  let images = document.querySelectorAll('.container');

  images.forEach((image) => {
    let img = image.querySelector('.card__image');
    let src = img.getAttribute('src');

    let btn = image.querySelector('.container__btn-submit');
    btn.addEventListener('click', () => {
      let tab = window.open();
      tab.document.body.innerHTML = "<img src='" + src + "'>";
    });
  });
}

export { onPrivate };
