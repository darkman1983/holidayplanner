<?php include 'views/header.php'; ?>
<?php include 'views/navbar.php'; ?>
    <div class="container">
    <div class="modal-content">
    <div class="modal-header">
    <h2>Urlaubsübersicht für alle Benutzer</h2>
    <div id="loadingIndicator" class="navbar-header navbar-left hidden">
      <i class="fa fa-cog fa-spin fa-1x margin-bottom link-color-black" aria-hidden="true" title="Lade Inhalte..."></i>
    </div>
    <div class="navbar-header navbar-right table-navbar">
			<div class="form-group">
			  <div class="input-group help-addon max-200">
				<input type="text" class="form-control" id="managerHolidaysFilter" name="managerHolidaysFilter" placeholder="Filter">
				<div class="input-group-btn">
                  <button class="btn btn-default" data-toggle="modal" data-target="#filter-help"><i class="glyphicon glyphicon-question-sign"></i></button>
                </div>
			  </div>
			</div>
	</div>
	<a href="#" class="glyphicon glyphicon-refresh nounderline navbar-right padding-right-5 link-color-black link-color-lightgrey" id="reloadHoliday" title="Benutzertabelle neu Laden"></a>
	</div>
	<div class="modal-body">
  <div class="table-responsive" id="managerHolidays">
  <table class="table table-striped ">
    <thead>
      <tr>
        <th>#</th>
        <th>Vorname</th>
        <th>Nachname</th>
        <th>Jahresurlaub</th>
        <th>Noch Verfügbar</th>
        <th>Unbearbeitete Anträge</th>
        <th>Anträge Gesamt</th>
        <th class="center-text">Aktion</th>
      </tr>
    </thead>
    <tbody>
    <?php 
    $userData = $viewModel->get ( 'userData' );
    if(!empty($userData)) {
      $maxNum = strlen(max($userData)['id']);
      foreach($userData as &$data) {
    ?>
      <tr>
        <td class="col-xs-1 vertical-center">
          <span><?php echo $data['staffid']; ?></span>
        </td>
        <td class="col-xs-1 vertical-center">
          <span><?php echo $data['firstname']; ?></span>
        </td>
        <td class="col-xs-2 vertical-center">
          <span><?php echo $data['lastname']; ?></span>
        </td>
        <td class="col-xs-1 vertical-center">
          <span><?php echo $data['maxHoliday']; ?></span>
        </td>
        <td class="col-xs-2 vertical-center">
          <span><?php echo ($data ['remainingHoliday'] == $data ['maxHoliday']) ? $data ['maxHoliday'] : ($data ['maxHoliday'] - $data ['remainingHoliday']); ?></span>
        </td>
        <td class="col-xs-2 vertical-center">
          <span><?php echo $data ['notProcessed'] ?></span>
        </td>
        <td class="col-xs-2 vertical-center">
          <span><?php echo $data ['allProposals'] ?></span>
        </td>
        <td class="col-xs-2 vertical-center center-text a-spacing-4">
        <a href="<?php echo $viewModel->get ( 'BaseUrl' ); ?>manager/userdetails?userID=<?php echo $data['id']; ?>" class="glyphicon glyphicon-info-sign nounderline link-color-black link-color-lightgrey glyphicon-medium spacing-4" title="Anträge des Benutzers" aria-hidden="true"></a>
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
      echo ($paginationData['page'] > 1) ? '<a href="'.$viewModel->get ( 'BaseUrl' ).'manager?page=1" aria-label="Erste Seite">&laquo;</a> <a href="'.$viewModel->get ( 'BaseUrl' ).'manager?page=' . ($paginationData['page'] - 1) . '" aria-label="Zurück">&lsaquo;</a>' : '<span class="disabled" aria-hidden="true">&laquo;</span><span class="disabled" aria-hidden="true">&lsaquo;</span>';
        ?>
      </li>
      <li><span class="modal-pagination-black"><?php echo ' Seite ', $paginationData['page'], ' von ', $paginationData['pages'], ', zeige ', $paginationData['start'], '-', $paginationData['end'], ' von ', $paginationData['total'], ' ergebnissen '; ?></span></li>
      <li>
      <?php 
      echo ($paginationData['page'] < $paginationData['pages']) ? '<a href="'.$viewModel->get ( 'BaseUrl' ).'manager?page=' . ($paginationData['page'] + 1) . '" aria-label="Weiter">&rsaquo;</a> <a href="'.$viewModel->get ( 'BaseUrl' ).'manager?page=' . $paginationData['pages'] . '" aria-label="Letzte Seite">&raquo;</a>' : '<span class="disabled">&rsaquo;</span><span class="disabled">&raquo;</span>';
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
                    <p>Sie sind dabei einen Benutzer zu LÖSCHEN, dies kann nicht rückgängig gemacht werden.</p>
                    <p>Wollen Sie den Benutzer wirklich löschen?</p>
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
                    <p># (Personalnummer), Vorname und Nachname</p>
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
	var timer;
	var x;
	
	$("#managerHolidaysFilter").keyup(function() {
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
		x = $.get( "<?php echo $viewModel->get ( 'BaseUrl' ); ?>Ajax/filtermanagerholidays?managerHolidaysFilter=" + $('#managerHolidaysFilter').val() + withPage , function( data ) {
			  $( "#managerHolidays" ).html( data );

			  if($( "#managerHolidays table tbody tr").length == 0)
				{
				  $( "#managerHolidays table tbody").append('<tr><td colspan="8" class="text-center">Nichts gefunden</td></tr>');
				}
			  $("#loadingIndicator").toggleClass('hidden');
			});
		$.get( "<?php echo $viewModel->get ( 'BaseUrl' ); ?>Ajax/getlogouttime", function( data ) {
			$( "#logouttime" ).html( data );
			});
	    }, 1000);
    });
    
	$("#reloadHoliday").click(function() {
		$("#managerHolidaysFilter").val('');
		$(".pagination").show();
		$("#loadingIndicator").toggleClass('hidden');
		$.getq( "reload", "<?php echo $viewModel->get ( 'BaseUrl' ); ?>Ajax/filtermanagerholidays?managerHolidaysFilter=&page=" + $.getUrlParam('page'), function( data ) {
			$( "#managerHolidays" ).html( data );
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
				$('#confirm-delete .modal-title').text('Benutzer gelöscht!');
				$('#confirm-delete .modal-body').html('Der Benutzer wurde erfolgreich gelöscht!');
				$('#confirm-delete .modal-footer').html('');
				$(window).wait(2000).attr("location","<?php echo $viewModel->get ( 'BaseUrl' ); ?>manager");
				}).fail(function() {
				    alert( "error" );
				  });
			});
		});
    });
</script>
<?php include 'views/footer.php'; ?>