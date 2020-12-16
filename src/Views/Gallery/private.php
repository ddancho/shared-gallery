<?php
if (empty($params)) {
    echo <<<EMPTY
    <div class="container">
      <h2 class="container__title">Sory, no private images available</h2>
    </div>
  EMPTY;
} else {
    foreach ($params as $record) {
      $comment = empty($record['image_comment']) ? '<p class="card__comment card__comment-hidden">' . 'no comment' . '</p>' : '<p class="card__comment">' . $record['image_comment'] . '</p>';

        echo <<<PAGE
      <div class="{$record['class']}">
          <div class="card">
            <p class="card__uploadby">{$record['created_at']}</p>
            <img src="{$record['src']}" id="{$record['id']}" alt="Image Resource Not Found" class="card__image" />
            <h2 class="card__title">{$record['image_name']}</h2>
            {$comment}
          </div>
          <div class="container__form-group-row">
            <input type="submit" class="container__btn-submit container__btn-submit-row" name="edit" value="Edit Image Data" />
            <input type="submit" class="container__btn-submit container__btn-submit-row container__btn-submit-delete" name="delete" value="Delete Image" />
          </div>
          <div class="container__form-group container__form-group-a">            
            <input type="submit" class="container__btn-submit container__btn-submit-row" name="view" value="View Full Size" />
          </div>
      </div>
  PAGE;
    }
}
