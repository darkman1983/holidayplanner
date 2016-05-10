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
    
    $getHolidaySql = sprintf ( "SELECT h.*, (SELECT COALESCE(SUM(`getNumDays`(ho.startdate, ho.enddate, 3)), 0) FROM holiday ho WHERE ho.employeeID = h.employeeID AND ho.type = 'H' AND FROM_UNIXTIME(ho.startdate, '%%Y') = FROM_UNIXTIME(%s, '%%Y') AND status = 2) - (SELECT COALESCE(SUM(`getNumDays`(ho.startdate, ho.enddate, 3)), 0) FROM holiday ho WHERE ho.employeeID = h.employeeID AND ho.type = 'I' AND FROM_UNIXTIME(ho.startdate, '%%Y') = FROM_UNIXTIME(%s, '%%Y')) AS remainingHoliday, (SELECT getNumDays(h.startdate, h.enddate, 3)) AS days FROM holiday h WHERE h.employeeID = '%s' LIMIT %s OFFSET %s", time(), time(), $this->session->get('id'), $pagination['limit'], $pagination['offset'] );
    $result = $this->db->query ( $getHolidaySql );
    $resultsets = $result->fetch_all ( MYSQLI_ASSOC );
    
    $this->viewModel->set ( "userHolidayData", $resultsets );
    
    $getMaxHolidaySql = sprintf ( "SELECT maxHoliday FROM mhy WHERE year = FROM_UNIXTIME(%s, '%%Y') AND employeeID = '%s'", time(), $this->session->get('id') );
    $result = $this->db->query ( $getMaxHolidaySql );
    $resultsets = $result->fetch_all ( MYSQLI_ASSOC );
    
    $this->viewModel->set ( "maxHoliday", @$resultsets[0]['maxHoliday'] );
    
    return $this->viewModel;
  }

  public function propose( ) {
    return $this->viewModel;
  }

  public function databaseError( $dbError ) {
    $this->viewModel->set ( "dbError", $dbError );
    
    return $this->viewModel;
  }

  public function success( ) {
    return $this->viewModel;
  }
}

?>
