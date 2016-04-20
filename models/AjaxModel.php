<?php

/**
 * @author tstepputtis
 *
 */
class AjaxModel extends BaseModel {
  private $db = NULL;
  private $urlValues;
  
  public function __construct($urlValues) {
    parent::__construct();
    
    $this->db = Database::getInstance()->getCon();
    $this->urlValues = $urlValues;
  }
  
  // data passed to the home index view
  public function validateUser( ) {
    
    $checkUserSql = sprintf("SELECT username FROM users WHERE username = '%s'", $this->urlValues['frm_username']);
    $result = $this->db->query($checkUserSql);
    
    if($result->num_rows > 0)
    {
      $this->viewModel->set ( "statusCode", 418 );
      $this->viewModel->set ( "statusText", 'Username already exists!' );
    }else {
      $this->viewModel->set ( "statusCode", 200 );
      $this->viewModel->set ( "statusText", 'OK - Username is available' );
    }
    
    return $this->viewModel;
  }
  
  public function filterUsers($urlValues)
  {
      $getFilteredUsersSql = sprintf("SELECT * FROM users WHERE firstname LIKE '%%%s%%' OR lastname LIKE '%%%s%%' OR username LIKE '%%%s%%'%s", $urlValues['usersFilter'], $urlValues['usersFilter'], $urlValues['usersFilter'], empty($urlValues['usersFilter']) ? 'LIMIT 0,10' : '');
      $result = $this->db->query($getFilteredUsersSql);
      $this->viewModel->set("filteredUsers", $result->fetch_all(MYSQLI_ASSOC));
      
      return $this->viewModel;
  }
  
  public function deleteUser($urlValues)
  {
      $deleteUserSql = sprintf("DELETE FROM users WHERE id = '%s'", $urlValues['userID']);
      $result = $this->db->query($deleteUserSql);
      
      $this->filterUsers($urlValues);
      
      return $this->viewModel;
  }
}

?>
