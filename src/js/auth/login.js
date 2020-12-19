document.getElementById("form").addEventListener("submit", function (e) {
  e.preventDefault();

  document
    .getElementById("login_email_error")
    .style.setProperty("visibility", "hidden");
  document
    .getElementById("login_password_error")
    .style.setProperty("visibility", "hidden");
  document
    .getElementById("login_success")
    .style.setProperty("visibility", "hidden");

  let formData = new FormData(this);
  let action = this.getAttribute("action");

  request(action, "POST", false, formData);

  //let rememberMe = document.getElementById("remember_me").checked;
});

const redirect = (location) => (window.location = location);

const request = (action, type, processData = false, data = null) => {
  app.request(
    {
      data,
      type,
      action,
      success: (res) => {
        const { msg, location, errors } = res;

        if (errors) {
          document.querySelector(".container__btn-submit").disabled = true;

          Object.keys(errors).forEach((element) => {
            if (element === "password" || element === "email") {
              let elementId = "login_" + element + "_error";
              let message = errors[element];

              document
                .getElementById(elementId)
                .style.setProperty("visibility", "visible");
              document.getElementById(elementId).innerText = message[0];
            }
          });

          window.setTimeout(function () {
            document.querySelector(".container__btn-submit").disabled = false;
          }, 3 * 1000);
        }

        if (msg) {
          document
            .getElementById("login_success")
            .style.setProperty("visibility", "visible");
          document.getElementById("login_success").innerText = msg;
          document.querySelector(".container__btn-submit").disabled = true;
          window.setTimeout(function () {
            redirect(location);
          }, 2 * 1000);
        }
      },
      error: (res) => {
        alert(res);
      },
    },
    processData
  );
};
