<?php

// Initialize
require_once('./private/initialize.php');

// Require user to be logged in
require_login();

// Get Movie Club ID
if(!isset($_GET['id'])){
  redirect_to('/account');
}
$id = $_GET['id'];

// Get Movie Club Details
$movie_club = MovieClub::find_by_id($id);
if($movie_club == false){
  redirect_to('/account');
}
$movie_club_owner = User::find_by_id($movie_club->club_owner_id);

// Check session user and club owner
if($movie_club_owner->id != $session->user_id){
  redirect_to('/account');
}

// Process form
if(is_post_request()){
  if(isset($_POST['deleteBtn'])){
    $movie_club->delete();
    $session->message('Your club was successfully deleted!');
    redirect_to('/account');
  }
}

// Page Title
$page_title = "Delete Club";

// Header
include(SHARED_PATH . '/header.php');

?>

<div class="forms">
  <h2>Delete Club</h2>
  <p>Are you sure you want to delete this club?</p>
  <p>You will not be able to undo this action!</p>
  <form action="/delete-club?id=<?php echo h($id)  ?>" method="post">
    <button type="submit" class="delete-button" name="deleteBtn" value="delete">Delete Club</button>
  </form>
</div>

<?php

// Footer
include(SHARED_PATH . '/footer.php');

?>
