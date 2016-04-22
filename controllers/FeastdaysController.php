<?php

class FeastdaysController extends BaseController {

  private $db = NULL;

  private $levels;
  
  // add to the parent constructor
  public function __construct( $action, $urlValues ) {
    parent::__construct ( $action, $urlValues );
    
    $this->levels = array ("index" => 3,"create" => 3,"edit" => 3 );
    
    // create the model object
    if ( ! $this->checkAccess ( $this->levels ) ) {
      $this->model = new ErrorModel ( );
    } else {
      $this->model = new UserModel ( );
    }
    
    $this->db = Database::getInstance ( )->getCon ( );
  }
  
  // default method
  protected function index( ) {
    if ( ! $this->checkAccess ( $this->levels ) ) {
      $this->view->output ( $this->model->notAllowed ( ), 'Error/notallowed' );
      return;
    }
    
    $this->view->output ( $this->model->index ( $this->urlValues ), '' );
  }

  protected function create( ) {
    if ( ! $this->checkAccess ( $this->levels ) ) {
      $this->view->output ( $this->model->notAllowed ( ), 'Error/notallowed' );
      return;
    }
    
    $dataValid = false;
    
    if ( isset ( $this->urlValues ['do'] ) && $this->urlValues ['do'] == 1 ) {
      foreach ( $this->urlValues as $key => &$data ) {
        if ( strstr ( $data, "frm_" ) && empty ( $data ) ) {
          $this->view->output ( $this->model->badRegData ( $this->urlValues ), 'User/badregdata' );
          return;
        } else {
          $dataValid = true;
        }
      }
    }
    
    if ( $dataValid ) {
      $createHolidayCustomSql = sprintf ( "INSERT INTO holiday_custom SET userID = '%s', start = '%s', duration = '%s', description = '%s'", $this->session->get('id') ,$this->urlValues ['frm_start'], $this->urlValues ['frm_duration'], $this->urlValues ['frm_description'] );
      $result = $this->db->query ( $createHolidayCustomSql );
      
      if ( $this->db->affected_rows != 1 ) {
        $this->view->output ( $this->model->badUserCreate ( $this->urlValues, $this->db->error ), 'User/badusercreate' );
        return;
      } else {
        $this->view->output ( $this->model->success ( ), 'User/success' );
        return;
      }
    }
    
    $this->view->output ( $this->model->create ( ), '' );
  }
}

?>
