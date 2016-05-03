<?php
$currentYear = date("Y", time());
$html = sprintf('
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
    <td width="40%%" class="underline">Max Mustermann</td>
    <td width="20%%" class="text-bold">Personal-Nr.:</td>
    <td width="30%%" class="underline">005</td>
  </tr>
  <tr>
    <td colspan="4"><table width="100%%" border="0" cellspacing="6" cellpadding="6" class="table-border-outer table-top-margin20">
      <tr>
        <td colspan="4">Resturlaub für %s</td>
        <td width="10%%">&nbsp;</td>
        <td width="20%%" align="right">5</td>
        <td width="15%%" align="right">Arbeitstage</td>
      </tr>
      <tr>
        <td colspan="4">Urlaubsanspruch für %s</td>
        <td>&nbsp;</td>
        <td align="right">30</td>
        <td align="right">Arbeitstage</td>
      </tr>
      <tr>
        <td colspan="4">Noch verfügbar für %s</td>
        <td>&nbsp;</td>
        <td align="right">25</td>
        <td align="right">Arbeitstage</td>
      </tr>
      <tr>
        <td width="15%%">Urlaub vom</td>
        <td width="15%%">14.04.2016</td>
        <td width="9%%" align="center">bis</td>
        <td width="15%%">16.04.2016</td>
        <td>&nbsp;</td>
        <td align="right">2</td>
        <td align="right">Arbeitstage</td>
      </tr>
      <tr class="tr-top-border">
        <td colspan="4">Resturlaub für %s</td>
        <td>&nbsp;</td>
        <td align="right">23</td>
        <td align="right">Arbeitstage</td>
      </tr>
    </table></td>
  </tr>
  <tr>
  <td colspan="4">&nbsp;</td>
  </tr>
</table>
</body>
', $currentYear, date("Y", strtotime("-1 year" , time())), $currentYear, $currentYear, $currentYear);

// ==============================================================
// ==============================================================
// ==============================================================
include ("../mpdf.php");

$mpdf = new mPDF('c', 'A4', '', '', 32, 25, 27, 25, 26, 13);

$mpdf->title = "Urlaubsantrag";

$mpdf->SetDisplayMode('fullpage');

$mpdf->list_indent_first_level = 0; // 1 or 0 - whether to indent the first level of a list

$header = '<div><img src="itslogo.jpg" style="width: 255px; height: 69px; float: right;"></div>';

$mpdf->SetHTMLHeader($header);
                                    
// LOAD a stylesheet
$stylesheet = file_get_contents('mpdfstyletables.css');
$mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text

$mpdf->WriteHTML($html);

$mpdf->Output("Urlaubsantrag.pdf", "I");
exit();

?>