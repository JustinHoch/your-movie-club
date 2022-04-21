<?php

// Initialize
require_once('./private/initialize.php');

// Require user to be logged in
require_login();

// Check how many clubs the user has
$clubs = MovieClub::find_by_owner_id($session->user_id);

if($clubs != false){
  if(count($clubs) == 5){
    $session->message('Sorry! You cannot create more than 5 clubs.');
    redirect_to('/account');
  }
}

// Process Form
if(is_post_request()){
  $args = $_POST['club'];
  $args['club_owner_id'] = $session->user_id;
  $new_club = new MovieClub($args);
  $new_club_result = $new_club->save();
  if($new_club_result){
    $add_member_args = [];
    $add_member_args['user_id'] = $session->user_id;
    $add_member_args['movie_club_id'] = $new_club->id;
    $add_member = new ClubMember($add_member_args);
    $add_member_result = $add_member->save();
    if($add_member_result){
      $session->message('Your new club was successfully created!');
      redirect_to('/account');
    }
  }

  print_r($new_club_saved);
  print_r($new_club);
}


// Page Title
$page_title = "Create Club";

// Header
include(SHARED_PATH . '/header.php');

?>

<div class="forms create-club">
  <h2>Create Movie Club</h2>
  <form action="/create-club" method="post">
    <label for="club-name">Movie Club Name</label>
    <input type="text" name="club[club_name]" id="club-name" required>

    <label for="description">Movie Club Description</label>
    <p>Use the club description to say what kind of movies (genre, rating, where to watch, ...ect) and how often the movies will change.</p>
    <textarea name="club[description]" id="description" cols="30" rows="10" required></textarea>

    <p>You can add movies and club members after the club has been created.</p>

    <button type="submit">Create Movie Club</button>
  </form>
</div>

<?php

// Footer
include(SHARED_PATH . '/footer.php');

?>
