<?php 
session_start();
$message='';
if (isset($_POST['uploadBtn']) && $_POST['uploadBtn'] == 'Subir')
{
  if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK)
  {
    // get details of the uploaded file
    $folio=$_POST['folioChq'];
    $fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
    $fileName = $_FILES['uploadedFile']['name'];
    $fileSize = $_FILES['uploadedFile']['size'];
    $fileType = $_FILES['uploadedFile']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));
    // sanitize file-name
    $newFileName = "voucher-".$folio . '.' . $fileExtension;
    // check if file has one of the following extensions
    $allowedfileExtensions = array('jpg', 'gif', 'png', 'zip', 'txt', 'xls', 'doc','xlsx','docx');
    if (in_array($fileExtension, $allowedfileExtensions))
    {
      // directory in which the uploaded file will be moved
      $uploadFileDir = './vouchers/';
      $dest_path = $uploadFileDir . $newFileName;
      if(move_uploaded_file($fileTmpPath, $dest_path)) 
      {
        $message ='Archivo cargado';
        
      }
      else 
      {
        $message = 'Error al cargar el archivo';
        
      }
    }
    else
    {
      $message = 'Error al cargar. Tipos de archivo permitidos: ' . implode(',', $allowedfileExtensions);
      
    }
  }
  else
  {
    $message = 'Favor de verificar el siguiente problema.<br>';
    $message .= 'Error:' . $_FILES['uploadedFile']['error'];
    
  }
}

$_SESSION['message'] = $message;
header("Location:expences.php");