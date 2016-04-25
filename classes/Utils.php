<?php

/** 
 * @author tstepputtis
 * 
 */
class Utils {

  /**
   * This function generates the pagination with the given parameters and returns an array for generating the pagination template
   *
   * @param array $urlValues          
   * @param integer $total          
   * @param integer $limit          
   * @return array pagination
   */
  public static function generatePagination( $urlValues, $total, $limit = 10 ) {
    
    // How many pages will there be
    $pages = ceil ( $total / $limit );
    
    // What page are we currently on?
    $page = min ( ($pages < 1) ? 1 : $pages, (isset ( $urlValues ['page'] ) && ! empty ( $urlValues ['page'] )) ? $urlValues ['page'] : 1 );
    
    // Calculate the offset for the query
    $offset = ($page - 1) * $limit;
    
    // Some information to display to the user
    $start = $offset + 1;
    $end = min ( ($offset + $limit), $total );
    
    $pagination = array ("limit" => $limit,"pages" => ($pages < 1) ? 1 : $pages,"page" => $page,"offset" => $offset,"start" => $start,"end" => $end,"total" => $total );
    
    return $pagination;
  }

  /**
   * This function calculates the days between two dates and can leave out weekends
   *
   * @param string $start_date          
   * @param string $end_date          
   * @param bool $withoutWeekends          
   * @return number of days
   */
  public static function getNumberDays( $start_date, $end_date, $withoutWeekends = true ) {
    $startDate = new DateTime ( $start_date );
    $endDate = new DateTime ( $end_date );
    $interval = $startDate->diff ( $endDate );
    $woweekends = 0;
    for( $i = 0; $i <= $interval->d; $i ++ ) {
      $startDate->modify ( '+1 day' );
      $weekday = $startDate->format ( 'w' );
      
      if ( $weekday != 0 && $weekday != 6 || $withoutWeekends ) { // 0 for Sunday and 6 for Saturday
        $woweekends ++;
      }
    }
    
    return $woweekends;
  }
}

?>