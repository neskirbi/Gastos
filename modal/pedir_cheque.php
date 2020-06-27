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
        $consulta_ben="SELECT * from proveedores ";

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
                                            <option value="<?php echo $data_user['cuenta']; ?>"><?php echo $data_user['nombre']; ?></option>
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
                                        <select class="form-control" id="category" name="category" required="required" style="<?php echo $hidden; ?>"  onchange="InicializaGastos(this); HacerRequeridoFolio(this);">
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
        div.style="display:yes;";
        input.required=true;
        input.value="";
        select_ben.required=false;
    }
    else
    {
        $('#cuenta').val($(este).val());
        div.style="display:none;";
        input.required=false;
        input.value="0";
        select_ben.required=true;
    }
}

/*function CargarSecobraA(){
    $.post("ajax/se_cobra_a_list.php",{},function(result){
        //console.log(result);
        var obj=JSON.parse(result),html='<option value="0">Se Cobra A</option>';
        for(var i in obj){
            //console.log(obj[i]);
            html+='<option value="'+obj[i].id_se_cobra_a+'">'+obj[i].name+'</option>';
        }
        $('#se_cobra_a_list').html(html);
    });
}
CargarSecobraA();*/




    
</script>

	