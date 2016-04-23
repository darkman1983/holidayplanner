<?php include 'views/header.php'; ?>
<?php include 'views/navbar.php';
$filteredFeastDays = $viewModel->get('userData');
$email = explode('@', $filteredFeastDays[0]['email']);
?>
    <div class="container">
      <div id="login-overlay" class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title" id="myModalLabel">Benutzer Editieren</h4>
          </div>
          <div class="modal-body">
              <div class="row">
                  <div class="col-xs-12">
                      <div class="well">
                          <form id="loginForm" method="POST" action="<?php echo $viewModel->get('BaseUrl') ?>user/edit?do=1&userEditID=<?php echo $viewModel->get('userEditID'); ?>" role="form" data-toggle="validator">
                              <div class="form-group" id="usernameGroup">
                                  <label for="frm_username" class="control-label">Benutzername</label>
                                  <input type="text" class="form-control" id="frm_username" name="frm_username" placeholder="Benutzernamen Eingeben" data-remote="<?php echo $viewModel->get('BaseUrl'); ?>ajax/validateuser?userEditID=<?php echo $filteredFeastDays[0]['id'] ?>" data-error="Oops! Dieser Benutzer existiert schon!" value="<?php echo $filteredFeastDays[0]['username'] ?>" required>
                                  <div class="help-block with-errors"></div>
                              </div>
                              <div class="form-group">
                                  <label for="frm_uPassword" class="control-label">Passwort</label>
                                  <input type="password" class="form-control" id="frm_uPassword" name="frm_uPassword" placeholder="Neues Passwort Eingeben">
                                  <div class="help-block with-errors"></div>
                              </div>
                              <div class="form-group">
                                  <label for="frm_confirmPassword" class="control-label">Passwort Wiederholen</label>
                                  <input type="password" class="form-control" id="frm_confirmPassword" name="frm_confirmPassword" placeholder="Passwort Wiederholen" data-match="#frm_uPassword" data-match-error="Oh nein, die Passwörter stimmen nicht überein!">
                                  <div class="help-block with-errors"></div>
                              </div>
                              <div class="form-group">
  								  <label for="frm_userlevel">Benutzerlevel Wählen</label>
  								  <select class="form-control" id="frm_userlevel" name="frm_userlevel">
  								    <?php
  								    $userID = $viewModel->get ( 'userID' );
  								    $levels = array(1 => "Normal", 2 => "Anträge Freigeben", 3 => "Administrator");
  								    foreach ($levels as $level => &$entry) {
  								      printf( '<option value="%s"%s>%s - %s</option>', $level, ($level == $filteredFeastDays[0]['level']) ? ' selected' : '', $level, $entry);
  								    }
  								    ?>
  								  </select>
                              </div>
                              <hr>
                              <div class="form-group">
                                  <label for="frm_email" class="control-label">Email Adresse</label>
                                  <div class="input-group">
                                    <input type="text" class="form-control" id="frm_email" name="frm_email" placeholder="Email Eingeben" value="<?php echo $email[0]; ?>" required>
                                    <span class="input-group-addon" id="sizing-addon1">@</span>
                                    <input type="text" class="form-control" id="frm_emailDomain" name="frm_emailDomain" placeholder="Domain eingeben" value="<?php echo $email[1]; ?>" required>
                                  </div>
                                  <div class="help-block with-errors"></div>
                              </div>
                              <div class="form-group">
                                  <label for="frm_firstname" class="control-label">Vorname</label>
                                  <input type="text" class="form-control" id="frm_firstname" name="frm_firstname" placeholder="Vorname Eingeben" value="<?php echo $filteredFeastDays[0]['firstname'] ?>" required>
                                  <div class="help-block with-errors"></div>
                              </div>
                              <div class="form-group">
                                  <label for="frm_lastname" class="control-label">Nachname</label>
                                  <input type="text" class="form-control" id="frm_lastname" name="frm_lastname" placeholder="Nachname Eingeben" value="<?php echo $filteredFeastDays[0]['lastname'] ?>" required>
                                  <div class="help-block with-errors"></div>
                              </div>
                              <button type="submit" class="btn btn-success btn-default">Ändern</button>
                              <a href="<?php echo $viewModel->get('BaseUrl'); ?>user" class="btn btn-danger btn-default"><span class="glyphicon glyphicon-remove"></span> Abbrechen</a>
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