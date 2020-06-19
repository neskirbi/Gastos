<?php 
date_default_timezone_set('America/Mexico_City');
include "../../config/config.php";//Contiene funcion que conecta a la base de datos
session_start();
$id=$_REQUEST['id'];
$id2=$_SESSION['user_id'];
$msn=$_REQUEST['msn'];


$cons="SELECT name from user where id='$id2' ";
$sql=mysqli_query($con,$cons);
$r=mysqli_fetch_array($sql);
$nombre=utf8_encode($r['name']);

$msn=mysqli_real_escape_string($con,$msn);



if($_SESSION['user_tipo']=='5')
	{
		$archivo="../chats/".$id2."chat".$id.".txt";

	}else{
		$archivo="../chats/".$id."chat".$id2.".txt";
	}



$fp = fopen($archivo, "r");
$contenido='';

while(!feof($fp)) {
	$contenido =$contenido. fgets($fp);
}
fclose($fp);



$file = fopen($archivo, "w");

$msn=$contenido.date("Y-m-d H:i:s")." ".$nombre ." : ".$msn. "<br/>";

if(fwrite($file, $msn))
{
     echo "Se ha ejecutado correctamente";
}
else
{
     echo "Ha habido un problema al crear el archivo";
}

fclose($file);
    
 


?>