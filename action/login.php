<?php
	session_start();

	if (isset($_POST['token']) && $_POST['token']!=='') {
			
	//Contiene las variables de configuracion para conectar a la base de datos
	include "../config/config.php";

	$email=mysqli_real_escape_string($con,(strip_tags($_POST["email"],ENT_QUOTES)));
	$password=((mysqli_real_escape_string($con,(strip_tags($_POST["password"],ENT_QUOTES)))));

    $query = mysqli_query($con,"SELECT * FROM user WHERE email = '" . $email . "' AND password = '" . $password . "';");

		if ($row = mysqli_fetch_array($query)) {
			if ($row['status']==1) { //comprobamos que el usuario este activo

				$_SESSION['user_id'] = $row['id'];
				$_SESSION['user_tipo'] = $row['tipo'];
				$_SESSION['programa'] = $row['programa'];
				$_SESSION['rutas'] = $row['rutas'];

				switch($_SESSION['user_tipo'])
				{
					case "-3":
					header("location: ../dashboard.php");
					break;
					case "-2":
					header("location: ../expences.php");
					break;
					case "-1":
					header("location: ../dashboard.php");
					break;
					case "0":
					header("location: ../dashboard.php");
					break;
					case "1":
					header("location: ../cheque.php");
					break;
					case "2":
					header("location: ../dashboard.php");
					break;
					case "3":
					header("location: ../dashboard.php");
					break;
					case "4":
					header("location: ../dashboard.php");
					break;
					case "5":
					header("location: ../dashboard.php");
					break;
				}
				
			}else{
				$error=sha1(md5("cuenta inactiva"));
				header("location: ../index.php?error=$error");
			}
		}else{
			$invalid=sha1(md5("contrasena y email invalido"));
			header("location: ../index.php?invalid=$invalid");
		}
	}else{

		header("location: ../");
	}

?>