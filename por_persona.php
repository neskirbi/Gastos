<?php
    $title ="Gastos Categorias | ";
    include "head.php";
	$active5="active";
    include "sidebar.php";
    session_start();
?>
        
    <div class="right_col" role="main"><!-- page content -->
        <div class="">
            <div class="page-title">
                <div class="clearfix"></div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <?php
                        //include("modal/new_category_expences.php");
                        //include("modal/upd_category_expences.php");
                    ?>
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Categorias <small>Gastos</small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        
                        <!-- form search -->
                        <form class="form-horizontal" role="form" id="category_expence">
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <select id="user" class="form-control" onchange="load(1);">
                                        <option value="0">--Selecciona un usuario--</option>
                                        <?php
                                        $where="";
                                        if($_SESSION['user_tipo']=="0" || $_SESSION['user_tipo']=="1")
                                        {
                                        }else{
                                            $where="where  programa='".$_SESSION['programa']."' ";
                                            
                                        }
                                        $cons="SELECT * from user  $where order by name asc ";
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
                                    <input type="date" class="form-control" id="fecha" value="<?php echo "2018-01-01"?>" onchange='load(1);'>
                                </div>
                                <div class="col-md-3">
                                    <input type="date" class="form-control" id="fecha2" value="<?php echo date('Y-m-d')?>" onchange='load(1);'>
                                </div>


                                <div class="col-md-3">
                                    <select id="cat" class="form-control" onchange="load(1);">
                                        <option value="">--Categoria--</option>
                                        <?php
                                        $cons="SELECT * from category_income order by name asc ";
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



                                <div class="col-md-1">
                                    <span id="loader"></span>
                                </div>
                                
                               
                              
                                <div class='col-md-1'>
                                    <button type="button" class="btn btn-default" onclick='imprimirpor_persona();'>
                                        <span class="glyphicon glyphicon-print" ></span> Imprimir
                                    </button>
                                </div>
                            </div>
                        </form>    
                        <!-- end form search -->

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

<!--<script type="text/javascript" src="js/por_persona.js"></script>-->
<script type="text/javascript" src="js/VentanaCentrada.js"></script>
<script>
$( "#add_category_expence" ).submit(function( event ) {
  $('#save_data').attr("disabled", true);
  
 var parametros = $(this).serialize();
     $.ajax({
            type: "POST",
            url: "action/add_category_expences.php",
            data: parametros,
             beforeSend: function(objeto){
                $("#result_c_expence").html("Mensaje: Cargando...");
              },
            success: function(datos){
            $("#result_c_expence").html(datos);
            $('#save_data').attr("disabled", false);
            load(1);
          }
    });
  event.preventDefault();
})

// success

$( "#upd_c_expence" ).submit(function( event ) {
  $('#upd_data').attr("disabled", true);
  
 var parametros = $(this).serialize();
     $.ajax({
            type: "POST",
            url: "action/upd_category_expences.php",
            data: parametros,
             beforeSend: function(objeto){
                $("#result_c_expence2").html("Mensaje: Cargando...");
              },
            success: function(datos){
            $("#result_c_expence2").html(datos);
            $('#upd_data').attr("disabled", false);
            load(1);
          }
    });
  event.preventDefault();
})

    function obtener_datos(id){
            var name = $("#name"+id).val();
            $("#mod_id").val(id);
            $("#mod_name").val(name);
        }

        

        function load(page){
            var fecha= $("#fecha").val();
            var user= $("#user").val();
            var fecha2= $("#fecha2").val();
            var cat=$("#cat").val();
            $("#loader").fadeIn('slow');
            $.ajax({
                url:'./ajax/por_persona.php?fecha='+fecha+'&fecha2='+fecha2+'&user='+user+'&cat='+cat,
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
            var q= $("#q").val();
        if (confirm("Realmente deseas eliminar la categoria?")){    
        $.ajax({
        type: "GET",
        url: "./ajax/category_expences.php",
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

function imprimirpor_persona()
{
    //numero de cheques
    var fecha = document.getElementById("fecha").value;
    var fecha2 = document.getElementById("fecha2").value;
    var user = document.getElementById("user").value;
    //alert(cheques);
    VentanaCentrada('./pdf/documentos/por_persona_pdf.php?fecha='+fecha+'&fecha2='+fecha2+'&user='+user,'Por persona','','1024','768','true');   
}
function valores(importe,iva,total,diferencia,contid)
{
    document.getElementById("d"+contid).innerHTML=importe;
    document.getElementById("nd"+contid).innerHTML=iva;
    document.getElementById("t"+contid).innerHTML=total;
    document.getElementById("di"+contid).innerHTML=diferencia;
}        

$(document).ready(function(){
            load(1);
        });
</script>