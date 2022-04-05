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
  $clubs = ClubMember::find_all_members_by_user_id($user->id);
}

// Page Title
$page_title = "Account";

// Header
include(SHARED_PATH . '/header.php');

?>

<div class="account-page">
  <h2>Account</h2>

  <!-- Display Session Message if there is one -->
  <?php echo display_session_message(); ?>

  <section class="account-details">
    <img src="/images/user/<?php echo h($user->avatar_path) ?>" alt="User profile picture" height="250" width="250" loading=“lazy” decoding=“async”>
    <div>
      <h2><?php echo h($user->username) ?></h2>
      <p><?php echo h($user->email) ?></p>
      <p>Member since: <?php echo h(get_date_format($user->date_created)) ?></p>
      <a href="edit-account.php" class="link-button">Edit Account</a>
    </div>
  </section>

  <section class="account-clubs">
    <h2>Your Movie Clubs</h2>
    <a href="create-club.php" class="link-button">Create Movie Club</a>
    <div class="clubs">
    <?php if($clubs !== false) { ?>
      <?php foreach($clubs as $club) {
        $club_details = MovieClub::find_by_id($club->movie_club_id);
        $club_owner = User::find_by_id($club_details->club_owner_id);
        $club_movie = ClubMovie::find_current_movie($club_details->id);
        ?>
        <?php if($club_movie !== false) { 
          $movie = apiMovie($club_movie->api_movie_id);
        ?>
          <a href="club.php?id=<?php echo h($club_details->id) ?>" class="club-card">
            <img src="<?php echo h(apiCheckImage($movie->poster_path)); ?>" alt="movie poster" height="231" width="154" loading=“lazy” decoding=“async>
            <div>
              <h3><?php echo h($club_details->club_name) ?></h3>
              <p><span>Current Movie:</span> <?php echo h($movie->title) ?></p>
              <p><span>Created By:</span> <?php echo h($club_owner->username) ?></p>
            </div>
          </a>
        <?php }else{?>
          <a href="club.php?id=<?php echo h($club_details->id) ?>" class="club-card">
            <img src="/images/tmdb/missing-image.webp" alt="missing image" height="513" width="342" loading=“lazy” decoding=“async>
            <div>
              <h3><?php echo h($club_details->club_name) ?></h3>
              <p>No Current Movie</p>
              <p><span>Created By:</span> <?php echo h($club_owner->username) ?></p>
            </div>
          </a>
        <?php } // end else?>
      <?php } // end for each?>
    <?php } // end if?>
    
    </div>
  </section>
</div> <!-- End account-page div -->

<?php

// Footer
include(SHARED_PATH . '/footer.php');

?>
