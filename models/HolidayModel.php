<?php

/**
 * Handles all holiday data for requested action
 * 
 * @author Timo Stepputtis
 *
 */
class HolidayModel extends BaseModel {

  /**
   * @var resource
   */
  private $db = NULL;

  public function __construct( ) {
    parent::__construct ( );
    
    $this->db = Database::getInstance ( )->getCon ( );
  }
  

  /**
   * Generates the index view data and sets the view output
   * 
   * @param array $urlValues
   * @return ViewModel
   */
  public function index( $urlValues ) {
    $getTotalHolidaySql = sprintf("SELECT COUNT(*) FROM holiday WHERE employeeID = '%s'", $this->session->get('id'));
    $totalResult = $this->db->query ( $getTotalHolidaySql );
    $totalHoliday = $totalResult->fetch_row ( );
    
    $pagination = Utils::generatePagination(intval(@$urlValues['page']), $totalHoliday[0]);
    $totalResult->free();
    
    $this->viewModel->set ( "pagination", $pagination );
    
    $getHolidaySql = sprintf ( "SELECT h.*, (SELECT COALESCE(SUM(`getNumDays`(ho.startdate, ho.enddate, 3)), 0) FROM holiday ho WHERE ho.employeeID = h.employeeID AND ho.type = 'H' AND status != 1 AND FROM_UNIXTIME(ho.startdate, '%%Y') = FROM_UNIXTIME(%s, '%%Y')) - (SELECT COALESCE(SUM(`getNumDays`(ho.startdate, ho.enddate, 3)), 0) FROM holiday ho WHERE ho.employeeID = h.employeeID AND ho.type = 'I' AND FROM_UNIXTIME(ho.startdate, '%%Y') = FROM_UNIXTIME(%s, '%%Y')) AS remainingHoliday, (SELECT getNumDays(h.startdate, h.enddate, 3)) AS days FROM holiday h WHERE h.employeeID = '%s' LIMIT %s OFFSET %s", time(), time(), $this->session->get('id'), $pagination['limit'], $pagination['offset'] );
    $result = $this->db->query ( $getHolidaySql );
    $resultsets = $result->fetch_all ( MYSQLI_ASSOC );
    
    $this->viewModel->set ( "userHolidayData", $resultsets );
    $result->free();
    
    $getMaxHolidaySql = sprintf ( "SELECT maxHoliday FROM mhy WHERE year = FROM_UNIXTIME(%s, '%%Y') AND employeeID = '%s'", time(), $this->session->get('id') );
    $result = $this->db->query ( $getMaxHolidaySql );
    $resultsets = $result->fetch_all ( MYSQLI_ASSOC );
    
    $this->viewModel->set ( "maxHoliday", @$resultsets[0]['maxHoliday'] );
    $result->free();
    
    return $this->viewModel;
  }

  /**
   * Returns the viewModel
   * 
   * @return ViewModel
   */
  public function propose( ) {
    return $this->viewModel;
  }

  /**
   * Sets status and extra data for template and returns the viewModel
   * 
   * @param string $status
   * @param array $extra
   * @return ViewModel
   */
  public function error( $status, $extra = array() ) {
    $this->viewModel->set ( "status", $status );
    $this->viewModel->set ( "extra", $extra );
    
    return $this->viewModel;
  }

  public function success( ) {
    return $this->viewModel;
  }
}

?>
