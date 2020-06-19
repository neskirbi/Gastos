<?php
session_start();
include"../config/config.php";
$destina=$_SESSION['user_id'];
$consulta="SELECT n.visto,n.id,n.asunto,n.destina,n.mensaje,n.fecha,u.name 
from notificaciones as n 
join user as u on u.id=n.remitente 
where n.destina=$destina order by fecha asc";
$sql=mysqli_query($con,$consulta);
while ($row=mysqli_fetch_array($sql)) 
{

	if ($row['visto']!='0') {
		?>
	    <a class="btn btn-default" style="width: 100%;" onclick="carga_msn(<?php echo $row['id'];?>); ">
	       <?php echo $row['asunto']."<br>".utf8_encode($row['name'])." ".$row['fecha']; ?>
	    </a>

	    <?php
	}else
	{
		?>
	    <a class="btn btn-info" style="width: 100%;" onclick="carga_msn(<?php echo $row['id'];?>); ">
	       <?php echo $row['asunto']."<br>".utf8_encode($row['name'])." ".$row['fecha']; ?>
	    </a>

	    <?php
	}
    
}

?>