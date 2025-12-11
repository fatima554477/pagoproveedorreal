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
<?php
   while($row = mysqli_fetch_array($queryVISTAPREV))
    {
		$row2xml = $pagoproveedores->busca_02XML($row['id']);
$SOLICITADO = "";$APROBADO = "";$PAGADO = "";$PAGADO = "";
    if($row['STATUS_DE_PAGO']=="SOLICITADO"){$SOLICITADO = "selected";}
elseif($row['STATUS_DE_PAGO']=="APROBADO"){$APROBADO = "selected";}
elseif($row['STATUS_DE_PAGO']=="PAGADO"){$PAGADO = "selected";}
elseif($row['STATUS_DE_PAGO']=="RECHAZADO"){$RECHAZADO = "selected";}

$STATUS_DE_PAGO = '<select required="" name="STATUS_DE_PAGO"> 
<option selected="">SELECCIONA UNA OPCION</option>
<option style="background:#d9f9fa" value="SOLICITADO" '.$SOLICITADO.'>SOLICITADO</option>
<option style="background:#e1f5de" value="APROBADO" '.$APROBADO.'>APROBADO</option>
<option style="background:#f5deee" value="PAGADO" '.$PAGADO.'>PAGADO</option>
<option style="background:#f5f4de" value="RECHAZADO" '.$RECHAZADO.'>RECHAZADO</option>
</select>';
		

	$queryVISTAPREV = $pagoproveedores->Listado_subefacturaDOCTOS($row['id']);		
	while($rowDOCTOS = mysqli_fetch_array($queryVISTAPREV))
	{



        if($rowDOCTOS["ADJUNTAR_FACTURA_PDF"]!=""){$ADJUNTAR_FACTURA_PDF .=  "<a target='_blank' href='includes/archivos/".$rowDOCTOS["ADJUNTAR_FACTURA_PDF"]."'>Visualizar!</a>"." <span id='".$rowDOCTOS['id']."' class='view_dataSBborrar2' style='cursor:pointer;color:blue;'>Borrar!</span> <span > ".$rowDOCTOS['fechaingreso']."</span>".'<br/>'; 
		}	else{
			
			//$ADJUNTAR_FACTURA_PDF = "";
			
		}
        
        
        if($rowDOCTOS["ADJUNTAR_FACTURA_XML"]!=""){$ADJUNTAR_FACTURA_XML .=  "<a target='_blank' href='includes/archivos/".$rowDOCTOS["ADJUNTAR_FACTURA_XML"]."'>Visualizar!</a>"." <span id='".$rowDOCTOS['id']."' class='view_dataSBborrar2' style='cursor:pointer;color:blue;'>Borrar!</span> <span > ".$rowDOCTOS['fechaingreso']."</span>".'<br/>'; 
		}	else{
			
			//$ADJUNTAR_FACTURA_XML = "";
			
		}

         
        if($rowDOCTOS["ADJUNTAR_COTIZACION"]!=""){$ADJUNTAR_COTIZACION .=  "<a target='_blank' href='includes/archivos/".$rowDOCTOS["ADJUNTAR_COTIZACION"]."'>Visualizar!</a>"." <span id='".$rowDOCTOS['id']."' class='view_dataSBborrar2' style='cursor:pointer;color:blue;'>Borrar!</span> <span > ".$rowDOCTOS['fechaingreso']."</span>".'<br/>'; 
		}	else{
			
			//$ADJUNTAR_COTIZACION = "";
			
		}
        
        if($rowDOCTOS["CONPROBANTE_TRANSFERENCIA"]!=""){$CONPROBANTE_TRANSFERENCIA =  "<a target='_blank' href='includes/archivos/".$rowDOCTOS["CONPROBANTE_TRANSFERENCIA"]."'>Visualizar!</a>"." <span id='".$rowDOCTOS['id']."' class='view_dataSBborrar2' style='cursor:pointer;color:blue;'>Borrar!</span> <span > ".$rowDOCTOS['fechaingreso']."</span>".'<br/>'; 
		}	else{
			
			//$CONPROBANTE_TRANSFERENCIA = "";
			
		}
        
        if($rowDOCTOS["FOTO_ESTADO_PROVEE"]!=""){$FOTO_ESTADO_PROVEE .=  "<a target='_blank' href='includes/archivos/".$rowDOCTOS["FOTO_ESTADO_PROVEE"]."'>Visualizar!</a>"." <span id='".$rowDOCTOS['id']."' class='view_dataSBborrar2' style='cursor:pointer;color:blue;'>Borrar!</span> <span > ".$rowDOCTOS['fechaingreso']."</span>".'<br/>'; 
		}	else{
			
			//$FOTO_ESTADO_PROVEE = "";
			
		}
        
        if($rowDOCTOS["COMPLEMENTOS_PAGO_PDF"]!=""){$COMPLEMENTOS_PAGO_PDF .=  "<a target='_blank' href='includes/archivos/".$rowDOCTOS["COMPLEMENTOS_PAGO_PDF"]."'>Visualizar!</a>"." <span id='".$rowDOCTOS['id']."' class='view_dataSBborrar2' style='cursor:pointer;color:blue;'>Borrar!</span> <span > ".$rowDOCTOS['fechaingreso']."</span>".'<br/>'; 
		}	else{
			
			//$COMPLEMENTOS_PAGO_PDF = "";
			
		}
        

        if($rowDOCTOS["COMPLEMENTOS_PAGO_XML"]!=""){$COMPLEMENTOS_PAGO_XML .=  "<a target='_blank' href='includes/archivos/".$rowDOCTOS["COMPLEMENTOS_PAGO_XML"]."'>Visualizar!</a>"." <span id='".$rowDOCTOS['id']."' class='view_dataSBborrar2' style='cursor:pointer;color:blue;'>Borrar!</span> <span > ".$rowDOCTOS['fechaingreso']."</span>".'<br/>'; 
		}	else{
			
			//$COMPLEMENTOS_PAGO_XML = "";
			
		}

        if($rowDOCTOS["CANCELACIONES_PDF"]!=""){$CANCELACIONES_PDF .=  "<a target='_blank' href='includes/archivos/".$rowDOCTOS["CANCELACIONES_PDF"]."'>Visualizar!</a>"." <span id='".$rowDOCTOS['id']."' class='view_dataSBborrar2' style='cursor:pointer;color:blue;'>Borrar!</span> <span > ".$rowDOCTOS['fechaingreso']."</span>".'<br/>'; 
		}	else{
			
			//$CANCELACIONES_PDF = "";
			
		}

        if($rowDOCTOS["CANCELACIONES_XML"]!=""){$CANCELACIONES_XML .=  "<a target='_blank' href='includes/archivos/".$rowDOCTOS["CANCELACIONES_XML"]."'>Visualizar!</a>"." <span id='".$rowDOCTOS['id']."' class='view_dataSBborrar2' style='cursor:pointer;color:blue;'>Borrar!</span> <span > ".$rowDOCTOS['fechaingreso']."</span>".'<br/>'; 
		}	else{
			
			//$CANCELACIONES_XML = "";
			
		}

        
        if($rowDOCTOS["ADJUNTAR_FACTURA_DE_COMISION_PDF"]!=""){$ADJUNTAR_FACTURA_DE_COMISION_PDF .=  "<a target='_blank' href='includes/archivos/".$rowDOCTOS["ADJUNTAR_FACTURA_DE_COMISION_PDF"]."'>Visualizar!</a>"." <span id='".$rowDOCTOS['id']."' class='view_dataSBborrar2' style='cursor:pointer;color:blue;'>Borrar!</span> <span > ".$rowDOCTOS['fechaingreso']."</span>".'<br/>'; 
		}	else{
			
			//$ADJUNTAR_FACTURA_DE_COMISION_PDF = "";
			
		}

        if($rowDOCTOS["ADJUNTAR_ARCHIVO_1"]!=""){$ADJUNTAR_ARCHIVO_1 .=  "<a target='_blank' href='includes/archivos/".$rowDOCTOS["ADJUNTAR_ARCHIVO_1"]."'>Visualizar!</a>"." <span id='".$rowDOCTOS['id']."' class='view_dataSBborrar2' style='cursor:pointer;color:blue;'>Borrar!</span> <span > ".$rowDOCTOS['fechaingreso']."</span>".'<br/>'; 
		}	else{
			
			//$ADJUNTAR_ARCHIVO_1 = "";
			
		}
        
        if($rowDOCTOS["CALCULO_DE_COMISION"]!=""){$CALCULO_DE_COMISION .=  "<a target='_blank' href='includes/archivos/".$rowDOCTOS["CALCULO_DE_COMISION"]."'>Visualizar!</a>"." <span id='".$rowDOCTOS['id']."' class='view_dataSBborrar2' style='cursor:pointer;color:blue;'>Borrar!</span> <span > ".$rowDOCTOS['fechaingreso']."</span>".'<br/>'; 
		}	else{
			
			//$CALCULO_DE_COMISION = "";
			
		}

        if($rowDOCTOS["COMPROBANTE_DE_DEVOLUCION"]!=""){$COMPROBANTE_DE_DEVOLUCION .=  "<a target='_blank' href='includes/archivos/".$rowDOCTOS["COMPROBANTE_DE_DEVOLUCION"]."'>Visualizar!</a>"." <span id='".$rowDOCTOS['id']."' class='view_dataSBborrar2' style='cursor:pointer;color:blue;'>Borrar!</span> <span > ".$rowDOCTOS['fechaingreso']."</span>".'<br/>'; 
		}	else{
			
			//$COMPROBANTE_DE_DEVOLUCION = "";
			
		}

        if($rowDOCTOS["NOTA_DE_CREDITO_COMPRA"]!=""){$NOTA_DE_CREDITO_COMPRA .=  "<a target='_blank' href='includes/archivos/".$rowDOCTOS["NOTA_DE_CREDITO_COMPRA"]."'>Visualizar!</a>"." <span id='".$rowDOCTOS['id']."' class='view_dataSBborrar2' style='cursor:pointer;color:blue;'>Borrar!</span> <span > ".$rowDOCTOS['fechaingreso']."</span>".'<br/>'; 
		}	else{
			
			//$NOTA_DE_CREDITO_COMPRA = "";
			
		}

      
        if($rowDOCTOS["ADJUNTAR_FACTURA_DE_COMISION_XML"]!=""){$ADJUNTAR_FACTURA_DE_COMISION_XML .=  "<a target='_blank' href='includes/archivos/".$rowDOCTOS["ADJUNTAR_FACTURA_DE_COMISION_XML"]."'>Visualizar!</a>"." <span id='".$rowDOCTOS['id']."' class='view_dataSBborrar2' style='cursor:pointer;color:blue;'>Borrar!</span> <span > ".$rowDOCTOS['fechaingreso']."</span>".'<br/>'; 
		}	else{
			
			//$ADJUNTAR_FACTURA_DE_COMISION_XML = "";
			
		}

}


?>

<?php


 $output .= '<form  id="ListadoPAGOPROVEEform"> 
      <div class="table-responsive">  
           <table class="table table-bordered" style="background: #ebf9e9;">';
		   

$campos_xml = '';

if($row2xml["Version"]=='no' or $row2xml["Version"]==''){

$campos_xml = '

<!--aqui empieza la lectura BD a XML-->
<!--aqui empieza la lectura BD a XML-->
<!--aqui empieza la lectura BD a XML-->
<!--aqui empieza la lectura BD a XML-->
<!--aqui empieza la lectura BD a XML-->

<tr style="background: #fbf696;style="font-weight:bold;">


<td width="30%" style="font-weight:bold;" ><label>NOMBRE RECEPTOR</label></td>
<td width="70%"><input type=»text» readonly=»readonly» style="background:#decaf1"  name="nombreR" value="'.$row2xml["nombreR"].'"></td>
</tr>

<tr style="background: #fbf696;style="font-weight:bold;">


<td width="30%" style="font-weight:bold;" ><label>RFC RECEPTOR</label></td>
<td width="70%"><input type=»text» readonly=»readonly» style="background:#decaf1"  name="rfcR" value="'.$row2xml["rfcR"].'"></td>
</tr>

<tr style="background: #fbf696;style="font-weight:bold;">

<td width="30%" style="font-weight:bold;" ><label>REGÍMEN FISCAL</label></td>
<td width="70%"><input type=»text» readonly=»readonly» style="background:#decaf1"  name="regimenE" value="'.$row2xml["regimenE"].'"></td>
</tr>

<tr style="background: #fbf696;style="font-weight:bold;">

<td width="30%" style="font-weight:bold;" ><label>UUID</label></td>
<td width="70%"><input type=»text» readonly=»readonly» style="background:#decaf1"  name="UUID" value="'.$row2xml["UUID"].'"></td>
</tr>

<tr style="background: #fbf696;style="font-weight:bold;">

<td width="30%" style="font-weight:bold;" ><label>FOLIO</label></td>
<td width="70%"><input type=»text» readonly=»readonly» style="background:#decaf1"  name="folio" value="'.$row2xml["folio"].'"></td>
</tr>

<tr style="background: #fbf696;style="font-weight:bold;">

<td width="30%" style="font-weight:bold;" ><label>SERIE</label></td>
<td width="70%"><input type=»text» readonly=»readonly» style="background:#decaf1"  name="serie" value="'.$row2xml["serie"].'"></td>
</tr>

<tr style="background: #fbf696;style="font-weight:bold;">

<td width="30%" style="font-weight:bold;" ><label>CLAVE DE UNIDAD</label></td>
<td width="70%"><input type=»text» readonly=»readonly» style="background:#decaf1"  name="ClaveUnidadConcepto" value="'.$row2xml["ClaveUnidadConcepto"].'"></td>
</tr>

<tr style="background: #fbf696;style="font-weight:bold;">

<td width="30%" style="font-weight:bold;" ><label>CANTIDAD</label></td>
<td width="70%"><input type=»text» readonly=»readonly» style="background:#decaf1"  name="CantidadConcepto" value="'.$row2xml["CantidadConcepto"].'"></td>
</tr>

<tr style="background: #fbf696;style="font-weight:bold;">

<td width="30%" style="font-weight:bold;" ><label>CLAVE DE PRODUCTO O SERVICIO</label></td>
<td width="70%"><input type=»text» readonly=»readonly» style="background:#decaf1"  name="ClaveProdServConcepto" value="'.$row2xml["ClaveProdServConcepto"].'"></td>
</tr>

<tr style="background: #fbf696;style="font-weight:bold;">

<td width="30%" style="font-weight:bold;" ><label>DESCRIPCIÓN</label></td>
<td width="70%"><input type=»text» readonly=»readonly» style="background:#decaf1"  name="DescripcionConcepto" value="'.$row2xml["DescripcionConcepto"].'"></td>
</tr>

<tr style="background: #fbf696;style="font-weight:bold;">


<td width="30%" style="font-weight:bold;" ><label>MONEDA</label></td>
<td width="70%"><input type=»text» readonly=»readonly» style="background:#decaf1"  name="Moneda" value="'.$row2xml["Moneda"].'"></td>
</tr>

<tr style="background: #fbf696;style="font-weight:bold;">

<td width="30%" style="font-weight:bold;" ><label>TIPO DE CAMBIO</label></td>
<td width="70%"><input type=»text» readonly=»readonly» style="background:#decaf1"  name="TipoCambio" value="'.$row2xml["TipoCambio"].'"></td>
</tr>

<tr style="background: #fbf696;style="font-weight:bold;">

<td width="30%" style="font-weight:bold;" ><label>USO DE CFDI</label></td>
<td width="70%"><input type=»text» readonly=»readonly» style="background:#decaf1"  name="UsoCFDI" value="'.$row2xml["UsoCFDI"].'"></td>
</tr>

<tr style="background: #fbf696;style="font-weight:bold;">

<td width="30%" style="font-weight:bold;" ><label>METODO DE PAGO</label></td>
<td width="70%"><input type=»text» readonly=»readonly» style="background:#decaf1"  name="metodoDePago" value="'.$row2xml["metodoDePago"].'"></td>
</tr>

<tr style="background: #fbf696;style="font-weight:bold;">

<td width="30%" style="font-weight:bold;" ><label>CONDICIONES DE PAGO</label></td>
<td width="70%"><input type=»text» readonly=»readonly» style="background:#decaf1"  name="condicionesDePago" value="'.$row2xml["condicionesDePago"].'"></td>
</tr>

<tr style="background: #fbf696;style="font-weight:bold;">

<td width="30%" style="font-weight:bold;" ><label>TIPO DE COMPROBANTE</label></td>
<td width="70%"><input type=»text» readonly=»readonly» style="background:#decaf1"  name="tipoDeComprobante" value="'.$row2xml["tipoDeComprobante"].'"></td>
</tr>

<tr style="background: #fbf696;style="font-weight:bold;">

<td width="30%" style="font-weight:bold;" ><label>VERSIÓN</label></td>
<td width="70%"><input type=»text» readonly=»readonly» style="background:#decaf1"  name="Version" value="'.$row2xml["Version"].'"></td>
</tr>
<input type="hidden" name="actualiza" value="true">

<tr style="background: #fbf696;style="font-weight:bold;">

<td width="30%" style="font-weight:bold;" ><label>FECHA DE TIMBRADO</label></td>
<td width="70%"><input type=»text» readonly=»readonly» style="background:#decaf1"  name="fechaTimbrado" value="'.$row2xml["fechaTimbrado"].'"></td>
</tr>

<tr style="background: #fbf696;style="font-weight:bold;">

<td width="30%" style="font-weight:bold;" ><label>SUBTOTAL</label></td>
<td width="70%"><input type=»text» readonly=»readonly» style="background:#decaf1"  name="subTotal" value="'.$row2xml["subTotal"].'"></td>
</tr>

<tr style="background: #fbf696;style="font-weight:bold;">

<td width="30%" style="font-weight:bold;" ><label>SERVICIO, PROPINA,ISH Y SANAMIENTO</label></td>
<td width="70%"><input type=»text» readonly=»readonly» style="background:#decaf1"  name="Propina" value="'.$row2xml["Propina"].'"></td>
</tr>

<tr style="background: #fbf696;style="font-weight:bold;">

<td width="30%" style="font-weight:bold;" ><label>DESCUENTO</label></td>
<td width="70%"><input type=»text» readonly=»readonly» style="background:#decaf1"  name="DESCUENTO" value="'.$row2xml["DESCUENTO"].'"></td>
</tr>

<tr style="background: #fbf696;style="font-weight:bold;">

<td width="30%" style="font-weight:bold;" ><label>TOTAL DE IMPUESTOS TRANSLADADOS</label></td>
<td width="70%"><input type=»text» readonly=»readonly» style="background:#decaf1"  name="TImpuestosTrasladados" value="'.$row2xml["TImpuestosTrasladados"].'"></td>
</tr>
 <tr style="background: #fbf696;style="font-weight:bold;">

<td width="30%" style="font-weight:bold;" ><label>TOTAL DE IMPUESTOS RETENIDOS</label></td>
<td width="70%"><input type=»text» readonly=»readonly» style="background:#decaf1"  name="TImpuestosRetenidos" value="'.$row2xml["TImpuestosRetenidos"].'"></td>
</tr>

<tr style="background: #fbf696;style="font-weight:bold;">

<td width="30%" style="font-weight:bold;" ><label>TUA</label></td>
<td width="70%"><input type=»text» readonly=»readonly» style="background:#decaf1"  name="TUA" value="'.$row2xml["TUA"].'"></td>
</tr>

<tr style="background: #fbf696;style="font-weight:bold;">

<td width="30%" style="font-weight:bold;" ><label>TOTAL</label></td>
<td width="70%"><input type=»text» readonly=»readonly» style="background:#decaf1"  name="totalf" value="'.$row2xml["totalf"].'"></td>
</tr>



<tr style="background: #fbf696;style="font-weight:bold;">

<td width="30%" style="font-weight:bold;" ><label>TUA TOTAL CARGOS:</label></td>
<td width="70%"><input type=»text» readonly=»readonly» style="background:#decaf1"  name="TuaTotalCargos" value="'.$row2xml["TuaTotalCargos"].'"></td>
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


     $output .= '





 <tr>
 
<td width="30%" style="font-weight:bold;" ><label>ADJUNTAR FACTURA (FORMATO XML)</label></td>
<td width="70%">	<div id="drop_file_zone" ondrop="upload_file2(event,\'ADJUNTAR_FACTURA_XML\')" ondragover="return false"'.$facturaDropZoneAttributes.'>
<p>Suelta aquí o busca tu archivo</p>
<p><input class="form-control form-control-sm" id="ADJUNTAR_FACTURA_XML" type="text" onkeydown="return false" onclick="file_explorer2(\'ADJUNTAR_FACTURA_XML\');" style="width:250px;" VALUE="'.$row["ADJUNTAR_FACTURA_XML"] .' " required'.$facturaInputAttributes.' /></p>
<input type="file" name="ADJUNTAR_FACTURA_XML" id="nono"'.$facturaInputAttributes.'/>
<div id="3ADJUNTAR_FACTURA_XML">
'.$ADJUNTAR_FACTURA_XML.'
</tr> 
<tr>
 
 
<td width="30%" style="font-weight:bold;" ><label>ADJUNTAR FACTURA (FORMATO PDF)</label></td>
<td width="70%">	<div id="drop_file_zone" ondrop="upload_file2(event,\'ADJUNTAR_FACTURA_PDF\')" ondragover="return false"'.$facturaDropZoneAttributes.'>
<p>Suelta aquí o busca tu archivo</p>
<p><input class="form-control form-control-sm" id="ADJUNTAR_FACTURA_PDF" type="text" onkeydown="return false" onclick="file_explorer2(\'ADJUNTAR_FACTURA_PDF\');" style="width:250px;" VALUE="'.$row["ADJUNTAR_FACTURA_PDF"] .' " required'.$facturaInputAttributes.' /></p>
<input type="file" name="ADJUNTAR_FACTURA_PDF" id="nono"'.$facturaInputAttributes.'/>
<div id="3ADJUNTAR_FACTURA_PDF">
'.$ADJUNTAR_FACTURA_PDF.'
</tr> 









<tr style="background:#F368E7">



 

 

<td width="30%" style="font-weight:bold;" ><label>NÚMERO DE SOLICITUD</label></td>
<td width="70%"><input type="text"   name="NUMERO_CONSECUTIVO_PROVEE" value="'.$row["NUMERO_CONSECUTIVO_PROVEE"].'"></td>
</tr>


<tr>
    <td width="30%" style="font-weight:bold;" ><label>PAGO A PROVEEDOR, VIATICO, REEMBOLSO O<br> PAGO A PROVEEDOR CON DOS O MAS FACTURAS:</label></td>
    <td width="70%" class="form-control">
        <select name="VIATICOSOPRO" style="background:#daddf5">
            <option style="background:#f2b4f5" value="SELECCIONA UNA OPCIÓN">SELECCIONA UNA OPCIÓN</option>
            <option style="background:#f2b4f5" value="PAGO A PROVEEDOR" '.($row["VIATICOSOPRO"] == "PAGO A PROVEEDOR" ? "selected" : "").'>PAGO A PROVEEDOR </option>
            <option style="background:#ddf5da" value="PAGO A PROVEEDOR CON DOS O MAS FACTURAS" '.($row["VIATICOSOPRO"] == "PAGO A PROVEEDOR CON DOS O MAS FACTURAS" ? "selected" : "").'>PAGO A PROVEEDOR CON DOS O MAS FACTURAS</option>
			<option style="background:#b3f39b" value="PAGOS CON UNA SOLA FACTURA" '.($row["VIATICOSOPRO"] == "PAGOS CON UNA SOLA FACTURA" ? "selected" : "").'>PAGOS CON UNA SOLA FACTURA</option>
            <option style="background:#fceade" value="VIATICOS" '.($row["VIATICOSOPRO"] == "VIATICOS" ? "selected" : "").'>VIATICOS</option>
            <option style="background:#dee6fc" value="REEMBOLSO" '.($row["VIATICOSOPRO"] == "REEMBOLSO" ? "selected" : "").'>REEMBOLSO</option>
            
        </select>
    </td>
</tr>

 
<tr>


<td width="30%" style="font-weight:bold;" ><label>NOMBRE COMERCIAL</label></td>
<td width="70%"><input type="text" name="NOMBRE_COMERCIAL" value="'.$row["NOMBRE_COMERCIAL"].'"><br><a style="color:red;font-size:10px">OBLIGATORIO</a></td>
</tr> 
<tr>

<td width="30%" style="font-weight:bold;" ><label>RAZÓN SOCIAL</label></td>
<td width="70%"><input type="text" name="RAZON_SOCIAL" value="'.$row["RAZON_SOCIAL"].'"></td>
</tr> 
<tr>
 
<td width="30%" style="font-weight:bold;" ><label>RFC DEL PROVEEDOR</label></td>
<td width="70%"><input type="text" name="RFC_PROVEEDOR" value="'.$row["RFC_PROVEEDOR"].'"></td>
</tr> 
<tr>

<td width="30%" style="font-weight:bold;" ><label>NÚMERO  DE EVENTO </label></td>
<td width="70%"><input type="text" name="NUMERO_EVENTO" value="'.$row["NUMERO_EVENTO"].'"><br><a style="color:red;font-size:10px">OBLIGATORIO</a></td>
</tr> 
<tr>

 
<td width="30%" style="font-weight:bold;" ><label>NOMBRE DEL EVENTO</label></td>
<td width="70%"><input type="text" name="NOMBRE_EVENTO" value="'.$row["NOMBRE_EVENTO"].'"></td>
</tr> 
<tr>
 
<td width="30%" style="font-weight:bold;" ><label>MOTIVO DEL GASTO</label></td>
<td width="70%"><input type="text" name="MOTIVO_GASTO" value="'.$row["MOTIVO_GASTO"].'"></td>
</tr> 
<tr>
 
<td width="30%" style="font-weight:bold;" ><label>CONCEPTO</label></td>
<td width="70%"><input type="text" name="CONCEPTO_PROVEE" value="'.$row["CONCEPTO_PROVEE"].'"></td>
</tr> 
<tr>

<td width="30%" style="font-weight:bold;" ><label>MONTO TOTAL DE LA COTIZACIÓN O DEL ADEUDO</label></td>
<td width="70%"><input type="text" name="MONTO_TOTAL_COTIZACION_ADEUDO" value="'.$row["MONTO_TOTAL_COTIZACION_ADEUDO"].'"></td>
</tr> 
<tr >

<td width="30%" style="font-weight:bold;" ><label>SUB TOTAL:</label></td>
<td width="70%"><input type="text" name="MONTO_FACTURA" id="montoTotalEvento" value="'.$row["MONTO_FACTURA"].'"></td>
</tr>

 
<tr >
<td width="30%" style="font-weight:bold;" ><label>IVA:</label></td>
<td width="70%"><input type="text" name="IVA" id="montoTotalAvion" value="'.$row["IVA"].'"></td>
</tr> 

<tr>
<td width="30%" style="font-weight:bold;" ><label>IMPUESTOS RETENIDOS  IVA:</label></td>
<td width="70%"><input type="text" name="TImpuestosRetenidosIVA"  value="'.$row["TImpuestosRetenidosIVA"].'"></td>
</tr> 

<tr >
<td width="30%" style="font-weight:bold;" ><label>IMPUESTOS RETENIDOS  ISR:</label></td>
<td width="70%"><input type="text" name="TImpuestosRetenidosISR"  value="'.$row["TImpuestosRetenidosISR"].'"></td>
</tr> 


<tr >
<td width="30%" style="font-weight:bold;" ><label>MONTO DE LA PROPINA O SERVICIO NO INCLUIDO EN LA FACTURA</label></td>
<td width="70%"><input type="text" name="MONTO_PROPINA" id="montoTotalpropina" value="'.$row["MONTO_PROPINA"].'"></td>
</tr> 
<tr>

<td width="30%" style="font-weight:bold;" ><label>IMPUESTO SOBRE HOSPEDAJE MÁS EL IMPUESTO DE SANEAMIENTO</label></td>
<td width="70%"><input type="text" name="IMPUESTO_HOSPEDAJE" id="montoTotalhospedaje" value="'.$row["IMPUESTO_HOSPEDAJE"].'"></td>
</tr>

<tr>
<td width="30%" style="font-weight:bold;" ><label>DESCUENTO:</label></td>
<td width="70%"><input type="text" name="descuentos"  value="'.$row["descuentos"].'"></td>
</tr> 


<tr >
<td width="30%" style="font-weight:bold;" ><label>TOTAL</label></td>
<td width="70%"><input type="text" style="background:#decaf1" name="MONTO_DEPOSITAR" id="montoTotalEventoResultado" value="'.$row["MONTO_DEPOSITAR"].'"></td>
</tr>



<tr >
<td width="30%" style="font-weight:bold;" ><label>TIPO DE CAMBIO</label></td>
<td width="70%"><input type="text" name="TIPO_CAMBIOP" value="'.$row["TIPO_CAMBIOP"].'"></td>
</tr>

<tr >
<td width="30%" style="font-weight:bold;" ><label>TOTAL DE LA CONVERSIÓN </label></td>
<td width="70%"><input type="text" name="TOTAL_ENPESOS" value="'.$row["TOTAL_ENPESOS"].'"></td>
</tr>


<tr>
    <td width="30%" style="font-weight:bold;" ><label>FORMA DE PAGO:</label></td>
    <td width="70%" class="form-control">
        <select name="PFORMADE_PAGO" style="background:#daddf5">
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
    </td>
</tr>

<tr style="background: #f1a766">
<td width="30%" style="font-weight:bold;" ><label>MONTO DEPOSITADO</label></td>
<td width="70%"><input type="text" name="MONTO_DEPOSITADO" value="'.$row["MONTO_DEPOSITADO"].'"></td>
</tr>


	<tr>
	
	<td width="30%" style="font-weight:bold;" ><label>TIPO DE MONEDA O DIVISA:</label></td>
    <td width="70%" >
        <select name="TIPO_DE_MONEDA" style="background:#daddf5">
		
		
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

<td width="30%" style="font-weight:bold;" ><label>FECHA DE PROGRAMACIÓN DEL PAGO</label></td>
<td width="70%"><input type="date" name="FECHA_DE_PAGO" value="'.$row["FECHA_DE_PAGO"].'"></td>
</tr>  

<tr   style="background: #f1a766">

<td width="30%" style="font-weight:bold;" ><label>FECHA EFECTIVA DE PAGO:</label></td>
<td width="70%"><input type="date" name="FECHA_A_DEPOSITAR" value="'.$row["FECHA_A_DEPOSITAR"].'"></td>
</tr> 
<tr style="background: #f1a766">

<td width="30%" style="font-weight:bold;" ><label>STATUS DE PAGO</label></td>
<td width="70%" class="form-control">'.$STATUS_DE_PAGO .'</td>
</tr> 
<tr style="background: #f1a766">

<td width="30%" style="font-weight:bold;" ><label>ADJUNTAR COTIZACIÓN O REPORTE: (CUAQUIER FORMATO)</label></td>




<td width="70%">	<div id="drop_file_zone" ondrop="upload_file2(event,\'ADJUNTAR_COTIZACION\')" ondragover="return false" style="width:300px;">
<p>Suelta aquí o busca tu archivo</p>
<p><input class="form-control form-control-sm" id="ADJUNTAR_COTIZACION" type="text" onkeydown="return false" onclick="file_explorer2(\'ADJUNTAR_COTIZACION\');" style="width:250px;" VALUE="'.$row["ADJUNTAR_COTIZACION"] .' " required /></p>
<input type="file" name="ADJUNTAR_COTIZACION" id="nono"/>
<div id="3ADJUNTAR_COTIZACION">
'.$ADJUNTAR_COTIZACION.'
</tr> 



<tr>
<td width="30%" style="font-weight:bold;" ><label>ACTIVO FIJO</label></td>
<td width="70%"><input type="text"   name="ACTIVO_FIJO"  value="'.$row["ACTIVO_FIJO"].'"></td>
</tr>



<tr>
<td width="30%" style="font-weight:bold;" ><label>GASTO FIJO</label></td>
<td width="70%"><input type="text"   name="GASTO_FIJO"  value="'.$row["GASTO_FIJO"].'"></td>
</tr>



<tr>
<td width="30%" style="font-weight:bold;" ><label>PAGAR CADA:</label></td>
<td width="70%"><input type="text"   name="PAGAR_CADA"  value="'.$row["PAGAR_CADA"].'"></td>
</tr>

<tr>
<td width="30%" style="font-weight:bold;" ><label>FECHA DE PROGRAMACIÓN DE PAGO:</label></td>
<td width="70%"><input type="date"   name="FECHA_PPAGO"  value="'.$row["FECHA_PPAGO"].'"></td>
</tr>

              
<tr>
<td width="30%" style="font-weight:bold;" ><label>FECHA DE TERMINACIÓN DE LA PROGRAMACIÓN:</label></td>
<td width="70%"><input type="date"   name="FECHA_TPROGRAPAGO"  value="'.$row["FECHA_TPROGRAPAGO"].'"></td>
</tr>



<tr>
<td width="30%" style="font-weight:bold;" ><label>NÚMERO DE EVENTO (FIJO) PARA PROGRAMACIÓN:</label></td>
<td width="70%"><input type="text"   name="NUMERO_EVENTOFIJO"  value="'.$row["NUMERO_EVENTOFIJO"].'"></td>
</tr>

<tr>
<td width="30%" style="font-weight:bold;" ><label>CLASIFICACIÓN GENERAL:</label></td>
<td width="70%"><input type="text"   name="CLASI_GENERAL"  value="'.$row["CLASI_GENERAL"].'"></td>
</tr>

<tr>
<td width="30%" style="font-weight:bold;" ><label> SUB CLASIFICACIÓN GENERAL:</label></td>
<td width="70%"><input type="text"   name="SUB_GENERAL"  value="'.$row["SUB_GENERAL"].'"></td>
</tr>







<tr>

<td width="30%" style="font-weight:bold;" ><label>INSTITUCIÓN BANCARIA</label></td>
<td width="70%"><input type="text" name="BANCO_ORIGEN" value="'.$row["BANCO_ORIGEN"].'"></td>
</tr>





<tr>

<td width="30%" style="font-weight:bold;" ><label>PLACAS DEL VEHICULO</label></td>
<td width="70%"><input type="text" name="PLACAS_VEHICULO" value="'.$row["PLACAS_VEHICULO"].'"></td>
</tr>
<tr  style="background: #f1a766">

<td width="30%" style="font-weight:bold;" ><label>ADJUNTAR COMPROBANTE DE TRANSFERENCIA: (FORMATO PDF)</label></td>
<td width="70%">	<div id="drop_file_zone" ondrop="upload_file2(event,\'CONPROBANTE_TRANSFERENCIA\')" ondragover="return false" style="width:300px;">
<p>Suelta aquí o busca tu archivo</p>
<p><input class="form-control form-control-sm" id="CONPROBANTE_TRANSFERENCIA" type="text" onkeydown="return false" onclick="file_explorer2(\'CONPROBANTE_TRANSFERENCIA\');" style="width:250px;" VALUE="'.$row["CONPROBANTE_TRANSFERENCIA"] .' " required /></p>
<input type="file" name="CONPROBANTE_TRANSFERENCIA" id="nono"/>
<div id="3CONPROBANTE_TRANSFERENCIA">
'.$CONPROBANTE_TRANSFERENCIA.'
</tr> 
<tr>

<td width="30%" style="font-weight:bold;" ><label>COMPLEMENTOS DE PAGO  (FORMATO PDF)</label></td>
<td width="70%">	<div id="drop_file_zone" ondrop="upload_file2(event,\'COMPLEMENTOS_PAGO_PDF\')" ondragover="return false" style="width:300px;">
<p>Suelta aquí o busca tu archivo</p>
<p><input class="form-control form-control-sm" id="COMPLEMENTOS_PAGO_PDF" type="text" onkeydown="return false" onclick="file_explorer2(\'COMPLEMENTOS_PAGO_PDF\');" style="width:250px;" VALUE="'.$row["COMPLEMENTOS_PAGO_PDF"] .' " required /></p>
<input type="file" name="COMPLEMENTOS_PAGO_PDF" id="nono"/>
<div id="3COMPLEMENTOS_PAGO_PDF">
'.$COMPLEMENTOS_PAGO_PDF.'
</tr> 
<tr>

<td width="30%" style="font-weight:bold;" ><label>COMPLEMENTOS DE PAGO  (FORMATO XML)</label></td>
<td width="70%">	<div id="drop_file_zone" ondrop="upload_file2(event,\'COMPLEMENTOS_PAGO_XML\')" ondragover="return false" style="width:300px;">
<p>Suelta aquí o busca tu archivo</p>
<p><input class="form-control form-control-sm" id="COMPLEMENTOS_PAGO_XML" type="text" onkeydown="return false" onclick="file_explorer2(\'COMPLEMENTOS_PAGO_XML\');" style="width:250px;" VALUE="'.$row["COMPLEMENTOS_PAGO_XML"] .' " required /></p>
<input type="file" name="COMPLEMENTOS_PAGO_XML" id="nono"/>
<div id="3COMPLEMENTOS_PAGO_XML">
'.$COMPLEMENTOS_PAGO_XML.'
</tr> 

<tr>

<td width="30%" style="font-weight:bold;" ><label>ADJUNTAR CANCELACIONES (FORMATO PDF)</label></td>
<td width="70%">	<div id="drop_file_zone" ondrop="upload_file2(event,\'CANCELACIONES_PDF\')" ondragover="return false" style="width:300px;">
<p>Suelta aquí o busca tu archivo</p>
<p><input class="form-control form-control-sm" id="CANCELACIONES_PDF" type="text" onkeydown="return false" onclick="file_explorer2(\'CANCELACIONES_PDF\');" style="width:250px;" VALUE="'.$row["CANCELACIONES_PDF"] .' " required /></p>
<input type="file" name="CANCELACIONES_PDF" id="nono"/>
<div id="3CANCELACIONES_PDF">
'.$CANCELACIONES_PDF.'
</tr> 
<tr>

<td width="30%" style="font-weight:bold;" ><label>ADJUNTAR CANCELACIONES (FORMATO PDF)</label></td>
<td width="70%">	<div id="drop_file_zone" ondrop="upload_file2(event,\'CANCELACIONES_XML\')" ondragover="return false" style="width:300px;">
<p>Suelta aquí o busca tu archivo</p>
<p><input class="form-control form-control-sm" id="CANCELACIONES_XML" type="text" onkeydown="return false" onclick="file_explorer2(\'CANCELACIONES_XML\');" style="width:250px;" VALUE="'.$row["CANCELACIONES_XML"] .' " required /></p>
<input type="file" name="CANCELACIONES_XML" id="nono"/>
<div id="3CANCELACIONES_XML">
'.$CANCELACIONES_XML.'
</tr> 

<tr>

<td width="30%" style="font-weight:bold;" ><label>ADJUNTAR FACTURA DE COMISIÓN :(FORMATO PDF)</label></td>
<td width="70%">	<div id="drop_file_zone" ondrop="upload_file2(event,\'ADJUNTAR_FACTURA_DE_COMISION_PDF\')" ondragover="return false" style="width:300px;">
<p>Suelta aquí o busca tu archivo</p>
<p><input class="form-control form-control-sm" id="ADJUNTAR_FACTURA_DE_COMISION_PDF" type="text" onkeydown="return false" onclick="file_explorer2(\'ADJUNTAR_FACTURA_DE_COMISION_PDF\');" style="width:250px;" VALUE="'.$row["ADJUNTAR_FACTURA_DE_COMISION_PDF"] .' " required /></p>
<input type="file" name="ADJUNTAR_FACTURA_DE_COMISION_PDF" id="nono"/>
<div id="3ADJUNTAR_FACTURA_DE_COMISION_PDF">
'.$ADJUNTAR_FACTURA_DE_COMISION_PDF.'
</tr>
<tr>

<td width="30%" style="font-weight:bold;" ><label>ADJUNTAR FACTURA DE COMISIÓN:(FORMATO XML)</label></td>
<td width="70%">	<div id="drop_file_zone" ondrop="upload_file2(event,\'ADJUNTAR_FACTURA_DE_COMISION_XML\')" ondragover="return false" style="width:300px;">
<p>Suelta aquí o busca tu archivo</p>
<p><input class="form-control form-control-sm" id="ADJUNTAR_FACTURA_DE_COMISION_XML" type="text" onkeydown="return false" onclick="file_explorer2(\'ADJUNTAR_FACTURA_DE_COMISION_XML\');" style="width:250px;" VALUE="'.$row["ADJUNTAR_FACTURA_DE_COMISION_XML"] .' " required /></p>
<input type="file" name="ADJUNTAR_FACTURA_DE_COMISION_XML" id="nono"/>
<div id="3ADJUNTAR_FACTURA_DE_COMISION_XML">
'.$ADJUNTAR_FACTURA_DE_COMISION_XML.'
</tr>

<tr>

<td width="30%" style="font-weight:bold;" ><label> ADJUNTAR CALCULO DE COMISIÓN</label></td>
<td width="70%">	<div id="drop_file_zone" ondrop="upload_file2(event,\'CALCULO_DE_COMISION\')" ondragover="return false" style="width:300px;">
<p>Suelta aquí o busca tu archivo</p>
<p><input class="form-control form-control-sm" id="CALCULO_DE_COMISION" type="text" onkeydown="return false" onclick="file_explorer2(\'CALCULO_DE_COMISION\');" style="width:250px;" VALUE="'.$row["CALCULO_DE_COMISION"] .' " required /></p>
<input type="file" name="CALCULO_DE_COMISION" id="nono"/>
<div id="3CALCULO_DE_COMISION">
'.$CALCULO_DE_COMISION.'
</tr>
<tr>

<td width="30%" style="font-weight:bold;" ><label>MONTO DE COMISIÓN</label></td>
<td width="70%"><input type="text" name="MONTO_DE_COMISION" value="'.$row["MONTO_DE_COMISION"].'"></td>
</tr>



<tr>
<td width="30%" style="font-weight:bold;" ><label> ADJUNTAR COMPROBANTE DE DEVOLUCIÓN DE DINERO A EPC</label></td>
<td width="70%">	<div id="drop_file_zone" ondrop="upload_file2(event,\'COMPROBANTE_DE_DEVOLUCION\')" ondragover="return false" style="width:300px;">
<p>Suelta aquí o busca tu archivo</p>
<p><input class="form-control form-control-sm" id="COMPROBANTE_DE_DEVOLUCION" type="text" onkeydown="return false" onclick="file_explorer2(\'COMPROBANTE_DE_DEVOLUCION\');" style="width:250px;" VALUE="'.$row["COMPROBANTE_DE_DEVOLUCION"] .' " required /></p>
<input type="file" name="COMPROBANTE_DE_DEVOLUCION" id="nono"/>
<div id="3COMPROBANTE_DE_DEVOLUCION">
'.$COMPROBANTE_DE_DEVOLUCION.'
</tr>




<tr>

<td width="30%" style="font-weight:bold;" ><label> ADJUNTAR NOTA DE CREDITO DE COMPRA</label></td>
<td width="70%">	<div id="drop_file_zone" ondrop="upload_file2(event,\'NOTA_DE_CREDITO_COMPRA\')" ondragover="return false" style="width:300px;">
<p>Suelta aquí o busca tu archivo</p>
<p><input class="form-control form-control-sm" id="NOTA_DE_CREDITO_COMPRA" type="text" onkeydown="return false" onclick="file_explorer2(\'NOTA_DE_CREDITO_COMPRA\');" style="width:250px;" VALUE="'.$row["NOTA_DE_CREDITO_COMPRA"] .' " required /></p>
<input type="file" name="NOTA_DE_CREDITO_COMPRA" id="nono"/>
<div id="3NOTA_DE_CREDITO_COMPRA">
'.$NOTA_DE_CREDITO_COMPRA.'
</tr>

<tr style="background: #f1a766">

<td width="30%" style="font-weight:bold;" ><label>PÓLIZA NÚMERO</label></td>
<td width="70%"><input type="text" name="POLIZA_NUMERO" value="'.$row["POLIZA_NUMERO"].'"></td>
</tr>
<tr>

<td width="30%" style="font-weight:bold;" ><label>NOMBRE DEL EJECUTIVO QUE INGRESO ESTA FACTURA</label></td>
<td width="70%"><input type="text" name="NOMBRE_DEL_AYUDO" value="'.$row["NOMBRE_DEL_AYUDO"].'"></td>
</tr>


<tr>

<td width="30%" style="font-weight:bold;" ><label>NOMBRE DEL EJECUTIVO QUE REALIZÓ LA COMPRA</label></td>
<td width="70%"><input type="text" name="NOMBRE_DEL_EJECUTIVO" value="'.$row["NOMBRE_DEL_EJECUTIVO"].'"></td>
</tr>



<tr>

<td width="30%" style="font-weight:bold;"><label>OBSERVACIONES</label></td>
<td width="70%"><input type="text" name="OBSERVACIONES_1" value="'.$row["OBSERVACIONES_1"].'"></td>
</tr>
<tr>

<td width="30%" style="font-weight:bold;" ><label>ADJUNTAR ARCHIVO RELACIONADO A ESTE GASTO</label></td>
<td width="70%">	<div id="drop_file_zone" ondrop="upload_file2(event,\'ADJUNTAR_ARCHIVO_1\')" ondragover="return false" style="width:300px;">
<p>Suelta aquí o busca tu archivo</p>
<p><input class="form-control form-control-sm" id="ADJUNTAR_ARCHIVO_1" type="text" onkeydown="return false" onclick="file_explorer2(\'ADJUNTAR_ARCHIVO_1\');" style="width:250px;" VALUE="'.$row["ADJUNTAR_ARCHIVO_1"] .' " required /></p>
<input type="file" name="ADJUNTAR_ARCHIVO_1" id="nono"/>
<div id="3ADJUNTAR_ARCHIVO_1">
'.$ADJUNTAR_ARCHIVO_1.'
</tr>



<tr><td colspan=2>
<table id="reseteaxml" style="width:100%;">'.$campos_xml.'</table>
</td></tr>


<tr>
<td width="30%" ><label>FECHA DE ÚLTIMA CARGA:</label></td>
<td width="70%"><input type="text" readonly=»readonly» style="background:#decaf1" name="FECHA_DE_LLENADO" value="'.$row["FECHA_DE_LLENADO"].'"></td>
</tr>
</table>
<tr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <td width="30%"><label><strong style="font-size:22px;"></strong></label></td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <td width="70%" class="align-middle">
        <!-- Botón GUARDAR -->
        <button class="btn btn-sm btn-outline-success px-5" type="button" id="clickPAGOP">GUARDAR</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <!-- Mensaje/respuesta al lado -->
      
        <div id="respuestaser" class="d-inline-block ms-3" style="
    color: #f5f5f5;
    text-shadow: 1px 1px 1px #919191,
        1px 2px 1px #919191,
        1px 3px 1px #919191,
        1px 4px 1px #919191,
        1px 5px 1px #919191,
        1px 6px 1px #919191,
        1px 7px 1px #919191,
        1px 8px 1px #919191,
        1px 9px 1px #919191,
        1px 10px 1px #919191,
    1px 18px 6px rgba(16,16,16,0.4),
    1px 22px 10px rgba(16,16,16,0.2),
    1px 25px 35px rgba(16,16,16,0.2),
    1px 30px 60px rgba(16,16,16,0.4);
        @keyframes fadeIn {
  0% { opacity: 0; }
  100% { opacity: 100; }
}"></div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

        <!-- Botón CERRAR al lado -->
        <button class="btn btn-sm btn-outline-success px-5" type="button" data-bs-dismiss="modal">CERRAR</button>

   <input type="hidden" value="ENVIARPAGOprovee" name="ENVIARPAGOprovee"/>
        <input type="hidden" value="'.$identioficador.'" name="IPpagoprovee" id="IPpagoprovee"/>
    </td>
</tr>


     ';
    }
    $output .= '</table></div></form>
	
	
	';
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

    success:function(data){
	
		if($.trim(data)=='Ingresado' || $.trim(data)=='Actualizado'){
				

			
			$.getScript(load(1));			
			$("#respuestaser").html("<span id='ACTUALIZADO' >"+data+"</span>");
			 $('#respuestaser2').html("<span id='ACTUALIZADO' >"+data+"</span>");
                     setTimeout(function() {
                    $("#respuestaser").fadeOut(300, function() {
                        $(this).html('').show();
                    });
                    $("#respuestaser2").fadeOut(300, function() {
                        $(this).html('').show();
                    });
                }, 2000);
			}
			
			else{
				
			$("#respuestaser").html(data);
			
		}
    }  
   });
   
});

		});
		
		

		
	</script>