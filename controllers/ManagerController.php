<?php

/**
 * @author Timo Stepputtis
 *
 */
class ManagerController extends BaseController {

  private $db = NULL;

  private $levels;
  
  // add to the parent constructor
  public function __construct( $action, $urlValues ) {
    parent::__construct ( $action, $urlValues );
    
    $this->levels = array ("index" => 2, "userdetails" => 2, "add" => 2, "edit" => 2, );
    
    // create the model object
    if ( ! $this->checkAccess ( $this->levels ) ) {
      $this->model = new ErrorModel ( );
    } else {
      $this->model = new ManagerModel ( );
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
  
  protected function userDetails( ) {
    if ( ! $this->checkAccess ( $this->levels ) ) {
      $this->view->output ( $this->model->notAllowed ( ), 'Error/notallowed' );
      return;
    }
    $this->view->output ( $this->model->userDetails( $this->urlValues ), '' );
  }

  protected function add( ) {
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
      $dates = explode(" - ", $this->urlValues ['frm_daterange']);
      $createUserSql = sprintf ( "INSERT INTO holiday SET employeeID = '%s', startdate = '%s', enddate = '%s', type = '%s', note = '%s', submitdate = '%s'", $this->session->get('id'), strtotime($dates[0]), strtotime($dates[1]), 'H', $this->urlValues['frm_note'], time() );
      $result = $this->db->query ( $createUserSql );

      if ( $this->db->affected_rows != 1 ) {
        $this->view->output ( $this->model->badUserCreate ( $this->urlValues, $this->db->error ), 'User/badusercreate' );
        return;
      } else {        
        $this->view->output ( $this->model->success ( ), 'Holiday/success' );
        return;
      }
    }
    
    $this->view->output ( $this->model->add ( $this->urlValues ), '' );
  }
  
  protected function edit() {
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
      $createUserSql = sprintf ( "UPDATE holiday SET response_note = '%s', processeddate = '%s', status = '%s' WHERE id = '%s'", $this->urlValues['frm_response_note'], time(), $this->urlValues['frm_status']);
      $result = $this->db->query ( $createUserSql );
    
      if ( $this->db->affected_rows != 1 ) {
        $this->view->output ( $this->model->badUserCreate ( $this->urlValues, $this->db->error ), 'User/badusercreate' );
        return;
      } else {
        $this->view->output ( $this->model->success ( ), 'Holiday/success' );
        return;
      }
    }
    
    $this->view->output ( $this->model->edit ( $this->urlValues ), '' );
  }
}

?>
