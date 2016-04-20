<?php

abstract class BaseController {
    
    protected $urlValues;
    protected $action;
    protected $model;
    protected $view;
    protected $session;
    
    public function __construct($action, $urlValues) {
        $this->action = $action;
        $this->urlValues = $urlValues;
                
        //establish the view object
        $this->view = new View(str_replace("controllers\\", "", get_class($this)), $action);
        
        $this->session = Session::getInstance();
    }
        
    //executes the requested method
    public function executeAction() {
        return $this->{$this->action}();
    }
}

?>
