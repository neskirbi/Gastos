<?php
include "../config/config.php";//Contiene funcion que conecta a la base de datos
session_start();
function verificar($id)
    {
        global $con;
        $consulta="SELECT * from desglose where id_cheque='".$id."' ";
        $sql_data=mysqli_query($con,$consulta);
        $num=mysqli_num_rows($sql_data);

        $consulta="SELECT * from desglose where id_cheque='".$id."' and ok_val='1' ";
        $sql_data=mysqli_query($con,$consulta);
        $num2=mysqli_num_rows($sql_data);

        $conf="0";
        if($num==$num2 and $num!="0")
        {
            $conf="1";
        }

        return $conf;
    } 

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
$objPHPExcel->getProperties()->setCreator("Ing. Sosa")
                             ->setLastModifiedBy("Adrian Sosa")
                             ->setTitle("Office 2007 XLSX Test Document")
                             ->setSubject("Office 2007 XLSX Test Document")
                             ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                             ->setKeywords("office 2007 openxml php")
                             ->setCategory("Test result file");

//Estilos
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);


//Aqui continua

//Titulo
$fila = 3;
$objPHPExcel->setActiveSheetIndex(0)
		    //->setCellValue('A'.$fila, "NÚMERO DE CHEQUES")
		    ->setCellValue('B'.$fila, "FECHA")
		    ->setCellValue('C'.$fila, "BENEFICIARIO")
		    ->setCellValue('D'.$fila, "IMPORTE")
		    ->setCellValue('E'.$fila, "CLASIFICACIÓN")
		    ->setCellValue('F'.$fila, "CONCEPTO")
		    ->setCellValue('G'.$fila, "PERSONA QUE SOLICITA CHEQUES")
		    ->setCellValue('H'.$fila, "PROGRAMA")
		    ->setCellValue('I'.$fila, "CONCEPTO PAGO A CUENTA DE PRESTAMO");

$fila = 4;

//$sql = "SELECT * from cheques where status='2'";
$sql = "SELECT che.fecha, case when che.bennombre = '0' then (select name from user where id=che.beneficiario) when che.bennombre != '0' then che.bennombre end ben, che.monto, che.concepto, che.beneficiario, (select name from programas where id=che.programa) as programa, (select name from t_cheque where id=che.t_cheque) as t_cheque, (select name from user where id=che.beneficiario) as solicitud, che.no_cheque,che.id ,che.t_cheque as t_cheque_id
		FROM cheques che
		where status='1'";
$sql = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($sql))
{
	if(verificar($row['id'])=="1" or $row['t_cheque_id']!="3" or $_SESSION['user_tipo']!="1")
                        {
	$objPHPExcel->setActiveSheetIndex(0)
			    //->setCellValue('A'.$fila, $row['no_cheque'])
			    ->setCellValue('B'.$fila, $row['fecha'])
			    ->setCellValue('C'.$fila, utf8_encode($row['ben']))
			    ->setCellValue('D'.$fila, $row['monto'])
			    ->setCellValue('E'.$fila, $row['t_cheque'])
			    ->setCellValue('F'.$fila, $row['concepto'])
			    ->setCellValue('G'.$fila, $row['solicitud'])
			    ->setCellValue('H'.$fila, $row['programa']);

	$fila++;
}
}

//Eliminar lineas
$objPHPExcel->getActiveSheet()->setShowGridlines(true);

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Cheques');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Cheques.xls"');
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