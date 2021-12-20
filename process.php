<?php
session_start();
require 'vendor/autoload.php';
//--------------------------------------------------------------------

//OBJECTIVES
//1.provide a way for the client to submit a payroll excel file and provide details
//2. read the excel file to extract the nessesary data
//3. process the data by the use of mathematical calculations
//4. write the output on to a F2 report

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
$file = $_FILES['file'];

//--------------------------------------------------------------------
//a costom function that takes the excel file as input and stores it on the server, it returns path to the file and an error message if available 

function handleFile($file){
$target_file = 0;
$target_dir = "uploads/";
$target_file = $target_dir . basename($file["name"]);
$uploadOk = 1;
$msg = '';
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
array_map('unlink', glob($target_file)); 

// Check if file already exists
if (file_exists($target_file)) {
  $msg = "file upload error, please try again.";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "xlsx" ) {
  $msg = "Sorry, only excel files are allowed.";
  $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
return array(0, $msg);
// if everything is ok, try to upload file
}
else{
  if (move_uploaded_file($file["tmp_name"], $target_file)) {
	$msg = $file["name"].' was uploaded';
	return array($target_file, $msg);
  } else {
    $msg = "Sorry, there was an error uploading your file.";
	return array(0, $msg);
  }
}
}

//--------------------------------------------------------------------
//a custom functions that extracts the required values and performs the calculations needs to produce data for the report
//the function takes the excel file as input and an option arguement

function getValues($file,$option){
require 'vendor/autoload.php';
$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
$objPHPExcel = $reader->load($file);
$sheet = $objPHPExcel->getActiveSheet(); 
$highestRow = $sheet->getHighestRow(); 
$highestColumn = $sheet->getHighestColumn();

$value1 =  $reader->listWorksheetInfo($file);
$totalRows = $value1[0]['totalRows'];

//initializing values for the columns we need

$AidsUSD = 0;
$AidsZWL = 0;
$AidsLevy = 0;
$totalEarningsUSD = 0;
$totalEarningsZWL = 0;
$totalFringeB = 0;
$PAYETax = 0;
$PAYETaxZWL = 0;
$GrossIncomeUSD = 0;
$TaxUSD = 0;
//calculating the totals for each required data column in the excel file
for($i=6;$i<=$totalRows;$i++){
	$TaxUSD = $TaxUSD+ $sheet->getCell('I'.strval($i))->getValue();
	$totalEarningsUSD = $totalEarningsUSD+ $sheet->getCell('L'.strval($i))->getValue();
	$totalEarningsZWL = $totalEarningsZWL+ $sheet->getCell('O'.strval($i))->getValue();
	$totalFringeB = $totalFringeB+ $sheet->getCell('P'.strval($i))->getValue();
	$PAYETax = $PAYETax+ $sheet->getCell('K'.strval($i))->getValue();
	$PAYETaxZWL = $PAYETaxZWL + $sheet->getCell('N'.strval($i))->getValue();
	$GrossIncomeUSD = $GrossIncomeUSD + $sheet->getCell('H'.strval($i))->getValue();
	$AidsUSD = $AidsUSD + $sheet->getCell('F'.strval($i))->getValue();
	$AidsZWL = $AidsZWL + $sheet->getCell('J'.strval($i))->getValue();
	$AidsLevy = $AidsLevy + $sheet->getCell('M'.strval($i))->getValue();
}
//using the option arguement to return the specified data value required for the specified fields
//tr = total remuneration
//gp = gross PAYE
//ne = number of employees
//al = aids levy
//tt = total taxes paid
//1. total in ZWL
//2. ZWL Paid
//3. USD in ZWL
//4. USD Paid
// for example tr1 = total renumeration (total in ZWL)
if($option == 'tr1'){
	return $totalEarningsUSD+$totalEarningsZWL+$totalFringeB;
}
else if($option == 'tr2'){
	return $totalEarningsZWL+$totalFringeB;
}
else if($option == 'tr3'){
	return $totalEarningsUSD;
}
else if($option == 'tr4'){
	return $GrossIncomeUSD;
}
else if($option == 'gp1'){
	return $PAYETax+$PAYETaxZWL;
}
else if($option == 'gp2'){
	return $PAYETaxZWL;
}
else if($option == 'gp3'){
	return $PAYETax;
}
else if($option == 'gp4'){
	return $TaxUSD;
}
else if($option == 'al1'){
	return $AidsZWL+$AidsLevy;
}
else if($option == 'al2'){
	return $AidsLevy;
}
else if($option == 'al3'){
	return $AidsZWL;
}
else if($option == 'al4'){
	return $AidsUSD;
}
else if($option == 'tt1'){
	return $PAYETax+$PAYETaxZWL+$AidsZWL+$AidsLevy;
}
else if($option == 'tt2'){
	return $PAYETaxZWL+$AidsLevy;
}
else if($option == 'tt3'){
	return $PAYETax+$AidsZWL;
}
else if($option == 'tt4'){
	return $TaxUSD+$AidsUSD;
}
else if($option == 'count'){
	return $totalRows - 6;
}
else{
	return Null;
}
}

