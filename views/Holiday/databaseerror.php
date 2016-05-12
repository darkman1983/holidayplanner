<?php
$extra = $viewModel->get('extra');

switch ($viewModel->get('dbError')) {
  case 1062:
    echo json_encode(array('status' => 1062, 'text' => 'Dieser Urlaubsantrag kann nicht angelegt werden, da in diesem Zeitraum schon ein anderer Antrag existiert!'));
    break;
  case '4e4f4e45':
    echo json_encode(array('status' => '4e4f4e45', 'text' => 'Sie haben zu wenig Urlaub!<br>Aktuell haben sie noch '.$extra[0].' Tage<br>Beantragt wurden aber '.$extra[1].' Tage'));
    break;
  default:
    break;
}

?>