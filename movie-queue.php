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

// Require User to be a member of the club
require_club_member($session->user_id, $id);

// Get Movie Club Details
$movie_club = MovieClub::find_by_id($id);
if($movie_club == false){
  redirect_to('/account');
}

// Get Coming Up Movies
$movie_queue = ClubMovie::find_all_unwatched_movies($id);

// Get current movie
if($movie_queue != false){
  $coming_up_movies = array_slice($movie_queue, 1);
}

// Page Title
$page_title = "Movie Queue";

// Form processing
if(is_post_request()){
  // Remove movie from queue
  if($session->user_id == $movie_club->club_owner_id && isset($_POST['remove-movie'])){
    $club_movie = ClubMovie::find_by_id($_POST['remove-movie']);
    $club_movie->delete();
    $session->message('Queue updated!');
    redirect_to('/movie-queue?id=' . $id);
  }
  // Go to next movie in queue
  if($session->user_id == $movie_club->club_owner_id && isset($_POST['next-movie'])){
    $club_movie = ClubMovie::find_by_id($_POST['next-movie']);
    $club_movie->watched_status = 1;
    $result = $club_movie->save();
    if($result){
      $session->message('Queue updated!');
      redirect_to('/movie-queue?id=' . $id);
    }
  }
}

// Header
include(SHARED_PATH . '/header.php');

?>

<div class="movie-queue-page">

  <!-- Display Session Message if there is one -->
  <?php echo display_session_message(); ?>

  <h2><a href="/club?id=<?php echo h($movie_club->id); ?>"><?php echo h($movie_club->club_name); ?></a> Movie Queue</h2>
  <p>You can add movies to your club queue by searching or exploring movies.</p>

  <?php if($movie_queue !== false){ 
    $current_movie = $movie_queue[0];
    $current_movie_details = apiMovie($current_movie->api_movie_id);
    $certification = getCerts($current_movie_details->release_dates);
  ?>
  <div class="queue-current">
    <h3>Current Movie</h3>
    <div class="current-queue-card">
      <a href="/movie?id=<?php echo h($current_movie_details->id); ?>">
        <img src="<?php echo h(apiCheckImage($current_movie_details->poster_path)); ?>" alt="<?php echo h($current_movie_details->title); ?> movie poster" height="513" width="342" loading=“lazy” decoding=“async>
      </a>
      <div>
        <h4><?php echo h($current_movie_details->title); ?></h4>
        <span><?php echo h($certification); ?></span>
        <p><?php echo h(get_year_format($current_movie_details->release_date ?? '')); ?></p>
        <?php if($session->user_id == $movie_club->club_owner_id){ ?>
          <form action="/movie-queue?id=<?php echo h($id); ?>" method="post">
            <button class="link-button" type="submit" name="next-movie" value="<?php echo h($current_movie->id); ?>">Next Movie</button>
          </form>
        <?php } ?>
      </div>
    </div>
  </div>
  <div class="movie-queue">
    <h3>Coming Up</h3>

    <div>
      <?php if($movie_queue !== false){ ?>
        <?php foreach($coming_up_movies as $movie){ 
          // $movie_details = apiMovie($movie->api_movie_id);
          // $certification = getCerts($movie_details->release_dates);
        ?>
          <div class="queue-card queue-card-number">
            <a href="/movie?id=<?php echo h($movie->api_movie_id); ?>">
              <img src="<?php echo h(apiCheckImage($movie->poster_path)); ?>" alt="<?php echo h($movie->movie_title); ?> movie poster" height="513" width="342" loading=“lazy” decoding=“async>
            </a>
            <div>
              <h4><?php echo h($movie->movie_title); ?></h4>
              <?php if($session->user_id == $movie_club->club_owner_id){ ?>
                <form action="/movie-queue?id=<?php echo h($id); ?>" method="post">
                  <button class="link-button" type="submit" name="remove-movie" value="<?php echo h($movie->id); ?>">Remove From Queue</button>
                </form>
              <?php } ?>
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
