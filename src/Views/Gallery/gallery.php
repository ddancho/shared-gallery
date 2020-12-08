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
          action="<?php echo Application::$base; ?>/upload"
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
    </ul>
  </nav>
  <div id="gallery_content" class="gallery__content"></div>
</div>

<script
  defer
  src="<?php echo Application::$js; ?>/request.js"
  type="text/javascript"
></script>

<script
  defer
  type="module"
  src="<?php echo Application::$js; ?>/gallery/gallery.js"
  type="text/javascript"
></script>

<script
  defer
  type="module"
  src="<?php echo Application::$js; ?>/gallery/upload.js"
  type="text/javascript"
></script>

<script
  defer
  type="module"
  src="<?php echo Application::$js; ?>/gallery/public.js"
  type="text/javascript"
></script>

<script
  defer
  type="module"
  src="<?php echo Application::$js; ?>/gallery/private.js"
  type="text/javascript"
></script>
