  <!-- Modal -->
  <div class="modal fade" id="loginModal" data-backdrop="static" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="padding:35px 50px;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><span class="glyphicon glyphicon-lock"></span> Login</h4>
        </div>
        <div class="modal-body" style="padding:40px 50px;">
          <form name="loginFrm" id="loginFrm" role="form" action="<?php echo $viewModel->get('BaseUrl'); ?>login/login" method="post">
            <div class="form-group">
              <label for="usrname"><span class="glyphicon glyphicon-user"></span> Benutzername</label>
              <input type="text" class="form-control" name="usrname" id="usrname" autocomplete="off" placeholder="Benutzername Eingeben">
            </div>
            <div class="form-group">
              <label for="psw"><span class="glyphicon glyphicon-eye-open"></span> Passwort</label>
              <input type="password" class="form-control" name="psw" id="psw" placeholder="Passwort Eingeben">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <span id="loadingIndicator" class="fa fa-cog fa-spin fa-med link-color-black pull-left loading-indicator-footer loading-indicator-hidden" aria-hidden="true"></span>&nbsp;<button type="submit" id="loginButton" class="btn btn-default btn-success pull-left"><span class="glyphicon glyphicon-off"></span> Login</button>
          <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Abbrechen</button>
          <p>Passwort <a href="#">Vergessen?</a></p>
        </div>
      </div>
      
    </div>
  </div> 