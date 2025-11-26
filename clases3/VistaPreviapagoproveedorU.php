
<?php
/*
fecha sandor: 
fecha fatis : 04/04/2024
*/
?>

<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    }  
//select.php  CONTRASENA_DE1
$identioficador = isset($_POST["personal_id"])?$_POST["personal_id"]:'';
if($identioficador != '')
{
 $output = '';
	require "controladorPP.php";

//$conexion = NEW accesoclase();
$queryVISTAPREV = $pagoproveedores->Listado_pagoproveedor2($identioficador);

?>
<div id="actualizatabla">
<?php
   while($row = mysqli_fetch_array($queryVISTAPREV))
    {
		$row2xml = $pagoproveedores->busca_02XML($row['id']);
$SOLICITADO = "";$APROBADO = "";$PAGADO = "";$PAGADO = "";
    if($row['STATUS_DE_PAGO']=="SOLICITADO"){$SOLICITADO = "selected";}
elseif($row['STATUS_DE_PAGO']=="APROBADO"){$APROBADO = "selected";}
elseif($row['STATUS_DE_PAGO']=="PAGADO"){$PAGADO = "selected";}
elseif($row['STATUS_DE_PAGO']=="RECHAZADO"){$RECHAZADO = "selected";}

$STATUS_DE_PAGO = '<select required="" name="STATUS_DE_PAGO" disabled >
<option selected="">SELECCIONA UNA OPCION</option>
<option style="background:#d9f9fa" value="SOLICITADO" '.$SOLICITADO.'>SOLICITADO</option>
<option style="background:#e1f5de" value="APROBADO" '.$APROBADO.'>APROBADO</option>
<option style="background:#f5deee" value="PAGADO" '.$PAGADO.'>PAGADO</option>
<option style="background:#f5f4de" value="RECHAZADO" '.$RECHAZADO.'>RECHAZADO</option>
</select>';
$STATUS_DE_PAGO .= '<input type="hidden" name="STATUS_DE_PAGO" value="'.$row['STATUS_DE_PAGO'].'">';
		

	$queryVISTAPREV = $pagoproveedores->Listado_subefacturaDOCTOS($row['id']);		
	while($rowDOCTOS = mysqli_fetch_array($queryVISTAPREV))
	{



        if($rowDOCTOS["ADJUNTAR_FACTURA_PDF"]!=""){$ADJUNTAR_FACTURA_PDF .=  "<a target='_blank' href='includes/archivos/".$rowDOCTOS["ADJUNTAR_FACTURA_PDF"]."'>Visualizar!</a>"." <span > ".$rowDOCTOS['fechaingreso']."</span>".'<br/>'; 
		}	else{
			
			//$ADJUNTAR_FACTURA_PDF = "";
			
		}
        
        
        if($rowDOCTOS["ADJUNTAR_FACTURA_XML"]!=""){$ADJUNTAR_FACTURA_XML .=  "<a target='_blank' href='includes/archivos/".$rowDOCTOS["ADJUNTAR_FACTURA_XML"]."'>Visualizar!</a>"."  ".$rowDOCTOS['fechaingreso']."</span>".'<br/>'; 
		}	else{
			
			//$ADJUNTAR_FACTURA_XML = "";
			
		}

         
        if($rowDOCTOS["ADJUNTAR_COTIZACION"]!=""){$ADJUNTAR_COTIZACION .=  "<a target='_blank' href='includes/archivos/".$rowDOCTOS["ADJUNTAR_COTIZACION"]."'>Visualizar!</a>"." <span id='".$rowDOCTOS['id']."' class='view_dataSBborrar2' style='cursor:pointer;color:blue;'>Borrar!</span> <span > ".$rowDOCTOS['fechaingreso']."</span>".'<br/>'; 
		}	else{
			
			//$ADJUNTAR_COTIZACION = "";
			
		}
        
        if($rowDOCTOS["CONPROBANTE_TRANSFERENCIA"]!=""){$CONPROBANTE_TRANSFERENCIA =  "<a target='_blank' href='includes/archivos/".$rowDOCTOS["CONPROBANTE_TRANSFERENCIA"]."'>Visualizar!</a>"."  <span > ".$rowDOCTOS['fechaingreso']."</span>".'<br/>'; 
		}	else{
			
			//$CONPROBANTE_TRANSFERENCIA = "";
			
		}
        
        if($rowDOCTOS["FOTO_ESTADO_PROVEE"]!=""){$FOTO_ESTADO_PROVEE .=  "<a target='_blank' href='includes/archivos/".$rowDOCTOS["FOTO_ESTADO_PROVEE"]."'>Visualizar!</a>"."  <span > ".$rowDOCTOS['fechaingreso']."</span>".'<br/>'; 
		}	else{
			
			//$FOTO_ESTADO_PROVEE = "";
			
		}
        
        if($rowDOCTOS["COMPLEMENTOS_PAGO_PDF"]!=""){$COMPLEMENTOS_PAGO_PDF .=  "<a target='_blank' href='includes/archivos/".$rowDOCTOS["COMPLEMENTOS_PAGO_PDF"]."'>Visualizar!</a>"."  <span > ".$rowDOCTOS['fechaingreso']."</span>".'<br/>'; 
		}	else{
			
			//$COMPLEMENTOS_PAGO_PDF = "";
			
		}
        

        if($rowDOCTOS["COMPLEMENTOS_PAGO_XML"]!=""){$COMPLEMENTOS_PAGO_XML .=  "<a target='_blank' href='includes/archivos/".$rowDOCTOS["COMPLEMENTOS_PAGO_XML"]."'>Visualizar!</a>"."  <span > ".$rowDOCTOS['fechaingreso']."</span>".'<br/>'; 
		}	else{
			
			//$COMPLEMENTOS_PAGO_XML = "";
			
		}

        if($rowDOCTOS["CANCELACIONES_PDF"]!=""){$CANCELACIONES_PDF .=  "<a target='_blank' href='includes/archivos/".$rowDOCTOS["CANCELACIONES_PDF"]."'>Visualizar!</a>"."  <span > ".$rowDOCTOS['fechaingreso']."</span>".'<br/>'; 
		}	else{
			
			//$CANCELACIONES_PDF = "";
			
		}

        if($rowDOCTOS["CANCELACIONES_XML"]!=""){$CANCELACIONES_XML .=  "<a target='_blank' href='includes/archivos/".$rowDOCTOS["CANCELACIONES_XML"]."'>Visualizar!</a>"." <span > ".$rowDOCTOS['fechaingreso']."</span>".'<br/>'; 
		}	else{
			
			//$CANCELACIONES_XML = "";
			
		}

        
        if($rowDOCTOS["ADJUNTAR_FACTURA_DE_COMISION_PDF"]!=""){$ADJUNTAR_FACTURA_DE_COMISION_PDF .=  "<a target='_blank' href='includes/archivos/".$rowDOCTOS["ADJUNTAR_FACTURA_DE_COMISION_PDF"]."'>Visualizar!</a>"." <span > ".$rowDOCTOS['fechaingreso']."</span>".'<br/>'; 
		}	else{
			
			//$ADJUNTAR_FACTURA_DE_COMISION_PDF = "";
			
		}

        if($rowDOCTOS["ADJUNTAR_ARCHIVO_1"]!=""){$ADJUNTAR_ARCHIVO_1 .=  "<a target='_blank' href='includes/archivos/".$rowDOCTOS["ADJUNTAR_ARCHIVO_1"]."'>Visualizar!</a>"." <span > ".$rowDOCTOS['fechaingreso']."</span>".'<br/>'; 
		}	else{
			
			//$ADJUNTAR_ARCHIVO_1 = "";
			
		}
        
        if($rowDOCTOS["CALCULO_DE_COMISION"]!=""){$CALCULO_DE_COMISION .=  "<a target='_blank' href='includes/archivos/".$rowDOCTOS["CALCULO_DE_COMISION"]."'>Visualizar!</a>"." <span > ".$rowDOCTOS['fechaingreso']."</span>".'<br/>'; 
		}	else{
			
			//$CALCULO_DE_COMISION = "";
			
		}

        if($rowDOCTOS["COMPROBANTE_DE_DEVOLUCION"]!=""){$COMPROBANTE_DE_DEVOLUCION .=  "<a target='_blank' href='includes/archivos/".$rowDOCTOS["COMPROBANTE_DE_DEVOLUCION"]."'>Visualizar!</a>"." <span > ".$rowDOCTOS['fechaingreso']."</span>".'<br/>'; 
		}	else{
			
			//$COMPROBANTE_DE_DEVOLUCION = "";
			
		}

        if($rowDOCTOS["NOTA_DE_CREDITO_COMPRA"]!=""){$NOTA_DE_CREDITO_COMPRA .=  "<a target='_blank' href='includes/archivos/".$rowDOCTOS["NOTA_DE_CREDITO_COMPRA"]."'>Visualizar!</a>"."  <span > ".$rowDOCTOS['fechaingreso']."</span>".'<br/>'; 
		}	else{
			
			//$NOTA_DE_CREDITO_COMPRA = "";
			
		}

      
        if($rowDOCTOS["ADJUNTAR_FACTURA_DE_COMISION_XML"]!=""){$ADJUNTAR_FACTURA_DE_COMISION_XML .=  "<a target='_blank' href='includes/archivos/".$rowDOCTOS["ADJUNTAR_FACTURA_DE_COMISION_XML"]."'>Visualizar!</a>"."  <span > ".$rowDOCTOS['fechaingreso']."</span>".'<br/>'; 
		}	else{
			
			//$ADJUNTAR_FACTURA_DE_COMISION_XML = "";
			
		}

}


?>
</div>
<?php


 $output .= '<div id="respuestaser"></div><form  id="ListadoPAGOPROVEEform"> 
      <div class="table-responsive">  
           <table class="table table-bordered">';

$campos_xml = '';

if($row2xml["Version"]=='no' or $row2xml["Version"]==''){

$campos_xml = '

<!--aqui empieza la lectura BD a XML-->
<!--aqui empieza la lectura BD a XML-->
<!--aqui empieza la lectura BD a XML-->
<!--aqui empieza la lectura BD a XML-->
<!--aqui empieza la lectura BD a XML-->

<tr style="background: #fbf696">


<td width="30%"><label>NOMBRE RECEPTOR</label></td>
<td width="70%"><input type="text"readonly=»readonly»  style="background:#d7bde2" name="nombreR" value="'.$row2xml["nombreR"].'"></td>
</tr>

<tr style="background: #fbf696">


<td width="30%"><label>RFC RECEPTOR</label></td>
<td width="70%"><input type="text" readonly=»readonly»  style="background:#d7bde2" name="rfcR" value="'.$row2xml["rfcR"].'"></td>
</tr>

<tr style="background: #fbf696">

<td width="30%"><label>REGÍMEN FISCAL</label></td>
<td width="70%"><input type="text" readonly=»readonly»  style="background:#d7bde2" name="regimenE" value="'.$row2xml["regimenE"].'"></td>
</tr>

<tr style="background: #fbf696">

<td width="30%"><label>UUID</label></td>
<td width="70%"><input type="text" readonly=»readonly»  style="background:#d7bde2" name="UUID" value="'.$row2xml["UUID"].'"></td>
</tr>

<tr style="background: #fbf696">

<td width="30%"><label>FOLIO</label></td>
<td width="70%"><input type="text"  readonly=»readonly»  style="background:#d7bde2"name="folio" value="'.$row2xml["folio"].'"></td>
</tr>

<tr style="background: #fbf696">

<td width="30%"><label>SERIE</label></td>
<td width="70%"><input type="text" readonly=»readonly»  style="background:#d7bde2" name="serie" value="'.$row2xml["serie"].'"></td>
</tr>

<tr style="background: #fbf696">

<td width="30%"><label>CLAVE DE UNIDAD</label></td>
<td width="70%"><input type="text" readonly=»readonly»  style="background:#d7bde2" name="ClaveUnidadConcepto" value="'.$row2xml["ClaveUnidadConcepto"].'"></td>
</tr>

<tr style="background: #fbf696">

<td width="30%"><label>CANTIDAD</label></td>
<td width="70%"><input type="text" readonly=»readonly»  style="background:#d7bde2" name="CantidadConcepto" value="'.$row2xml["CantidadConcepto"].'"></td>
</tr>

<tr style="background: #fbf696">

<td width="30%"><label>CLAVE DE PRODUCTO O SERVICIO</label></td>
<td width="70%"><input type="text" readonly=»readonly»  style="background:#d7bde2" name="ClaveProdServConcepto" value="'.$row2xml["ClaveProdServConcepto"].'"></td>
</tr>

<tr style="background: #fbf696">

<td width="30%"><label>DESCRIPCIÓN</label></td>
<td width="70%"><input type="text" readonly=»readonly»  style="background:#d7bde2" name="DescripcionConcepto" value="'.$row2xml["DescripcionConcepto"].'"></td>
</tr>

<tr style="background: #fbf696">


<td width="30%"><label>MONEDA</label></td>
<td width="70%"><input type="text" readonly=»readonly»  style="background:#d7bde2" name="Moneda" value="'.$row2xml["Moneda"].'"></td>
</tr>

<tr style="background: #fbf696">

<td width="30%"><label>TIPO DE CAMBIO</label></td>
<td width="70%"><input type="text" readonly=»readonly»  style="background:#d7bde2" name="TipoCambio" value="'.$row2xml["TipoCambio"].'"></td>
</tr>

<tr style="background: #fbf696">

<td width="30%"><label>USO DE CFDI</label></td>
<td width="70%"><input type="text" readonly=»readonly»  style="background:#d7bde2" name="UsoCFDI" value="'.$row2xml["UsoCFDI"].'"></td>
</tr>

<tr style="background: #fbf696">

<td width="30%"><label>METODO DE PAGO</label></td>
<td width="70%"><input type="text" readonly=»readonly»  style="background:#d7bde2" name="metodoDePago" value="'.$row2xml["metodoDePago"].'"></td>
</tr>

<tr style="background: #fbf696">

<td width="30%"><label>CONDICIONES DE PAGO</label></td>
<td width="70%"><input type="text" readonly=»readonly»  style="background:#d7bde2" name="condicionesDePago" value="'.$row2xml["condicionesDePago"].'"></td>
</tr>

<tr style="background: #fbf696">

<td width="30%"><label>TIPO DE COMPROBANTE</label></td>
<td width="70%"><input type="text" readonly=»readonly»  style="background:#d7bde2" name="tipoDeComprobante" value="'.$row2xml["tipoDeComprobante"].'"></td>
</tr>

<tr style="background: #fbf696">

<td width="30%"><label>VERSIÓN</label></td>
<td width="70%"><input type="text" readonly=»readonly»  style="background:#d7bde2" name="Version" value="'.$row2xml["Version"].'"></td>
</tr>
<input type="hidden" name="actualiza" value="true">

<tr style="background: #fbf696">

<td width="30%"><label>FECHA DE TIMBRADO</label></td>
<td width="70%"><input type="date" readonly=»readonly»  style="background:#d7bde2" name="fechaTimbrado" value="'.$row2xml["fechaTimbrado"].'"></td>
</tr>

<tr style="background: #fbf696">

<td width="30%"><label>SUBTOTAL</label></td>
<td width="70%"><input type="text" readonly=»readonly»  style="background:#d7bde2" name="subTotal" value="'.$row2xml["subTotal"].'"></td>
</tr>

<tr style="background: #fbf696">

<td width="30%"><label>SERVICIO, PROPINA,ISH Y SANAMIENTO</label></td>
<td width="70%"><input type="text"readonly=»readonly»  style="background:#d7bde2"  name="Propina" value="'.$row2xml["Propina"].'"></td>
</tr>

<tr style="background: #fbf696">

<td width="30%"><label>DESCUENTO</label></td>
<td width="70%"><input type="text" readonly=»readonly»  style="background:#d7bde2" name="DESCUENTO" value="'.$row2xml["DESCUENTO"].'"></td>
</tr>

<tr style="background: #fbf696">

<td width="30%"><label>TOTAL DE IMPUESTOS TRANSLADADOS</label></td>
<td width="70%"><input type="text" readonly=»readonly»  style="background:#d7bde2" name="TImpuestosTrasladados" value="'.$row2xml["TImpuestosTrasladados"].'"></td>
</tr>
 <tr style="background: #fbf696">

<td width="30%"><label>TOTAL DE IMPUESTOS RETENIDOS</label></td>
<td width="70%"><input type="text" readonly=»readonly»  style="background:#d7bde2" name="TImpuestosRetenidos" value="'.$row2xml["TImpuestosRetenidos"].'"></td>
</tr>

<tr style="background: #fbf696">

<td width="30%"><label>TUA</label></td>
<td width="70%"><input type="text" readonly=»readonly»  style="background:#d7bde2" name="TUA" value="'.$row2xml["TUA"].'"></td>
</tr>
<tr style="background: #fbf696">

<td width="30%"><label>TUA TOTAL CARGOS:</label></td>
<td width="70%"><input type="text" readonly=»readonly»  style="background:#d7bde2" name="TuaTotalCargos" value="'.$row2xml["TuaTotalCargos"].'"></td>
</tr> 

<tr style="background: #fbf696">

<td width="30%"><label>TOTAL</label></td>
<td width="70%"><input type="text" readonly=»readonly»  style="background:#d7bde2" name="totalf" value="'.$row2xml["totalf"].'"></td>
</tr>







<!--aqui termina la lectura BD a XML-->
<!--aqui termina la lectura BD a XML-->
<!--aqui termina la lectura BD a XML-->
<!--aqui termina la lectura BD a XML-->
<!--aqui termina la lectura BD a XML-->

'; 

	}else{
        $campos_xml = '';
        }


    $disableFactura = in_array($row["VIATICOSOPRO"], array(
        "PAGO A PROVEEDOR CON DOS O MAS FACTURAS",
        "VIATICOS",
        "REEMBOLSO"
    ));
    $facturaInputAttributes = $disableFactura ? ' disabled="disabled"' : '';
    $facturaDropZoneAttributes = $disableFactura
        ? ' style="width:300px;pointer-events:none;opacity:0.6;"'
        : ' style="width:300px;"';

    $fechaDePagoBloqueada = '';
    $fechaProgramacionColor = '#39FF14';
    if (in_array($row['STATUS_DE_PAGO'], array('APROBADO', 'PAGADO'))) {
        $fechaDePagoBloqueada = ' readonly="readonly" style="background:#d7bde2"';
        $fechaProgramacionColor = '#dfd9f3';
    }


     $output .= '




<tr>
  <td width="30%" style="background:#dfd9f3"><label>FACTURA FORMATO XML</label></td>
  <td width="70%">
    <div id="drop_file_zone" style="width:300px; background-color:#d7bde2;"> <!-- Fondo gris -->
      <p style="color:#999;">Suelta aquí o busca tu archivo</p> <!-- Texto deshabilitado -->
      <p>
        <!-- Input con readonly y sin eventos -->
        <input 
          class="form-control form-control-sm" 
          id="ADJUNTAR_FACTURA_XML" 
          type="text" 
          readonly 
          style="width:250px; background-color:#e9ecef;" 
          value="'.$row["ADJUNTAR_FACTURA_XML"] .'" 
          required 
        />
      </p>
      <!-- Archivo oculto y deshabilitado -->
      <input type="file" name="ADJUNTAR_FACTURA_XML" id="nono" style="display:none;" disabled />
    </div>
    <div id="3ADJUNTAR_FACTURA_XML">
      '.$ADJUNTAR_FACTURA_XML.'
    </div>
  </td>
</tr>


<tr>
  <td width="30%" style="background:#dfd9f3"><label> FACTURA FORMATO PDF</label></td>
  <td width="70%">
    <div id="drop_file_zone" style="width:300px; background-color:#d7bde2;"> <!-- Fondo gris -->
      <p style="color:#999;">Suelta aquí o busca tu archivo</p> <!-- Texto deshabilitado -->
      <p>
        <!-- Input con readonly y sin eventos -->
        <input 
          class="form-control form-control-sm" 
          id="ADJUNTAR_FACTURA_PDF" 
          type="text" 
          readonly 
          style="width:250px; background-color:#e9ecef;" 
          value="'.$row["ADJUNTAR_FACTURA_PDF"] .'" 
          required 
        />
      </p>
      <!-- Archivo oculto y deshabilitado -->
      <input type="file" name="ADJUNTAR_FACTURA_PDF" id="nono" style="display:none;" disabled />
    </div>
    <div id="3ADJUNTAR_FACTURA_PDF">
      '.$ADJUNTAR_FACTURA_PDF.'
    </div>
  </td>
</tr>
 
  

<tr>
<td width="30%" style="background:#dfd9f3"><label>NÚMERO DE SOLICITUD</label></td>
<td width="70%"><input type="text" readonly=»readonly»  style="background:#d7bde2" name="NUMERO_CONSECUTIVO_PROVEE" value="'.$row["NUMERO_CONSECUTIVO_PROVEE"].'"></td>
</tr>
<tr>
    <td width="30%" style="background:#dfd9f3"><label>PAGO A PROVEEDOR, VIATICO, REEMBOLSO O<br> PAGO A PROVEEDOR CON DOS O MAS FACTURAS:</label></td>   
	
	
    <td width="70%" >
       <input type="text" readonly=»readonly»  style="background:#d7bde2" name="VIATICOSOPRO" value="'.$row["VIATICOSOPRO"].'"></td>

</tr>

 
<tr>


<td width="30%" style="background:#dfd9f3"><label>NOMBRE COMERCIAL</label></td>
<td width="70%"><input type="text" readonly=»readonly» style="background:#d7bde2" name="NOMBRE_COMERCIAL" value="'.$row["NOMBRE_COMERCIAL"].'"></td>
</tr> 
<tr>

<td width="30%" style="background:#dfd9f3"><label>RAZÓN SOCIAL</label></td>
<td width="70%"><input type="text" readonly=»readonly»  style="background:#d7bde2"   name="RAZON_SOCIAL" value="'.$row["RAZON_SOCIAL"].'"></td>
</tr> 
<tr>
 
<td width="30%" style="background:#dfd9f3"><label>RFC DEL PROVEEDOR</label></td>
<td width="70%"><input type="text" readonly=»readonly»  style="background:#d7bde2"   name="RFC_PROVEEDOR" value="'.$row["RFC_PROVEEDOR"].'"></td>
</tr> 
<tr>

<td width="30%" style="background:#dfd9f3"><label>NÚMERO  DE EVENTO </label></td>
<td width="70%"><input type="text" readonly=»readonly»  style="background:#d7bde2"  name="NUMERO_EVENTO" value="'.$row["NUMERO_EVENTO"].'"></td>
</tr> 
<tr>

 
<td width="30%" style="background:#dfd9f3"><label>NOMBRE DEL EVENTO</label></td>
<td width="70%"><input type="text" readonly=»readonly»  style="background:#d7bde2"   name="NOMBRE_EVENTO" value="'.$row["NOMBRE_EVENTO"].'"></td>  
</tr> 
<tr>
 
<td width="30%" style="background:#dfd9f3"><label>MOTIVO DEL GASTO</label></td>
<td width="70%"><input type="text" readonly=»readonly»  style="background:#d7bde2"  name="MOTIVO_GASTO" value="'.$row["MOTIVO_GASTO"].'"></td>
</tr> 
<tr>
 
<td width="30%" style="background:#dfd9f3"><label>CONCEPTO</label></td>
<td width="70%"><input type="text" readonly=»readonly»  style="background:#d7bde2"   name="CONCEPTO_PROVEE" value="'.$row["CONCEPTO_PROVEE"].'"></td>
</tr> 
<tr>

<td width="30%" style="background:#dfd9f3"><label>MONTO TOTAL DE LA COTIZACIÓN O DEL ADEUDO</label></td>
<td width="70%"><input type="text" readonly=»readonly»  style="background:#d7bde2" name="MONTO_TOTAL_COTIZACION_ADEUDO" value="'.$row["MONTO_TOTAL_COTIZACION_ADEUDO"].'"></td>
</tr> 
<tr>

<td width="30%" style="background:#dfd9f3" ><label>SUB TOTAL:</label></td> 
<td width="70%"><input type="text" readonly=»readonly»  style="background:#d7bde2" name="MONTO_FACTURA" id="montoTotalEvento" value="'.$row["MONTO_FACTURA"].'"></td>
</tr>

 
<tr>
<td width="30%" style="background:#dfd9f3"><label>IVA:</label></td>
<td width="70%"><input type="text" readonly=»readonly»  style="background:#d7bde2" name="IVA" id="montoTotalAvion" value="'.$row["IVA"].'"></td>
</tr> 

<tr >
<td width="30%" style="background:#dfd9f3"><label>IMPUESTOS RETENIDOS  IVA:</label></td>
<td width="70%"><input type="text" readonly=»readonly»  style="background:#d7bde2" name="TImpuestosRetenidosIVA"  value="'.$row["TImpuestosRetenidosIVA"].'"></td>
</tr> 

<tr>
<td width="30%" style="background:#dfd9f3"><label>IMPUESTOS RETENIDOS  ISR:</label></td>
<td width="70%"><input type="text" readonly=»readonly»  style="background:#d7bde2" name="TImpuestosRetenidosISR"  value="'.$row["TImpuestosRetenidosISR"].'"></td>
</tr> 


<tr>
<td width="30%" style="background:#dfd9f3"><label>MONTO DE LA PROPINA O SERVICIO NO INCLUIDO EN LA FACTURA</label></td>
<td width="70%"><input type="text" readonly=»readonly»  style="background:#d7bde2" name="MONTO_PROPINA" id="montoTotalpropina" value="'.$row["MONTO_PROPINA"].'"></td>
</tr> 
<tr>

<td width="30%" style="background:#dfd9f3"><label>IMPUESTO SOBRE HOSPEDAJE MÁS EL IMPUESTO DE SANEAMIENTO</label></td>
<td width="70%"><input type="text" readonly=»readonly»  style="background:#d7bde2" name="IMPUESTO_HOSPEDAJE" id="montoTotalhospedaje" value="'.$row["IMPUESTO_HOSPEDAJE"].'"></td>
</tr>

<tr>
<td width="30%" style="background:#dfd9f3"><label>DESCUENTO:</label></td>
<td width="70%"><input type="text" readonly=»readonly»  style="background:#d7bde2" name="descuentos"  value="'.$row["descuentos"].'"></td>
</tr> 


<tr >
<td width="30%" style="background:#dfd9f3"><label>TOTAL</label></td>
<td width="70%"><input type=»text» readonly=»readonly» style="background:#decaf1" name="MONTO_DEPOSITAR" id="montoTotalEventoResultado" value="'.$row["MONTO_DEPOSITAR"].'"></td>
</tr>



<tr >
<td width="30%" style="background:#dfd9f3"><label>TIPO DE CAMBIO</label></td>
<td width="70%"><input type=»text» readonly=»readonly» style="background:#decaf1" name="TIPO_CAMBIOP" value="'.$row["TIPO_CAMBIOP"].'"></td>
</tr>

<tr >
<td width="30%"  style="background:#dfd9f3"><label>TOTAL DE LA CONVERSIÓN </label></td>
<td width="70%"><input type=»text» readonly=»readonly» style="background:#decaf1" name="TOTAL_ENPESOS" value="'.$row["TOTAL_ENPESOS"].'"></td>
</tr>


<tr>
    <td width="30%" style="background:#dfd9f3"><label>FORMA DE PAGO:</label></td>
    <td width="70%" class="form-control"  >
        <select name="PFORMADE_PAGO" style="background:#daddf5" disabled>
            <option style="background:#f2b4f5" value="">SELECCIONA UNA OPCIÓN</option>
            <option style="background:#f2b4f5" value="03" '.($row["PFORMADE_PAGO"] == "03" ? "selected" : "").'>03 TRANSFERENCIA ELECTRÓNICA</option>
            <option style="background:#ddf5da" value="01" '.($row["PFORMADE_PAGO"] == "01" ? "selected" : "").'>01 EFECTIVO</option>
            <option style="background:#fceade" value="02" '.($row["PFORMADE_PAGO"] == "02" ? "selected" : "").'>02 CHEQUE NOMINATIVO</option>
            <option style="background:#dee6fc" value="04" '.($row["PFORMADE_PAGO"] == "04" ? "selected" : "").'>04 TARJETA DE CRÉDITO</option>
            <option style="background:#f6fcde" value="05" '.($row["PFORMADE_PAGO"] == "05" ? "selected" : "").'>05 MONEDERO ELECTRÓNICO</option>
            <option style="background:#dee2fc" value="06" '.($row["PFORMADE_PAGO"] == "06" ? "selected" : "").'>06 DINERO ELECTRÓNICO</option>
            <option style="background:#f9e5fa" value="08" '.($row["PFORMADE_PAGO"] == "08" ? "selected" : "").'>08 VALES DE DESPENSA</option>
            <option style="background:#eefcde" value="28" '.($row["PFORMADE_PAGO"] == "28" ? "selected" : "").'>28 TARJETA DE DÉBITO</option>
            <option style="background:#fcfbde" value="29" '.($row["PFORMADE_PAGO"] == "29" ? "selected" : "").'>29 TARJETA DE SERVICIO</option>
            <option style="background:#f9e5fa" value="99" '.($row["PFORMADE_PAGO"] == "99" ? "selected" : "").'>99 OTRO</option>
        </select>
        <input type="hidden" name="PFORMADE_PAGO" value="'.$row["PFORMADE_PAGO"].'">
    </td>
</tr>

<tr>
<td width="30%" width="30%" style="background:#dfd9f3"><label>MONTO DEPOSITADO</label></td>
<td width="70%"><input type=»text» readonly=»readonly» style="background:#decaf1" name="MONTO_DEPOSITADO" value="'.$row["MONTO_DEPOSITADO"].'"></td>
</tr>


	<tr>
	
	<td width="30%"  style="background:#dfd9f3"><label>TIPO DE MONEDA O DIVISA:</label></td>
    <td width="70%" >
        <select name="TIPO_DE_MONEDA" style="background:#daddf5" readonly=»readonly» style="background:#decaf1">
		
		
            <option style="background:#f2b4f5" value="SELECCIONA UNA OPCIÓN">SELECCIONA UNA OPCIÓN</option> 
			
			
            <option style="background:#a3e4d7" value="MXN" '.($row["TIPO_DE_MONEDA"] == "MXN" ? "selected" : "").'>MXN (Peso mexicano) </option>
			
            <option style="background:#c9e8e8" value="USD" '.($row["TIPO_DE_MONEDA"] == "USD" ? "selected" : "").'>USD (Dolar) </option>			

             <option style="background:#e8f6f3" value="EUR" '.($row["TIPO_DE_MONEDA"] == "EUR" ? "selected" : "").'>EUR (Euro) </option>     

             <option style="background:#fdf2e9" value="GBP" '.($row["TIPO_DE_MONEDA"] == "GBP" ? "selected" : "").'>GBP (Libra esterlina)</option> 
	

             <option style="background:#eaeded" value="CHF" '.($row["TIPO_DE_MONEDA"] == "CHF" ? "selected" : "").'>CHF (Franco suizo)</option> 

             <option style="background:#fdebd0" value="CNY" '.($row["TIPO_DE_MONEDA"] == "CNY" ? "selected" : "").'>CNY (Yuan)</option> 
			 
             <option style="background:#ebdef0" value="JPY" '.($row["TIPO_DE_MONEDA"] == "JPY" ? "selected" : "").'>JPY (Yen japonés)</option>

             <option style="background:#fef5e7" value="HKD" '.($row["TIPO_DE_MONEDA"] == "HKD" ? "selected" : "").'>HKD (Dólar hongkonés)</option> 
			 
             <option style="background:#ebedef" value="CAD" '.($row["TIPO_DE_MONEDA"] == "CAD" ? "selected" : "").'>CAD (Dólar canadiense)</option> 	


             <option style="background:#fbeee6" value="AUD" '.($row["TIPO_DE_MONEDA"] == "AUD" ? "selected" : "").'>AUD (Dólar australiano)</option>
			 			 
             <option style="background:#f2b4f5" value="BRL" '.($row["TIPO_DE_MONEDA"] == "BRL" ? "selected" : "").'>BRL (Real brasileño)</option>
			 			 
             <option style="background:#e8f6f3" value="RUB" '.($row["TIPO_DE_MONEDA"] == "RUB" ? "selected" : "").'>RUB  (Rublo ruso)</option>			 
        </select>
    </td>
</tr> 



<tr>

<td width="30%" width="30%" style="background:'.$fechaProgramacionColor.'"><label>FECHA DE PROGRAMACIÓN DEL PAGO</label></td>
<td width="70%"><input type="date"  name="FECHA_DE_PAGO" value="'.$row["FECHA_DE_PAGO"].'"'.$fechaDePagoBloqueada.'></td>
</tr> 
<tr>

<td width="30%" width="30%" style="background:#dfd9f3"><label>FECHA EFECTIVA DE PAGO:</label></td>
<td width="70%"><input type="date" readonly=»readonly» style="background:#decaf1" name="FECHA_A_DEPOSITAR" value="'.$row["FECHA_A_DEPOSITAR"].'"></td>
</tr> 
<tr>

<td width="30%" style="background:#dfd9f3"><label>STATUS DE PAGO</label></td>
<td width="70%"  class="form-control">'.$STATUS_DE_PAGO .'</td>
</tr> 
<tr>



<tr>
  <td width="30%" style="background:#dfd9f3"><label>ADJUNTAR COTIZACIÓN O REPORTE</label></td>
  <td width="70%">
    <div id="drop_file_zone" style="width:300px; background-color:#d7bde2;"> <!-- Fondo gris -->
      <p style="color:#999;">Suelta aquí o busca tu archivo</p> <!-- Texto deshabilitado -->
      <p>
        <!-- Input con readonly y sin eventos -->
        <input 
          class="form-control form-control-sm" 
          id="ADJUNTAR_COTIZACION" 
          type="text" 
          readonly 
          style="width:250px; background-color:#e9ecef;" 
          value="'.$row["ADJUNTAR_COTIZACION"] .'" 
          required 
        />
      </p>
      <!-- Archivo oculto y deshabilitado -->
      <input type="file" name="ADJUNTAR_COTIZACION" id="nono" style="display:none;" disabled />
    </div>
    <div id="3ADJUNTAR_COTIZACION">
      '.$ADJUNTAR_COTIZACION.'
    </div>
  </td>
</tr>

<tr>
<td width="30%" style="background:#dfd9f3"><label>ACTIVO FIJO</label></td>
<td width="70%"><input type="text" readonly=»readonly»  style="background:#d7bde2"name="ACTIVO_FIJO"  value="'.$row["ACTIVO_FIJO"].'"></td>
</tr>



<tr>
<td width="30%" style="background:#dfd9f3"><label>GASTO FIJO</label></td>
<td width="70%"><input type="text" readonly=»readonly»  style="background:#d7bde2"   name="GASTO_FIJO"  value="'.$row["GASTO_FIJO"].'"></td>
</tr>



<tr>
<td width="30%" style="background:#dfd9f3"><label>PAGAR CADA:</label></td>
<td width="70%"><input type="text" readonly=»readonly»  style="background:#d7bde2"   name="PAGAR_CADA"  value="'.$row["PAGAR_CADA"].'"></td>
</tr>

<tr>
<td width="30%" style="background:#dfd9f3"><label>FECHA DE PROGRAMACIÓN DE PAGO:</label></td>
<td width="70%"><input type="text" readonly=»readonly»  style="background:#d7bde2"  name="FECHA_PPAGO"  value="'.$row["FECHA_PPAGO"].'"></td>
</tr>

              
<tr>
<td width="30%" style="background:#dfd9f3"><label>FECHA DE TERMINACIÓN DE LA PROGRAMACIÓN:</label></td>
<td width="70%"><input type="text" readonly=»readonly»  style="background:#d7bde2"   name="FECHA_TPROGRAPAGO"  value="'.$row["FECHA_TPROGRAPAGO"].'"></td>
</tr>



<tr>
<td width="30%" style="background:#dfd9f3"><label>NÚMERO DE EVENTO (FIJO) PARA PROGRAMACIÓN:</label></td>
<td width="70%"><input type="text" readonly=»readonly»  style="background:#d7bde2"  name="NUMERO_EVENTOFIJO"  value="'.$row["NUMERO_EVENTOFIJO"].'"></td>
</tr>

<tr>
<td width="30%" style="background:#dfd9f3"><label>CLASIFICACIÓN GENERAL:</label></td>
<td width="70%"><input type="text" readonly=»readonly»  style="background:#d7bde2"   name="CLASI_GENERAL"  value="'.$row["CLASI_GENERAL"].'"></td>
</tr>

<tr>
<td width="30%" style="background:#dfd9f3"><label> SUB CLASIFICACIÓN GENERAL:</label></td>
<td width="70%"><input type="text" readonly=»readonly»  style="background:#d7bde2"  name="SUB_GENERAL"  value="'.$row["SUB_GENERAL"].'"></td>
</tr>







<tr>

<td width="30%" style="background:#dfd9f3"><label>INSTITUCIÓN BANCARIA</label></td>
<td width="70%"><input type="text" readonly=»readonly»  style="background:#d7bde2" name="BANCO_ORIGEN" value="'.$row["BANCO_ORIGEN"].'"></td>
</tr>





<tr>

<td width="30%" style="background:#dfd9f3"><label>PLACAS DEL VEHICULO</label></td>
<td width="70%"><input type="text" readonly=»readonly»  style="background:#d7bde2" name="PLACAS_VEHICULO" value="'.$row["PLACAS_VEHICULO"].'"></td>
</tr>
<tr>


<tr>
  <td width="30%" style="background:#dfd9f3"><label>COMPROBANTE DE TRANSFERENCIA AL PROVEEDOR</label></td>
  <td width="70%">
    <div id="drop_file_zone" style="width:300px; background-color:#d7bde2;"> <!-- Fondo gris -->
      <p style="color:#999;">Suelta aquí o busca tu archivo</p> <!-- Texto deshabilitado -->
      <p>
        <!-- Input con readonly y sin eventos -->
        <input 
          class="form-control form-control-sm" 
          id="CONPROBANTE_TRANSFERENCIA" 
          type="text" 
          readonly 
          style="width:250px; background-color:#e9ecef;" 
          value="'.$row["CONPROBANTE_TRANSFERENCIA"] .'" 
          required 
        />
      </p>
      <!-- Archivo oculto y deshabilitado -->
      <input type="file" name="CONPROBANTE_TRANSFERENCIA" id="nono" style="display:none;" disabled />
    </div>
    <div id="3CONPROBANTE_TRANSFERENCIA">
      '.$CONPROBANTE_TRANSFERENCIA.'
    </div>
  </td>
</tr>





<tr>


<td width="30%" style="font-weight:bold;background:#39FF14" ><label>COMPLEMENTOS DE PAGO  (FORMATO XML)</label></td>
<td width="70%">	<div id="drop_file_zone" ondrop="upload_file2(event,\'COMPLEMENTOS_PAGO_XML\')" ondragover="return false" style="width:300px;">
<p>Suelta aquí o busca tu archivo</p>
<p><input class="form-control form-control-sm" id="COMPLEMENTOS_PAGO_XML" type="text" onkeydown="return false" onclick="file_explorer2(\'COMPLEMENTOS_PAGO_XML\');" style="width:250px;" VALUE="'.$row["COMPLEMENTOS_PAGO_XML"] .' " required /></p>
<input type="file" name="COMPLEMENTOS_PAGO_XML" id="nono"/>
<div id="3COMPLEMENTOS_PAGO_XML">
'.$COMPLEMENTOS_PAGO_XML.'
</tr> 
<tr>
<td width="30%" style="font-weight:bold;background:#39FF14"  ><label>COMPLEMENTOS DE PAGO  (FORMATO PDF)</label></td>
<td width="70%">	<div id="drop_file_zone" ondrop="upload_file2(event,\'COMPLEMENTOS_PAGO_PDF\')" ondragover="return false" style="width:300px;">
<p>Suelta aquí o busca tu archivo</p>
<p><input class="form-control form-control-sm" id="COMPLEMENTOS_PAGO_PDF" type="text" onkeydown="return false" onclick="file_explorer2(\'COMPLEMENTOS_PAGO_PDF\');" style="width:250px;" VALUE="'.$row["COMPLEMENTOS_PAGO_PDF"] .' " required /></p>
<input type="file" name="COMPLEMENTOS_PAGO_PDF" id="nono"/>
<div id="3COMPLEMENTOS_PAGO_PDF">
'.$COMPLEMENTOS_PAGO_PDF.'
</tr> 

<tr>
  <td width="30%" style="background:#dfd9f3"><label>ADJUNTAR CANCELACIONES (FORMATO PDF)</label></td>
  <td width="70%">
    <div id="drop_file_zone" style="width:300px; background-color:#d7bde2;"> <!-- Fondo gris -->
      <p style="color:#999;">Suelta aquí o busca tu archivo</p> <!-- Texto deshabilitado -->
      <p>
        <!-- Input con readonly y sin eventos -->
        <input 
          class="form-control form-control-sm" 
          id="CANCELACIONES_PDF" 
          type="text" 
          readonly 
          style="width:250px; background-color:#e9ecef;" 
          value="'.$row["CANCELACIONES_PDF"] .'" 
          required 
        />
      </p>
      <!-- Archivo oculto y deshabilitado -->
      <input type="file" name="CANCELACIONES_PDF" id="nono" style="display:none;" disabled />
    </div>
    <div id="3CANCELACIONES_PDF">
      '.$CANCELACIONES_PDF.'
    </div>
  </td>
</tr>



<tr>
  <td width="30%" style="background:#dfd9f3"><label>ADJUNTAR CANCELACIONES (FORMATO XML)</label></td>
  <td width="70%">
    <div id="drop_file_zone" style="width:300px; background-color:#d7bde2;"> <!-- Fondo gris -->
      <p style="color:#999;">Suelta aquí o busca tu archivo</p> <!-- Texto deshabilitado -->
      <p>
        <!-- Input con readonly y sin eventos -->
        <input 
          class="form-control form-control-sm" 
          id="CANCELACIONES_XML" 
          type="text" 
          readonly 
          style="width:250px; background-color:#e9ecef;" 
          value="'.$row["CANCELACIONES_XML"] .'" 
          required 
        />
      </p>
      <!-- Archivo oculto y deshabilitado -->
      <input type="file" name="CANCELACIONES_XML" id="nono" style="display:none;" disabled />
    </div>
    <div id="3CANCELACIONES_XML">
      '.$CANCELACIONES_XML.'
    </div>
  </td>
</tr> 

<tr>

<td width="30%" style="background:#dfd9f3"><label>ADJUNTAR FACTURA DE COMISIÓN (FORMATO PDF)</label></td>

  <td width="70%">
    <div id="drop_file_zone" style="width:300px; background-color:#d7bde2;"> <!-- Fondo gris -->
      <p style="color:#999;">Suelta aquí o busca tu archivo</p> <!-- Texto deshabilitado -->
      <p>
        <!-- Input con readonly y sin eventos -->
        <input 
          class="form-control form-control-sm" 
          id="ADJUNTAR_FACTURA_DE_COMISION_PDF" 
          type="text" 
          readonly 
          style="width:250px; background-color:#e9ecef;" 
          value="'.$row["ADJUNTAR_FACTURA_DE_COMISION_PDF"] .'" 
          required 
        />
      </p>
      <!-- Archivo oculto y deshabilitado -->
      <input type="file" name="ADJUNTAR_FACTURA_DE_COMISION_PDF" id="nono" style="display:none;" disabled />
    </div>
    <div id="3ADJUNTAR_FACTURA_DE_COMISION_PDF">
      '.$ADJUNTAR_FACTURA_DE_COMISION_PDF.'
    </div>
  </td>
</tr>



<tr>

<td width="30%" style="background:#dfd9f3"><label>ADJUNTAR FACTURA DE COMISIÓN (FORMATO XML)</label></td>
  <td width="70%">
    <div id="drop_file_zone" style="width:300px; background-color:#d7bde2;"> <!-- Fondo gris -->
      <p style="color:#999;">Suelta aquí o busca tu archivo</p> <!-- Texto deshabilitado -->
      <p>
        <!-- Input con readonly y sin eventos -->
        <input 
          class="form-control form-control-sm" 
          id="ADJUNTAR_FACTURA_DE_COMISION_XML" 
          type="text" 
          readonly 
          style="width:250px; background-color:#e9ecef;" 
          value="'.$row["ADJUNTAR_FACTURA_DE_COMISION_XML"] .'" 
          required 
        />
      </p>
      <!-- Archivo oculto y deshabilitado -->
      <input type="file" name="ADJUNTAR_FACTURA_DE_COMISION_XML" id="nono" style="display:none;" disabled />
    </div>
    <div id="3ADJUNTAR_FACTURA_DE_COMISION_XML">
      '.$ADJUNTAR_FACTURA_DE_COMISION_XML.'
    </div>
  </td>
</tr>

<tr>

<td width="30%" style="background:#dfd9f3"><label> ADJUNTAR CALCULO DE COMISIÓN</label></td>
  <td width="70%">
    <div id="drop_file_zone" style="width:300px; background-color:#d7bde2;"> <!-- Fondo gris -->
      <p style="color:#999;">Suelta aquí o busca tu archivo</p> <!-- Texto deshabilitado -->
      <p>
        <!-- Input con readonly y sin eventos -->
        <input 
          class="form-control form-control-sm" 
          id="CALCULO_DE_COMISION" 
          type="text" 
          readonly 
          style="width:250px; background-color:#e9ecef;" 
          value="'.$row["CALCULO_DE_COMISION"] .'" 
          required 
        />
      </p>
      <!-- Archivo oculto y deshabilitado -->
      <input type="file" name="CALCULO_DE_COMISION" id="nono" style="display:none;" disabled />
    </div>
    <div id="3CALCULO_DE_COMISION">
      '.$CALCULO_DE_COMISION.'
    </div>
  </td>
</tr>


<tr>

<td width="30%" style="background:#dfd9f3"><label>MONTO DE COMISIÓN</label></td>
<td width="70%"><input type="text" readonly=»readonly»  style="background:#d7bde2" name="MONTO_DE_COMISION" value="'.$row["MONTO_DE_COMISION"].'"></td>
</tr>



<tr>
<td width="30%" style="background:#dfd9f3"><label> ADJUNTAR COMPROBANTE DE DEVOLUCIÓN DE DINERO Al CORPORATIVO</label></td>
  <td width="70%">
    <div id="drop_file_zone" style="width:300px; background-color:#d7bde2;"> <!-- Fondo gris -->
      <p style="color:#999;">Suelta aquí o busca tu archivo</p> <!-- Texto deshabilitado -->
      <p>
        <!-- Input con readonly y sin eventos -->
        <input 
          class="form-control form-control-sm" 
          id="COMPROBANTE_DE_DEVOLUCION" 
          type="text" 
          readonly 
          style="width:250px; background-color:#e9ecef;" 
          value="'.$row["COMPROBANTE_DE_DEVOLUCION"] .'" 
          required 
        />
      </p>
      <!-- Archivo oculto y deshabilitado -->
      <input type="file" name="COMPROBANTE_DE_DEVOLUCION" id="nono" style="display:none;" disabled />
    </div>
    <div id="3COMPROBANTE_DE_DEVOLUCION">
      '.$COMPROBANTE_DE_DEVOLUCION.'
    </div>
  </td>
</tr>




<tr>

<td width="30%" style="background:#dfd9f3"><label> ADJUNTAR NOTA DE CREDITO DE COMPRA</label></td>
 <td width="70%">
    <div id="drop_file_zone" style="width:300px; background-color:#d7bde2;"> <!-- Fondo gris -->
      <p style="color:#999;">Suelta aquí o busca tu archivo</p> <!-- Texto deshabilitado -->
      <p>
        <!-- Input con readonly y sin eventos -->
        <input 
          class="form-control form-control-sm" 
          id="NOTA_DE_CREDITO_COMPRA" 
          type="text" 
          readonly 
          style="width:250px; background-color:#e9ecef;" 
          value="'.$row["NOTA_DE_CREDITO_COMPRA"] .'" 
          required 
        />
      </p>
      <!-- Archivo oculto y deshabilitado -->
      <input type="file" name="NOTA_DE_CREDITO_COMPRA" id="nono" style="display:none;" disabled />
    </div>
    <div id="3NOTA_DE_CREDITO_COMPRA">
      '.$NOTA_DE_CREDITO_COMPRA.'
    </div>
  </td>
</tr>

<tr>

<td width="30%" style="background:#dfd9f3"><label>PÓLIZA NÚMERO</label></td>
<td width="70%"><input type="text" readonly=»readonly»  style="background:#d7bde2" name="POLIZA_NUMERO" value="'.$row["POLIZA_NUMERO"].'"></td>
</tr>
<tr>

<td width="30%" style="background:#dfd9f3"><label>NOMBRE DEL EJECUTIVO QUE INGRESO ESTA FACTURA</label></td>
<td width="70%"><input type="text" readonly=»readonly»  style="background:#d7bde2" name="NOMBRE_DEL_AYUDO" value="'.$row["NOMBRE_DEL_AYUDO"].'"></td>
</tr>


<tr>

<td width="30%" style="background:#dfd9f3"><label>NOMBRE DEL EJECUTIVO QUE REALIZÓ LA COMPRA</label></td>
<td width="70%"><input type="text" readonly=»readonly»  style="background:#d7bde2" name="NOMBRE_DEL_EJECUTIVO" value="'.$row["NOMBRE_DEL_EJECUTIVO"].'"></td>
</tr>




<tr>
  <td width="30%" style="background:#dfd9f3"><label>ADJUNTAR ARCHIVO RELACIONADO A ESTE GASTO</label></td>
  <td width="70%">
    <div id="drop_file_zone" style="width:300px; background-color:#d7bde2;"> <!-- Fondo gris -->
      <p style="color:#999;">Suelta aquí o busca tu archivo</p> <!-- Texto deshabilitado -->
      <p>
        <!-- Input con readonly y sin eventos -->
        <input 
          class="form-control form-control-sm" 
          id="ADJUNTAR_ARCHIVO_1" 
          type="text" 
          readonly 
          style="width:250px; background-color:#e9ecef;" 
          value="'.$row["ADJUNTAR_ARCHIVO_1"] .'" 
          required 
        />
      </p>
      <!-- Archivo oculto y deshabilitado -->
      <input type="file" name="ADJUNTAR_ARCHIVO_1" id="nono" style="display:none;" disabled />
    </div>
    <div id="3ADJUNTAR_ARCHIVO_1">
      '.$ADJUNTAR_ARCHIVO_1.'
    </div>
  </td>
</tr>

<tr><td colspan=2>
<table id="reseteaxml" style="width:100%;">'.$campos_xml.'</table>
</td></tr>

<tr>
<td width="30%" ><label>FECHA DE ÚLTIMA CARGA:</label></td>
<td width="70%"><input type="text" readonly=»readonly» style="background:#decaf1" name="FECHA_DE_LLENADO" value="'.$row["FECHA_DE_LLENADO"].'"></td>
</tr>
</table>


	        <tr>
            <td width="30%"><label></label></td>  
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td width="70%"><button class="btn btn-sm btn-outline-success px-5"  type="button" id="clickPAGOP">GUARDAR</button>
			
			<input type="hidden" value="ENVIARPAGOprovee"  name="ENVIARPAGOprovee"/>
			<input type="hidden" value="'.$row["id"].'"  name="IPpagoprovee" id="IPpagoprovee"/>
			</td>  
        </tr>

     ';
    }
    $output .= '</table></div>

	</form>';
    echo $output;
}

