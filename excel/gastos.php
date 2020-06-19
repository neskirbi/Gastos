<?php

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

include "../config/config.php";//Contiene funcion que conecta a la base de datos
 function array_multi($array)
    {
        $restem=1;
        $res=0;
        for ($i=0; $i < count($array) ; $i++) { 
            $restem=$restem*$array[$i];
        }
        if($i==0)
            {
                $res=0;
            }else{
                $res=$restem;
            }
        
        return $res;
    }
function cli_ok($id)
    {
        global $con;
        $res=array();
        $fecha=array();
        $consulta="SELECT * from cheques as c join desglose as d on d.id_cheque=c.id where c.id='$id' ";
        $sql=mysqli_query($con,$consulta);
        while ($sql_data=mysqli_fetch_array($sql))
        {
            $res[]=$sql_data['ok_cli'];
            $fecha[]=$sql_data['fecha_ok_cli'];
        }
        $res=array_multi($res);
        
        if($res==1)
        {
            return 'Autorizado';
        }else
        {
            return 'Sin Autorizar';
        }
    }

function estatus($id)
    {
        global $con;
        $consulta="SELECT * from cheques as che join desglose as des on des.id_cheque=che.id where che.id='$id' ";
        $sql=mysqli_query($con,$consulta);
        $gastos= mysqli_num_rows($sql);
        
        $consulta="SELECT * from cheques as che join desglose as des on des.id_cheque=che.id where (che.id='$id' and des.comprobante!='') or (che.id='$id' and des.deducible='0') ";
        $sql=mysqli_query($con,$consulta);
        $sin_comprobar= mysqli_num_rows($sql);

        $consulta="SELECT * from cheques as che join desglose as des on des.id_cheque=che.id where (che.id='$id' and des.ok_sup='0')  ";
        $sql=mysqli_query($con,$consulta);
        $ok_sup= mysqli_num_rows($sql);

        if(intval($ok_sup)>0)
        {
            return "3";
        }else if((intval($gastos)-intval($sin_comprobar))>0)
        {
            return "2";
        } else{
            return "1";
        }
    }
    function estatus_cli($id)
    {
        global $con;
        $consulta="SELECT * from cheques as che join desglose as des on des.id_cheque=che.id where che.id='$id' ";
        $sql=mysqli_query($con,$consulta);
        $gastos= mysqli_num_rows($sql);
        
        $consulta="SELECT * from cheques as che join desglose as des on des.id_cheque=che.id where (che.id='$id' and des.comprobante!='') or (che.id='$id' and des.deducible='0') ";
        $sql=mysqli_query($con,$consulta);
        $sin_comprobar= mysqli_num_rows($sql);

        $consulta="SELECT * from cheques as che join desglose as des on des.id_cheque=che.id where (che.id='$id' and des.ok_cli='0')  ";
        $sql=mysqli_query($con,$consulta);
        $ok_sup= mysqli_num_rows($sql);

        if(intval($ok_sup)>0)
        {
            return "3";
        }else if((intval($gastos)-intval($sin_comprobar))>0)
        {
            return "2";
        } else{
            return "1";
        }
    }


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
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->getStyle('B3:L3')->applyFromArray(
    array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '3F5367')
        )
    )
);


