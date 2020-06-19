<?php
    include "../config/config.php";//Contiene funcion que conecta a la base de datos
    session_start();
   

    if (isset($_GET['id'])){
        
		  $id=intval($_REQUEST['id']);
        
        
        //main query to fetch the data
        $sql="SELECT * FROM  desglose where id_cheque='$id' order by created_at desc";
        $query = mysqli_query($con, $sql);
        //loop through fetched data
        $numrows=mysqli_num_rows($query);
        if ($numrows>0){
            
            ?>
            <table border="1" class="table table-striped jambo_table bulk_action" style="font-size: 10px;">
                <thead>
                    <tr class="headings">
                        <th class="column-title" style="text-align: center;">Tipo de gasto </th>
                        <th class="column-title" style="text-align: center;">Justificacion del<br>gasto </th>
                        <th class="column-title" style="text-align: center;">Comensales </th>
                        <th class="column-title" style="text-align: center;">Fecha del Gasto<br>DD/MM/AA </th>
                        <th class="column-title" style="text-align: center;">Fecha del Comprobante<br>DD/MM/AA </th>
                        <th class="column-title" style="text-align: center;">Moneda</th>
                        <th class="column-title" style="text-align: center;">Comprobante<br> Fiscal </th>
                        <th class="column-title" style="text-align: center;">Subtotal </th>
                        <th class="column-title" style="text-align: center;">IVA </th>
                        <th class="column-title" style="text-align: center;">Propinas </th>
                        <th class="column-title" style="text-align: center;">Otros </th>
                        <th class="column-title" style="text-align: center;">Total </th>
                        <th class="column-title" style="text-align: center;">PDF </th>
                        <th class="column-title" style="text-align: center;">XML </th>
                        <th class="column-title" style="text-align: center;">OK </th>
                        <th class="column-title" style="text-align: center;">Comenta </th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                        while ($r=mysqli_fetch_array($query)) {
                            $check1="";
                            $check2="";
                            $display='';
                            $xml="";
                            $pdf="";
                            
                            
                            $comen=$r['comentario'];
                            //echo"<script>alert('".$r['id'].intval($r['ok_sup'])."');</script>";
                            if($r['ok_sup']=="1")
                            {
                                $check1="checked";
                                
                            }
                            //echo"<script>alert('".$r['id'].intval($r['ok_cli'])."');</script>";
                            if($r['ok_cli']=="1")
                            {
                                $check2="Ok";
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
                                $comprobante_f="No";
                            }else
                            {
                                if (strpos($r['comprobante'],"xml" ) !== false) 
                                {
                                    $xml="OK";
                                }else
                                {
                                    $pdf="OK";
                                }
                            	$si_pdf="class='btn btn-success'";
                            	$deshabilita='';
                            	$onclick='onclick="eliminar_fichero('.$id.','.$id_cheque.')"';
                                $comprobante_f="S&iacute;";
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
                    
                    

                    <tr class="even pointer">
                        <td><?php echo$name_category;?></td>
                        <td style="text-align: center;"><?php echo$description;?></td>
                        <td style="text-align: center;">-----</td>
                        <td style="text-align: center;"><?php echo$created_at;?></td>
                        <td style="text-align: center;"><?php echo$created_at;?></td>
                        <td style="text-align: center;"><?php echo"MXN";?></td>
                        <td style="text-align: center;"><?php echo$comprobante_f;?></td>
                        <td style="text-align: center;">$<?php  echo number_format($amount,2);?></td>
                        <td style="text-align: center;">$<?php echo number_format($iva,2);?></td>
                        <td>-----</td>
                        <td>-----</td>
                        <td style="text-align: center;">$<?php echo number_format(($iva+$amount),2);?></td>
                        <td><?php echo$pdf;?></td>
                        <td><?php echo$xml;?></td>
                        <td><?php echo$check2; ?></td>
                        <td><?php echo $comen;?></td>                      
                          
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