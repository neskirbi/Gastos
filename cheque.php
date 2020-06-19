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
             datos=datos[0]+datos[2];
            console.log("---->"+id);
            get_mails(id*1,"Se ha solicitado un cheque para: {nombre} por un monto de: {monto}");

            $("#result_user").html(datos);

            var substring = "Error";
            if(datos.indexOf(substring) == -1)
            {
                document.getElementById("p_cheque").reset();
            }
            
            load(1);
          }
    });
  event.preventDefault();
})

function load(page){
            var q= $("#q").val();
            var daterange= $("#date").val();
            $("#loader").fadeIn('slow');
            console.log(daterange);
            $.ajax({
                url:'./ajax/cheques.php?action=ajax&page='+page+'&daterange='+daterange+'&q='+q,
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
    console.log(url);
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
    url: "./action/rechazar_cheque.php",
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
        console.log('no_cheque'+este);
        var no_cheque=document.getElementById('no_cheque'+este).value;
        if(no_cheque.length!=0)
        {
            var q= $("#q").val();
            if (confirm("Realmente deseas aceptar el cheque")){  
            $.ajax({
            type: "GET",
            url: "./action/aceptar_cheque.php",
            data: "id="+id+"&no_cheque="+no_cheque,
             beforeSend: function(objeto){
                $("#resultados").html("Mensaje: Cargando...");

                
              },
            success: function(datos){
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
    console.log("2---->"+id);
    $.post("ajax/mails.php",{id:id} ,function (mails){
    //alert("Se notificará a: "+ mails);
   
    //var nombre=datos.1.0
    // [["raul.martinez@promo-tecnicas.com"],["dalia salazar "],["1072.9"]]
    
        console.log(mails);
        //var mensaje="Se ha solicitado un cheque para: {nombre} por un monto de: {monto}";
        datos=JSON.parse(mails);
        mensaje=mensaje.replace("{nombre}",datos[1][0] );
        mensaje=mensaje.replace("{monto}",datos[2][0]);
        mails=datos[0].join(",");
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