<?php

/**
 * The index Model of the page
 * 
 * @author Timo Stepputtis
 *
 */
class IndexModel extends BaseModel {
  
  
  /**
   * Sets the pagetitle and returns the viewModel
   * 
   * @return ViewModel
   */
  public function index( ) {
    $this->viewModel->set ( "pageTitle", "It-Solutions Urlaubsplaner" );
    
    return $this->viewModel;
  }
}

?>
