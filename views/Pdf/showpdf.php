<?php 
header('Content-type: application/pdf');
header('Content-Transfer-Encoding: binary');
header("Content-Disposition:inline;filename='".$viewModel->get("savePath")."'");

echo $viewModel->get("pdfData");
?>