<?php
//--------------------------------------------------------------------
// config
require 'vendor/autoload.php';
//--------------------------------------------------------------------
//collecting form data
$ename = $_POST['ename'];
$tname = $_POST['tname'];
$btnumber = $_POST['btnumber'];
$paye = $_POST['paye'];
$tin = $_POST['tin'];
$address = $_POST['address'];
$postal = $_POST['postal'];
$tax_period = $_POST['tax_period'];
$due_date = $_POST['due_date'];
$email = $_POST['email'];
$cell = $_POST['cell'];

//--------------------------------------------------------------------
//create report
$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('assets/template/temp.docx');
//--------------------------------------------------------------------
	//fill report details
	$data = array($ename, $tname, $btnumber, $paye, $tin, $address, $postal, $tax_period, $due_date, $email, $cell);
	$fields = array('ename', 'tname', 'btnumber', 'paye', 'tin', 'address', 'postal', 'tax_period', 'due_date', 'email', 'cell');
	$templateProcessor->setValue($fields, $data);
//--------------------------------------------------------------------
//saving report to reports folder
$templateProcessor->saveAs('reports/'.$ename.'.docx');
echo $ename."'s report has been saved successfully<br>";
//--------------------------------------------------------------------
?>