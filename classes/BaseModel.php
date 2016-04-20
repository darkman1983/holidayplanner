<?php

class BaseModel {
    
    protected $viewModel;
    protected $session = NULL;

    //create the base and utility objects available to all models on model creation
    public function __construct()
    {
        $this->viewModel = new ViewModel();
        $this->viewModel->set("AssetPath", "http://hday.localhost/views/Assets/");
        $this->viewModel->set("BaseUrl", "http://hday.localhost/");
        
        $this->session = Session::getInstance ( );
        $this->commonViewData();
    }

    //establish viewModel data that is required for all views in this method (i.e. the main template)
    protected function commonViewData() {
      $this->viewModel->set ( "pageTitle", "It-Solutions Urlaubsplaner" );
      $this->viewModel->set ( "userID", $this->session->get ( 'id' ) );
      $this->viewModel->set ( "loggedIN", $this->session->get ( 'loggedIN' ) );
      $this->viewModel->set ( "level", $this->session->get ( 'level' ) );
      $this->viewModel->set ( "firstname", $this->session->get ( 'firstname' ) );
      $this->viewModel->set ( "lastname", $this->session->get ( 'lastname' ) );
    }
}

?>
