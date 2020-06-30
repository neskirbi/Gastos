<style type="text/css">
    .adios{
        transition-delay: : 1s;

    }
</style>
<?php
include"subir.php";

    $hidden="";
   
        $consulta_tcheque="SELECT * from t_cheque where id='3'";
        $consulta_pro="SELECT * from Programas where id='".$_SESSION['programa']."'";
        //$consulta_ben="SELECT * from user  where id='".$_SESSION['user_id']."' ";
        $consulta_ben="SELECT * from user where   programa='".$_SESSION['programa']."' order by name asc";
        $hidden="visibility: hidden;";
        $consulta_pa="SELECT * from t_pago";


?>
<!--<form class="form-horizontal form-label-left input_mask" method="post" id="add_income" name="add_income">-->
    
    
    
    <div class="modal fade bs-example-modal-lg-new" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Nuevo Gasto</h4>
                </div>
                <div class="modal-body">
                    
                        <div id="result_income"></div>
                        <div class="form-group">
                        
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input id="referencia" type="text" required name="referencia" class="form-control"  style="visibility: hidden;">
                            </div>
                        </div>
                        <div id="contenedor_gastos"></div>
                        <!--<div class="form-group">
                            

                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Fecha de consumo<span class="required">*</span></label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input id="formula1" type="date" required name="date" class="form-control" placeholder="Default Input">
                            </div>
                        </div>
                        <div class="form-group">
                            

                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Fecha de factura<span class="required">*</span></label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input id="formula1" type="date" required name="date_fac" class="form-control" placeholder="Default Input">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Descripción <span class="required">*</span>
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input id="formula2" name="description" class="date-picker form-control col-md-7 col-xs-12" required type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Importe antes de iva <span class="required">*</span>
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input id="formula3" onblur="sumar_iva(this);" onkeyup="sumar_iva(this);" name="amount" class=" form-control col-md-7 col-xs-12" required type="text"  title="Ingresa sólo números con 0 ó 2 decimales" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-6">Deducible<span class="">*</span>
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input id="formula4" name="deducible" class="pull-md-right pull-xl-right pull-lg-right pull-sm-right pull-xs-right"  type="checkbox" onchange="iva(this);" checked="checked">
                            </div>
                        </div>
                        <div id="monto_iva_div" class="form-group adios" >
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">IVA <span class="required">*</span>
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input id="monto_iva" onblur="sumar_iva(this);" onkeyup="sumar_iva(this);" name="monto_iva" class=" form-control col-md-7 col-xs-12" required type="text"   >
                            </div>
                        </div>
                        <div id="monto_iva_div" class="form-group adios" >
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Total <span class="required">*</span>
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input id="total" name="total" class=" form-control col-md-7 col-xs-12" required type="text"   >
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Categoria
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <select class="form-control" id="formula6" name="category" required>
                                    <option selected="" value="">-- Selecciona Categoria --</option>
                                    <?php
                                    $categories = mysqli_query($con,"select * from category_income");
                                    while ($cat=mysqli_fetch_array($categories)) { ?>
                                    <option value="<?php echo $cat['id']; ?>"><?php echo $cat['name'];?></option>
                                    <?php 
                                    } 
                                    ?>
                                </select>
                            </div>
                        </div>
-->
                       
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					<button id="save_data" onclick="CargarGastos();" type="submit" class="btn btn-success">Solicitar</button>
                </div>
            </div>
        </div>
    </div> <!-- /Modal -->
