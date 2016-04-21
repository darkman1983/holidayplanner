<table class="table table-striped ">
    <thead>
      <tr>
        <th>#</th>
        <th>Vorname</th>
        <th>Nachname</th>
        <th>Email</th>
        <th>Benutzername</th>
        <th>Berechtigungsstufe</th>
        <th>Löschen - Editieren</th>
      </tr>
    </thead>
    <tbody>
    <?php 
    foreach($viewModel->get ( 'filteredUsers' ) as &$data) {
    ?>
      <tr>
        <td class="vertical-center">
          <span><?php echo $data['id']; ?></span>
        </td>
        <td class="col-xs-2 vertical-center">
          <span><?php echo $data['firstname']; ?></span>
        </td>
        <td class="col-xs-2 vertical-center">
          <span><?php echo $data['lastname']; ?></span>
        </td>
        <td class="col-xs-2 vertical-center">
          <span><?php echo $data['email']; ?></span>
        </td>
        <td class="col-xs-2 vertical-center">
          <span><?php echo $data['username']; ?></span>
        </td>
        
        <td class="col-xs-2 vertical-center">
        <?php 
        $userID = $viewModel->get ( 'userID' );
        $levels = array(1 => "Normal", 2 => "Anträge Freigeben", 3 => "Administrator");
        ?>
        <?php 
          printf( "%s - %s", $data['level'], $levels[$data['level']]);
        ?>
        </td>
        <td class="vertical-center center-text">
        <?php 
        if($userID != $data['id'])
        {
        ?>
        <a href="#" class="glyphicon glyphicon-remove nounderline link-color-black link-color-lightgrey glyphicon-medium" data-href="<?php echo $viewModel->get ( 'BaseUrl' ); ?>Ajax/deleteuser?usersFilter=&userID=<?php echo $data['id']; ?>" data-toggle="modal" data-target="#confirm-delete" aria-hidden="true"></a>
        <a href="<?php echo $viewModel->get ( 'BaseUrl' ); ?>user/edit?userEditID=<?php echo $data['id']; ?>" class="glyphicon glyphicon-edit nounderline link-color-black link-color-lightgrey glyphicon-medium" aria-hidden="true"></a>
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