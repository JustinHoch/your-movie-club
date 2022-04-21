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

// Get watched movie details
$watched_club_movie = ClubMovie::find_by_id($id);
if($watched_club_movie == false){
  redirect_to('/account');
}

// Get Movie Club Details
$movie_club = MovieClub::find_by_id($watched_club_movie->movie_club_id);
if($movie_club == false){
  redirect_to('/account');
}

// Check if user is club owner or admin
$owner_or_admin = false;
if($movie_club->club_owner_id == $session->user_id || $session->user_level != 1){
  $owner_or_admin = true;
}

// redirect if not owner or admin
if(!$owner_or_admin){
  redirect_to('/account');
}

// Process form
if(is_post_request()){
  if(isset($_POST['deleteBtn'])){
    $watched_club_movie->delete();
    $session->message('The watched movie was successfully deleted!');
    redirect_to('/watched-movies?id=' . $movie_club->id);
  }
}

// Page Title
$page_title = "Delete Watched Movie";

// Header
include(SHARED_PATH . '/header.php');

?>

<div class="forms">
  <h2>Delete Watched Movie</h2>
  <p>Are you sure you want to delete this watched movie?</p>
  <p>You will not be able to undo this action!</p>
  <form action="/delete-watched-movie?id=<?php echo h($id)  ?>" method="post">
    <button type="submit" class="delete-button" name="deleteBtn" value="delete">Delete Movie</button>
  </form>
</div>

<?php

// Footer
include(SHARED_PATH . '/footer.php');

?>