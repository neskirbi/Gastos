    <form   id="p_cheque" >
   <div> <!-- Modal -->
    <?php
    $hidden="";
    if ($_SESSION['user_tipo']=="3" || $_SESSION['user_tipo']=="2") {
        $titulo1="Solicitar Reembolso";
        $titulo2="Solicitud";
        $consulta_tcheque="SELECT * from t_cheque where id='3'";
        $consulta_pro="SELECT * from Programas where id='".$_SESSION['programa']."'";
        //$consulta_ben="SELECT * from user  where id='".$_SESSION['user_id']."' ";
        //$consulta_ben="SELECT * from user where   programa='".$_SESSION['programa']."' order by name asc";
        $hidden="visibility: hidden;";
        
    }else
    {
        $titulo1="Solicitar Gasto a Comprobar"; //se cambio
        $titulo2="Gastos a Comprobar";  //se cambio
        $consulta_pro="SELECT * from Programas";
		$consulta_pa="SELECT * from t_pago";
        $consulta_tcheque="SELECT * from t_cheque where id!='3'";
    }
        $consulta_ben="SELECT * from proveedores order by titular asc ";

    $where="";  
    
    if($_SESSION['user_tipo']!="0")
    {
        
        //$where=" where programa='".$_SESSION['programa']."' and rutas IN ('".str_replace(",","','",$_SESSION['rutas'])."') ";
        $where=" where programa='".$_SESSION['programa']."'  ";
    }
    $selec="";
      if($_SESSION['user_tipo']!="2"||$_SESSION['user_tipo']!="3")
    {
        
        $selec="selected";
    }
    ?>
	<td colspan="1">	
		                       
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg-add"><i class="fa fa-plus-circle"></i> <?php echo $titulo1;?></button>
    </td>
	
	
	</div>
	
	
	
	
    <div class="modal fade bs-example-modal-lg-add" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md" >
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel"><?php echo $titulo2;?></h4>
                </div>
                <div class="modal-body">
                    
                        <div id="result_user"></div>
                          
                      
                        <table  width="100%" cellspacing="5px" cellpadding="5px">
						
						  <tr>
                                <td colspan="2">
								 <br>
                                     <div class="col-md-4 pull-left" style="width:27%">
                                        <input readonly="readonly" type="date" name="fecha" class="form-control" required="required" value="<?php echo date("Y-m-d");?>">
                                    </div>
                                 <div class="col-md-5 pull-left" style="width:67%">
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
                                   
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="col-md-4 pull-left" style="width:100%">
                                        <br>
                                         <select required id="se_cobra_a_list" name="se_cobra_a_list" class="form-control" style="width: 40%; display: inline-block;" onchange="CargarGastosCedis(this); GenerarSantanderFolio();"> 
                                         <option selected="" value="">Se Cobra A</option>
                                            <?php
                                            $consulta="SELECT * from se_cobra_a order by id_se_cobra_a asc";
                                            $user = mysqli_query($con,$consulta);
                                            while ($data_user=mysqli_fetch_array($user)) { ?>
                                            <option value="<?php echo $data_user['id_se_cobra_a']; ?>"><?php echo $data_user['name']; ?></option>
                                            <?php } ?>                                       
                                        </select>
                                        <select required id="cedis_gastos_list" name="cedis_gastos_list" class="form-control" style="width: 40%; display: inline-block;" disabled="" ></select>
                                    </div>
                                    
                                   
                                </td>
                            </tr>
				
						    <tr>
                              <td colspan="2">
                                <br>
                                    <div class="col-md-4 pull-left" style="width:30%">
                                           <input type="text" name="periodo" class="form-control" placeholder="Periodo" required="required" >
                                    </div>
							
                                    <div class="col-md-5 pull-left" style="width:30%">
                                           <input type="text" name="semana" class="form-control" placeholder="Semana - Mes" required="required" >
                                    </div>
									
									 <div class="col-md-5 pull-left" style="width:33%">
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
									
							  </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                     <br>
                                <div class="col-md-10 pull-left" style="width:47%" >
                                    
                                        <select class="form-control" id="idben" name="idben" required onchange="benefi(this);GenerarSantanderFolio();" style="<?php echo $hidden; ?>" >
                                            <option selected="" value="">-- Beneficiario --</option>
                                            <?php

                                            $user = mysqli_query($con,$consulta_ben);
                                            while ($data_user=mysqli_fetch_array($user)) { ?>
                                            <option data-cuenta="<?php echo $data_user['cuenta']; ?>" value="<?php echo $data_user['id']; ?>"><?php echo $data_user['nombre']; ?></option>
                                            <?php } ?>
                                            <!--<option value="0">Otro</option>-->
                                        </select>   
                                </div>

                                 <br>
                                
                     
                                <div class="col-md-10 pull-left" id="cont_ben" style="width:47%; display: none;">
                                        <input class="form-control" value="0" type="text" id="nombreben" name="nombreben" placeholder="Nombre">
                                </div> 

                                </td>
                            </tr>
						
						<tr>
                                <td colspan="2">
                               
                                <br>
								  <div class="col-md-10 pull-left" style="width:33%">
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

                                         <div class="col-md-5 pull-left" style="<?php echo $hidden; ?>; " style=width:60% >
                                           <input id="cuenta" type="text" name="Cuenta" class="form-control" placeholder="Cuenta" required="required" >
                                        </div>                          
                                </td>
                            </tr>
				
							<tr>
                                <td colspan="2">
                                <br>
								  <div class="col-md-10 pull-left" style="width:27%">
								    <h4 class="modal-title" style="font-size:15px">Importe: $</h4>
                                  </div>	
								<?php
                               
                                $rec='required="required"';
                                $val="";
                                        if($_SESSION['user_tipo']!="2"||$_SESSION['user_tipo']!="3")
                                        {
                                            $rec='';
                                            $val="0";
                                        }
                                    ?>

                                         <div class="col-md-5 pull-left" style="<?php echo $hidden; ?>; " style=width:67% >
                                           <input type="text" name="monto" value="<?php echo $val; ?>" class="form-control" placeholder="Monto ej: 200.22" <?php echo $rec; ?>  >
                                        </div>                          
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <br>
                                     <div class="col-md-5 pull-left">
                                        <select class="form-control" id="cuentasalida" name="cuentasalida" required="required">
                                            <option selected="" value="">--Cuenta de salida --</option>
                                            <?php
                                            $categories = mysqli_query($con,"SELECT * from cuentasalida");
                                            while ($cat=mysqli_fetch_array($categories)) { ?>
                                            <option value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                      </div>
                                </td>
                            </tr>
						
						
						
						
						     <tr>
                                <td colspan="2">
                                <br>
                                    <div class="col-md-10 pull-left" style="width:95%">
                                           <input type="text" id="concepto" name="concepto" class="form-control" placeholder="Concepto" required="required" >
                                    </div>
								 </td>
                            </tr>

                             <tr>
                                <td colspan="2">
                                <br>
                                    <div class="col-md-10 pull-left" style="width:95%">
                                           <input type="text" id="cvalidacion" name="cvalidacion" class="form-control" placeholder="C&oacute;digo de validaci&oacute;n" onkeyup="GenerarSantanderFolio();" >
                                    </div>
                                 </td>
                            </tr>

                             <tr>
                                <td colspan="2">
                                <br>
                                    <div class="col-md-10 pull-left" style="width:65%">
                                           <input type="text" name="FolioSantander" id="FolioSantander" class="form-control" placeholder="FolioSantander">
                                    </div>

                                    <div class="col-md-10 pull-left" style="width:30%">
                                        <input type="checkbox" name="referencia" id="referencia"  placeholder="referencia" onchange="GenerarSantanderFolio();" >
                                        <label>Referencia</label>
                                    </div>
                                 </td>
                            </tr>
						
						
                           <tr>
                                <td>
                                <br>

                                      <div class="col-md-5 pull-left">
                                        <select class="form-control" id="clasificacion" name="clasificacion" required="required">
                                            <option selected="" value="">-- Seleccione clasificacion --</option>
                                            <?php
                                            $categories = mysqli_query($con,"select * from clasificacion");
                                            while ($cat=mysqli_fetch_array($categories)) { ?>
                                            <option value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                      </div>


									  
                                    <div class="col-md-5 pull-left">
                                        <select class="form-control" id="category" name="category" required="required" style="<?php echo $hidden; ?>"  onchange="InicializaGastos(this); HacerRequeridoFolio(this); GenerarSantanderFolio();">
                                            <option value="">-- Seleccione tipo de gasto --</option>
                                            <?php
                                            $categories = mysqli_query($con,$consulta_tcheque);
                                            while ($cat=mysqli_fetch_array($categories)) { ?>
                                            <option value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div> 

                                    <!--aqui rcv  -->
								   
                                </td>
                            </tr>
                            

                            <tr>
                                <td colspan="2">
                                    <div id="contenedor_gastos"></div>
                                    
                                </td>
                            </tr>
                            
                        </table>    
                          
                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					<button id="pedir_cheque" type="submit" class="btn btn-primary" name="Solicitar">
                      <span class="glyphicon glyphicon-ok"></span> Solicitar
                    </button>
                </div>
            </div>
        </div>
    </div> <!-- /Modal -->
    </form> 


<script type="text/javascript">

function benefi(este)
{
    //console.log(este.value);
    var div=document.getElementById("cont_ben");
    var input=document.getElementById("nombreben");
    var select_ben=document.getElementById("idben");
    if(este.value=="0")
    {
        $('#cuenta').val('');
        div.style="display:yes;";
        input.required=true;
        input.value="";
        select_ben.required=false;
    }
    else
    {

        $('#cuenta').val($('#idben option:selected').data('cuenta'));
        div.style="display:none;";
        input.required=false;
        input.value="0";
        select_ben.required=true;
    }
}

function GenerarSantanderFolio(){
    if($('#category').val()!="1"){
        if (!$('#referencia').is(":checked"))
        {
            
            //var benefi=$('#idben').val();
            var benefi=$('#idben option:selected').text();

             $('#FolioSantander').val(benefi);
        }else{
           
            $('#FolioSantander').val('');
            
        }
    }else{
        $('#FolioSantander').val('');
    }
   

    
}

function EditarFolioSantander(este){
    var id=$(este).data("id");
    var FolioSantander=$('#FS'+id).val();

    $.post("action/EditarFolioSantander.php",{id:id,FolioSantander:FolioSantander} ,function (result){
        if(result.includes("1")){
            $('#FS'+id).css('border','solid 1px #40C2A6');

        }else{
            $('#FS'+id).css('border','solid 1px #E96153');

        }
      
                
     });  
}


function Editarcuentasalida(este){
    var id=$(este).data("id");
    var cuentasalida=$(este).val();

    $.post("action/Editarcuentasalida.php",{id:id,cuentasalida:cuentasalida} ,function (result){
        if(result.includes("1")){
            $(este).css('border','solid 1px #40C2A6');

        }else{
            $(este).css('border','solid 1px #E96153');

        }
      
                
     });  
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
    if($(este).val()!="" && $(este).val()!="2" && $(este).val()!="5"){
        NumGastos=0;
        var html='<br><div><button type="button" class="btn btn-primary" onclick="CrearGasto();"><i class="fa fa-plus-circle"></i> Agregar Gasto</button>';
        html+='</div>';

        $('#contenedor_gastos').html(html);
        CrearGasto();
    }else if($(este).val()!="" || $(este).val()=="2" || $(este).val()!="5"){
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
//Quita un formulario para agregar gastos
function QuitarGasto(este){
    $(este).parent().remove();
    
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
            json.factura=$('#Com1'+$(this).data('id')).val();
            json.comprobante=$('#Com2'+$(this).data('id')).val();

            data.push(json);           
        }
       
        
    });

    if(data.length>0){
        var datas = JSON.stringify(data);
        $.post("action/add_gasto2.php",{id_cheque:id_cheque,data:datas},function(result){
            console.log("Resultado: "+result);
            if(result=="1"){
                document.getElementById("p_cheque").reset();
                $('#contenedor_gastos').html('');
            }else{
                alert(result);
            }

            //
        });
    }
    document.getElementById("p_cheque").reset();
    $('#contenedor_gastos').html('');
    
}

////Carga el select de los pagos
var CategoriaIncomeopc="";
function GetCategoriaIncome(){
    $.post("ajax/GetCategoriaIncome.php",{},function(result){
        CategoriaIncomeopc=result;

    });
}
GetCategoriaIncome();

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
function HacerRequeridoFolio(este){
    if($(este).val()=="1"){
        $('#cvalidacion').prop('required',true);
    }else{
        $('#cvalidacion').prop('required',false);
    }

}

    
</script>

	