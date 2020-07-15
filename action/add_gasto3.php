<?php	
	session_start();
	/*Inicia validacion del lado del servidor*/
	include "../config/config.php";//Contiene funcion que conecta a la base de datos
	

	$id_cheque=$_REQUEST['id_cheque'];
	$params=json_decode($_REQUEST['data'],true);
	$values=array();
	$tamount=0;
	$tiva=0;	
	$existe=0;
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
		$tamount+=$amount;
		$tiva+=$iva;

	    if($params[$key]['factura']!=""){
	    	$facturat=explode(",",$params[$key]['factura']);
		    $facturaname=$facturat[0];
		    $factura64=$facturat[1];
		    //echo strlen ($facturaname."--");
		    if(!file_exists("../Comprobantes/".$facturaname) && strlen ($facturaname)==36){
		    	$content = base64_decode($factura64);
			    $file = fopen("../Comprobantes/".$facturaname, "wb");
			    fwrite($file, $content);
				fclose($file);
		    }else if(file_exists("../Comprobantes/".$facturaname)){
		    	$existe++;
		    	echo"0#sep#";
		    	?>
				<div class="alert alert-danger" role="alert">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Error! El archivo <?php echo $facturaname; ?> ya existe.</strong> 
						
				</div>
				<?php
		    }else if(strlen ($facturaname)!=36){
		    	$existe++;
		    	echo"0#sep#";
		    	?>
				<div class="alert alert-danger" role="alert">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Error! Verifiar el nombre del archivo. <?php echo $facturaname; ?></strong> 
						
				</div>
				<?php		    	
		    }


		    
	    }

	    if($params[$key]['comprobante']!=""){
	    	$comprobantet=explode(",",$params[$key]['comprobante']);
		    $comprobantename=$comprobantet[0];
		    $comprobante64=$comprobantet[1];
		    //echo strlen ($comprobantename."--");
		    if(!file_exists("../Comprobantes/".$comprobantename) && strlen ($comprobantename)==36){
			    $content = base64_decode($comprobante64);
			    $file = fopen("../Comprobantes/".$comprobantename, "wb");
			    fwrite($file, $content);
				fclose($file);
			}else if(file_exists("../Comprobantes/".$comprobantename)){
				$existe++;
		    	echo"0#sep#";
		    	?>
				<div class="alert alert-danger" role="alert">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Error! El archivo <?php echo $comprobantename; ?> ya existe.</strong> 
						
				</div>
				<?php
		    }else if(strlen ($comprobantename)!=36){
		    	$existe++;
		    	echo"0#sep#";
		    	?>
				<div class="alert alert-danger" role="alert">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Error! Verifiar el nombre del archivo.</strong> 
						
				</div>
				<?php		    	
		    }
	    }
	   
	    
    	$values[]="('$description','$amount','$user_id','$category','$date_added','$id_cheque','$deducible','$iva','$date_fac','$comprobantename','$facturaname')";
	}

	if($existe==0){
		$verificar="SELECT status from cheques where id='$id_cheque' ";
	    $sql=mysqli_query($con,$verificar);
	    $verificar=mysqli_fetch_array($sql);
	    if(intval($verificar['status'])!=0)
	    {
	    	echo"0#sep#";
	    	?>
			<div class="alert alert-danger" role="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Error! No se puede agregar mas este reembolso ya se solicitó.</strong> 
					
			</div>
			<?php
	    	//echo "#1#No se puede agregar mas, este reembolso ya se solicitó.";
	    }else{
	    	//Esto el lo ultimo
	    	 $consulta="UPDATE cheques set monto=monto+$tamount+$tiva where id='$id_cheque' and t_cheque='3' ";
		    if($query_new_insert = mysqli_query($con,$consulta))
		    {
		    	
		    	

					$sql="INSERT INTO desglose (description, amount, user_id, category_id, created_at,id_cheque,deducible,iva,date_fac,comprobante,factura) VALUES".implode(",",$values);
				$query_new_insert = mysqli_query($con,$sql);
				if ($query_new_insert){
					echo"1#sep#";
					?>
					<div class="alert alert-success" role="alert">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>¡Monto actualizado!</strong>
					
				</div>
				<?php
				} else{
					echo"0#sep#";
	    	?>
			<div class="alert alert-danger" role="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Error! Lo siento algo ha salido mal intenta nuevamente.</strong> 
					
			</div>
			<?php
					//echo "Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
				}
		    }
		    else
		    {
		    	echo"1#sep#";
		    	?>
				<div class="alert alert-danger" role="alert">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>Error!</strong> 
						
				</div>
				<?php
		    }
		}
	}
	

	

	
	

	       


		
?>