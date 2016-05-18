<?php

/**
 * The Loader class will try to initialize the requested controller class or throw an error
 * 
 * @author Timo Stepputtis
 *
 */
class Loader {

  /**
   * The name of a controller
   *
   * @var string $controllerName
   */
  private $controllerName;

  /**
   * The name of a class
   *
   * @var string $controllerClass
   */
  private $controllerClass;

  /**
   * The action that was requested
   *
   * @var string $action
   */
  private $action;

  /**
   * The request array
   *
   * @var array $request
   */
  private $request;

  /**
   * The session object
   *
   * @var object $session
   */
  private $session;

  /**
   * Store the URL request values on object creation and initialize the session
   */
  public function __construct( ) {
    $this->request = array_merge ( $_GET, $_POST );
    Database::getInstance ( )->recursiveEscape ( $this->request );
    
    $db = Database::getInstance ( )->getCon ( );
    
    if ( $this->request ['controller'] == "" ) {
      $this->controllerName = "IndexController";
      $this->controllerClass = $this->controllerName;
    } else {
      $this->controllerName = ucfirst ( strtolower ( $this->request ['controller'] ) ) . 'Controller';
      $this->controllerClass = $this->controllerName;
    }
    
    if ( $this->request ['action'] == "" ) {
      $this->action = "index";
    } else {
      $this->action = $this->request ['action'];
    }
    
    $this->session = Session::getInstance ( );
  }

  /**
   * Factory method which establishes the requested controller as an object
   *
   * @return ErrorController|object <p>Returns either an class object of the requested controller or an ErrorController object</p>
   */
  public function createController( ) {
    // check our requested controller's class file exists and require it if so
    if ( ! file_exists ( "controllers/" . $this->controllerName . ".php" ) ) {
      return new ErrorController ( "badurl", $this->request );
    }
    
    // does the class exist?
    if ( class_exists ( $this->controllerClass ) ) {
      $parents = class_parents ( $this->controllerClass );
      
      // does the class inherit from the BaseController class?
      if ( in_array ( "BaseController", $parents ) ) {
        // does the requested class contain the requested action as a method?
        if ( method_exists ( $this->controllerClass, $this->action ) ) {
          return new $this->controllerClass ( $this->action, $this->request );
        } else {
          // bad action/method error
          return new ErrorController ( "badurl", $this->request );
        }
      } else {
        // bad controller error
        return new ErrorController ( "badurl", $this->request );
      }
    } else {
      // bad controller error
      return new ErrorController ( "badurl", $this->request );
    }
  }
}

?>