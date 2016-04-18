<?php include 'views/header.php'; ?>
<?php include 'views/navbar.php'; ?>
<div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="padding:35px 50px;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4><span class="glyphicon glyphicon-lock"></span> Login</h4>
        </div>
        <div class="modal-body" style="padding:40px 50px;">
          <form role="form" action="<?php echo @$viewModel->get('BaseUrl'); ?>login/login" method="post">
            <div class="form-group">
              <label for="usrname"><span class="glyphicon glyphicon-user"></span> Benutzername</label>
              <input type="text" class="form-control" id="usrname" placeholder="Benutzername Eingeben">
            </div>
            <div class="form-group">
              <label for="psw"><span class="glyphicon glyphicon-eye-open"></span> Passwort</label>
              <input type="text" class="form-control" id="psw" placeholder="Passwort Eingeben">
            </div>
            <div class="checkbox">
              <label><input type="checkbox" value="" checked>Eingeloggt bleiben</label>
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
<?php include 'views/footer.php'; ?>