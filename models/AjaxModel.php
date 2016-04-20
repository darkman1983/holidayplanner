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
    print $checkUserSql;
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
}

?>
