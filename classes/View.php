<?php

class View {    
    
    protected $viewFile;
    
    //establish View location on object creation
    public function __construct($controllerClass, $action) {
        $controllerName = str_replace("Controller", "", $controllerClass);
        $this->viewFile = "views/" . $controllerName . "/" . $action . ".php";
    }
               
    //output the View
    public function output($viewModel, $template = "maintemplate") {
        
        $templateFile = "views/".$template.".php";
        
        if (file_exists($this->viewFile)) {
            if ($template) {
                //include the full template
                if (file_exists($templateFile)) {
                    require($templateFile);
                } else {
                    require("views/error/badtemplate.php");
                }
            } else {
                //we're not using a template View so just output the method's View directly
                require($this->viewFile);
            }
        } else {
            require("views/error/badview.php");
        }
        
    }
}

?>