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
  
  public function validateStaffId( ) {
    $checkUserSql = sprintf ( "SELECT username FROM users WHERE staffid = '%s'", $this->urlValues ['frm_staffid'] );
    $result = $this->db->query ( $checkUserSql );
    if ( $result->num_rows > 0 || !is_numeric($this->urlValues ['frm_staffid']) ) {
      $this->viewModel->set ( "statusCode", 418 );
      $this->viewModel->set ( "statusText", 'Personalnummer existiert schon!' );
    } else {
      $this->viewModel->set ( "statusCode", 200 );
      $this->viewModel->set ( "statusText", 'OK - Personalnummer ist frei.' );
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
      
      $pagination = Utils::generatePagination ( intval(@$this->urlValues['page']), $totalFeastDays [0] );
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
        OR (FROM_UNIXTIME(date, '%%d') = '%s'
        AND FROM_UNIXTIME(date, '%%m') = '%s'
        AND FROM_UNIXTIME(date, '%%Y') = '%s')
        OR description LIKE '%%%s%%'%s",
        $this->urlValues ['feastDaysFilter'],
        $day,
        $month,
        $year,
        $this->urlValues ['feastDaysFilter'],
        empty ( $this->urlValues ['feastDaysFilter'] ) ? sprintf ( " LIMIT %s OFFSET %s", $pagination ['limit'], $pagination ['offset'] ) : '' );
    
    $result = $this->db->query ( $getFilteredFeastDaysSql );
    
    $this->viewModel->set ( "filteredFeastDays", @$result->fetch_all ( MYSQLI_ASSOC ) );
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
  
      $pagination = Utils::generatePagination ( intval(@$this->urlValues['page']), $totalHolidayDays [0] );
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
        $sqlPart = " OR status = 0";
        break;
      case 'nicht genehmigt':
        $sqlPart = " OR status = 1";
        break;
      case 'genehmigt':
        $sqlPart = " OR status = 2";
        break;
      case 'eingetragen':
        $sqlPart = " OR status = 3";
        break;
      default:
        $sqlPart = "";
        break;
    }
  
    $getFilteredHolidaySql = sprintf ( "SELECT *, (SELECT getNumDays(startdate, enddate, 3)) AS days FROM holiday
        WHERE employeeID = '%s' AND ((
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
        OR response_note LIKE '%%%s%%'%s)%s",
        $this->session->get('id'),
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
  
    $this->viewModel->set ( "filteredHolidays", @$result->fetch_all ( MYSQLI_ASSOC ) );
    $result->free();
  
    return $this->viewModel;
  }
  
  public function filterManagerHolidays( ) {  
    if ( empty ( $this->urlValues ['managerHolidaysFilter'] ) ) {
      $getHolidayTotalSql = sprintf("SELECT COUNT(*) FROM holiday WHERE employeeID = '%s'", $this->session->get('id'));
      $totalResult = $this->db->query ( $getHolidayTotalSql );
      $totalHolidayDays = $totalResult->fetch_row ( );
  
      $pagination = Utils::generatePagination ( intval(@$this->urlValues['page']), $totalHolidayDays [0] );
      $totalResult->free();
    }
    
    $getFilteredHolidaySql = sprintf ( "SELECT u.*,
        (SELECT COUNT(*) FROM holiday WHERE employeeID = u.id AND status = 0) as notProcessed,
        (SELECT COUNT(*) FROM holiday WHERE employeeID = u.id) as allProposals,
        (SELECT COALESCE(SUM(maxHoliday), 0) FROM mhy WHERE year = YEAR(CURRENT_DATE) AND employeeID = u.id) as maxHoliday,
        (SELECT COALESCE(SUM(`getNumDays`(ho.startdate, ho.enddate, 3)), (SELECT COALESCE(SUM(maxHoliday), 0) FROM mhy WHERE year = YEAR(CURRENT_DATE) AND employeeID = u.id)) FROM holiday ho WHERE ho.employeeID = u.id AND ho.type = 'H' AND status != 1 AND FROM_UNIXTIME(ho.startdate, '%%Y') = YEAR(CURRENT_DATE)) - (SELECT COALESCE(SUM(`getNumDays`(ho.startdate, ho.enddate, 3)), 0) FROM holiday ho WHERE ho.employeeID = u.id AND ho.type = 'I' AND FROM_UNIXTIME(ho.startdate, '%%Y') = YEAR(CURRENT_DATE)) AS remainingHoliday
        FROM users u
        WHERE u.staffid LIKE '%%%s%%' OR u.firstname LIKE '%%%s%%' OR u.lastname LIKE '%%%s%%'%s",
        $this->urlValues ['managerHolidaysFilter'],
        $this->urlValues ['managerHolidaysFilter'],
        $this->urlValues ['managerHolidaysFilter'],
        empty ( $this->urlValues ['managerHolidaysFilter'] ) ? sprintf ( " LIMIT %s OFFSET %s", $pagination ['limit'], $pagination ['offset'] ) : '' );
  
    $result = $this->db->query ( $getFilteredHolidaySql );
  
    $this->viewModel->set ( "filteredManagerHolidays", @$result->fetch_all ( MYSQLI_ASSOC ) );
    $result->free();
  
    return $this->viewModel;
  }
  
  public function filterManagerUserDetails( ) {
    $day = '';
    $month = '';
    $year = '';
  
    if ( empty ( $this->urlValues ['managerUserDetailsFilter'] ) ) {
      $getHolidayTotalSql = sprintf("SELECT COUNT(*) FROM holiday WHERE employeeID = '%s'", $this->session->get('id'));
      $totalResult = $this->db->query ( $getHolidayTotalSql );
      $totalHolidayDays = $totalResult->fetch_row ( );
  
      $pagination = Utils::generatePagination ( intval(@$this->urlValues['page']), $totalHolidayDays [0] );
      $totalResult->free();
    }
  
    if ( strstr ( $this->urlValues ['managerUserDetailsFilter'], "." ) ) {
      $dateParts = explode ( ".", $this->urlValues ['managerUserDetailsFilter'] );
  
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
  
    switch ( strtolower ( trim ( $this->urlValues ['managerUserDetailsFilter'] ) ) ) {
      case 'unbearbeitet' :
        $sqlPart = " OR h.status = 0";
        break;
      case 'nicht genehmigt' :
        $sqlPart = " OR h.status = 1";
        break;
      case 'genehmigt' :
        $sqlPart = " OR h.status = 2";
        break;
      case 'eingetragen' :
        $sqlPart = " OR h.status = 3";
        break;
      case 'urlaub' :
        $sqlPart = " OR h.type = 'H'";
        break;
      case 'krankheit' :
        $sqlPart = " OR h.type = 'I'";
        break;
      default :
        $sqlPart = "";
        break;
    }
    
    $getFilteredHolidaySql = sprintf ( "SELECT h.*, u.firstname, u.lastname,
        (SELECT COALESCE(SUM(`getNumDays`(ho.startdate, ho.enddate, 3)), 0) FROM holiday ho WHERE ho.employeeID = h.employeeID AND ho.type = 'H' AND FROM_UNIXTIME(ho.startdate, '%%Y') = FROM_UNIXTIME(%s, '%%Y')) - (SELECT COALESCE(SUM(`getNumDays`(ho.startdate, ho.enddate, 3)), 0) FROM holiday ho WHERE ho.employeeID = h.employeeID AND ho.type = 'I' AND FROM_UNIXTIME(ho.startdate, '%%Y') = FROM_UNIXTIME(%s, '%%Y')) AS remainingHoliday,
        (SELECT getNumDays(h.startdate, h.enddate, 3)) AS days
        FROM holiday h JOIN users u ON h.employeeID = u.id WHERE h.employeeID = '%s' AND
        ((
        FROM_UNIXTIME(h.startdate, '%%d') = '%s'
        AND FROM_UNIXTIME(h.startdate, '%%m') = '%s'
        AND FROM_UNIXTIME(h.startdate, '%%Y') = '%s'
        )
        OR
        (
        FROM_UNIXTIME(h.submitdate, '%%d') = '%s'
        AND FROM_UNIXTIME(h.submitdate, '%%m') = '%s'
        AND FROM_UNIXTIME(h.submitdate, '%%Y') = '%s'
        )
        OR h.note LIKE '%%%s%%'
        OR h.response_note LIKE '%%%s%%'%s)%s",
        time ( ),
        time ( ),
        $this->urlValues ['userID'],
        $day,
        $month,
        $year,
        $day,
        $month,
        $year,
        $this->urlValues ['managerUserDetailsFilter'],
        $this->urlValues ['managerUserDetailsFilter'],
        $sqlPart,
        empty ( $this->urlValues ['managerUserDetailsFilter'] ) ? sprintf ( " LIMIT %s OFFSET %s", $pagination ['limit'], $pagination ['offset'] ) : '' );
  
    $result = $this->db->query ( $getFilteredHolidaySql );
  
    $this->viewModel->set ( "userHolidayData", @$result->fetch_all ( MYSQLI_ASSOC ) );
    $result->free();
    
    $getMaxHolidaySql = sprintf ( "SELECT maxHoliday FROM mhy WHERE year = FROM_UNIXTIME(%s, '%%Y') AND employeeID = '%s'", time ( ), $this->urlValues ['userID'] );
    $result = $this->db->query ( $getMaxHolidaySql );
    $resultsets = $result->fetch_all ( MYSQLI_ASSOC );
    
    $this->viewModel->set ( "maxHolidays", @$resultsets [0] ['maxHoliday'] );
    $this->viewModel->set ( 'uid', $this->urlValues ['userID'] );
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
