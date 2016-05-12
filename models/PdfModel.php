<?php

/**
 * @author tstepputtis
 *
 */
class PdfModel extends BaseModel {

  private $db = NULL;

  public function __construct( ) {
    parent::__construct ( );
    
    $this->db = Database::getInstance ( )->getCon ( );
  }
  
  // data passed to the home index view
  public function showPdf( $urlValues, $manager = false ) {
    $getPdfDataSql = sprintf ( "SELECT h.*, u.firstname, u.lastname, u.staffid, COALESCE((SELECT maxHoliday FROM mhy WHERE year = FROM_UNIXTIME(h.startdate, '%%Y') AND employeeID = h.employeeID), 0) AS maxHoliday, COALESCE((SELECT maxHoliday FROM mhy WHERE year = FROM_UNIXTIME(h.startdate, '%%Y') -1 AND employeeID = h.employeeID), 0) AS maxHolidayLast,  (SELECT COALESCE(SUM(`getNumDays`(ho.startdate, ho.enddate, 3)), 0) FROM holiday ho WHERE ho.id <> h.id AND ho.employeeID = h.employeeID AND ho.type = 'H' AND FROM_UNIXTIME(ho.startdate, '%%Y') = FROM_UNIXTIME(h.startdate, '%%Y') AND status = 2) - (SELECT COALESCE(SUM(`getNumDays`(ho.startdate, ho.enddate, 3)), 0) FROM holiday ho WHERE ho.employeeID = h.employeeID AND ho.type = 'I' AND FROM_UNIXTIME(ho.startdate, '%%Y') = FROM_UNIXTIME(h.startdate, '%%Y')) AS remainingHoliday, (SELECT COALESCE(SUM(`getNumDays`(ho.startdate, ho.enddate, 3)), 0) FROM holiday ho WHERE ho.employeeID = h.employeeID AND ho.type = 'H' AND FROM_UNIXTIME(ho.startdate, '%%Y') = FROM_UNIXTIME(h.startdate, '%%Y')-1) - (SELECT COALESCE(SUM(`getNumDays`(ho.startdate, ho.enddate, 3)), 0) FROM holiday ho WHERE ho.employeeID = h.employeeID AND ho.type = 'I' AND FROM_UNIXTIME(ho.startdate, '%%Y') = FROM_UNIXTIME(h.startdate, '%%Y')-1) AS lastYearHoliday, (SELECT `getNumDays`(h.startdate, h.enddate, 3)) AS days FROM holiday h JOIN users u ON h.employeeID = u.id WHERE h.id = %s%s", $urlValues ['pdfID'], $manager ? '' : sprintf(" AND u.id = '%s'", $this->session->get('id')) );
    $resultQuery = $this->db->query ( $getPdfDataSql );
    $result = $resultQuery->fetch_all ( MYSQLI_ASSOC );
    
    $this->viewModel->set ( "pdfData", Utils::generatePdf ( $result [0] ) );
    $this->viewModel->set ( "savePath", Utils::generatePdfFileName( $result [0] ) );
    
    $resultQuery->free();
    
    return $this->viewModel;
  }
  
  public function ManagerShowPdf( $urlValues ) {
    return $this->showPdf($urlValues, true);
  }
}

?>
