<?php

/**
 * @author tstepputtis
 *
 */
class AjaxModel extends BaseModel {

  private $db = NULL;

  private $urlValues;

  public function __construct( $urlValues ) {
    parent::__construct ( );
    
    $this->db = Database::getInstance ( )->getCon ( );
    $this->urlValues = $urlValues;
  }
  
  // data passed to the home index view
  public function validateUser( ) {
    $checkUserSql = sprintf ( "SELECT username FROM users WHERE username = '%s'%s", $this->urlValues ['frm_username'], isset ( $this->urlValues ['userEditID'] ) ? sprintf ( " AND id <> '%s'", $this->urlValues ['userEditID'] ) : '' );
    $result = $this->db->query ( $checkUserSql );
    if ( $result->num_rows > 0 ) {
      $this->viewModel->set ( "statusCode", 418 );
      $this->viewModel->set ( "statusText", 'Username already exists!' );
    } else {
      $this->viewModel->set ( "statusCode", 200 );
      $this->viewModel->set ( "statusText", 'OK - Username is available' );
    }
    
    return $this->viewModel;
  }

  public function getLogoutTime( ) {
    return $this->viewModel;
  }

  public function filterUsers( ) {
    if ( empty ( $this->urlValues ['usersFilter'] ) ) {
      $getTotalUsersSql = "SELECT COUNT(*) FROM users";
      $totalResult = $this->db->query ( $getTotalUsersSql );
      $totalUsers = $totalResult->fetch_row ( );
      
      $pagination = Utils::generatePagination ( $this->urlValues, $totalUsers [0] );
    }
    
    $getFilteredUsersSql = sprintf ( "SELECT * FROM users WHERE firstname LIKE '%%%s%%' OR lastname LIKE '%%%s%%' OR username = '%s'%s", $this->urlValues ['usersFilter'], $this->urlValues ['usersFilter'], $this->urlValues ['usersFilter'], empty ( $this->urlValues ['usersFilter'] ) ? sprintf ( " LIMIT %s OFFSET %s", $pagination ['limit'], $pagination ['offset'] ) : '' );
    $result = $this->db->query ( $getFilteredUsersSql );
    
    $this->viewModel->set ( "filteredUsers", $result->fetch_all ( MYSQLI_ASSOC ) );
    
    return $this->viewModel;
  }

  public function filterFeastDays( ) {
    $day = '';
    $month = '';
    $year = '';
    
    if ( empty ( $this->urlValues ['feastDaysFilter'] ) ) {
      $getFeastDaysTotalSql = "SELECT COUNT(*) FROM feastdays";
      $totalResult = $this->db->query ( $getFeastDaysTotalSql );
      $totalFeastDays = $totalResult->fetch_row ( );
      
      $pagination = Utils::generatePagination ( $this->urlValues, $totalFeastDays [0] );
    }
    
    if ( strstr ( $this->urlValues ['feastDaysFilter'], "." ) ) {
      $dateParts = explode ( ".", $this->urlValues ['feastDaysFilter'] );
      
      for( $i = 0; $i < count ( $dateParts ); $i ++ ) {
        switch ( $i ) {
          case 0 :
            $day = $dateParts [$i];
            break;
          case 1 :
            $month = $dateParts [$i];
            break;
          case 2 :
            $year = $dateParts [$i];
            break;
        }
      }
    }
    
    $getFilteredFeastDaysSql = sprintf ( "SELECT f.*, u.username FROM feastdays f LEFT JOIN users u ON f.userID = u.id  WHERE u.username = '%s' OR (FROM_UNIXTIME(start, '%%d') = '%s' AND FROM_UNIXTIME(start, '%%m') = '%s' AND FROM_UNIXTIME(start, '%%Y') = '%s') OR description LIKE '%%%s%%'%s", $this->urlValues ['feastDaysFilter'], $day, $month, $year, $this->urlValues ['feastDaysFilter'], empty ( $this->urlValues ['feastDaysFilter'] ) ? sprintf ( " LIMIT %s OFFSET %s", $pagination ['limit'], $pagination ['offset'] ) : '' );
    $result = $this->db->query ( $getFilteredFeastDaysSql );
    
    $this->viewModel->set ( "filteredFeastDays", $result->fetch_all ( MYSQLI_ASSOC ) );
    
    return $this->viewModel;
  }

  public function deleteUser( ) {
    return $this->viewModel;
  }

  public function deleteFeastDays( ) {
    return $this->viewModel;
  }
}

?>
