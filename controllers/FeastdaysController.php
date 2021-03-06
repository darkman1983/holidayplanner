<?php

/**
 * The FeastDaysController processes all data related to fest days
 * 
 * @author tstepputtis
 *
 */
class FeastdaysController extends BaseController {

  /**
   * @var resource
   */
  private $db = NULL;

  /**
   * @var array
   */
  private $levels;
  
  public function __construct( $action, $urlValues ) {
    parent::__construct ( $action, $urlValues );
    
    $this->levels = array ("index" => 1,"create" => 3,"edit" => 3 );
    
    // create the model object
    if ( ! $this->checkAccess ( $this->levels ) && ! in_array ( $this->action, array ('create','edit' ) ) ) {
      $this->model = new ErrorModel ( );
    } else {
      $this->model = new FeastDaysModel ( );
    }
    
    $this->db = Database::getInstance ( )->getCon ( );
  }
  
  /**
   * Sets the index output
   */
  protected function index( ) {
    if ( ! $this->checkAccess ( $this->levels ) ) {
      $this->view->output ( $this->model->notAllowed ( ), 'Error/notallowed' );
      return;
    }
    
    $this->view->output ( $this->model->index ( $this->urlValues ), '' );
  }

  /**
   * Creates a feastday and sets the create output
   */
  protected function create( ) {
    if ( ! $this->checkAccess ( $this->levels ) ) {
      $this->view->output ( $this->model->error ( 'NOACCESSEXPIRED' ), 'Feastdays/error' );
      return;
    }
    
    $dataValid = false;
    
    if ( isset ( $this->urlValues ['do'] ) && $this->urlValues ['do'] == 1 ) {
      foreach ( $this->urlValues as $key => &$data ) {
        if ( strstr ( $data, "frm_" ) && empty ( $data ) ) {
          $this->view->output ( $this->model->error ( 'NOTCOMPLETE' ), 'Feastdays/error' );
          return;
        } else {
          $dataValid = true;
        }
      }
    }
    
    if ( $dataValid ) {
      $checkDateRangeSql = sprintf ( "SELECT COUNT(*) FROM feastdays f WHERE FROM_UNIXTIME(f.date, '%%Y-%%m-%%d') = FROM_UNIXTIME(%s, '%%Y-%%m-%%d')", strtotime ( $this->urlValues ['frm_date'] ) );
      $result = $this->db->query ( $checkDateRangeSql );
      $resultsets = $result->fetch_all ( MYSQLI_NUM );
      
      if ( $resultsets [0] [0] > 0 ) {
        $this->view->output ( $this->model->error ( 'DUPLICATE' ), 'Feastdays/error' );
        return;
      }
      
      $resultsets->free ( );
      
      $createFeastDaysSql = sprintf ( "INSERT INTO feastdays SET userID = '%s', date = '%s', description = '%s'", $this->session->get ( 'id' ), strtotime ( $this->urlValues ['frm_date'] ), $this->urlValues ['frm_description'] );
      $result = $this->db->query ( $createFeastDaysSql );
      
      if ( $this->db->affected_rows != 1 ) {
        $this->view->output ( $this->model->error ( 'NOTHINGINSERTED' ), 'Feastdays/error' );
        return;
      } else {
        $this->view->output ( $this->model->success ( ), 'Feastdays/success' );
        return;
      }
    }
    
    $this->view->output ( $this->model->create ( ), '' );
  }

  /**
   * Processes the edited data, updates the database and sets the output
   */
  protected function edit( ) {
    if ( ! $this->checkAccess ( $this->levels ) ) {
      $this->view->output ( $this->model->error ( 'NOACCESSEXPIRED' ), 'Feastdays/error' );
      return;
    }
    
    $dataValid = false;
    
    if ( isset ( $this->urlValues ['do'] ) && $this->urlValues ['do'] == 1 ) {
      $dataValid = true;
    }
    
    if ( $dataValid ) {
      $editFestDaysSql = sprintf ( "UPDATE feastdays SET date = '%s', description = '%s' WHERE id = '%s'", strtotime ( $this->urlValues ['frm_date'] ), $this->urlValues ['frm_description'], $this->urlValues ['feastDaysEditID'] );
      $result = $this->db->query ( $editFestDaysSql );
      
      if ( $this->db->affected_rows != 1 ) {
        $this->view->output ( $this->model->error ( 'NOTHINGUPDATED' ), 'Feastdays/error' );
        return;
      }
      
      $this->view->output ( $this->model->success ( ), 'Feastdays/success' );
      return;
    }
    
    $this->view->output ( $this->model->edit ( $this->urlValues ), '' );
  }
}

?>
