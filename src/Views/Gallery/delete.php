<?php

echo <<<PAGE
    <div class="container">        
        <h2 class="container__title">Continue To Delete?</h2>
        <form id="deleteForm" action="{$params['action']}" method="POST" enctype="multipart/form-data">
            <div class="container__form-group">
                <input type="submit" class="container__btn-submit container__btn-submit-update" value="Delete" />                                    
                <input type="submit" id="delete_cancel" class="container__btn-submit-cancel container__btn-submit-update" value="Cancel" />
                <p id="delete_status" class="container__description-success">0</p>
            </div>
        </form>        
    </div>
  PAGE;
