<?php
use App\Core\Application;
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="data:image/x-icon;," type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="<?php echo Application::$assets; ?>/css/style.css" />
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,700;1,400&display=swap"
      rel="stylesheet"
    />
    <title>Shared Gallery</title>
  </head>
  <body>
    <div class="navbar">
      <ul>
        <?php if (!is_null(Application::$app->session->get('user'))): ?>
          <li><a href="/gallery">Shared Gallery</a></li>
          <li><a id="logout" href="/logoutUser">Logout</a></li>
        <?php else: ?>
          <li><a href="/index">Shared Gallery</a></li>
          <li><a href="/login">Login</a></li>
          <li><a href="/register">Register</a></li>
        <?php endif;?>
      </ul>
    </div>

    <main>

      {{content}}

    </main>

  </body>
</html>