<!--</form>-->	
<div class="form-group">
    
	             <tr>
						<!--<div class="col-md-5 pull-left" style="width:200px">
                                   <?php 
                                      ?>
                                        <select class="form-control" id="programa" name="programa" required="required" readonly>
                                            <option selected="" value="">-- Programa --</option>
                                            <?php
                                            
                                            $categories = mysqli_query($con,$consulta_pro);
                                            while ($cat=mysqli_fetch_array($categories)) 
                                            {
                                                $marca="";
                                                if($_SESSION['user_tipo']!="0")
                                                {
                                                    if($_SESSION['programa']==$cat['id'])
                                                    {
                                                        $marca='selected';
                                                    }
                                                }
                                                ?>
                                                 <option value="<?php echo $cat['id']; ?>" <?php echo $marca; ?> ><?php echo $cat['name']; ?></option>
												<?php 
                                            } 
                                            ?>
                                        </select>
                        </div> 
									
				        <div class="col-md-5 pull-left" style="width:200px">
                      		   <?php 
                                                ?>
                                        <select class="form-control" id="tipopago" name="tipopago" required="required" readonly>
                                            <option selected="" value="">-- Tipo Pago --</option>
                                            <?php
                                             
                                            $tpago = mysqli_query($con,$consulta_pa);
                                            while ($catp=mysqli_fetch_array($tpago)) 
                                            {
                                                $marca="";
                                                if($_SESSION['user_tipo']!="0")
                                                {
                                                    if($_SESSION['programa']==$catp['id'])
                                                    {
                                                        $marca='selected';
                                                   
                                                    }
                                                }
                                                ?>
                                                 <option value="<?php echo $catp['id']; ?>" <?php echo $marca; ?> ><?php echo $catp['name']; ?></option>

                                                <?php 
                                            } 
                                            ?>
                                        </select>
                         </div> 
								
						 <div class="col-md-10 pull-left"  id="cont_ben" style="width:400px">
                             <input class="form-control" value="Beneficiario" type="text" id="nombreben" name="nombreben" placeholder="Nombre">
                         </div>  
				</tr>
						
	          <div class="col-md-1 col-sm-9 col-xs-12" style="width:1200px" style="height:400px">
								 <br>
       
								  <div class="col-md-10 pull-left" style="width:200px">
								    <h4 class="modal-title" style="font-size:15px">Numero de cuenta: </h4>
                                  </div>	
								<?php
                               
                                $rec='required="required"';
                                $val="";
                                        if($_SESSION['user_tipo']!="2"||$_SESSION['user_tipo']!="3")
                                        {
                                            $recc='';
                                            $valc="0";
                                        }
                                    ?>

                                        <div class="col-md-5 pull-left"  style="width:200px" >
                                           <input type="text" name="Cuenta" class="form-control" placeholder="Cuenta" required="required" >
                                        </div>                          
                                                          
								
									<div class="col-md-4 pull-left" style="width:100px">
                                           <input type="text" name="periodo" class="form-control" placeholder="Periodo" required="required" >
                                    </div>
							
                                    <div class="col-md-5 pull-left" style="width:100px">
                                           <input type="text" name="semana" class="form-control" placeholder="Semana - Mes" required="required" >
									</div>		
                         	   
		      </div>	-->			
							
    
      <div class="col-md-1 col-sm-9 col-xs-12" style="width:1200px" style="height:400px">
      <br>
        <!--<button id="pedir_cheque" type="submit" class="btn btn-primary" name="Solicitar"><span class="glyphicon glyphicon-ok"></span> Actualizar Pago Directo</button>-->
    
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg-new" ><i class="fa fa-plus-circle"  ></i> A&ntilde;adir Gastos</button>
		
		
									
</div>
</div>
<br>
<br>
<script type="text/javascript">

    ////Carga el select de los pagos
var CategoriaIncomeopc="";
function GetCategoriaIncome(){
    $.post("ajax/GetCategoriaIncome.php",{},function(result){
        CategoriaIncomeopc=result;
        InicializaGastos();

    });
}



    var NumGastos=0;
