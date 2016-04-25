<?php

class AjaxController extends BaseController {
  private $levels;
  private $db = NULL;
  
  // add to the parent constructor
  public function __construct( $action, $urlValues ) {
    parent::__construct ( $action, $urlValues );
    
    $this->levels = array ("validateuser" => 1, "filterusers" => 2,"deleteuser" => 3,"filterfeastdays" => 3 );
    
    $this->db = Database::getInstance()->getCon();
    
    if ( !$this->action == 'checkloginstatus' && ! $this->checkAccess ( $this->levels ) ) {
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
  
  protected function checkLoginStatus( ) {
    /*if ( ! $this->checkAccess ( $this->levels ) ) {
      $this->view->output ( $this->model->badsession ( array("ajax" => true) ), 'Error/notallowed' );
      return;
    }*/
  
    $this->view->output ( $this->model->checkLoginStatus ( ), '' );
  }

  protected function filterUsers( ) {
    if ( ! $this->checkAccess ( $this->levels ) ) {
      $this->view->output ( $this->model->badsession ( array("ajax" => true) ), 'Error/notallowed' );
      return;
    }
    
    $this->view->output ( $this->model->filterUsers ( ), 'Ajax/filterusers' );
  }
  
  protected function filterFeastDays( ) {
    if ( ! $this->checkAccess ( $this->levels ) ) {
      $this->view->output ( $this->model->badsession ( array("ajax" => true) ), 'Error/notallowed' );
      return;
    }
  
    $this->view->output ( $this->model->filterFeastDays ( ), 'Ajax/filterfeastdays' );
  }

  protected function deleteUser( ) {
    if ( ! $this->checkAccess ( $this->levels ) ) {
      $this->view->output ( $this->model->badsession ( array("ajax" => true) ), 'Error/notallowed' );
      return;
    }
    
    $deleteUserSql = sprintf ( "DELETE FROM users WHERE id = '%s'", $this->urlValues ['userDeleteID'] );
    $result = $this->db->query ( $deleteUserSql );

    $this->view->output ( $this->model->deleteUser ( ), 'Ajax/deleteuser' );
  }
  
  protected function deleteFeastDays( ) {
    if ( ! $this->checkAccess ( $this->levels ) ) {
      $this->view->output ( $this->model->badsession ( array("ajax" => true) ), 'Error/notallowed' );
      return;
    }
    
    $deleteUserSql = sprintf ( "DELETE FROM holiday_custom WHERE id = '%s'", $this->urlValues ['feastDaysDeleteID'] );
    $result = $this->db->query ( $deleteUserSql );
  
    $this->view->output ( $this->model->deleteFeastDays ( ), 'Ajax/deletefeastdays' );
  }
}

?>
