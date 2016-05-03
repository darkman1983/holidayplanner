<?php

/**
 * @author tstepputtis
 *
 */
class PdfModel extends BaseModel {

  private $db = NULL;

  public function __construct( ) {
    parent::__construct ( );
    
    $this->db = Database::getInstance ( )->getCon ( );
  }
  
  // data passed to the home index view
  public function showPdf( $urlValues ) {
    $getPdfDataSql = sprintf ( "SELECT h.*, u.id, u.firstname, u.lastname, u.remainingHoliday, u.maxHoliday, (SELECT getNumDays(h.startdate, h.enddate, 3)) AS days FROM holiday h JOIN users u ON h.employeeID = u.id WHERE h.id = %s", intval ( $urlValues ['pdfID'] ) );
    
    $resultQuery = $this->db->query ( $getPdfDataSql, MYSQLI_ASSOC );
    $result = $resultQuery->fetch_all ( MYSQLI_ASSOC );
    
    $currentYear = date ( "Y", time ( ) );
    $html = sprintf ( '
<head>
<style type="text/css">
h1 {
    font-family: Arial;
}
table {
    font-family: Arial;
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
', $currentYear, $result[0]['firstname'], $result[0]['lastname'], $result[0]['employeeID'], date ( "Y", strtotime ( "-1 year", time ( ) ) ), ($result[0]['remainingHoliday'] > $result[0]['maxHoliday']) ? $result[0]['remainingHoliday'] - $result[0]['maxHoliday'] : 0, $currentYear, $result[0]['maxHoliday'], $currentYear, ($result[0]['remainingHoliday'] > $result[0]['maxHoliday']) ? $result[0]['maxHoliday'] : $result[0]['remainingHoliday'], date("d.m.Y", $result[0]['startdate']), date("d.m.Y", $result[0]['enddate']), $result[0]['days'], $currentYear, $result[0]['remainingHoliday'] - $result[0]['days'] );
    
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
    
    $this->viewModel->set ( "pdfData", $mpdf->Output ( "Urlaubsantrag.pdf", "S" ) );
    
    return $this->viewModel;
  }
}

?>
