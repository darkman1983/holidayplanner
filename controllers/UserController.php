<?php

/**
 * @author tstepputtis
 *
 */
class UserController extends BaseController {
  // add to the parent constructor
  public function __construct( $action, $urlValues ) {
    parent::__construct ( $action, $urlValues );
    
    // create the model object
    if ( $this->session->get ( 'level' ) != 3 ) {
      $this->model = new ErrorModel ( );
    } else {
      $this->model = new UserModel ( );
    }
  }
  
  // default method
  protected function index( ) {
    if ( $this->session->get ( 'level' ) != 3 ) {
      $this->view->output ( $this->model->notAllowed ( ), 'Error/notallowed' );
    } else {
      $this->view->output ( $this->model->index ( ), '' );
    }
  }

  protected function create( ) {
    $this->view->output ( $this->model->create ( ), '' );
  }
}

?>
