<?php

$tpl = '
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
.middle {
    vertical-align: middle;
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
        <td width="10%%" align="center">bis</td>
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
  <tr>
  <td colspan="4" style="font-weight: bold;">Anmerkung</td>
  </tr>
  <tr>
  <td colspan="4">%s</td>
  </tr>
  <tr>
  <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
  <td colspan="4" style="font-weight: bold;">Rückmeldung</td>
  </tr>
  <tr>
  <td colspan="4">%s</td>
  </tr>
  <tr>
  <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><table width="100%%" border="0" cellspacing="6" cellpadding="6">
      <tr>
        <td width="180px">Geändert am %s:</td>
        <td class="underline">%s %s</td>
        <td width="40px">auf</td>
        <td width="130px">%s</td>
      </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="4"><table width="100%%" border="0" cellspacing="4" cellpadding="4">
      <tr>
        <td width="33%%"><img src="views/Assets/images/check-box-outline%s.png" style="width: 16px; height: 16px"> SAP HMC erledigt</td>
        <td width="33%%"><img src="views/Assets/images/check-box-outline%s.png" style="width: 16px; height: 16px"> Urlaubsübersicht</td>
        <td width="33%%"><img src="views/Assets/images/check-box-outline%s.png" style="width: 16px; height: 16px"> Karte</td>
      </tr>
    <tr></table></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>';

?>