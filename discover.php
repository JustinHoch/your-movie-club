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
  print_r($_POST);
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
      $url_string .= $watch_provider . ",";
    }
    $url_string = rtrim($url_string, ", ");
  }

  redirect_to('/discover' . $url_string);
}

// GET url parameters
$search_string = "?sort_by=";
$sort_by = "";
$in_genres = [];
$in_watch_providers = [];

if(isset($_GET['sort_by'])){
  $sort_by = $_GET['sort_by'];
  $search_string .= $_GET['sort_by'];
}else{
  $search_string .= "popularity.desc";
}

if(isset($_GET['with_genres'])){
  $in_genres = explode(",", $_GET['with_genres']);
  $search_string .= "&with_genres=" . $_GET['with_genres'];
}

if(isset($_GET['with_watch_providers'])){
  $in_watch_providers = explode(",", $_GET['with_watch_providers']);
  $search_string .= "&with_watch_providers=" . $_GET['with_watch_providers'];
}

// Get movies
$movies = apiDiscover($search_string);

// Page Title
$page_title = "Discover";

// Header
include(SHARED_PATH . '/header.php');

?>

<div class="discover-page">
  <h2>Discover Movies</h2>
  <div class="form">
    <form action="/discover" method="post">
      <div id="discover-sort">
        <label for="sort_by">Sort</label>
        <select name="sort_by" id="sort_by">
          <option value="popularity.desc" <?php if($sort_by == 'popularity.desc'){ echo 'selected'; }; ?>>Popularity Descending</option>
          <option value="popularity.asc" <?php if($sort_by == 'popularity.asc'){ echo 'selected'; }; ?>>Popularity Ascending</option>
          <option value="release_date.desc" <?php if($sort_by == 'release_date.desc'){ echo 'selected'; }; ?>>Release Date Descending</option>
          <option value="release_date.asc" <?php if($sort_by == 'release_date.asc'){ echo 'selected'; }; ?>>Release Date Ascending</option>
        </select>
      </div>

      <div id="discover-genre">
        <?php foreach($genres->genres as $genre){ ?>
          <input type="checkbox" name="genre[<?php echo h($genre->name); ?>]" id="<?php echo h($genre->name); ?>" value="<?php echo h($genre->id); ?>" <?php if(in_array($genre->id, $in_genres)){ echo 'checked'; } ?>>
          <label for="<?php echo h($genre->name); ?>"><?php echo h($genre->name); ?></label>
        <?php } ?>
      </div>

      <div id="discover-watch-providers">
        <?php foreach($watch_providers->results as $provider){
          if($provider->provider_id != 119){
        ?>
          <input type="checkbox" name="watch_provider[<?php echo h($provider->provider_name); ?>]" id="<?php echo h($provider->provider_id); ?>" value="<?php echo h($provider->provider_id); ?>" <?php if(in_array($provider->provider_id, $in_watch_providers)){ echo 'checked'; } ?>>
          <label for="<?php echo h($provider->provider_id); ?>"><?php echo h($provider->provider_name); ?></label>
        <?php }} ?>
      </div>

      <button type="submit">Search</button>
    </form>
  </div>

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
  <?php } ?>
  </div>
</div>

<?php

// Footer
include(SHARED_PATH . '/footer.php');

?>
