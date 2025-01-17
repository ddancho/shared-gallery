<?php
use App\Core\Application;
?>

<div class="solo">
  <div class="container">
    <h2 class="container__title">Register</h2>
    <form id="form" action="<?php echo Application::$base; ?>/register" method="POST" enctype="multipart/form-data">
      <div class="container__form-group">
        <label for="name" class="container__form-label">Name</label>
        <input
          type="text"
          id="name"
          name="name"
          class="container__form-input"
          placeholder="Enter your name"
        />
        <p id="reg_name_error" class="container__description-error">0</p>
      </div>
      <div class="container__form-group">
        <label for="email" class="container__form-label">Email</label>
        <input
          type="email"
          id="email"
          name="email"
          class="container__form-input"
          placeholder="Enter your email"
        />
        <p id="reg_email_error" class="container__description-error">0</p>
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
        <p id="reg_password_error" class="container__description-error">0</p>
      </div>
      <div class="container__form-group">
        <label for="confirm" class="container__form-label"
          >Confirm Password</label
        >
        <input
          type="password"
          id="confirm"
          name="confirm"
          class="container__form-input"
          placeholder="Confirm your password"
        />
        <p id="reg_confirm_error" class="container__description-error">0</p>
      </div>
      <div class="container__form-group">
        <input type="submit" class="container__btn-submit" value="Submit" />
        <p id="register_success" class="container__description-success">0</p>
      </div>
    </form>
  </div>
</div>

<script defer src="<?php echo Application::$js; ?>/request.js" type="text/javascript"></script>

<script defer src="<?php echo Application::$js; ?>/auth/register.js" type="text/javascript"></script>