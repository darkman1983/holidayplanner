<?php

/**
 * @author tstepputtis
 *
 */
class FeastDaysModel extends BaseModel {

  private $db = NULL;

  public function __construct( ) {
    parent::__construct ( );
    
    $this->db = Database::getInstance ( )->getCon ( );
  }
  
  // data passed to the home index view
  public function index( $urlValues ) {
    $this->viewModel->set ( "pageTitle", "It-Solutions Urlaubsplaner" );
    
    $getHolidayCustomCountSql = "SELECT COUNT(*) FROM holiday_custom";
    $totalResult = $this->db->query ( $getHolidayCustomCountSql );
    $totalHolidayCustom = $totalResult->fetch_row ( );
    
    $pagination = Utils::generatePagination($urlValues, $totalHolidayCustom[0]);
    
    $this->viewModel->set ( "pagination", $pagination );
    
    $getHolidayCustomSql = sprintf ( "SELECT h.id, h.start, h.duration, h.description, u.username FROM holiday_custom h LEFT JOIN users u ON h.userID = u.id LIMIT %s OFFSET %s", $pagination['limit'], $pagination['offset'] );
    $result = $this->db->query ( $getHolidayCustomSql );
    $resultsets = $result->fetch_all ( MYSQLI_ASSOC );
    
    $this->viewModel->set ( "feastDaysData", $resultsets );
    
    return $this->viewModel;
  }

  public function create( ) {
    return $this->viewModel;
  }
  
  public function edit( $urlValues ) {
    $getFeastDaysSql = sprintf ( "SELECT * FROM holiday_custom WHERE id = '%s'", $urlValues ['feastDaysEditID'] );
    $result = $this->db->query ( $getFeastDaysSql );
    $resultsets = $result->fetch_all ( MYSQLI_ASSOC );
    
    $this->viewModel->set ( "feastDaysData", $resultsets[0] );
    $this->viewModel->set ( "feastDaysEditID", $urlValues ['feastDaysEditID'] );
    
    return $this->viewModel;
  }

  public function badFeastDaysCreate( $urlValues, $dbError ) {
    $this->viewModel->set ( "urlValues", $urlValues );
    $this->viewModel->set ( "dbError", $dbError );
    
    return $this->viewModel;
  }

  public function success( ) {
    return $this->viewModel;
  }
}

?>
