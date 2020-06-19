<?php
    $title ="Facturaci&oacute;n | ";
    include "head.php";
	$active9="active";
    include "sidebar.php";
    include"modal/imp_cortes.php";
?>

    <div class="right_col" role="main"><!-- page content -->
        <div class="">
            <div class="page-title">
                <div class="clearfix"></div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div id="salida"> </div>
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Gastos</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        
                      

                        <!-- form print -->
                        
                        	 <div class="form-group row">
	                            <input type="hidden" class="form-control" id="name_user" value="<?php echo $name; ?>">
	                            	<div class="col-md-3 pull-left">
	                                	<select id="mes" name="fecha" class="form-control" >
                                            <option value="0">--Selecciona un mes--</option>
                                            <?php
                                            $fecha = '2018-01-01';
                                            $i=0;
                                            
                                                while ( $i <11 ) 
                                                { 
                                                    $nuevafecha = strtotime ( '+'.$i.' year' , strtotime ( $fecha ) ) ;
                                                    $nuevafecha = date ( 'Y' , $nuevafecha );
                                                    ?>
                                                    <option value="01-<?php echo $nuevafecha;?>">Enero <?php echo $nuevafecha;?></option>
                                                    <option value="02-<?php echo $nuevafecha;?>">Febrero <?php echo $nuevafecha;?></option>
                                                    <option value="03-<?php echo $nuevafecha;?>">Marzo <?php echo $nuevafecha;?></option>
                                                    <option value="04-<?php echo $nuevafecha;?>">Abril <?php echo $nuevafecha;?></option>
                                                    <option value="05-<?php echo $nuevafecha;?>">Mayo <?php echo $nuevafecha;?></option>
                                                    <option value="06-<?php echo $nuevafecha;?>">Junio <?php echo $nuevafecha;?></option>
                                                    <option value="07-<?php echo $nuevafecha;?>">Julio <?php echo $nuevafecha;?></option>
                                                    <option value="08-<?php echo $nuevafecha;?>">Agosto <?php echo $nuevafecha;?></option>
                                                    <option value="09-<?php echo $nuevafecha;?>">Septiembre <?php echo $nuevafecha;?></option>
                                                    <option value="10-<?php echo $nuevafecha;?>">Octubre <?php echo $nuevafecha;?></option>
                                                    <option value="11-<?php echo $nuevafecha;?>">Noviembre <?php echo $nuevafecha;?></option>
                                                    <option value="12-<?php echo $nuevafecha;?>">Diciembre <?php echo $nuevafecha;?></option>
                                                    <optgroup></optgroup>    

                                                    <?php
                                                    if($nuevafecha==date('Y'))
                                                    {
                                                        break;
                                                    }
                                                    $i++;
                                                }
                                            ?>
                                            
                                            
                                        </select>
	                            	</div>

                                    <div class="col-md-3 pull-left">
                                        <select id="programa" name="programa" class="form-control" >
                                            <option value="00">--Selecciona un programa--</option>
                                            <?php
                                            $consulta="SELECT * from programas ";
                                            $sql=mysqli_query($con,$consulta);
                                            while($sql_data=mysqli_fetch_array($sql))
                                            {
                                                ?>
                                                <option value="<?php echo $sql_data['id']; ?>"><?php echo $sql_data['name'];?></option>
                                                <?php
                                            }
                                            
                                            ?>
                                            
                                            
                                        </select>
                                    </div>
	                            	 
									<div class="col-md-2">
                                    <button type="button" class="btn btn-default" onclick='load(1);'>
                                        <span class="glyphicon glyphicon-search" ></span> Buscar</button>
										
									</div>	
	                                
                                    <div class="col-md-2 ">
                                    
                                    <button onclick="carga_corte();" type="button" class="btn btn-default pull-right" data-toggle="modal" data-target="#modal_cortes">
                                      <span class="glyphicon glyphicon-print"></span> Imprimir
                                    </button>
                                    </div>  


                                
	                        </div>    
                        
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

<script>


function carga_corte()
{
    var mes=document.getElementById("mes").value;
    var programa=document.getElementById("programa").value;
    console.log("--->"+programa);
    if(programa!="00")
    {
        $.post("ajax/t_cortes.php",{programa:programa},function(result){
            $("#cont_corte").html(result);
        });
    }
    
}

function imprimir_cor(id)
{
     window.open("pdf/documentos/factura.php?id="+id, "_blank");
    
}


function imprimir_cor_det(id)
{
     window.open("pdf/documentos/facturadeta.php?id="+id, "_blank");
    
}
function factura()
{
    var ids=document.getElementById("ids").value;
    var programa=document.getElementById("programa").value;
     
    var n_programa=document.getElementById("programa").options[document.getElementById("programa").selectedIndex].innerHTML;

    console.log(ids);
    if((ids*1)==0 && programa!="00")
    {
        alert("¡No hay nada por facturar!");
    }else{
        if(confirm("Desea hacer un corte de "+n_programa))
        {
            $.post("action/facturar.php", {programa:programa}, function(result){
                result=result.replace("(pro)",n_programa);
                $("#salida").html(result);
                
            });    
        }    
    }
    
    
load(1);
}



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
       

</script>

<script type="text/javascript">


function load(este){
    
    $("#loader2").fadeIn('slow');
    var mes=$('#mes').val();
    var programa=$('#programa').val();
    if(mes!="0" && programa!="00")
    {
        //periodo=mes;
       console.log(mes);
        
        $.ajax({
            url:'./ajax/factura.php?mes='+mes+'&programa='+programa,
            beforeSend: function(objeto){
            $('#loader2').html('<img src="./images/ajax-loader.gif"> Cargando...');
            },
            success:function(data){
                $(".outer_div").html(data).fadeIn('slow');
                $('#loader2').html('');
            }
        });
    }else
    {
        alert("Seleccione periodo y programa");
    }
    
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
            load(1);
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
                load(1);
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
load(1);
</script>