<?php

/**
 * The ErrorController handles some base errors occuring on loading
 * 
 * @author Timo Stepputtis
 *
 */
class ErrorController extends BaseController
{    
    public function __construct($action, $urlValues) {
        parent::__construct($action, $urlValues);
        
        //create the model object
        $this->model = new ErrorModel();
    }
    
    
    /**
     * Bad URL request error
     */
    protected function badURL()
    {
        $this->view->output($this->model->badURL($this->urlValues));
    }
    
    /**
     * Bad username
     */
    protected function badUsername()
    {
    	$this->view->output($this->model->badUsername($this->urlValues));
    }
    
    /**
     * Bad password
     */
    protected function badPassword()
    {
    	$this->view->output($this->model->badPassword($this->urlValues));
    }
    
    /**
     * Bad email
     */
    protected function badEmail()
    {
    	$this->view->output($this->model->badEmail($this->urlValues));
    }
    
    /**
     * Bad registration data
     */
    protected function badRegData()
    {
    	$this->view->output($this->model->badRegData($this->urlValues));
    }
}

?>
