<?php 
    $title ="Dashboard - "; 
    include "head.php";
	$active1="active";
    include "sidebar.php";
	include("funciones.php");
?>

<?php 
session_start();

if($_SESSION['user_tipo']=="0" || $_SESSION['user_tipo']=="1" || $_SESSION['user_tipo']=="-1" || $_SESSION['user_tipo']=="-3"|| $_SESSION['user_tipo']=="-2")
{
  $filtro=" ";
  if (isset($_GET['pro'])) {
    $filtro=" and che.programa='".$_GET['pro']."' ";
  }
   
}
if($_SESSION['user_tipo']=="3" || $_SESSION['user_tipo']=="4"  || $_SESSION['user_tipo']=="5")
{
  $filtro=" and che.programa='".$_SESSION['programa']."' and usu.rutas in ('".str_replace(",","','",$_SESSION['rutas'])."') ";

}
if($_SESSION['user_tipo']=="2")
{
  $filtro=" and usu.id='".$_SESSION['user_id']."'   ";
}

$consulta="SELECT sum(che.monto) as monto from gastos as gas join cheques as che on che.id=gas.id_cheque join user as usu on usu.id=che.beneficiario where  gas.status=1  $filtro ";
  $expenses = mysqli_query($con, $consulta);

$consulta="SELECT sum(des.amount+des.iva) as monto from desglose as des join cheques as che on che.id=des.id_cheque join user as usu on usu.id=che.beneficiario where ((des.deducible='0' $filtro) or (des.comprobante!='' $filtro)) ";
  $income = mysqli_query($con,$consulta );

$expenses=mysqli_fetch_array($expenses);
$income=mysqli_fetch_array($income);
$expenses=$expenses['monto'];
$income=$income['monto'];
    
?>
	<div class="right_col" role="main" >
    
          <div class="">

            <div class="row top_tiles">
              <?php
              if($_SESSION['user_tipo']=="-3"){
                ?>
              <div style="width: 100%; text-align: right;  padding: 5px;">
                <select class="form-control" style="width: 25%; " onchange="carga(this);">
                  <option value="">--Seleccione un programa--</option>
                  <?php 
                  $consulta="SELECT * from programas ";
                  $sql=mysqli_query($con,$consulta);
                  while($pro=mysqli_fetch_array($sql)) {
                    $selected="";
                    if($pro['id']==$_GET['pro'])
                    {}
                    ?>
                    <option value="<?php echo $pro['id'];?>"><?php echo $pro['name'];?></option>
                    <?php
                  }
                  ?>
                  
                </select>

              </div>
              <?php
            }
              ?>
              
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">
                  <div class="icon"><i class=" fa fa-usd"></i></div>
                  
				  
                            <div class="count"><?php echo number_format($expenses,2); ?></div>
                   
                 
                  <center><a href="expences.php"><h4>Gastos Generados </h4></a></center>
                 
                </div>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-credit-card"></i></div>
                  
                            <div class="count"><?php echo number_format($income,2); ?></div>
                 
                  <center> <a href="expences.php?g=1"><h4>Gastos Comprobados</h4></a></center>
                 
                </div>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-usd"></i></div>
                  <div class="count"><?php echo number_format(($expenses-$income),2);?></div>
                  <center><a href="expences.php?g=2"><h4>Gastos por Comprobar</h4></a></center>
                  
                </div>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-credit-card"></i></div>
                  <div class="count"><?php echo no_aprobado($filtro);?></div>
                  <center><h4>Gastos Rechazados</h4></center>
                 
                </div>
              </div>
            </div>

          </div>
		<div class='row'>  
		  <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Ingresos vs Gastos <small>Reporte mensual</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content"><iframe class="chartjs-hidden-iframe" style="width: 100%; display: block; border: 0px; height: 0px; margin: 0px; position: absolute; left: 0px; right: 0px; top: 0px; bottom: 0px;"></iframe>
                    <canvas id="mybarChart2" style="width: 521px; height: 260px;" width="521" height="260"></canvas>
                  </div>
                </div>
              </div>
			 </div>
			 
        </div>

<?php include "footer.php" ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js"></script>

<script>
function gastos_mes()
{
  console.log(document.getElementById("mes"));
}

 if($("#mybarChart2").length) {
            var f=document.getElementById("mybarChart2");
            new Chart(f,
            {
                type:"bar",
                data: {
                    labels:["Enero","Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio","Agosto",	"Septiembre","Octubre",	"Noviembre","Diciembre"],
                    datasets:[ {
                        label: "Gastos a Comprobar", backgroundColor: "#26B99A", data: [<?php echo sum_expense_month_nc($filtro,1); ?>, <?php echo sum_expense_month_nc($filtro,2); ?>, <?php echo sum_expense_month_nc($filtro,3); ?>, <?php echo sum_expense_month_nc($filtro,4); ?>, <?php echo sum_expense_month_nc($filtro,5); ?>, <?php echo sum_expense_month_nc($filtro,6); ?>, <?php echo sum_expense_month_nc($filtro,7); ?>,<?php echo sum_expense_month_nc($filtro,8); ?>,<?php echo sum_expense_month_nc($filtro,9); ?>,<?php echo sum_expense_month_nc($filtro,10); ?>,<?php echo sum_expense_month_nc($filtro,11); ?>,<?php echo sum_expense_month_nc($filtro,12); ?>]
                    }
                    ,
                    {
                        label: "Gastos Comprobados", backgroundColor: "#03586A", data: [<?php echo sum_expenses_month_c($filtro,1);?>, <?php echo sum_expenses_month_c($filtro,2);?>, <?php echo sum_expenses_month_c($filtro,3);?>, <?php echo sum_expenses_month_c($filtro,4);?>, <?php echo sum_expenses_month_c($filtro,5);?>, <?php echo sum_expenses_month_c($filtro,6);?>, <?php echo sum_expenses_month_c($filtro,7);?>,<?php echo sum_expenses_month_c($filtro,8);?>,<?php echo sum_expenses_month_c($filtro,9);?>,<?php echo sum_expenses_month_c($filtro,10);?>,<?php echo sum_expenses_month_c($filtro,11);?>,<?php echo sum_expenses_month_c($filtro,12);?>]
                    }
                    ]
                }
                ,
               
                options: {
                  
                    scales: {
                        yAxes:[ {
                            ticks: {
                                beginAtZero: !0
                            }
                        }
                        ]
                    }
                }
            }
            )
        }

function carga(este)
{
  var pro= este.value;
  this.location="dashboard.php?pro="+pro;
}



</script>