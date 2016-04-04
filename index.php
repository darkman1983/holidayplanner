<?php

include 'includes/Classloader.php';
spl_autoload_register(array('Classloader', 'load'));

$tpl = new Template();

?>