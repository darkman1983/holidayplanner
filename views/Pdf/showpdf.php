<?php 
header('Content-type: application/pdf');
header('Content-Transfer-Encoding: binary');
echo $viewModel->get('pdfData'); ?>