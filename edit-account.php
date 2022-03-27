<?php

// Initialize
require_once('./private/initialize.php');

// Require user to be logged in
require_login();

// Get user
$user = User::find_by_id($session->user_id);

// Check for POST Request
if(is_post_request()){
  // update user atrributes and database. Display errors if anything goes wrong
  $args = $_POST['user'];
  $user->merge_attributes($args);
  $result = $user->save();
  if($result === true){
    $session->login($user);
    $session->message('Your account was updated successfully.');
    redirect_to('/account');
  }
}

// Page Title
$page_title = "Edit Account";

// Header
include(SHARED_PATH . '/header.php');

?>

<div class="forms">

  <!-- Display errors if $user->save() failed -->
  <?php echo display_errors($user->errors); ?>

  <h2>Edit Account</h2>
  <form action="/edit-account" method="post">
    <p>Change Avatar</p>
    <div id="avatar">
      <label class="avatar-radio" for="avatar1">
        <input type="radio" name="user[avatar_path]" id="avatar1" value="blue-cat.webp" <?php echo $session->avatar_path === 'blue-cat.webp' ? 'checked' : ''; ?>>
        <img src="/images/user/blue-cat.webp" alt="blue cat avatar" height="250" width="250" loading=“lazy” decoding=“async>
      </label>
      <label class="avatar-radio" for="avatar2">
        <input type="radio" name="user[avatar_path]" id="avatar2" value="blue-dog.webp" <?php echo $session->avatar_path === 'blue-dog.webp' ? 'checked' : ''; ?>>
        <img src="/images/user/blue-dog.webp" alt="blue dog avatar" height="250" width="250" loading=“lazy” decoding=“async>
      </label>
      <label class="avatar-radio" for="avatar3">
        <input type="radio" name="user[avatar_path]" id="avatar3" value="blue-rabbit.webp" <?php echo $session->avatar_path === 'blue-rabbit.webp' ? 'checked' : ''; ?>>
        <img src="/images/user/blue-rabbit.webp" alt="blue rabbit avatar" height="250" width="250" loading=“lazy” decoding=“async>
      </label>
      <label class="avatar-radio" for="avatar4">
        <input type="radio" name="user[avatar_path]" id="avatar4" value="green-cat.webp" <?php echo $session->avatar_path === 'green-cat.webp' ? 'checked' : ''; ?>>
        <img src="/images/user/green-cat.webp" alt="green cat avatar" height="250" width="250" loading=“lazy” decoding=“async>
      </label>
      <label class="avatar-radio" for="avatar5">
        <input type="radio" name="user[avatar_path]" id="avatar5" value="green-dog.webp" <?php echo $session->avatar_path === 'green-dog.webp' ? 'checked' : ''; ?>>
        <img src="/images/user/green-dog.webp" alt="green dog avatar" height="250" width="250" loading=“lazy” decoding=“async>
      </label>
      <label class="avatar-radio" for="avatar6">
        <input type="radio" name="user[avatar_path]" id="avatar6" value="green-rabbit.webp" <?php echo $session->avatar_path === 'green-rabbit.webp' ? 'checked' : ''; ?>>
        <img src="/images/user/green-rabbit.webp" alt="green rabbit avatar" height="250" width="250" loading=“lazy” decoding=“async>
      </label>
      <label class="avatar-radio" for="avatar7">
        <input type="radio" name="user[avatar_path]" id="avatar7" value="purple-cat.webp" <?php echo $session->avatar_path === 'purple-cat.webp' ? 'checked' : ''; ?>>
        <img src="/images/user/purple-cat.webp" alt="purple cat avatar" height="250" width="250" loading=“lazy” decoding=“async>
      </label>
      <label class="avatar-radio" for="avatar8">
        <input type="radio" name="user[avatar_path]" id="avatar8" value="purple-dog.webp" <?php echo $session->avatar_path === 'purple-dog.webp' ? 'checked' : ''; ?>>
        <img src="/images/user/purple-dog.webp" alt="purple dog avatar" height="250" width="250" loading=“lazy” decoding=“async>
      </label>
      <label class="avatar-radio" for="avatar9">
        <input type="radio" name="user[avatar_path]" id="avatar9" value="purple-rabbit.webp" <?php echo $session->avatar_path === 'purple-rabbit.webp' ? 'checked' : ''; ?>>
        <img src="/images/user/purple-rabbit.webp" alt="purple rabbit avatar" height="250" width="250" loading=“lazy” decoding=“async>
      </label>
    </div><!--End avatar-->

    <label for="email">Email</label>
    <input type="text" id="email" placeholder="Email" name="user[email]" value="<?php echo h($session->email); ?>">

    <label for="username">Username</label>
    <input type="text" id="username" placeholder="Username" name="user[username]" value="<?php echo h($session->username); ?>">

    <p>If you would like to change your password you can do so here. If not, just leave these fields blank.</p>

    <label for="password">Password</label>
    <input type="password" id="password" placeholder="password" name="user[unhashed_password]" value="<?php echo h($user->unhashed_password); ?>">

    <label for="confirm-password">Confirm Password</label>
    <input type="password" id="confirm-password" placeholder="retype password" name="user[confirm_password]" value="<?php echo h($user->confirm_password); ?>">

    <button type="submit">Update Account</button>
  </form>
  <a href="/delete-account" class="link-button-delete">Delete Account</a>
</div>

<?php

// Footer
include(SHARED_PATH . '/footer.php');

?>
