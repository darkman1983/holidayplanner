<?php

class AjaxController extends BaseController {
  private $levels;
  
  // add to the parent constructor
  public function __construct( $action, $urlValues ) {
    parent::__construct ( $action, $urlValues );
    
    $this->levels = array ("validateuser" => 1,"filterusers" => 2,"deleteuser" => 3 );
    
    if ( ! $this->checkAccess ( $this->levels ) ) {
      $this->model = new ErrorModel ( $this->urlValues );
    } else {
      // create the model object
      $this->model = new AjaxModel ( $this->urlValues );
    }
  }
  
  // default method
  protected function validateUser( ) {
    if ( ! $this->checkAccess ( $this->levels ) ) {
      $this->view->output ( $this->model->badsession ( array("ajax" => true) ), 'Error/notallowed' );
      return;
    }
    
    $this->view->output ( $this->model->validateUser ( ), '' );
  }

  protected function filterUsers( ) {
    if ( ! $this->checkAccess ( $this->levels ) ) {
      $this->view->output ( $this->model->badsession ( array("ajax" => true) ), 'Error/notallowed' );
      return;
    }
    
    $this->view->output ( $this->model->filterUsers ( ), 'Ajax/filterusers' );
  }

  protected function deleteUser( ) {
    if ( ! $this->checkAccess ( $this->levels ) ) {
      $this->view->output ( $this->model->badsession ( array("ajax" => true) ), 'Error/notallowed' );
      return;
    }

    $this->view->output ( $this->model->deleteUser ( ), 'Ajax/deleteuser' );
  }
}

?>
