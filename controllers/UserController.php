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
    if ( ! $this->checkAccess ( $this->levels ) && ! in_array ( $this->action, array ("create","edit" ) ) ) {
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
      $this->view->output ( $this->model->error ( 'NOACCESSEXPIRED' ), 'User/error' );
      return;
    }
    
    $dataValid = false;
    
    if ( isset ( $this->urlValues ['do'] ) && $this->urlValues ['do'] == 1 ) {
      foreach ( $this->urlValues as $key => &$data ) {
        if ( strstr ( $data, "frm_" ) && empty ( $data ) ) {
          $this->view->output ( $this->model->error ( 'NOTCOMPLETE' ), 'User/error' );
          return;
        } else {
          $dataValid = true;
        }
      }
    }
    
    if ( $dataValid ) {
      $createUserSql = sprintf ( "INSERT INTO users SET staffid = '%s', firstname = '%s', lastname = '%s', username = '%s', password = '%s', email = '%s', level = '%s'", $this->urlValues ['frm_staffid'], ucfirst ( $this->urlValues ['frm_firstname'] ), ucfirst ( $this->urlValues ['frm_lastname'] ), strtolower ( $this->urlValues ['frm_username'] ), sha1 ( strtolower ( $this->urlValues ['frm_username'] ) . ":" . $this->urlValues ['frm_uPassword'] ), $this->urlValues ['frm_email'], $this->urlValues ['frm_userlevel'] );
      $result = $this->db->query ( $createUserSql );
      
      if ( $this->db->affected_rows != 1 ) {
        $this->view->output ( $this->model->error ( 'NOTHINGINSERTED' ), 'User/error' );
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
      $this->view->output ( $this->model->error ( 'NOACCESSEXPIRED' ), 'User/error' );
      return;
    }
    
    $dataValid = false;
    
    if ( isset ( $this->urlValues ['do'] ) && $this->urlValues ['do'] == 1 ) {
      $dataValid = true;
    }
    
    if ( $dataValid ) {
      $createUserSql = sprintf ( "UPDATE users SET firstname = '%s', lastname = '%s', username = '%s', %semail = '%s', level = '%s' WHERE id = '%s'", $this->urlValues ['frm_firstname'], $this->urlValues ['frm_lastname'], $this->urlValues ['frm_username'], ! empty ( $this->urlValues ['frm_uPassword'] ) ? sprintf ( "password = '%s', ", sha1 ( $this->urlValues ['frm_username'] . ":" . $this->urlValues ['frm_uPassword'] ) ) : '', $this->urlValues ['frm_email'], $this->urlValues ['frm_userlevel'], $this->urlValues ['userEditID'] );
      $result = $this->db->query ( $createUserSql );
      $createAffected = $this->db->affected_rows;
      $mhyAffected = 0;
      
      $mhyParts = '';
      $years = @$this->urlValues ['frm_years'];
      $days = @$this->urlValues ['frm_maxHolidays'];
      
      if ( isset ( $years ) && ! empty ( $years ) ) {
        for( $i = 0; $i < count ( $years ); $i ++ ) {
          $mhyParts .= sprintf ( "('%s', '%s', '%s'),", $this->urlValues ['userEditID'], $days [$i], $years [$i] );
        }
        
        $mhyDeleteSql = sprintf ( "DELETE FROM mhy WHERE employeeID = '%s'", $this->urlValues ['userEditID'] );
        $result = $this->db->query ( $mhyDeleteSql );
        
        $mhyInsertSql = sprintf ( "INSERT INTO mhy VALUES %s", substr ( $mhyParts, 0, - 1 ) );
        $result = $this->db->query ( $mhyInsertSql );
        $mhyAffected = $this->db->affected_rows;
      }
      
      if ( $createAffected != 1 && $mhyAffected < 1 ) {
        $this->view->output ( $this->model->error ( 'NOTHINGUPDATED' ), 'User/error' );
        return;
      }
      
      $this->view->output ( $this->model->success ( ), 'User/success' );
      return;
    }
    
    $this->view->output ( $this->model->edit ( $this->urlValues ), '' );
  }
}

?>
