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
    $userHolidayData = $viewModel->get ( 'filteredFeastDays' );
    if(!empty($userHolidayData))
    {
      $maxNum = strlen(max($userHolidayData)['id']);
      foreach($userHolidayData as &$data) {
    ?>
      <tr>
        <td class="vertical-center">
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