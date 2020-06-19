<?php
include"../config/config.php";
$id= $_REQUEST['id'] ;



$zip = new ZipArchive();
// Creamos y abrimos un archivo zip temporal
 $zip->open("facturas.zip",ZipArchive::CREATE);
 // Añadimos un directorio
 $dir = 'comprobantes';
 //$zip->addEmptyDir($dir);



$consulta="SELECT  * from desglose where id_cheque ='$id' and comprobante!='' ";
$facs=mysqli_query($con,$consulta);



while($datos=mysqli_fetch_array($facs))
{
	$zip->addFile("../".$dir."/".$datos['comprobante'],$datos['comprobante']);
	//echo "<br>". $datos['comprobante'];
}


 // Añadimos un archivo en la raid del zip.
 //$zip->addFile($dir."/1.jpg","1.jpg");
 //Añadimos un archivo dentro del directorio que hemos creado
 //$zip->addFile($dir."/2.jpg","2.jpg");
 // Una vez añadido los archivos deseados cerramos el zip.
 $zip->close();
 // Creamos las cabezeras que forzaran la descarga del archivo como archivo zip.
 header("Content-type: application/octet-stream");
 header("Content-disposition: attachment; filename=facturas.zip");
 // leemos el archivo creado
 readfile('facturas.zip');
 // Por último eliminamos el archivo temporal creado
 unlink('facturas.zip');//Destruye el archivo temporal
?>
?>