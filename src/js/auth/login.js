document.getElementById('form').addEventListener('submit', (e) => {
  e.preventDefault();

  document
    .getElementById('email_error')
    .style.setProperty('visibility', 'hidden');
  document
    .getElementById('password_error')
    .style.setProperty('visibility', 'hidden');
  document
    .getElementById('login_success')
    .style.setProperty('visibility', 'hidden');

  let form = document.getElementById('form');
  let action = form.getAttribute('action');

  let email = document.getElementById('email').value;
  let password = document.getElementById('password').value;
  let rememberMe = document.getElementById('remember_me').checked;

  const redirect = (location) => (window.location = location);

  app.request({
    data: {
      email,
      password,
    },
    type: 'POST',
    action,
    success: (res) => {
      const { msg, location, errors } = res;

      if (errors) {
        Object.keys(errors).forEach((element) => {
          if (element === 'password' || element === 'email') {
            let elementId = element + '_error';
            let message = errors[element];

            document
              .getElementById(elementId)
              .style.setProperty('visibility', 'visible');
            document.getElementById(elementId).innerText = message[0];
          }
        });
      }

      if (msg) {
        document
          .getElementById('login_success')
          .style.setProperty('visibility', 'visible');
        document.getElementById('login_success').innerText = msg;
        let btn = document.querySelector('.container__btn-submit');
        btn.disabled = true;
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
