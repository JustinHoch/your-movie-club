<div class="admin-page">
  <div class="admin-header">
    <p><span>Logged in as:</span> <?php echo h($session->username) ?></p>
    <p><span>User Level:</span> <?php echo h($session->get_level_name()) ?></p>
    <?php if($admin_title !== 'Admin Dashboard'){ ?>
      <a href="/admin">Back to Admin Dashboard</a>
      <?php } ?>
    <h2><?php echo h($admin_title) ?></h2>
  </div>