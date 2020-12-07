import { onUpload } from './upload.js';
import { onPublic } from './public.js';

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
        const { page, view } = res;
        document.getElementById('gallery_content').innerHTML = view;

        switch (page) {
          case 'public':
            onPublic();
            break;
          case 'private':
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
