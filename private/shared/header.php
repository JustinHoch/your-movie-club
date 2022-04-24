<?php
  // Get page title
  if(!isset($page_title)) {
    $page_title = 'Your Movie Club';
  } else {
    $page_title .= ' - Your Movie Club';
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo h($page_title); ?></title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <?php if(isset($js_files)){
      foreach($js_files as $file){
    ?>
      <script defer src="<?php echo h($file) ?>"></script>
    <?php }} ?>
  </head>
  <body>
    <div class="wrapper">
      <header>
        <nav>
          <a href="/" class="logo-a" name="Home">
            <img src="/images/logo/logo.png" alt="Your Movie Club Logo" height="150" width="150" loading=“lazy” decoding=“async”>
            <h1>Your Movie Club</h1>
          </a>
          <input id="menu-toggle" type="checkbox" />
          <label class='menu-button-container' for="menu-toggle">
            menu toggle
            <div class='menu-button'></div>
          </label>
          <ul class="menu">
            <li class="nav-link"><a href="/search">Search</a></li>
            <li class="nav-link"><a href="/discover">Discover</a></li>
            <?php if($session->is_logged_in()) { ?>
              <?php if($session->is_admin()){ ?>
                <li class="nav-link">
                  <a href="/admin">Admin</a>
                </li>
              <?php } ?>
              <li class="nav-link" id="nav-account-link">
                <a href="/account">Account</a>
              </li>
              <li class="nav-link" id="nav-logout"><a href="/logout">Logout <?php echo $session->username ?></a></li>
            <?php } else { ?>
            <li class="nav-link"><a href="/login">Login</a></li>
            <li class="nav-link"><a href="/signup">SignUp</a></li>
            <?php } ?>
          </ul>
        </nav>
      </header>
      <main>