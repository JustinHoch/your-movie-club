<?php

// Initialize
require_once('./private/initialize.php');

// Get token
if(!isset($_GET['token'])){
  redirect_to('/');
}
$token = $_GET['token'];

// Check token
$token_user = PasswordReset::find_by_token($token);
if($token_user == false){
  redirect_to('/');
}

$user = User::find_by_email($token_user->email);

// process form
if(is_post_request()){
  $user->unhashed_password = $_POST['user']['unhashed_password'];
  $user->confirm_password = $_POST['user']['confirm_password'];
  $result = $user->save();
  if($result == true){
    $session->login($user);
    $session->message('Your password was successfully updated!');
    $token_user->delete();
    redirect_to('/account');
  }
}

// Page Title
$page_title = "Password Reset";

// Header
include(SHARED_PATH . '/header.php');

?>

<div class="forms">
  <h2>Reset Password for: <?php echo h($user->email); ?></h2>
  
  <!-- Display errors if $user->save() failed -->
  <?php echo display_errors($user->errors); ?>

  <form action="/password-reset?token=<?php echo h($token); ?>" method="post">
    <label for="password">New Password</label>
    <input type="password" id="password" placeholder="password" name="user[unhashed_password]" value="<?php echo h($user->unhashed_password); ?>" required>

    <label for="confirm-password">Confirm New Password</label>
    <input type="password" id="confirm-password" placeholder="retype password" name="user[confirm_password]" value="<?php echo h($user->confirm_password); ?>" required>

    <button type="submit">Change Password</button>
  </form>
</div>

<?php

// Footer
include(SHARED_PATH . '/footer.php');

?>