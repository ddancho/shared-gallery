if ((document.readyState = 'loading')) {
  document.addEventListener('DOMContentLoaded', () => {
    let element = document.getElementById('public');
    element.focus();
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

document.getElementById('public').addEventListener('focus', function (e) {
  console.log('Hello public');
});

document.getElementById('private').addEventListener('focus', function (e) {
  console.log('Hello private');
});

document.getElementById('upload').addEventListener('focus', function (e) {
  console.log('Hello upload');
});
