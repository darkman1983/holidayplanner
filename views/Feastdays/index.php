<?php include 'views/header.php'; ?>
<?php include 'views/navbar.php'; ?>
    <div class="container">
    <div class="modal-content">
    <div class="modal-header">
    <h2>Feiertagsverwaltung</h2>
    <div id="loadingIndicator" class="navbar-header navbar-left hidden">
      <i class="fa fa-cog fa-spin fa-1x margin-bottom link-color-black" aria-hidden="true" title="Lade Inhalte..."></i>
    </div>
    <div class="navbar-header navbar-right table-navbar">
			<div class="form-group">
				<input type="text" class="form-control" id="feastDaysFilter" name="feastDaysFilter" placeholder="Filter">
			</div>
	</div>
	<a href="#" class="glyphicon glyphicon-refresh nounderline navbar-right padding-right-5 link-color-black link-color-lightgrey" id="reloadFeastdays" title="Benutzertabelle neu Laden"></a>
	<a href="<?php echo $viewModel->get ( 'BaseUrl' )?>feastdays/create" class="glyphicon glyphicon-plus nounderline navbar-right link-color-black link-color-lightgrey" title="Benutzer Hinzufügen"></a>
	</div>
	<div class="modal-body">
  <div class="table-responsive" id="feastdays">
  <table class="table table-striped ">
    <thead>
      <tr>
        <th>#</th>
        <th>Startdatum</th>
        <th>Enddatum</th>
        <th>Beschreibung</th>
        <th>Angelegt von</th>
        <th>Löschen - Editieren</th>
      </tr>
    </thead>
    <tbody>
    <?php 
    $filteredUsers = $viewModel->get ( 'feastDaysData' );
    if(!empty($filteredUsers))
    {
      $maxNum = strlen(max($filteredUsers)['id']);
      foreach($filteredUsers as &$data) {
    ?>
      <tr>
        <td class="vertical-center">
          <span><?php echo str_pad($data['id'], $maxNum, 0, STR_PAD_LEFT); ?></span>
        </td>
        <td class="col-xs-2 vertical-center">
          <span><?php echo date("d.m.Y", $data['start']); ?></span>
        </td>
        <td class="col-xs-2 vertical-center">
          <span><?php echo ($data['duration'] > 1) ? date("d.m.Y", strtotime(sprintf("+%s days", $data['duration']-1), $data['start'])) : date("d.m.Y", $data['start']); ?></span>
        </td>
        <td class="col-xs-3 vertical-center">
          <span><?php echo $data['description']; ?></span>
        </td>
        <td class="col-xs-2 vertical-center">
          <span><?php echo $data['username']; ?></span>
        </td>
        <td class="col-xs-2 vertical-center center-text">
        <a href="#" class="glyphicon glyphicon-remove nounderline link-color-black link-color-lightgrey glyphicon-medium" data-href="<?php echo $viewModel->get ( 'BaseUrl' ); ?>Ajax/deletefeastdays?feastDaysFilter=&feastDaysDeleteID=<?php echo $data['id']; ?>" data-toggle="modal" data-target="#confirm-delete" aria-hidden="true"></a>
        <a href="<?php echo $viewModel->get ( 'BaseUrl' ); ?>feastdays/edit?feastDaysEditID=<?php echo $data['id']; ?>" class="glyphicon glyphicon-edit nounderline link-color-black link-color-lightgrey glyphicon-medium" aria-hidden="true"></a>
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
<script>
$(document).ready(function(){
	$("#feastDaysFilter").keyup(function() {
		$("#loadingIndicator").toggleClass('hidden');
		$.get( "<?php echo $viewModel->get ( 'BaseUrl' ); ?>Ajax/filterfeastdays?feastDaysFilter=" + $("#feastDaysFilter").val(), function( data ) {
			  $( "#feastdays" ).html( data );
			  $("#loadingIndicator").toggleClass('hidden');
			});
    });
    
	$("#reloadFeastDays").click(function() {
		$("#FeastDaysFilter").val('');
		$("#loadingIndicator").toggleClass('hidden');
		$.get( "<?php echo $viewModel->get ( 'BaseUrl' ); ?>Ajax/filterfeastdays?feastDaysFilter=", function( data ) {
			$( "#feastdays" ).html( data );
			$("#loadingIndicator").toggleClass('hidden');
			});
		});
	
	$('#confirm-delete').on('show.bs.modal', function(e) {
		$("#deleteConfirmed").click(function() {
			$.get( $(e.relatedTarget).data('href'), function( data ) {
				$('#confirm-delete .modal-header button').remove();
				$('#confirm-delete .modal-title').text('Feiertag gelöscht!');
				$('#confirm-delete .modal-body').html('Der Feiertag wurde erfolgreich gelöscht!');
				$('#confirm-delete .modal-footer').html('');
				$(window).wait(2000).attr("location","<?php echo $viewModel->get ( 'BaseUrl' ); ?>feastdays");
				}).fail(function() {
				    alert( "error" );
				  });
			});
		});
    });
</script>
<?php include 'views/footer.php'; ?>