<?php

// Initialize
require_once('./private/initialize.php');

// Header
include(SHARED_PATH . '/header.php');

// API Functions
$trending_movies = apiTrendingMovies();
$trending_movies_week = apiTrendingMoviesWeek();
$trending_movies_day = apiTrendingMoviesDay();

?>

<?php if($session->is_logged_in()) { ?>
  <section class="main-cta">
    <h2>Welcome <?php echo $session->username ?></h2>
    <p>Here you can create movie clubs to connect with friends and family and discuss your favorite movies.</p>
    <p>Go to your account page to view and create movie clubs.</p>
    <a class="signup-link" href="/account" name="Go To Account">Go To Account</a>
  </section>
<?php }else{ ?>
  <section class="main-cta">
    <h2>Welcome to Your Movie Club!</h2>
    <p>Here you can create movie clubs to connect with friends and family and discuss your favorite movies.</p>
    <p>Sign Up today to create your own personal movie club!</p>
    <a class="signup-link" href="signup.php" name="Sign up">Sign Up</a>
  </section>
<?php } ?>

<section class="about-blurb">
  <h2>The Best Place to Discuss Your Favorite Movies</h2>
  <p>It’s like a book club, but for movies. You can create or join movie clubs, or just browse around for your next movie night! Invite friends to join movie clubs! With millions of movies to look through and the best way to watch, we’ve got you covered!</p>
</section>

<section class="popular-movies-container">
  <h2>Popular Movies</h2>
  <div class="popular-movies">
    <?php foreach($trending_movies->results as $movie) { ?>
    <div class="movie-card">
      <a href="movie.php?id=<?php echo h($movie->id); ?>">
        <img src="https://image.tmdb.org/t/p/w342<?php echo h($movie->poster_path); ?>" alt="<?php echo h($movie->title); ?> poster" height="513" width="342" loading=“lazy” decoding=“async>
        <p><?php echo h($movie->title); ?></p>
      </a>
    </div>
    <?php } ?>
  </div>
</section>

<section class="popular-movies-container">
  <h2>Popular Movies This Week</h2>
  <div class="popular-movies">
    <?php foreach($trending_movies_week->results as $movie) { ?>
    <div class="movie-card">
      <a href="movie.php?id=<?php echo h($movie->id); ?>">
        <img src="https://image.tmdb.org/t/p/w342<?php echo h($movie->poster_path); ?>" alt="<?php echo h($movie->title); ?> poster" height="513" width="342" loading=“lazy” decoding=“async>
        <p><?php echo h($movie->title); ?></p>
      </a>
    </div>
    <?php } ?> 
  </div>
</section>

<section class="popular-movies-container">
  <h2>Popular Movies Today</h2>
  <div class="popular-movies">
  <?php foreach($trending_movies_day->results as $movie) { ?>
    <div class="movie-card">
      <a href="movie.php?id=<?php echo h($movie->id); ?>">
        <img src="https://image.tmdb.org/t/p/w342<?php echo h($movie->poster_path); ?>" alt="<?php echo h($movie->title); ?> poster" height="513" width="342" loading=“lazy” decoding=“async>
        <p><?php echo h($movie->title); ?></p>
      </a>
    </div>
    <?php } ?>
  </div>
</section>

<?php

// Footer
include(SHARED_PATH . '/footer.php');

?>
