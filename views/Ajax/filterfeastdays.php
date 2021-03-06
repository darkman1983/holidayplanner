<table class="table table-striped ">
    <thead>
      <tr>
        <th>#</th>
        <th>Datum</th>
        <th>Beschreibung</th>
        <th>Angelegt von</th>
        <th>Löschen - Editieren</th>
      </tr>
    </thead>
    <tbody>
    <?php 
    $userData = $viewModel->get ( 'filteredFeastDays' );
    if(!empty($userData))
    {
      $maxNum = strlen(max($userData)['id']);
      foreach($userData as &$data) {
    ?>
      <tr>
        <td class="col-xs-1 vertical-center">
          <span><?php echo str_pad($data['id'], $maxNum, 0, STR_PAD_LEFT); ?></span>
        </td>
        <td class="col-xs-2 vertical-center">
          <span><?php echo date("d.m.Y", $data['date']); ?></span>
        </td>
        <td class="col-xs-5 vertical-center">
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