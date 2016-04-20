<?php include 'views/header.php'; ?>
<?php include 'views/navbar.php'; ?>
    <div class="container">
    <div class="">
    <br>
    <div class="modal-content">
    <div class="modal-header">
    <h2>Benutzer Verwaltung</h2>
    <div class="navbar-header navbar-right table-navbar">
		<form name="filter" role="filter">
			<div class="form-group">
				<input type="text" class="form-control" placeholder="Filter">
			</div>
		</form>
	</div>
	<a href="#" class="glyphicon glyphicon-refresh nounderline navbar-right padding-right-5 link-color-black link-color-lightgrey" title="Benutzertabelle neu Laden"></a>
	<a href="<?php echo $viewModel->get ( 'BaseUrl' )?>user/create" class="glyphicon glyphicon-plus nounderline navbar-right link-color-black link-color-lightgrey" title="Benutzer Hinzufügen"></a>
	</div>
	<div class="modal-body">
  <div class="table-responsive">
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
        <td class="vertical-center"><a href="<?php echo $viewModel->get ( 'BaseUrl' ); ?>user/delete/<?php echo $data['id']; ?>" class="glyphicon glyphicon-remove nounderline  link-color-black link-color-lightgrey" aria-hidden="true"></a></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
  </div>
</div>
</div>
</div>
</div>
<script>
$(document).ready(function(){
	/*$("#usernameGroup").hide();
	$("#lastname").keyup(function() {
        var firstname = $("#firstname");
        var lastname = $("#lastname");
        var username = firstname.val().toLowerCase().charAt(0) + lastname.val().toLowerCase();

        $("#username").val(username);
        $("#loginForm").validator('validate');
        $("#usernameGroup").show();
    });*/
});
</script>
<?php include 'views/footer.php'; ?>