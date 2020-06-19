<script src="ckeditor/ckeditor.js"></script>
<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
    $title ="Inbox | ";
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
                        include("modal/redactar.php");

                        
                    ?>
                    
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Notificaciones</h2>
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
                        </form>
                        <!-- end form print -->

                        <div class="x_content">
                            <div class="table-responsive">
                                <!-- ajax -->
                                <span id="loader"></span>
                                    <div id="resultados"></div><!-- Carga los datos ajax -->
                                    <div  style="height: 600px; ">
                                        <table style="width: 100%; height: 600px;">
                                            <tr>                                            
                                                <td style="width: 30%;  vertical-align: top;  ">
                                                <div id='contenido' style="width: 100%; overflow-y: scroll; height: 600px;"></div></td>
                                                <td style="width: 70%;">
                                                <div id='contenido2' style="width: 100%; overflow-y: scroll; height: 600px;"></div></td>
                                            </tr>
                                        </table>
                                        
                                    </div><!-- Carga los datos ajax -->
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



<script type="text/javascript">
    
    function inbox()
    {
        $.post("ajax/inbox.php",{},function(result){
            
            $('#contenido').html(result);
        });
    }

    function carga_msn(id)
    {
        $.post("ajax/carga_inbox.php",{id:id},function(result){
            
            $('#contenido2').html(result);
            inbox();
        });
    }

    function enviar()
    {
        var destina=document.getElementById('destina').value;
        var asunto=document.getElementById('asunto').value;
        var msn=CKEDITOR.instances.editor1.getData();
        
        if(destina=='0')
        {
            alert('Seleccione un destinatario');
        }else{
            if (asunto.lenght>10) {
                alert('Asunto min 10 caracteres');
            }else{
                $.post("action/enviar.php",{destina:destina,asunto:asunto,msn:msn},function(result){
                    $('#salida_res').html(result);
                    
                });
            }
             
        }
       
    }


    inbox();
    CKEDITOR.replace( 'editor1' );
</script>





?>