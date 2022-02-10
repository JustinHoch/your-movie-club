<?php
  // Includes
  require_once('db_credentials.php');
  require_once('db_connection.php');

  // Database Connection
  $database = db_connect();

  /**
   * Find By SQL Function
   *
   * @param object the database object used for the SQL query
   * @param string SQL string to be queried
   * @return object returns an object array containing the results of the query
   */
  function find_by_sql($database, $sql) {
    $result = $database->query($sql);
    if(!$result) {
      exit("<p>Database query failed</p>");
    }

    // Turn results into objects
    $object_array = [];
    while ($record = $result->fetch(PDO::FETCH_ASSOC)) {
      $object_array[] = $record;
    }
    //  $result->free();
    return $object_array;
  }

  // Find all users query
  $find_all_users_query = "SELECT * FROM users";

  // Find all movieclubs query
  $find_all_movie_clubs_query = "SELECT * FROM movie_clubs";

  // Users
  $users = find_by_sql($database, $find_all_users_query);
  // Movie Clubs
  $movie_clubs = find_by_sql($database, $find_all_movie_clubs_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styles.css">
  <title>Your Movie Club</title>
</head>
<body>
  <header>
    <h1>Welcome to Your Movie Club</h1>
  </header>
  <main>
    <h2>Club Users</h2>
    <table>
      <tr>
        <th>Username</th>
        <th>Date Created</th>
      </tr>
      <?php foreach($users as $user) { ?>
      <tr>
        <td><?php echo $user["username"]; ?></td>
        <td><?php echo $user["date_created"]; ?></td>
      </tr>
      <?php } ?> 
    </table>

    <h2>Movie Clubs</h2>
    <table>
      <tr>
        <th>Club Name</th>
        <th>Date Created</th>
      </tr>
      <?php foreach($movie_clubs as $movie_club) {?>
      <tr>
        <td><?php echo $movie_club["club_name"]; ?></td>
        <td><?php echo $movie_club["date_created"]; ?></td>
      </tr>
      <?php } ?> 
    </table>
  </main>
</body>
</html>
