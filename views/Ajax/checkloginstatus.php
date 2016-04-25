<?php
$loggedIN = $viewModel->get('loggedIN');
echo json_encode(array("loggedIN" => (isset($loggedIN) && $loggedIN === true) ? true : false));
?>