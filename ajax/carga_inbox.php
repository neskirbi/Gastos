<?php
session_start();
include"../config/config.php";
$id=$_REQUEST['id'];

$consulta="SELECT u.profile_pic as pic,n.id,n.asunto,n.destina,n.mensaje,n.fecha,u.name 
from notificaciones as n 
join user as u on u.id=n.remitente 
where n.id=$id order by fecha asc";

$sql=mysqli_query($con,$consulta);
while ($row=mysqli_fetch_array($sql)) 
{
    ?>
    <table width="100%" style="height: 600px;">
    	<tr>
    		<td style="height: 60px; ">
    			<img height="60px" src="images/profiles/<?php echo $row['pic'];?>"  >
    			<font style="font-size: 15px;"><?php echo utf8_encode($row['name']);?></font>
    			<br>
    			<h3><?php echo $row['asunto'];?></h3>
    		</td>
    		<td style="width: 20%; "><font style="font-size: 12px;"><?php echo $row['fecha'];?></font>
    			
    		</td>
    	</tr>
    	
    	<tr>
    		
    			<td colspan="2" style=" vertical-align: top;">
    			<hr><center><?php echo $row['mensaje'];?></center>
    			<hr>
    			</td>
    	</tr>



    </table>

    <?php
}

$consulta="UPDATE notificaciones set visto=1 where id='$id'";
$sql=mysqli_query($con,$consulta);
?>