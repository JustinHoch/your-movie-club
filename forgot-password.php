<?php

// Initialize
require_once('./private/initialize.php');

//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require './private/classes/PHPMailer/PHPMailer.php';
require './private/classes/PHPMailer/SMTP.php';
require './private/classes/PHPMailer/Exception.php';

$errors = [];
$email = '';

// Process form
if(is_post_request() && isset($_POST['email'])){

   // Test recaptcha response
   if(!empty($_POST['recaptcha_response'])){
    // Build POST request:
    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptcha_secret = RECAPTCHA_SECRET_KEY;
    $recaptcha_response = $_POST['recaptcha_response'];

    // Make and decode POST request:
    $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
    $recaptcha = json_decode($recaptcha);

    if($recaptcha->score <= 0.5){
      $errors[] = "Sorry! It looks like you might be a robot. If you are a human, please try again.";
    }
  }

  // check that email is associated with an account
  $email = $_POST['email'];
  $emailCheck = User::find_by_email($email);
  if($emailCheck == false){
    $errors[] = "No account with that email was found. Please make sure you have entered the correct email address.";
  }

  if(empty($errors)){
    $args = [];
    $token = bin2hex(random_bytes(25));
    $args['email'] = $email;
    $args['token'] = $token;
    $pwdReset = new PasswordReset($args);
    $pwdReset_result = $pwdReset->save();
    if($pwdReset_result){
      // send email with link to change password
      $mail = new PHPMailer();
      $mail->isSMTP();
      $mail->SMTPDebug = SMTP::DEBUG_SERVER;
      $mail->Host = 'smtp.gmail.com';
      $mail->Port = 465;
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
      $mail->SMTPAuth = true;
      $mail->Username = EMAIL_USERNAME;
      $mail->Password = EMAIL_PASSWORD;
      $mail->setFrom('justin@yourmovieclub.com', 'YMC');
      //Set who the message is to be sent to
      $mail->addAddress($email);
      $mail->isHTML(true);
      $mail->Subject = 'Password Reset for Your Movie Club';
      $bodyContent = '<h1>Reset Your Password</h1>'; 
      $bodyContent .= '<p>You have recieved this email because you requested a password reset for Your Movie Club account.</p>';
      $bodyContent .= '<p>Follow the link below to reset your password.</p>';
      $bodyContent .= SITE_BASE_URL . 'password-reset?token=' . $token;
      $mail->Body = $bodyContent;
      if (!$mail->send()) {
        $errors[] = "Email failed to send. Mailer Error " . $mail->ErrorInfo;
      } else {
        redirect_to('/reset-pending?email=' . $email);
      }
    }
  }
}

// include js files as needed
$js_files = [
  'https://www.google.com/recaptcha/api.js?render=' . RECAPTCHA_SITE_KEY,
  '/js/recaptcha.js'
];

// Page Title
$page_title = "Forgot Password";

// Header
include(SHARED_PATH . '/header.php');

?>

<div class="forms">
  <h2>Forgot Password</h2>
  <p>If you have forgotten your password you can request a password reset here. Enter the email you used to create your account and we will send you a link to make a new password.</p>
  
  <!-- Display errors -->
  <?php echo display_errors($errors); ?>

  <form action="/forgot-password" method="post">
    <label for="email">Email</label>
    <input type="text" id="email" placeholder="Email" name="email" value="<?php echo h($email); ?>" required>

    <input type="hidden" name="recaptcha_response" id="recaptchaResponse">
    <!-- For fixing recaptcha failing accessibility check -->
    <label for="g-recaptcha-response-100000" style="display: none;">Recaptcha</label>

    <button type="submit">Send Email</button>
  </form>
</div>

<?php

// Footer
include(SHARED_PATH . '/footer.php');

?>