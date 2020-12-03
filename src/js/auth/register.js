document.getElementById('form').addEventListener('submit', (e) => {
  e.preventDefault();

  document
    .getElementById('name_error')
    .style.setProperty('visibility', 'hidden');
  document
    .getElementById('email_error')
    .style.setProperty('visibility', 'hidden');
  document
    .getElementById('password_error')
    .style.setProperty('visibility', 'hidden');
  document
    .getElementById('confirm_error')
    .style.setProperty('visibility', 'hidden');
  document
    .getElementById('register_success')
    .style.setProperty('visibility', 'hidden');

  let form = document.getElementById('form');
  let action = form.getAttribute('action');

  let name = document.getElementById('name').value;
  let email = document.getElementById('email').value;
  let password = document.getElementById('password').value;
  let confirm = document.getElementById('confirm').value;

  const redirect = (location) => (window.location = location);

  app.request({
    data: {
      name,
      email,
      password,
      confirm,
    },
    type: 'POST',
    action,
    success: (res) => {
      const { msg, location, errors } = res;

      if (errors) {
        Object.keys(errors).forEach((element) => {
          let elementId = element + '_error';
          let message = errors[element];

          document
            .getElementById(elementId)
            .style.setProperty('visibility', 'visible');
          document.getElementById(elementId).innerText = message[0];
        });
      }

      if (msg) {
        document
          .getElementById('register_success')
          .style.setProperty('visibility', 'visible');
        document.getElementById('register_success').innerText = msg;
        document.querySelector('.container__btn-submit').disabled = true;
        window.setTimeout(function () {
          redirect(location);
        }, 2 * 1000);
      }
    },
    error: (res) => {
      alert(res);
    },
  });
});
