<?php

class MovieClub extends DatabaseObject {

  static protected $table_name = "movie_clubs";
  static protected $db_columns = ['id', 'club_name', 'club_owner_id', 'date_created', 'description', 'avatar_path'];

  public $id;
  public $club_name;
  public $club_owner_id;
  public $date_created;
  public $description;
  public $avatar_path;

  public function __construct($args=[]) {
    $this->club_name = $args['club_name'] ?? '';
    $this->club_owner_id = $args['club_owner_id'] ?? '';
    $this->date_created = $args['date_created'] ?? date('Y-m-d');
    $this->description = $args['description'] ?? '';
    $this->avatar_path = $args['avatar_path'] ?? '';
  }

  static public function find_by_owner_id($id) {
    $sql = "SELECT * FROM " . static::$table_name . " ";
    $sql .= "WHERE club_owner_id=" . self::$database->quote($id);
    $object_array = static::find_by_sql($sql);
    if(!empty($object_array)) {
        return $object_array;
    }   else    {
        return false;
    }
  }

}

?>