function onAccountUpdate() {
  document.getElementById("view_type").disabled = true;
  document.getElementById("sort_type").disabled = true;
  document.getElementById("img_per_page_type").disabled = true;

  let viewColumn = Array.from(
    document.getElementById("gallery_content").classList
  ).find((element) => element === "gallery__content-column");

  if (viewColumn === undefined) {
    document
      .getElementById("gallery_content")
      .classList.remove("gallery__content-grid");
    document
      .getElementById("gallery_content")
      .classList.add("gallery__content-column");
  }

  hideErrorsElements();

  document
    .getElementById("acc_update_success")
    .style.setProperty("visibility", "hidden");

  let btns = Array.from(
    document.querySelectorAll(
      ".container__btn-submit.container__btn-submit-row"
    )
  );

  btns.forEach((btn) => {
    if (btn.name === "updateAcc") {
      btn.addEventListener("click", (e) => {
        e.preventDefault();

        let formElement = document.getElementById("accountform");
        let form = new FormData(formElement);
        let action = formElement.getAttribute("action");

        request(action, "POST", false, form);
      });
    } else if (btn.name === "deleteAcc") {
      btn.addEventListener("click", (e) => {
        e.preventDefault();
        let action = document
          .getElementById("accountform")
          .getAttribute("action");
        action = action.replace("account", "deleteAccount");

        request(action, "GET");
      });
    }
  });
}

const request = (action, type, processData = false, data = null) => {
  app.request(
    {
      data,
      type,
      action,
      success: (res) => {
        const { msg, userName, errors, viewDelAcc } = res;

        if (errors) {
          Object.keys(errors).forEach((element) => {
            let elementId = "acc_" + element + "_error";
            let message = errors[element];

            document
              .getElementById(elementId)
              .style.setProperty("visibility", "visible");
            document.getElementById(elementId).innerText = message[0];
          });
        }

        if (msg) {
          hideErrorsElements();

          document.getElementById("user_name").innerHTML = userName;

          let updateSucces = document.getElementById("acc_update_success");

          updateSucces.style.setProperty("visibility", "visible");
          updateSucces.innerHTML = msg;
          document.querySelector(".container__btn-submit").disabled = true;

          window.setTimeout(function () {
            updateSucces.style.setProperty("visibility", "hidden");
            updateSucces.innerHTML = "";
            document.querySelector(".container__btn-submit").disabled = false;
          }, 3 * 1000);
        }

        if (viewDelAcc) {
          deleteAccountAction(viewDelAcc);
        }
      },
      error: (res) => {
        alert(res);
      },
    },
    processData
  );
};

const hideErrorsElements = () => {
  document
    .getElementById("acc_name_error")
    .style.setProperty("visibility", "hidden");
  document
    .getElementById("acc_email_error")
    .style.setProperty("visibility", "hidden");
  document
    .getElementById("acc_password_error")
    .style.setProperty("visibility", "hidden");
  document
    .getElementById("acc_confirm_error")
    .style.setProperty("visibility", "hidden");
};

export { onAccountUpdate };
