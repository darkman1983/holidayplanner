<?php

//Define variable for making sure all scripts loaded from index
define("IN_HOLIDAYMANAGER", true);

include_once 'Classloader.php';
spl_autoload_register(array('Classloader', 'load'));

$loader = new Loader(); 								//create the loader object
$controller = $loader->createController(); 				//creates the requested controller object based on the 'controller' URL value
$controller->executeAction(); 							//execute the requested controller's requested method based on the 'action' URL value. Controller methods output a View.
?>