<?php

function require_login() {
  global $session;
  if(!$session->is_logged_in()) {
    redirect_to('/login.php');
  } else {
    // Do nothing, let the rest of the page proceed
  }
}

function require_admin() {
  global $session;
  if(!$session->is_admin()) {
    $session->message('Your account does not have access to admin pages.');
    redirect_to('/account');
  } else {
    // Do nothing, let the rest of the page proceed
  }
}

function display_errors($errors=array()) {
  $output = '';
  if(!empty($errors)) {
    $output .= "<div class=\"error-message\">";
    $output .= "<h2>Please fix the following errors:</h2>";
    $output .= "<ul>";
    foreach($errors as $error) {
      $output .= "<li>" . h($error) . "</li>";
    }
    $output .= "</ul>";
    $output .= "</div>";
  }
  return $output;
}

function display_session_message() {
  global $session;
  $msg = $session->message();
  if(isset($msg) && $msg != '') {
    $session->clear_message();
    return '<div id="session-message"><p>' . h($msg) . '</p></div>';
  }
}

?>
