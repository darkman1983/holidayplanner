<?php

/**
 * The Login Controller handles all login related requests
 * 
 * @author Timo Stepputtis
 *
 */
class LoginController extends BaseController {
  // add to the parent constructor
  public function __construct( $action, $urlValues ) {
    parent::__construct ( $action, $urlValues );
    
    // create the model object
    $this->model = new LoginModel ( $this->urlValues );
  }
  

  /**
   * Sets the index view output
   */
  protected function index( ) {
    $this->view->output ( $this->model->index ( ), '' );
  }

  /**
   * Sets the login view output
   */
  protected function login( ) {
    $this->view->output ( $this->model->login ( ), '' );
  }

  /**
   * Sets the logout view output
   */
  protected function logout( ) {
    $this->view->output ( $this->model->logout ( ), 'Login/logout' );
  }
}

?>
