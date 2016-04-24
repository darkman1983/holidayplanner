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
  public function index( $urlValues ) {
    $getTotalUsersSql = "SELECT COUNT(*) FROM users";
    $totalResult = $this->db->query ( $getTotalUsersSql );
    $totalUsers = $totalResult->fetch_row ( );
    
    $pagination = Utils::generatePagination($urlValues, $totalUsers[0]);
    
    $this->viewModel->set ( "pagination", $pagination );
    
    $get_users_sql = sprintf ( "SELECT * FROM users LIMIT %s OFFSET %s", $pagination['limit'], $pagination['offset'] );
    $result = $this->db->query ( $get_users_sql );
    $resultsets = $result->fetch_all ( MYSQLI_ASSOC );
    
    $this->viewModel->set ( "userData", $resultsets );
    
    return $this->viewModel;
  }

  public function create( ) {
    return $this->viewModel;
  }

  public function edit( $urlValues ) {
    $get_users_sql = sprintf ( "SELECT * FROM users WHERE id = '%s'", $urlValues ['userEditID'] );
    $result = $this->db->query ( $get_users_sql );
    $resultsets = $result->fetch_all ( MYSQLI_ASSOC );
    
    $this->viewModel->set ( "userData", $resultsets );
    $this->viewModel->set ( "userEditID", $urlValues ['userEditID'] );
    
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
