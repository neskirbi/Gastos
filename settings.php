<?php
session_start();
    $title ="Configuracion | ";
    include "head.php";
	$active8="active";
    include "sidebar.php";
    if($_SESSION['user_tipo']!="0")
    {
    	echo("<script>
    		this.location='index.php';</script>");
    	
    }

   $configuration = mysqli_query($con, "select * from configuration");

?>
        
    <div class="right_col" role="main"> <!-- page content -->
        <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Configuraciones Generales</h3>
              </div>
            </div>
			
            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="x_panel">
					
                        <div class="x_title">
                            <h2>Configuración</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
						<?php 
							if (isset($_GET['succes'])){
								?>
							<div class="alert alert-success" role="alert">
								<button type="button" class="close" data-dismiss="alert">&times;</button>
								<strong>¡Bien hecho!</strong> Datos actualizados correctamente.	
							</div>		
								<?php
							}
						?>
                            <br />
                            <form action="action/upd_settings.php" method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                                <?php if(mysqli_num_rows($configuration)>0){?>
                                    <?php foreach($configuration as $cat){
										
											if($cat['name']=="logo"){
												$logo_img=$cat['val'];
											} else {
									?>
                                   
									<div class="form-group">
                                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name"><?php echo $cat['label']?></label>
                                        <div class="col-md-10 col-sm-10 col-xs-12">
                                            <input type="text" id="first-name" name="<?php echo $cat['name']; ?>" class="form-control col-md-7 col-xs-12" value="<?php echo $cat['val'];?>">
                                        </div>
                                    </div>
									
                                    <?php 
											}	
									} //end foreach?>
                                <?php } //end if ?>   
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-2">
                                        <button type="submit"  name="token1" class="btn btn-success">Actualizar Datos</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>      
                </div>
				<div class="col-md-4 col-sm-4 col-xs-12">
					<div class="row">
               
                    <div class="x_panel">
                        <div class="x_content">
						
							<div class="row">
								<div class='col-md-12'>
									<label>Logo</label>	<br>
								 <div id="load_img"> 	
									<img src="images/<?php echo $logo_img; ?>" alt="Logotipo" width="300px">
								</div>	
								</div>
								<div class='col-md-12'>
									<br>
										<span class="btn btn-my-button btn-file">
                                            Selecionar una imagen <input type="file" name="imagefile" id="imagefile" onchange="upload_image();">
                                        </span>
								</div>
							</div>
                           
                        </div>
                    </div>
                
            </div>
				</div>
            </div>

            
        </div>
  </div><!-- /page content -->

<?php include "footer.php" ?>

<script>
		function upload_image(){
				
				var inputFileImage = document.getElementById("imagefile");
				var file = inputFileImage.files[0];
				if( (typeof file === "object") && (file !== null) )
				{
					$("#load_img").text('Cargando...');	
					var data = new FormData();
					data.append('imagefile',file);
					
					
					$.ajax({
						url: "ajax/imagen_ajax.php",        // Url to which the request is send
						type: "POST",             // Type of request to be send, called as method
						data: data, 			  // Data sent to server, a set of key/value pairs (i.e. form fields and values)
						contentType: false,       // The content type used when sending data to the server.
						cache: false,             // To unable request pages to be cached
						processData:false,        // To send DOMDocument or non processed data file it is set to false
						success: function(data)   // A function to be called if request succeeds
						{
							$("#load_img").html(data);
							
						}
					});	
				}
				
				
			}
    </script>