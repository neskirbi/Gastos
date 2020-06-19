<?php


function destinatarios()
{
	global $con;
	$filtro="";

	if ($_SESSION['user_tipo']=="-3") {
		$filtro=" or id!='0' ";
	}

	?>
		<select id="destina" name="destina" class="form-control" style="width: 150px;">
		<option value="0">--Destinatario--</option>
		<option value="54">Soporte</option>
		<?php 
		$pro=$_SESSION['programa'];
		$cons="SELECT * from user where programa='$pro' $filtro  order by name";
		$sql=mysqli_query($con,$cons);
		while ($r=mysqli_fetch_array($sql)) {
			?>
			 <option value="<?php echo $r['id']; ?>"><?php echo $r['name']; ?></option>
			<?php
		}
		?>			
		</select>

	<?php
}
?>