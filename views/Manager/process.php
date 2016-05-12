<?php include 'views/header.php'; ?>
<?php include 'views/navbar.php';
$userHolidayData = $viewModel->get('userHolidayData');
?>
    <div class="container">
      <div id="login-overlay" class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title" id="myModalLabel">Urlaub oder Krankheit Hinzufügen</h4>
          </div>
          <div class="modal-body">
              <div class="row">
                  <div class="col-xs-12">
                      <div class="well">
                          <form id="processForm" name="processForm" method="POST" action="<?php echo $viewModel->get('BaseUrl') ?>manager/process?do=1" role="form" data-toggle="validator">
                              <div class="form-group has-feedback has-feedback-left" id="usernameGroup">
                                  <label for="frm_daterange" class="control-label">Urlaubs- / Krankheitstage wählen</label>
                                  <div class='input-group input-daterange'>
                                    <span class="input-group-addon" id="sizing-addon1">Format: TT.MM.JJJJ - TT.MM.JJJJ</span>
                                    <input type="text" class="form-control" id="frm_daterange" name="frm_daterange" value="<?php echo date("d.m.Y", $userHolidayData['startdate']); ?> - <?php echo date("d.m.Y", $userHolidayData['enddate']); ?>" disabled>
                                    <i class="form-control-feedback glyphicon glyphicon-calendar"></i>
                                  </div>
                                  <div class="help-block with-errors"></div>
                              </div>
                              <div class="form-group has-feedback">
  								  <label for="frm_type">Typ Wählen</label>
  								  <select class="form-control" id="frm_type" name="frm_type">
  								    <option value="H">Urlaub</option>
  								    <option value="I"<?php echo ($userHolidayData['type'] == 'I') ? ' selected' : ''; ?>>Krankheit</option>
  								  </select>
                              </div>
                              <div class="form-group has-feedback">
  								  <label for="frm_status">Status Wählen</label>
  								  <select class="form-control" id="frm_status" name="frm_status">
  								  <option value="0">Unbearbeitet</option>
  								    <option value="1"<?php echo ($userHolidayData['status'] == 1) ? ' selected' : ''; ?>>Nicht genehmigt</option>
  								    <option value="2"<?php echo ($userHolidayData['status'] == 2) ? ' selected' : ''; ?>>Genehmigt</option>
  								    <option value="3"<?php echo ($userHolidayData['status'] == 3) ? ' selected' : ''; ?>>Eingetragen</option>
  								  </select>
                              </div>
                              <div class="form-group">
                                  <label for="frm_note" class="control-label">Anmerkungen</label>
                                  <textarea rows="4" cols="2" class="form-control" id="frm_note" name="frm_note" disabled><?php echo $userHolidayData['note']; ?></textarea>
                                  <div class="help-block with-errors"></div>
                              </div>
                              <div class="form-group">
                                  <label for="frm_response_note" class="control-label">Rückmeldung</label>
                                  <textarea rows="4" cols="2" class="form-control" id="frm_response_note" name="frm_response_note" placeholder="Rückmeldung Eingeben"><?php echo $userHolidayData['response_note']; ?></textarea>
                                  <div class="help-block with-errors"></div>
                              </div>
                              <span id="loadingIndicator" class="fa fa-cog fa-spin fa-med link-color-black vertical-center loading-indicator-hidden" aria-hidden="true"></span>&nbsp;<button type="submit" id="addButton" class="btn btn-success btn-default"><span class="glyphicon glyphicon-plus"></span> Erstellen</button>
                              <a id="pageBack" href="#" class="btn btn-danger btn-default"><span class="glyphicon glyphicon-remove"></span> Abbrechen</a>
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
	$('textarea').inputlimiter();

	$('#pageBack').on('click', function(e){
		window.history.back();
		e.preventDefault(); // avoid to execute the actual submit of the form.
		});

	$('#processForm').on('submit', function(e) {
    	$.ajax({
            type: "POST",
            url: '<?php echo $viewModel->get('BaseUrl') ?>manager/process?do=1&holidayProcessID=' + $.getUrlParam('holidayProcessID'),
            data: $("#processForm").serialize(), // serializes the form's elements.
            dataType: 'json',
            beforeSend: function(){
            	$("#loadingIndicator").toggleClass('loading-indicator-hidden');
            	$('#processButton').attr('disabled','disabled');
            },
            success: function(data)
            {
                switch(data.status)
                {
                case 'NOTHINGUPDATED':
                	new PNotify({
                	    title: 'Oh Nein!',
                	    text: data.text,
                	    type: 'warning'
                	});
                	$('#processButton').removeAttr('disabled');
                	break;
                case 'OK':
                	new PNotify({
                	    title: 'Super!',
                	    text: data.text,
                	    type: 'success'
                	});
                	$(location).wait(2500).attr('href', '<?php echo $viewModel->get('BaseUrl'); ?>manager/userdetails?userID=' + $.getUrlParam('userID'));
                    break;
                case 'NOACCESSEXPIRED':
                	new PNotify({
                	    title: 'Oh Nein!',
                	    text: data.text,
                	    type: 'error'
                	});
                	$('#processButton').removeAttr('disabled');
                    break;
                case 'NOTCOMPLETE':
                	new PNotify({
                	    title: 'Oh Nein!',
                	    text: data.text,
                	    type: 'warning'
                	});
                	$('#processButton').removeAttr('disabled');
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
            	$('#processButton').removeAttr('disabled');
            }
          });
    	e.preventDefault(); // avoid to execute the actual submit of the form.
    });

    $('#frm_type').on('change', function(e){
        if($(this).val() == 'I')
        {
        	$('#frm_status option:eq(2)').prop('selected', true);
        }else {
        	$('#frm_status option:eq(0)').prop('selected', true);
        }
        });
});
</script>
<?php include 'views/footer.php'; ?>