<?php
    $title ="Ingresos | ";
    include "head.php";
	$active3="active";
    include "sidebar.php"; 
?>
    <div class="right_col" role="main"> <!-- page content -->
        <div class="">
            <div class="page-title">
                <div class="clearfix"></div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <?php
                        include("modal/new_income.php");
                        include("modal/upd_income.php");
                    ?>
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Ingresos</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        
                       

                        <!-- form print -->
                        <form class="form-horizontal" role="form" id="data_income">
                             <div class="form-group row">
                                <input type="hidden" class="form-control" id="name_user" value="<?php echo $name; ?>">
                                    <div class="col-md-3 pull-left">
                                       <input type="text" class="form-control" id="daterange" name="daterange" value="<?php echo "01/".date("m/Y")." - ".date("d/m/Y");?>" readonly onchange="load(1);">
                                    </div>
                                    <div class="col-md-6 pull-left">
                                        <select class="form-control" id="category" name="category" onchange="load(1);">
                                            <option selected="" value="0">-- Imprimir por Categoria --</option>
                                            <?php
                                            $gastos = mysqli_query($con,"SELECT * FROM gastos as gas 
                                            join cheques as che on che.id=gas.id_cheque
                                            join user as usu on usu.id=che.beneficiario ");
                                            while ($cat=mysqli_fetch_array($gastos)) { ?>
                                            <option value="<?php echo $cat['id_cheque']; ?>"><?php echo $cat['name']."  $ ".$cat['monto']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div> 
											
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-default pull-right">
                                      <span class="glyphicon glyphicon-print"></span> Imprimir
                                    </button>
                                </div>  
                            </div>    
                        </form>
                       
                        <!-- end form print -->

                        <div class="x_content">
                            <div class="table-responsive">
                                <!-- ajax -->
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
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
 
<!-- Include Date Range Picker -->
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
<script type="text/javascript" src="js/income.js"></script>
<script type="text/javascript" src="js/VentanaCentrada.js"></script>
<script>
$( "#add_income" ).submit(function( event ) {
  $('#save_data').attr("disabled", true);
  
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
            load(1);
          }
    });
  event.preventDefault();
})

// success

$( "#upd_income" ).submit(function( event ) {
  $('#upd_data').attr("disabled", true);
  
 var parametros = $(this).serialize();
     $.ajax({
            type: "POST",
            url: "action/upd_income.php",
            data: parametros,
             beforeSend: function(objeto){
                $("#result_income2").html("Mensaje: Cargando...");
              },
            success: function(datos){
            $("#result_income2").html(datos);
            $('#upd_data').attr("disabled", false);
            load(1);
          }
    });
  event.preventDefault();
})

    function obtener_datos(id){
            var description = $("#description"+id).val();
            var amount = $("#amount"+id).val();
			var category_id = $("#category_id"+id).val();
            $("#mod_id").val(id);
            $("#mod_description").val(description);
            $("#mod_amount").val(amount);
			$("#mod_category").val(category_id);
        }


        // function print
        $("#data_income").submit(function(e){
            e.preventDefault();
          var daterange = $("#daterange").val();
          var category = $("#category").val();
          

         VentanaCentrada('./pdf/documentos/income_pdf.php?daterange='+daterange+'&category='+category,'Gasto','','1024','768','true');
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

function add_ref()
{
    var valor=document.getElementById("category");
    console.log(valor.value);
    document.getElementById("referencia").value=valor.value;
    if(valor.value==0)
    {
       $("#result_income").html('<div class="alert alert-danger" role="alert"> <button type="button" class="close"  data-dismiss="alert">&times;</button> <strong>Error! Seleccione un gasto</strong>  </div>'); 
    }
    else{
        $("#result_income").html("");
    }
}
</script>