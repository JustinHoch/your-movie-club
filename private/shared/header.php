<?php
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
  </head>
  <body>
    <div class="wrapper">
      <header>
        <nav>
          <a href="/" class="logo-a" name="Home">
            <img src="/images/logo/logo.png" alt="Your Movie Club Logo" height="150" width="150" loading=“lazy” decoding=“async”>
          </a>
          <h1>Your Movie Club</h1>
          <input id="menu-toggle" type="checkbox" />
          <label class='menu-button-container' for="menu-toggle">
            menu toggle
            <div class='menu-button'></div>
          </label>
          <ul class="menu">
            <li><a href="/search">Search</a></li>
            <li><a href="/discover">Discover</a></li>
            <?php if($session->is_logged_in()) { ?>
              <li id="nav-account-link">
                <a href="/account">
                  Account
                </a>
              </li>
              <li><a href="/logout">Logout <?php echo $session->username ?></a></li>
            <?php } else { ?>
            <li><a href="/login">Login</a></li>
            <li><a href="/signup">SignUp</a></li>
            <?php } ?>
          </ul>
        </nav>
      </header>
      <main>