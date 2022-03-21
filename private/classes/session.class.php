<?php

class Session {

  public $user_id;
  public $username;
  public $user_level;
  public $avatar_path;
  private $last_login;

  public const MAX_LOGIN_AGE = 60*60*24; // 1 day in seconds

  public function __construct() {
    session_start();
    $this->check_stored_login();
  }

  public function login($user) {
    if($user) {
      // prevent session fixation attacks
      session_regenerate_id();
      $this->user_id = $_SESSION['user_id'] = $user->id;
      $this->username = $_SESSION['username'] = $user->username;
      $this->user_level = $_SESSION['user_level'] = $user->user_level;
      $this->avatar_path = $_SESSION['avatar_path'] = $user->avatar_path;
      $this->last_login = $_SESSION['last_login'] = time();
    }
    return true;
  }

  public function is_logged_in() {
    return isset($this->user_id) && $this->last_login_is_recent();
  }

  public function is_admin() {
    $this->user_level == 2 || $this->user_level == 3 ? true : false;
  }

  public function is_super_admin() {
    $this->user_level == 3 ? true : false;
  }

  public function logout() {
    unset($_SESSION['user_id']);
    unset($_SESSION['username']);
    unset($_SESSION['user_level']);
    unset($_SESSION['last_login']);
    unset($_SESSION['avatar_path']);
    unset($this->user_id);
    unset($this->username);
    unset($this->user_level);
    unset($this->last_login);
    unset($this->avatar_path);
    return true;
  }

  private function check_stored_login() {
    if(isset($_SESSION['user_id'])) {
      $this->user_id = $_SESSION['user_id'];
      $this->username = $_SESSION['username'];
      $this->user_level = $_SESSION['user_level'];
      $this->last_login = $_SESSION['last_login'];
      $this->avatar_path = $_SESSION['avatar_path'];
    }
  }

  private function last_login_is_recent() {
    if(!isset($this->last_login)) {
      return false;
    } elseif(($this->last_login + self::MAX_LOGIN_AGE) < time()) {
      return false;
    } else {
      return true;
    }
  }

  public function message($msg="") {
    if(!empty($msg)) {
      // Then this is a "set" message
      $_SESSION['message'] = $msg;
      return true;
    } else {
      return $_SESSION['message'] ?? '';
    }
  }

  public function clear_message() {
    unset($_SESSION['message']);
  }

}

?>