<?php

// Initialize
require_once('./private/initialize.php');

// Get watch providers
$watch_providers = apiAllWatchProviders();
// print_r($watch_providers->results);

// Get all genres
$genres = apiAllGenres();

// Process Form
if(is_post_request()){
  $url_string = "?sort_by=" . $_POST['sort_by'];
  if(isset($_POST['genre'])){
    $url_string .= "&with_genres=";
    foreach($_POST['genre'] as $genre){
      $url_string .= $genre . ",";
    }
    $url_string = rtrim($url_string, ", ");
  }
  if(isset($_POST['watch_provider'])){
    $url_string .= "&with_watch_providers=";
    foreach($_POST['watch_provider'] as $watch_provider){
      $url_string .= $watch_provider . "|";
    }
    $url_string = rtrim($url_string, "| ");
  }
  
  redirect_to('/discover' . $url_string);
}

// GET url parameters
$search_string = "&sort_by=";
$sort_by = "";
$in_genres = [];
$in_watch_providers = [];
$page = "1";
$search_string_no_page = "?sort_by=";

if(isset($_GET['sort_by'])){
  $sort_by = $_GET['sort_by'];
  $search_string .= $_GET['sort_by'];
  $search_string_no_page .= $_GET['sort_by'];
}else{
  $search_string .= "popularity.desc";
  $search_string_no_page .= "popularity.desc";
}

if(isset($_GET['with_genres'])){
  $in_genres = explode(",", $_GET['with_genres']);
  $search_string .= "&with_genres=" . $_GET['with_genres'];
  $search_string_no_page .= "&with_genres=" . $_GET['with_genres'];
}

if(isset($_GET['with_watch_providers'])){
  $in_watch_providers = explode("|", $_GET['with_watch_providers']);
  $search_string .= "&with_watch_providers=" . $_GET['with_watch_providers'] . "&watch_region=US";
  $search_string_no_page .= "&with_watch_providers=" . $_GET['with_watch_providers'] . "&watch_region=US";
}

if(isset($_GET['page'])){
  $page = $_GET['page'];
  $search_string .= "&page=" . $_GET['page'];
}

// Get movies
$movies = apiDiscover($search_string);

// include js files as needed
$js_files = [
  '/js/dropdown-menu.js',
  'https://kit.fontawesome.com/67a3532d66.js'
];

// Page Title
$page_title = "Discover";

// Header
include(SHARED_PATH . '/header.php');

?>

