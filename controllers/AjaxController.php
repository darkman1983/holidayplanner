<?php

class AjaxController extends BaseController {
  // add to the parent constructor
  public function __construct( $action, $urlValues ) {
    parent::__construct ( $action, $urlValues );
    
    if ( ! $this->checkAccess ( ) ) {
      $this->model = new ErrorModel ( $this->urlValues );
    } else {
      // create the model object
      $this->model = new AjaxModel ( $this->urlValues );
    }
  }

  private function checkAccess( ) {
    $levels = array ("validateuser" => 1,"filterusers" => 2,"deleteuser" => 3 );
    
    if ( ! $this->session->get ( 'loggedIN' ) ) {
      return false;
    }
    
    if ( $this->session->get ( 'level' ) < $levels [$this->action] ) {
      return false;
    }
    
    return true;
  }
  
  // default method
  protected function validateUser( ) {
    if ( ! $this->checkAccess ( ) ) {
      $this->view->output ( $this->model->badsession ( array("ajax" => true) ), 'Error/notallowed' );
      return;
    }
    
    $this->view->output ( $this->model->validateUser ( ), '' );
  }

  protected function filterUsers( ) {
    if ( ! $this->checkAccess ( ) ) {
      $this->view->output ( $this->model->badsession ( array("ajax" => true) ), 'Error/notallowed' );
      return;
    }
    
    $this->view->output ( $this->model->filterUsers ( $this->urlValues ), 'Ajax/filterusers' );
  }

  protected function deleteUser( ) {
    if ( ! $this->checkAccess ( ) ) {
      $this->view->output ( $this->model->badsession ( array("ajax" => true) ), 'Error/notallowed' );
      return;
    }
    $this->view->output ( $this->model->deleteUser ( $this->urlValues ), 'Ajax/deleteuser' );
  }
}

?>
