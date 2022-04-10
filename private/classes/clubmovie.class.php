<?php

class ClubMovie extends DatabaseObject {

  static protected $table_name = "club_movies";
  static protected $db_columns = ['id', 'api_movie_id', 'movie_club_id', 'user_id', 'queue_number', 'date_added', 'watched_status'];

  public $id;
  public $api_movie_id;
  public $movie_club_id;
  public $user_id;
  public $queue_number;
  public $date_added;
  public $watched_status;

  public function __construct($args=[]) {
    $this->api_movie_id = $args['api_movie_id'] ?? '';
    $this->movie_club_id = $args['movie_club_id'] ?? '';
    $this->user_id = $args['user_id'] ?? '';
    $this->queue_number = $args['queue_number'] ?? '';
    $this->date_added = $args['date_added'] ?? date('Y-m-d');
    $this->watched_status = $args['watched_status'] ?? 0;
  }

  static public function find_current_movie($movie_club_id) {
    $sql = "SELECT * FROM " . static::$table_name . " ";
    $sql .= "WHERE movie_club_id=" . self::$database->quote($movie_club_id) . " ";
    $sql .= "AND watched_status=0 LIMIT 1";
    $object_array = static::find_by_sql($sql);
    if(!empty($object_array)) {
        return array_shift($object_array);
    }   else    {
        return false;
    }
  }

  static public function find_all_unwatched_movies($movie_club_id) {
    $sql = "SELECT * FROM " . static::$table_name . " ";
    $sql .= "WHERE movie_club_id=" . self::$database->quote($movie_club_id) . " ";
    $sql .= "AND watched_status=0";
    $object_array = static::find_by_sql($sql);
    if(!empty($object_array)) {
        return $object_array;
    }   else    {
        return false;
    }
  }

}

?>