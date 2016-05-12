<?php

/**
 * @author tstepputtis
 *
 */
class LoginModel extends BaseModel {

  private $db = NULL;

  private $urlValues = array ();

  public function __construct( $urlValues ) {
    parent::__construct ( );
    
    $this->db = Database::getInstance ( )->getCon ( );
    $this->urlValues = $urlValues;
    
    $this->viewModel->set ( "pageTitle", "It-Solutions Urlaubsplaner :: Login" );
  }
  // data passed to the home index view
  public function index( ) {
    return $this->viewModel;
  }

  public function login( ) {
    if ( isset ( $this->urlValues ['usrname'] ) && isset ( $this->urlValues ['psw'] ) ) {
      $loginCheck_SQL = sprintf ( "SELECT * FROM users WHERE username = '%s' AND password = '%s'", strtolower ( $this->urlValues ['usrname'] ), sha1 ( strtolower ( $this->urlValues ['usrname'] ) . ':' . $this->urlValues ['psw'] ) );
      $result = $this->db->query ( $loginCheck_SQL );
      
      if ( $result->num_rows > 0 ) {
        $resultset = $result->fetch_all ( MYSQLI_ASSOC );
        
        $this->session->set ( 'id', $resultset [0] ['id'] );
        $this->session->set ( 'firstname', $resultset [0] ['firstname'] );
        $this->session->set ( 'lastname', $resultset [0] ['lastname'] );
        $this->session->set ( 'email', $resultset [0] ['email'] );
        $this->session->set ( 'level', $resultset [0] ['level'] );
        $this->session->set ( 'loggedIN', true );
        
        $this->viewModel->set ( "loggedIN", true );
        $this->viewModel->set ( "status", 1 );
      } else {
        $this->viewModel->set ( "status", 0 );
        $this->session->destroy ( );
        $this->session = Session::getInstance ( );
      }
    }
    
    return $this->viewModel;
  }

  public function logout( ) {
    $this->session->destroy ( );
    
    return $this->viewModel;
  }
}

?>
