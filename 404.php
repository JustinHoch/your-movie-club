<?php

// Initialize
require_once('./private/initialize.php');

// Page Title
$page_title='404 Page Not Found';

// Header
include(SHARED_PATH . '/header.php');

?>

<div class="error-page">
  <h2>Error 404:</br> Page Not Found</h2>
  <p>Whooops! Sorry, it looks like the page you are trying to reach does not exist!</p>
</div>

<?php

// Footer
include(SHARED_PATH . '/footer.php');

?>