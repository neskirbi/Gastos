<?php
function Reemplaza($string){
	$string = str_replace("(", " ",$string);
	$string = str_replace(")", " ",$string);
	$string = str_replace(".", " ",$string);
	$string = str_replace(",", " ",$string);
	$string = str_replace("°", " ",$string);
	$string = str_replace("'", " ",$string);
	$string = str_replace("!", " ",$string);
	$string = str_replace("#", " ",$string);
	$string = str_replace("%", " ",$string);
	$string = str_replace("=", " ",$string);
	$string = str_replace("?", " ",$string);
	$string = str_replace("¡", " ",$string);
	$string = str_replace("¿", " ",$string);
	$string = str_replace("*", " ",$string);
	$string = str_replace("{", " ",$string);
	$string = str_replace("}", " ",$string);
	$string = str_replace("[", " ",$string);
	$string = str_replace("]", " ",$string);
	$string = str_replace(">", " ",$string);
	$string = str_replace("<", " ",$string);
	$string = str_replace(";", " ",$string);
	$string = str_replace(":", " ",$string);
	$string = str_replace("_", " ",$string);
	$string = str_replace("-", " ",$string);
	$string = str_replace("+", " ",$string);
	$string = str_replace("-", " ",$string);
	$string = str_replace("&", " ",$string);
	$string = str_replace("|", " ",$string);
	$string = str_replace("á", "A",$string);
	$string = str_replace("é", "E",$string);
	$string = str_replace("í", "I",$string);
	$string = str_replace("ó", "O",$string);
	$string = str_replace("ú", "U",$string);
	$string = str_replace("Á", "A",$string);
	$string = str_replace("É", "E",$string);
	$string = str_replace("Í", "I",$string);
	$string = str_replace("Ó", "O",$string);
	$string = str_replace("Ú", "U",$string);
	$string = str_replace("ü", "U",$string);
	$string = str_replace("ö", "O",$string);
	return $string;
}

include"../config/config.php";
$fechaautorizado=$_REQUEST['fechaautorizado'];
echo$sql="SELECT che.cuentasalida,pro.cuenta,che.monto,che.FolioSantander,che.fecha,pro.email from cheques as che 
left join proveedores as pro on pro.id = che.beneficiario 
where che.fechaautorizado='$fechaautorizado' and pro.tipocuenta='EXTRNA' order by fechaautorizado desc";
$rows = mysqli_query($con,$sql);
$areglo=array();
while ($row=mysqli_fetch_array($rows)){
	//$row['FolioSantander']=Reemplaza($row['FolioSantander']);
	$areglo[]=$row;
}

echo json_encode($areglo);

?>

