<?php

class Template {

  protected static $_instance = null;

  private $tplPath = '';

  private $tplName = 'index';

  private $vars = array ();

  public static function getInstance( ) {
    if ( null === self::$_instance ) {
      self::$_instance = new self ( );
    }
    return self::$_instance;
  }

  protected function __clone( ) {
  }

  protected function __construct( ) {
  }

  public function setTempaltePath( $path ) {
    $this->tplPath = $path;
    $this->vars ['tplPath'] = $this->tplPath; 
  }

  public function addVar( $name, $value ) {
    $this->vars [$name] = $value;
  }

  private function getVar( $name ) {
    return $this->vars [$name];
  }

  public function renderTemplate( ) {
    $tplFile = $this->tplPath . DIRECTORY_SEPARATOR . $this->tplName . ".php";
    
    try {
      require_once $tplFile;
    } catch ( Exception $e ) {
      throw new Exception("There has been an Error: $e");
    }
  }
}

?>