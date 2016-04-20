<?php

class AjaxController extends BaseController
{
    //add to the parent constructor
    public function __construct($action, $urlValues) {
        parent::__construct($action, $urlValues);
        
        //create the model object
        $this->model = new AjaxModel($this->urlValues);
    }
    
    //default method
    protected function validateUser()
    {
        $this->view->output($this->model->validateUser(), '');
    }
}

?>
