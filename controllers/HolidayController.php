<?php

/**
 * @author tstepputtis
 *
 */
class HolidayController extends BaseController {

  private $db = NULL;

  private $levels;
  
  // add to the parent constructor
  public function __construct( $action, $urlValues ) {
    parent::__construct ( $action, $urlValues );
    
    $this->levels = array ("index" => 1,"propose" => 1 );
    
    // create the model object
    if ( ! $this->checkAccess ( $this->levels ) ) {
      $this->model = new ErrorModel ( );
    } else {
      $this->model = new HolidayModel ( );
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

  protected function propose( ) {
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
      
      $checkDateRangeSql = sprintf("SELECT COUNT(*) FROM holiday h WHERE h.employeeID = %s AND (FROM_UNIXTIME(%s, '%%Y-%%m-%%d') BETWEEN FROM_UNIXTIME(startdate, '%%Y-%%m-%%d') AND FROM_UNIXTIME(enddate, '%%Y-%%m-%%d') OR FROM_UNIXTIME(%s, '%%Y-%%m-%%d') BETWEEN FROM_UNIXTIME(startdate, '%%Y-%%m-%%d') AND FROM_UNIXTIME(enddate, '%%Y-%%m-%%d'))", $this->session->get('id'), strtotime($dates[0]), strtotime($dates[1]));
      $result = $this->db->query ( $checkDateRangeSql );
      $resultsets = $result->fetch_all ( MYSQLI_NUM );
      
      if($resultsets[0][0] > 0) {
        $this->view->output ( $this->model->databaseError ( 1062 ), 'Holiday/databaseerror' );
        return;
      }
      
      $resultsets->free();
      
      $createProposeSql = sprintf ( "INSERT INTO holiday SET employeeID = '%s', startdate = '%s', enddate = '%s', type = '%s', note = '%s', submitdate = '%s'", $this->session->get('id'), strtotime($dates[0]), strtotime($dates[1]), 'H', $this->urlValues['frm_note'], time() );
      $result = $this->db->query ( $createProposeSql );

      if ( $this->db->affected_rows != 1 ) {
        $this->view->output ( $this->model->databaseError ( $this->db->errno ), 'Holiday/databaseerror' );
        return;
      } else {        
        $this->view->output ( $this->model->success ( ), 'Holiday/success' );
        return;
      }
    }
    
    $this->view->output ( $this->model->propose ( ), '' );
  }
}

?>
