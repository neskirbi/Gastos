<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<body>

<textarea id="consulta"></textarea>
<button onclick="enviar();">enviar </button>
<div style="width: 100%;" id="res"></div>

</body>
<script type="text/javascript">
	
	function enviar()
	{
		var consulta=document.getElementById("consulta").value;
		console.log(consulta);
		$.post("consultas2.php",{consulta:consulta},function(result){
			document.getElementById("res").innerHTML=result;
		});
	}
</script>

</html>