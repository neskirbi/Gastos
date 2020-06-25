        
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu"><!-- sidebar menu -->
            <div class="menu_section">
                <ul class="nav side-menu">
                 <li class="<?php if(isset($active1)){echo $active11;}?>">
                        <a href="inbox.php"><i class="fas fa-envelope"></i> Notificaciones<span id="sal_noti"></span></a>
                    </li>
                    <?php
                    ///////////////////////
                    if($_SESSION['user_tipo']=="0" || $_SESSION['user_tipo']=="2" || $_SESSION['user_tipo']=="3" || $_SESSION['user_tipo']=="4" || $_SESSION['user_tipo']=="5" || $_SESSION['user_tipo']=="6"  || $_SESSION['user_tipo']=="-3"  )
                    {
                        ?>
                    <li class="<?php if(isset($active1)){echo $active1;}?>">
                        <a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <?php
                    }
                    /////////////////////////////////


                    if($_SESSION['user_tipo']=="-2" || $_SESSION['user_tipo']=="0" || $_SESSION['user_tipo']=="2" || $_SESSION['user_tipo']=="3"  || $_SESSION['user_tipo']=="4" || $_SESSION['user_tipo']=="5" || $_SESSION['user_tipo']=="6" || $_SESSION['user_tipo']=="-3")
                    {
                        ?>
                     <li class="<?php if(isset($active2)){echo $active2;}?>">
                        <a href="expences.php"><i class="fa fa-credit-card"></i> Control de Gastos</a>
                    </li>
                    <?php
                    }


                    /////////////////////////////
                     if($_SESSION['user_tipo']=="0"  || $_SESSION['user_tipo']=="3"  || $_SESSION['user_tipo']=="4" || $_SESSION['user_tipo']=="5" || $_SESSION['user_tipo']=="6")
                    {
                        ?>
                        <li class="<?php if(isset($active5)){echo $active5;}?>">
                            <a href="por_persona.php"><i class="fa fa-align-left"></i> Detalle por Persona</a>
                        </li>

                    <?php
                    }
               
                    
                    ////////////////////////////////////////

					if($_SESSION['user_tipo']=="0" || $_SESSION['user_tipo']=="4"  )
                    {
                        ?>
                    <li class="<?php if(isset($active4)){echo $active4;}?>">
                        <a href="cheque.php"><img src="images/payroll.png" class="fa"></img>Solicitar Gasto</a>
                    </li>
                    <?php
                    }
                    ////////////////////////////////////////

                    
                    if($_SESSION['user_tipo']=="1" )
                    {
                        ?>
                    <li class="<?php if(isset($active4)){echo $active4;}?>">
                        <a href="cheque.php"><img src="images/payroll.png" class="fa"></img>Autorizar Cheque</a>
                    </li>

                    <li class="<?php if(isset($active4)){echo $active4;}?>">
                        <a href="cheques_aceptados.php"><img src="images/payroll.png" class="fa"></img>Cheques Aceptados</a>
                    </li>

                    <li class="<?php if(isset($active4)){echo $active4;}?>">
                        <a href="cheques_rechazados.php"><img src="images/payroll.png" class="fa"></img>Cheques Rechazados</a>
                    </li>
                    <?php
                    }
                    ////////////////////////////////
                    ?>

                    
                    <?php
                    if($_SESSION['user_tipo']=="0" || $_SESSION['user_tipo']=="5")
                    {
                    ?>
                        

                    <li class="<?php if(isset($active6)){echo $active6;}?>">
                        <a href="expences2.php"><i class="fa fa-align-right"></i>Resumen por Persona</a>
                    </li>
                    
                    <?php
                    }
                    /////////////////////////////////////////

                    if($_SESSION['user_tipo']=="0" || $_SESSION['user_tipo']=="5" || $_SESSION['user_tipo']=="2" || $_SESSION['user_tipo']=="3")
                    {

                    ?>
                    <li class="<?php if(isset($active10)){echo $active10;}?>">
                        <a href="rechazados.php"><i class="fa fa-times"></i> Gastos Rechazados</a>
                    </li> 

                    
                    <?php
                    }
                    ////////////////////////////////////////////

                    if($_SESSION['user_tipo']=="0")
                    {

                    ?>
                    <li class="<?php if(isset($active7)){echo $active7;}?>">
                        <a href="users.php"><i class="fa fa-users"></i> Usuarios</a>
                    </li>

                    
                    <?php
                    }
                    ////////////////////////////////////////////////

                    if($_SESSION['user_tipo']=="0")
                    {
                            ?>
                        <li class="<?php if(isset($active8)){echo $active8;}?>">
                          <a href="settings.php"><i class="fa fa-cog"></i> Configuración</a>
                        </li>
                            <?php
                    }

                        /////////////////////////////////

                        if($_SESSION['user_tipo']=="0" || $_SESSION['user_tipo']=="4")
                        {
                            ?>
                            <li class="<?php if(isset($active9)){echo $active9;}?>">
                            <a href="facturacion.php"><i class="fa fa-cog"></i> Soporte mensual</a>
                            </li>
                            <?php
                        }
                        /////////////////////////
                        if($_SESSION['user_tipo']=="0" || $_SESSION['user_tipo']=="4"|| $_SESSION['user_tipo']=="5")
                        {
                            ?>
                            <li class="<?php if(isset($active9)){echo $active9;}?>">
                            <a data-target="#myModal" data-toggle="modal"><i class="fa fa-bar-chart"></i> Desgloses</a>
                            </li>
                            <?php
                        }
                        ?>


                    
                </ul>
            </div>
        </div><!-- /sidebar menu -->
    </div>
</div> 
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="width: 100%; margin-left: 10%;" id="modal-body" name="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
     
    <div class="top_nav"><!-- top navigation -->
        <div class="nav_menu">
            <nav>
                <div class="nav toggle">
                    <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                </div>
                <ul class="nav navbar-nav navbar-right">
                    <li class="">
                        <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <img src="images/profiles/<?php echo $profile_pic;?>" alt=""><?php echo $name;?>
                            <span class=" fa fa-angle-down"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-usermenu pull-right">
                            <li><a href="profile.php"><i class="fa fa-user"></i> Mi cuenta</a></li>
							<li><a href="http://obedalvarado.pw/contacto/" target="_blank"><i class="fa fa-info"></i> Soporte</a></li>
                            <li><a href="action/logout.php"><i class="fa fa-sign-out pull-right"></i> Cerrar Sesión</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </div><!-- /top navigation -->    
    <?php
    //include"ventana.php";

    ?>

    <script>
       $( "#modal-body" ).load( "desgloseXCL.php" );
        function noti()
        {
            $.post("ajax/avisos.php",{},function(result){
                //console.log(result);
                $('#sal_noti').html(result);
            });
        } 

        setInterval(noti,10000);
    </script>