<?php

class Comment extends DatabaseObject {

  static protected $table_name = 'comments';
  static protected $db_columns = ['id', 'user_id', 'movie_clubs_id', 'club_movie_id', 'comment_text', 'date_created', 'parent_id'];

  public $id;
  public $user_id;
  public $movie_clubs_id;
  public $club_movie_id;
  public $comment_text;
  public $date_created;
  public $parent_id;

  public function __construct($args=[]) {
    $this->user_id = $args['user_id'] ?? '';
    $this->movie_clubs_id = $args['movie_clubs_id'] ?? '';
    $this->club_movie_id = $args['club_movie_id'] ?? '';
    $this->comment_text = $args['comment_text'] ?? '';
    $this->date_created = $args['date_created'] ?? date('Y-m-d');
    $this->parent_id = $args['parent_id'] ?? NULL;
  }

  static public function find_all_movie_comments($club_movie_id){
    $sql = "SELECT * FROM " . static::$table_name . " ";
    $sql .= "WHERE club_movie_id=" . self::$database->quote($club_movie_id);
    $sql .= "ORDER BY date_created DESC";
    $object_array = static::find_by_sql($sql);
    if(!empty($object_array)) {
        return $object_array;
    }   else    {
        return false;
    }
  }

}

?>