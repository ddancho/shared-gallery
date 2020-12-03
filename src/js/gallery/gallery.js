import { onUpload } from './upload.js';

if (document.readyState === 'loading') {
} else {
  document.addEventListener('DOMContentLoaded', (e) => {
    e.preventDefault();

    let element = document.getElementById('public');
    element.focus();

    let action = element.getAttribute('action');
    request('public', action);
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
  request('public', action);
});

document.getElementById('private').addEventListener('click', function (e) {
  e.preventDefault();

  let action = this.getAttribute('action');
  request('private', action);
});

document.getElementById('upload').addEventListener('click', function (e) {
  e.preventDefault();

  let action = this.getAttribute('action');
  request('upload', action);
});

const redirect = (location) => (window.location = location);

const request = (page, action) => {
  app.request({
    data: {
      page,
    },
    type: 'POST',
    action,
    success: (res) => {
      const { page, actionAttr, content } = res;
      let gallery = document.getElementById('gallery_content');
      gallery.innerHTML = content;

      switch (page) {
        case 'public':
          console.log('public page');
          break;
        case 'private':
          console.log('private page');
          break;
        case 'upload':
          console.log('upload page');
          onUpload(actionAttr);
          break;
        default:
          break;
      }
    },
    error: (res) => {
      alert(res);
    },
  });
};
