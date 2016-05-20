<?php
/**
 * The UserModel class can do all related to user actions
 * 
 * @author Timo Stepputtis
 *
 */
class UserModel extends BaseModel {

  /**
   * Hold the database connection resource
   * @var resource
   */
  private $db = NULL;

  /**
   * The constructor will get current database connection and assign it to the $db variable
   */
  public function __construct( ) {
    parent::__construct ( );
    
    $this->db = Database::getInstance ( )->getCon ( );
  }
  
  /**
   * The default function for the UserModel, will display the index/overview page
   * 
   * @param array $urlValues
   * @return ViewModel
   */
  public function index( $urlValues ) {
    $getTotalUsersSql = "SELECT COUNT(*) FROM users";
    $totalResult = $this->db->query ( $getTotalUsersSql );
    $totalUsers = $totalResult->fetch_row ( );
    
    $pagination = Utils::generatePagination(intval(@$urlValues['page']), $totalUsers[0]);
    
    $this->viewModel->set ( "pagination", $pagination );
    
    $get_users_sql = sprintf ( "SELECT * FROM users LIMIT %s OFFSET %s", $pagination['limit'], $pagination['offset'] );
    $result = $this->db->query ( $get_users_sql );
    $resultsets = $result->fetch_all ( MYSQLI_ASSOC );
    
    $this->viewModel->set ( "userData", $resultsets );
    
    return $this->viewModel;
  }

  /**
   * Returns the viewModel
   * 
   * @return ViewModel
   */
  public function create( ) {
    return $this->viewModel;
  }

  /**
   * Generates data for the view and returns the viewModel
   * 
   * @param array $urlValues
   * @return ViewModel
   */
  public function edit( $urlValues ) {
    $get_users_sql = sprintf ( "SELECT * FROM users WHERE id = '%s'", $urlValues ['userEditID'] );
    $result = $this->db->query ( $get_users_sql );
    $resultsets = $result->fetch_all ( MYSQLI_ASSOC );
    
    $this->viewModel->set ( "userData", $resultsets );
    $this->viewModel->set ( "userEditID", $urlValues ['userEditID'] );
    
    $getMaxHolidayYearSql = sprintf ( "SELECT * FROM mhy WHERE employeeID = '%s'", $urlValues ['userEditID'] );
    $result = $this->db->query ( $getMaxHolidayYearSql );
    $resultsets = $result->fetch_all ( MYSQLI_ASSOC );
    
    $this->viewModel->set ( "maxHolidayDataYear", $resultsets );
    
    return $this->viewModel;
  }

  /**
   * Sets the status template variable and returns the viewModel
   * 
   * @param string $status
   * @return ViewModel
   */
  public function error( $status ) {
    $this->viewModel->set ( "status", $status );
  
    return $this->viewModel;
  }

  /**
   * Returns the viewModel
   * 
   * @return ViewModel
   */
  public function success( ) {
    return $this->viewModel;
  }
}

?>
