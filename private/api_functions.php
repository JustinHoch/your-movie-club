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

?>