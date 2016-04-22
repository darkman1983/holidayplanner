<?php

/**
 * @author tstepputtis
 *
 */
class FeastdaysModel extends BaseModel {

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
    
    /* Start Pagination Code */
    
    // How many items to list per page
    $limit = 10;
    
    // How many pages will there be
    $pages = ceil ( $totalHolidayCustom [0] / $limit );
    
    // What page are we currently on?
    $page = min ( ($pages < 1) ? 1 : $pages, isset ( $urlValues ['page'] ) ? $urlValues ['page'] : 1 );
    
    // Calculate the offset for the query
    $offset = ($page - 1) * $limit;
    
    // Some information to display to the user
    $start = $offset + 1;
    $end = min ( ($offset + $limit), $totalHolidayCustom );
    
    $this->viewModel->set ( "pagination", array ("limit" => $limit,"pages" => ($pages < 1) ? 1 : $pages,"page" => $page,"offset" => $offset,"start" => $start,"end" => $end,"total" => $totalHolidayCustom [0] ) );
    
    /* End Pagination Code */
    
    $getHolidayCustomSql = sprintf ( "SELECT * FROM holiday_custom LIMIT %s OFFSET %s", $limit, $offset );
    $result = $this->db->query ( $getHolidayCustomSql );
    $resultsets = $result->fetch_all ( MYSQLI_ASSOC );
    
    return $this->viewModel;
  }
  
  public function create( ) {
    return $this->viewModel;
  }
  
}

?>
