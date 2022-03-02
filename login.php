<?php

// Initialize
require_once('./private/initialize.php');

$errors = [];
$email = '';
$password = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {

  $email = $_POST['email'] ?? '';
  $password = $_POST['password'] ?? '';

  // Validations
  if(is_blank($email)) {
    $errors[] = "Email cannot be blank.";
  }
  if(is_blank($password)) {
    $errors[] = "Password cannot be blank.";
  }

  // if there were no errors, try to login
  if(empty($errors)) {
    $user = User::find_by_email($email);
    // test if user found and password is correct
    if($user != false && $user->verify_password($password)) {
      // Mark admin as logged in
      $session->login($user);
      redirect_to('./');
    } else {
      // username not found or password does not match
      $errors[] = "Log in was unsuccessful.";
    }

  }

}

// Page Title
$page_title = "Login";

// Header
include(SHARED_PATH . '/header.php');

?>

<div class="forms">
  <h2>Login</h2>
  
  <!-- Display errors if $user->save() failed -->
  <?php echo display_errors($errors); ?>

  <form action="./login" method="post">
    <label for="email">Email</label>
    <input type="text" placeholder="Email" name="email" value="<?php echo h($email); ?>" required>

    <label for="password">Password</label>
    <input type="password" placeholder="Password" name="password" value="" required>

    <button type="submit">Login</button>
  </form>
  <p>Don't have an account? <a href="signup.html">Sign Up!</a></p>
</div>

<?php

// Footer
include(SHARED_PATH . '/footer.php');

?>