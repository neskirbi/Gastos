<?php
session_start();

if($_SESSION['user_tipo']=="4" || $_SESSION['user_tipo']=="1" || $_SESSION['user_tipo']=="0"|| $_SESSION['user_tipo']=="3"){
}else{
    echo("<script>
            this.location='dashboard.php';</script>");
}
    $title ="Solicitar cheque | ";
    include "head.php";
	
    $status="1";
    $url="cheques.php";
    if(isset($_GET['s'])){
        $status=$_GET['s'];
        switch ($_GET['s']) {
            case '0':
                $active6="active";
            break;

            case '1':
                $active4="active";
            break;
            
            case '2':
                $active5="active";
            break;

            case 's':
                $active7="active";
            break;
        }
    }else{
        $active4="active";
        $status="1";
    }
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
                        
                        <div class="form-group row">
                            <div class="col-md-3 pull-left">
                                    <input type="date" class="form-control" id="date" name="date"   onchange="load(1);">
                                </div>
                           
                            <div class="col-md-2">
                                <button type="button" class="btn btn-default" onclick='load(1);'>
                                    <span class="glyphicon glyphicon-search" ></span> Buscar
                                </button>
                                
                           
                                
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
                            <div class="col-md-2">
                                <input type="text" style="width: 250px;" class="form-control" id="cheque" name="" placeholder="No. cheque ej. (1), (1,2,3), (1-13)" >
                            </div>
                                
                                <!-- <span id="loader"></span> -->
                                <?php
                                
                                if(($_SESSION['user_tipo']=="1" || $_SESSION['user_tipo']=="0") && $_GET['s']==2)
                                {
                                    ?>
                                    <div class="col-sm-2">

                                        <select class="form-control" id="fechaautorizado" >
                                           <!--<option selected="" value="0">-- Fecha --</option>
                                            <?php
                                            
                                            $query = mysqli_query($con,"SELECT distinct(fechaautorizado) as fechaautorizado from cheques where fechaautorizado!='0000-00-00' order by fechaautorizado desc");
                                            while ($row=mysqli_fetch_array($query)) 
                                            {
                                                
                                                ?>
                                                 <option value="<?php echo $row['fechaautorizado']; ?>">Autorizacion: <?php echo $row['fechaautorizado']; ?></option>

                                                <?php 
                                            } 
                                            ?>-->
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-default" onclick='DescargarMismobanco();'>
                                        <span class="glyphicon glyphicon-download" ></span> Mismobanco </button>


                                        <button type="button" class="btn btn-default" onclick='DescargarInterban();'>
                                        <span class="glyphicon glyphicon-download" ></span> Interban </button>
                                    </div>
                                </div>


                                       
                                        <?php
                                    
                                        if($_SESSION['user_tipo']=="1")
                                        {
                                            ?>
                                        <div class="form-group row">
                                        <div class="col-md-2 pull-right">
                                            <button type="button" class="btn btn-success" onclick='AutorizarGastos();'>
                                            <span class="glyphicon glyphicon-ok " ></span> Autorizar</button>
                                        </div> 
                                    </div>
                                            <?php
                                        }
                                        
                                    ?> 
                                    <?php
                                }
                                ?>
                                <!-- <span id="loader"></span> -->
                                
                            <!-- <span id="loader"></span> -->
                           
                                <!-- <span id="loader"></span> -->
                        </div>   
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
                url:'./ajax/cheques.php?action=ajax&page='+page+'&daterange='+daterange+'&q='+q+"&s=<?php echo $status;?>",
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


    function aceptar_cheque(id,este,tpago)
    {
        document.getElementById('a'+este).disabled= false;
        document.getElementById('c'+este).disabled= false;
        
        if(tpago!="Transferencia"){
            var no_cheque=document.getElementById('no_cheque'+este).value;
        }else{
            var no_cheque='';
        }
        if(no_cheque.length!=0 || tpago=="Transferencia")
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

function AutorizarGastos(){
    var ids=[];
    if(confirm("Desar Autorizar los gastos?")){
        $('input[name=autorizarcheck]').each(function(){

            if($(this).is(':checked')){
                var json=JSON.parse('{}');
                json.id=$(this).data('id')
                ids.push(json);
            }        
        });
        if(ids.length>0){
            var idsjson = JSON.stringify(ids);
            $.post("action/AutorizarGastos.php",{ids:idsjson},function(result){
                
                $("#resultados").html(result);
                load(1);
                FechaAutorizado();

                //
            });
        }else{
            alert("No has seleccionado ningún gasto.")
        }
       
        
    }
    
}

function DescargarMismobanco(){
    var fechaautorizado=$('#fechaautorizado').val();
    if(fechaautorizado=="0"){
        alert("Seleccione una fecha.")
    }else{

        $.post("ajax/Mismobanco.php",{fechaautorizado:fechaautorizado},function(result){
            //console.log(result);
            var json=JSON.parse(result);
            //console.log(json);
            var txt="";
            for(var i in json){
               txt+=json[i].cuentasalida+"  "+json[i].cuenta+"  "+json[i].monto+"  "+json[i].FolioSantander+"  "+json[i].fecha+"  "+json[i].email+"\n";
            }
            //console.log(txt);
            if(txt!=""){
                var blob = new Blob([txt], {type: "text/plain;charset=utf-8"});
                saveAs(blob, "Mismobanco"+fechaautorizado.split('-').join('')+".txt");   
            }else{
                alert("No hay datos para este archivo en esta fecha.");
            }
                     
        });
    }
    
}

function DescargarInterban(){
    var fechaautorizado=$('#fechaautorizado').val();
    if(fechaautorizado=="0"){
        alert("Seleccione una fecha.")
    }else{

        $.post("ajax/Interban.php",{fechaautorizado:fechaautorizado},function(result){
            //console.log(result);
            var json=JSON.parse(result);
            //console.log(json);
            var txt="";
            for(var i in json){
               txt+=json[i].cuentasalida+"  "+json[i].cuenta+"  "+json[i].clavebanco+json[i].titular+"  "+json[i].monto+json[i].plazabanco+json[i].FolioSantander+"       "+json[i].email+"         \n";
            }
            //console.log(txt);
            if(txt!=""){
                var blob = new Blob([txt], {type: "text/plain;charset=utf-8"});
                saveAs(blob, "Interban"+fechaautorizado.split('-').join('')+".txt"); 
            }else{
                alert("No hay datos para este archivo en esta fecha.");
            }
                       
        });
    }
    
}


function FechaAutorizado(){
    $.post("ajax/GetFechaAutorizados.php",{},function(result){
        $('#fechaautorizado').html(result);
    });
}

$(document).ready(function(){
    FechaAutorizado();
});







</script>