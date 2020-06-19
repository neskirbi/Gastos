<?php
 include "../config/config.php";
$month=$_GEt['month'];
$year=$_GET['year'];
$fecha=$year."-".month."-01";

$sql = "SELECT d.id, d.description, d.amount,u.name, ct.name,d.created_at,d.id_cheque, d.comprobante,d.deducible ,d.iva from desglose d join user u on u.id=d.user_id join category_income ct on ct.id=d.category_id where u.programa='1' and d.created_at between '".$fecha."' and LASTDAY('".$fecha."')";
$result=mysqli_query($con,$consulta);
use PhpSpreadsheet\Spreadsheet;
use PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'Hello World !');

$writer = new Xlsx($spreadsheet);
$writer->save('hello world.xlsx');
    ?>