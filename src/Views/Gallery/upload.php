<div class="container">
  <h2 class="container__title">Upload Image</h2>
  <form id="uploadForm" action="" method="POST" enctype="multipart/form-data">
    <div class="container__form-group">
      <label for="file" class="container__form-label">Image</label>
      <input
        type="file"
        id="file"
        class="container__form-input"
        accept="image/png,image/jpeg"
        required
      />
      <p id="file_error" class="container__description-error">0</p>
    </div>
    <div class="container__form-group">
      <label for="comment" class="container__form-label">Your comment for image</label>
      <input
        type="text"
        id="comment"
        name="comment"
        class="container__form-input"
      />
    </div>
    <fieldset class="container__form-group-fieldset" form="uploadForm">
        <legend>Choose Image Visibility</legend>
        <div class="container__form-input-checkbox">
            <input type="radio" id="public" name="visibility" value="public" checked>
        </div>
        <label for="public" class="container__form-label-checkbox">Public</label>
        <div class="container__form-input-checkbox">
            <input type="radio" id="private" name="visibility" value="private">
        </div>
        <label for="private" class="container__form-label-checkbox">Private</label>
    </fieldset>
    <div class="container__form-group">
      <div class="container__form-progress_bar">
        <span id="progress_bar_fill" class="container__form-progress_bar-fill">
        </span>
      </div>
    </div>
    <div class="container__form-group">
      <input type="submit" class="container__btn-submit" value="Upload" />
      <p id="upload_success" class="container__description-success">0</p>
    </div>
  </form>
</div>
