<?php
    $title ="Comprobaciones | ";
    include "head.php";
	$active11="active";
    include "sidebar.php";
?>

    <div class="right_col" role="main"><!-- page content -->
        <div class="">
            <div class="page-title">
                <div class="clearfix"></div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <?php
                        include("modal/desglose.php");
                        //include("modal/pedir_cheque.php");

                        
                    ?>
                    <button type="button" class="btn btn-primary" onclick="soli_reembolso();" ><i class="fa fa-plus-circle"></i> Solicitar Reembolso</button>
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
                        <form class="form-horizontal" role="form" id="data_expence">
                        	 <div class="form-group row">
	                            <input type="hidden" class="form-control" id="name_user" value="<?php echo $name; ?>">
	                            	<!--<div class="col-md-3 pull-left">

	                                	<input type="text" class="form-control" id="daterange" name="daterange" value="<?php echo "01/".date("m/Y")." - ".date("d/m/Y");?>" readonly onchange="load(0);">
	                            	</div>-->

                                    <div class="col-md-2.5 pull-left">
                                        <?php
                                        $fechaini=date('2018-01-01');
                                        if($_SESSION['user_tipo']=="-2")
                                        {
                                            $fechaini=date('Y-m-d');
                                        }
                                        ?>
                                        
                                        <input type="date" class="form-control" id="date1" name="date1"   onchange="load(1);" value="<?php echo $fechaini; ?>">
                                    </div>

                                    <div class="col-md-2.5 pull-left">
                                        
                                        <input type="date" class="form-control" id="date2" name="date2"   onchange="load(1);" value="<?php echo date('Y-m-d'); ?>">
                                    </div>


                                    <div class="col-md-3">
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

                                <div class="col-md-2">
                                    <select id="cat" class="form-control"  onchange="load(1);">
                                        <option value="0">--Categoria--</option>
                                        <?php
                                            $consulta="SELECT * from clasificacion";
                                            $sql=mysqli_query($con,$consulta);
                                            while ($data=mysqli_fetch_array($sql))
                                            {
                                                ?>
                                                    <option value="<?php echo $data['id']?>"><?php echo utf8_encode($data['name'])?></option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                        
                                </div>  
	                            	
                                    <button type="button" class="btn btn-default" onclick="load(1);">
                                        <span class="glyphicon glyphicon-search" ></span> Buscar</button>
									
                                    <button  type="button" class="btn btn-default " onclick="exportar_control();">
                                      <span class="fa fa-file-excel-o"></span></button>
                                      
                                 
	                        </div>   
                            <?php
                            
                             $sel1="";
                             $sel2="";
                            $status=intval($_REQUEST['g']);
                            
                            if ($status==1) {
                                $sel1="selected";
                            }else if ($status==2) {
                                $sel2="selected";
                            }

                            ?>
                             <select onchange="load(1);" id="status" class="form-control" style="width: 20%;">
                                        <option value="0">--Status--</option>
                                        <option <?php echo $sel1; ?> value="1">Comprobados</option>
                                        <option <?php echo $sel2; ?> value="2">No Comrobados</option>
                                      </select> 
                        </form>
                        <!-- end form print -->

                        <div class="x_content">
                            <div class="table-responsive">
                                <!-- ajax -->
                                <span id="loader"></span>
                                    <div id="resultados"></div><!-- Carga los datos ajax -->
                                    <div class='outer_div' style="height: 600px; overflow-y: scroll;"></div><!-- Carga los datos ajax -->
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

 $( "#p_cheque" ).submit(function( event ) {
    

  
    var parametros = $(this).serialize();
     $.ajax({
            type: "POST",
            url: "action/pedir-cheque.php",
            data: parametros,
             beforeSend: function(objeto){
                $("#result_user").html("Mensaje: Cargando...");
              },
            success: function(datos){
            
            $("#result_user").html(datos);
            var substring = "Error";
            if(datos.indexOf(substring) == -1)
            {
                document.getElementById("p_cheque").reset();
            }
            
            load(0);
          }
    });
  event.preventDefault();
})

 


function load(page){
    console.log(page);
    //var daterange= $("#daterange").val();
    var date1= $("#date1").val();
    var date2= $("#date2").val();
    var status= $("#status").val();
    var user= $("#user").val();
    var cat= $("#cat").val();
    $("#loader").fadeIn('slow');
    $.ajax({
        url:'./ajax/expences.php?action=ajax&page='+page+'&date1='+date1+"&date2="+date2+"&status="+status+"&user="+user+"&cat="+cat,
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
        url:'./ajax/cargar_desglose.php?id='+id,
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
            url: "action/add_gasto.php",
            data: parametros,
            beforeSend: function(objeto)
            {
                $("#result_income").html("Mensaje: Cargando...");
            },
            success: function(datos){
                if(datos.includes("#1#")){
                    alert(datos.replace("#1#",""));
                }else{
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
          }
    });
  event.preventDefault();
})





//
$( "#edi_income" ).submit(function( event ) {
  //$('#edi_data').attr("disabled", true);
  var ref=$('#referencia').val();
  
 var parametros = $(this).serialize();
     $.ajax({
            type: "POST",
            url: "action/edi_gasto.php",
            data: parametros,
            beforeSend: function(objeto)
            {
                $("#edi_result_income").html("Mensaje: Cargando...");
            },
            success: function(datos){
                $("#edi_result_income").html(datos);
                obtener_datos(ref);
          }
    });
  event.preventDefault();
})
//

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


function iva2(este)
{
    console.log(este.checked);
    var monto_iva=document.getElementById("edi_monto_iva");
    var monto_iva_div=document.getElementById("monto_iva_div2");
    if(este.checked==true)
    {
        monto_iva.value="";
        monto_iva.required=true;
        monto_iva_div.style="display:yes;";
    }else{
        monto_iva.value="0";
        monto_iva.required=false;
        monto_iva_div.style="display:none;";
        sumar_iva2();
    }
}

function guarda_com_sup(este)
{
    este.style="border:solid #E7A3A3 1px; background-color: #EEAAAA;";
    console.log(este.value);
    var id =este.id.replace("comen1","");
    var texto=este.value;
    console.log(id);
    $.post("action/com_sup.php", {id:id,comen:texto}, function(result){
        if(result=="1")
        {
            este.style="border:solid #D0DDB5 1px; background-color: #D7E4BC;";
        }
        
            
    });
}


function guarda_com_cli(este)
{
    este.style="border:solid #E7A3A3 1px; background-color: #EEAAAA;";
    console.log(este.value);
    var id =este.id.replace("comen2","");
    var texto=este.value;
    console.log(id);
    $.post("action/com_cli.php", {id:id,comen:texto}, function(result){
        if(result=="1")
        {
            este.style="border:solid #D0DDB5 1px; background-color: #D7E4BC;";
        }
        
            
    });


}


function guarda_com_val(este)
{
    este.style="border:solid #E7A3A3 1px; background-color: #EEAAAA;";
    console.log(este.value);
    var id =este.id.replace("comen3","");
    var texto=este.value;
    console.log(id);
    $.post("action/com_val.php", {id:id,comen:texto}, function(result){
        if(result=="1")
        {
            este.style="border:solid #D0DDB5 1px; background-color: #D7E4BC;";
        }
        
            
    });
}


function sumar_iva()
{

    var total=document.getElementById("total");
    var montoa=document.getElementById("formula3");
    var iva=document.getElementById("monto_iva");
    var check=document.getElementById("formula4");
    if(check.checked==true)
    {
        console.log("si")
        total.value=(iva.value*1)+(montoa.value*1);

    }else
    {
        total.value=(montoa.value*1);
    }
}

function sumar_iva2()
{

    var total=document.getElementById("edi_total");
    var montoa=document.getElementById("edi_monto");
    var iva=document.getElementById("edi_monto_iva");
    var check=document.getElementById("edi_dedu2");
    if(check.checked==true)
    {
        console.log("si")
        total.value=(iva.value*1)+(montoa.value*1);

    }else
    {
        total.value=(montoa.value*1);
    }
}


function imprime_formato(id)
{
    window.open("pdf/documentos/comprobacion.php?id="+id, "_blank");

}

function eliminar_com(id)
{
    if (confirm("¿Realmente desea eliminar el gasto?")) 
    {
        $.post("action/eliminar_gasto.php",{id:id},function (result){
            alert(result);
            load2(id_glob);
            load(0);
        });
    }
    
}

function get_id_che(id)
{
    $.post("ajax/id_gastoche.php",{id:id},function(result){
        console.log(result);
    });
}

function ok_sup(este)
{
    var comen=document.getElementById("comen1"+este.value);

    var che="";
    if (este.checked) {
        che="1";
         comen.style="display:none;";
         comen.value="";

    }else
    {
        che="0";
         comen.style="display:yes;";
    }
    var id = este.value;
    console.log(id);
    $.post("action/ok_sup.php",{id:id,che:che},function(result){
        
            alert(result);
            get_id_che(id);
       
        
    });


}

function ok_cli(este)
{
    var comen=document.getElementById("comen2"+este.value);
    var che="";
    if (este.checked) {
        che="1";
        comen.style="display:none;";
        comen.value="";
    }else
    {
        che="0";
        comen.style="display:yes;";
    }
    var id = este.value;
    $.post("action/ok_cli.php",{id:id,che:che},function(result){
        
        alert(result);
        

       
        
    });


}
function ok_val(este)
{
    var comen=document.getElementById("comen3"+este.value);
    var che="";
    if (este.checked) {
        che="1";
        comen.style="display:none;";
        comen.value="";
    }else
    {
        che="0";
        comen.style="display:yes;";
    }
    var id = este.value;
    $.post("action/ok_val.php",{id:id,che:che},function(result){
        
            alert(result);
       
        
    });
}

function si_aid(este)
{
    
    var che="";
    if (este.checked) {
        che="1";
    }else
    {
        che="0";
        
    }
    var id = este.value;
    $.post("action/si_aid.php",{id:id,che:che},function(result){
        
            alert(result);
       
        
    });
}



function editar_gasto(id)
{
    var fecha=document.getElementById("edi_fecha");
    var desc=document.getElementById("edi_des");
    var monto=document.getElementById("edi_monto");
    var iva=document.getElementById("edi_monto_iva");
    var total=document.getElementById("edi_total");
    var dedu=document.getElementById("edi_dedu");
    var referencia=document.getElementById("referencia2");
    
    $.post("ajax/edi_gasto.php",{id:id},function(result){
        //alert(result);
        var obj = JSON.parse(result);

        referencia.value=obj['id'];        
        fecha.value=obj['created_at'];
        desc.value=obj['description'];
        monto.value=obj['amount'];
        iva.value=obj['iva'];
        total.value=(obj['iva']*1)+(obj['amount']*1);

        if(obj['deducible']=="0")
        {
            dedu.checked=false;
            iva(dedu);
        }

    });
}

function soli_reembolso()
{
    if(confirm("Agregar comprobación?"))
   {
    var user_id=<?php echo $_SESSION['user_id']; ?>;
    var user_tipo=<?php echo $_SESSION['user_tipo']; ?>;
    var programa=<?php echo $_SESSION['programa']; ?>;
    var monto=0;
    var fecha=<?php echo json_encode( date("Y-m-d")); ?>;
    var idben=<?php echo $_SESSION['user_id']; ?>;
    var nombreben="0";
    var clasificacion=22;
    var concepto="Reembolso de gastos";
    var category="3";

    console.log(user_id+"--"+user_tipo+"--"+programa+"--"+monto+"--"+fecha+"--"+idben+"--"+nombreben+"--"+clasificacion+"--"+concepto+"--"+category);

    $.post("action/pedir-cheque.php",{user_id:user_id,user_tipo:user_tipo,programa:programa,monto:monto,fecha:fecha,idben:idben,nombreben:nombreben,clasificacion:clasificacion,concepto:concepto,category:category},function(result){
        //alert(result);
        load(0);
    });
}
}
function solicitar_cheque(id)
{
   if(confirm("Realmente solicitas el reembolso?"))
   {
        $.post("action/solicitar_cheque.php",{id:id},function(result){
            if(!result.includes("Error")){
                get_mails(id);
               
                
                
            }
            alert(result);
           
        });
        load(0);
   }
   

}

function exportar_control()
{
    var date1= $("#date1").val();
    var date2= $("#date2").val();
    var category= $("#category").val();
    var user= $("#user").val();
    var cat= $("#cat").val();

    console.log(1);
    var win = window.open('excel/gastos.php?page=1&date1='+date1+"&date2="+date2+"&category="+category+"&user="+user+"&cat="+cat, '_blank');
    if (win) {
    //Browser has allowed it to be opened
    win.focus();
} else {
    //Browser has blocked it
    alert('Permitir ventanas emergentes para esta pagina.');
}
}

function get_mails(id)
{
    $.post("ajax/mails.php",{id:id} ,function (mails){
    //alert("Se notificará a: "+ mails);
   
    //var nombre=datos.1.0
    // [["raul.martinez@promo-tecnicas.com"],["dalia salazar "],["1072.9"]]
    

        var mensaje="Se ha solicitado el reembolso por parte de: {nombre} por un monto de: {monto}";
        datos=JSON.parse(mails);
        mensaje=mensaje.replace("{nombre}",datos[1][0] );
        mensaje=mensaje.replace("{monto}",datos[2][0]);
        mails=datos[0].join(",")+",luis.martinez@promo-tecnicas.com";
        console.log(mails);
        console.log(mensaje);
    
        send_mails(mails,mensaje);
      
                
     });   
}

function send_mails(mails,mensaje)
{
    
    $.post("http://cbd.mine.nu/mail/send_mails.php",{mails:mails,mensaje:mensaje} ,function (result){
    alert( result);
  });   
}






</script>

<?php
if($_SESSION['user_tipo']=="-2")
{
    echo"<script>
        $(document).ready(function(){
            load(1);
        });
    </script>";
}else{
    echo"<script>
    $(document).ready(function(){
        load(0);
    });
    </script>";
}




?>