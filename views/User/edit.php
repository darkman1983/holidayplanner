<?php include 'views/header.php'; ?>
<?php include 'views/navbar.php';
$userData = $viewModel->get('userData');
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
                              <div class="form-group has-feedback" id="usernameGroup">
                                  <label for="frm_username" class="control-label">Benutzername</label>
                                  <input type="text" class="form-control" id="frm_username" name="frm_username" placeholder="Benutzernamen Eingeben" data-remote="<?php echo $viewModel->get('BaseUrl'); ?>ajax/validateuser?userEditID=<?php echo $userData[0]['id'] ?>" data-error="Oops! Dieser Benutzer existiert schon!" value="<?php echo $userData[0]['username'] ?>" required>
                                  <div class="help-block with-errors"></div>
                              </div>
                              <div class="form-group has-feedback">
                                  <label for="frm_uPassword" class="control-label">Passwort</label>
                                  <input type="password" class="form-control" id="frm_uPassword" name="frm_uPassword" placeholder="Neues Passwort Eingeben">
                                  <div class="help-block with-errors"></div>
                              </div>
                              <div class="form-group has-feedback">
                                  <label for="frm_confirmPassword" class="control-label">Passwort Wiederholen</label>
                                  <input type="password" class="form-control" id="frm_confirmPassword" name="frm_confirmPassword" placeholder="Passwort Wiederholen" data-match="#frm_uPassword" data-match-error="Oh nein, die Passwörter stimmen nicht überein!">
                                  <div class="help-block with-errors"></div>
                              </div>
                              <div class="form-group has-feedback">
  								  <label for="frm_userlevel">Benutzerlevel Wählen</label>
  								  <?php
  								  $levels = array(1 => "Normal", 2 => "Anträge Freigeben", 3 => "Administrator");
  								  $userID = $viewModel->get ( 'userID' );
  								  
  								  if($userID != $userData[0]['id'])
  								  {
  								  ?>
  								  <select class="form-control" id="frm_userlevel" name="frm_userlevel">
  								    <?php  								    
  								    foreach ($levels as $level => &$entry) {
  								      printf( '<option value="%s"%s>%s - %s</option>', $level, ($level == $userData[0]['level']) ? ' selected' : '', $level, $entry);
  								    }
  								    ?>
  								  </select>
  								  <?php
  								  } else {
  								    printf('<br><input type="hidden" name="frm_userlevel" value="%s"><span>%s</span>', $viewModel->get('level'), $levels[$viewModel->get('level')]);
  								  }
  								  ?>
                              </div>
                              <div class="form-group has-feedback">
  								  <label>Jahresurlaubstage pro Jahr</label><br>
  								  <a href="#" id="mhyAdd" class="glyphicon glyphicon-plus nounderline link-color-black link-color-lightgrey glyphicon-medium" title="Eintrag hinzufügen" data-toggle="modal" data-target="#addMhy" aria-hidden="true"></a>
  								  <a href="#" id="mhyDel" class="glyphicon glyphicon-remove nounderline link-color-black link-color-lightgrey glyphicon-medium" title="Markierte löschen" aria-hidden="true"></a>
  								  <a href="#" id="mhyInfo" class="glyphicon glyphicon-question-sign nounderline link-color-black link-color-lightgrey glyphicon-medium" aria-hidden="true"></a>
  								  <div class="table-responsive mhy-div">
  								  <table class="table table-striped mhy" id="mhy">
  								  <thead>
  								  <tr>
  								  <th>Jahr</th>
  								  <th>Urlaubstage</th>
  								  </tr>
  								  </thead>
  								  <tbody>
  								  <?php 
  								  $maxHolidayDataYear = $viewModel->get('maxHolidayDataYear');
  								  foreach ($maxHolidayDataYear as $mhyData) { ?>
  								  <tr>
  								    <td><input type="hidden" name="frm_years[]" id="years" value="<?php echo $mhyData['year']; ?>"><?php echo $mhyData['year']; ?></td>
  								    <td><input type="hidden" name="frm_maxHolidays[]" id="maxHolidays" value="<?php echo $mhyData['maxHoliday']; ?>"><?php echo $mhyData['maxHoliday']; ?></td>
  								    </tr>
  								    <?php } ?>
  								  </tbody>
  								  </table>
  								  </div>
                              </div>
                              <hr>
                              <div class="form-group has-feedback">
                                  <label for="frm_email" class="control-label">Email Adresse</label>
                                  <input type="email" class="form-control" id="frm_email" name="frm_email" placeholder="Email Eingeben" value="<?php echo $userData[0]['email']; ?>" required>
                                  <div class="help-block with-errors"></div>
                              </div>
                              <div class="form-group has-feedback">
                                  <label for="frm_firstname" class="control-label">Vorname</label>
                                  <input type="text" class="form-control" id="frm_firstname" name="frm_firstname" placeholder="Vorname Eingeben" value="<?php echo $userData[0]['firstname'] ?>" required>
                                  <div class="help-block with-errors"></div>
                              </div>
                              <div class="form-group has-feedback">
                                  <label for="frm_lastname" class="control-label">Nachname</label>
                                  <input type="text" class="form-control" id="frm_lastname" name="frm_lastname" placeholder="Nachname Eingeben" value="<?php echo $userData[0]['lastname'] ?>" required>
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
      <div class="modal fade" id="addMhy" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Jahresurlaubstage hinzufügen</h4>
                </div>
                <div class="modal-body">
                <div class="form-group">
                                  <label for="frm_mhyyear" class="control-label">Jahr</label>
                                  <input type="text" class="form-control" id="frm_mhyyear" name="frm_mhyyear" placeholder="Jahr Eingeben">
                              </div>
                <div class="form-group">
                                  <label for="frm_mhydays" class="control-label">Tage</label>
                                  <input type="text" class="form-control" id="frm_mhydays" name="frm_mhydays" placeholder="Anzahl der maximalen Tage Eingeben">
                              </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-ok btn-success" id="mhyAddButton" data-dismiss="modal">Hinzufügen</a>
                </div>
            </div>
        </div>
    </div>
