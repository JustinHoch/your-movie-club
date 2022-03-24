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

// Get Movie Club Owner Details
$movie_club_owner = User::find_by_id($movie_club->club_owner_id);

// Get Movie Club Members
$members = ClubMember::find_all_members($movie_club->id);

// Add Member Form
$errors = [];
$member_email = '';
if(is_post_request()){
  // Get email
  $member_email = $_POST['add-member']['email'];
  // Check if email is associated with an account
  $email_check = User::find_by_email($member_email);
  if($email_check == false){
    $errors[] = 'No account was found for ' . $member_email;
  } else {
    // Check if user is already a member
    $member_check = ClubMember::member_check($email_check->id, $id);
    if($member_check !== false){
      $errors[] = 'That account is already a member of this club';
    }else{
      // Gather New Member data
      $_POST['add-member']['user_id'] = $email_check->id;
      $_POST['add-member']['movie_club_id'] = $id;
      $args = $_POST['add-member'];
      $new_member = new ClubMember($args);
      $result = $new_member->save();
      if($result === true){
        $session->message('Member Added!');
        redirect_to('/club-members?id=' . $id);
      }
    }
  }
}

// Page Title
$page_title = "Club Members";

// Header
include(SHARED_PATH . '/header.php');

?>

<div class="club-members-page">

  <!-- Display errors -->
  <?php echo display_errors($errors); ?>

  <!-- Display Session Message -->
  <?php echo display_session_message(); ?>

  <h2><a href="/club?id=<?php echo h($movie_club->id); ?>"><?php echo h($movie_club->club_name); ?></a> Club Members</h2>
  <p>Club Owner: <?php echo h($movie_club_owner->username); ?></p>

  <form class="forms" action="/club-members?id=<?php echo h($id); ?>" method="post">
    <label for="add-member">Add Members</label>
    <input type="text" id="add-member" name="add-member[email]" placeholder="User Email" value="<?php echo h($member_email); ?>" required>
    <button type="submit">Add Member</button>
  </form>

  <div class="members">

    <?php foreach($members as $member){
      $member_details = User::find_by_id($member->user_id);
    ?>
      <div class="member-card">
        <img src="/images/user/<?php echo h($member_details->avatar_path); ?>" alt="<?php echo h($member_details->username); ?> profile picture" height="250" width="250" loading=“lazy” decoding=“async”>
        <div>
          <p class="member-name"><?php echo h($member_details->username); ?></p>
          <p>Since: <?php echo h($member->date_joined); ?></p>
        </div>
      </div>
    <?php } ?>

  </div>
</div>

<?php

// Footer
include(SHARED_PATH . '/footer.php');

?>
