<?php

// Initialize
require_once('./private/initialize.php');

// Seach Query
$search_query = "";
if(isset($_GET['query'])){
  $search_query = $_GET['query'];
  $search_results = apiMovieSearch($_GET['query']);
  $api_results = $search_results->results;
}else{
  $search_results = apiTrendingMovies();
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

    <div id="search-bar">
      <input type="text" id="search" name="search" placeholder="Search for movies" value="<?php echo h($search_query) ?>" required>
      <button type="submit">Search</button>
    </div>

  </form>

  <div class="search-return">

  <?php if(!empty($api_results)){ ?>
    <?php foreach($api_results as $result){ ?>
      <div class="search-card">
        <a href="/movie?id=<?php echo h($result->id) ?>">
          <img class="shadow" src="<?php echo h(apiCheckImage($result->poster_path)); ?>" alt="<?php echo h($result->title) ?> movie poster" height="513" width="342" loading=“lazy” decoding=“async>
        </a>
        <h3><?php echo h($result->title) ?></h3>
        <span><?php echo h(get_year_format($result->release_date ?? '')) ?></span>
      </div>
    <?php } ?>
  <?php }else{ ?>
    <p>Sorry, no results were found.</p>
    <img src="/images/other/empty-space-holder.svg" alt="person with stars and the words empty space" style="box-shadow: none;">
  <?php } ?>

  </div>
</div>

<?php

// Footer
include(SHARED_PATH . '/footer.php');

?>
