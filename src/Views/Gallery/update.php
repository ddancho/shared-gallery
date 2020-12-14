<?php

echo <<<PAGE
    <div class="container">
        <h2 class="container__title">Edit</h2>
        <form action="{$record['action']}" method="POST" enctype="multipart/form-data">
        <div class="container__form-group">
            <label for="image_name" class="container__form-label">Image Name</label>
            <input
            type="text"
            id="image_name"
            value="{$record['image_name']}"
            class="container__form-input"            
            />
            <p id="name_error" class="container__description-error">0</p>
        </div>
        <div class="container__form-group">
            <label for="image_comment" class="container__form-label">Image Comment</label>
            <input
            type="text"
            id="image_comment"
            value="{$record['image_comment']}"
            class="container__form-input"            
            />
            <p id="name_error" class="container__description-error">0</p>
        </div>
        <div class="container__form-group">
            <input type="submit" class="container__btn-submit" value="Update" />
            <p id="update_success" class="container__description-success">0</p>
        </div>
        </form>
    </div>
  PAGE;
