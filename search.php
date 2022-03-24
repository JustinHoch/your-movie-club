<?php

// Initialize
require_once('./private/initialize.php');

// Seach Query
$search_query = '';
$is_search = false;
if(isset($_GET['query'])){
  $search_query = $_GET['query'];
  $is_search = true;
  $search_results = apiMovieSearch($search_query);
  $api_results = $search_results->results;
}

// Seach form
if(is_post_request()){
  $post_query = $_POST['search'];
  redirect_to('/search?query=' . $post_query);
}

// Page Title
$page_title = "Search";

// Header
include(SHARED_PATH . '/header.php');

?>

<div class="search-page">
  <h2>Movie Search</h2>
  <form action="/search" method="post" class="forms">
    <label for="search">Search Movies</label>
    <input type="text" id="search" name="search" placeholder="Search for movies" value="<?php echo h($search_query) ?>" required>

    <button type="submit">Search</button>
  </form>

  <div class="search-return">

  <?php if($is_search){ ?>
    <?php foreach($api_results as $result){ ?>
      <div class="search-card">
        <a href="/movie?id=<?php echo h($result->id) ?>">
          <img src="<?php echo h(apiCheckImage($result->poster_path)); ?>" alt="<?php echo h($result->title) ?> movie poster" height="513" width="342" loading=“lazy” decoding=“async>
        </a>
        <h3><?php echo h($result->title) ?></h3>
        <span><?php echo h($result->release_date) ?></span>
      </div>
    <?php } ?>
  <?php } ?>

  </div>
</div>

<?php

// Footer
include(SHARED_PATH . '/footer.php');

?>
