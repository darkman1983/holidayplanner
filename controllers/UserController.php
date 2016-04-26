<?php

/**
 * @author tstepputtis
 *
 */
class UserController extends BaseController {

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
      $createUserSql = sprintf ( "INSERT INTO users SET firstname = '%s', lastname = '%s', username = '%s', password = '%s', email = '%s', level = '%s'", ucfirst($this->urlValues ['frm_firstname']), ucfirst($this->urlValues ['frm_lastname']), strtolower($this->urlValues ['frm_username']), sha1 ( strtolower($this->urlValues ['usrname']) . ":" . $this->urlValues ['frm_uPassword'] ), $this->urlValues ['frm_email'], $this->urlValues ['frm_userlevel'] );
      $result = $this->db->query ( $createUserSql );
      
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

  protected function edit( ) {
    if ( ! $this->checkAccess ( $this->levels ) ) {
      $this->view->output ( $this->model->notAllowed ( ), 'Error/notallowed' );
      return;
    }
    
    $dataValid = false;
    
    if ( isset ( $this->urlValues ['do'] ) && $this->urlValues ['do'] == 1 ) {
      $dataValid = true;
    }
    
    if ( $dataValid ) {
      $createUserSql = sprintf ( "UPDATE users SET firstname = '%s', lastname = '%s', username = '%s', %semail = '%s', level = '%s' WHERE id = '%s'", $this->urlValues ['frm_firstname'], $this->urlValues ['frm_lastname'], $this->urlValues ['frm_username'], ! empty ( $this->urlValues ['frm_uPassword'] ) ? sprintf ( "password = '%s', ", sha1 ( $this->urlValues ['frm_username'] . ":" . $this->urlValues ['frm_uPassword'] ) ) : '', $this->urlValues ['frm_email'] . "@" . $this->urlValues ['frm_emailDomain'], $this->urlValues ['frm_userlevel'], $this->urlValues ['userEditID'] );
      $result = $this->db->query ( $createUserSql );
      
      $this->view->output ( $this->model->success ( ), 'User/success' );
      return;
    }
    
    $this->view->output ( $this->model->edit ( $this->urlValues ), '' );
  }
}

?>
