<?php

$publicRadio = $params['image_status'] === '0' ? 'checked' : '';
$privateRadio = $params['image_status'] === '1' ? 'checked' : '';

$container = $params['image_status'] === '0' ? 'container' : 'container__private';

echo <<<PAGE
    <div class="{$container}">
        <h2 class="container__title">Edit</h2>
        <form id="updateForm" action="{$params['action']}" method="POST" enctype="multipart/form-data">
            <div class="container__form-group">
                <label for="image_name" class="container__form-label">Image Name</label>
                <input
                type="text"            
                name="image_name"
                value="{$params['image_name']}"
                class="container__form-input"            
                required
                />                
            </div>
            <div class="container__form-group">
                <label for="image_comment" class="container__form-label">Image Comment</label>
                <input
                type="text"
                name="image_comment"
                value="{$params['image_comment']}"
                class="container__form-input"            
                />            
            </div>
            <fieldset class="container__form-group-fieldset" form="updateForm">
                <legend>Image Visibility</legend>
                <div class="container__form-input-checkbox">
                    <input type="radio" id="public" name="visibility" value="public" {$publicRadio}>
                </div>
                <label for="public" class="container__form-label-checkbox">Public</label>
                <div class="container__form-input-checkbox">
                    <input type="radio" id="private" name="visibility" value="private" {$privateRadio}>
                </div>
                <label for="private" class="container__form-label-checkbox">Private</label>
            </fieldset>
            <div class="container__form-group">
                <input type="submit" class="container__btn-submit container__btn-submit-update" value="Update" />                                    
                <input type="submit" id="edit_cancel" class="container__btn-submit-cancel container__btn-submit-update" value="Cancel" />
                <p id="update_status" class="container__description-success">0</p>
            </div>
        </form>        
    </div>
  PAGE;
