<?php

// Initialize
require_once('./private/initialize.php');

// Require user to be logged in
require_login();

// Get club movie ID
if(!isset($_GET['id'])){
  redirect_to('/account');
}
$id = $_GET['id'];

// Get watched movie details
$watched_club_movie = ClubMovie::find_by_id($id);
if($watched_club_movie == false){
  redirect_to('/account');
}

// Get movie club details
$movie_club = MovieClub::find_by_id($watched_club_movie->movie_club_id);

// Require User to be a member of the club or admin
if(!require_club_member_or_admin($session->user_id, $movie_club->id, $session->user_level)){
  redirect_to('/account');
}

// Check if user is club owner or admin
$owner_or_admin = false;
if($movie_club->club_owner_id == $session->user_id || $session->user_level != 1){
  $owner_or_admin = true;
}

// Get movie details
$movie_details = apiMovie($watched_club_movie->api_movie_id);

// Get movie comments
$comments = Comment::find_all_movie_comments($watched_club_movie->id);

// Page Title
$page_title = "Watched Movie";

// Header
include(SHARED_PATH . '/header.php');

?>

<div class="club-page">

  <!-- Display errors if $new_comment->save() -->
  

  <!-- Display Session Message if there is one -->
  <?php echo display_session_message(); ?>

  <h2><?php echo h($watched_club_movie->movie_title) ?></h2>
  <p><b>Movie Club:</b> <a href="/club?id=<?php echo h($movie_club->id) ?>"><?php echo h($movie_club->club_name) ?></a></p>
  <p><b>Watched On:</b> <?php echo h(get_date_format($watched_club_movie->watched_date ?? '')) ?></p>
  <div class="club-details">
      <div class="current-movie-details">
        <div>
          <a href="/movie?id=<?php echo h($watched_club_movie->api_movie_id) ?>">
            <img src="<?php echo h(apiCheckImage($watched_club_movie->poster_path)); ?>" alt="<?php echo h($watched_club_movie->movie_title) ?> poster" height="513" width="342" loading=“lazy” decoding=“async>
          </a>
          <div>
            <h3><?php echo h($watched_club_movie->movie_title) ?></h3>
            <p><?php echo h(get_year_format($movie_details->release_date ?? '')); ?></p>
            <p><?php echo h($movie_details->overview) ?></p>
          </div>
        </div>
      </div><!--End current-movie-details-->

      <?php if($owner_or_admin){ ?>
      <div class="club-links">
        <ul>
          <li><a href="/delete-watched-movie?id=<?php echo h($id) ?>" class="link-button-delete">Delete Movie</a></li>
        </ul>
      </div>
      <?php } ?>
  </div><!--End current-movie-->

    <div class="discussion">
      <h3>Discussion</h3>
      
      <div class="comments">
        <?php if($comments !== false){ ?>
          <?php foreach($comments as $comment){
            $comment_user = User::find_by_id($comment->user_id);
          ?>
          <div class="comment">
            <div class="comment-user">
              <img src="/images/user/<?php echo h($comment_user->avatar_path) ?>" alt="<?php echo h($comment_user->username) ?> profile picture" height="250" width="250" loading=“lazy” decoding=“async”>
              <div>
                <p><?php echo h($comment_user->username) ?></p>
                <p><?php echo h(get_date_format($comment->date_created)) ?></p>
              </div>
            </div>
            <p><?php echo h($comment->comment_text) ?></p>
          </div>
          <?php } ?>
        <?php } else { ?>
          <p>There are no comments for this movie.</p>
        <?php } ?>

      </div>
    </div><!--End discussion-->
</div><!--End Club-page-->

<?php

// Footer
include(SHARED_PATH . '/footer.php');

?>
