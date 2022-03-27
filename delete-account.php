<?php

// Initialize
require_once('./private/initialize.php');

// Require user to be logged in
require_login();

// Delete account form
if(is_post_request()){
  $user = User::find_by_id($session->user_id);
  $result = $user->delete();
  $session->logout();
  $session->message('Your account has been deleted.');
  redirect_to('/');
}

// Page Title
$page_title = "Delete Account";

// Header
include(SHARED_PATH . '/header.php');

?>

<div class="forms">
  <h2>Delete Account</h2>
  <p>Are you sure you want to delete your account?</p>
  <p>You will not be able to undo this action!</p>
  <form action="" method="post">
    <button type="submit" class="delete-button">Delete Account</button>
  </form>
</div>

<?php

// Footer
include(SHARED_PATH . '/footer.php');

?>
