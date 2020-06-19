<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8" lang="es_ES">
</head>
<body>
	<select class="col" name="month" id="month" >
	    <?php
	    for ($i = 1; $i <= 12; $i++) 
	    {
	        setlocale (LC_TIME, 'es_ES.utf8','es'); 
	        echo '<option value="'.$i.'">'. strftime('%B', mktime(0, 0, 0, $i)).'</option>"n"';
	    }
	    ?>
	</select>
	<select class="col" name="year" id="year" >
		<?php
		for($i=2018;$i<=date('Y');$i++)
		{
			echo "<option value='$i'>".$i."</option>";
		}
		?>
	</select>
	<button class="btn btn-primary col" onclick="descarga('1')" >Descarga por mes</button>
	<button class="btn btn-info col" onclick="descarga('0')" >Descarga histórico</button>
	
	<script type="text/javascript">
	function descarga(id){
		var tipo=id;
		var month= $("#month").val();
        var	year= $("#year").val();
        window.location = 'excel/desgloseXCL_ajx.php?tipo='+tipo+'&month='+month+'&year='+year;

	};
</script>
 <!-- jQuery -->
 <script src="js/jquery/dist/jquery.min.js"></script>
</body>
</html>




<?php

//$sql = "SELECT d.id, d.description, d.amount,u.name, ct.name,d.created_at,d.id_cheque, d.comprobante,d.deducible ,d.iva from desglose d join user u on u.id=d.user_id join category_income ct on ct.id=d.category_id where u.programa='1'";