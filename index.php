<?php

include_once 'Classloader.php';
spl_autoload_register(array('Classloader', 'load'));

var_dump($_POST);
print "<br>";
var_dump($_GET);

$loader = new Loader(); 								//create the loader object
$session = $loader->createSession(); 					//Initialize the Session
$controller = $loader->createController(); 				//creates the requested controller object based on the 'controller' URL value
$controller->executeAction(); 							//execute the requested controller's requested method based on the 'action' URL value. Controller methods output a View.
?>