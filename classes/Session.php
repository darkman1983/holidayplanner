<?php

class Session {

  private static $instance;

  private $_sessionStarted = false;

  private $sessionHandler = NULL;

  public static function getInstance( ) {
    if ( self::$instance == null ) {
      self::$instance = new Session ( );
    }
    
    return self::$instance;
  }

  public function __construct( ) {
    $this->sessionHandler = new MySqlSessionHandler ( );
    // add db data
    //$this->sessionHandler->setDbDetails ( 'localhost', 'hmAdmin', '987zxy321', 'holiday_management' );
    // OR alternatively send a MySQLi ressource
    $this->sessionHandler->setDbConnection(Database::getInstance()->getCon());
    
    $this->sessionHandler->setDbTable ( 'sessions' );
    
    session_set_save_handler(array($this->sessionHandler, 'open'),
        array($this->sessionHandler, 'close'),
        array($this->sessionHandler, 'read'),
        array($this->sessionHandler, 'write'),
        array($this->sessionHandler, 'destroy'),
        array($this->sessionHandler, 'gc'));
    // The following prevents unexpected effects when using objects as save handlers.
    register_shutdown_function('session_write_close');
    
    if ( $this->_sessionStarted == false ) {
      session_start ( );
      $this->_sessionStarted = true;
    }
  }

  public function set( $key, $value ) {
    $_SESSION [$key] = $value;
  }

  public function get( $key, $secondkey = false ) {
    if ( $secondkey == true ) {
      if ( isset ( $_SESSION [$key] [$secondkey] ) ) {
        return $_SESSION [$key] [$secondkey];
      }
    } else {
      if ( isset ( $_SESSION [$key] ) ) {
        return $_SESSION [$key];
      }
    }
    return false;
  }

  public function display( ) {
    return $_SESSION;
  }

  public function destroy( ) {
    if ( $this->_sessionStarted == true ) {
      session_unset ( );
      session_destroy ( );
    }
  }
}

?>