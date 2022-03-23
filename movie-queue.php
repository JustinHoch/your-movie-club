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

// Get Current Movie
$current_movie = ClubMovie::find_current_movie($id);

// Get Coming Up Movies
$coming_up_movies = ClubMovie::find_coming_up_movies($id);

// Page Title
$page_title = "Movie Queue";

// Header
include(SHARED_PATH . '/header.php');

?>

<div class="movie-queue-page">
  <h2><a href="/club?id=<?php echo h($movie_club->id); ?>"><?php echo h($movie_club->club_name); ?></a> Movie Queue</h2>
  <p>You can add movies to your club queue by searching or exploring movies.</p>

  <?php if($current_movie !== false){ 
    $current_movie_details = apiMovie($current_movie->api_movie_id);
    $certification = getCerts($current_movie_details->release_dates);
  ?>
  <div class="queue-current">
    <h3>Current Movie</h3>
    <div class="current-queue-card">
      <a href="/movie?id=<?php echo h($current_movie_details->id); ?>">
        <img src="https://image.tmdb.org/t/p/w342<?php echo h($current_movie_details->poster_path); ?>" alt="<?php echo h($current_movie_details->title); ?> movie poster" height="513" width="342" loading=“lazy” decoding=“async>
      </a>
      <div>
        <h4><?php echo h($current_movie_details->title); ?></h4>
        <span><?php echo h($certification); ?></span>
        <p><?php echo h($current_movie_details->release_date); ?></p>
      </div>
    </div>
  </div>
  <div class="movie-queue">
    <h3>Coming Up</h3>

    <div>
      <?php if($coming_up_movies !== false){ ?>
        <?php foreach($coming_up_movies as $movie){ 
          $movie_details = apiMovie($movie->api_movie_id);
          $certification = getCerts($movie_details->release_dates);
        ?>
          <div class="queue-card queue-card-number">
            <a href="/movie?id=<?php echo h($movie_details->id); ?>">
              <img src="https://image.tmdb.org/t/p/w342<?php echo h($movie_details->poster_path); ?>" alt="<?php echo h($movie_details->title); ?> movie poster" height="513" width="342" loading=“lazy” decoding=“async>
            </a>
            <div>
              <h4><?php echo h($movie_details->title); ?></h4>
              <span><?php echo h($certification); ?></span>
              <p><?php echo h($movie_details->release_date); ?></p>
              <!-- <form action="" method="post">
                <button class="delete-button" type="submit" name="remove-movie" value="club-movie-id">Remove</button>
              </form> -->
            </div>
          </div>
        <?php } ?>
      <?php } ?>
    </div>
  </div>
  <?php }else{ ?>
    <p>There are currently no movies in the queue.</p>
  <?php } ?>
</div>

<?php

// Footer
include(SHARED_PATH . '/footer.php');

?>
