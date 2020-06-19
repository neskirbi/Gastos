<form class="form-horizontal form-label-left input_mask" id="add_user" name="add_user">   
   <div> <!-- Modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg-add"><i class="fa fa-plus-circle"></i> Agregar Usuario</button>
    </div>
    <div class="modal fade bs-example-modal-lg-add" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Agregar Usuario</h4>
                </div>
                <div class="modal-body">
               
                    
                        <div id="result_user"></div>

                         
                          <div class="col-md-12 col-sm-6 col-xs-12 form-group has-feedback">
                                <input name="name" required type="text" class="form-control" placeholder="Nombre">
                                <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                            <?php 
                                    session_start();
                                    $readonly="";
                                    if($_SESSION['user_tipo']!="0")
                                    {
                                        $readonly="disabled";
                                    }
                                    ?>
                            <select class="form-control" required name="programa" id="programa" <?php echo $readonly; ?>>
                            <option value="" >-- Selecciona Programa --</option>
                            <?php
                            session_start();
                            $consulta="SELECT * from programas";
                            $sql=mysqli_query($con,$consulta);
                            while($sql_data=mysqli_fetch_array($sql))
                            {
                                $marca="";
                                                if($_SESSION['user_tipo']!="0")
                                                {
                                                    if($_SESSION['programa']==$sql_data['id'])
                                                    {
                                                        $marca='selected';
                                                        
                                                    }
                                                }
                                ?>
                                <option value="<?php echo $sql_data['id'];?>" <?php echo $marca;  ?> ><?php echo $sql_data['name'];?></option>
                                <?php
                            }
                            ?>
                                     
                            </select>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                            <input class="form-control has-feedback-left" type="text" name="telefono" placeholder="Telefono" required="required">
                            <span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
                        </div>
                        
                        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                            <select class="form-control" required name="ciudad">
                            <option value="" >-- Ciudad --</option>
                            <?php
                            $consulta="SELECT * from Estados";
                            $sql=mysqli_query($con,$consulta);
                            while($sql_data=mysqli_fetch_array($sql))
                            {
                                ?>
                                <option value="<?php echo $sql_data['id'];?>" ><?php echo $sql_data['estado'];?></option>
                                <?php
                            }
                            ?>
                                     
                            </select>
                        </div>
                        
                        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                            <input name="email" type="text" class="form-control has-feedback-left" placeholder="Correo Electronico" required>
                            <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                            <select class="form-control" required name="status">
                                    <option value="" selected>-- Selecciona estado --</option>
                                    <option value="1" >Activo</option>
                                    <option value="0" >Inactivo</option>  
                            </select>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                            <input type="password" id="password" name="password" placeholder="Contraseña" required class="form-control col-md-7 col-xs-12">
                        </div>
                           
                         <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                            <select class="form-control" required name="tipo">
                            <option value="" >-- Tipo de usuario --</option>
                            <?php
                            $consulta="SELECT * from t_user";
                            $sql=mysqli_query($con,$consulta);
                            while($sql_data=mysqli_fetch_array($sql))
                            {
                                ?>
                                <option value="<?php echo $sql_data['id'];?>" ><?php echo $sql_data['name'];?></option>
                                <?php
                            }
                            ?>
                                     
                            </select>
                        </div>
                       <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                            <input class="form-control " type="text" name="rutas" placeholder="Rutas(s) Ej.  d2,d3" required="required">
                            
                        </div>
                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					<button id="save_data" type="submit" class="btn btn-success">Guardar</button>
                </div>
            </div>
        </div>
    </div> <!-- /Modal -->
 </form>	