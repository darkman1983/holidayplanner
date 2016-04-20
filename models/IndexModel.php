<?php

/**
 * @author tstepputtis
 *
 */
class IndexModel extends BaseModel {
  
  // data passed to the home index view
  public function index( ) {
    $this->viewModel->set ( "pageTitle", "It-Solutions Urlaubsplaner" );
    
    return $this->viewModel;
  }
}

?>
