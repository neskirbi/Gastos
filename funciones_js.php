<script type="text/javascript">
function exportarcheques()
{
	//fecha
	//var fecha=document.getElementById("datepicker").value;
	//fecha
	//var fecha2=document.getElementById("datepicker1").value;
	//Supervisor
	//var superv=document.getElementById("nom").value;
	// Si no Supervisor 
	//var superv1=document.getElementById("nom1").value;
	//marcadores1 ruta
	//var m1=document.getElementById("m1").value;
	//marcadores2 tienda
	//console.log(m2[2][0]);

	document.location.target = "_blank";
	var url="excel/exportar_cheques.php";
	console.log(url);
	document.location.href=url;
}
</script>