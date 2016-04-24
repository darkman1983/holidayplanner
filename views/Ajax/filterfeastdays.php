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
    $filteredFestDays = $viewModel->get ( 'filteredFeastDays' );
    if(!empty($filteredFestDays))
    {
      foreach($filteredFestDays as &$data) {
    ?>
      <tr>
        <td class="vertical-center">
          <span><?php echo $data['id']; ?></span>
        </td>
        <td class="col-xs-2 vertical-center">
          <span><?php echo date("d.m.y", $data['start']); ?></span>
        </td>
        <td class="col-xs-2 vertical-center">
          <span><?php echo ($data['duration'] > 1) ? date("d.m.y", strtotime(sprintf("+%s days", $data['duration']), $data['start'])) : date("d.m.y", $data['start']); ?></span>
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