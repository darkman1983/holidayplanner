<?php 
if (!$viewModel->get('ajax')) {
  include 'views/header.php';
  include 'views/navbar.php';
}
?>
<h1>Error</h1>
<p>Benutzerlevel reicht nicht aus um die Seite anzuzeigen oder Session ist abgelaufen!</p>
<?php 
if (!$viewModel->get('ajax')) {
  include 'views/footer.php';
}
?>