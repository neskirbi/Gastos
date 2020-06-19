		$(document).ready(function(){
			load(1);
		});

		

	
		
			function cancelar_cheque(id)
		{
			var q= $("#q").val();
		if (confirm("Realmente deseas eliminar al usuario?")){	
		$.ajax({
        type: "GET",
        url: "./ajax/cheques.php",
        data: "id="+id,"q":q,
		 beforeSend: function(objeto){
			$("#resultados").html("Mensaje: Cargando...");
		  },
        success: function(datos){
		$("#resultados").html(datos);
		load(1);
		}
			});
		}
		}
		
		
		
		

