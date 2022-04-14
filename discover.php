<?php

// Initialize
require_once('./private/initialize.php');

// Page Title
$page_title = "Discover";

// Header
include(SHARED_PATH . '/header.php');

?>

<div class="discover-page">
  <h2>Discover Movies</h2>
  <div class="form">
    <form action="/discover">
      <label for="sort_by">Sort</label>
      <select name="sort_by" id="sort_by">
        <option value="popularity.desc">Popularity Descending</option>
        <option value="popularity.asc">Popularity Ascending</option>
        <option value="release_date.desc">Release Date Descending</option>
        <option value="release_date.asc">Release Date Ascending</option>
      </select>

      <input type="checkbox" name="action" id="action">
      <label for="action">Action</label>
      <input type="checkbox" name="adventure" id="adventure">
      <label for="adventure">Adventure</label>
      <input type="checkbox" name="animation" id="animation">
      <label for="animation">Animation</label>
      <input type="checkbox" name="comedy" id="comedy">
      <label for="comedy">Comedy</label>
      <input type="checkbox" name="crime" id="crime">
      <label for="crime">Crime</label>
      <input type="checkbox" name="documentary" id="documentary">
      <label for="documentary">Documentary</label>
      <input type="checkbox" name="drama" id="drama">
      <label for="drama">Drama</label>
      <input type="checkbox" name="family" id="family">
      <label for="family">Family</label>
      <input type="checkbox" name="fantasy" id="fantasy">
      <label for="fantasy">Fantasy</label>
      <input type="checkbox" name="history" id="history">
      <label for="history">History</label>
      <input type="checkbox" name="horror" id="horror">
      <label for="horror">Horror</label>
      <input type="checkbox" name="music" id="music">
      <label for="music">Music</label>
      <input type="checkbox" name="mystery" id="mystery">
      <label for="mystery">Mystery</label>
      <input type="checkbox" name="romance" id="romance">
      <label for="romance">Romance</label>
      <input type="checkbox" name="science_fiction" id="science_fiction">
      <label for="science_fiction">Science Fiction</label>
      <input type="checkbox" name="tv_movie" id="tv_movie">
      <label for="tv_movie">TV Movie</label>
      <input type="checkbox" name="thriller" id="thriller">
      <label for="thriller">Thriller</label>
      <input type="checkbox" name="war" id="war">
      <label for="war">War</label>
      <input type="checkbox" name="western" id="western">
      <label for="western">Western</label>

    </form>
  </div>
</div>

<?php

// Footer
include(SHARED_PATH . '/footer.php');

?>
