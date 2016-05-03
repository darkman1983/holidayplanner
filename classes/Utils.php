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

  public static function is_timestamp( $timestamp ) {
    if ( strtotime ( date ( 'd-m-Y H:i:s', $timestamp ) ) === ( int ) $timestamp ) {
      return true;
    }
    
    return false;
  }

  public static function generatePdf( $pdfData ) {
    $currentYear = date ( "Y", $pdfData ['startdate'] );
    $lastYear = ($pdfData ['lastYearHoliday'] > 0) ? $pdfData ['maxHoliday'] + ($pdfData ['lastYearHoliday'] - $pdfData ['maxHoliday']) : 0;
    $html = sprintf ( '
<head>
<style type="text/css">
h1 {
    font-family: Arial !important;
}
table {
    font-family: Arial !important;
    font-size: 14px;
}
table .table-border-outer tr:nth-child(-n+3) {
    border: 1px solid #000;
}
table .table-border-outer tr:nth-child(5) {
    border: 0 !important;
    border-top: 3px groove #000 !important;
}
table .table-border-outer tr td  {
    height: 30px;
    vertical-align: middle;
}
.underline {
    border-bottom-width: 1px;
    border-bottom-style: solid;
    border-bottom-color: #000;
}
.tr-top-border {
    border-top: 2px solid red !important;
}
.text-bold {
	font-weight: bold;
}
.table-border-outer {
	border: 2px solid #000;
}
.table-top-margin10 {
    margin-top: 10px;
    }
.table-top-margin20 {
    margin-top: 20px;
}
</style>
</head>
<body>
    <br><br><br><br>
    <h2 style="text-align: center;">Urlaubsantrag %s</h2>
<table width="100%%" class="table-top-margin10">
  <tr>
    <td width="12%%" class="text-bold">Name:</td>
    <td width="40%%" class="underline">%s %s</td>
    <td width="20%%" class="text-bold">Personal-Nr.:</td>
    <td width="30%%" class="underline">%s</td>
  </tr>
  <tr>
    <td colspan="4"><table width="100%%" border="0" cellspacing="6" cellpadding="6" class="table-border-outer table-top-margin20">
      <tr>
        <td colspan="4">Resturlaub für %s</td>
        <td width="10%%">&nbsp;</td>
        <td width="20%%" align="right">%s</td>
        <td width="15%%" align="right">Arbeitstage</td>
      </tr>
      <tr>
        <td colspan="4">Urlaubsanspruch für %s</td>
        <td>&nbsp;</td>
        <td align="right">%s</td>
        <td align="right">Arbeitstage</td>
      </tr>
      <tr>
        <td colspan="4">Noch verfügbar für %s</td>
        <td>&nbsp;</td>
        <td align="right">%s</td>
        <td align="right">Arbeitstage</td>
      </tr>
      <tr>
        <td width="15%%">Urlaub vom</td>
        <td width="15%%">%s</td>
        <td width="9%%" align="center">bis</td>
        <td width="15%%">%s</td>
        <td>&nbsp;</td>
        <td align="right">%s</td>
        <td align="right">Arbeitstage</td>
      </tr>
      <tr class="tr-top-border">
        <td colspan="4">Resturlaub für %s</td>
        <td>&nbsp;</td>
        <td align="right">%s</td>
        <td align="right">Arbeitstage</td>
      </tr>
    </table></td>
  </tr>
  <tr>
  <td colspan="4">&nbsp;</td>
  </tr>
</table>
</body>
',
        $currentYear,
        $pdfData ['firstname'],
        $pdfData ['lastname'],
        $pdfData ['employeeID'],
        date ( "Y", strtotime ( "-1 year", $pdfData ['startdate'] ) ),
        $lastYear,
        $currentYear,
        $pdfData ['maxHoliday'] + $lastYear,
        $currentYear,
        ($pdfData ['remainingHoliday'] > $pdfData ['maxHoliday']) ? $pdfData ['maxHoliday'] : ($pdfData ['maxHoliday'] - $pdfData ['remainingHoliday']) + $pdfData['days'] + $lastYear,
        date ( "d.m.Y", $pdfData ['startdate'] ),
        date ( "d.m.Y", $pdfData ['enddate'] ),
        $pdfData ['days'],
        $currentYear,
        $pdfData ['maxHoliday'] - $pdfData ['remainingHoliday'] + $lastYear );
    
    require_once 'classes/pdf/mpdf.php';
    
    $mpdf = new mPDF ( 'c', 'A4', '', '', 32, 25, 27, 25, 26, 13 );
    
    $mpdf->title = "Urlaubsantrag";
    
    $mpdf->SetDisplayMode ( 'fullpage' );
    
    $mpdf->list_indent_first_level = 0; // 1 or 0 - whether to indent the first level of a list
    
    $header = '<div><img src="views/Assets/images/itslogo.jpg" style="width: 255px; height: 69px; float: right;"></div>';
    
    $mpdf->SetHTMLHeader ( $header );
    
    // LOAD a stylesheet
    $stylesheet = file_get_contents ( 'views/Assets/css/mpdfstyletables.css' );
    $mpdf->WriteHTML ( $stylesheet, 1 ); // The parameter 1 tells that this is css/style only and no body/html/text
    
    $mpdf->WriteHTML ( $html );
    
    $savePath = sprintf ( "views/Pdf/generated/Urlaubsantrag%s%s%s.pdf", $pdfData ['id'], $pdfData ['employeeID'], date ( "dmY", $pdfData ['startdate'] ) );
    
    return $mpdf->Output ( $savePath, "S" );
  }

  public static function getPdfSavePath( $pdfData ) {
    return sprintf ( "views/Pdf/generated/Urlaubsantrag%s%s%s.pdf", $pdfData ['id'], $pdfData ['employeeID'], date ( "dmY", $pdfData ['startdate'] ) );
  }
}

?>