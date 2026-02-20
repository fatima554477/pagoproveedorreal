<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

<div id="content">     
			<hr/>
		<strong>	  <p class="mb-0 text-uppercase" ><img src="includes/contraer31.png" id="mostrar5" style="cursor:pointer;"/>
<img src="includes/contraer41.png" id="ocultar5" style="cursor:pointer;"/>&nbsp;&nbsp;&nbsp; FILTRO PAGO APROVEEDORES-VYO</p></strong></div>


<div  id="mensajefiltro"></div>
<div  id="pasarpagado2"></div>
 </div>
							
	        <div id="target5" style="display:block;" class="content2">
        <div class="card">
          <div class="card-body">
      
<!--aqui inicia filtro-->

            <div class="row text-center" id="loader2" style="position: absolute;top: 140px;left: 50%"></div>
<table width="100%" border="0">
<tr>
<td width="30%" align="center">
	<span>Mostrar</span>
	<select  class="form-select mb-3" id="per_page" onchange="load2(1);">
		<option value="7" <?php if(!empty($_REQUEST['per_page'])){echo 'selected';} ?>>7</option>
		<option value="5" <?php if($_REQUEST['per_page']=='5'){echo 'selected';} ?>>5</option>
		<option value="10" <?php if($_REQUEST['per_page']=='10'){echo 'selected';} ?>>10</option>
		<option value="15" <?php if($_REQUEST['per_page']=='15'){echo 'selected';} ?>>15</option>
		<option value="20" <?php if($_REQUEST['per_page']=='20'){echo 'selected';} ?>>20</option>
		<option value="50" <?php if($_REQUEST['per_page']=='50'){echo 'selected';} ?>>50</option>
		<option value="100" <?php if($_REQUEST['per_page']=='100'){echo 'selected';} ?>>100</option>
	</select>
</td>


<td width="30%" align="center">					
	<button  class="btn btn-sm btn-outline-success px-5" type="button" onclick="load2(1);" >BUSCAR/RESET</button>
</td>

<td width="30%" align="center">
	<span>PLANTILLA</span>
	
	<!--<select  class="form-select mb-3" id="DEPARTAMENTO2WE" onchange="load(1);">
	
	<option value="DEFAULT" <?php if($_SESSION['DEPARTAMENTO']=='DEFAULT'){echo 'selected';} ?>>DEFAULT</option>
	
	<option value="SANDOR" <?php if($_SESSION['DEPARTAMENTO']=='SANDOR'){echo 'selected';} ?>>SANDOR</option>
	
	<option value="SANDOR3" <?php if($_SESSION['DEPARTAMENTO']=='SANDOR3'){echo 'selected';} ?>>SANDOR3</option>

	</select>-->


<?php
$encabezado = '<select class="form-select mb-3" id="DEPARTAMENTO2WE" required onchange="load2(1);">
                <option value="">SELECCIONA UNA OPCIÓN</option>';
$options = '';

// Colores de fondo (asegurar que hay suficientes)
$fondos = array("fff0df", "f4ffdf", "dfffed", "dffeff", "dfe8ff", "efdfff", "ffdffd", "ffdfe9", "e6dfff");
$num = 0;

$queryper = $conexion->desplegablesfiltro('ventasoperaciones', '');

while($row1 = mysqli_fetch_array($queryper)) {
    // Rotación de colores
    $bgColor = $fondos[$num];
    $num = ($num === count($fondos) - 1) ? 0 : $num + 1;
    
    // Verificar selección
    $selected = ($_SESSION['DEPARTAMENTO'] === $row1['nombreplantilla']) ? 'selected' : '';
    
    // Convertir a mayúsculas
    $nombre = mb_strtoupper($row1['nombreplantilla'], 'UTF-8');
    
    $options .= '<option style="background: #' . $bgColor . '" ' . $selected . 
                ' value="' . htmlspecialchars($row1['nombreplantilla']) . '">' . 
                htmlspecialchars($nombre) . '</option>';
}

echo $encabezado . $options . '</select>';
?>




</td>
        <p><strong style="background:#ffb6c1"> ROSA:</strong> 
        FORMAS DE PAGO DIFERENTES A (03 TRANSFERENCIA ELECTRONICA DE FONDOS)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       <strong style="background:#fdfe87"> AMARILLO:</strong> 
        PAGO A PROVEEDOR SIN XML
        </p>

</tr>
</table>
		<div class="datos_ajax2">
		</div>
  
<!--aqui termina filtro-->


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