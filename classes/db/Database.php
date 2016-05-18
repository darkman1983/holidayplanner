<?php

class Database {

  private static $instance;

  private $conf = NULL;

  private $con = NULL;

  /**
   * Get an instance of the Database class
   *
   * @return Database
   */
  public static function getInstance( ) {
    if ( self::$instance == null ) {
      self::$instance = new Database ( );
    }
    
    return self::$instance;
  }

  /**
   * Get the database configuration and save it to private variable, than unset the configuration array and initialise the database connection
   */
  public function __construct( ) {
    require_once ('conf/dbConfig.php');
    
    $this->conf = $config;
    
    unset ( $config );
    
    $this->_init ( );
  }

  /**
   * Establish the database connection and save it to private connection variable
   */
  private function _init( ) {
    $this->con = new mysqli ( $this->conf ['DB_SERVER'], $this->conf ['DB_USER'], $this->conf ['DB_PASSWORD'], $this->conf ['DB_DATABASE'] );
    $this->con->set_charset ( "utf-8" );
  }

  /**
   * Return the actual database connection
   *
   * @return resource
   */
  public function getCon( ) {
    return $this->con;
  }

  /**
   * Recursively escapes all values in an Array
   * 
   * @param Array &$data
   */
  public function recursiveEscape( &$data ) {
    foreach ( $data as &$current ) {
      if ( is_array ( $current ) ) {
        self::recursiveEscape ( $current );
      } else {
        $current = $this->con->escape_string ( $current );
      }
    }
  }
}

?>