<?php include 'views/header.php'; ?>
<?php include 'views/navbar.php'; ?>
    <div class="container">
      <div id="login-overlay" class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title" id="myModalLabel">Neuen Benutzer erstellen</h4>
          </div>
          <div class="modal-body">
              <div class="row">
                  <div class="col-xs-12">
                      <div class="well">
                          <form id="createForm" name="createForm" method="POST" action="<?php echo $viewModel->get('BaseUrl') ?>user/create?do=1" role="form" data-toggle="validator">
                          <div class="form-group has-feedback">
                                  <label for="frm_staffid" class="control-label">Personalnummer</label>
                                  <input type="text" class="form-control" id="frm_staffid" name="frm_staffid" placeholder="Personalnummer Eingeben" data-remote="<?php echo $viewModel->get('BaseUrl'); ?>ajax/validatestaffid" data-error="Oops! Diese Personalnummer existiert schon, Feld nicht ausgefüllt oder keine Nummer." required>
                                  <div class="help-block with-errors"></div>
                              </div>
                              <div class="form-group has-feedback" id="usernameGroup">
                                  <label for="frm_username" class="control-label">Benutzername</label>
                                  <div class="input-group">
                                    <span class="input-group-addon" id="sizing-addon1">z.B. hmustermann</span>
                                    <input type="text" class="form-control" id="frm_username" name="frm_username" placeholder="Benutzernamen Eingeben" data-remote="<?php echo $viewModel->get('BaseUrl'); ?>ajax/validateuser" data-error="Oops! Feld leer oder Benutzer existiert schon!" required>
                                  </div>
                                  <div class="help-block with-errors"></div>
                              </div>
                              <div class="form-group has-feedback">
                                  <label for="frm_uPassword" class="control-label">Passwort</label>
                                  <input type="password" class="form-control" id="frm_uPassword" name="frm_uPassword" placeholder="Passwort Eingeben" data-minlength="6" data-error="Oops! Das Passwort muss mindestens 6 Zeichen lang sein!" required>
                                  <div class="help-block with-errors"></div>
                              </div>
                              <div class="form-group has-feedback">
                                  <label for="frm_confirmPassword" class="control-label">Passwort Wiederholen</label>
                                  <input type="password" class="form-control" id="frm_confirmPassword" name="frm_confirmPassword" placeholder="Passwort Eingeben" data-match="#frm_uPassword" data-match-error="Oh nein, die Passwörter stimmen nicht überein!">
                                  <div class="help-block with-errors"></div>
                              </div>
                              <div class="form-group has-feedback">
  								  <label for="frm_userlevel">Benutzerlevel Wählen</label>
  								  <select class="form-control" id="frm_userlevel" name="frm_userlevel">
  								    <option value="1">1 - Normal</option>
  								    <option value="2">2 - Anträge Freigeben</option>
  								    <option value="3">3 - Administrator</option>
  								  </select>
                              </div>
                              <hr>
                              <div class="form-group has-feedback">
                                  <label for="frm_email" class="control-label">Email Adresse</label>
                                  <input type="email" class="form-control" id="frm_email" name="frm_email" placeholder="Email Eingeben" required>
                                  <div class="help-block with-errors"></div>
                              </div>
                              <div class="form-group has-feedback">
                                  <label for="frm_firstname" class="control-label">Vorname</label>
                                  <input type="text" class="form-control" id="frm_firstname" name="frm_firstname" placeholder="Vorname Eingeben" required>
                                  <div class="help-block with-errors"></div>
                              </div>
                              <div class="form-group has-feedback">
                                  <label for="frm_lastname" class="control-label">Nachname</label>
                                  <input type="text" class="form-control" id="frm_lastname" name="frm_lastname" placeholder="Nachname Eingeben" required>
                                  <div class="help-block with-errors"></div>
                              </div>
                              <span id="loadingIndicator" class="fa fa-cog fa-spin fa-med link-color-black vertical-center loading-indicator-hidden" aria-hidden="true"></span>&nbsp;<button type="submit" id="createButton" class="btn btn-success btn-default"><span class="glyphicon glyphicon-plus"></span> Erstellen</button>
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
	$('#createForm').on('submit', function(e) {
    	$.ajax({
            type: "POST",
            url: '<?php echo $viewModel->get('BaseUrl') ?>user/create?do=1',
            data: $("#createForm").serialize(), // serializes the form's elements.
            dataType: 'json',
            beforeSend: function(){
            	$("#loadingIndicator").toggleClass('loading-indicator-hidden');
            	$('#createButton').attr('disabled','disabled');
            },
            success: function(data)
            {
                switch(data.status)
                {
                case 'NOTHINGINSERTED':
                	new PNotify({
                	    title: 'Oh Nein!',
                	    text: data.text,
                	    type: 'warning'
                	});
                	$('#createButton').removeAttr('disabled');
                	break;
                case 'OK':
                	new PNotify({
                	    title: 'Super!',
                	    text: data.text,
                	    type: 'success'
                	});
                	$(location).wait(2500).attr('href', '<?php echo $viewModel->get('BaseUrl'); ?>user');
                    break;
                case 'NOACCESSEXPIRED':
                	new PNotify({
                	    title: 'Oh Nein!',
                	    text: data.text,
                	    type: 'error'
                	});
                	$('#createButton').removeAttr('disabled');
                    break;
                case 'NOTCOMPLETE':
                	new PNotify({
                	    title: 'Oh Nein!',
                	    text: data.text,
                	    type: 'warning'
                	});
                	$('#createButton').removeAttr('disabled');
                    break;
                }
                $("#loadingIndicator").toggleClass('loading-indicator-hidden');
            },
            fail: function() {
            	$("#loadingIndicator").toggleClass('loading-indicator-hidden');
            	new PNotify({
            	    title: 'Oh Nein!',
            	    text: 'Es kann keine Verbindung zum Server hergestellt werden.',
            	    type: 'error'
            	});
            	$('#createButton').removeAttr('disabled');
            }
          });
    	e.preventDefault(); // avoid to execute the actual submit of the form.
    });
});
</script>
<?php include 'views/footer.php'; ?>