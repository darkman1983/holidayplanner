<?php include 'views/header.php'; ?>
<?php include 'views/navbar.php'; ?>
    <div class="container">
    <div class="modal-content">
    <div class="modal-header">
    <h2><?php if($viewModel->get('level') == 1){ ?>Urlaubs- & Feiertage<?php }else{ ?>Urlaubs- & Feiertagsverwaltung<?php } ?></h2>
    <div id="loadingIndicator" class="navbar-header navbar-left hidden">
      <i class="fa fa-cog fa-spin fa-1x margin-bottom link-color-black" aria-hidden="true" title="Lade Inhalte..."></i>
    </div>
    <div class="navbar-header navbar-right table-navbar">
			<div class="form-group">
				<input type="text" class="form-control" id="feastDaysFilter" name="feastDaysFilter" placeholder="Filter">
			</div>
	</div>
	<a href="#" class="glyphicon glyphicon-refresh nounderline navbar-right padding-right-5 link-color-black link-color-lightgrey" id="reloadFeastDays" title="Benutzertabelle neu Laden"></a>
	<?php if($viewModel->get('level') > 1){ ?><a href="<?php echo $viewModel->get ( 'BaseUrl' )?>feastdays/create" class="glyphicon glyphicon-plus nounderline navbar-right link-color-black link-color-lightgrey" title="Benutzer Hinzufügen"></a><?php } ?>
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
        <?php if($viewModel->get('level') > 1){ ?>
        <th>Angelegt von</th>
        <th class="center-text">Aktion</th>
        <?php } ?>
        <th></th>
      </tr>
    </thead>
    <tbody>
    <?php 
    $userHolidayData = $viewModel->get ( 'feastDaysData' );
    if(!empty($userHolidayData))
    {
      $maxNum = strlen(max($userHolidayData)['id']);
      foreach($userHolidayData as &$data) {
    ?>
      <tr>
        <td class="col-xs-1 vertical-center">
          <span><?php echo str_pad($data['id'], $maxNum, 0, STR_PAD_LEFT); ?></span>
        </td>
        <td class="col-xs-2 vertical-center">
          <span><?php echo date("d.m.Y", $data['startdate']); ?></span>
        </td>
        <td class="col-xs-2 vertical-center">
          <span><?php echo date("d.m.Y", $data['enddate']); ?></span>
        </td>
        <td class="col-xs-3 vertical-center">
          <span><?php echo $data['description']; ?></span>
        </td>
        <?php if($viewModel->get('level') > 1){ ?>
        <td class="col-xs-2 vertical-center">
          <span><?php echo $data['username']; ?></span>
        </td>
        <td class="col-xs-2 vertical-center center-text a-spacing-4">
        <a href="#" class="glyphicon glyphicon-remove nounderline link-color-black link-color-lightgrey glyphicon-medium" title="Löschen" data-href="<?php echo $viewModel->get ( 'BaseUrl' ); ?>Ajax/deletefeastdays?feastDaysFilter=&feastDaysDeleteID=<?php echo $data['id']; ?>" data-toggle="modal" data-target="#confirm-delete" aria-hidden="true"></a>
        <a href="<?php echo $viewModel->get ( 'BaseUrl' ); ?>feastdays/edit?feastDaysEditID=<?php echo $data['id']; ?>" title="Bearbeiten" class="glyphicon glyphicon-edit nounderline link-color-black link-color-lightgrey glyphicon-medium" aria-hidden="true"></a>
        </td>
        <?php } else { ?>
        <td class="col-xs-4"></td>
        <?php } ?>
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
      echo ($paginationData['page'] > 1) ? '<a href="'.$viewModel->get ( 'BaseUrl' ).'feastdays?page=1" aria-label="Erste Seite">&laquo;</a> <a href="'.$viewModel->get ( 'BaseUrl' ).'feastdays?page=' . ($paginationData['page'] - 1) . '" aria-label="Zurück">&lsaquo;</a>' : '<span class="disabled" aria-hidden="true">&laquo;</span><span class="disabled" aria-hidden="true">&lsaquo;</span>';
        ?>
      </li>
      <li><span class="modal-pagination-black"><?php echo ' Seite ', $paginationData['page'], ' von ', $paginationData['pages'], ', zeige ', $paginationData['start'], '-', $paginationData['end'], ' von ', $paginationData['total'], ' ergebnissen '; ?></span></li>
      <li>
      <?php 
      echo ($paginationData['page'] < $paginationData['pages']) ? '<a href="'.$viewModel->get ( 'BaseUrl' ).'feastdays?page=' . ($paginationData['page'] + 1) . '" aria-label="Weiter">&rsaquo;</a> <a href="'.$viewModel->get ( 'BaseUrl' ).'feastdays?page=' . $paginationData['pages'] . '" aria-label="Letzte Seite">&raquo;</a>' : '<span class="disabled">&rsaquo;</span><span class="disabled">&raquo;</span>';
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
		var withPage = '';
		
		if($(this).val() != '')
		{
		$(".pagination").hide();
		}else {
			withPage = "&page=" + $.getUrlParam('page');
			$(".pagination").show();
		}
		$("#loadingIndicator").toggleClass('hidden');
		$.get( "<?php echo $viewModel->get ( 'BaseUrl' ); ?>Ajax/filterfeastdays?feastDaysFilter=" + $("#feastDaysFilter").val(), function( data ) {
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
		$.get( "<?php echo $viewModel->get ( 'BaseUrl' ); ?>Ajax/filterfeastdays?feastDaysFilter=&page=" + $.getUrlParam('page'), function( data ) {
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
				$(window).wait(2000).attr("location","<?php echo $viewModel->get ( 'BaseUrl' ); ?>feastdays");
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