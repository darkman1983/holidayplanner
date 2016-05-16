<?php include 'views/header.php'; ?>
<?php include 'views/navbar.php'; ?>
<?php 
$feastDaysData = $viewModel->get('feastDaysData');
?>
    <div class="container">
      <div id="login-overlay" class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title" id="myModalLabel">Feiertag ändern</h4>
          </div>
          <div class="modal-body">
              <div class="row">
                  <div class="col-xs-12">
                      <div class="well">
                          <form id="feastDaysEditForm" name="feastDaysEditForm" method="POST" action="<?php echo $viewModel->get('BaseUrl') ?>feastdays/edit?do=1&feastDaysEditID=<?php echo $viewModel->get('feastDaysEditID'); ?>" role="form" data-toggle="validator">
                              <div class="form-group has-feedback" id="usernameGroup">
                                  <label for="frm_daterange" class="control-label">Feiertag wählen</label>
                                  <div class='input-group input-daterange'>
                                    <span class="input-group-addon" id="sizing-addon1">Format: TT.MM.JJJJ</span>
                                    <input type="text" class="form-control" id="frm_date" name="frm_date" value="<?php echo date("d.m.Y", $feastDaysData['date']); ?>" placeholder="Bitte Datum Wählen oder Eingeben" required>
                                    <i class="form-control-feedback glyphicon glyphicon-calendar"></i>
                                  </div>
                                  <div class="help-block with-errors"></div>
                              </div>
                              <div class="form-group has-feedback">
                                  <label for="frm_description" class="control-label">Beschreibung</label>
                                  <textarea rows="4" cols="2" class="form-control" id="frm_description" name="frm_description" placeholder="Beschreibung Eingeben" required><?php echo $feastDaysData['description']; ?></textarea>
                                  <div class="help-block with-errors"></div>
                              </div>
                              <span id="loadingIndicator" class="fa fa-cog fa-spin fa-med link-color-black vertical-center loading-indicator-hidden" aria-hidden="true"></span>&nbsp;<button type="submit" class="btn btn-success btn-default">Ändern</button>
                              <a href="<?php echo $viewModel->get('BaseUrl'); ?>feastdays" class="btn btn-danger btn-default"><span class="glyphicon glyphicon-remove"></span> Abbrechen</a>
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
		$('#frm_date').daterangepicker({
			"singleDatePicker": true,
		    "showWeekNumbers": true,
		    "locale": {
		        "format": "DD.MM.YYYY",
		        "separator": " - ",
		        "applyLabel": "OK",
		        "cancelLabel": "Schließen",
		        "fromLabel": "Von",
		        "toLabel": "Bis",
		        "customRangeLabel": "Custom",
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
		    }
		}, function(start, end, label) {
		  //console.log("New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')");
		});

		$('textarea').inputlimiter();

		$('#feastDaysEditForm').on('submit', function(e) {
	    	$.ajax({
	            type: "POST",
	            url: '<?php echo $viewModel->get('BaseUrl'); ?>feastdays/edit?do=1&feastDaysEditID=' + $.getUrlParam('feastDaysEditID'),
	            data: $("#feastDaysEditForm").serialize(), // serializes the form's elements.
	            dataType: 'json',
	            beforeSend: function(){
	            	$("#loadingIndicator").toggleClass('loading-indicator-hidden');
	            	$('#feastdaysButton').attr('disabled','disabled');
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
	                	$(location).wait(2500).attr('href', '<?php echo $viewModel->get('BaseUrl'); ?>feastdays');
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
	            	new PNotify({
	            	    title: 'Oh Nein!',
	            	    text: 'Es kann keine Verbindung zum Server hergestellt werden.',
	            	    type: 'error'
	            	});
	            	$('#feastdaysButton').removeAttr('disabled');
	            }
	          });
	    	e.preventDefault(); // avoid to execute the actual submit of the form.
	    });
});
</script>
<?php include 'views/footer.php'; ?>