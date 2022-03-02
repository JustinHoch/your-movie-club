<?php
require_once('./private/initialize.php');

// Log out the user
$session->logout();

redirect_to('./');

?>