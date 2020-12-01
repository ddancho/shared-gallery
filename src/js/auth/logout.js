let form = document.getElementById('form');
let action = form.getAttribute('action');

let logout = document
  .getElementById('continue')
  .addEventListener('click', (e) => {
    e.preventDefault();
    request(true, action);
  });

let cancel = document
  .getElementById('cancel')
  .addEventListener('click', (e) => {
    e.preventDefault();
    request(false, action);
  });

const redirect = (location) => (window.location = location);

const request = (logout, action) => {
  app.request({
    data: {
      logout,
    },
    type: 'POST',
    action,
    success: (res) => {
      const { home, gallery } = res;

      if (home) {
        redirect(home);
      }

      if (gallery) {
        redirect(gallery);
      }
    },
    error: (res) => {
      alert(res);
    },
  });
};
