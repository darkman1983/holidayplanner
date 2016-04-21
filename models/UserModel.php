<?php

/**
 * @author tstepputtis
 *
 */
class UserModel extends BaseModel {

  private $db = NULL;

  public function __construct( ) {
    parent::__construct ( );
    
    $this->db = Database::getInstance ( )->getCon ( );
  }
  
  // data passed to the home index view
  public function index( ) {
    $getTotalUsersSql = "SELECT COUNT(*) FROM users";
    $totalResult = $this->db->query ( $getTotalUsersSql );
    $totalUsers = $totalResult->fetch_row ( );
    
    /* Start Pagination Code */
    
    // How many items to list per page
    $limit = 10;
    
    // How many pages will there be
    $pages = ceil ( $totalUsers [0] / $limit );
    
    // What page are we currently on?
    $page = min ( $pages, filter_input ( INPUT_GET, 'page', FILTER_VALIDATE_INT, array ('options' => array ('default' => 1,'min_range' => 1 ) ) ) );
    
    // Calculate the offset for the query
    $offset = ($page - 1) * $limit;
    
    // Some information to display to the user
    $start = $offset + 1;
    $end = min ( ($offset + $limit), $totalUsers );
    
    $this->viewModel->set ( "pagination", array ("limit" => $limit,"pages" => $pages,"page" => $page,"offset" => $offset,"start" => $start,"end" => $end,"total" => $totalUsers [0] ) );
    
    /* End Pagination Code */
    
    $get_users_sql = sprintf ( "SELECT * FROM users LIMIT %s OFFSET %s", $limit, $offset );
    $result = $this->db->query ( $get_users_sql );
    $resultsets = $result->fetch_all ( MYSQLI_ASSOC );
    
    $this->viewModel->set ( "userData", $resultsets );
    
    return $this->viewModel;
  }

  public function create( ) {
    return $this->viewModel;
  }

  public function edit( $urlValues ) {
    $get_users_sql = sprintf ( "SELECT * FROM users WHERE id = '%s'", $urlValues['userEditID']);
    $result = $this->db->query ( $get_users_sql );
    $resultsets = $result->fetch_all ( MYSQLI_ASSOC );
    
    $this->viewModel->set ( "userData", $resultsets );
    $this->viewModel->set ( "userEditID", $urlValues['userEditID'] );
    
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
