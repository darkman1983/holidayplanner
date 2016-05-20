<?php

/**
 * The PDF Controller handles PDF related requests
 * 
 * @author Timo Stepputtis
 *
 */
class PdfController extends BaseController {
  // add to the parent constructor
  public function __construct( $action, $urlValues ) {
    parent::__construct ( $action, $urlValues );
    
    $this->levels = array ("showpdf" => 1, "managershowpdf" => 2 );
    
    // create the model object
    if ( ! $this->checkAccess ( $this->levels ) ) {
      $this->model = new ErrorModel ( );
    } else {
      $this->model = new PdfModel ( );
    }
    
    $this->db = Database::getInstance ( )->getCon ( );
  }
  

  /**
   * Sets the view output
   */
  protected function showPdf( ) {
    if ( ! $this->checkAccess ( $this->levels ) ) {
      $this->view->output ( $this->model->notAllowed ( ), 'Error/notallowed' );
      return;
    }
    
    $this->view->output ( $this->model->showPdf ( $this->urlValues ), '' );
  }
  
  /**
   * Sets the manager view output
   */
  protected function managerShowPdf( ) {
    if ( ! $this->checkAccess ( $this->levels ) ) {
      $this->view->output ( $this->model->notAllowed ( ), 'Error/notallowed' );
      return;
    }
  
    $this->view->output ( $this->model->managerShowPdf ( $this->urlValues ), '' );
  }
}

?>
