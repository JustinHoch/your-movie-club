<?php

  // Turn on output buffering
  ob_start();

  // Assign file paths to PHP constants
  // __FILE__ returns the current path to this file
  // dirname() returns the path to the parent directory
  define("PRIVATE_PATH", dirname(__FILE__));
  define("PROJECT_PATH", dirname(PRIVATE_PATH));
  define("PUBLIC_PATH", PROJECT_PATH);
  define("SHARED_PATH", PRIVATE_PATH . '/shared');

  // Assign the root URL to a PHP constant
  define("WWW_ROOT", $_SERVER['SCRIPT_NAME']);

  // Require files
  require_once('functions.php');
  require_once('api_functions.php');
  require_once('status_error_functions.php');
  require_once('db_credentials.php');
  require_once('db_connection.php');
  require_once('validation_functions.php');

  // Include Classes
  include('classes/databaseobject.class.php');
  include('classes/user.class.php');
  include('classes/session.class.php');
  include('classes/movieclub.class.php');
  include('classes/clubmovie.class.php');
  
  // Autoload class definitions
  // function my_autoload($class) {
  //   if ( preg_match('/\A\w+\Z/', $class) ) {
  //     include 'classes/' . $class . '.class.php';
  //   }
  // }
  // spl_autoload_register('my_autoload');

  // Database Connection
  $database = db_connect();
  DatabaseObject::set_database($database);

  // Start Session
  $session = new Session;

?>
