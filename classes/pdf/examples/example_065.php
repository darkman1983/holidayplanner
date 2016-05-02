<?php
//============================================================+
// File name   : example_003.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 003 for TCPDF class
//               Custom Header and Footer
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Custom Header and Footer
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

	//Page header
	public function Header() {	   
	    // Logo
		$image_file = K_PATH_IMAGES.'itslogo.jpg';
		$this->Image($image_file, 25, 10, 40, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		// Set font
		$this->SetFont('arial', 'B', 20);
		// Title
		$this->Cell(120, 10, 'Urlaubsplaner - Urlaubsantrag '.date("Y", time()), 0, false, 'C', 0, '', 0, false, 'M', 'M');
	}

	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
		$this->SetY(-15);
		
		// Set font
		$this->SetFont('arial', 'I', 8);
		// Page number
		$this->Cell(0, 15, 'Version 1.0 - Seite '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	}
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Timo Stepputtis');
$pdf->SetTitle('IT-Solutions Urlaubsplaner');
$pdf->SetSubject('Urlaubsantrag '.date("Y", time()));
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT+10, PDF_MARGIN_TOP+5, PDF_MARGIN_RIGHT-30);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/ger.php')) {
	require_once(dirname(__FILE__).'/lang/ger.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('arial', 'BI', 12);

// add a page
$pdf->AddPage();

// Print a table

$html = '
<table border="1" cellspacing="0" cellpadding="4" style="width:100%">
	<tr>
      <td style="font-weight:bold;width: 8%">Name</td>
	  <td style="width: 25%">Max Mustermann</td>
      <td style="font-weight:bold">Personal-Nr.</td>
	  <td style="width: 25%">005</td>
	</tr>
    <tr>
      <td colspan="4"><table border="1" cellspacing="0" cellpadding="4" style="width:100%"><tr><td style="width: 35%">Resturlaub f&uuml;r 2015</td style="width: 15%"><td></td><td style="width: 8%">5</td><td style="width: 25%">Arbeitstage</td></tr></table></td>
	</tr>
</table>';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_065.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
