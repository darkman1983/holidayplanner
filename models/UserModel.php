<?php

/**
 * @author tstepputtis
 *
 */
class UserModel extends BaseModel {

  private $db = NULL;

  public function __construct() {
    parent::__construct();
    
    $this->db = Database::getInstance ( )->getCon ( );
  }
  
  // data passed to the home index view
  public function index( ) {
    $get_users_sql = sprintf("SELECT * FROM users LIMIT %s", "0,10");
    $result = $this->db->query($get_users_sql);
    $resultsets = $result->fetch_all(MYSQLI_ASSOC);
    
    $this->viewModel->set("userData", $resultsets);
    
    return $this->viewModel;
  }
  
  public function create()
  {
    return $this->viewModel;
  }
  
  public function badUserCreate($urlValues, $dbError)
  {
      $this->viewModel->set("urlValues", $urlValues);
      $this->viewModel->set("dbError", $dbError);
      
      return $this->viewModel;
  }
  
  public function success()
  {
      return $this->viewModel;
  }
}

?>
