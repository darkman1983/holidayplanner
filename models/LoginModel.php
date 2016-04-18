<?php

class LoginModel extends BaseModel
{
  private $db = NULL;
  private $urlValues = array();
  
  public function __construct($urlValues)
  {
    parent::__construct();
    
    $this->db = Database::getInstance()->getCon();
  }
    //data passed to the home index view
    public function index()
    {   
        $this->viewModel->set("pageTitle", "It-Solutions Urlaubsplaner :: Login");

        return $this->viewModel;
    }
    
    public function login()
    {
      $this->viewModel->set("pageTitle", "It-Solutions Urlaubsplaner :: Login");
      
      //print_r($this->urlValues);
    
      return $this->viewModel;
    }
}

?>
