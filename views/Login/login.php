<?php 
$showError = $viewModel->get ( 'showError' );

if (!isset($showError))
{
    header("Location: http://hday.localhost/"); /* Browser umleiten */
}else {
?>
<?php include 'views/header.php'; ?>
<?php include 'views/navbar.php'; ?>

<!-- Modal -->
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="padding:35px 50px;">
          <h4 class="modal-title"><span class="glyphicon glyphicon-lock"></span> Login</h4>
        </div>
        <div class="modal-body" style="padding:40px 50px;">
                  <?php
$showError = $viewModel->get ( 'showError' );
                  if ( ! isset ( $showError ) ) {
                    echo "<!--";
                  }
                  ?><div class="alert alert-danger" role="alert">
				<strong>FEHLER...</strong> Dieser Benutzer scheint nicht zu
				existieren oder das Passwort ist falsch!
			</div>
			<?php
  if ( ! isset ( $showError ) ) {
  echo "-->";
}
?>
          <form name="loginFrm" role="form" action="<?php echo $viewModel->get('BaseUrl'); ?>login/login" method="post">
            <div class="form-group">
              <label for="usrname"><span class="glyphicon glyphicon-user"></span> Benutzername</label>
              <input type="text" class="form-control" name="usrname" id="usrname" placeholder="Benutzername Eingeben">
            </div>
            <div class="form-group">
              <label for="psw"><span class="glyphicon glyphicon-eye-open"></span> Passwort</label>
              <input type="password" class="form-control" name="psw" id="psw" placeholder="Passwort Eingeben">
            </div>
            <div class="checkbox">
              <label><input type="checkbox" name="sl" value="true" checked>Eingeloggt bleiben</label>
            </div>
              <button type="submit" class="btn btn-success btn-block"><span class="glyphicon glyphicon-off"></span> Login</button>
          </form>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Abbrechen</button>
          <p>Passwort <a href="#">Vergessen?</a></p>
        </div>
      </div>
      
    </div>
<?php include 'views/footer.php';
}
?>