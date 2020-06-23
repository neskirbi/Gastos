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
<form class="form-horizontal form-label-left input_mask" method="post" id="add_income" name="add_income">
    
    
    
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
                        <div class="form-group">
                            

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

                       
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					<button id="save_data" type="submit" class="btn btn-success">Solicitar</button>
                </div>
            </div>
        </div>
    </div> <!-- /Modal -->
</form>	
<div class="form-group">
    
	             <tr>
						<div class="col-md-5 pull-left" style="width:200px">
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
                         	   
		      </div>				
							
    
      <div class="col-md-1 col-sm-9 col-xs-12" style="width:1200px" style="height:400px">
      <br>
        <button id="pedir_cheque" type="submit" class="btn btn-primary" name="Solicitar"><span class="glyphicon glyphicon-ok"></span> Actualizar Pago Directo</button>
    
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg-new" ><i class="fa fa-plus-circle" ></i> A&ntilde;adir Gastos</button>
		
		
									
</div>
</div>
<br>
<br>