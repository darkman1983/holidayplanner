<?php

/**
 * The session class for setting / getting / destoying session data and the session it self
 * 
 * @author Timo Stepputtis
 *
 */
class Session {

  /**
   * @var resource
   */
  private static $instance;

  /**
   * @var bool
   */
  private $_sessionStarted = false;

  /**
   * @var resource
   */
  private $sessionHandler = NULL;

  /**
   * Get an instance of the current class
   *
   * @return Session
   */
  public static function getInstance( ) {
    if ( self::$instance == null ) {
      self::$instance = new Session ( );
    }
    
    return self::$instance;
  }

  /**
   * Initialize the class, Database connection, session handler and start the session
   */
  public function __construct( ) {
    $this->sessionHandler = new MySqlSessionHandler ( );
    // add db data
    // $this->sessionHandler->setDbDetails ( 'localhost', 'hmAdmin', '987zxy321', ' ' );
    // OR alternatively send a MySQLi ressource
    $this->sessionHandler->setDbConnection ( Database::getInstance ( )->getCon ( ) );
    
    $this->sessionHandler->setDbTable ( 'sessions' );
    
    session_set_save_handler ( array ($this->sessionHandler,'open' ), array ($this->sessionHandler,'close' ), array ($this->sessionHandler,'read' ), array ($this->sessionHandler,'write' ), array ($this->sessionHandler,'destroy' ), array ($this->sessionHandler,'gc' ) );
    // The following prevents unexpected effects when using objects as save handlers.
    register_shutdown_function ( 'session_write_close' );
    
    if ( $this->_sessionStarted == false ) {
      session_start ( );
      $this->_sessionStarted = true;
    }
  }

  /**
   * Set a session key / value pair
   *
   * @param string $key          
   * @param string $value          
   */
  public function set( $key, $value ) {
    $_SESSION [$key] = $value;
  }

  /**
   * Get a value of the session from key
   *
   * @param string $key          
   * @param string $secondkey          
   * @return string|boolean
   */
  public function get( $key, $secondkey = '' ) {
    if ( ! empty ( $secondkey ) ) {
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

  /**
   * Display the session content
   *
   * @return session
   */
  public function display( ) {
    return $_SESSION;
  }

  /**
   * Destroy the current session
   */
  public function destroy( ) {
    if ( $this->_sessionStarted == true ) {
      session_unset ( );
      session_destroy ( );
    }
  }
}

?>