<?php
class Classloader {
	const BASE_DIR = __DIR__;
	const FILE_EXTENSION = '.class.php';
	public static function load($className) {
		$className = str_replace ( '\\', DIRECTORY_SEPARATOR, $className );
		$filePath = Classloader::BASE_DIR . DIRECTORY_SEPARATOR . $className . Classloader::FILE_EXTENSION;
		if (file_exists ( $filePath )) {
			include_once ($filePath);
		}
	}
}

?>