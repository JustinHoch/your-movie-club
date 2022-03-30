<?php

// Initialize
require_once('../private/initialize.php');

// Require user to be Logged in
require_login();

// Require user to be an admin
require_admin();

// Get user ID
if(!isset($_GET['id'])){
  redirect_to('/admin');
}
$id = $_GET['id'];

// Get User Info
$user = User::find_by_id($id);

// Redirect if no user is found
if($user == false){
  redirect_to('/admin');
}

// Redirect if user is a Super Admin
if($user->user_level == 3 && $session->user_level !== 3){
  redirect_to('/admin');
}

// Page Title
$page_title='Admin: User';

// Admin Page Title
$admin_title='User Information';

// Header
include(SHARED_PATH . '/header.php');

// Admin Header
include(SHARED_PATH . '/admin-header.php');

?>

<!-- Display Session Message -->
<?php echo display_session_message(); ?>

<div class="user-info">
  <div>
    <img src="/images/user/<?php echo h($user->avatar_path) ?>" alt="<?php echo h($user->username) ?> profile picture" height="250" width="250" loading=“lazy” decoding=“async”>
  </div>
  <div>
    <p><span>Username:</span> <?php echo h($user->username) ?></p>
    <p><span>Email:</span> <?php echo h($user->email) ?></p>
    <p><span>User Level:</span> <?php echo h($user->get_level_name()) ?></p>
    <p><span>Date Created:</span> <?php echo h($user->date_created) ?></p>
  </div>
  <div>
    <a href="/admin/edit-user?id=<?php echo h($user->id) ?>" class="link-button">Edit User</a>
    <a href="/admin/delete-user?id=<?php echo h($user->id) ?>" class="link-button-delete">Delete User</a>
  </div>
</div>

</div><!--End Admin Page-->

<?php

// Footer
include(SHARED_PATH . '/footer.php');

?>
