  <table class="table table-striped ">
    <thead>
      <tr>
        <th>#</th>
        <th>Vorname</th>
        <th>Nachname</th>
        <th>Jahresurlaub</th>
        <th>Noch Verfügbar</th>
        <th>Unbearbeitete Anträge</th>
        <th>Anträge Gesamt</th>
        <th class="center-text">Aktion</th>
      </tr>
    </thead>
    <tbody>
    <?php 
    $userData = $viewModel->get ( 'filteredManagerHolidays' );
    if(!empty($userData)) {
      $maxNum = strlen(max($userData)['id']);
      foreach($userData as &$data) {
    ?>
      <tr>
        <td class="col-xs-1 vertical-center">
          <span><?php echo $data['staffid']; ?></span>
        </td>
        <td class="col-xs-1 vertical-center">
          <span><?php echo $data['firstname']; ?></span>
        </td>
        <td class="col-xs-2 vertical-center">
          <span><?php echo $data['lastname']; ?></span>
        </td>
        <td class="col-xs-1 vertical-center">
          <span><?php echo $data['maxHoliday']; ?></span>
        </td>
        <td class="col-xs-2 vertical-center">
          <span><?php echo ($data ['remainingHoliday'] == $data ['maxHoliday']) ? $data ['maxHoliday'] : ($data ['maxHoliday'] - $data ['remainingHoliday']); ?></span>
        </td>
        <td class="col-xs-2 vertical-center">
          <span><?php echo $data ['notProcessed'] ?></span>
        </td>
        <td class="col-xs-2 vertical-center">
          <span><?php echo $data ['allProposals'] ?></span>
        </td>
        <td class="col-xs-2 vertical-center center-text a-spacing-4">
        <a href="<?php echo $viewModel->get ( 'BaseUrl' ); ?>manager/userdetails?userID=<?php echo $data['id']; ?>" class="glyphicon glyphicon-info-sign nounderline link-color-black link-color-lightgrey glyphicon-medium spacing-4" title="Anträge des Benutzers" aria-hidden="true"></a>
        </td>
      </tr>
      <?php
      }
    }
        ?>
    </tbody>
  </table>