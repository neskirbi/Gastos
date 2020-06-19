<?php
include"config.php";
$consulta= $_REQUEST['consulta'];

$sql=mysqli_query($con,$consulta);
?>
<table border="1px" width="100%">
	

<?php
while ($data=mysqli_fetch_array($sql)) {
	?>
	<tr>
		<td><?php print_r($data);?></td>
	</tr>
	<?php
}
?>
</table>