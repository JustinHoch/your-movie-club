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

// Check if user is club owner or admin
$owner_or_admin = false;
if($movie_club->club_owner_id == $session->user_id || $session->user_level != 1){
  $owner_or_admin = true;
}

// Check session user and club owner
if(!$owner_or_admin){
  redirect_to('/account');
}

// Process form
if(is_post_request()){
  if(isset($_POST['club'])){
    $movie_club->club_name = $_POST['club']['club_name'];
    $movie_club->description = $_POST['club']['description'];
    $result = $movie_club->save();
    if($result){
      $session->message('Your club was successfully updated!');
      redirect_to('/club?id=' . $id);
    }
  }
}

// Page Title
$page_title = "Edit Club";

// Header
include(SHARED_PATH . '/header.php');

?>

<div class="forms create-club">
  <h2>Edit Movie Club</h2>
  <form action="/edit-club?id=<?php echo h($id)  ?>" method="post">
    <label for="club-name">Movie Club Name</label>
    <input type="text" name="club[club_name]" id="club-name" value="<?php echo h($movie_club->club_name)  ?>" required>

    <label for="description">Movie Club Description</label>
    <p>Use the club description to say what kind of movies (genre, rating, where to watch, ...ect) and how often the movies will change.</p>
    <textarea name="club[description]" id="description" cols="30" rows="10" required><?php echo h($movie_club->description)  ?></textarea>

    <button type="submit">Edit Movie Club</button>
  </form>
  <a href="/delete-club?id=<?php echo h($id)  ?>" class="link-button-delete">Delete Club</a>
</div>

<?php

// Footer
include(SHARED_PATH . '/footer.php');

?>
