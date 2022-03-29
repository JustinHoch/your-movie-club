<?php

// Initialize
require_once('./private/initialize.php');

// Page Title
$page_title='403 Forbidden';

// Header
include(SHARED_PATH . '/header.php');

?>

<div class="error-page">
  <h2>Error 403:</br>Forbidden</h2>
  <p>Whoa there! This place is off limits. Best just head back the way you came.</p>
</div>

<?php

// Footer
include(SHARED_PATH . '/footer.php');

?>