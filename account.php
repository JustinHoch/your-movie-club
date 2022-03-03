<?php

// Initialize
require_once('./private/initialize.php');

// Require User
if(!$session->is_logged_in()) {
  redirect_to('./login.php');
} else {
  // Get user data
  $user = User::find_by_id($session->user_id);
  // Get user clubs
  $clubs = MovieClub::find_by_owner_id($user->id);
}

// Page Title
$page_title = "Home";

// Header
include(SHARED_PATH . '/header.php');

?>

<div class="account-page">
  <section class="account-details">
    <img src="/images/user/<?php echo h($user->avatar_path) ?>" alt="User profile picture" height="250" width="250" loading=“lazy” decoding=“async”>
    <div>
      <h2><?php echo h($user->username) ?></h2>
      <p><?php echo h($user->email) ?></p>
      <p>Member since: <?php echo h($user->date_created) ?></p>
      <a href="account-edit.php" class="link-button">Edit Account</a>
    </div>
  </section>

  <section class="account-clubs">
    <h2>Your Movie Clubs</h2>
    <a href="create-club.php" class="link-button">Create Movie Club</a>
    <div class="clubs">
    <?php if($clubs !== false) { ?>
      <?php foreach($clubs as $club) {
        $club_movie = ClubMovie::find_current_movie($club->id);
        $movie = apiMovie($club_movie->api_movie_id);
      ?>
      <a href="club.php?=<?php echo h($club->id) ?>" class="club-card">
        <img src="https://image.tmdb.org/t/p/w154<?php echo h($movie->poster_path) ?>" alt="movie poster" height="231" width="154" loading=“lazy” decoding=“async>
        <div>
          <h3><?php echo h($club->club_name) ?></h3>
          <p><span>Current Movie:</span> <?php echo h($movie->title) ?></p>
          <p><span>Created By:</span> <?php echo h($user->username) ?></p>
        </div>
      </a>
      <?php } // end for each?>
    <?php } // end if?>
    
    </div>
  </section>
</div> <!-- End account-page div -->

<?php

// Footer
include(SHARED_PATH . '/footer.php');

?>
