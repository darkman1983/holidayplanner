<?php include 'views/header.php'; ?>
<?php include 'views/navbar.php'; ?>
    <div class="modal-content modal-space">
    <div class="modal-header">
    <h2>Antragsübersicht</h2>
    <div id="loadingIndicator" class="navbar-header navbar-left hidden">
      <i class="fa fa-cog fa-spin fa-1x margin-bottom link-color-black" aria-hidden="true" title="Lade Inhalte..."></i>
    </div>
    <div class="navbar-header navbar-right table-navbar">
			<div class="form-group">
			<div class="input-group help-addon max-200">
				<input type="text" class="form-control" id="managerUserDetailsFilter" name="managerUserDetailsFilter" placeholder="Filter">
				<div class="input-group-btn">
                  <button class="btn btn-default" data-toggle="modal" data-target="#filter-help"><i class="glyphicon glyphicon-question-sign"></i></button>
                </div>
			</div>
			</div>
	</div>
	<a href="#" class="glyphicon glyphicon-refresh nounderline navbar-right padding-right-5 link-color-black link-color-lightgrey spacing-4" id="reloadmanagerUserDetails" title="Urlaubsanträge neu laden"></a>
	<a href="<?php echo $viewModel->get ( 'BaseUrl' )?>manager/add?userID=<?php echo $viewModel->get ( 'uid' )?>" class="glyphicon glyphicon-plus nounderline navbar-right link-color-black link-color-lightgrey spacing-4" title="Urlaub oder Krankheit Hinzufügen"></a>
	<a href="<?php echo $viewModel->get ( 'BaseUrl' )?>manager" class="glyphicon glyphicon-arrow-left nounderline navbar-right link-color-black link-color-lightgrey spacing-4" title="Zurück zur Übersicht"></a>
	</div>
	<div class="modal-body">
  <div class="table-responsive" id="managerUserDetails">
  <table class="table table-striped">
    <thead>
      <tr>
        <th>#</th>
        <th>Name</th>
        <th>Einreichdatum</th>
        <th>Von - Bis</th>
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
    $userData = $viewModel->get ( 'userHolidayData' );
    $maxHoliday = $viewModel->get ( 'maxHoliday' );

    if(!empty($userData))
    {
      $maxNum = strlen(max($userData)['id']);
      foreach($userData as &$data) {
    ?>
      <tr>
        <td class="vertical-center">
          <span><?php echo str_pad($data['id'], $maxNum, 0, STR_PAD_LEFT); ?></span>
        </td>
        <td class="vertical-center">
          <span><?php echo $data['firstname']." ".$data['lastname']; ?></span>
        </td>
        <td class="vertical-center">
          <span><?php echo date("d.m.Y", $data['submitdate']); ?></span>
        </td>
        <td class="vertical-center">
          <span><?php echo date("d.m.Y", $data['startdate']); ?> - <?php echo date("d.m.Y", $data['enddate']); ?></span>
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
          switch(($data['type'] == 'I') ? 3 : $data['status'])
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
        <?php if($data['status'] == 3) { ?>
        <a href="#" class="glyphicon glyphicon-remove nounderline link-color-black link-color-lightgrey glyphicon-medium" title="Löschen" data-href="<?php echo $viewModel->get ( 'BaseUrl' ); ?>Ajax/managerDeleteHoliday?holidayFilter=&holidayDeleteID=<?php echo $data['id']; ?>" data-toggle="modal" data-target="#confirm-delete" aria-hidden="true"></a>
        <?php } else { ?>
        <a href="#" class="glyphicon glyphicon-remove glyphicon-medium nounderline link-disabled"></a>
        <?php } ?>
        <a href="<?php echo $viewModel->get ( 'BaseUrl' ); ?>manager/process?holidayProcessID=<?php echo $data['id']; ?>&userID=<?php echo $viewModel->get ( 'uid' )?>" class="glyphicon glyphicon-edit nounderline link-color-black link-color-lightgrey glyphicon-medium" title="Bearbeiten" aria-hidden="true"></a>
        <?php if ($data['type'] != 'I') { ?>
        <a href="#" class="fa fa-file-pdf-o nounderline link-color-black link-color-lightgrey glyphicon-medium" title="Als PDF anzeigen" data-href="<?php echo $viewModel->get ( 'BaseUrl' ); ?>pdf/managershowpdf?pdfID=<?php echo $data['id']; ?>" data-toggle="modal" data-target="#viewPdf" aria-hidden="true"></a>
        <?php } else { ?>
        <a href="#" class="fa fa-file-pdf-o nounderline glyphicon-medium link-disabled"></a>
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
<?php 
$paginationData = $viewModel->get ( 'pagination' );
?>
  <nav>
    <ul class="pagination">
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
<div class="modal fade" id="confirm-delete" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Löschen bestätigen</h4>
                </div>
                <div class="modal-body">
                    <p>Sie sind dabei einen Urlaubsantrag zu LÖSCHEN, dies kann nicht rückgängig gemacht werden.</p>
                    <p>Wollen Sie den Urlaubsantrag wirklich löschen?</p>
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
                    <p>Einreichdatum, Startdatum, Anmerkung, Rückmeldung, Typ und Status</p>
                    <p>Während gefiltert wird, ist die Datensatznavigation nicht verfügbar!</p>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-ok btn-success" data-dismiss="modal">Verstanden</a>
                </div>
            </div>
        </div>
    </div>
<div class="modal fade" id="viewPdf" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-full">
            <div class="modal-content modal-content-full">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Urlaubsantrag</h4>
                </div>
                <div class="modal-body modal-body-full" id="pdfData">
                </div>
            </div>
        </div>
    </div>
<script>
$(document).ready(function(){
	var timer;
	var x;
	
	$("#managerUserDetailsFilter").keyup(function() {
		var withPage = '';
		
		if($(this).val() != '')
		{
		$(".pagination").hide();
		}else {
			withPage = "&page=" + $.getUrlParam('page');
			$(".pagination").show();
		}

		if (x) { x.abort() } // If there is an existing XHR, abort it.
	    clearTimeout(timer); // Clear the timer so we don't end up with dupes.
	    timer = setTimeout(function() { // assign timer a new timeout
		$("#loadingIndicator").toggleClass('hidden');
		x = $.get( "<?php echo $viewModel->get ( 'BaseUrl' ); ?>Ajax/filtermanageruserdetails?managerUserDetailsFilter=" + $("#managerUserDetailsFilter").val() + '&userID=' + $.getUrlParam('userID'), function( data ) {
			$( "#managerUserDetails").html( data );
			if($( "#managerUserDetails table tbody tr").length == 0)
				{
				  $( "#managerUserDetails table tbody").append('<tr><td colspan="10" class="text-center">Nichts gefunden</td></tr>');
				}
			  
			  $("#loadingIndicator").toggleClass('hidden');
			});
		$.get( "<?php echo $viewModel->get ( 'BaseUrl' ); ?>Ajax/getlogouttime", function( data ) {
			$( "#logouttime" ).html( data );
			});
	    }, 1000);
    });
    
	$("#reloadmanagerUserDetails").click(function() {
		$("#managerUserDetailsFilter").val('');
		$("#loadingIndicator").toggleClass('hidden');
		$.getq( "reload", "<?php echo $viewModel->get ( 'BaseUrl' ); ?>Ajax/filtermanageruserdetails?managerUserDetailsFilter=&page=" + $.getUrlParam('page') + '&userID=' + $.getUrlParam('userID'), function( data ) {
			$( "#managerUserDetails" ).html( data );
			$("#loadingIndicator").toggleClass('hidden');
			});
		$.getq( "logouttime", "<?php echo $viewModel->get ( 'BaseUrl' ); ?>Ajax/getlogouttime", function( data ) {
			$( "#logouttime" ).html( data );
			});
		});
	
	$('#confirm-delete').on('show.bs.modal', function(e) {
		$("#deleteConfirmed").click(function() {
			$.get( $(e.relatedTarget).data('href'), function( data ) {
				$('#confirm-delete .modal-header button').remove();
				$('#confirm-delete .modal-title').text('Urlaubsantrag gelöscht!');
				$('#confirm-delete .modal-body').html('Der Urlaubsantrag wurde erfolgreich gelöscht!');
				$('#confirm-delete .modal-footer').html('');
				$(window).wait(2000).attr("location","<?php echo $viewModel->get ( 'BaseUrl' ); ?>manager/userdetails?userID=" + $.getUrlParam('userID'));
				}).fail(function() {
				    alert( "error" );
				  });
			$.get( "<?php echo $viewModel->get ( 'BaseUrl' ); ?>Ajax/getlogouttime", function( data ) {
				$( "#logouttime" ).html( data );
				});
			});
		});

	$('#viewPdf').on('show.bs.modal', function(e) {
		$('#viewPdf .modal-body').html('<embed width=100% height=100% type="application/pdf" src="' + $(e.relatedTarget).data('href') + '"></embed>');
		});

    });
</script>
<?php include 'views/footer.php'; ?>