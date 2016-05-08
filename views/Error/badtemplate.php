<?php 
if (!$viewModel->get('ajax')) {
  include 'views/header.php';
  include 'views/navbar.php';
}
?>

<h1>Fatal MVC Error</h1>
<p>The controller action you requested is configured to access <strong>/views/<?php echo $template; ?>.php</strong> as a view template, but this does not exist. Please make sure this file exists in /views or change the template name argument in your controller action's $this->returnView() method call to an existing template.</p>

<?php 
if (!$viewModel->get('ajax')) {
  include 'views/footer.php';
}
?>