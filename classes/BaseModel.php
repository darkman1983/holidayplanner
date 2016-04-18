<?php

class BaseModel {
    
    protected $viewModel;

    //create the base and utility objects available to all models on model creation
    public function __construct()
    {
        $this->viewModel = new ViewModel();
        $this->viewModel->set("AssetPath", "http://hday.localhost/views/Assets/");
        $this->viewModel->set("BaseUrl", "http://hday.localhost/");
        $this->commonViewData();
    }

    //establish viewModel data that is required for all views in this method (i.e. the main template)
    protected function commonViewData() {
	
    //e.g. $this->viewModel->set("mainMenu",array("Home" => "/home", "Help" => "/help"));
    }
}

?>
