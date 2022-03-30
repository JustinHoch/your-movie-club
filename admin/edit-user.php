<?php

// Initialize
require_once('../private/initialize.php');

// Require user to be logged in
require_login();

// Require user to be an admin
require_admin();

// Get user ID
if(!isset($_GET['id'])){
  redirect_to('/admin');
}
$id = $_GET['id'];

// Get user
$user = User::find_by_id($id);

// Redirect if no user is found
if($user == false){
  redirect_to('/admin');
}

// Redirect if user is a Super Admin
if($user->user_level == 3 && $session->user_level !== 3){
  redirect_to('/admin');
}

// Check for POST Request
if(is_post_request()){
  // update user atrributes and database. Display errors if anything goes wrong
  $args = $_POST['user'];
  $user->merge_attributes($args);
  $result = $user->save();
  if($result === true){
    $session->message('User was updated successfully.');
    redirect_to('/admin/user?id=' . $id);
  }
}

// Page Title
$page_title = "Admin: Edit User";

// Admin Page Title
$admin_title='Edit User Information';

// Header
include(SHARED_PATH . '/header.php');

// Admin Header
include(SHARED_PATH . '/admin-header.php');

?>

<div class="forms">

  <!-- Display errors if $user->save() failed -->
  <?php echo display_errors($user->errors); ?>

  <form action="/admin/edit-user?id=<?php echo $id; ?>" method="post">
    <p>Change Avatar</p>
    <div id="avatar">
      <label class="avatar-radio" for="avatar1">
        <input type="radio" name="user[avatar_path]" id="avatar1" value="blue-cat.webp" <?php echo $user->avatar_path === 'blue-cat.webp' ? 'checked' : ''; ?>>
        <img src="/images/user/blue-cat.webp" alt="blue cat avatar" height="250" width="250" loading=“lazy” decoding=“async>
      </label>
      <label class="avatar-radio" for="avatar2">
        <input type="radio" name="user[avatar_path]" id="avatar2" value="blue-dog.webp" <?php echo $user->avatar_path === 'blue-dog.webp' ? 'checked' : ''; ?>>
        <img src="/images/user/blue-dog.webp" alt="blue dog avatar" height="250" width="250" loading=“lazy” decoding=“async>
      </label>
      <label class="avatar-radio" for="avatar3">
        <input type="radio" name="user[avatar_path]" id="avatar3" value="blue-rabbit.webp" <?php echo $user->avatar_path === 'blue-rabbit.webp' ? 'checked' : ''; ?>>
        <img src="/images/user/blue-rabbit.webp" alt="blue rabbit avatar" height="250" width="250" loading=“lazy” decoding=“async>
      </label>
      <label class="avatar-radio" for="avatar4">
        <input type="radio" name="user[avatar_path]" id="avatar4" value="green-cat.webp" <?php echo $user->avatar_path === 'green-cat.webp' ? 'checked' : ''; ?>>
        <img src="/images/user/green-cat.webp" alt="green cat avatar" height="250" width="250" loading=“lazy” decoding=“async>
      </label>
      <label class="avatar-radio" for="avatar5">
        <input type="radio" name="user[avatar_path]" id="avatar5" value="green-dog.webp" <?php echo $user->avatar_path === 'green-dog.webp' ? 'checked' : ''; ?>>
        <img src="/images/user/green-dog.webp" alt="green dog avatar" height="250" width="250" loading=“lazy” decoding=“async>
      </label>
      <label class="avatar-radio" for="avatar6">
        <input type="radio" name="user[avatar_path]" id="avatar6" value="green-rabbit.webp" <?php echo $user->avatar_path === 'green-rabbit.webp' ? 'checked' : ''; ?>>
        <img src="/images/user/green-rabbit.webp" alt="green rabbit avatar" height="250" width="250" loading=“lazy” decoding=“async>
      </label>
      <label class="avatar-radio" for="avatar7">
        <input type="radio" name="user[avatar_path]" id="avatar7" value="purple-cat.webp" <?php echo $user->avatar_path === 'purple-cat.webp' ? 'checked' : ''; ?>>
        <img src="/images/user/purple-cat.webp" alt="purple cat avatar" height="250" width="250" loading=“lazy” decoding=“async>
      </label>
      <label class="avatar-radio" for="avatar8">
        <input type="radio" name="user[avatar_path]" id="avatar8" value="purple-dog.webp" <?php echo $user->avatar_path === 'purple-dog.webp' ? 'checked' : ''; ?>>
        <img src="/images/user/purple-dog.webp" alt="purple dog avatar" height="250" width="250" loading=“lazy” decoding=“async>
      </label>
      <label class="avatar-radio" for="avatar9">
        <input type="radio" name="user[avatar_path]" id="avatar9" value="purple-rabbit.webp" <?php echo $user->avatar_path === 'purple-rabbit.webp' ? 'checked' : ''; ?>>
        <img src="/images/user/purple-rabbit.webp" alt="purple rabbit avatar" height="250" width="250" loading=“lazy” decoding=“async>
      </label>
    </div><!--End avatar-->

    <label for="email">Email</label>
    <input type="text" id="email" placeholder="Email" name="user[email]" value="<?php echo h($user->email); ?>">

    <label for="username">Username</label>
    <input type="text" id="username" placeholder="Username" name="user[username]" value="<?php echo h($user->username); ?>">

    <label for="user-level">User Level</label>
    <select name="user[user_level]" id="user-level">
      <option value="1" <?php echo $user->user_level == 1 ? 'selected' : '' ?>>Member</option>
      <option value="2" <?php echo $user->user_level == 2 ? 'selected' : '' ?>>Admin</option>
      <?php if($session->user_level == 3){ ?>
        <option value="3" <?php echo $user->user_level == 3 ? 'selected' : '' ?>>Super Admin</option>
      <?php } ?>
    </select>

    <p>If you would like to change your password you can do so here. If not, just leave these fields blank.</p>

    <label for="password">Password</label>
    <input type="password" id="password" placeholder="password" name="user[unhashed_password]" value="<?php echo h($user->unhashed_password); ?>">

    <label for="confirm-password">Confirm Password</label>
    <input type="password" id="confirm-password" placeholder="retype password" name="user[confirm_password]" value="<?php echo h($user->confirm_password); ?>">

    <button type="submit">Update Account</button>
  </form>
</div>

</div><!--End Admin Page-->

<?php

// Footer
include(SHARED_PATH . '/footer.php');

?>
