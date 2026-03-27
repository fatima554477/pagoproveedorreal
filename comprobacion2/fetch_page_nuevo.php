<div id="content">     
	<hr/>
	<strong>
		<p class="mb-0 text-uppercase">
			<img src="includes/contraer31.png" id="mostrar2" onclick="load(1);" style="cursor:pointer;"/>
			<img src="includes/contraer41.png" id="ocultar2" style="cursor:pointer;"/>&nbsp;&nbsp;&nbsp; FILTRO COMPROBACIONES DE GASTOS 
		</p>
	</strong>
</div>

<div id="mensajefiltro">
	<div class="progress" style="width: 25%;">
		<div class="progress-bar" role="progressbar" style="width: <?php echo $Aeventosporcentaje ; ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?php echo $Aeventosporcentaje ; ?>%</div>
	</div>
</div>
							
<div id="target2" style="display:block;" class="content2">
	<div class="card">
		<div class="card-body">
			<!--aqui inicia filtro-->
			<div class="row text-center" id="loader" style="position: absolute;top: 140px;left: 50%"></div>
			<table width="100%" border="0">
				<tr>

<td width="30%" align="center"> 
    <span>MOSTRAR</span>
    <select class="form-select mb-3" id="per_page" onchange="load(1);">
  
<option value="7" <?php if(!empty($_REQUEST['per_page'])){echo 'selected';} ?>>7</option>
        <option value="10" <?php if($_REQUEST['per_page']=='10') echo 'selected'; ?>>10</option>
        <option value="50" <?php if($_REQUEST['per_page']=='50') echo 'selected'; ?>>50</option>
        <option value="100"<?php if($_REQUEST['per_page']=='100')echo 'selected'; ?>>100</option>
	<option value="100000"  <?php if($_REQUEST['per_page']=='100000')  echo 'selected'; ?>>TODOS</option>
        
    </select>
</td>
								<td width="30%" align="center">
    <button class="btn btn-sm btn-outline-success px-5" type="button" onclick="load(1);">BUSCAR</button>
    &nbsp;
    <button class="btn btn-sm btn-outline-danger px-4" type="button" onclick="LIMPIAR_FILTRO();">🧹 LIMPIAR FILTRO</button>
</td>
<td width="30%" align="center">
    <span>PLANTILLA</span>
    <?php
    $encabezado = '';
    $option = '';
    $queryper = $conexion->desplegablesfiltro('comprobaciones','');
    $encabezado = '<select class="form-select mb-3" id="DEPARTAMENTO2WE" required="" onchange="load(1);">
        <option value="">SELECCIONA UNA OPCIÓN</option>';
    /*linea para multiples colores*/
    $fondos = array("fff0df","f4ffdf","dfffed","dffeff","dfe8ff","efdfff","ffdffd","efdfff","ffdfe9");
    $num = 0;
    /*linea para multiples colores*/	
    while($row1 = mysqli_fetch_array($queryper)) {
        /*linea para multiples colores*/
        if($num==8) {
            $num=0;
        } else {
            $num++;
        }
        /*linea para multiples colores*/		
        $select = '';
        if($_SESSION['DEPARTAMENTO'] == $row1['nombreplantilla']) {
            $select = "selected";
        }

        // Cambio aplicado aquí: strtoupper() al texto mostrado
        $option .= '<option style="background: #'.$fondos[$num].'" '.$select.' value="'.$row1['nombreplantilla'].'">'.strtoupper($row1['nombreplantilla']).'</option>';
    }
    echo $encabezado.$option.'</select>';			
    ?>	
</td>
					<p>
						<strong style="background:#ffb6c1"> ROSA:</strong> 
						FORMAS DE PAGO DIFERENTES A (04 TARJETA)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<strong style="background:#fdfe87"> AMARILLO:</strong> 
						COMPROBACIÓN SIN XML
					</p>
				</tr>
			</table>
			<div class="datos_ajax"></div>
			<!--aqui termina filtro-->
		</div>
	</div>
</div>
<div class="modal fade" id="modalRechazoPago" tabindex="-1" role="dialog" aria-labelledby="modalRechazoPagoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background:#ebf9e9;">
                <h5 class="modal-title" id="modalRechazoPagoLabel">Motivo del rechazo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="cerrarModalRechazoPago();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="modal_rechazo_id" value="">
                <textarea id="modal_rechazo_texto" class="form-control" rows="5" placeholder="Describe el motivo del rechazo"></textarea>
                <div id="modal_rechazo_mensaje" style="margin-top:10px;font-size:12px;color:#666;"></div>
            </div>
            <div class="modal-footer" id="modal_rechazo_footer_editar">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="cerrarModalRechazoPago();">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btn_guardar_rechazo_modal">Guardar</button>
            </div>
            <div class="modal-footer" id="modal_rechazo_footer_ver" style="display:none;">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="cerrarModalRechazoPago();">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<?php
if($_GET['num_evento']==true){
	$_SESSION['num_evento']=$_GET['num_evento'];
}else{
	$_SESSION['num_evento']='';
}
require "clases/script.filtro.php";
?>