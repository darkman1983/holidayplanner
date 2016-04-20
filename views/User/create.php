<?php include 'views/header.php'; ?>
<?php include 'views/navbar.php'; ?>
    <div class="container">
      <div id="login-overlay" class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title" id="myModalLabel">Neuen Benutzer Anlegen</h4>
          </div>
          <div class="modal-body">
              <div class="row">
                  <div class="col-xs-12">
                      <div class="well">
                          <form id="loginForm" method="POST" action="<?php echo $viewModel->get('BaseUrl') ?>user/create" role="form" data-toggle="validator">
                              <div class="form-group" id="usernameGroup">
                                  <label for="username" class="control-label">Benutzername</label>
                                  <div class="input-group">
                                    <span class="input-group-addon" id="sizing-addon1">z.B. hmustermann</span>
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Benutzernamen Eingeben" data-remote="<?php echo $viewModel->get('BaseUrl'); ?>ajax/validateuser" data-error="Oops! Dieser Benutzer existiert schon!" required>
                                  </div>
                                  <div class="help-block with-errors"></div>
                              </div>
                              <div class="form-group">
                                  <label for="uPassword" class="control-label">Passwort</label>
                                  <input type="password" class="form-control" id="uPassword" name="uPassword" placeholder="Passwort Eingeben" data-minlength="6" data-error="Oops! Das Passwort muss mindestens 6 Zeichen lang sein!" required>
                                  <div class="help-block with-errors"></div>
                              </div>
                              <div class="form-group">
                                  <label for="confirmPassword" class="control-label">Passwort Wiederholen</label>
                                  <input type="password" class="form-control" id="ConfirmPassword" name="ConfirmPassword" placeholder="Passwort Eingeben" data-match="#uPassword" data-match-error="Oh nein, die Passwörter stimmen nicht überein!">
                                  <div class="help-block with-errors"></div>
                              </div>
                              <div class="form-group">
  								  <label for="userlevel">Benutzerlevel Wählen</label>
  								  <select class="form-control" id="userlevel" name="userlevel">
  								    <option value="1">1 - Normal</option>
  								    <option value="2">2 - Anträge Freigeben</option>
  								    <option value="3">3 - Administrator</option>
  								  </select>
                              </div>
                              <hr>
                              <div class="form-group">
                                  <label for="email" class="control-label">Email Adresse</label>
                                  <div class="input-group">
                                    <input type="text" class="form-control" id="email" name="email" placeholder="Email Eingeben" required>
                                    <span class="input-group-addon" id="sizing-addon1">@</span>
                                    <input type="text" class="form-control" id="emailDomain" name="emailDomain" placeholder="Domain eingeben" required>
                                  </div>
                                  <div class="help-block with-errors"></div>
                              </div>
                              <div class="form-group">
                                  <label for="firstname" class="control-label">Vorname</label>
                                  <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Vorname Eingeben" required>
                              </div>
                              <div class="form-group">
                                  <label for="lastname" class="control-label">Nachname</label>
                                  <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Nachname Eingeben" required>
                              </div>
                              <button type="submit" class="btn btn-success btn-block">Erstellen</button>
                          </form>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
      </div>
<script>
$(document).ready(function(){
	/*$("#usernameGroup").hide();
	$("#lastname").keyup(function() {
        var firstname = $("#firstname");
        var lastname = $("#lastname");
        var username = firstname.val().toLowerCase().charAt(0) + lastname.val().toLowerCase();

        $("#username").val(username);
        $("#loginForm").validator('validate');
        $("#usernameGroup").show();
    });*/
});
</script>
<?php include 'views/footer.php'; ?>