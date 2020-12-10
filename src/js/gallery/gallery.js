import { onUpload } from './upload.js';
import { onPublic } from './public.js';
import { onPrivate } from './private.js';

if (document.readyState === 'loading') {
} else {
  document.addEventListener('DOMContentLoaded', (e) => {
    e.preventDefault();

    let view = document.getElementById('view_type');
    document.getElementById('gallery_content').classList.add(view.value);

    let sort = document.getElementById('sort_type');
    sort.add(new Option('Uploader', 'uploader'));

    document
      .getElementById('south_arrow')
      .classList.toggle('nav__select-arrow-active');

    let element = document.getElementById('public');
    element.focus();

    let action = element.getAttribute('action');
    request(action, 'GET', false);
  });
}

document.querySelector('.nav__expand').addEventListener('click', () => {
  document.querySelector('.nav').classList.toggle('nav-closed');
});

let listItems = document.querySelectorAll('.nav__listitem');

listItems.forEach((item) => {
  item.addEventListener('click', () => setItemActive(item));
});

const setItemActive = (item) => {
  listItems.forEach((listItem) => {
    listItem.classList.remove('nav__listitem-active');
  });

  item.classList.add('nav__listitem-active');
};

document.getElementById('view_type').addEventListener('change', function (e) {
  e.preventDefault();

  let classToAdd = this.value;
  let classToRemove = Array.from(this.options).find(
    (option) => option.value !== classToAdd
  ).value;

  document.getElementById('gallery_content').classList.remove(classToRemove);
  document.getElementById('gallery_content').classList.add(classToAdd);
});

document.getElementById('south_arrow').addEventListener('click', function (e) {
  e.preventDefault();

  if (this.classList.length === 0) {
    document
      .getElementById('north_arrow')
      .classList.toggle('nav__select-arrow-active');
    this.classList.toggle('nav__select-arrow-active');
  }
});

document.getElementById('north_arrow').addEventListener('click', function (e) {
  e.preventDefault();

  if (this.classList.length === 0) {
    document
      .getElementById('south_arrow')
      .classList.toggle('nav__select-arrow-active');
    this.classList.toggle('nav__select-arrow-active');
  }
});

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

document.getElementById('public').addEventListener('click', function (e) {
  e.preventDefault();

  let action = this.getAttribute('action');
  request(action, 'GET', false);
});

document.getElementById('private').addEventListener('click', function (e) {
  e.preventDefault();

  let action = this.getAttribute('action');
  request(action, 'GET', false);
});

document.getElementById('upload').addEventListener('click', function (e) {
  e.preventDefault();

  let action = this.getAttribute('action');
  request(action, 'GET', false);
});

const request = (action, type, processData) => {
  app.request(
    {
      type,
      action,
      success: (res) => {
        const { page, view } = res;

        let galleryContent = document.getElementById('gallery_content');
        galleryContent.innerHTML = view;

        switch (page) {
          case 'public':
            onPublic(action, fixGalleryViewType);
            break;
          case 'private':
            onPrivate(action, fixGalleryViewType);
            break;
          case 'upload':
            onUpload(action);
            break;
        }
      },
      error: (res) => {
        alert(res);
      },
    },
    processData
  );
};
