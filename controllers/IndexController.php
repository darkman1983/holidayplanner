<?php

/**
 * The index Controller
 * 
 * @author Timo Stepputtis
 *
 */
class IndexController extends BaseController
{
    //add to the parent constructor
    public function __construct($action, $urlValues) {
        parent::__construct($action, $urlValues);
        
        //create the model object
        $this->model = new IndexModel();
    }
    
    /**
     * Sets the view output
     */
    protected function index()
    {
        $this->view->output($this->model->index(), '');
    }
}

?>
