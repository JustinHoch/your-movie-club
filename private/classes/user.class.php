<?php

class User extends DatabaseObject {

  static protected $table_name = "users";
  static protected $db_columns = ['id', 'username', 'email', 'password', 'date_created', 'user_level', 'avatar_path'];

  public $id;
  public $username;
  public $email;
  protected $password;
  public $unhashed_password;
  public $confirm_password;
  protected $password_required = true;
  public $date_created;
  public $user_level;
  public $avatar_path;

  public function __construct($args=[]) {
    $this->username = $args['username'] ?? '';
    $this->email = $args['email'] ?? '';
    $this->user_level = $args['user_level'] ?? 1;
    $this->unhashed_password = $args['unhashed_password'] ?? '';
    $this->confirm_password = $args['confirm_password'] ?? '';
    $this->date_created = $args['date_created'] ?? date('Y-m-d');
    $this->avatar_path = $args['avatar_path'] ?? 'blue-cat.webp';
  }

  protected function set_hashed_password() {
    $this->password = password_hash($this->unhashed_password, PASSWORD_BCRYPT);
  }

  public function verify_password($unhashed_password){
    return password_verify($unhashed_password, $this->password);
  }

  protected function create() {
    $this->set_hashed_password();
    return parent::create();
  }

  protected function update() {
    if($this->unhashed_password != '') {
      // validate password
      $this->set_hashed_password();
    } else {
      // password not being updated, skip hashing and validation
      $this->password_required = false;
    }
    return parent::update();
  }

  protected function validate() {
    $this->errors = [];
  
    if(is_blank($this->email)) {
      $this->errors[] = "Email cannot be blank.";
    } elseif (!has_length($this->email, array('max' => 255))) {
      $this->errors[] = "Last name must be less than 255 characters.";
    } elseif (!has_valid_email_format($this->email)) {
      $this->errors[] = "Email must be a valid format.";
    }
  
    if(is_blank($this->username)) {
      $this->errors[] = "Username cannot be blank.";
    } elseif (!has_length($this->username, array('min' => 2, 'max' => 255))) {
      $this->errors[] = "Username must be between 2 and 255 characters.";
    } elseif (!has_unique_username($this->username, $this->id ?? 0)) {
      $this->errors[] = "Username not allowed. Try another.";
    }
  
    if($this->password_required) {
      if(is_blank($this->unhashed_password)) {
        $this->errors[] = "Password cannot be blank.";
      } elseif (!has_length($this->password, array('min' => 4))) {
        $this->errors[] = "Password must contain 4 or more characters";
      }
    
      if(is_blank($this->confirm_password)) {
        $this->errors[] = "Confirm password cannot be blank.";
      } elseif ($this->unhashed_password !== $this->confirm_password) {
        $this->errors[] = "Password and confirm password must match.";
      }
    }
  
    return $this->errors;
  }

  static public function find_by_username($username) {
    $sql = "SELECT * FROM " . static::$table_name . " ";
    $sql .= "WHERE username=" . self::$database->quote($username);
    $object_array = static::find_by_sql($sql);
    if(!empty($object_array)) {
        return array_shift($object_array);
    }   else    {
        return false;
    }
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

}

?>
