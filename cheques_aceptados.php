<?php
session_start();
if($_SESSION['user_tipo']=="4" || $_SESSION['user_tipo']=="1" || $_SESSION['user_tipo']=="0"|| $_SESSION['user_tipo']=="3"){
}else{
    echo("<script>
            this.location='dashboard.php';</script>");
}
    $title ="Solicitar cheque | ";
    include "head.php";
	$active4="active";
    include "sidebar.php"; 
?>
    <div class="right_col" role="main"> <!-- page content -->
        <div class="">
            <div class="page-title">
                <div class="clearfix"></div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <?php
                        include("modal/pedir_cheque.php");
                    ?>
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Autorización de Pagos Solicitados</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div id="result_user"></div>
                        
                        <!-- form search -->
                        <form class="form-horizontal" role="form" id="datos_cotizacion">
                            <div class="form-group row">
                                <div class="col-md-3 pull-left">
                                        <input type="date" class="form-control" id="date" name="date" value="<?php echo date('Y-m-d');?>"  onchange="load(1);">
                                    </div>
                               
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-default" onclick='load(1);'>
                                        <span class="glyphicon glyphicon-search" ></span> Buscar
                                    </button>
                                    
                                </div>
                              
                                <div class="col-md-2">
                                    
                                    <?php
                                    
                                    if($_SESSION['user_tipo']=="1" || $_SESSION['user_tipo']=="0")
                                    {
                                        ?>
                                        <button type="button" class="btn btn-default" onclick='exportar();'>
                                        <span class="glyphicon glyphicon-export" ></span> Exportar</button>
                                        
                                        
                                        <?php
                                    }
                                    ?>
                                    <!-- <span id="loader"></span> -->
                                </div>   
                                  <div class="col-md-3">
                                    <input type="text" style="width: 250px;" class="form-control" id="cheque" name="" placeholder="No. cheque ej. (1), (1,2,3), (1-13)" >
                                </div>
                                <div class="col-md-2">
                                    
                                    <!-- <span id="loader"></span> -->
                                    <?php
                                    
                                    if($_SESSION['user_tipo']=="1" || $_SESSION['user_tipo']=="0")
                                    {
                                        ?>
                                       
                                        <button type="button" class="btn btn-default" onclick='imprimircheque();'>
                                        <span class="glyphicon glyphicon-print" ></span> Imprimir</button>
                                        <?php
                                    }
                                    ?>
                                    <!-- <span id="loader"></span> -->
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

<?php 
include "footer.php" ;

?>
<script type="text/javascript" src="js/VentanaCentrada.js"></script>
<script type="text/javascript" src="js/cheques.js"></script>
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

        datos=datos.split(",");
       
        id=datos[1];
        ultimo_id=id;
        datos=datos[0]+datos[2];
        
        get_mails(id*1,"Se ha solicitado un cheque para: {nombre} por un monto de: {monto}");

        $("#result_user").html(datos);

        var substring = "Error";
        if(datos.indexOf(substring) == -1)
        {
            CargarGastos(id);
            
        }
        
        load(1);
      }
    });
  event.preventDefault();
});

function load(page){
            var q= $("#q").val();
            var daterange= $("#date").val();
            $("#loader").fadeIn('slow');
            $.ajax({
                url:'./ajax/cheques_aceptados.php?action=ajax&page='+page+'&daterange='+daterange+'&q='+q,
                 beforeSend: function(objeto){
                 $('#loader').html('<img src="./images/ajax-loader.gif"> Cargando...');
              },
                success:function(data){
                    $(".outer_div").html(data).fadeIn('slow');
                    $('#loader').html('');
                    
                }
            })
        } 

function exportar()
{
    document.location.target = "_blank";
    var url="excel/exportar_cheques.php";
    document.location.href=url;     
} 

