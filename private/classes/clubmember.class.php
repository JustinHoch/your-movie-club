<?php

class ClubMember extends DatabaseObject {

  static protected $table_name = 'movie_club_members';
  static protected $db_columns = ['id', 'user_id', 'movie_club_id', 'joined_status', 'date_joined'];

  public $id;
  public $user_id;
  public $movie_club_id;
  public $joined_status;
  public $date_joined;

  public function __construct($args=[]) {
    $this->user_id = $args['user_id'] ?? '';
    $this->movie_club_id = $args['movie_club_id'] ?? '';
    $this->joined_status = $args['joined_status'] ?? 1;
    $this->date_joined = $args['date_joined'] ?? date('Y-m-d');
  }

  static public function find_all_members($movie_club_id) {
    $sql = "SELECT * FROM " . static::$table_name . " ";
    $sql .= "WHERE movie_club_id=" . self::$database->quote($movie_club_id);
    $object_array = static::find_by_sql($sql);
    if(!empty($object_array)) {
        return $object_array;
    }   else    {
        return false;
    }
  }

  static public function find_all_members_by_user_id($user_id) {
    $sql = "SELECT * FROM " . static::$table_name . " ";
    $sql .= "WHERE user_id=" . self::$database->quote($user_id);
    $object_array = static::find_by_sql($sql);
    if(!empty($object_array)) {
        return $object_array;
    }   else    {
        return false;
    }
  }

  static public function member_check($user_id, $movie_club_id) {
    $sql = "SELECT * FROM " . static::$table_name . " ";
    $sql .= "WHERE user_id=" . self::$database->quote($user_id);
    $sql .= "AND movie_club_id=" . self::$database->quote($movie_club_id);
    $object_array = static::find_by_sql($sql);
    if(!empty($object_array)) {
        return $object_array;
    }   else    {
        return false;
    }
  }

}

?>