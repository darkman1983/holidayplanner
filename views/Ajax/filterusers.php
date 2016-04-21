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
    <?php foreach($viewModel->get ( 'filteredUsers' ) as &$data) { ?>
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