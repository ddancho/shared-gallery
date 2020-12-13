const simulateMouseClick = () => {
  let aElement = document.querySelector('.nav__listitem-active a');
  let id = aElement.getAttribute('id');

  const event = new MouseEvent('click', {
    view: window,
    bubbles: true,
  });

  let page = document.getElementById(id);
  page.dispatchEvent(event);
};

const fixGalleryViewType = () => {
  let gallery = document.getElementById('gallery_content');
  let viewType = document.getElementById('view_type');
  let options = Array.from(viewType.options);

  let view = Array.from(gallery.classList).find(
    (view) => view === viewType.value
  );

  if (view === undefined) {
    let classToRemove = options.find((view) => view.value != viewType.value);
    gallery.classList.remove(classToRemove.value);
    gallery.classList.add(viewType.value);
  }
};

const getSortByValue = () => {
  return document.getElementById('sort_type').value;
};

const getSortByDirection = () => {
  let direcElement = document.querySelector('.nav__select-arrow-active');

  return direcElement.getAttribute('value');
};

const getImagesPerPageValue = () => {
  return document.getElementById('img_per_page_type').value;
};

export {
  simulateMouseClick,
  fixGalleryViewType,
  getSortByValue,
  getSortByDirection,
  getImagesPerPageValue,
};
