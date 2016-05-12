<table class="table table-striped ">
    <thead>
      <tr>
        <th>#</th>
        <th>Vorname</th>
        <th>Nachname</th>
        <th>Email</th>
        <th>Benutzername</th>
        <th>Berechtigungsstufe</th>
        <th class="text-center">Aktion</th>
      </tr>
    </thead>
    <tbody>
    <?php 
    $userData = $viewModel->get ( 'filteredUsers' );
    if(!empty($userData))
    {
      $maxNum = strlen(max($userData)['id']);
      foreach($viewModel->get ( 'filteredUsers' ) as &$data) {
    ?>
      <tr>
        <td class="vertical-center">
          <span><?php echo $data['staffid']; ?></span>
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
        <td class="vertical-center center-text a-spacing-4">
        <?php 
        if($userID != $data['id'] && strtotime("+10 minutes", $data['createdate']) > time())
        {
        ?>
        <a href="#" class="glyphicon glyphicon-remove nounderline link-color-black link-color-lightgrey glyphicon-medium" title="Löschen" data-href="<?php echo $viewModel->get ( 'BaseUrl' ); ?>Ajax/deleteuser?usersFilter=&userDeleteID=<?php echo $data['id']; ?>" data-toggle="modal" data-target="#confirm-delete" aria-hidden="true"></a>
        <?php } else { ?>
        <a href="#" class="glyphicon glyphicon-remove glyphicon-medium nounderline link-disabled"></a>
        <?php } ?>
        <a href="<?php echo $viewModel->get ( 'BaseUrl' ); ?>user/edit?userEditID=<?php echo $data['id']; ?>" class="glyphicon glyphicon-edit nounderline link-color-black link-color-lightgrey glyphicon-medium" title="Bearbeiten" aria-hidden="true"></a>
        </td>
      </tr>
      <?php
      }
    }
        ?>
    </tbody>
  </table>