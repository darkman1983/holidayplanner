<?php include 'views/header.php'; ?>
<?php include 'views/navbar.php'; ?>
<h1>Error</h1>
<p>Es gab probleme den Benutzer zu Erstellen.<br><?php echo $viewModel->get('dbError'); ?></p>
<?php include 'views/footer.php'; ?>