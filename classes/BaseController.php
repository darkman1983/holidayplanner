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
    
    protected function checkAccess( $levels = '' ) {
      if(empty($levels))
      {
        return false;
      }
    
      if ( ! $this->session->get ( 'loggedIN' ) ) {
        return false;
      }
    
      if ( $this->session->get ( 'level' ) < $levels [$this->action] ) {
        return false;
      }
    
      return true;
    }
        
    //executes the requested method
    public function executeAction() {
        return $this->{$this->action}();
    }
}

?>
