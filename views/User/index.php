<?php include 'views/header.php'; ?>
<?php include 'views/navbar.php'; ?>
    <div class="container">
    <div class="">
    <br>
    <div class="modal-content">
    <div class="modal-header">
    <h2>Benutzer Verwaltung</h2>
    <div class="navbar-header navbar-right table-navbar">
			<div class="form-group">
				<input type="text" class="form-control" id="userFilter" name="userFilter" placeholder="Filter">
			</div>
	</div>
	<a href="#" class="glyphicon glyphicon-refresh nounderline navbar-right padding-right-5 link-color-black link-color-lightgrey" id="reloadUsers" title="Benutzertabelle neu Laden"></a>
	<a href="<?php echo $viewModel->get ( 'BaseUrl' )?>user/create" class="glyphicon glyphicon-plus nounderline navbar-right link-color-black link-color-lightgrey" title="Benutzer Hinzufügen"></a>
	</div>
	<div class="modal-body">
  <div class="table-responsive" id="users">
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>#</th>
        <th>Vorname</th>
        <th>Nachname</th>
        <th>Email</th>
        <th>Benutzername</th>
        <th>Berechtigungsstufe</th>
        <th>Löschen?</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach($viewModel->get ( 'userData' ) as &$data) { ?>
      <tr>
        <td class="vertical-center"><input type="hidden" class="form-control" id="id" name="id" value="<?php echo $data['id']; ?>"><?php echo $data['id']; ?></td>
        <td class="col-xs-2 vertical-center"><input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $data['firstname']; ?>"></td>
        <td class="col-xs-2 vertical-center"><input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $data['lastname']; ?>"></td>
        <td class="col-xs-2 vertical-center"><input type="text" class="form-control" id="email" name="email" value="<?php echo $data['email']; ?>"></td>
        <td class="col-xs-2 vertical-center"><input type="text" class="form-control" id="username" name="username" value="<?php echo $data['username']; ?>"></td>
        <td class="col-xs-2 vertical-center">
        <?php 
        $userID = $viewModel->get ( 'userID' );
        $levels = array(1 => "Normal", 2 => "Anträge Freigeben", 3 => "Administrator");
        if ($userID != $data['id'])
        {
        ?>
        <select class="form-control" name="level">
        <?php 
        
        for($i=1; $i <= count($levels); $i++) {
          $option = '<option value="%s"%s>%s - %s</option>';
          if ($data['level'] == $i)
          {
            printf($option, $i, ' selected', $i, $levels[$i]);
          }else {
            printf($option, $i, '', $i, $levels[$i]);
          }
        } 
        ?>
        </select>
        <?php
        } else {
          printf( "%s - %s", $data['level'], $levels[$data['level']]);
        }
        ?></td>
        <td class="vertical-center">
        <?php 
        if($userID != $data['id'])
        {
        ?>
        <a href="#" class="glyphicon glyphicon-remove nounderline link-color-black link-color-lightgrey" data-href="<?php echo $viewModel->get ( 'BaseUrl' ); ?>Ajax/deleteuser?usersFilter=&userID=<?php echo $data['id']; ?>" data-toggle="modal" data-target="#confirm-delete" aria-hidden="true"></a>
        <?php 
        }
        ?>
        </td>
      </tr>
      <?php
}
        ?>
    </tbody>
  </table>
  </div>
</div>
</div>
</div>
</div>
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
<script>
$(document).ready(function(){
	$("#userFilter").keyup(function() {
		$.get( "<?php echo $viewModel->get ( 'BaseUrl' ); ?>Ajax/filterusers?usersFilter=" + $("#userFilter").val(), function( data ) {
			  $( "#users" ).html( data );
			});
    });
	$("#reloadUsers").click(function() {
		$("#userFilter").val('');
		$.get( "<?php echo $viewModel->get ( 'BaseUrl' ); ?>Ajax/filterusers?usersFilter=", function( data ) {
			$( "#users" ).html( data );
			});
		});
	$('#confirm-delete').on('show.bs.modal', function(e) {
		$("#deleteConfirmed").click(function() {
			$.get( $(e.relatedTarget).data('href'), function( data ) {
				$('#confirm-delete').modal('hide');
				$( "#users" ).html( data );
				});
			});
		});
    });
</script>
<?php include 'views/footer.php'; ?>