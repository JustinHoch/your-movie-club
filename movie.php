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

// Header
include(SHARED_PATH . '/header.php');

?>

<div class="movie-page">
  <div class="movie-details">
    <img src="https://image.tmdb.org/t/p/w780<?php echo h($movie_details->poster_path); ?>" alt="movie poster" height="513" width="342" loading=“lazy” decoding=“async>
    <div>
      <h2><?php echo h($movie_details->title); ?></h2>
      <?php if($certification){ ?>
      <p><?php echo h($certification); ?></p>
      <?php } ?>
      <P><?php echo h($movie_details->release_date); ?></P>
      <p><?php echo h($genres); ?></p>
      <p><?php echo h($movie_details->runtime); ?> minutes</p>
      <h2>Overview</h2>
      <p><?php echo h($movie_details->overview); ?></p>
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
        <img src="<?php echo h(checkActorimage($actor->profile_path)); ?>" alt="<?php echo h($actor->name); ?> headshot" height="513" width="342" loading=“lazy” decoding=“async>
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
