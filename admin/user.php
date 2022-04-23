<?php

// Initialize
require_once('../private/initialize.php');

// Require user to be Logged in
require_login();

// Require user to be an admin
require_admin();

// Get user ID
if(!isset($_GET['id'])){
  redirect_to('/admin');
}
$id = $_GET['id'];

// Get User Info
$user = User::find_by_id($id);

// Redirect if no user is found
if($user == false){
  redirect_to('/admin');
}

// Redirect if user is a Super Admin and the logged in user is NOT a Super Admin
if($user->user_level == 3 && $session->user_level != 3){
  redirect_to('/admin');
}

// Find all User made movie clubs
$user_clubs = MovieClub::find_by_owner_id($user->id);

// Page Title
$page_title='Admin: User';

// Admin Page Title
$admin_title='User Information';

// Header
include(SHARED_PATH . '/header.php');

// Admin Header
include(SHARED_PATH . '/admin-header.php');

?>

<!-- Display Session Message -->
<?php echo display_session_message(); ?>

<div class="user-info">
  <div>
    <img src="/images/user/<?php echo h($user->avatar_path) ?>" alt="<?php echo h($user->username) ?> profile picture" height="250" width="250" loading=“lazy” decoding=“async”>
  </div>
  <div>
    <p><span>Username:</span> <?php echo h($user->username) ?></p>
    <p><span>Email:</span> <?php echo h($user->email) ?></p>
    <p><span>User Level:</span> <?php echo h($user->get_level_name()) ?></p>
    <p><span>Date Created:</span> <?php echo h($user->date_created) ?></p>
  </div>
  <div>
    <a href="/admin/edit-user?id=<?php echo h($user->id) ?>" class="link-button">Edit User</a>
    <a href="/admin/delete-user?id=<?php echo h($user->id) ?>" class="link-button-delete">Delete User</a>
  </div>
</div>

<div class="account-clubs">
  <h2>Clubs Created By <?php echo h($user->username) ?></h2>
  <div class="clubs">
    <?php if($user_clubs != false){ ?>
      <?php foreach($user_clubs as $club){
        $club_details = MovieClub::find_by_id($club->id);
        $current_movie = ClubMovie::find_current_movie($club_details->id);
        ?>
        <?php if($current_movie !== false) {  ?>
          <a href="/club.php?id=<?php echo h($club_details->id) ?>" class="club-card">
            <img src="<?php echo h(apiCheckImage($current_movie->poster_path)); ?>" alt="<?php echo h($current_movie->movie_title) ?> movie poster" height="231" width="154" loading=“lazy” decoding=“async>
            <div>
              <h3><?php echo h($club_details->club_name) ?></h3>
              <p><span>Current Movie:</span> <?php echo h($current_movie->movie_title) ?></p>
            </div>
          </a>
        <?php }else{?>
          <a href="/club.php?id=<?php echo h($club_details->id) ?>" class="club-card">
            <img src="/images/tmdb/missing-image.webp" alt="missing image" height="513" width="342" loading=“lazy” decoding=“async>
            <div>
              <h3><?php echo h($club_details->club_name) ?></h3>
              <p>No Current Movie</p>
            </div>
          </a>
        <?php } // end else?>
      <?php } ?>
    <?php }else{ ?>
      <h3>This user has not created any clubs.</h3>
      <img src="/images/other/empty-space-holder.svg" alt="person with stars and the words empty space" style="box-shadow: none;">
    <?php } ?>
  </div>
</div>

</div><!--End Admin Page-->

<?php

// Footer
include(SHARED_PATH . '/footer.php');

?>
