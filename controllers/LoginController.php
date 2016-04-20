<?php

/**
 * @author tstepputtis
 *
 */
class LoginController extends BaseController {
  // add to the parent constructor
  public function __construct( $action, $urlValues ) {
    parent::__construct ( $action, $urlValues );
    
    // create the model object
    $this->model = new LoginModel ( $this->urlValues );
  }
  
  // default method
  protected function index( ) {
    $this->view->output ( $this->model->index ( ), '' );
  }

  protected function login( ) {
    $this->view->output ( $this->model->login ( ), '' );
  }

  protected function logout( ) {
    $this->view->output ( $this->model->logout ( ), 'Login/logout' );
  }
}

?>
