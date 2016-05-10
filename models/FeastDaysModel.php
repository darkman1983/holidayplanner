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
    
    $getFeastDaysCountSql = "SELECT COUNT(*) FROM feastdays";
    $totalResult = $this->db->query ( $getFeastDaysCountSql );
    $totalFeastDaysCustom = $totalResult->fetch_row ( );
    
    $pagination = Utils::generatePagination ( $urlValues, $totalFeastDaysCustom [0] );
    
    $this->viewModel->set ( "pagination", $pagination );
    
    $getFeastDaysSql = sprintf ( "SELECT f.*, u.username FROM feastdays f LEFT JOIN users u ON f.userID = u.id LIMIT %s OFFSET %s", $pagination ['limit'], $pagination ['offset'] );
    $result = $this->db->query ( $getFeastDaysSql );
    $resultsets = $result->fetch_all ( MYSQLI_ASSOC );
    
    $this->viewModel->set ( "feastDaysData", $resultsets );
    
    return $this->viewModel;
  }

  public function create( ) {
    return $this->viewModel;
  }

  public function edit( $urlValues ) {
    $getFeastDaysSql = sprintf ( "SELECT * FROM feastdays WHERE id = '%s'", $urlValues ['feastDaysEditID'] );
    $result = $this->db->query ( $getFeastDaysSql );
    $resultsets = $result->fetch_all ( MYSQLI_ASSOC );
    
    $this->viewModel->set ( "feastDaysData", $resultsets [0] );
    $this->viewModel->set ( "feastDaysEditID", $urlValues ['feastDaysEditID'] );
    
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
