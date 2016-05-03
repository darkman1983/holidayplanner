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
  public function showPdf( $urlValues ) {
    $getPdfDataSql = sprintf ( "SELECT h.*, u.firstname, u.lastname, u.maxHoliday, (SELECT COALESCE(SUM(`getNumDays`(ho.startdate, ho.enddate, 3)), 0) FROM holiday ho WHERE ho.type = 'H' AND YEAR(FROM_UNIXTIME(ho.startdate)) = YEAR(FROM_UNIXTIME(h.startdate))) - (SELECT COALESCE(SUM(`getNumDays`(ho.startdate, ho.enddate, 3)), 0) FROM holiday ho WHERE ho.type = 'I' AND YEAR(FROM_UNIXTIME(ho.startdate)) = YEAR(FROM_UNIXTIME(h.startdate))) AS remainingHoliday, (SELECT COALESCE(SUM(`getNumDays`(ho.startdate, ho.enddate, 3)), 0) FROM holiday ho WHERE ho.type = 'H' AND YEAR(FROM_UNIXTIME(ho.startdate)) = YEAR(FROM_UNIXTIME(h.startdate))-1) - (SELECT COALESCE(SUM(`getNumDays`(ho.startdate, ho.enddate, 3)), 0) FROM holiday ho WHERE ho.type = 'I' AND YEAR(FROM_UNIXTIME(ho.startdate)) = YEAR(FROM_UNIXTIME(h.startdate))-1) AS lastYearHoliday, (SELECT `getNumDays`(h.startdate, h.enddate, 3)) AS days FROM holiday h JOIN users u ON h.employeeID = u.id WHERE h.id = %s", $urlValues ['pdfID'] );
    $resultQuery = $this->db->query ( $getPdfDataSql );
    $result = $resultQuery->fetch_all ( MYSQLI_ASSOC );
    
    $this->viewModel->set ( "pdfData", Utils::generatePdf ( $result [0] ) );
    $this->viewModel->set ( "savePath", Utils::getPdfSavePath ( $result [0] ) );
    
    return $this->viewModel;
  }
}

?>
