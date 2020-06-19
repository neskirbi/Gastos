$(document).ready(function(){
	load(1);
});

function load(page){
	var daterange= $("#daterange").val();
	var category= $("#category").val();
	$(".outer_div").html('');
	$("#loader").fadeIn('slow');
	$.ajax({
		url:'./ajax/income.php?action=ajax&page='+page+'&daterange='+daterange+'&category='+category,
		beforeSend: function(objeto){
			$('#loader').html('<img src="./images/ajax-loader.gif"> Cargando...');
		},
		success:function(data){
			$(".outer_div").html(data).fadeIn('slow');
			$('#loader').html('');
		}
	})
}



function eliminar (id){
	var q= $("#q").val();
	if (confirm("Realmente deseas eliminar el ingreso?")){	
		$.ajax({
		type: "GET",
		url: "./ajax/income.php",
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