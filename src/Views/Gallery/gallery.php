<?php
use App\Core\Application;
?>

<div class="gallery">
  <nav class="nav">
    <ul class="nav__list">
      <li>
        <svg
          class="nav__expand"
          viewBox="0 0 256 512"
          width="100"
          title="Expand Arrow"
        >
          <path
            d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z"
          />
        </svg>
      </li>
      <li class="nav__listitem nav__listitem-active">
        <a
          id="public"
          href="javascript:void(0)"
          action="<?php echo Application::$base; ?>/publicGallery"
        >
          <svg viewBox="0 0 24 24" fill="black" width="48px" height="48px">
            <path d="M0 0h24v24H0z" fill="none" />
            <path
              d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"
            />
          </svg>
          <p>Public Gallery</p>
        </a>
      </li>
      <li class="nav__listitem">
        <a
          id="private"
          href="javascript:void(0)"
          action="<?php echo Application::$base; ?>/privateGallery"
        >
          <svg viewBox="0 0 24 24" fill="black" width="48px" height="48px">
            <path d="M0 0h24v24H0z" fill="none" />
            <path
              d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"
            />
          </svg>
          <p>Private Gallery</p>
        </a>
      </li>
      <li class="nav__listitem">
        <a
          id="upload"
          href="javascript:void(0)"
          action="<?php echo Application::$base; ?>/uploadImageView"
        >
          <svg
            enable-background="new 0 0 24 24"
            viewBox="0 0 24 24"
            fill="black"
            width="48px"
            height="48px"
          >
            <g><rect fill="none" height="24" width="24" x="0" /></g>
            <g>
              <g>
                <g>
                  <path
                    d="M20.55,5.22l-1.39-1.68C18.88,3.21,18.47,3,18,3H6C5.53,3,5.12,3.21,4.85,3.55L3.46,5.22C3.17,5.57,3,6.01,3,6.5V19 c0,1.1,0.89,2,2,2h14c1.1,0,2-0.9,2-2V6.5C21,6.01,20.83,5.57,20.55,5.22z M12,9.5l5.5,5.5H14v2h-4v-2H6.5L12,9.5z M5.12,5 l0.82-1h12l0.93,1H5.12z"
                  />
                </g>
              </g>
            </g>
          </svg>
          <p>Upload Image</p>
        </a>
      </li>
      <li class="nav__listitem">
        <a
          id="account"
          href="javascript:void(0)"
          action="<?php echo Application::$base; ?>/accountView"
        >
          <svg viewBox="0 0 24 24" fill="black" width="48px" height="48px">
            <path d="M0 0h24v24H0z" fill="none" />
            <path
              d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"
            />
          </svg>
          <p>Account</p>
        </a>
      </li>
    </ul>
    <div class="nav__select">
      <div class="nav__select-container">
        <label for="view_type" class="nav__select-label">Choose a view</label>
        <select name="views" id="view_type" class="nav__select-input">
          <option value="gallery__content-column">Column</option>
          <option value="gallery__content-grid">Grid</option>
        </select>
      </div>
    </div>
    <div class="nav__select">
      <div class="nav__select-container">
        <label for="sort_type" class="nav__select-label">Sort by</label>
        <select name="sorts" id="sort_type" class="nav__select-input">
          <option value="date">Date</option>
        </select>
      </div>
      <div class="nav__select-arrow">
        <svg
          id="south_arrow"
          value="asc"
          enable-background="new 0 0 24 24"
          viewBox="0 0 24 24"
          fill="black"
          width="18px"
          height="18px"
        >
          <rect fill="none" height="24" width="24" />
          <path
            d="M19,15l-1.41-1.41L13,18.17V2H11v16.17l-4.59-4.59L5,15l7,7L19,15z"
          />
        </svg>
      </div>
      <div class="nav__select-arrow">
        <svg
          id="north_arrow"
          value="desc"
          enable-background="new 0 0 24 24"
          viewBox="0 0 24 24"
          fill="black"
          width="18px"
          height="18px"
        >
          <rect fill="none" height="24" width="24" />
          <path
            d="M5,9l1.41,1.41L11,5.83V22H13V5.83l4.59,4.59L19,9l-7-7L5,9z"
          />
        </svg>
      </div>
    </div>
    <div class="nav__select">
      <div class="nav__select-container">
        <label for="img_per_page_type" class="nav__select-label"
          >Images Per Page</label
        >
        <select name="views" id="img_per_page_type" class="nav__select-input">
          <option value="3">3</option>
          <option value="10">10</option>
          <option value="20">20</option>
          <option value="30">30</option>
          <option value="40">40</option>
          <option value="50">50</option>
        </select>
      </div>
      <div class="nav__select-arrow nav__select-arrow-l-r">
        <svg
          id="west_arrow"
          enable-background="new 0 0 24 24"
          viewBox="0 0 24 24"
          fill="black"
          width="18px"
          height="18px"
        >
          <rect fill="none" height="24" width="24" />
          <path
            d="M9,19l1.41-1.41L5.83,13H22V11H5.83l4.59-4.59L9,5l-7,7L9,19z"
          />
        </svg>
      </div>
      <div class="nav__select-arrow nav__select-arrow-l-r">
        <svg
          id="east_arrow"
          enable-background="new 0 0 24 24"
          viewBox="0 0 24 24"
          fill="black"
          width="18px"
          height="18px"
        >
          <rect fill="none" height="24" width="24" />
          <path
            d="M15,5l-1.41,1.41L18.17,11H2V13h16.17l-4.59,4.59L15,19l7-7L15,5z"
          />
        </svg>
      </div>
    </div>
  </nav>
  <div id="gallery_content" class="gallery__content"></div>
</div>
<div class="gallery__content__modal">
  <div
    id="gallery_content_modal"
    class="gallery__content__modal__container"
  ></div>
</div>

<script
  defer
  src="<?php echo Application::$js; ?>/request.js"
  type="text/javascript"
></script>

<script
  defer
  src="<?php echo Application::$js; ?>/auth/deleteAccount.js"
  type="text/javascript"
></script>

<script
  defer
  type="module"
  src="<?php echo Application::$js; ?>/gallery/gallery.js"
  type="text/javascript"
></script>