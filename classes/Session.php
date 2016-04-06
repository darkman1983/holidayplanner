<?php

class Session {
	private static $instance;
	private $_sessionStarted = false;
	
	public static function getInstance() {
		if (self::$instance == null) {
			self::$instance = new Session();
		}
		
		return self::$instance;
	}

	public function __construct() {
		if ($this->_sessionStarted == false) {
			session_start ();
			$this->_sessionStarted = true;
		}
	}

	public function set($key, $value) {
		$_SESSION [$key] = $value;
	}

	public function get($key, $secondkey = false) {
		if ($secondkey == true) {
			if (isset ( $_SESSION [$key] [$secondkey] )) {
				return $_SESSION [$key] [$secondkey];
			}
		} else {
			if (isset ( $_SESSION [$key] )) {
				return $_SESSION [$key];
			}
		}
		return false;
	}

	public function display() {
		return $_SESSION;
	}

	public function destroy() {
		if ($this->_sessionStarted == true) {
			session_unset ();
			session_destroy ();
		}
	}
}

?>