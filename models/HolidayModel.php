<?php

/**
 * @author tstepputtis
 *
 */
class HolidayModel extends BaseModel {

  private $db = NULL;

  public function __construct( ) {
    parent::__construct ( );
    
    $this->db = Database::getInstance ( )->getCon ( );
  }
  
  // data passed to the home index view
  public function index( $urlValues ) {
    $getTotalHolidaySql = sprintf("SELECT COUNT(*) FROM holiday WHERE employeeID = '%s'", $this->session->get('id'));
    $totalResult = $this->db->query ( $getTotalHolidaySql );
    $totalHoliday = $totalResult->fetch_row ( );
    
    $pagination = Utils::generatePagination($urlValues, $totalHoliday[0]);
    
    $this->viewModel->set ( "pagination", $pagination );
    
    $getHolidaySql = sprintf ( "SELECT h.*, DATEDIFF(FROM_UNIXTIME(h.enddate, '%%Y-%%m-%%d'), FROM_UNIXTIME(h.startdate, '%%Y-%%m-%%d'))+1 AS days FROM holiday h WHERE h.employeeID = '%s' LIMIT %s OFFSET %s", $this->session->get('id'), $pagination['limit'], $pagination['offset'] );
    $result = $this->db->query ( $getHolidaySql );
    $resultsets = $result->fetch_all ( MYSQLI_ASSOC );
    
    $this->viewModel->set ( "userHolidayData", $resultsets );
    
    $getUserSql = sprintf ( "SELECT * FROM users WHERE id = '%s'", $this->session->get('id') );
    $result = $this->db->query ( $getUserSql );
    $resultsets = $result->fetch_all ( MYSQLI_ASSOC );
    
    $this->viewModel->set ( "userData", $resultsets );
    
    return $this->viewModel;
  }

  public function propose( ) {
    return $this->viewModel;
  }

  public function badUserCreate( $urlValues, $dbError ) {
    $this->viewModel->set ( "urlValues", $urlValues );
    $this->viewModel->set ( "dbError", $dbError );
    
    return $this->viewModel;
  }

  public function success( ) {
    return $this->viewModel;
  }
}

?>
