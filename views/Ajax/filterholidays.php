<table class="table table-striped">
    <thead>
      <tr>
        <th>#</th>
        <th>Einreichdatum</th>
        <th>Startdatum</th>
        <th>Enddatum</th>
        <th>Tage</th>
        <th>Anmerkung</th>
        <th>Rückmeldung</th>
        <th>Typ</th>
        <th>Status</th>
        <th class="center-text">Aktionen</th>
      </tr>
    </thead>
    <tbody>
    <?php
    $userHolidayData = $viewModel->get ( 'filteredHolidays' );
    if(!empty($userHolidayData))
    {
      $maxNum = strlen(max($userHolidayData)['id']);
      foreach($userHolidayData as &$data) {
    ?>
      <tr>
        <td class="vertical-center">
          <span><?php echo str_pad($data['id'], $maxNum, 0, STR_PAD_LEFT); ?></span>
        </td>
        <td class="vertical-center">
          <span><?php echo date("d.m.Y", $data['submitdate']); ?></span>
        </td>
        <td class="vertical-center">
          <span><?php echo date("d.m.Y", $data['startdate']); ?></span>
        </td>
        <td class="vertical-center">
          <span><?php echo date("d.m.Y", $data['enddate']); ?></span>
        </td>
        <td class="vertical-center">
          <span><?php echo $data['days']; ?></span>
        </td>
        <td class="col-xs-2 vertical-center">
          <span><?php echo $data['note']; ?></span>
        </td>
        <td class="col-xs-2 vertical-center">
          <span><?php echo $data['response_note']; ?></span>
        </td>
        <td class="vertical-center">
          <span><?php
          switch($data['type']) {
            case 'H':
              $txt = "Urlaub";
              break;
            case 'I':
              $txt = "Krankheit";
              break;
          }
          
          echo $txt;
          ?></span>
        </td>
        <td class="vertical-center">
          <span><?php 
          switch(($data['type'] == 'I') ? 3 : $data['status'])
          {
            case 0:
              $txt = "Unbearbeitet";
              break;
            case 1:
              $txt = "Nicht genehmigt";
              break;
            case 2:
              $txt = "Genehmigt";
              break;
            case 3:
              $txt = "Eingetragen";
              break;
          }
          
          echo $txt;
          ?></span>
        </td>
        <td class="vertical-center center-text a-spacing-4">
        <?php if($data['status'] == 0 && $data['type'] != 'I') { ?>
        <a href="#" class="glyphicon glyphicon-remove nounderline link-color-black link-color-lightgrey glyphicon-medium" title="Löschen" data-href="<?php echo $viewModel->get ( 'BaseUrl' ); ?>Ajax/deleteholiday?holidayFilter=&holidayDeleteID=<?php echo $data['id']; ?>" data-toggle="modal" data-target="#confirm-delete" aria-hidden="true"></a>
        <!-- <a href="<?php echo $viewModel->get ( 'BaseUrl' ); ?>holiday/edit?holidayEditID=<?php echo $data['id']; ?>" class="glyphicon glyphicon-edit nounderline link-color-black link-color-lightgrey glyphicon-medium" title="Bearbeiten" aria-hidden="true"></a>  -->
        <?php } else { ?>
        <a href="#" class="glyphicon glyphicon-remove glyphicon-medium nounderline link-disabled"></a>
        <?php } ?>
        <?php if($data['type'] != 'I') { ?>
        <a href="#" class="fa fa-file-pdf-o nounderline link-color-black link-color-lightgrey glyphicon-medium" title="Als PDF anzeigen" data-href="<?php echo $viewModel->get ( 'BaseUrl' ); ?>pdf/showPdf?pdfID=<?php echo $data['id']; ?>" data-toggle="modal" data-target="#viewPdf" aria-hidden="true"></a>
        <?php } else {?>
        <a href="#" class="fa fa-file-pdf-o glyphicon-medium nounderline link-disabled"></a>
        <?php } ?>
        </td>
      </tr>
      <?php
      }
    }
        ?>
    </tbody>
  </table>