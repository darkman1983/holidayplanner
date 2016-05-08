<?php 
if (!$viewModel->get('ajax')) {
  include 'views/header.php';
  include 'views/navbar.php';
}
?>

<h1>Fatal MVC Error</h1>
<p>The controller action you requested does not have a view. This should exist as <strong><?php echo $this->viewFile; ?></strong>. Please create this file.

<?php 
if (!$viewModel->get('ajax')) {
  include 'views/footer.php';
}
?>