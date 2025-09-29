   <link href="minimal-table.css" rel="stylesheet" type="text/css">
   
       <style>
        .loader {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
            margin-right: 8px;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        #ajax-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 25px;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            display: none;
            z-index: 10000;
        }
    </style>

<div id="content">
	<hr/> <strong>	  <p class="mb-0 text-uppercase" ><img src="includes/contraer31.png" id="mostrar5" onclick="load(1);"style="cursor:pointer;"/>
<img src="includes/contraer41.png" id="ocultar5" style="cursor:pointer;"/>&nbsp;&nbsp;&nbsp; FILTRO PAGO A PROVEEDORES-A  <a style="color:red;font:7px">ORDEN DESCENDENTE </a></p></strong></div>
<div id="mensajefiltro"></div>
<div id="pasarpagado2"></div>
</div>
<div id="target5" style="display:block;" class="content2">
	<div class="card">
		<div class="card-body">
			<!--aqui inicia filtro-->
			<div class="row text-center" id="loader2" style="position: absolute;top: 140px;left: 50%"></div>
			<table width="100%" border="0">
				<tr>
<td width="30%" align="center"> 
    <span id="mostrar">MOSTRAR</span>
    <select class="form-select mb-3" id="per_page" onchange="load(1);">

       
		<option value="50" <?php if($_REQUEST['per_page']=='50') echo 'selected'; ?>>50</option>
        <option value="10" <?php if($_REQUEST['per_page']=='10') echo 'selected'; ?>>10</option>
        <option value="15" <?php if($_REQUEST['per_page']=='15') echo 'selected'; ?>>15</option>
        <option value="20" <?php if($_REQUEST['per_page']=='20') echo 'selected'; ?>>20</option>
        
        <option value="100"<?php if($_REQUEST['per_page']=='100')echo 'selected'; ?>>100</option>		
		<option value="200" <?php if($_REQUEST['per_page']=='200'){echo 'selected';} ?>>200</option>
		 <option value="10000"<?php if($_REQUEST['per_page']=='10000')echo 'selected'; ?>>TODOS</option>
    </select>
</td>

					<td width="30%" align="center">
						<button class="btn btn-sm btn-outline-success px-5" type="button" onclick="load(1);">BUSCAR</button>
					</td>
					<td width="30%" align="center"> <span>PLANTILLA</span> 
					
					
						<?php
$encabezado = '<select class="form-select mb-3" id="DEPARTAMENTO2WE" required onchange="load(1);">
                <option value="">SELECCIONA UNA OPCIÓN</option>';
$options = '';

// Colores de fondo (asegurar que hay suficientes)
$fondos = array("fff0df", "f4ffdf", "dfffed", "dffeff", "dfe8ff", "efdfff", "ffdffd", "ffdfe9", "e6dfff");
$num = 0;

$queryper = $conexion->desplegablesfiltro('pagoProveedores', '');

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
					<p><strong style="background:#ffb6c1"> ROSA:</strong> FORMAS DE PAGO DIFERENTES A (03 TRANSFERENCIA ELECTRONICA DE FONDOS)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong style="background:#fdfe87"> AMARILLO:</strong> PAGO A PROVEEDOR SIN XML </p>
				</tr>
			</table>
			<div class="datos_ajax2"> </div>
		
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
require "clases3/script.filtro.php";
?>