function InicializaGastos(){
    //if($(este).val()!="" && $(este).val()!="2" && $(este).val()!="5"){
        NumGastos=0;
        var html='<br><div><button type="button" class="btn btn-primary" onclick="CrearGasto();"><i class="fa fa-plus-circle"></i> Agregar Gasto</button>';
        html+='</div>';

        $('#contenedor_gastos').html(html);
        CrearGasto();
    //}else if($(este).val()!="" || $(este).val()=="2" || $(este).val()!="5"){
        //$('#contenedor_gastos').html('');
    //}
    
}
//Agrega un formulario para agregar gastos
function CrearGasto(){
    var html='<div style=" border-bottom:solid 1px #ABB1BA;" data-id="'+NumGastos+'"><br>';
    html+='<label class="pull-right" style=" display:inline-block; " onclick="QuitarGasto(this);">X</label>';
    html+='<br><label style="width:200px;">Fecha de Consumo</label><input id="FC'+NumGastos+'" class="form-control" style=" display:inline-block; width:180px;" type="date" name=""><br>';
    html+='<br><label style="width:200px;">Fecha de Factura</label><input id="FF'+NumGastos+'" class="form-control" style=" display:inline-block; width:180px;" type="date" name=""><br>';
    html+='<br><label style="width:200px;">Descripción</label><input id="Des'+NumGastos+'" class="form-control" style=" display:inline-block; width:60%;" type="text" name=""><br>';
    html+='<br><label style="width:200px;">Importe antes de IVA</label><input id="IAI'+NumGastos+'" class="form-control" style=" display:inline-block; width:60%;" type="text" name=""><br>';
    html+='<br><label style="width:200px;">Deducible</label><input id="Ded'+NumGastos+'" type="checkbox" name="" onchange="RequiredFactura(this);" data-id="'+NumGastos+'"><br>';
    html+='<br><label style="width:200px;">Categoria</label><select id="Cat'+NumGastos+'" class="form-control" style=" display:inline-block; width:40%;">'+CategoriaIncomeopc+'</select><br>';
    html+='<br><label style="width:200px;">IVA</label><input id="I'+NumGastos+'" class="form-control" style=" display:inline-block; width:60%;" type="text" name=""><br>';
    html+='<br><label style="width:200px;">Factura</label><input id="File1'+NumGastos+'" data-id="'+NumGastos+'" class="form-control" style=" display:inline-block; width:60%;" type="file" name="" onchange="FiletoBase64(this,1);" disabled="disabled">';

    html+='<input id="Com1'+NumGastos+'" class="form-control" style=" visibility:hidden; width:60%;" type="text" name="">';

    html+='<label style="width:200px;">Complemento Pago</label><input id="File2'+NumGastos+'" data-id="'+NumGastos+'" class="form-control" style=" display:inline-block; width:60%;" type="file" name="" onchange="FiletoBase64(this,2);" disabled="disabled">';

    html+='<input id="Com2'+NumGastos+'" class="form-control" style=" visibility:hidden; width:60%;" type="text" name="">';
    html+='</div>';
    $('#contenedor_gastos').append(html);
    NumGastos++;
}


//Guarda los gastos en su tabla
function CargarGastos(){
    var id_cheque=$('#referencia').val();
    var data = new Array();
    var cont=1;
    $('#contenedor_gastos').children().each(function(){
        if($(this).data('id')!=undefined){
            if($('#Des'+$(this).data('id')).val().length!=0 && $('#Cat'+$(this).data('id')).val()!=0){
                 var json=JSON.parse('{}');
                json.date=$('#FC'+$(this).data('id')).val();
                json.date_fac=$('#FF'+$(this).data('id')).val();
                json.description=$('#Des'+$(this).data('id')).val();
                json.amount=$('#IAI'+$(this).data('id')).val();
                json.deducible=$('#Ded'+$(this).data('id')).is(":checked");
                json.category=$('#Cat'+$(this).data('id')).val();
                json.monto_iva=$('#I'+$(this).data('id')).val();
                json.factura=$('#Com1'+$(this).data('id')).val();
                json.comprobante=$('#Com2'+$(this).data('id')).val();


                data.push(json);
            }else{
            alert('Debellenar el formulario '+cont);
        }
          cont++;            
        }
       
        
    });

    if(data.length>0){
        var datas = JSON.stringify(data);
        $.post("action/add_gasto3.php",{id_cheque:id_cheque,data:datas},function(result){
            console.log("Resultado: "+result);
            var temp = result.split("#sep#");
            if(temp[0].includes("1")){
                $('#result_income').html(temp[1]);
                GetCategoriaIncome();
                load2(id_cheque,'','');
                load(0);
            }else{
                $('#result_income').html(temp[1]);
            }

            //
        });
    }
    //document.getElementById("p_cheque").reset();
    
    
}

function RequiredFactura(este){
    if($(este).is(":checked")){
        $('#File1'+$(este).data('id')).prop('disabled',false);
        $('#File2'+$(este).data('id')).prop('disabled',false);
    }else{
        $('#File1'+$(este).data('id')).prop('disabled',true);
        $('#File2'+$(este).data('id')).prop('disabled',true);
    }
    
}

function FiletoBase64(este,numero) {
  var f = este.files[0]; // FileList object
  if(f!=undefined){
    var reader = new FileReader();
      // Closure to capture the file information.
      reader.onload = (function(theFile) {
        return function(e) {
          var binaryData = e.target.result;
          //Converting Binary Data to base 64
          var base64String = window.btoa(binaryData);
          $('#Com'+numero+$(este).data('id')).val(f.name+","+base64String);
        };
      })(f);
      // Read in the image file as a data URL.
      reader.readAsBinaryString(f);
  }else{
    $('#Com'+$(este).data('id')).val('');
  }
  
}

</script>