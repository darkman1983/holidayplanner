<?php include 'views/header.php'; ?>
<?php include 'views/navbar.php'; ?>
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
                          <form id="addForm" name="addForm" method="POST" action="<?php echo $viewModel->get('BaseUrl') ?>manager/add?do=1" role="form" data-toggle="validator">
                              <div class="form-group has-feedback has-feedback-left" id="usernameGroup">
                                  <label for="frm_daterange" class="control-label">Urlaubs- / Krankheitstage wählen</label>
                                  <div class='input-group input-daterange'>
                                    <span class="input-group-addon" id="sizing-addon1">Format: TT.MM.JJJJ - TT.MM.JJJJ</span>
                                    <input type="text" class="form-control" id="frm_daterange" name="frm_daterange" placeholder="Bitte Datum Wählen oder Eingeben" required>
                                    <i class="form-control-feedback glyphicon glyphicon-calendar"></i>
                                  </div>
                                  <div class="help-block with-errors"></div>
                              </div>
                              <div class="form-group has-feedback">
  								  <label for="frm_type">Typ Wählen</label>
  								  <select class="form-control" id="frm_type" name="frm_type">
  								    <option value="H">Urlaub</option>
  								    <option value="I">Krankheit</option>
  								  </select>
                              </div>
                              <div class="form-group has-feedback">
  								  <label for="frm_status">Status Wählen</label>
  								  <select class="form-control" id="frm_status" name="frm_status">
  								    <option value="1">Nicht genehmigt</option>
  								    <option value="2">Genehmigt</option>
  								    <option value="3">Eingetragen</option>
  								  </select>
                              </div>
                              <div class="form-group">
                                  <label for="frm_note" class="control-label">Anmerkungen</label>
                                  <textarea rows="4" cols="2" class="form-control" id="frm_note" name="frm_note" placeholder="Anmerkungen Eingeben"></textarea>
                                  <div class="help-block with-errors"></div>
                              </div>
                              <div class="form-group">
                                  <label for="frm_response_note" class="control-label">Rückmeldung</label>
                                  <textarea rows="4" cols="2" class="form-control" id="frm_response_note" name="frm_response_note" placeholder="Rückmeldung Eingeben"></textarea>
                                  <div class="help-block with-errors"></div>
                              </div>
                              <span id="loadingIndicator" class="fa fa-cog fa-spin fa-med link-color-black vertical-center loading-indicator-hidden" aria-hidden="true"></span>&nbsp;<button type="submit" id="addButton" class="btn btn-success btn-default"><span class="glyphicon glyphicon-plus"></span> Erstellen</button>
                              <a href="<?php echo $viewModel->get('BaseUrl'); ?>manager/userdetails?userID=<?php echo $viewModel->get('uid'); ?>" class="btn btn-danger btn-default"><span class="glyphicon glyphicon-remove"></span> Abbrechen</a>
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
	$('#frm_daterange').daterangepicker({
	    "showWeekNumbers": true,
	    "locale": {
	        "format": "DD.MM.YYYY",
	        "separator": " - ",
	        "applyLabel": "OK",
	        "cancelLabel": "Schließen",
	        "fromLabel": "Von",
	        "toLabel": "Bis",
	        "daysOfWeek": [
	            "So",
	            "Mo",
	            "Di",
	            "Mi",
	            "Do",
	            "Fr",
	            "Sa"
	        ],
	        "monthNames": [
	            "Januar",
	            "Februar",
	            "März",
	            "April",
	            "Mai",
	            "Juni",
	            "Juli",
	            "August",
	            "September",
	            "October",
	            "November",
	            "Dezember"
	        ],
	        "firstDay": 1
	    },
	    "minDate": "<?php echo date("d.m.Y", time()) ?>",
        "maxDate": "<?php echo date("d.m.Y", strtotime("Dec 31", strtotime("+1 year"))); ?>"
	}, function(start, end, label) {
	  //console.log("New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')");
	});

	$('textarea').inputlimiter();

	$('#addForm').on('submit', function(e) {
    	$.ajax({
            type: "POST",
            url: '<?php echo $viewModel->get('BaseUrl') ?>manager/add?do=1&userID=' + $.getUrlParam('userID'),
            data: $("#addForm").serialize(), // serializes the form's elements.
            dataType: 'json',
            beforeSend: function(){
            	$("#loadingIndicator").toggleClass('loading-indicator-hidden');
            	$('#processButton').attr('disabled','disabled');
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