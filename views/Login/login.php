<?php
switch ( $viewModel->get ( 'status' ) ) {
  case 0 :
    echo json_encode ( array ('status' => 0,'text' => 'Leider gab es Probleme beim Login.<br>Benutzername und Passwort richtig?' ) );
    break;
  case 1 :
    echo json_encode ( array ('status' => 1,'text' => 'Sie wurden erfolgreich eingeloggt!' ) );
    break;
}
?>