function imprimircheque()
{
    //numero de cheques
    var cheques = document.getElementById("cheque").value;
    //alert(cheques);
    VentanaCentrada('./pdf/documentos/cheque_pdf.php?cheques='+cheques,'Cheque','','1024','768','true');   
}
        
 function rechazar_cheque(id,este)
{
    var q= $("#q").val();
    document.getElementById('a'+este).disabled= false;
    document.getElementById('c'+este).disabled= false;
    if (confirm("Realmente deseas rechazar el cheque?")){  
    $.ajax({
    type: "GET",
    url: "action/rechazar_cheque.php",
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

function cancelar_cheque(id,este)
{
    var q= $("#q").val();
    
    if (confirm("Realmente deseas cancelar el cheque?")){  
    $.ajax({
    type: "GET",
    url: "./action/cancelar_cheque.php",
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


    function aceptar_cheque(id,este)
    {
        document.getElementById('a'+este).disabled= false;
        document.getElementById('c'+este).disabled= false;
        var no_cheque=document.getElementById('no_cheque'+este).value;
        if(no_cheque.length!=0)
        {
            var q= $("#q").val();
            if (confirm("Realmente deseas aceptar el cheque")){  
            $.ajax({
            type: "GET",
            url: "action/aceptar_cheque.php",
            data: "id="+id+"&nocheque="+no_cheque,
             beforeSend: function(objeto){
                $("#resultados").html("Mensaje: Cargando...");

                
              },
            success: function(datos){
                console.log(datos);
            $("#resultados").html(datos);
            get_mails((id*1),"Se a aprovado el  gasto para : {nombre} por un monto de: {monto} con numero de cheque: "+no_cheque);
            load(1);
            }
                });
            }
        }else{
            alert('Debes introducir numero de cheque');
        }
        
    }

function get_mails(id,mensaje)
{
    $.post("ajax/mails.php",{id:id} ,function (mails){
    //alert("Se notificará a: "+ mails);
   
    //var nombre=datos.1.0
    // [["raul.martinez@promo-tecnicas.com"],["dalia salazar "],["1072.9"]]
    
        //var mensaje="Se ha solicitado un cheque para: {nombre} por un monto de: {monto}";
        datos=JSON.parse(mails);
        mensaje=mensaje.replace("{nombre}",datos[1][0] );
        mensaje=mensaje.replace("{monto}",datos[2][0]);
        mails=datos[0].join(",");
    
        send_mails(mails,mensaje);
      
                
     });   
}


function send_mails(mails,mensaje)
{
    
    $.post("http://cbd.mine.nu/mail/send_mails.php",{mails:mails,mensaje:mensaje} ,function (result){
    alert( result);
  });   
}


function GenerarSantanderFolio(){
    if (!$('#referencia').is(":checked"))
    {
        var folio=$('#folio').val();
        var secobra=$('#se_cobra_a_list').val();
        var benefi=$('#idben').val();
        //var secobra=$('#se_cobra_a_list option:selected').text();
        //var benefi=$('#idben option:selected').text();

        if(folio!=""){
            $('#FolioSantander').val(folio+"-"+secobra+"-"+benefi);
        }else{
             $('#FolioSantander').val("");
        }
    }else{
       
        $('#FolioSantander').val($('#concepto').val());
        
    }

    
}


function CargarGastosCedis(este){

    var id_se_cobra_a=$(este).val();
    if(id_se_cobra_a=="0"){
        $('#cedis_gastos_list').prop('disabled', true);
        $('#cedis_gastos_list').html('<option value="0">CEDIS Gastos</option>');
    }else{
        $('#cedis_gastos_list').prop('disabled', false);
        $.post("ajax/cedis_gastos_list.php",{id_se_cobra_a:id_se_cobra_a},function(result){
        var obj=JSON.parse(result),html='<option value="0">CEDIS Gastos</option>';
        for(var i in obj){
            html+='<option value="'+obj[i].id_se_cobra_a+'">'+obj[i].name+'</option>';
        }
        $('#cedis_gastos_list').html(html);
    });
    }
    
}


var NumGastos=0;
function InicializaGastos(este){
    if($(este).val()!=""){
        NumGastos=0;
        var html='<br><div><button type="button" class="btn btn-primary" onclick="CrearGasto();"><i class="fa fa-plus-circle"></i> Agregar Gasto</button>';
        html+='</div>';

        $('#contenedor_gastos').html(html);
        CrearGasto();
    }else{
        $('#contenedor_gastos').html('');
    }
    
}
//Agrega un formulario para agregar gastos
function CrearGasto(){
    var html='<div style=" border-bottom:solid 1px #ABB1BA;" data-id="'+NumGastos+'"><br>';
    html+='<label class="pull-right" style=" display:inline-block; " onclick="QuitarGasto(this);">X</label>';
    html+='<br><label style="width:200px;">Fecha de Consumo</label><input id="FC'+NumGastos+'" class="form-control" style=" display:inline-block; width:180px;" type="date" name=""><br>';
    html+='<br><label style="width:200px;">Fecha de Factura</label><input id="FF'+NumGastos+'" class="form-control" style=" display:inline-block; width:180px;" type="date" name=""><br>';
    html+='<br><label style="width:200px;">Descripción</label><input id="Des'+NumGastos+'" class="form-control" style=" display:inline-block; width:60%;" type="text" name=""><br>';
    html+='<br><label style="width:200px;">Importe antes de IVA</label><input id="IAI'+NumGastos+'" class="form-control" style=" display:inline-block; width:60%;" type="text" name=""><br>';
    html+='<br><label style="width:200px;">Deducible</label><input id="Ded'+NumGastos+'" type="checkbox" name=""><br>';
    html+='<br><label style="width:200px;">Categoria</label><select id="Cat'+NumGastos+'" class="form-control" style=" display:inline-block; width:40%;">'+CategoriaIncomeopc+'</select><br>';
    html+='<br><label style="width:200px;">IVA</label><input id="I'+NumGastos+'" class="form-control" style=" display:inline-block; width:60%;" type="text" name=""><br>';
    html+='<br><label style="width:200px;">Comprobante</label><input id="File'+NumGastos+'" data-id="'+NumGastos+'" class="form-control" style=" display:inline-block; width:60%;" type="file" name="" onchange="FiletoBase64(this);">';

    html+='<input id="Com'+NumGastos+'" class="form-control" style=" visibility:hidden; width:60%;" type="text" name="">';
    html+='</div>';
    $('#contenedor_gastos').append(html);
    NumGastos++;
}
//Quita un formulario para agregar gastos
function QuitarGasto(este){
    $(este).parent().remove();
    
}

//Guarda los gastos en su tabla
function CargarGastos(id_cheque){
    var data = new Array();
    $('#contenedor_gastos').children().each(function(){
        if($(this).data('id')!=undefined){
            var json=JSON.parse('{}');
            json.date=$('#FC'+$(this).data('id')).val();
            json.date_fac=$('#FF'+$(this).data('id')).val();
            json.description=$('#Des'+$(this).data('id')).val();
            json.amount=$('#IAI'+$(this).data('id')).val();
            json.deducible=$('#Ded'+$(this).data('id')).is(":checked");
            json.category=$('#Cat'+$(this).data('id')).val();
            json.monto_iva=$('#I'+$(this).data('id')).val();
            json.comprobante=$('#Com'+$(this).data('id')).val();

            data.push(json);           
        }
       
        
    });

    var datas = JSON.stringify(data);
    $.post("action/add_gasto2.php",{id_cheque:id_cheque,data:datas},function(result){
        console.log("Resultado: "+result);
        if(result=="1"){
            document.getElementById("p_cheque").reset();
            $('#contenedor_gastos').html('');
        }else{
            alert(result);
        }

        //document.getElementById("p_cheque").reset();
    });
}

////Carga el select de los pagos
var CategoriaIncomeopc="";
function GetCategoriaIncome(){
    $.post("ajax/GetCategoriaIncome.php",{},function(result){
        CategoriaIncomeopc=result;

    });
}
GetCategoriaIncome();

function FiletoBase64(este) {
  var f = este.files[0]; // FileList object
  if(f!=undefined){
    var reader = new FileReader();
      // Closure to capture the file information.
      reader.onload = (function(theFile) {
        return function(e) {
          var binaryData = e.target.result;
          //Converting Binary Data to base 64
          var base64String = window.btoa(binaryData);
          $('#Com'+$(este).data('id')).val(f.name+","+base64String);
        };
      })(f);
      // Read in the image file as a data URL.
      reader.readAsBinaryString(f);
  }else{
    $('#Com'+$(este).data('id')).val('');
  }
  
}
</script>