$objPHPExcel->getActiveSheet()->getStyle('B3:L3')->getFont()->setBold(true)
                                ->setName('Verdana')
                                ->setSize(10)
                                ->getColor()->setRGB('ffffff');

    



        // escaping, additionally removing everything that could be (html/javascript-) code
         //$daterange = mysqli_real_escape_string($con,(strip_tags($_REQUEST['daterange'], ENT_QUOTES)));
        
         $user=$_REQUEST['user'];
         $date1=$_REQUEST['date1'];
         $date2=$_REQUEST['date2'];

         //$arraydate=explode("-", $daterange);

         //$fecha1=explode("/",$arraydate[0]);
         //$fecha2=explode("/",$arraydate[1]);
        


         if($_REQUEST['page']=="0")
         {
          $arraydate[0]="2015-01-01";
          $arraydate[1]=date("Y-m-d");
         }else{
            //$arraydate[0]=str_replace(" ","",($fecha1[2]."-".$fecha1[1]."-".$fecha1[0])); 
            $arraydate[0]=$date1; 
            $arraydate[1]=$date2;  
         }
         
         //$arraydate[1]=str_replace(" ","",($fecha2[2]."-".$fecha2[1]."-".$fecha2[0]));
         

          $filtro="";
        if($_SESSION['user_tipo']=="0" || $_SESSION['user_tipo']=="1" || $_SESSION['user_tipo']=="-2")
        {
          $filtro=" che.programa!='100' and ";
        }
        $por_per="";
        if($_SESSION['user_tipo']=="3"||$_SESSION['user_tipo']=="5" ||$_SESSION['user_tipo']=="4" )
        {
            if($user!="0")
            {
                $por_per="usu.id='".$user."' and ";
            }
          $filtro=" che.programa='".$_SESSION['programa']."' and usu.rutas IN ('".str_replace(",","','",$_SESSION['rutas'])."') and  $por_per ";
        }
        if($_SESSION['user_tipo']=="2")
        {
          $filtro="  usu.id='".$_SESSION['user_id']."' and   ";
        }
            
        $montof=array();
        $comprobadof=array();
        $balancef=array();
        //main query to fetch the data
        $sql="SELECT che.pago,gas.id, gas.id_cheque, gas.fecha, gas.fecha_comp, gas.status, gas.t_gasto FROM gastos as gas join cheques as che on che.id=gas.id_cheque join user as usu on usu.id=che.beneficiario where $filtro  gas.fecha between '$arraydate[0]' and '$arraydate[1]' order by gas.fecha desc ";
        $query = mysqli_query($con, $sql);
        $numrows=mysqli_num_rows($query);
        //loop through fetched data
        if ($numrows>0){
            


    $objPHPExcel->setActiveSheetIndex(0)

             ->setCellValue('B3', "Folio")
             ->setCellValue('C3', "Pago")
             ->setCellValue('D3', "Tipo de gasto")
             ->setCellValue('E3', "Status")
             ->setCellValue('F3', "Beneficiario")
             ->setCellValue('G3', "Monto")             
             ->setCellValue('H3', "Comprobado")
             ->setCellValue('I3', "X Comprobar")
             ->setCellValue('J3', "Fecha de Solicitud")
             ->setCellValue('K3', "Fecha de entrega")
             ->setCellValue('L3', "No. Cheque");

$objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(30);


                $cont=5;
                        while ($r=mysqli_fetch_array($query)) {
                            $consulta="SELECT * from cheques where id='".$r['id_cheque']."'";

                            $autorizado=cli_ok($r['id_cheque']);
                            $sql=mysqli_query($con,$consulta);
                            $sql_data=mysqli_fetch_array($sql);
                            $stilo_sol="btn btn-default";
                            $staus_che=$sql_data['status'];
                            if($staus_che!='0')
                            {
                                $stilo_sol="btn btn-success";
                            }
                            
                            if($sql_data['bennombre']=="0")
                            {
                                $consulta_n="SELECT * from user where id='".$sql_data['beneficiario']."'";
                                $sql_n=mysqli_query($con,$consulta_n);
                                $sql_data_n=mysqli_fetch_array($sql_n);
                                $nombre=$sql_data_n['name'];
                            }else
                            {
                                $nombre=$sql_data['bennombre'];
                            }

                            
                            $no_cheque=$sql_data['no_cheque'];
                            $id_cheque=$r['id_cheque'];
                            $fecha=$sql_data['fecha'];
                            $fecha_confirm=$sql_data['fecha_confirm'];

                            if(($no_cheque*1)==0)
                            {
                              $fecha_confirm="";
                            }
							
							$pago=	"";
                            if($r['pago']=='1')
                            {
                            	$pago=	"Ok";
                            }
                            
                            $description=$sql_data['concepto'];
                            $monto=$sql_data['monto'];
                            
                            

                            $consulta2="SELECT * from t_cheque where id='".$sql_data['t_cheque']."'";
                            $sql2=mysqli_query($con,$consulta2);
                            $sql_data2=mysqli_fetch_array($sql2);
                            $name_category=$sql_data2['name'];


                           $comprovado="SELECT sum(amount+iva) as balance from desglose where ((id_cheque='$id_cheque' and comprobante!='') )  ";
                            $comprovado=mysqli_query($con,$comprovado);
                            $comprovado=mysqli_fetch_array($comprovado);
                            $comprovado=$comprovado['balance'];

                            $balance=$monto-$comprovado;


                            $coin_name = "coin";
                            $querycoin = mysqli_query($con,"SELECT * from configuration where name='$coin_name' ");
                            if ($r = mysqli_fetch_array($querycoin)) {
                                $coin=$r['val'];
                            }
                            $concepto=$sql_data['concepto'];
                            $programa=$sql_data['programa'];
                            $consulta="SELECT name from programas where id='".$programa."' ";
                            $sql_data=mysqli_query($con ,$consulta) ;
                            $pro=mysqli_fetch_array($sql_data);
                            $programa=$pro['name'];
                           
                            $montof[]=$monto;
                            $comprobadof[]=$comprovado;
                            $balancef[]=$balance;
    
                    $objPHPExcel->setActiveSheetIndex(0)
                                 ->setCellValue('B'.$cont, $id_cheque)
                                 ->setCellValue('C'.$cont, $pago)
                                 ->setCellValue('D'.$cont, $name_category)
                                 ->setCellValue('E'.$cont, $autorizado)
                                 ->setCellValue('F'.$cont, utf8_encode($nombre))
                                 ->setCellValue('G'.$cont, "$".number_format($monto,2))
                                 ->setCellValue('H'.$cont, "$".number_format($comprovado,2))
                                 ->setCellValue('I'.$cont, "$".number_format($balance,2))
                                 ->setCellValue('J'.$cont, $fecha)
                                 ->setCellValue('K'.$cont, $fecha_confirm)
                                 ->setCellValue('L'.$cont, $no_cheque);
                           

               $cont++;
                    } //en while

                      $objPHPExcel->setActiveSheetIndex(0)
                                //->setCellValue('A3', "NÚMERO DE CHEQUES")
                                 ->setCellValue('B'.($cont+1), "Total")
                                 ->setCellValue('G'.($cont+1), "$".number_format(array_sum($montof),2))
                                 ->setCellValue('H'.($cont+1), "$".number_format(array_sum($comprobadof),2))
                                 ->setCellValue('I'.($cont+1), "$".number_format(array_sum($balancef),2));
                            
               
            $montof=array();
            $comprobadof=array();
            $balancef=array();
        }
    





//Eliminar lineas
$objPHPExcel->getActiveSheet()->setShowGridlines(true);

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Control de gastos');


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