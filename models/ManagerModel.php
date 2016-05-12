<?php

/**
 * @author tstepputtis
 *
 */
class ManagerModel extends BaseModel {

  private $db = NULL;

  public function __construct( ) {
    parent::__construct ( );
    
    $this->db = Database::getInstance ( )->getCon ( );
  }
  
  public function index( $urlValues ) {
    $getTotalUsersSql = "SELECT COUNT(*) FROM users";
    $totalResult = $this->db->query ( $getTotalUsersSql );
    $totalUsers = $totalResult->fetch_row ( );
    
    $pagination = Utils::generatePagination(intval(@$urlValues['page']), $totalUsers[0]);
    
    $this->viewModel->set ( "pagination", $pagination );
    
    $get_users_sql = sprintf ( "SELECT u.*, (SELECT COUNT(*) FROM holiday WHERE employeeID = u.id AND status = 0) as notProcessed, (SELECT COUNT(*) FROM holiday WHERE employeeID = u.id) as allProposals, (SELECT COALESCE(SUM(maxHoliday), 0) FROM mhy WHERE year = YEAR(CURRENT_DATE) AND employeeID = u.id) as maxHoliday, (SELECT COALESCE(SUM(`getNumDays`(ho.startdate, ho.enddate, 3)), (SELECT COALESCE(SUM(maxHoliday), 0) FROM mhy WHERE year = YEAR(CURRENT_DATE) AND employeeID = u.id)) FROM holiday ho WHERE ho.employeeID = u.id AND ho.type = 'H' AND FROM_UNIXTIME(ho.startdate, '%%Y') = YEAR(CURRENT_DATE)) - (SELECT COALESCE(SUM(`getNumDays`(ho.startdate, ho.enddate, 3)), 0) FROM holiday ho WHERE ho.employeeID = u.id AND ho.type = 'I' AND FROM_UNIXTIME(ho.startdate, '%%Y') = YEAR(CURRENT_DATE)) AS remainingHoliday FROM users u LIMIT %s OFFSET %s", $pagination['limit'], $pagination['offset'] );
    $result = $this->db->query ( $get_users_sql );
    $resultsets = $result->fetch_all ( MYSQLI_ASSOC );
    
    $this->viewModel->set ( "userData", $resultsets );
  
    return $this->viewModel;
  }
  
  // data passed to the home index view
  public function userDetails( $urlValues ) {
    $getTotalHolidaySql = sprintf("SELECT COUNT(*) FROM holiday WHERE employeeID = '%s'", $urlValues['userID']);
    $totalResult = $this->db->query ( $getTotalHolidaySql );
    $totalHoliday = $totalResult->fetch_row ( );
    
    $pagination = Utils::generatePagination(intval(@$urlValues['page']), $totalHoliday[0]);
    
    $this->viewModel->set ( "pagination", $pagination );
    
    $getHolidaySql = sprintf ( "SELECT h.*, u.firstname, u.lastname, (SELECT COALESCE(SUM(`getNumDays`(ho.startdate, ho.enddate, 3)), 0) FROM holiday ho WHERE ho.employeeID = h.employeeID AND ho.type = 'H' AND FROM_UNIXTIME(ho.startdate, '%%Y') = FROM_UNIXTIME(%s, '%%Y')) - (SELECT COALESCE(SUM(`getNumDays`(ho.startdate, ho.enddate, 3)), 0) FROM holiday ho WHERE ho.employeeID = h.employeeID AND ho.type = 'I' AND FROM_UNIXTIME(ho.startdate, '%%Y') = FROM_UNIXTIME(%s, '%%Y')) AS remainingHoliday, (SELECT getNumDays(h.startdate, h.enddate, 3)) AS days FROM holiday h JOIN users u ON h.employeeID = u.id WHERE h.employeeID = '%s' LIMIT %s OFFSET %s", time(), time(), $urlValues['userID'], $pagination['limit'], $pagination['offset'] );
    $result = $this->db->query ( $getHolidaySql );
    $resultsets = $result->fetch_all ( MYSQLI_ASSOC );
    
    $this->viewModel->set ( "userHolidayData", $resultsets );
    
    $getMaxHolidaySql = sprintf ( "SELECT maxHoliday FROM mhy WHERE year = FROM_UNIXTIME(%s, '%%Y') AND employeeID = '%s'", time(), $urlValues['userID'] );
    $result = $this->db->query ( $getMaxHolidaySql );
    $resultsets = $result->fetch_all ( MYSQLI_ASSOC );
    
    $this->viewModel->set ( "maxHolidays", $resultsets[0]['maxHoliday'] );
    $this->viewModel->set('uid', $urlValues['userID']);
    
    return $this->viewModel;
  }

  public function add( $urlValues ) {
    $this->viewModel->set('uid', $urlValues['userID']);
    
    return $this->viewModel;
  }

  public function process( $urlValues ) {
    $getHolidaySql = sprintf ( "SELECT h.* FROM holiday h WHERE h.id = '%s'", $urlValues['holidayProcessID'] );
    $result = $this->db->query ( $getHolidaySql );
    $resultsets = $result->fetch_all ( MYSQLI_ASSOC );
    
    $this->viewModel->set ( "userHolidayData", $resultsets[0] );
    $this->viewModel->set('uid', $urlValues['userID']);
    $result->free();
    
    return $this->viewModel;
  }
  
  public function error( $status ) {
    $this->viewModel->set ( "status", $status );
  
    return $this->viewModel;
  }

  public function success( ) {
    return $this->viewModel;
  }
}

?>
