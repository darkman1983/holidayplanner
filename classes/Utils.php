<?php

/** 
 * @author Timo Stepputtis
 * 
 */
class Utils {

  /**
   * This function generates the pagination with the given parameters and returns an array for generating the pagination template
   *
   * @param integer $page          
   * @param integer $total          
   * @param integer $limit          
   * @return array pagination
   */
  public static function generatePagination( $page, $total, $limit = 10 ) {
    
    // How many pages will there be
    $pages = ceil ( $total / $limit );
    
    // What page are we currently on?
    $page = min ( ($pages < 1) ? 1 : $pages, (isset ( $page ) && ! empty ( $page )) ? $page : 1 );
    
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
    $startDate = new DateTime ( Utils::is_timestamp ( $start_date ) ? date ( "d.m.Y", $start_date ) : $start_date );
    $endDate = new DateTime ( Utils::is_timestamp ( $end_date ) ? date ( "d.m.Y", $end_date ) : $end_date );
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

  /**
   * Check wherever a Integer is a valid unixtime
   * @param integer $timestamp
   * @return boolean
   */
  public static function is_timestamp( $timestamp ) {
    if ( strtotime ( date ( 'd-m-Y H:i:s', $timestamp ) ) === ( int ) $timestamp ) {
      return true;
    }
    
    return false;
  }

  /**
   * Generates a PDF string from array data and returns it
   * @param array $pdfData
   * @return string
   */
  public static function generatePdf( $pdfData ) {
    require_once 'views/Pdf/holidaytemplate.php';
    
    $status = '';
    $checkboxes = unserialize($pdfData['extdata']);
    
    switch ($pdfData['status']) {
      case 0:
        $status = "Unbearbeitet";
        break;
      case 1:
        $status = "Nicht genehmigt";
        break;
      case 2:
        $status = "Genehmigt";
        break;
      case 3:
        $status = "Eingetragen";
        break;
    }
    
    /*print_r($pdfData);
    return;*/
    
    $currentYear = date ( "Y", $pdfData ['startdate'] );
    $lastYear = ($pdfData ['lastYearHoliday'] > 0) ? $pdfData ['maxHoliday'] + ($pdfData ['lastYearHoliday'] - $pdfData ['maxHoliday']) : $pdfData ['maxHolidayLast'];
    $html = sprintf ( $tpl,
        $currentYear,
        $pdfData ['firstname'],
        $pdfData ['lastname'],
        $pdfData ['staffid'],
        date ( "Y", strtotime ( "-1 year", $pdfData ['startdate'] ) ),
        $lastYear,
        $currentYear,
        $pdfData ['maxHoliday'] + $lastYear,
        $currentYear,
        ($pdfData ['remainingHoliday'] > $pdfData ['maxHoliday']) ? $pdfData ['maxHoliday'] : ($pdfData ['maxHoliday'] - $pdfData ['remainingHoliday']) + $lastYear,
        date ( "d.m.Y", $pdfData ['startdate'] ),
        date ( "d.m.Y", $pdfData ['enddate'] ),
        $pdfData ['days'],
        $currentYear,
        ($pdfData ['maxHoliday'] - $pdfData ['remainingHoliday'] + $lastYear -  $pdfData ['days']),
        $pdfData['note'],
        $pdfData['response_note'],
        date("d.m.Y", $pdfData['processeddate']),
        $pdfData['processedFirstname'],
        $pdfData['processedLastname'],
        $status,
        $checkboxes['sap'] ? '' : '-blank',
        $checkboxes['uue'] ? '' : '-blank',
        $checkboxes['map'] ? '' : '-blank'
        );
    
    require_once 'classes/pdf/mpdf.php';
    
    $mpdf = new mPDF ( 'c', 'A4', '', '', 32, 25, 27, 25, 26, 13 );
    
    $mpdf->title = "Urlaubsantrag";
    
    $mpdf->SetDisplayMode ( 'fullpage' );
    
    $mpdf->list_indent_first_level = 0; // 1 or 0 - whether to indent the first level of a list
    
    $header = '<div><img src="views/Assets/images/itslogo.jpg" style="width: 255px; height: 69px; float: right;"></div>';
    
    $mpdf->SetHTMLHeader ( $header );
    
    // LOAD a stylesheets
    $stylesheet2 = file_get_contents ( 'views/Assets/css/mpdfstyletables.css' );
    $mpdf->WriteHTML ( $stylesheet2, 1 ); // The parameter 1 tells that this is css/style only and no body/html/text
    
    $mpdf->WriteHTML ( $html );
    
    $savePath = sprintf ( "views/Pdf/generated/Urlaubsantrag%s%s%s.pdf", $pdfData ['id'], $pdfData ['employeeID'], date ( "dmY", $pdfData ['startdate'] ) );
    
    return $mpdf->Output ( $savePath, "S" );
  }
  
  public static function generatePdfFileName( $pdfData ) {
    return sprintf ( "Urlaubsantrag%s%s%s.pdf", $pdfData ['id'], $pdfData ['employeeID'], date ( "dmY", $pdfData ['startdate'] ) );
  }
}

?>