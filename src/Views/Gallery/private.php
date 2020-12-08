<?php
if (empty($params)) {
    echo <<<EMPTY
    <div class="container">
      <h2 class="container__title">Sory, no private images available</h2>
    </div>
  EMPTY;
} else {
    foreach ($params as $record) {
        echo <<<PAGE
      <div class="{$record['class']}">
          <div class="card">
            <p class="card__uploadby">{$record['created_at']}</p>
            <img src="{$record['src']}" alt="background image 01" class="card__image" />
            <h2 class="card__title">{$record['image_name']}</h2>
            <p class="card__comment">{$record['image_comment']}</p>
          </div>
          <div class="container__form-group">
            <input type="submit" class="container__btn-submit" value="View Full Size" />
          </div>
      </div>
  PAGE;
    }
}
