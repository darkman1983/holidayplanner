<?php
switch ($viewModel->get('dbError')) {
  case 1062:
    echo json_encode(array('status' => 1062, 'text' => 'Dieser Urlaubs- / Feiertag kann nicht angelegt werden, da an diesem Datum schon ein anderer Eintrag existiert!'));
    break;
}

?>