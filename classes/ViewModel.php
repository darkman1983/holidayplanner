<?php
/**
 * The ViewModel class file
 * @author Timo Stepputtis
 */

/**
 * The ViewModel class holds all variables assigned to it for the templates
 *
 */
class ViewModel {    
    
    //dynamically adds a property or method to the ViewModel instance
    public function set($name,$val) {
        $this->$name = $val;
    }
    
    //returns the requested property value
    public function get($name) {
        if (isset($this->{$name})) {
            return $this->{$name};
        } else {
            return null;
        }
    }
}

?>