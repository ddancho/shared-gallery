import {
  simulateMouseClick,
  getImagesPerPageValue,
  getSortByValue,
  getSortByDirection,
} from "./helpers.js";

function onViewTypeChange() {
  document.getElementById("view_type").addEventListener("change", function (e) {
    e.preventDefault();

    let classToAdd = this.value;
    let classToRemove = Array.from(this.options).find(
      (option) => option.value !== classToAdd
    ).value;

    document.getElementById("gallery_content").classList.remove(classToRemove);
    document.getElementById("gallery_content").classList.add(classToAdd);
  });
}

function onSortTypeChange() {
  document.getElementById("sort_type").addEventListener("change", function (e) {
    e.preventDefault();

    simulateMouseClick();
  });
}

function onAscArrowClick() {
  document
    .getElementById("south_arrow")
    .addEventListener("click", function (e) {
      e.preventDefault();

      if (this.classList.length === 0) {
        document
          .getElementById("north_arrow")
          .classList.toggle("nav__select-arrow-active");
        this.classList.toggle("nav__select-arrow-active");
      }

      simulateMouseClick();
    });
}

function onDescArrowClick() {
  document
    .getElementById("north_arrow")
    .addEventListener("click", function (e) {
      e.preventDefault();

      if (this.classList.length === 0) {
        document
          .getElementById("south_arrow")
          .classList.toggle("nav__select-arrow-active");
        this.classList.toggle("nav__select-arrow-active");
      }

      simulateMouseClick();
    });
}

function onPageDownArrowClick(cb) {
  document.getElementById("west_arrow").addEventListener("click", function (e) {
    e.preventDefault();

    let page = -1;
    let ipp = getImagesPerPageValue();
    let sortBy = getSortByValue();
    let direction = getSortByDirection();
    let action = document
      .querySelector(".nav__listitem.nav__listitem-active a")
      .getAttribute("action");

    cb(action, "POST", true, { sortBy, direction, ipp, page });
  });
}

function onPageUpArrowClick(cb) {
  document.getElementById("east_arrow").addEventListener("click", function (e) {
    e.preventDefault();

    let page = 1;
    let ipp = getImagesPerPageValue();
    let sortBy = getSortByValue();
    let direction = getSortByDirection();
    let action = document
      .querySelector(".nav__listitem.nav__listitem-active a")
      .getAttribute("action");

    cb(action, "POST", true, { sortBy, direction, ipp, page });
  });
}

function onImagePerPageChange(cb) {
  document
    .getElementById("img_per_page_type")
    .addEventListener("change", function (e) {
      e.preventDefault();

      let aElement = document.querySelector(".nav__listitem-active a");
      let action = aElement.getAttribute("action");

      let page = 0;
      let ipp = getImagesPerPageValue();
      let sortBy = getSortByValue();
      let direction = getSortByDirection();

      cb(action, "POST", true, { sortBy, direction, ipp, page });
    });
}

function onNavListItem() {
  document.querySelector(".nav__expand").addEventListener("click", () => {
    document.querySelector(".nav").classList.toggle("nav-closed");
  });

  let listItems = document.querySelectorAll(".nav__listitem");

  listItems.forEach((item) => {
    item.addEventListener("click", () => setItemActive(item));
  });

  const setItemActive = (item) => {
    listItems.forEach((listItem) => {
      listItem.classList.remove("nav__listitem-active");
    });

    item.classList.add("nav__listitem-active");
  };
}

export {
  onViewTypeChange,
  onSortTypeChange,
  onAscArrowClick,
  onDescArrowClick,
  onPageDownArrowClick,
  onPageUpArrowClick,
  onImagePerPageChange,
  onNavListItem,
};
