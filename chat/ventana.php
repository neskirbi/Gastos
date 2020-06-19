<!DOCTYPE html>
<html>
<head>

<style type="text/css">
	.a{
		width: 20%;
		height: 30px;
		border: solid 1px #000;
		position: absolute;
		bottom: 0px;
		right: 0px;
		display: inline-block;
	}

	.aa{
		width: 99%;
		height: 500px;
		border: solid 1px #000;
		bottom: 0px;
		left: 0px;
		position: absolute;
		display: inline-block;
		overflow-y: scroll;
	}

	.b{
		width: 99%;
		height: 30px;
		border: solid 1px #100;
		

	}
	.c{
		width: 99%;
		height: 429px;
		border: solid 1px #100;
		overflow-y: scroll;
		

	}

	.cc{
		width: 100%;
		height: 0px;
		border: solid 1px #100;
		overflow-y: scroll;
		

	}

</style>
<?php
session_start();
?>
	<title></title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
<div style="z-index: 15; width: 75%; position: fixed; border: solid #000 0px; height: 30px; bottom: 0px; left: 0px; display: inline-block; " id="contenedor">
	
			
</div>

<div class="a" id="vusuu">

		<div class="b" id="tusu">
		<a href="#" onclick="desplegar1('usuu');">Usuarios</a>
		</div>

		<div class="cc" id="conusuu">
		
		</div>
	</div>





</body>
<script type="text/javascript">

var cliente=<?php echo $_SESSION['user_id']; ?>;
var ids='';
	
	function cargar_usuarios(rutas,programa)
	{

		console.log(rutas+"----"+programa);
		$.post("chat/ajax/usuario.php",{rutas:rutas,programa:programa},function(result){
			$('#conusuu').html(result);
			
		});
	}

	function chat(id,este)
	{

		if ($('#vusu'+id).length) {
  
	  		
		  console.log("ya esta abierta");

		} else {
			/*var hiper=document.createElement('a');
			hiper.html=este.innerHTML;
			$(div2).append(hiper);
*/
			var div = document.createElement('div');
			div.className="aa";
			div.id='vusu'+id;

			
			var div2 = document.createElement('div');
			div2.className="b";
			div2.id='tusu'+id;

			

			var div3 = document.createElement('div');
			div3.className="c";
			div3.id='conusu'+id;

			
			$(div).append(div2);
			$(div).append(div3);
			$('#contenedor').html(div);

			ids=id;
		}
		
		var idd="'usu"+id+"'";
		$('#tusu'+id).html('<a href="#" onclick="desplegar('+idd+')"> '+este.innerHTML+'</a>');

		$(div).append('<div> <input style="width:80%;" type="text" id="text'+id+'" ></input> <button onclick="enviar('+id+');">Enviar</button> </div>');


		

		
		
	}

	function conver()
	{

		//console.log(cliente+'----'+ids);

		$.post("chat/ajax/chats.php",{ids:ids,cliente:cliente},function(result){
			//console.log(result);
			var res=JSON.parse(result);
			var arreglo=JSON.parse(res.contenido);
			//console.log(arreglo.length);

			for(var i=0;i<arreglo.length;i++)
			{
				//console.log(arreglo[i].id);
				//console.log(arreglo[i].msn);

				
				$('#conusu'+arreglo[i].id).html(arreglo[i].msn);
				
			}
		});
	}



	function desplegar(id)
	{
		var div=document.getElementById('v'+id);
		var divcon=document.getElementById('con'+id);
		var h=div.clientHeight;
		if(h>30)
		{
			div.style.height='30px';
			divcon.style.height='0px';
		}else{
			div.style.height='500px';
			divcon.style.height='429px';
		}
		
	}

	function desplegar1(id)
	{
		var div=document.getElementById('v'+id);
		var divcon=document.getElementById('con'+id);
		var h=div.clientHeight;
		if(h>30)
		{
			div.style.height='30px';
			divcon.style.height='0px';
		}else{
			div.style.height='500px';
			divcon.style.height='469px';
		}
		
	}

	function enviar(id)
	{
		var msn = document.getElementById("text"+id).value;
		console.log(id+"---"+msn);
		$.post("chat/action/enviar.php",{id:id,msn:msn},function(result){
			document.getElementById("text"+id).value="";
		});
		
	}


cargar_usuarios(<?php echo json_encode($_SESSION['rutas']); ?>,<?php echo $_SESSION['programa']; ?>);
setInterval(function(){ conver(); }, 200);
</script>
</html>