<div class="discover-page">
  <h2>Discover Movies</h2>
  <div class="form" id="discover-form-container">
    <form action="/discover" method="post" id="discover-form">
      <div id="discover-sort">
        <label for="sort_by">Sort:</label>
        <select name="sort_by" id="sort_by">
          <option value="popularity.desc" <?php if($sort_by == 'popularity.desc'){ echo 'selected'; }; ?>>Popularity Descending</option>
          <option value="popularity.asc" <?php if($sort_by == 'popularity.asc'){ echo 'selected'; }; ?>>Popularity Ascending</option>
          <option value="release_date.desc" <?php if($sort_by == 'release_date.desc'){ echo 'selected'; }; ?>>Release Date Descending</option>
          <option value="release_date.asc" <?php if($sort_by == 'release_date.asc'){ echo 'selected'; }; ?>>Release Date Ascending</option>
        </select>
      </div>

      <div id="discover-genre" class="dropdown">
        <button type="button" class="dropbtn" onclick="dropdownMenu('genre-list')">
          <p>Genres</p>
          <i class="fa-solid fa-angle-down fa-xs"></i>
        </button>
        <div id="genre-list" class="dropdown-content">
          <?php foreach($genres->genres as $genre){ ?>
            <div class="genre-checkbox">
              <input type="checkbox" name="genre[<?php echo h($genre->name); ?>]" data-genre="genre" id="<?php echo h($genre->name); ?>" value="<?php echo h($genre->id); ?>" <?php if(in_array($genre->id, $in_genres)){ echo 'checked'; } ?>>
              <label for="<?php echo h($genre->name); ?>"><?php echo h($genre->name); ?></label>
            </div>
          <?php } ?>
        </div>
      </div>

      <div id="discover-watch-providers" class="dropdown">
        <button type="button" class="dropbtn" onclick="dropdownMenu('provider-list')">
          <p>Watch Providers</p>
          <i class="fa-solid fa-angle-down fa-xs"></i>
        </button>
        <!-- <button class="dropbtn" type="button" onclick="dropdownMenu('provider-list')">Watch Providers</button> -->
        <div id="provider-list" class="dropdown-content">
          <?php foreach($watch_providers->results as $provider){
            if($provider->provider_id != 119){
          ?>
            <div class="provider-checkbox">
              <input type="checkbox" name="watch_provider[<?php echo h($provider->provider_name); ?>]" data-provider="provider" id="<?php echo h($provider->provider_id); ?>" value="<?php echo h($provider->provider_id); ?>" <?php if(in_array($provider->provider_id, $in_watch_providers)){ echo 'checked'; } ?>>
              <label for="<?php echo h($provider->provider_id); ?>"><?php echo h($provider->provider_name); ?></label>
            </div>
          <?php }} ?>
        </div>
      </div>

      <button type="submit">Search</button>
    </form>
  </div>

  <!-- Selected genres and/or watch providers -->
  <?php if(!empty($in_genres) || !empty($in_watch_providers)){ ?>
  <div class="discover-selected">
    <?php if(!empty($in_genres)){ ?>
      <div>
        <h3>Selected Genres</h3>
        <div class="selected-container">
          <?php
            foreach($in_genres as $selected_genre){
              foreach($genres->genres as $genre){
                if($selected_genre == $genre->id){
                  echo "<span>" . $genre->name . "</span>";
                }
              }
            }
          ?>
        </div>
      </div>
    <?php } ?>

    <?php if(!empty($in_watch_providers)){ ?>
      <div>
        <h3>Selected Providers</h3>
        <div class="selected-container">
          <?php
            foreach($in_watch_providers as $selected_provider){
              foreach($watch_providers->results as $provider){
                if($selected_provider == $provider->provider_id){
                  echo "<span>" . $provider->provider_name . "</span>";
                }
              }
            }
          ?>
        </div>
      </div>
    <?php } ?>
  </div>
  <?php } ?>

  <div class="discover-movies">
  <?php if(!empty($movies->results)){ ?>
    <?php foreach($movies->results as $result){ ?>
      <div class="search-card">
        <a href="/movie?id=<?php echo h($result->id) ?>">
          <img src="<?php echo h(apiCheckImage($result->poster_path)); ?>" alt="<?php echo h($result->title) ?> movie poster" height="513" width="342" loading=“lazy” decoding=“async>
        </a>
        <h3><?php echo h($result->title) ?></h3>
        <span><?php echo h(get_year_format($result->release_date ?? '')) ?></span>
      </div>
    <?php } ?>
  <?php }else{ ?>
    <p>No results were found!</p>
    <img src="/images/other/empty-space-holder.svg" alt="person with stars and the words empty space" style="box-shadow: none;">
  <?php } ?>
  </div>

  <?php if(!empty($movies->results)){ ?>
    <?php if($movies->total_pages > 1){ ?>
      <div class="discover-pagination">
        <?php if($page > 1){ ?>
          <a href="/discover<?php echo h($search_string_no_page) . "&page=" . $page - 1 ?>">Previous Page</a>
        <?php } ?>
        <p>Page <?php echo h($page) ?> of <?php echo h($movies->total_pages) ?></p>
        <?php if($page < $movies->total_pages){ ?>
          <a href="/discover<?php echo h($search_string_no_page) . "&page=" . $page + 1 ?>">Next Page</a>
        <?php } ?>
      </div>
  <?php
    }
  } ?>
</div>

<?php

// Footer
include(SHARED_PATH . '/footer.php');

?>