<script>
$(document).ready(function(){
	$('#frm_uPassword').popover({
		'trigger': 'hover focus',
		'placement': 'bottom',
		'title': 'Information',
		'content': 'Leer lassen um kein neues Passwort zu vergeben!'
		});

	$('#mhyInfo').popover({
		'trigger': 'hover click',
		'placement': 'bottom',
		'title': 'Hilfe',
		'html': true,
		'content': '<p>Zum Hinzufügen neuer Jahresurlaubstage auf Hinzufügen klicken.</p>Einzelne oder mehrere Zeilen mit klicken markieren und dann auf Löschen klicken.'
		});
	
	$('#mhy tbody').on( 'click', 'tr', function () {
	    $(this).toggleClass('highlight');
	} );

	$("#mhyDel").click(function() {
		$('.highlight').remove();
		});

	$('#addMhy').on('shown.bs.modal', function () {
		$('#frm_mhyyear').val('');
		$('#frm_mhydays').val('');
        $('#frm_mhyyear').focus();
    });

	$("#mhyAddButton").click(function() {
		var isContained = false;
		$.each($("#mhy tbody").find("tr"), function() {
	        if($(this).text().indexOf($('#frm_mhyyear').val()) !== -1) {
	        	isContained = true;
    	        }
	    });

	    if(isContained) {
	    	new PNotify({
        	    title: 'Oh Nein!',
        	    text: 'Dieser Eintrag existiert schon.',
        	    type: 'error'
        	});
	    } else {
	    	$('#mhy > tbody').append('<tr><td><input type="hidden" name="frm_years[]" id="years" value="' + $('#frm_mhyyear').val() + '">' + $('#frm_mhyyear').val() +'</td><td><input type="hidden" name="frm_maxHolidays[]" id="maxHolidays" value="' + $('#frm_mhydays').val() +'">' + $('#frm_mhydays').val() +'</td></tr>');
	    }
		});
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