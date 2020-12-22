import { onUpload } from "./upload.js";
import { onPublic } from "./public.js";
import { onPrivate } from "./private.js";
import { onAccountUpdate } from "./account.js";
import {
  fixGalleryViewType,
  getSortByValue,
  getSortByDirection,
  getImagesPerPageValue,
} from "./helpers.js";
import {
  onViewTypeChange,
  onSortTypeChange,
  onAscArrowClick,
  onDescArrowClick,
  onPageDownArrowClick,
  onPageUpArrowClick,
  onImagePerPageChange,
  onNavListItem,
} from "./eventControls.js";

document.addEventListener("DOMContentLoaded", (e) => {
  e.preventDefault();

  let view = document.getElementById("view_type");
  document.getElementById("gallery_content").classList.add(view.value);

  let sort = document.getElementById("sort_type");
  sort.add(new Option("Uploader", "uploader"));

  document
    .getElementById("south_arrow")
    .classList.toggle("nav__select-arrow-active");

  let element = document.getElementById("public");
  element.focus();

  onPageDownArrowClick(request);

  onPageUpArrowClick(request);

  let page = 0;
  let ipp = getImagesPerPageValue();
  let sortBy = getSortByValue();
  let direction = getSortByDirection();
  let action = element.getAttribute("action");

  request(action, "POST", true, { sortBy, direction, ipp, page });
});

onNavListItem();

onViewTypeChange();

onSortTypeChange();

onAscArrowClick();

onDescArrowClick();

onImagePerPageChange();

document.getElementById("public").addEventListener("click", function (e) {
  e.preventDefault();

  let page = null;
  let ipp = getImagesPerPageValue();
  let sortBy = getSortByValue();
  let direction = getSortByDirection();
  let action = this.getAttribute("action");

  request(action, "POST", true, { sortBy, direction, ipp, page });
});

document.getElementById("private").addEventListener("click", function (e) {
  e.preventDefault();

  let page = null;
  let ipp = getImagesPerPageValue();
  let direction = getSortByDirection();
  let action = this.getAttribute("action");

  request(action, "POST", true, { direction, ipp, page });
});

document.getElementById("upload").addEventListener("click", function (e) {
  e.preventDefault();

  let action = this.getAttribute("action");
  request(action, "POST");
});

document.getElementById("account").addEventListener("click", function (e) {
  e.preventDefault();

  let action = this.getAttribute("action");
  request(action, "POST");
});

const request = (action, type, processData = false, data = null) => {
  app.request(
    {
      data,
      type,
      action,
      success: (res) => {
        const { page, records, view } = res;

        let galleryContent = document.getElementById("gallery_content");
        galleryContent.innerHTML = view;

        switch (page) {
          case "public":
            onPublic(action, records, fixGalleryViewType);
            break;
          case "private":
            onPrivate(action, records, fixGalleryViewType);
            break;
          case "upload":
            onUpload(action);
            break;
          case "account":
            onAccountUpdate();
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
