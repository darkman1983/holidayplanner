<?php
/**
 * The ViewModel class holds all variables assigned to it for the templates
 * 
 * @author Timo Stepputtis
 */
class ViewModel {    
    
    
    /**
     * Dynamically adds a property or method to the ViewModel instance
     * 
     * @param string $name
     * @param string $val
     */
    public function set($name,$val) {
        $this->$name = $val;
    }
    
    
    /**
     * Returns the requested property value
     * 
     * @param string $name
     * @return string|NULL
     */
    public function get($name) {
        if (isset($this->{$name})) {
            return $this->{$name};
        } else {
            return null;
        }
    }
}

?>