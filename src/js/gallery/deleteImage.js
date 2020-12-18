import { simulateMouseClick } from "./helpers.js";

function onDeleteImage(id, view) {
  document.body.style.setProperty("overflow-y", "hidden");

  let modal = document.querySelector(".gallery__content__modal");
  modal.style.setProperty("visibility", "visible");
  modal.style.setProperty("opacity", "1");

  document.getElementById("gallery_content_modal").innerHTML = view;

  document
    .getElementById("delete_cancel")
    .addEventListener("click", function (e) {
      e.preventDefault();

      document.body.style.setProperty("overflow-y", "visible");
      modal.style.setProperty("visibility", "hidden");
      modal.style.setProperty("opacity", "0");
    });

  document
    .getElementById("deleteForm")
    .addEventListener("submit", function (e) {
      e.preventDefault();

      let form = new FormData(this);
      form.append("id", id);
      let action = this.getAttribute("action");

      request(action, "POST", false, form);
    });
}

const request = (action, type, processData = false, data = null) => {
  app.request(
    {
      data,
      type,
      action,
      success: (res) => {
        const { isDeleted } = res;

        let delElement = document.getElementById("delete_status");
        document.querySelector(
          ".container__btn-submit.container__btn-submit-update"
        ).disabled = true;
        document.querySelector(
          ".container__btn-submit-cancel.container__btn-submit-update"
        ).disabled = true;

        if (isDeleted) {
          delElement.style.setProperty("visibility", "visible");
          delElement.innerHTML = "Image data deleted successfully";

          window.setTimeout(function () {
            onDeleteImageResponse(delElement, null);
          }, 3 * 1000);

          simulateMouseClick();
        } else {
          delElement.classList.toggle("container__description-error-m");
          delElement.style.setProperty("visibility", "visible");
          delElement.innerHTML = "Error, please try later";

          window.setTimeout(function () {
            onDeleteImageResponse(delElement, "container__description-error-m");
          }, 3 * 1000);

          simulateMouseClick();
        }
      },
      error: (res) => {
        alert(res);
      },
    },
    processData
  );
};

const onDeleteImageResponse = (delElement, classType) => {
  if (classType) {
    delElement.classList.toggle(classType);
  }
  delElement.style.setProperty("visibility", "hidden");
  delElement.innerHTML = "";

  document.querySelector(
    ".container__btn-submit.container__btn-submit-update"
  ).disabled = false;
  document.querySelector(
    ".container__btn-submit-cancel.container__btn-submit-update"
  ).disabled = false;

  document.body.style.setProperty("overflow-y", "visible");
  document
    .querySelector(".gallery__content__modal")
    .style.setProperty("visibility", "hidden");
  document
    .querySelector(".gallery__content__modal")
    .style.setProperty("opacity", "0");
};

export { onDeleteImage };
