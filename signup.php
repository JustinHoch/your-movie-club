<?php

// Initialize
require_once('./private/initialize.php');

//Check if this is a POST request. If it is, add the new member, log them in, and redirect to index.php
if($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Create record using post parameters
  $args = $_POST['user'];
  $user = new User($args);

  // Test recaptcha response
  if(!empty($_POST['recaptcha_response'])){
    // Build POST request:
    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptcha_secret = RECAPTCHA_SECRET_KEY;
    $recaptcha_response = $_POST['recaptcha_response'];

    // Make and decode POST request:
    $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
    $recaptcha = json_decode($recaptcha);

    // Assign recaptcha score to user
    $user->recaptcha_score = $recaptcha->score;
  }

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

// include js files as needed
$js_files = [
  'https://www.google.com/recaptcha/api.js?render=' . RECAPTCHA_SITE_KEY,
  '/js/recaptcha.js'
];

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

    <p>This site is protected by reCAPTCHA and the Google <a target="blank" href="https://policies.google.com/privacy">Privacy Policy</a> and <a target="blank" href="https://policies.google.com/terms">Terms of Service</a> apply.</p>

    <button type="submit" value="Sign up">Sign Up</button>

    <input type="hidden" name="recaptcha_response" id="recaptchaResponse">
  </form>
  <p>Already have an account? <a href="login.php">Login</a></p>
</div>

<?php

// Footer
include(SHARED_PATH . '/footer.php');

?>