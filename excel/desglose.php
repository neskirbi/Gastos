<?php
include "../config/config.php";//Contiene funcion que conecta a la base de datos
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



if (PHP_SAPI == 'cli')
    die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once dirname(__FILE__) . '../exel/Classes/PHPExcel.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Ing. Martinez")
                             ->setLastModifiedBy("Raul Marinez")
                             ->setTitle("Office 2007 XLSX Test Document")
                             ->setSubject("Office 2007 XLSX Test Document")
                             ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                             ->setKeywords("office 2007 openxml php")
                             ->setCategory("Test result file");

                             $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);


$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);


$objPHPExcel->getActiveSheet()->getStyle('C3:M3')->applyFromArray(
    array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '3F5367')
        )
    )
);


$objPHPExcel->getActiveSheet()->getStyle('C3:M3')->getFont()->setBold(true)
                                ->setName('Verdana')
                                ->setSize(10)
                                ->getColor()->setRGB('ffffff');

$objPHPExcel->setActiveSheetIndex(0)

             ->setCellValue('C3', "Folio")
             ->setCellValue('D3', "Beneficiario")
             ->setCellValue('E3', "Fecha de \n Factura")
             ->setCellValue('F3', "Fecha de \n Consumo")
             ->setCellValue('G3', "Concepto")             
             ->setCellValue('H3', "Descripcion")
             ->setCellValue('I3', "Folio Fiscal")
             ->setCellValue('J3', "Monto Factrura\n(A.Iva)")
             ->setCellValue('K3', "Iva")
             ->setCellValue('L3', "Total")
             ->setCellValue('M3', "Deducible");



$id_cheque=$_REQUEST['id_cheque'];

 $ben="SELECT u.name from cheques c 
join user u on u.id=c.beneficiario
where c.id='$id_cheque'  ";
$ben=mysqli_query($con,$ben);
$ben=mysqli_fetch_array($ben);
$nombre=utf8_encode($ben['name']);

$consulta="SELECT * FROM  desglose d
join category_income c on c.id=d.category_id
 where d.id_cheque='$id_cheque'  order by d.created_at desc";
$sql=mysqli_query($con,$consulta);
$cont=6;
while ($row=mysqli_fetch_array($sql)) {
	$total=$row['amount']+$row['iva'];
	$total=number_format($total,2);

	if($row['deducible'])
	{
		$dedu="SI";
	}else
	{
		$dedu="No";
	}
	$folio=explode(".",$row['comprobante']);


	$objPHPExcel->setActiveSheetIndex(0)
                                 ->setCellValue('C'.$cont, $row['id'])
                                 ->setCellValue('D'.$cont, $nombre)
                                 ->setCellValue('E'.$cont, $row['date_fac'])
                                 ->setCellValue('F'.$cont, $row['created_at'])
                                 ->setCellValue('G'.$cont, $row['name'])
                                 ->setCellValue('H'.$cont, utf8_encode($row['description']))
                                 ->setCellValue('I'.$cont, $folio[0])
                                 ->setCellValue('J'.$cont, number_format($row['amount'],2))
                                 ->setCellValue('K'.$cont, number_format($row['iva'],2))
                                 ->setCellValue('L'.$cont, number_format($total,2))
                                 ->setCellValue('M'.$cont, $dedu);


	$cont++;
}




//Eliminar lineas
//$objPHPExcel->getActiveSheet()->setShowGridlines(true);

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Control de gastos');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Desglose.xls"');
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

?>