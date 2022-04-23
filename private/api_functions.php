<?php

function withApi($url) {
  $response = file_get_contents($url);
  return(json_decode($response));
}

function apiTrendingMovies() {
  $url = "https://api.themoviedb.org/3/movie/popular?api_key=" . API_KEY . "&language=en-US&page=1";
  return withApi($url);
}

function apiTrendingMoviesWeek() {
  $url = "https://api.themoviedb.org/3/trending/movie/week?api_key=" . API_KEY;
  return withApi($url);
}

function apiTrendingMoviesDay() {
  $url = "https://api.themoviedb.org/3/trending/movie/day?api_key=" . API_KEY;
  return withApi($url);
}

function apiMovie($id) {
  $url = "https://api.themoviedb.org/3/movie/${id}?api_key=" . API_KEY . "&language=en-US&append_to_response=release_dates,watch/providers,credits";
  return withApi($url);
}

function apiMovieSearch($query) {
  $urlQuery = urlencode($query);
  $url = "https://api.themoviedb.org/3/search/movie?api_key=" . API_KEY . "&language=en-US&query=${urlQuery}&page=1&include_adult=false";
  return withApi($url);
}

function apiAllWatchProviders() {
  $url = "https://api.themoviedb.org/3/watch/providers/movie?api_key=" . API_KEY . "&language=en-US&watch_region=US";
  $wp_list = withApi($url);
  return $wp_list;
}

function apiAllGenres() {
  $url = "https://api.themoviedb.org/3/genre/movie/list?api_key=" . API_KEY . "&language=en-US";
  return withApi($url);
}

function apiDiscover($search_string) {
  $url = "https://api.themoviedb.org/3/discover/movie?api_key=" . API_KEY . "&language=en-US" . $search_string;
  return withApi($url);
}

// TODO: needs revision
function getCerts($movie_certs) {
  $certs = $movie_certs->results;
  $us_cert = [];
  $certifications = [];
  foreach($certs as $cert) {
    if($cert->iso_3166_1 == "US"){
      $us_cert[] = $cert->release_dates;
    }
  }
  if(isset($us_cert[0])){
    foreach($us_cert[0] as $item){
      if($item->certification !== ""){
        $certifications[] = $item->certification;
      }
    }
  }
  if(count($certifications) > 0){
    return $certifications[0];
  }else{
    return false;
  }
}

function getGenres($genres) {
  $genre_string = "";
  foreach($genres as $genre){
    // $genre_string .= $genre->name . " ";
    $genre_string .= "<a href=\"/discover?sort_by=popularity.desc&with_genres=" . $genre->id . "\" class=\"genre-link\">" . $genre->name . "</a>";
  }
  return $genre_string;
}

function apiCheckImage($image_path, $size="md") {
  if($image_path == ""){
    return "/images/tmdb/missing-image.webp";
  }elseif($size == "md"){
    return "https://image.tmdb.org/t/p/w342" . $image_path;
  }elseif($size == "lg"){
    return "https://image.tmdb.org/t/p/w500" . $image_path;
  }
}

?>