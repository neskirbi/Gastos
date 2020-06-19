$(document).ready(function(){
	load(1);
});

function load(page){
	var daterange= $("#daterange").val();
	var category= $("#category").val();
	$("#loader").fadeIn('slow');
	$.ajax({
		url:'./ajax/expences.php?action=ajax&page='+page+'&daterange='+daterange+"&category="+category,
		beforeSend: function(objeto){
			$('#loader').html('<img src="./images/ajax-loader.gif"> Cargando...');
		},
		success:function(data){
			$(".outer_div").html(data).fadeIn('slow');
			$('#loader').html('');
		}
	})
}







function eliminar (id)
{
	console.log(id);
	var q= $("#q").val();
	if (confirm("Realmente deseas eliminar el gasto?")){	
		$.ajax({
			type: "GET",
			url: "./ajax/expences.php",
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