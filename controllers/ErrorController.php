<?php

class ErrorController extends BaseController
{    
    //add to the parent constructor
    public function __construct($action, $urlValues) {
        parent::__construct($action, $urlValues);
        
        //create the model object
        $this->model = new ErrorModel();
    }
    
    //bad URL request error
    protected function badURL()
    {
        $this->view->output($this->model->badURL($this->urlValues));
    }
    
    protected function badUsername()
    {
    	$this->view->output($this->model->badUsername($this->urlValues));
    }
    
    protected function badPassword()
    {
    	$this->view->output($this->model->badPassword($this->urlValues));
    }
    
    protected function badEmail()
    {
    	$this->view->output($this->model->badEmail($this->urlValues));
    }
    
    protected function badRegData()
    {
    	print "Bad reg data function...<br>";
    	$this->view->output($this->model->badRegData($this->urlValues));
    }
}

?>
