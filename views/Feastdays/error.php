<?php
switch ( $viewModel->get ( 'status' ) ) {
  case 'NOTHINGINSERTED' :
    echo json_encode ( array ('status' => 'NOTHINGINSERTED','text' => 'Es konnte kein neuer Eintrag erstellt werden.' ) );
    break;
  case 'DUPLICATE' :
    echo json_encode ( array ('status' => 'DUPLICATE','text' => 'Dieser Urlaubs- / Feiertag kann nicht angelegt werden, da in diesem Zeitraum schon ein anderer Antrag existiert!' ) );
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