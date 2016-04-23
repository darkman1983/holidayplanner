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
                          <form id="loginForm" method="POST" action="<?php echo $viewModel->get('BaseUrl') ?>feastdays/edit?do=1&feastDaysEditID=<?php echo $viewModel->get('feastDaysEditID'); ?>" role="form" data-toggle="validator">
                              <div class="form-group" id="usernameGroup">
                                  <label for="frm_startdate" class="control-label">Startdatum</label>
                                  <div class='input-group date' id='datetimepicker1'>
                                    <span class="input-group-addon" id="sizing-addon1">Format: TT.MM.JJJJ</span>
                                    <input type="text" class="form-control" id="frm_startdate" name="frm_startdate" placeholder="Bitte Datum Wählen oder Eingeben" value="<?php echo date("d.m.Y", $feastDaysData['start']); ?>" data-remote="<?php echo $viewModel->get('BaseUrl'); ?>ajax/validatefeastday" data-error="Oops! Dieser Feiertag existiert schon!" required>
                                    <span class="input-group-addon">
                                      <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                  </div>
                                  <div class="help-block with-errors"></div>
                              </div>
                              <div class="form-group">
                                  <label for="frm_enddate" class="control-label">Enddatum</label>
                                  <div class='input-group date' id='datetimepicker2'>
                                    <span class="input-group-addon" id="sizing-addon1">Format: TT.MM.JJJJ</span>
                                    <input type="text" class="form-control" id="frm_enddate" name="frm_enddate" value="<?php echo ($feastDaysData['duration'] > 1) ? date("d.m.Y", strtotime(sprintf("+%s days", $feastDaysData['duration']-1), $feastDaysData['start'])) : date("d.m.Y", $feastDaysData['start']); ?>" placeholder="Dauer in Tagen Eingeben" required>
                                    <span class="input-group-addon">
                                      <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                  </div>
                                  <div class="help-block with-errors"></div>
                              </div>
                              <div class="form-group">
                                  <label for="frm_description" class="control-label">Beschreibung</label>
                                  <textarea rows="4" cols="2" class="form-control" id="frm_description" name="frm_description" placeholder="Beschreibung Eingeben" required><?php echo $feastDaysData['description']; ?></textarea>
                                  <div class="help-block with-errors"></div>
                              </div>
                              <button type="submit" class="btn btn-success btn-default">Ändern</button>
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
	$('#datetimepicker1').datetimepicker({
        locale: 'de',
        format: 'L',
        useCurrent: false
    });
	$('#datetimepicker2').datetimepicker({
        locale: 'de',
        format: 'L',
        useCurrent: false
    });
	$("#datetimepicker1").on("dp.change", function (e) {
        $('#datetimepicker2').data("DateTimePicker").minDate(e.date);
    });
    $("#datetimepicker2").on("dp.change", function (e) {
        $('#datetimepicker1').data("DateTimePicker").maxDate(e.date);
    });
});
</script>
<?php include 'views/footer.php'; ?>