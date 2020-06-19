<?php
	/*-------------------------
	Autor: Ing. Adrian Augusto Sosa Perez
	---------------------------*/
	error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
    date_default_timezone_set('America/Mexico_City');
	session_start();
	if (!isset($_SESSION['user_id']) AND $_SESSION['user_id'] != 1) {
        header("location: ../../");
		exit;
    }
	/* Connect To Database*/
	include("../../config/config.php");
	$session_id= session_id();

	require_once(dirname(__FILE__).'/../html2pdf.class.php');

	$id= $_REQUEST['id'];

		
	//Variables por GET
	//$daterange = mysqli_real_escape_string($con,(strip_tags($_REQUEST['daterange'], ENT_QUOTES)));
	//$category=intval($_REQUEST['category']);
    // get the HTML
     ob_start();
     include(dirname('__FILE__').'/res/factura.php');
    $content = ob_get_clean();

    try
    {
        // init HTML2PDF
        $html2pdf = new HTML2PDF('P', 'LETTER', 'es', true, 'UTF-8', array(0, 0, 0, 0));
        // display the full page
        $html2pdf->pdf->SetDisplayMode('fullpage');
        // convert
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        // send the PDF
        $html2pdf->Output('Factura_detalle.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }