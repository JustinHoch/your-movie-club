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

// Delete account form
if(is_post_request()){
  if(isset($_POST['delete'])){
    $result = $user->delete();
    $session->message('User ' . $user->username .  '\'s account has been deleted.');
    redirect_to('/admin');
  }
}

// Page Title
$page_title = "Admin: Delete User";

// Admin Page Title
$admin_title='Delete ' . $user->username . '\'s Account';

// Header
include(SHARED_PATH . '/header.php');

// Admin Header
include(SHARED_PATH . '/admin-header.php');

?>

<div class="forms">
  <p>Are you sure you want to delete this user account?</p>
  <p>You will not be able to undo this action!</p>
  <form action="/admin/delete-user?id=<?php echo $id; ?>" method="post">
    <button type="submit" class="delete-button" name="delete">Delete Account</button>
  </form>
</div>

<?php

// Footer
include(SHARED_PATH . '/footer.php');

?>
