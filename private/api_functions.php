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
  if($us_cert[0]){
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
    $genre_string .= $genre->name . " ";
  }
  return $genre_string;
}

function apiCheckImage($image_path) {
  if($image_path == ""){
    return "/images/tmdb/missing-image.webp";
  }else{
    return "https://image.tmdb.org/t/p/w342" . $image_path;
  }
}

?>