<?php
    $title ="Gastos | ";
    include "head.php";
	$active10="active";
    include "sidebar.php";
?>

    <div class="right_col" role="main"><!-- page content -->
        <div class="">
            <div class="page-title">
                <div class="clearfix"></div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                   
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Gastos Rechazados !</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        
                      

                        <!-- form print -->
                        <form class="form-horizontal" role="form" id="data_expence">
                        	 <div class="form-group row">
	                            
	                            	<div class="col-md-3 pull-left">
                                        <input type="date" class="form-control" id="date" value="2018-01-01">
	                            	</div>

                                    <div class="col-md-3 pull-left">
                                        <input type="date" class="form-control" id="date2" value="<?php echo date('Y-m-d');?>">
                                    </div>

	                            	<div class="col-md-3 pull-left">
		                                <select id="user" class="form-control" onchange="load(1);">
                                        <option value="0">--Selecciona un usuario--</option>
                                        <?php
                                        $where="";
                                        if($_SESSION['user_tipo']=="0" || $_SESSION['user_tipo']=="1")
                                        {
                                        }else{
                                            if($_SESSION['user_tipo']=="3" || $_SESSION['user_tipo']=="5" )
                                        {
                                            $where="where  programa='".$_SESSION['programa']."' and rutas IN ('".str_replace(",","','",$_SESSION['rutas'])."') and tipo!='5' ";
                                        }
                                         if($_SESSION['user_tipo']=="2" )
                                        {
                                            $where="where  id='".$_SESSION['user_id']."'   ";
                                        }
                                         
                                         if($_SESSION['user_tipo']=="4" )
                                        {
                                            $where="where  programa='".$_SESSION['programa']."'   ";
                                        }

                                        }
                                        $cons="SELECT * from user  $where order by name";
                                        $sql=mysqli_query($con,$cons);
                                        while($data=mysqli_fetch_array($sql))
                                        {
                                            ?>
                                            <option value="<?php echo $data['id'];?>"><?php echo utf8_encode($data['name']);?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
		                            </div>   
									<div class="col-md-3">
                                    <button type="button" class="btn btn-default" onclick='load(1);'>
                                        <span class="glyphicon glyphicon-search" ></span> Buscar</button>
										
									</div>	
	                              
	                        </div>    
                        </form>
                        <!-- end form print -->

                        <div class="x_content">
                            <div class="table-responsive">
                                <!-- ajax -->
                                <span id="loader"></span>
                                    <div id="resultados"></div><!-- Carga los datos ajax -->
                                    <div class='outer_div'></div><!-- Carga los datos ajax -->
                                <!-- /ajax -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /page content -->

<?php include "footer.php" ?>
<!-- Include Required Prerequisites -->

<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
 
<!-- Include Date Range Picker -->
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
<!--<script type="text/javascript" src="js/expences.js"></script>-->

<script type="text/javascript" src="js/VentanaCentrada.js"></script>
<script>

$(document).ready(function(){
    load(0);
});

function load(page){
    console.log(page);
    var date= $("#date").val();
    var date2= $("#date2").val();
    var user= $("#user").val();
    var category= $("#category").val();
    $("#loader").fadeIn('slow');

    $.ajax({
        url:'./ajax/rechazados.php?date='+date+"&date2="+date2+"&user="+user,
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
                load(0);
            }
        });
    }
}
/////

 var id_glob="";
    function obtener_datos(id){
        id_glob=id;
            $("#referencia").val(id);
            var description = $("#description"+id).val();
            var amount = $("#amount"+id).val();
			var category_id = $("#category_id"+id).val();
            $("#mod_id").val(id);
            $(".outer_div2").html('').fadeIn('slow');
            load2(id);
            /*$("#mod_description").val(description);
            $("#mod_amount").val(amount);
			$("#mod_category").val(category_id);*/
        }


        // function print
        $("#data_expence").submit(function(e){
        	e.preventDefault();
          var daterange= $("#daterange").val();
          var category = $("#category").val();
         VentanaCentrada('./pdf/documentos/expence_pdf.php?daterange='+daterange+'&action=ajax','Gasto','','1024','768','true');
        });

</script>

