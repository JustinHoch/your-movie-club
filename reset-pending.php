<?php

// Initialize
require_once('./private/initialize.php');

// get and check email
if(!isset($_GET['email'])){
  redirect_to('/');
}
$email = $_GET['email'];
$email_check = PasswordReset::find_by_email($email);
if($email_check == false){
  redirect_to('/');
}

// Page Title
$page_title = "Reset Pending";

// Header
include(SHARED_PATH . '/header.php');

?>

<div class="reset-pending">
  <h2>Password Reset Email Sent!</h2>
  <p>A password reset email has been sent to: <?php echo h($email) ?></p>
  <p>Check your email for a link to reset your password.</p>
  <p><b>Be sure to check your spam folder if you do not see an email from us in your inbox.</b></p>
</div>

<?php

// Footer
include(SHARED_PATH . '/footer.php');

?>