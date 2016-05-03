<?php include 'views/header.php'; ?>
<?php include 'views/navbar.php'; ?>
    <div class="container">
    <div class="modal-content">
    <div class="modal-header">
    <h2>Urlaubsübersicht</h2>
    <div id="loadingIndicator" class="navbar-header navbar-left hidden">
      <i class="fa fa-cog fa-spin fa-1x margin-bottom link-color-black" aria-hidden="true" title="Lade Inhalte..."></i>
    </div>
    <div class="navbar-header navbar-right table-navbar">
			<div class="form-group">
			<div class="input-group help-addon max-200">
				<input type="text" class="form-control" id="holidayFilter" name="holidayFilter" placeholder="Filter">
				<div class="input-group-btn">
                  <button class="btn btn-default" data-toggle="modal" data-target="#filter-help"><i class="glyphicon glyphicon-question-sign"></i></button>
                </div>
			</div>
			</div>
	</div>
	<a href="#" class="glyphicon glyphicon-refresh nounderline navbar-right padding-right-5 link-color-black link-color-lightgrey" id="reloadFeastDays" title="Urlaubsanträge neu laden"></a>
	<a href="<?php echo $viewModel->get ( 'BaseUrl' )?>holiday/propose" class="glyphicon glyphicon-plus nounderline navbar-right link-color-black link-color-lightgrey" title="Urlaub beantragen"></a>
	</div>
	<div class="modal-body">
  <div class="table-responsive" id="feastdays">
  <table class="table table-striped">
    <thead>
      <tr>
        <th>#</th>
        <th>Einreichdatum</th>
        <th>Startdatum</th>
        <th>Enddatum</th>
        <th>Tage</th>
        <th>Anmerkung</th>
        <th>Rückmeldung</th>
        <th>Typ</th>
        <th>Status</th>
        <th class="center-text">Aktionen</th>
      </tr>
    </thead>
    <tbody>
    <?php 
    $userData = $viewModel->get ( 'userData' );
    $userHolidayData = $viewModel->get ( 'userHolidayData' );
    if(!empty($userHolidayData))
    {
      $maxNum = strlen(max($userHolidayData)['id']);
      foreach($userHolidayData as &$data) {
    ?>
      <tr>
        <td class="vertical-center">
          <span><?php echo str_pad($data['id'], $maxNum, 0, STR_PAD_LEFT); ?></span>
        </td>
        <td class="vertical-center">
          <span><?php echo date("d.m.Y", $data['submitdate']); ?></span>
        </td>
        <td class="vertical-center">
          <span><?php echo date("d.m.Y", $data['startdate']); ?></span>
        </td>
        <td class="vertical-center">
          <span><?php echo date("d.m.Y", $data['enddate']); ?></span>
        </td>
        <td class="vertical-center">
          <span><?php echo $data['days']; ?></span>
        </td>
        <td class="col-xs-2 vertical-center">
          <span><?php echo $data['note']; ?></span>
        </td>
        <td class="col-xs-2 vertical-center">
          <span><?php echo $data['response_note']; ?></span>
        </td>
        <td class="vertical-center">
          <span><?php
          switch($data['type']) {
            case 'H':
              $txt = "Urlaub";
              break;
            case 'I':
              $txt = "Krankheit";
              break;
          }
          
          echo $txt;
          ?></span>
        </td>
        <td class="vertical-center">
          <span><?php 
          switch(($data['type'] == 'I') ? 3 : $data['approved'])
          {
            case 0:
              $txt = "Unbearbeitet";
              break;
            case 1:
              $txt = "Nicht genehmigt";
              break;
            case 2:
              $txt = "Genehmigt";
              break;
            case 3:
              $txt = "Eingetragen";
              break;
          }
          
          echo $txt;
          ?></span>
        </td>
        <td class="vertical-center center-text a-spacing-4">
        <?php if($data['approved'] == 0 && $data['type'] != 'I') { ?>
        <a href="#" class="glyphicon glyphicon-remove nounderline link-color-black link-color-lightgrey glyphicon-medium" title="Löschen" data-href="<?php echo $viewModel->get ( 'BaseUrl' ); ?>Ajax/deleteHoliday?holidayFilter=&holidayDeleteID=<?php echo $data['id']; ?>" data-toggle="modal" data-target="#confirm-delete" aria-hidden="true"></a>
        <a href="<?php echo $viewModel->get ( 'BaseUrl' ); ?>holiday/edit?holidayEditID=<?php echo $data['id']; ?>" class="glyphicon glyphicon-edit nounderline link-color-black link-color-lightgrey glyphicon-medium" title="Bearbeiten" aria-hidden="true"></a>
        <?php } else { ?>
        <a href="#" class="glyphicon glyphicon-remove glyphicon-medium nounderline link-disabled"></a>
        <a href="#" class="glyphicon glyphicon-edit glyphicon-medium nounderline link-disabled"></a>
        <?php } ?>
        <?php if($data['type'] != 'I') { ?>
        <a href="<?php echo $viewModel->get ( 'BaseUrl' ); ?>pdf/showPdf?pdfID=<?php echo $data['id']; ?>" class="fa fa-file-pdf-o nounderline link-color-black link-color-lightgrey glyphicon-medium" title="Als PDF anzeigen" target="_blank" aria-hidden="true"></a>
        <?php } else {?>
        <a href="#" class="fa fa-file-pdf-o glyphicon-medium nounderline link-disabled"></a>
        <?php } ?>
        </td>
      </tr>
      <?php
      }
    }
        ?>
    </tbody>
  </table>
  </div>