<script type="text/javascript">
$(function() {
    $('input[name="daterange"]').daterangepicker({
		 locale: {
      format: 'DD/MM/YYYY',
	  "applyLabel": "Aplicar",
	  "cancelLabel": "Cancelar",
	  "daysOfWeek": [
            "Do",
            "Lu",
            "Ma",
            "Mi",
            "Ju",
            "Vi",
            "Sa"
        ],
       "monthNames": [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre"
        ],		
    }
	});
});

function load2(id){
    
    $("#loader2").fadeIn('slow');
    
    $.ajax({
        url:'./ajax/carga_rechazados.php?id='+id,
        beforeSend: function(objeto){
        $('#loader2').html('<img src="./images/ajax-loader.gif"> Cargando...');
        },
        success:function(data){
            $(".outer_div2").html(data).fadeIn('slow');
            $('#loader2').html('');
        }
    })
}

$( "#add_income" ).submit(function( event ) {
  $('#save_data').attr("disabled", true);
  var ref=$('#referencia').val();
  
 var parametros = $(this).serialize();
     $.ajax({
            type: "POST",
            url: "action/add_income.php",
            data: parametros,
             beforeSend: function(objeto){
                $("#result_income").html("Mensaje: Cargando...");
              },
            success: function(datos){
            $("#result_income").html(datos);
            $('#save_data').attr("disabled", false);
            document.getElementById("formula1").value="";
            document.getElementById("formula2").value="";
            document.getElementById("formula3").value="";
            document.getElementById("formula4").checked=true;
            document.getElementById("monto_iva").value="";
            document.getElementById("formula6").selectedIndex = "0";
            load2(ref);
            load(0);
          }
    });
  event.preventDefault();
})

function id_subir(id)
{
    document.getElementById('id_gas').value=id;
    $("#respuesta").html('');
    $("#span_nombre").html('');
}

function eliminar_fichero(id,id_cheque)
{
    console.log(id);
    if (confirm("Realmente deseas eliminar el fichero?"))
    {
        $.post("action/eliminar_fichero.php", {id: id}, function(result){
            alert(result);
            if(!result.includes("Error"))
            {
                load2(id_glob);
                load(0);
            }
        });
    }
    
}
function iva(este)
{
    console.log(este.checked);
    var monto_iva=document.getElementById("monto_iva");
    var monto_iva_div=document.getElementById("monto_iva_div");
    if(este.checked==true)
    {
        monto_iva.value="";
        monto_iva.required=true;
        monto_iva_div.style="display:yes;";
    }else{
        monto_iva.value="0";
        monto_iva.required=false;
        monto_iva_div.style="display:none;";
    }
}

function ok_sup(este,opc)
{
    console.log(este.value);
    var formData = new FormData;
    var comen=document.getElementById("comen"+este.value);
    if(este.checked==true)
    {
        valor=1;
        if(opc=="2")
        {
            comen.style="display:none;";
            comen.value="";
        }
    }else
    {
        valor=0;
        if(opc=="2")
        {
            comen.style="display:yes;";
        }
    }

    
    $.post("action/ok_sup.php", {id: este.value,valor:valor,opc:opc}, function(result){
            alert(result);
            
    });


}

function guarda_com(este)
{
    este.style="border:solid #f00 1px;";
    console.log(este.value);
    var id =este.id.replace("comen","");
    var texto=este.value;
    console.log(id);
    $.post("action/comentario_cli.php", {id:id,comen:texto}, function(result){
        if(result=="1")
        {
            este.style="border:solid #0f0 1px;";
        }
        
            
    });


}
function sumar_iva(este)
{
    console.log(este.value);
    var iva=document.getElementById("monto_iva");
    var check=document.getElementById("formula4");
    if(check.checked==true)
    {
        console.log("si")
        iva.value=este.value*.16;

    }else
    {
        iva.value="0";
    }
}
function imprime_formato(id)
{
    window.open("pdf/documentos/comprobacion.php?id="+id, "_blank");

}

function reciclar(id)
{ 
    console.log(id);
    if(confirm("Restaurar gasto?")){
       $.post("action/reciclar.php",{id:id},function(result){
        
        alert(result);
        load(1);
       });
    }
}

</script>