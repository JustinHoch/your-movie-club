<?php

// Initialize
require_once('./private/initialize.php');

//Check if this is a POST request. If it is, add the new member, log them in, and redirect to index.php
if($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Create record using post parameters
  $args = $_POST['user'];
  $user = new User($args);
  $result = $user->save();

  // Test result to see if there were no errors when saving the admin to the database
  // if all went well, use session to login with the new admin, add a session message, and redirect to index.php
  if($result === true) {
    $new_user = User::find_by_email($user->email);
    // Add new user to default movie club
    $new_member_args = [];
    $new_member_args['user_id'] = $new_user->id;
    $new_member_args['movie_club_id'] = 1;
    $new_member = new ClubMember($new_member_args);
    $new_member->save();
    $session->login($new_user);
    $session->message('Thanks for signing up!');
    redirect_to('account.php');
  } else {
    // show errors: the rest of the page will load and show the errors above the Form
  }

} else {
  // If this is not a POST request -> display the form
  $user = new User;
}

// Page Title
$page_title = "Sign Up";

// Header
include(SHARED_PATH . '/header.php');

?>

<div class="forms">

   <!-- Display errors if $user->save() failed -->
   <?php echo display_errors($user->errors); ?>

  <h2>Sign Up</h2>
  <form action="/signup" method="post">
    <label for="email">Email</label>
    <input type="text" id="email" placeholder="Email" name="user[email]" value="<?php echo h($user->email); ?>" required>

    <label for="username">Username</label>
    <input type="text" id="username" placeholder="Username" name="user[username]" value="<?php echo h($user->username); ?>" required>

    <label for="password">Password</label>
    <input type="password" id="password" placeholder="password" name="user[unhashed_password]" value="<?php echo h($user->unhashed_password); ?>" required>

    <label for="confirm-password">Confirm Password</label>
    <input type="password" id="confirm-password" placeholder="retype password" name="user[confirm_password]" value="<?php echo h($user->confirm_password); ?>" required>

    <button type="submit" value="Sign up">Sign Up</button>
  </form>
  <p>Already have an account? <a href="login.php">Login</a></p>
</div>

<?php

// Footer
include(SHARED_PATH . '/footer.php');

?>