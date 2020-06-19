<?php
	session_start();
	if (!isset($_SESSION['user_id']) && $_SESSION['user_id']==null) {
		header("location: ../");
	}

	include "../config/config.php";

	// Contiene la clase para cargar las imagenes
	include_once "../lib/class.upload.php";

	if(isset($_SESSION["user_id"]) && !empty($_POST)){
		if (isset($_POST['token1'])) {
			foreach ($_POST as $name => $value) {
				$sql = mysqli_query($con,"UPDATE configuration set val=\"$value\" where name=\"$name\"");
		   		// echo $value."=>".$name."<br>";
			}
			if ($sql) {
		   			// $msj=sha1(md5("actualizado correctamente"));
					header("location: ../settings.php?succes");
		   	}
		} 
		
	   	if (isset($_POST['token'])) {
	   		$handle = new Upload($_FILES['image']);
			if ($handle->uploaded) {
				$url="../images/";
				$handle->Process($url);
			    $image = $handle->file_dst_name;
			    $update_image=mysqli_query($con, "UPDATE configuration set val=\"$image\" WHERE name=\"logo\"");
			}
			$handle = new Upload($_FILES['image2']);
			if ($handle->uploaded) {
				$url="../images/";
				$handle->Process($url);
			    $image2 = $handle->file_dst_name;
			    $update_image2=mysqli_query($con, "UPDATE configuration set val=\"$image2\" WHERE name=\"favicon\"");
			}

			header("location: ../settings.php?succes");
	   	}
		// echo "actualizado correectamente";
	}else{

		// echo "hubo un error";
		header("location: ../settings?error=$msj");
	}
?>

