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
    if($user === false){
      $errors[] = "No account associated with that email was found.";
    }elseif(!$user->verify_password($password)){
      $errors[] = "Incorrect password.";
    }else{
      $session->login($user);
      redirect_to('account.php');
    }
  }
}

// Page Title
$page_title = "Login";

// Meta Description
$meta_description = 'Login in to your account at Your Movie Club.';

// Header
include(SHARED_PATH . '/header.php');

?>

<div class="forms">
  <h2>Login</h2>
  
  <!-- Display errors if $user->save() failed -->
  <?php echo display_errors($errors); ?>

  <form action="./login" method="post">
    <label for="email">Email</label>
    <input type="text" id="email" placeholder="Email" name="email" value="<?php echo h($email); ?>" required>

    <label for="password">Password</label>
    <input type="password" id="password" placeholder="Password" name="password" value="" required>

    <button type="submit">Login</button>
  </form>
  <p>Don't have an account? <a href="signup.php">Sign Up!</a></p>
  <p>Forgot your password? <a href="/forgot-password">Reset Password</a></p>
</div>

<?php

// Footer
include(SHARED_PATH . '/footer.php');

?>