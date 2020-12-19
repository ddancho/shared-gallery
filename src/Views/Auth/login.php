<?php
use App\Core\Application;
?>

<div class="solo">
  <div class="container">
    <h2 class="container__title">Login</h2>
    <form id="form" action="<?php echo Application::$base; ?>/login" method="POST" enctype="multipart/form-data">
      <div class="container__form-group">
        <label for="email" class="container__form-label">Email</label>
        <input
          type="email"
          id="email"
          name="email"
          class="container__form-input"
          placeholder="Enter your email"
        />
        <p id="login_email_error" class="container__description-error">0</p>
      </div>
      <div class="container__form-group">
        <label for="password" class="container__form-label">Password</label>
        <input
          type="password"
          id="password"
          name="password"
          class="container__form-input"
          placeholder="Enter your Password"
        />
        <p id="login_password_error" class="container__description-error">0</p>
      </div>
      <div class="container__form-group-row">
          <div class="container__form-input-checkbox">
              <input type="checkbox" id="remember_me">
          </div>
          <label for="remember_me" class="container__form-label-checkbox">Remember Me</label>
      </div>
      <div class="container__form-group">
        <input type="submit" class="container__btn-submit" value="Submit" />
        <p id="login_success" class="container__description-success">0</p>
      </div>
    </form>
  </div>
</div>

<script defer src="<?php echo Application::$js; ?>/request.js" type="text/javascript"></script>

<script defer src="<?php echo Application::$js; ?>/auth/login.js" type="text/javascript"></script>