</div>
<div class="modal-footer modal-pagination">
<div class="bold-font text-center vertical-middle padding-t5">Jahresurlaub: <?php echo $userData[0]['remainingHoliday']; ?> Tage von <?php echo $userData[0]['maxHoliday']; ?> verbleibend</div>
<hr class="hr-reduce-margin">
<?php 
$paginationData = $viewModel->get ( 'pagination' );
?>
  <nav>
    <ul class="pagination pagination-nomargintop">
      <li>
      <?php
      echo ($paginationData['page'] > 1) ? '<a href="'.$viewModel->get ( 'BaseUrl' ).'user?page=1" aria-label="Erste Seite">&laquo;</a> <a href="'.$viewModel->get ( 'BaseUrl' ).'user?page=' . ($paginationData['page'] - 1) . '" aria-label="Zurück">&lsaquo;</a>' : '<span class="disabled" aria-hidden="true">&laquo;</span><span class="disabled" aria-hidden="true">&lsaquo;</span>';
        ?>
      </li>
      <li><span class="modal-pagination-black"><?php echo ' Seite ', $paginationData['page'], ' von ', $paginationData['pages'], ', zeige ', $paginationData['start'], '-', $paginationData['end'], ' von ', $paginationData['total'], ' ergebnissen '; ?></span></li>
      <li>
      <?php 
      echo ($paginationData['page'] < $paginationData['pages']) ? '<a href="'.$viewModel->get ( 'BaseUrl' ).'user?page=' . ($paginationData['page'] + 1) . '" aria-label="Weiter">&rsaquo;</a> <a href="'.$viewModel->get ( 'BaseUrl' ).'user?page=' . $paginationData['pages'] . '" aria-label="Letzte Seite">&raquo;</a>' : '<span class="disabled">&rsaquo;</span><span class="disabled">&raquo;</span>';
      ?>
      </li>
    </ul>
  </nav>
</div>
</div>
</div>
<div class="modal fade" id="confirm-delete" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Löschen bestätigen</h4>
                </div>
                <div class="modal-body">
                    <p>Sie sind dabei einen Feiertag zu LÖSCHEN, dies kann nicht rückgängig gemacht werden.</p>
                    <p>Wollen Sie den Feiertag wirklich löschen?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
                    <a id="deleteConfirmed" class="btn btn-danger btn-ok">Löschen</a>
                </div>
            </div>
        </div>
    </div>
<div class="modal fade" id="filter-help" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Filterhilfe</h4>
                </div>
                <div class="modal-body">
                    <p>Wenn sie einen Suchbegriff eingeben, wird automatisch gesucht in:</p>
                    <p>Startdatum, Anmerkung, Rückmeldung, Status</p>
                    <p>Während gefiltert wird, ist die Datensatznavigation nicht verfügbar!</p>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-ok btn-success" data-dismiss="modal">Verstanden</a>
                </div>
            </div>
        </div>
    </div>
<script>
$(document).ready(function(){
	$("#holidayFilter").keyup(function() {
		var withPage = '';
		
		if($(this).val() != '')
		{
		$(".pagination").hide();
		}else {
			withPage = "&page=" + $.getUrlParam('page');
			$(".pagination").show();
		}
		$("#loadingIndicator").toggleClass('hidden');
		$.get( "<?php echo $viewModel->get ( 'BaseUrl' ); ?>Ajax/filterholidays?holidayFilter=" + $("#holidayFilter").val(), function( data ) {
			  $( "#feastdays" ).html( data );
			  $("#loadingIndicator").toggleClass('hidden');
			});
		$.get( "<?php echo $viewModel->get ( 'BaseUrl' ); ?>Ajax/getlogouttime", function( data ) {
			$( "#logouttime" ).html( data );
			});
    });
    
	$("#reloadFeastDays").click(function() {
		$("#FeastDaysFilter").val('');
		$("#loadingIndicator").toggleClass('hidden');
		$.get( "<?php echo $viewModel->get ( 'BaseUrl' ); ?>Ajax/filterholidays?holidayFilter=&page=" + $.getUrlParam('page'), function( data ) {
			$( "#feastdays" ).html( data );
			$("#loadingIndicator").toggleClass('hidden');
			});
		$.get( "<?php echo $viewModel->get ( 'BaseUrl' ); ?>Ajax/getlogouttime", function( data ) {
			$( "#logouttime" ).html( data );
			});
		});
	
	$('#confirm-delete').on('show.bs.modal', function(e) {
		$("#deleteConfirmed").click(function() {
			$.get( $(e.relatedTarget).data('href'), function( data ) {
				$('#confirm-delete .modal-header button').remove();
				$('#confirm-delete .modal-title').text('Feiertag gelöscht!');
				$('#confirm-delete .modal-body').html('Der Feiertag wurde erfolgreich gelöscht!');
				$('#confirm-delete .modal-footer').html('');
				$(window).wait(2000).attr("location","<?php echo $viewModel->get ( 'BaseUrl' ); ?>holiday");
				}).fail(function() {
				    alert( "error" );
				  });
			$.get( "<?php echo $viewModel->get ( 'BaseUrl' ); ?>Ajax/getlogouttime", function( data ) {
				$( "#logouttime" ).html( data );
				});
			});
		});
    });
</script>
<?php include 'views/footer.php'; ?>