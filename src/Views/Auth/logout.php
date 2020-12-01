<?php
use App\Core\Application;
?>

<div class="container">
  <h2 class="container__title">Continue To Logout?</h2>
  <form id="form" action="<?php echo Application::$base; ?>/logout" method="POST" enctype="multipart/form-data">
    <div class="container__form-group">
      <input id="continue" type="submit" class="container__btn-submit" value="Logout" />
      <input id="cancel" type="submit" class="container__btn-submit-cancel" value="Cancel" />
    </div>
  </form>
</div>

<script defer src="<?php echo Application::$js; ?>/request.js" type="text/javascript"></script>

<script defer src="<?php echo Application::$js; ?>/auth/logout.js" type="text/javascript"></script>