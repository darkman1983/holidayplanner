<?php
/**
 * @author Timo Stepputtis
 *
 */
abstract class BaseController {
    
    protected $urlValues;
    protected $action;
    protected $model;
    protected $view;
    protected $session;
    
    /**
     * @param string $action <p>A action string, which represents the requested function from controller</p>
     * @param array $urlValues <p>An mixed array of $_GET and $_POST</p>
     */
    public function __construct($action, $urlValues) {
        $this->action = $action;
        $this->urlValues = $urlValues;
                
        //establish the view object
        $this->view = new View(str_replace("controllers\\", "", get_class($this)), $action);
        
        $this->session = Session::getInstance();
    }
    
    /**
     * Checks wherever a user has access to the current requested action
     * 
     * @param array $levels <p>An associative array of levels for actions</p>
     * @return boolean
     */
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
        
    /**
     * Executes the requested action
     */
    public function executeAction() {
        return $this->{$this->action}();
    }
}

?>
