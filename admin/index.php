<?php

// Initialize
require_once('../private/initialize.php');

// Require user to be Logged in
require_login();

// Require user to be an admin
require_admin();

// Get Users
$users = User::find_all();

// Page Title
$page_title='Admin: Dashboard';

// Admin Page Title
$admin_title='Admin Dashboard';

// Header
include(SHARED_PATH . '/header.php');

// Admin Header
include(SHARED_PATH . '/admin-header.php');

?>

<!-- Display Session Message -->
<?php echo display_session_message(); ?>

<div class="users">
  <h3>Users</h3>
  <div class="user-list">

  <?php foreach($users as $user){
    if($user->user_level == 3 && $session->user_level != 3){
      continue;
    }  
  ?>

    <div class="user-card">
      <div>
        <h4><?php echo h($user->username) ?></h4>
        <p><?php echo h($user->email) ?></p>
        <p><span>User Level:</span> <?php echo h($user->get_level_name()) ?></p>
      </div>
      <div>
        <a href="/admin/user?id=<?php echo h($user->id) ?>" class="link-button">View</a>
      </div>
    </div>

  <?php } ?>
    
  </div>
</div>

</div><!--End Admin Page-->

<?php

// Footer
include(SHARED_PATH . '/footer.php');

?>
