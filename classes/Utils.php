<?php

/** 
 * @author tstepputtis
 * 
 */
class Utils {

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