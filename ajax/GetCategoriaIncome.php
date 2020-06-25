<?php

include"../config/config.php";

$sql="SELECT * from category_income order by id asc";
$rows = mysqli_query($con,$sql);
$html='<option value="0">--Categoria--</option>';
while ($row=mysqli_fetch_array($rows)){
	$html.='<option value="'.$row['id'].'">'.$row['name'].'</option>';
}

echo $html;

?>

