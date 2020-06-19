<!-- Button trigger modal -->
<button type="button" class="btn btn-primary " data-toggle="modal" data-target="#myModal">
  Redactar
</button>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" >
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Redactar</h4>
      </div>
      <div class="modal-body">
      <div id="salida_res"></div>
      <?php destinatarios(); ?>
      <br>
      <input type="text" style="width: 250px;" class="form-control" name="asunto" id="asunto" placeholder="Asunto">
        <textarea name="editor1" id="editor1" id="msn" ></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="enviar()">Enviar</button>
      </div>
    </div>
  </div>
</div>