?>
<script>
	var fileobj;
	function upload_file2(e,name) {
	    e.preventDefault();
	    fileobj = e.dataTransfer.files[0];
	    ajax_file_upload2(fileobj,name);
	}
	 
	function file_explorer2(name) {
	    document.getElementsByName(name)[0].click();
	    document.getElementsByName(name)[0].onchange = function() {
	        fileobj = document.getElementsByName(name)[0].files[0];
	        ajax_file_upload2(fileobj,name);
	    };
	}
	
	
	// Función para calcular el total automáticamente
function calcularTotal() {
    // Obtener valores
    const montoEvento = parseFloat(document.getElementById('montoTotalEvento').value) || 0;
    const montoAvion = parseFloat(document.getElementById('montoTotalAvion').value) || 0;
    const montopropina = parseFloat(document.getElementById('montoTotalpropina').value) || 0;
    const montohospedaje = parseFloat(document.getElementById('montoTotalhospedaje').value) || 0;
    
    // Calcular suma
    const total = montoEvento + montoAvion + montopropina + montohospedaje;
    
    // Asignar resultado (con 2 decimales)
    document.getElementById('montoTotalEventoResultado').value = total.toFixed(2);
}

// Ejecutar al cargar la ventana
window.onload = calcularTotal;

// Escuchar cambios en los inputs
document.getElementById('montoTotalEvento').addEventListener('input', calcularTotal);
document.getElementById('montoTotalAvion').addEventListener('input', calcularTotal);
document.getElementById('montoTotalpropina').addEventListener('input', calcularTotal);
document.getElementById('montoTotalhospedaje').addEventListener('input', calcularTotal);


	function ajax_file_upload2(file_obj,nombre) {
	    if(file_obj != undefined) {
	        var form_data = new FormData();                  
	        form_data.append(nombre, file_obj);
	        form_data.append("IPpagoprovee",  $("#IPpagoprovee").val());
	        $.ajax({
	            type: 'POST',
                url:"pagoproveedores/controladorPP.php",
				  dataType: "html",
	            contentType: false,
	            processData: false,
	            data: form_data,
 beforeSend: function() {
$('#3'+nombre).html('<p style="color:green;">Cargando archivo!</p>');
$('#respuestaser').html('<p style="color:green;">Actualizado!</p>');
    },				
	            success:function(response) {

if($.trim(response) == 2 ){

$('#3'+nombre).html('<p style="color:red;">Error, archivo diferente a PDF, JPG o GIF.</p>');
$('#'+nombre).val("");
}
else if($.trim(response) == 3 ){
$('#3'+nombre).html('<p style="color:red;">UUID PREVIAMENTE CARGADO.</p>');
//$('#'+nombre).val("");
}
else{
		var result = response.split('^^');
		$('#'+nombre).val(result[1]);
		$('#3'+nombre).html('<a target="_blank" href="includes/archivos/'+$.trim(result[0])+'">Visualizar!</a>');

		if(result[1].length>1){
			$('#respuestaser').html('<p style="color:green;font-size:25px;font-weight: bolder;">XML CORRECTAMENTE CARGADO CON EL UUID:<br> '+result[1]+'</p>');
			$('#reseteaxml').remove(); 
		}	
}
$('#respuestaser').html('<p style="color:green;">'+response+'</p>');
	            }
	        });
	    }
	}
    $(document).ready(function(){


$("#clickPAGOP").click(function(){
	
   $.ajax({  
    url:"pagoproveedores/controladorPP.php",
    method:"POST",  
    data:$('#ListadoPAGOPROVEEform').serialize(),

    beforeSend:function(){  
    $('#mensajepagoproveedores').html('cargando'); 
    }, 	
	
    success:function(data){
	
		if($.trim(data)=='Ingresado' || $.trim(data)=='Actualizado'){
				
			$('#dataModal').modal('hide');
			//$("#results").load("pagoproveedores/fetch_pagesPP.php");
			
			$.getScript(load2(1));

			$("#mensajepagoproveedores").html("<span id='ACTUALIZADO' >"+data+"</span>");

			}else{
				
			$("#mensajepagoproveedores").html(data);
			
		}
    }  
   });
   
});

		});
		
	</script>