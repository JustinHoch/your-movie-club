<?php

// Initialize
require_once('../private/initialize.php');

// Require user to be Logged in
require_login();

// Require user to be an admin
require_admin();

// Page Title
$page_title='Admin';

// Header
include(SHARED_PATH . '/header.php');

?>

<div class="admin-page">
  <h2>Admin Page</h2>
</div>

<?php

// Footer
include(SHARED_PATH . '/footer.php');

?>
