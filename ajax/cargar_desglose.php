<?php
    include "../config/config.php";//Contiene funcion que conecta a la base de datos
    session_start();
   

    if (isset($_GET['id'])){
        
		  $id=intval($_REQUEST['id']);
          $nom=filter_input(INPUT_GET, 'nom', FILTER_SANITIZE_SPECIAL_CHARS);  
          $correo=filter_input(INPUT_GET, 'mail'); 
        
		$filtro="";
        if( $_SESSION['user_tipo']=="-2")
        {
          $filtro=" and si_aid='1' ";
        }
        
        //main query to fetch the data
        $sql="SELECT * FROM  desglose where id_cheque='$id' $filtro order by created_at desc";
        $query = mysqli_query($con, $sql);
        //loop through fetched data
        $numrows=mysqli_num_rows($query);
        if ($numrows>0){
            
            ?>
            
                          <a href="#" class="btn btn-default" title="Exportar" onclick="exc_des(<?php echo $id; ?>);">
                                    <i class="far fa-file-excel"></i> </a>         
                        <button class="btn btn-default" onclick="imprime_formato(<?php echo $id; ?>);"><span class="glyphicon glyphicon-print" ></span> Imprimir</button>
                        <?php

                        echo"No. Folio: " . $id." ".$nom." <a href='mailto:".$correo."?subject=".$id."'>".$correo."</a>";
                        ?>
                    

                        
                    
            

            <table class="table table-striped jambo_table bulk_action" border="1">
                <thead>
                    <tr class="headings">
                        <th class="column-title">Fecha de <br> Factura </th>
                        <th class="column-title">Fecha de <br> Consumo </th>
                        <th class="column-title">Descripción </th>
                        <th class="column-title">Monto A.IVA </th>
                        <th class="column-title">IVA </th>
                        <th class="column-title">Total </th>
                        <th class="column-title">Concepto </th>
                        <th class="column-title">Deducible </th>
                        <th class="column-title">F. fiscal </th>
                          <?php

                          
                            
                            if($_SESSION['user_tipo']=="3" || $_SESSION['user_tipo']=="0"||$_SESSION['user_tipo']=="5" ||$_SESSION['user_tipo']=="4"|| $_SESSION['user_tipo']=="-3")
                            {
                                ?>
                                <th>¿Sup. OK?</th>
                                <?php
                            }

                            
                            if($_SESSION['user_tipo']=="2" || $_SESSION['user_tipo']=="3"|| $_SESSION['user_tipo']=="0")
                                {

                                    ?>
                                <th></th>
                                

                                        <th>Editar</th>
                                    <?php
                                }
                            
                            
                            
                            if($_SESSION['user_tipo']=="5" || $_SESSION['user_tipo']=="0" ||$_SESSION['user_tipo']=="4" || $_SESSION['user_tipo']=="-3")
                            {
                                ?>
                                <th>¿Cliente OK?</th>
                                <th></th>
                                <?php
                            }

                            if($_SESSION['user_tipo']=="4")
                            {
                                ?>
                                <th>¿OK?</th>

                        <th></th>
                                <?php
                            }

                            ?>

                            
                            
                       
                     
                         <?php
                            
                            if($_SESSION['user_tipo']=="-2" ||$_SESSION['user_tipo']=="0"||$_SESSION['user_tipo']=="4" ||$_SESSION['user_tipo']=="2" || $_SESSION['user_tipo']=="3"|| $_SESSION['user_tipo']=="-3")
                            {
                                ?>
                                <th>Validar ¿OK?</th>
                                <?php
                            }
                            ?>
                    </tr>
                </thead>
                <tbody>
                <?php 
                        while ($r=mysqli_fetch_array($query)) {
                            $check1="";
                            $check2="";
                            $display1='';
                            $display2='';
                            $display3='';

                            $comen1=$r['com_sup'];
                            $comen2=$r['com_cli'];
                            $comen3=$r['com_val'];
                            $date_fac=$r['date_fac'];
                            //echo"<script>alert('".$r['id'].intval($r['ok_sup'])."');</script>";
                            if($r['ok_sup']=="1")
                            {
                                $check1="checked";
                                $display1='style="display:none;"';
                                
                            }
                            

                            $dis_bot_cli="";
                            if($r['ok_cli']=="1")
                            {
                                $dis_bot_cli="disabled";
                                $display2='style="display:none;"';
                                
                            }

                            $check2_1="";
                            if($r['si_aid']=="1")
                            {
                                $check2_1="checked";
                                
                            }


                            $check3="";

                            if($r['ok_val']=="1")
                            {
                                $check3="checked";
                                $display3='style="display:none;"';
                                
                            }

                            $id=$r['id'];
                            $deducible=$r['deducible'];
                            $iva=$r['iva'];
                            $id_cheque=$r['id_cheque'];

                            if(""==$r['comprobante'])
                            {
                            	$si_pdf="class='btn btn-default'";
                            	$deshabilita='disabled="disabled"';
                            	$onclick="";
                                $boton_des="";
                                $folio_fi="";

                            }else
                            {
                                $temp_fol=explode(".",$r['comprobante']);
                                $folio_fi=$temp_fol[0];
                                $boton_des='<a target="_blank" href="comprobantes/'.$r['comprobante'].'" class="btn btn-default" title="Descarga de factura">
                                    <i class="fa fa-cloud-download"></i> </a>';
                            	$si_pdf="class='btn btn-success'";
                            	$deshabilita='';
                                $deshabilita1='disabled="disabled"';                                
                            	$onclick='onclick="eliminar_fichero('.$id.','.$id_cheque.')"';
                            }
                            if($deducible=="0"){
                                $deducible="No";
                                $deshabilita1='disabled="disabled"';
                            }else{
                                $deshabilita1="";
                                $deducible="S&iacute;";
                            }

                            $created_at=date('d/m/Y', strtotime($r['created_at']));
                            $description=$r['description'];
                            $amount=$r['amount'];
                            $user_id=$r['user_id'];
                            $category_id=$r['category_id'];

                            $sql = mysqli_query($con, "select * from category_income where id=$category_id");
                            if($c=mysqli_fetch_array($sql)) {
                                $name_category=$c['name'];
                            }

                            $coin_name = "coin";
                            $querycoin = mysqli_query($con,"select * from configuration where name=\"$coin_name\" ");
                            if ($r2 = mysqli_fetch_array($querycoin)) {
                                $coin=$r2['val'];
                            }
                            
                ?>
                    <!-- <input type="hidden" value="<?php echo $created_at;?>" id="created_at<?php echo $id;?>"> -->
                    <input type="hidden" value="<?php echo $description;?>" id="description<?php echo $id;?>">
                    <input type="hidden" value="<?php echo $category_id;?>" id="category_id<?php echo $id;?>">
                    <input type="hidden" value="<?php echo number_format($amount,2,'.','');?>" id="amount<?php echo $id;?>">

                    <tr class="even pointer">
                        <td><?php echo $date_fac; ?></td>
                        <td><?php echo $created_at;?></td>
                        <td ><?php echo $description; ?></td>
                        <td>$<?php  echo number_format($amount,2);?></td>
                        <td>$<?php echo number_format($iva,2);?></td>
                        <td>$<?php echo number_format(($iva*1)+($amount*1),2);?></td>
                        <td><?php echo $name_category;?></td>
                        <td><?php echo $deducible;?></td>
                        <td><?php echo $folio_fi;?></td>
                          <?php
                          
                            if($_SESSION['user_tipo']=="3"||$_SESSION['user_tipo']=="0"||$_SESSION['user_tipo']=="5"|| $_SESSION['user_tipo']=="4"|| $_SESSION['user_tipo']=="-3")
                            {
                                $disabled="";

                                if(($_SESSION['user_tipo']=="5"|| $_SESSION['user_tipo']=="4"|| $_SESSION['user_tipo']=="-3") && $_SESSION['programa']=="1")
                                {
                                    $disabled=" disabled ";
                                }
                                ?>
                                <td>

                                    <input <?php echo$disabled; echo $check1; ?> type="checkbox" onchange="ok_sup(this);" value="<?php echo $id;?>">
                                    <?php
                                if($_SESSION['user_tipo']=="-2"||$_SESSION['user_tipo']=="0"||$_SESSION['user_tipo']=="3" || ['programa']!="1" )
                                {
                                    ?>
                                    <input value="<?php echo $comen1; ?>" class="form-control" onkeyup="guarda_com_sup(this);" type="" name="" <?php echo $display1; ?> id="comen1<?php echo $id;?>">
                                    <?php
                                }else
                                {
                                    echo $comen1;

                                }
                                ?>
                                </td>
                                <?php
                            }
                            ?>
                            <?php
                            
                            if($_SESSION['user_tipo']=="5"||$_SESSION['user_tipo']=="0"|| $_SESSION['user_tipo']=="4"|| $_SESSION['user_tipo']=="-3" )
                            {
                                 $disabled="";
                                if( ($_SESSION['user_tipo']=="4"|| $_SESSION['user_tipo']=="-3") && $_SESSION['programa']=="1")
                                {
                                    $disabled=" disabled ";
                                }

                                ?>
                                <td>
                                <button <?php echo $dis_bot_cli; ?> class="btn btn-success" title="Autorizar" onclick="ok_cli(<?php echo $id;?>,<?php echo $id_cheque;?>,1);" ><i class="fas fa-thumbs-up"></i></button>
                                <button <?php echo $dis_bot_cli; ?> class="btn btn-danger" title="Descartar" onclick="ok_cli(<?php echo $id;?>,<?php echo $id_cheque;?>,2);" ><i class="fas fa-times"></i></button>
                                    
                                    <?php

                                if($_SESSION['user_tipo']=="-2"||$_SESSION['user_tipo']=="0" ||$_SESSION['user_tipo']=="5" || ['programa']=="1")
                                {
                                    ?>
                                    <input value="<?php echo $comen2; ?>" class="form-control"  type="" name="" <?php echo $display2; ?> id="comen2<?php echo $id;?>">
                                        <?php
                                }else
                                {
                                    echo $comen2;

                                }
                                ?>
                                </td>
                                <?php
                            }
                            if($_SESSION['user_tipo']=="4")
                            {
                                
                            ?>
                                <td>
                                    <input <?php  echo $check2_1; ?> type="checkbox" onchange="si_aid(this);" value="<?php echo $id;?>">
                                </td>
                                <?php
                            }

                            ?>
                            <td style="width: 150px;">
                               
                                    
                                    <?php
                                    if($_SESSION['user_tipo']=="2" || $_SESSION['user_tipo']=="3"|| $_SESSION['programa']!="1"){
                                        ?>

                                    <a href="#" <?php echo $si_pdf;?>  title='Adjuntar factura' onclick="id_subir('<?php echo $id;?>');" data-toggle="modal" data-target=".bs-example-modal-lg-subir"><i class="fa fa-cloud-upload"></i></a> 

                                    <a href="#" class='btn btn-default' <?php echo $deshabilita;?> title='Eliminar factura'<?php echo $onclick; ?>>
                                    <i class="glyphicon glyphicon-trash"></i> </a>


                                    <?php
                                }

                                ?>

                                    <?php echo $boton_des;

                                    if($_SESSION['user_tipo']=="2" || $_SESSION['user_tipo']=="3"){
                                     ?>

                                    <a id="c<?php echo $cont; ?>" href="#" class='btn btn-danger' title='Eliminar gasto' onclick="eliminar_com('<?php echo $id;?>');"><i class="fa fa-close"></i> </a>
                                    <?php
                                }
                                ?>
                                
                              

                            </td>
                            <?php

                                if($_SESSION['user_tipo']=="2" || $_SESSION['user_tipo']=="3"|| $_SESSION['user_tipo']=="0")
                                {
                                    ?>
                            <td>
                                <a href="#" class='btn btn-default' title='Editar gasto' onclick="editar_gasto('<?php echo $id;?>');" data-toggle="modal" data-target=".bs-example-modal-lg-edi"><i class="glyphicon glyphicon-edit"></i></a> 
                                
                            </td>
                               <?php
                                }

                            ?>
                            <?php

                                if($_SESSION['user_tipo']=="-2" ||$_SESSION['user_tipo']=="0" ||$_SESSION['user_tipo']=="4"||$_SESSION['user_tipo']=="2" || $_SESSION['user_tipo']=="3"|| $_SESSION['user_tipo']=="-3")
                                {
                                    $dis="  ";
                                    if($_SESSION['user_tipo']=="4"||$_SESSION['user_tipo']=="2" || $_SESSION['user_tipo']=="3"|| $_SESSION['user_tipo']=="-3")
                                    {
                                     $dis=" disabled ";
                                 }
                                    ?>
                                    <td>
                                        <center>
                                            <input <?php echo $check3; echo $dis; ?>  type="checkbox" onchange="ok_val(this);" value="<?php echo $id;?>">
                                            <br>

                                            
                                             <?php

                                if($_SESSION['user_tipo']=="-2" ||$_SESSION['user_tipo']=="0")
                                {
                                    ?>
                                    <input value="<?php echo $comen3; ?>" class="form-control" onkeyup="guarda_com_val(this);" type="" name="" <?php echo $display3; ?> id="comen3<?php echo $id;?>">

                                    <?php
                                }else
                                {
                                    echo $comen3;

                                }
                                    ?>
                                        </center>
                                    </td>
                                    
                                    <?php
                                }

                            ?>
                    </tr>
                <?php
                    } //end while
                ?>
                
              </table>
            </div>
            <?php
        }else{
           ?> 
            <div class="alert alert-warning alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Aviso!</strong> No hay datos para mostrar
            </div>
        <?php    
        }
    }
?>