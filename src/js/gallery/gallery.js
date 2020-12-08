import { onUpload } from './upload.js';
import { onPublic } from './public.js';
import { onPrivate } from './private.js';

if (document.readyState === 'loading') {
} else {
  document.addEventListener('DOMContentLoaded', (e) => {
    e.preventDefault();

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
        const { page, records, view } = res;

        let galleryContent = document.getElementById('gallery_content');
        galleryContent.innerHTML = view;

        switch (page) {
          case 'public':
            toggleClass(
              records,
              galleryContent,
              'gallery__content-private',
              'gallery__content'
            );
            onPublic();
            break;
          case 'private':
            toggleClass(
              records,
              galleryContent,
              'gallery__content',
              'gallery__content-private'
            );
            onPrivate();
            break;
          case 'upload':
            toggleClass(
              records,
              galleryContent,
              'gallery__content-private',
              'gallery__content'
            );
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

const toggleClass = (anyRecords, element, value, newValue) => {
  if (!anyRecords) {
    if (element.classList.value === value) {
      element.classList.remove(value);
      element.classList.add(newValue);
    }
    //document.querySelector('.nav').style.removeProperty('height');
  } else {
    if (element.classList.value === 'gallery__content-private') {
      element.classList.remove('gallery__content-private');
      element.classList.add('gallery__content');
    }
    //document.querySelector('.nav').style.setProperty('height', 'calc(100vh - 3.2rem)');
  }
};
