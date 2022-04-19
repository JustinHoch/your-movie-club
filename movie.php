<?php

// Initialize
require_once('./private/initialize.php');

// Page Title
$page_title = "Movie";

// Check for movie id
if($_GET['id']){
  $movie_id = h($_GET['id']);
}else{
  redirect_to('./');
}

// Get user clubs if logged in
if($session->is_logged_in()){
  $user_clubs = MovieClub::find_by_owner_id($session->user_id);
}

// Get movie details
$movie_details = apiMovie($movie_id);

// Get movie rating
$certification = getCerts($movie_details->release_dates);

// Get movie genres
$genres = getGenres($movie_details->genres);

// Get watch providers
$watch_providers = $movie_details->{'watch/providers'}->results;

// Get movie cast
$cast = $movie_details->credits->cast;

// Form Proccessing
if(is_post_request() && $user_clubs != false){
  // Check if user is a member of the club
  require_club_member($session->user_id, $_POST['club_id']);
  // Get movie club details
  $movie_club = MovieClub::find_by_id($_POST['club_id']);
  // Check if movie is already in queue
  $movie_queue = ClubMovie::find_all_unwatched_movies($movie_club->id);
  if($movie_queue != false){
    foreach($movie_queue as $queue_movie){
      if($queue_movie->api_movie_id == $movie_id){
        $session->message('This movie is already in ' . $movie_club->club_name . ' movie queue.');
        redirect_to('/movie?id=' . $movie_id);
      }
    }
    if(count($movie_queue) == 20){
      $session->message('' . $movie_club->club_name . ' has reached the maximum amount of movies allowed in the queue.');
      redirect_to('/movie?id=' . $movie_id);
    }
  }
  // Check if user is the owner of the club
  if($movie_club->club_owner_id == $session->user_id){
    $args = array(
      'api_movie_id' => $movie_id,
      'movie_club_id' => $movie_club->id,
      'user_id' => $session->user_id,
      'poster_path' => $movie_details->poster_path,
      'movie_title' => $movie_details->title
    );
    $new_movie = new ClubMovie($args);
    $result = $new_movie->save();
    if($result){
      $session->message('' . $movie_details->title . ' has been added to ' . $movie_club->club_name . '.');
      redirect_to('/movie?id=' . $movie_id);
    }
  }
}

// Header
include(SHARED_PATH . '/header.php');

?>

<div class="movie-page">

  <!-- Display Session Message if there is one -->
  <?php echo display_session_message(); ?>

  <div class="movie-details">
    <img src="<?php echo h(apiCheckImage($movie_details->poster_path)); ?>" alt="movie poster" height="513" width="342" loading=“lazy” decoding=“async>
    <div>
      <h2><?php echo h($movie_details->title); ?></h2>
      <?php if($certification){ ?>
      <p><?php echo h($certification); ?></p>
      <?php } ?>
      <p><?php echo h(get_year_format($movie_details->release_date ?? '')); ?></p>
      <p><?php echo h($genres); ?></p>
      <p><?php echo h($movie_details->runtime); ?> minutes</p>
      <h2>Overview</h2>
      <p><?php echo h($movie_details->overview); ?></p>
      <?php if($session->is_logged_in() && $user_clubs != false){ ?>
        <form action="/movie?id=<?php echo h($movie_id); ?>" method="post">
          <label for="clubs">Add to movie queue</label>
          <select name="club_id" id="clubs">
            <?php foreach($user_clubs as $club){ ?>
              <option value="<?php echo h($club->id); ?>"><?php echo h($club->club_name); ?></option>
            <?php } ?>
          </select>
          <button type="submit">Add to Queue</button>
        </form>
      <?php } ?>
    </div>
  </div>

  <?php if(property_exists($watch_providers, "US")){ ?>
  <div class="watch-providers">
    <h2>Watch providers</h2>

    <?php if(property_exists($watch_providers->US, "flatrate")){ ?>
    <div class="watch-type">
      <h3>Streaming</h3>
      <div class="provider-container">
        <?php foreach($watch_providers->US->flatrate as $provider){ ?>
        <div class="wp-card">
          <img src="https://image.tmdb.org/t/p/original<?php echo h($provider->logo_path); ?>" alt="<?php echo h($provider->provider_name); ?>" height="100" width="100" loading=“lazy” decoding=“async>
        </div>
        <?php } ?>
      </div>
    </div>
    <?php } ?>

    <?php if(property_exists($watch_providers->US, "rent")){ ?>
    <div class="watch-type">
      <h3>Rent</h3>
      <div class="provider-container">
        <?php foreach($watch_providers->US->rent as $provider){ ?>
        <div class="wp-card">
          <img src="https://image.tmdb.org/t/p/original<?php echo h($provider->logo_path); ?>" alt="<?php echo h($provider->provider_name); ?>" height="100" width="100" loading=“lazy” decoding=“async>
        </div>
        <?php } ?>
      </div>
    </div>
    <?php } ?>

    <?php if(property_exists($watch_providers->US, "buy")){ ?>
    <div class="watch-type">
      <h3>Buy</h3>
      <div class="provider-container">
        <?php foreach($watch_providers->US->buy as $provider){ ?>
        <div class="wp-card">
          <img src="https://image.tmdb.org/t/p/original<?php echo h($provider->logo_path); ?>" alt="<?php echo h($provider->provider_name); ?>" height="100" width="100" loading=“lazy” decoding=“async>
        </div>
        <?php } ?>
      </div>
    </div>
    <?php } ?>
    
  </div><!--End watch-providers-->
  <?php } ?>

  <div class="movie-cast">
    <h2>Top Cast</h2>
    <div class="cast-container">
      <?php foreach($cast as $actor){ ?>
      <div class="cast-card">
        <img src="<?php echo h(apiCheckImage($actor->profile_path)); ?>" alt="<?php echo h($actor->name); ?> headshot" height="513" width="342" loading=“lazy” decoding=“async>
        <h3><?php echo h($actor->name); ?></h3>
        <p><?php echo h($actor->character); ?></p>
      </div>
      <?php } ?>
    </div><!--End cast-container-->
  </div><!--End movie-cast-->
</div>

<?php

// Footer
include(SHARED_PATH . '/footer.php');

?>
