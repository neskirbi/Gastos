<?php	
	session_start();
	/*Inicia validacion del lado del servidor*/
	include "../config/config.php";//Contiene funcion que conecta a la base de datos
	

	$id_cheque=$_REQUEST['id_cheque'];
	$params=json_decode($_REQUEST['data'],true);
	$values=array();
	foreach ($params as $key => $value) {
		//print_r($params[$key]);
		$date_added=$params[$key]['date'];
		$date_fac=$params[$key]['date_fac'];
		$description=mysqli_real_escape_string($con,(strip_tags($params[$key]['description'],ENT_QUOTES)));
		$amount=floatval($params[$key]['amount']);
		$category=intval($params[$key]['category']);
		$user_id=$_SESSION['user_id'];
		$deducible=boolval($params[$key]['deducible']);
	    $iva=floatval($params[$key]['monto_iva']);
		$comprobantename="";
		$facturaname="";

	    if(strlen($params[$key]['factura'])>10){
	    	$facturat=explode(",",$params[$key]['factura']);
		    $facturaname=$facturat[0];
		    $factura64=$facturat[1];


		    $content = base64_decode($factura64);
		    $file = fopen("../Comprobantes/".$facturaname, "wb");
		    fwrite($file, $content);
			fclose($file);
	    }

	    if(strlen($params[$key]['comprobante'])>10){
	    	$comprobantet=explode(",",$params[$key]['comprobante']);
		    $comprobantename=$comprobantet[0];
		    $comprobante64=$comprobantet[1];


		    $content = base64_decode($comprobante64);
		    $file = fopen("../Comprobantes/".$comprobantename, "wb");
		    fwrite($file, $content);
			fclose($file);
	    }
	   
	    
	    $values[]="('$description','$amount','$user_id','$category','$date_added','$id_cheque','$deducible','$iva','$date_fac','$comprobantename','$facturaname')";
	}

	

	
	$sql="INSERT INTO desglose (description, amount, user_id, category_id, created_at,id_cheque,deducible,iva,date_fac,comprobante,factura) VALUES".implode(",",$values);
	$query_new_insert = mysqli_query($con,$sql);
	if ($query_new_insert){
		echo"1";
	} else{
		echo "Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
	}

	       


		
?>