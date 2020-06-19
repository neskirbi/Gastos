<?php
    include "../config/config.php";//Contiene funcion que conecta a la base de datos
    session_start();
   

    if (isset($_GET['id'])){
        
		  $id=intval($_REQUEST['id']);
        
        
        //main query to fetch the data
        $sql="SELECT * FROM  desglose where id_cheque='$id' and ok_sup='0' or ok_cli='0' order by created_at desc";
        $query = mysqli_query($con, $sql);
        //loop through fetched data
        $numrows=mysqli_num_rows($query);
        if ($numrows>0){
            
            ?>
            <button class="btn btn-default" onclick="imprime_formato(<?php echo $id; ?>);"><span class="glyphicon glyphicon-print" ></span> Imprimir</button>
            <table class="table table-striped jambo_table bulk_action">
                <thead>
                    <tr class="headings">
                        <th class="column-title">Fecha </th>
                        <th class="column-title">Descripción </th>
                        <th class="column-title">Monto </th>
                        <th class="column-title">IVA </th>
                        <th class="column-title">Concepto </th>
                        <th class="column-title">Deducible </th>
                        <th class="column-title">F. fiscal </th>
                          <?php
                            
                            if($_SESSION['user_tipo']=="3" || $_SESSION['user_tipo']=="0"||$_SESSION['user_tipo']=="5")
                            {
                                ?>
                                <th>C. Supervisor</th>
                                <?php
                            }
                            ?>

                            <?php
                            
                            if($_SESSION['user_tipo']=="5" || $_SESSION['user_tipo']=="0")
                            {
                                ?>
                                <th>C. Cliente</th>
                                <?php
                            }
                            ?>

                            
                            

                        <th class="column-title no-link last"><span class="nobr"></span></th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                        while ($r=mysqli_fetch_array($query)) {
                            $check1="";
                            $check2="";
                            $display='';
                            $comen=$r['comentario'];
                            //echo"<script>alert('".$r['id'].intval($r['ok_sup'])."');</script>";
                            if($r['ok_sup']=="1")
                            {
                                $check1="checked";
                                
                            }
                            //echo"<script>alert('".$r['id'].intval($r['ok_cli'])."');</script>";
                            if($r['ok_cli']=="1")
                            {
                                $check2="checked";
                                $display='style="display:none;"';
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
                        <td><?php echo $created_at;?></td>
                        <td ><?php echo $description; ?></td>
                        <td>$<?php  echo number_format($amount,2);?></td>
                        <td>$<?php echo number_format($iva,2);?></td>
                        <td><?php echo $name_category;?></td>
                        <td><?php echo $deducible;?></td>
                        <td><?php echo $folio_fi;?></td>
                          <?php
                            
                            if($_SESSION['user_tipo']=="3"||$_SESSION['user_tipo']=="0"||$_SESSION['user_tipo']=="5")
                            {
                                $disabled="";
                                if($_SESSION['user_tipo']=="5")
                                {
                                    $disabled=" disabled ";
                                }
                                ?>
                                <td>
                                <!--aqui comentario supervisor de rechazo-->
                                </td>
                                <?php
                            }
                            ?>
                            <?php
                            
                            if($_SESSION['user_tipo']=="5"||$_SESSION['user_tipo']=="0")
                            {
                                ?>
                                <td>
                                    <?php echo $comen; ?>
                                        
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