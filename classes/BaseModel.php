<?php

class BaseModel {
    
    protected $viewModel;
    protected $session = NULL;

    //create the base and utility objects available to all models on model creation
    public function __construct()
    {
        $this->viewModel = new ViewModel();
        $baseUrl = $_SERVER['SERVER_NAME'];
        $this->viewModel->set("AssetPath", "http://{$baseUrl}/views/Assets/");
        $this->viewModel->set("BaseUrl", "http://$baseUrl/");
        
        $this->session = Session::getInstance ( );
        $this->commonViewData();
    }

    //establish viewModel data that is required for all views in this method (i.e. the main template)
    protected function commonViewData() {
      $this->viewModel->set ( "logouttime", strtotime("+20 minutes", $this->session->get('timestamp')));
      $this->viewModel->set ( "pageTitle", "It-Solutions Urlaubsplaner" );
      $this->viewModel->set ( "userID", $this->session->get ( 'id' ) );
      $this->viewModel->set ( "loggedIN", $this->session->get ( 'loggedIN' ) );
      $this->viewModel->set ( "level", $this->session->get ( 'level' ) );
      $this->viewModel->set ( "firstname", $this->session->get ( 'firstname' ) );
      $this->viewModel->set ( "lastname", $this->session->get ( 'lastname' ) );
    }
}

?>
