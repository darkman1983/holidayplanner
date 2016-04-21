<?php

class FeastdaysController extends BaseController
{
    //add to the parent constructor
    public function __construct($action, $urlValues) {
        parent::__construct($action, $urlValues);
        
        //create the model object
        $this->model = new FeastdaysModel();
    }
    
    //default method
    protected function index()
    {
        $this->view->output($this->model->index(), '');
    }
}

?>
