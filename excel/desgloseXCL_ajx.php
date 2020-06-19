<?php
 include "../config/config.php";
session_start();
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
//ini_set('max_input_time', 3000);
ini_set('max_execution_time', 3000);
//ini_set('memory_limit', '1024M');
//set_time_limit(30);
//ini_set('memory_limit', '2024M');


date_default_timezone_set('America/Mexico_City');

$month=$_GET['month'];
$year=$_GET['year'];
$tipo=$_GET['tipo'];
$fecha=$year."-".$month."-01";

require_once dirname(__FILE__) . '../exel/Classes/PHPExcel.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Promotecnicas y Ventas")
                             ->setLastModifiedBy("Promotecnicas")
                             ->setTitle("Office 2007 XLSX Test Document")
                             ->setSubject("Office 2007 XLSX Test Document")
                             ->setDescription("Document for Office 2007 XLSX, generated using PHP classes.")
                             ->setKeywords("office 2007 openxml php")
                             ->setCategory("Test result file");


//Estilos
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);  
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(60);


$objPHPExcel->getActiveSheet()->getStyle('B3:K3')->applyFromArray(
    array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '3F5367')
        )
    )
);


$objPHPExcel->getActiveSheet()->getStyle('B3:K3')->getFont()->setBold(true)
                                ->setName('Verdana')
                                ->setSize(10)
                                ->getColor()->setRGB('ffffff');

    $objPHPExcel->setActiveSheetIndex(0)

             ->setCellValue('B3', "ID")
             ->setCellValue('C3', "Concepto")
             ->setCellValue('D3', "Monto sin IVA")
             ->setCellValue('E3', "Nombre SD")
             ->setCellValue('F3', "Categoria")
             ->setCellValue('G3', "Fecha")             
             ->setCellValue('H3', "ID Cheque")
             ->setCellValue('I3', "Folio Fiscal")
             ->setCellValue('J3', "Deducible")
             ->setCellValue('K3', "IVA");
        
    $i=4;   
    if($tipo==1)
    {
        $extras="and d.created_at between '".$fecha."' and LAST_DAY('".$fecha."')";
    } 
    else{
        $extras=" ";
    }
    $consulta = "SELECT d.id, d.description, d.amount,u.name as usuario, ct.name,d.created_at,d.id_cheque, d.comprobante,d.deducible ,d.iva from desglose d join user u on u.id=d.user_id join category_income ct on ct.id=d.category_id where u.programa='1' ".$extras." order by id";
        $result = mysqli_query($con, $consulta )or die(mysqli_error());
        //loop through fetched data     
    while ($row=mysqli_fetch_array($result)) {
    	$objPHPExcel->setActiveSheetIndex(0)
    		->setCellValue('B'.$i, $row['id'])
    		->setCellValue('C'.$i, $row['description'])
    		->setCellValue('D'.$i, $row['amount'])
    		->setCellValue('E'.$i, $row['usuario'])
    		->setCellValue('F'.$i, $row['name'])
    		->setCellValue('G'.$i, $row['created_at'])
    		->setCellValueExplicit('H'.$i, $row['id_cheque'],PHPExcel_Cell_DataType::TYPE_STRING)
    		->setCellValue('I'.$i, $row['comprobante'])
    		->setCellValue('J'.$i, $row['deducible'])
    		->setCellValue('K'.$i, $row['iva']);
        $objPHPExcel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('"$" ###0.00_-');
        $objPHPExcel->getActiveSheet()->getStyle('K'.$i)->getNumberFormat()->setFormatCode('"$" ###0.00_-');
        
    	$i++;	
    }         


//Eliminar lineas
$objPHPExcel->getActiveSheet()->setShowGridlines(true);

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Control de gastos');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Desglose '.date("Y-m-d") .'.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;