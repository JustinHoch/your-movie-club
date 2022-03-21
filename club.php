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
$movie_club_owner = User::find_by_id($movie_club->club_owner_id);
$current_movie = ClubMovie::find_current_movie($movie_club->id);
$current_movie_details = apiMovie($current_movie->api_movie_id);
$comments = Comment::find_all_movie_comments($current_movie->id);

// Post Comment
if(is_post_request()){
  $_POST['comment']['user_id'] = $session->user_id;
  $_POST['comment']['movie_clubs_id'] = $id;
  $_POST['comment']['club_movie_id'] = $current_movie->id;
  $args = $_POST['comment'];
  $new_comment = new Comment($args);

  // TEST
  // print_r($_POST['comment']);

  $result = $new_comment->save();

  if($result === true){
    $session->message('Your comment has been added to the disscussion!');
    redirect_to('/club?id=' . $id);
  }
}

// Page Title
$page_title = "Club";

// Header
include(SHARED_PATH . '/header.php');

?>

<div class="club-page">

  <!-- Display errors if $new_comment->save() -->
  

  <!-- Display Session Message if there is one -->
  <?php echo display_session_message(); ?>

  <h2><?php echo h($movie_club->club_name) ?></h2>
  <p><?php echo h($movie_club->description) ?></p>
  <h3>Current Movie</h3>
  <div class="club-details">
    <div class="current-movie-details">
      <a href="/movie?id=<?php echo h($current_movie_details->id) ?>">
        <img src="https://image.tmdb.org/t/p/w342<?php echo h($current_movie_details->poster_path) ?>" alt="<?php echo h($current_movie_details->title) ?> poster" height="513" width="342" loading=“lazy” decoding=“async>
      </a>
      <div>
        <h4><?php echo h($current_movie_details->title) ?></h4>
        <p><?php echo h($current_movie_details->overview) ?></p>
      </div>
    </div><!--End current-movie-details-->
    <div class="club-links">
      <ul>
        <li><a href="/movie-queue?id=<?php echo h($movie_club->id) ?>" class="link-button">Movie Queue</a></li>
        <li><a href="/club-members?id=<?php echo h($movie_club->id) ?>" class="link-button">Club Members</a></li>
      </ul>
    </div>
  </div><!--End current-movie-->

  <div class="discussion">
    <h3>Discussion</h3>
    <form action="/club?id=<?php echo h($id) ?>" method="post">
      <label for="comment-text">Comment</label>
      <textarea name="comment[comment_text]" id="comment-text" placeholder="Share your thoughts here..." required></textarea>
      <button type="submit">Add Comment</button>
    </form>
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
              <p><?php echo h($comment->date_created) ?></p>
            </div>
          </div>
          <p><?php echo h($comment->comment_text) ?></p>
        </div>
        <?php } ?>
      <?php } else { ?>
        <p>There are not comments for this movie yet.</p>
      <?php } ?>

    </div>
  </div>
</div><!--End Club-page-->

<?php

// Footer
include(SHARED_PATH . '/footer.php');

?>