//--------------------------------------------------------------------
//create report
//initialising the phpword template processor

$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('assets/template/temp.docx');
$filename = handleFile($file);
if($filename[0] != 0){
	$_SESSION['msg'] = $filename[1];
//echo"<script type='text/javascript'>location.href = '/';</script>";
}

//--------------------------------------------------------------------
//fill report details part A
//setting the values for Part A of the report collected by the form
	
$data = array($ename, $tname, $btnumber, $paye, $tin, $address, $postal, $tax_period, $due_date, $email, $cell);
$fields = array('ename', 'tname', 'btnumber', 'paye', 'tin', 'address', 'postal', 'tax_period', 'due_date', 'email', 'cell');

//writing the data onto the word template

$templateProcessor->setValue($fields, $data);
//--------------------------------------------------------------------

//finding the total number of rows on the excel file to determine the number of employees
$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
$value1 =  $reader->listWorksheetInfo($filename[0]);
$count = $value1[0]['totalRows'];
$filename = $filename[0];
//collecting the data for part B of the report by calling the getvalues() custom function

//$data1 = array(getValues($filename,'tr1'), getValues($filename,'tr2'), getValues($filename,'tr3'), getValues($filename,'tr4'));
//$data2 = array(getValues($filename,'count'));
//$data3 = array(getValues($filename,'gp1'), getValues($filename,'gp2'), getValues($filename,'gp3'), getValues($filename,'gp4'));
//$data4 = array(getValues($filename,'al1'), getValues($filename,'al2'), getValues($filename,'al3'), getValues($filename,'al4'));
//$data5 = array(getValues($filename,'tt1'), getValues($filename,'tt2'), getValues($filename,'tt3'), getValues($filename,'tt4'));
//$fields1 = array('tr1', 'tr2', 'tr3', 'tr4');
//$fields2 = array('ne1');
//$fields3 = array('gp1', 'gp2', 'gp3', 'gp4');
//$fields4 = array('al1', 'al2', 'al3', 'al4');
//$fields5 = array('tt1', 'tt2', 'tt3', 'tt4');

//writing the data collected onto the word template

//$templateProcessor->setValue($fields1, $data1);
//$templateProcessor->setValue($fields2, $data2);
//$templateProcessor->setValue($fields3, $data3);
//$templateProcessor->setValue($fields4, $data4);
//$templateProcessor->setValue($fields5, $data5);

//--------------------------------------------------------------------

//saving report to reports folder on the server

//header("Content-Disposition: attachment; filename=report.docx");
//$templateProcessor->saveAs('php://output');
$_SESSION['download'] = 'reports/'.$ename.'.docx';
$templateProcessor->saveAs('reports/'.$ename.'.docx');

echo"<script type='text/javascript'>location.href ='final.php/';</script>";

//--------------------------------------------------------------------

?>