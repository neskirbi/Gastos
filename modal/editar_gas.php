<style type="text/css">
    .adios{
        transition-delay: : 1s;

    }
</style>
<?php

?>
<form class="form-horizontal form-label-left input_mask" method="post" id="edi_income" name="edi_income">
    
    <div class="modal fade bs-example-modal-lg-edi" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md2">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Editar Gasto</h4>
                </div>
                <div class="modal-body">
                    
                        <div id="edi_result_income"></div>
                        <div class="form-group">
                        
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input id="referencia2" type="text"  name="referencia" class="form-control"  style="visibility: hidden;" value="" >
                            </div>
                            </div>
                        <div class="form-group">
                            

                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Fecha<span class="required">*</span></label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input id="edi_fecha" type="date" required name="date" class="form-control" placeholder="Default Input">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Descripción <span class="required">*</span>
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input id="edi_des" name="description" class="date-picker form-control col-md-7 col-xs-12" required type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Importe antes de iva <span class="required">*</span>
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input id="edi_monto" onblur="sumar_iva2();" onkeyup="sumar_iva2();" name="amount" class=" form-control col-md-7 col-xs-12" required type="text"  title="Ingresa sólo números con 0 ó 2 decimales" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-6">Deducible<span class="">*</span>
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input id="edi_dedu2" name="deducible" class="pull-md-right pull-xl-right pull-lg-right pull-sm-right pull-xs-right"  type="checkbox" onchange="iva2(this);" checked="checked">
                            </div>
                        </div>
                        <div id="monto_iva_div2" class="form-group adios" >
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">IVA <span class="required">*</span>
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input id="edi_monto_iva" onblur="sumar_iva2();" onkeyup="sumar_iva2();" name="monto_iva" class=" form-control col-md-7 col-xs-12" required type="text"   >
                            </div>
                        </div>
                        <div id="monto_iva_div" class="form-group adios" >
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Total <span class="required">*</span>
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input id="edi_total" name="total" class=" form-control col-md-7 col-xs-12" required type="text"   >
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
					<button id="edi_data" type="submit" class="btn btn-success">Guardar</button>
                </div>
            </div>
        </div>
    </div> <!-- /Modal -->
</form>	

<br>
<br>