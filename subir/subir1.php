<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Subir</title>
	<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>-->
</head>
<body>
<span id="respuesta"></span>
<button class="btn btn-success" onclick="clickea();"><i class="glyphicon glyphicon-plus" ></i> Agregar archivo</button>
<span id="span_nombre"></span>
<form id="io" action="subir/subir2.php" enctype="multipart/form-data" method="post">
<input name="imagen" id="imagen" type="file" style="visibility: hidden;" onchange="nombre();">
<input name="complemento" id="imagen" type="file" style="visibility: hidden;" value="complemento">
<input type="text" name="id" id="id_gas1" style="visibility: hidden;">

<input type="text" name="nombre_ima" class="form-control" id="nombre_ima" placeholder="Folio de la factura o numero de ticket" required>
<br>
<input class="btn btn-primary" type="button" onclick="guardar();"   value="Aceptar">
</form>
	
</body>
<script>
	function guardar() 
    {
        var nombre=document.getElementById("nombre_ima").value;
        if(nombre.length==32){

            var frm=$("#io");
            //var datos = $('#io').serialize();
            var formData = new FormData;
            formData.append("imagen",$("input[name=imagen]")[0].files[0]);
            formData.append("id",$("input[name=id]")[0].value);
            formData.append("nombre_ima",$("input[name=nombre_ima]")[0].value.replace(' ',''));
            $.ajax({
                    url: frm.attr("action"),
                    type: frm.attr("method"),
                    data: formData,    
                    contentType: false,
                    cache: false,
                    processData: false,        
                    success: function(data) {
                    $("#respuesta").html(data);
                    load2(id_glob);
                    load(1);
                    } 
                
            });
        }else
        {
            alert("Revisar el folio fiscal.");
        }
	
}

function clickea()
{
    document.getElementById("imagen").click();
}

function nombre()
{
    var file = $("#imagen")[0].files[0]; 
    $("#span_nombre").html(file.name);
}
</script>
</html>