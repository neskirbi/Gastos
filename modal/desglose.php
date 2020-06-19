  
	<!-- Modal -->
    <div class="modal fade bs-example-modal-lg-udp" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" style="width:100%;">
            <div class="modal-content" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel"> Desglose de Gastos</h4>
                </div>
                <div class="modal-body">
                <span id="loader2"></span>
                 <?php
                    include("modal/add_gasto.php");
                    include("modal/editar_gas.php");
                ?>
                    
                        <div class='outer_div2' style="height: 400px;overflow-y: scroll; "></div>
                    
                </div>
               
            </div>
        </div>
    </div> <!-- /Modal -->
	