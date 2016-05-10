<?php

/**
 * The AjaxController has several functions for ajax based data requests
 * @author Timo Stepputtis
 *
 */
class AjaxController extends BaseController {
  /**
   * @var array $levels
   */
  private $levels;
  /**
   * @var resource $db
   */
  private $db = NULL;
  
  
  public function __construct( $action, $urlValues ) {
    parent::__construct ( $action, $urlValues );
    
    $this->levels = array ("validateuser" => 1, "getlogouttime" => 1, "filterusers" => 2,"deleteuser" => 3,"filterfeastdays" => 3, "filterholidays" => 1, "deleteholiday" => 1 );
    
    $this->db = Database::getInstance()->getCon();
    
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
  
  protected function getLogoutTime()
  {
    $this->view->output ( $this->model->getLogoutTime ( ), '' );
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
  
  protected function filterHolidays( ) {
    if ( ! $this->checkAccess ( $this->levels ) ) {
      $this->view->output ( $this->model->badsession ( array("ajax" => true) ), 'Error/notallowed' );
      return;
    }
  
    $this->view->output ( $this->model->filterHolidays ( ), 'Ajax/filterholidays' );
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
    
    $deleteFeastDaysSql = sprintf ( "DELETE FROM feastdays WHERE id = '%s'", $this->urlValues ['feastDaysDeleteID'] );
    $result = $this->db->query ( $deleteFeastDaysSql );
  
    $this->view->output ( $this->model->deleteFeastDays ( ), 'Ajax/deletefeastdays' );
  }
  
  protected function deleteHoliday() {
    if ( ! $this->checkAccess ( $this->levels ) ) {
      $this->view->output ( $this->model->badsession ( array("ajax" => true) ), 'Error/notallowed' );
      return;
    }
    
    $deleteHolidaySql = sprintf ( "DELETE FROM holiday WHERE id = '%s' AND employeeID = '%s'", $this->urlValues ['holidayDeleteID'], $this->session->get('id') );
    print $deleteHolidaySql;
    $result = $this->db->query ( $deleteHolidaySql );
    
    $this->view->output ( $this->model->deleteHoliday ( ), 'Ajax/deleteholiday' );
  }
}

?>
