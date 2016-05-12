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
    
    $result->free();
    
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
      
      $pagination = Utils::generatePagination ( intval($this->urlValues['page']), $totalUsers [0] );
      $totalResult->free();
    }
    
    $getFilteredUsersSql = sprintf ( "SELECT * FROM users
        WHERE firstname LIKE '%%%s%%'
        OR lastname LIKE '%%%s%%'
        OR username = '%s'%s",
        $this->urlValues ['usersFilter'],
        $this->urlValues ['usersFilter'],
        $this->urlValues ['usersFilter'],
        empty ( $this->urlValues ['usersFilter'] ) ? sprintf ( " LIMIT %s OFFSET %s", $pagination ['limit'], $pagination ['offset'] ) : '' );
    $result = $this->db->query ( $getFilteredUsersSql );
    
    $this->viewModel->set ( "filteredUsers", $result->fetch_all ( MYSQLI_ASSOC ) );
    
    $result->free();
    
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
      
      $pagination = Utils::generatePagination ( intval($this->urlValues['page']), $totalFeastDays [0] );
      $totalResult->free();
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
    
    $getFilteredFeastDaysSql = sprintf ( "SELECT f.*, u.username FROM feastdays f
        LEFT JOIN users u ON f.userID = u.id
        WHERE u.username = '%s'
        OR (FROM_UNIXTIME(start, '%%d') = '%s'
        AND FROM_UNIXTIME(start, '%%m') = '%s'
        AND FROM_UNIXTIME(start, '%%Y') = '%s')
        OR description LIKE '%%%s%%'%s",
        $this->urlValues ['feastDaysFilter'],
        $day,
        $month,
        $year,
        $this->urlValues ['feastDaysFilter'],
        empty ( $this->urlValues ['feastDaysFilter'] ) ? sprintf ( " LIMIT %s OFFSET %s", $pagination ['limit'], $pagination ['offset'] ) : '' );
    
    $result = $this->db->query ( $getFilteredFeastDaysSql );
    
    $this->viewModel->set ( "filteredFeastDays", $result->fetch_all ( MYSQLI_ASSOC ) );
    $result->free();
    
    return $this->viewModel;
  }
  
  public function filterHolidays( ) {
    $day = '';
    $month = '';
    $year = '';
  
    if ( empty ( $this->urlValues ['holidayFilter'] ) ) {
      $getHolidayTotalSql = sprintf("SELECT COUNT(*) FROM holiday WHERE employeeID = '%s'", $this->session->get('id'));
      $totalResult = $this->db->query ( $getHolidayTotalSql );
      $totalHolidayDays = $totalResult->fetch_row ( );
  
      $pagination = Utils::generatePagination ( intval($this->urlValues['page']), $totalHolidayDays [0] );
      $totalResult->free();
    }
  
    if ( strstr ( $this->urlValues ['holidayFilter'], "." ) ) {
      $dateParts = explode ( ".", $this->urlValues ['holidayFilter'] );
  
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
    
    switch(strtolower(trim($this->urlValues ['holidayFilter']))) {
      case 'unbearbeitet':
        $sqlPart = "OR status = 0";
        break;
      case 'nicht genehmigt':
        $sqlPart = "OR status = 1";
        break;
      case 'genehmigt':
        $sqlPart = "OR status = 2";
        break;
      case 'eingetragen':
        $sqlPart = "OR status = 3";
        break;
      default:
        $sqlPart = "";
        break;
    }
  
    $getFilteredHolidaySql = sprintf ( "SELECT *, (SELECT getNumDays(startdate, enddate, 3)) AS days FROM holiday
        WHERE (
        FROM_UNIXTIME(startdate, '%%d') = '%s'
        AND FROM_UNIXTIME(startdate, '%%m') = '%s'
        AND FROM_UNIXTIME(startdate, '%%Y') = '%s'
        )
        OR
        (
        FROM_UNIXTIME(submitdate, '%%d') = '%s'
        AND FROM_UNIXTIME(submitdate, '%%m') = '%s'
        AND FROM_UNIXTIME(submitdate, '%%Y') = '%s'
        )
        OR note LIKE '%%%s%%'
        OR response_note LIKE '%%%s%%'%s%s",
        $day,
        $month,
        $year,
        $day,
        $month,
        $year,
        $this->urlValues ['holidayFilter'],
        $this->urlValues ['holidayFilter'],
        $sqlPart,
        empty ( $this->urlValues ['holidayFilter'] ) ? sprintf ( " LIMIT %s OFFSET %s", $pagination ['limit'], $pagination ['offset'] ) : '' );
    
    $result = $this->db->query ( $getFilteredHolidaySql );
  
    $this->viewModel->set ( "filteredHolidays", $result->fetch_all ( MYSQLI_ASSOC ) );
    $result->free();
  
    return $this->viewModel;
  }

  public function deleteUser( ) {
    return $this->viewModel;
  }

  public function deleteFeastDays( ) {
    return $this->viewModel;
  }
  
  public function deleteHoliday( ) {
    return $this->viewModel;
  }
}

?>
