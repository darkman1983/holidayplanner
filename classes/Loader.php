<?php

class Loader {
    
    private $controllerName;
    private $controllerClass;
    private $action;
    private $request;
    private $session;
    
    //store the URL request values on object creation
    public function __construct() {
        $this->request = array_merge($_GET, $_POST);

        if ($this->request['controller'] == "") {
            $this->controllerName = "IndexController";
            $this->controllerClass = $this->controllerName;
        } else {
            $this->controllerName = ucfirst(strtolower($this->request['controller'])).'Controller';
            $this->controllerClass = $this->controllerName;
        }

        if ($this->request['action'] == "") {
            $this->action = "index";
        } else {
            $this->action = $this->request['action'];
        }
        
        $this->session = Session::getInstance();
    }
    
    public function createSession()
    {
    	return $this->session;
    }
                  
    //factory method which establishes the requested controller as an object
    public function createController() {
        //check our requested controller's class file exists and require it if so
        if (!file_exists("controllers/" . $this->controllerName . ".php")) {
            return new ErrorController("badurl",$this->request);
        }
        
        //does the class exist?
        if (class_exists($this->controllerClass)) {
            $parents = class_parents($this->controllerClass);
            
            //does the class inherit from the BaseController class?
            if (in_array("BaseController",$parents)) {
                //does the requested class contain the requested action as a method?
                if (method_exists($this->controllerClass,$this->action))
                {
                    return new $this->controllerClass($this->action,$this->request);
                } else {
                    //bad action/method error
                    return new ErrorController("badurl",$this->request);
                }
            } else {
                //bad controller error
                return new ErrorController("badurl",$this->request);
            }
        } else {
            //bad controller error
            return new ErrorController("badurl",$this->request);
        }
    }
}

?>