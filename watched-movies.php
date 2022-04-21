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

// Require User to be a member of the club or admin
if(!require_club_member_or_admin($session->user_id, $id, $session->user_level)){
  redirect_to('/account');
}

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

// Get watched Movies
$watched_movies = ClubMovie::find_all_watched_movies($id);

// process form for delete movie
if(is_post_request()){
  // Remove movie from watched movies
  if(isset($_POST['remove-movie'])){
    $club_movie = ClubMovie::find_by_id($_POST['remove-movie']);
    $club_movie->delete();
    $session->message('The movie was successfully removed from the watched movies list!');
    redirect_to('/watched-movies?id=' . $id);
  }
}

// Page Title
$page_title = "Watched Movies";

// Header
include(SHARED_PATH . '/header.php');

?>

<div class="watched-movies-page">

  <!-- Display Session Message if there is one -->
  <?php echo display_session_message(); ?>

  <h2><a href="/club?id=<?php echo h($movie_club->id); ?>"><?php echo h($movie_club->club_name); ?></a> Watched Movies</h2>

  <p>This is a list of the movies that have been watched in this club.<br>You can visit the movies to see the details and comments for that movie.</p>

  <?php if($watched_movies != false){ ?>
  <div class="watched-movie-list">

    <?php foreach($watched_movies as $movie){ ?>
    <div class="watched-movie-card">
      <img src="<?php echo h(apiCheckImage($movie->poster_path)); ?>" alt="<?php echo h($movie->movie_title); ?> movie poster" height="513" width="342" loading=“lazy” decoding=“async>
      <div class="watched-movie-details">
        <h3><?php echo h($movie->movie_title); ?></h3>
        <p>Watched Date: <?php echo h(get_date_format($movie->watched_date ?? '')); ?></p>
        <a class="link-button" href="/watched-movie?id=<?php echo h($movie->id); ?>">View Movie</a>
      </div>
    </div>
    <?php } ?>

  </div>
  <?php }else{ ?>
  <p>There are no watched movies in this club!</p>
  <?php } ?>
  
</div>

<?php

// Footer
include(SHARED_PATH . '/footer.php');

?>
