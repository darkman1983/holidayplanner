<?php
switch ( $viewModel->get ( 'status' ) ) {
  case 'NOTHINGINSERTED' :
    echo json_encode ( array ('status' => 'NOTHINGINSERTED','text' => 'Es konnte kein neuer Benutzer erstellt werden.' ) );
    break;
  case 'NOTHINGUPDATED' :
    echo json_encode ( array ('status' => 'NOTHINGUPDATED','text' => 'Es wurde nichts aktualisiert.' ) );
    break;
  case 'NOTCOMPLETE' :
    echo json_encode ( array ('status' => 'NOTCOMPLETE','text' => 'Formulardaten sind nicht komplett.' ) );
    break;
  case 'NOACCESSEXPIRED' :
    echo json_encode ( array ('status' => 'NOACCESSEXPIRED','text' => 'Sie haben keinen Zugriff oder Ihre Sitzung ist abgelaufen.' ) );
    break;
}
?>