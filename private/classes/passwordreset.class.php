<?php

class PasswordReset extends DatabaseObject {

  static protected $table_name = "password_resets";
  static protected $db_columns = ['id', 'email', 'token'];

  public $id;
  public $email;
  public $token;

  public function __construct($args=[]) {
    $this->email = $args['email'] ?? '';
    $this->token = $args['token'] ?? '';
  }

  static public function find_by_email($email) {
    $sql = "SELECT * FROM " . static::$table_name . " ";
    $sql .= "WHERE email=" . self::$database->quote($email);
    $object_array = static::find_by_sql($sql);
    if(!empty($object_array)) {
        return array_shift($object_array);
    }   else    {
        return false;
    }
  }

  static public function find_by_token($token) {
    $sql = "SELECT * FROM " . static::$table_name . " ";
    $sql .= "WHERE token=" . self::$database->quote($token);
    $object_array = static::find_by_sql($sql);
    if(!empty($object_array)) {
        return array_shift($object_array);
    }   else    {
        return false;
    }
  }

}

?>