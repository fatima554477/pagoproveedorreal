

<?php
/*
fecha sandor: 
fecha fatis : 15/04/2025
*/
?>



<?php
$connecDB = $conexion->db();



 $_SESSION['where'] = ISSET($_SESSION['where'])?$_SESSION['where']: " WHERE idRelacion = '".$_SESSION['idPROV']."' ";
 $_SESSION['where2'] = '';
 $_SESSION['where'] = " WHERE idRelacion = '".$_SESSION['idPROV']."' ";
 $results = mysqli_query($connecDB,"SELECT COUNT(*) FROM 02SUBETUFACTURA ".$_SESSION['where']." order by id desc  ");

$get_total_rows = mysqli_fetch_array($results); //total records
$item_per_page = 7;

$pages = ceil($get_total_rows[0]/$item_per_page);


?>
<script type="text/javascript" src="inventario/js/jquery-1.11.2.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {
	
	$("#results").load("subirfactura/fetch_pagesSF.php");  //initial page number to load
	
	$(".pagination").bootpag({
	   total: <?php echo $pages; ?>,
	   page: 1,
	   maxVisible: 5 
	}).on("page", function(e, num){
		e.preventDefault();
		$("#results").prepend('<div class="loading-indication"><img src="inventario/ajax-loader.gif" /> Cargando datos...</div>');
		$("#results").load("subirfactura/fetch_pagesSF.php", {'page':num});
	});

});


function calcular() {
    const numberNoCommas = (x) => {
        return x.toString().replace(/,/g, "");
    }

    const numberWithCommas = (x) => {
        //return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
		const num = parseFloat(x);
		if (isNaN(num)) return '';
		return num.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function formatInputPreservingCursor(inputElement, value) {
        const originalValue = inputElement.value;
        const cursorPos = inputElement.selectionStart;

        const commasBefore = originalValue.slice(0, cursorPos).split(',').length - 1;

        const formattedValue = numberWithCommas(value);
        inputElement.value = formattedValue;

        let newCursorPos = cursorPos - commasBefore;
        let i = 0, charsPassed = 0;
        while (charsPassed < newCursorPos && i < formattedValue.length) {
            if (formattedValue[i] !== ',') {
                charsPassed++;
            }
            i++;
        }
        inputElement.setSelectionRange(i, i);
    }

    // Listener para inputs tipo .tol
    const inputs = document.querySelectorAll(".total");

    inputs.forEach(input => {
        input.addEventListener("keydown", function (e) {
            const keyCode = e.keyCode || e.which;

            // Teclas numéricas (teclado principal del 0 al 9 o numpad 0 al 9)
            const isNumberKey =
                (keyCode >= 48 && keyCode <= 57) || // Teclado principal
                (keyCode >= 96 && keyCode <= 105) ||
				(keyCode === 46) ||
				(keyCode === 8 );  // Numpad

            if (isNumberKey) {
                // Esperar a que el valor se actualice antes de formatear
                setTimeout(() => {
                    const arr = document.getElementsByClassName("total");

                    let MONTO_PROPINA_elem = document.getElementsByName("MONTO_PROPINA")[0];
                    let MONTO_FACTURA_elem = document.getElementsByName("MONTO_FACTURA")[0];
                    let IVA_elem = document.getElementsByName("IVA")[0];
                    let IMPUESTO_HOSPEDAJE_elem = document.getElementsByName("IMPUESTO_HOSPEDAJE")[0];
					
                    let MONTO_PROPINA2 = numberNoCommas(MONTO_PROPINA_elem.value);
                    let MONTO_FACTURA2 = numberNoCommas(MONTO_FACTURA_elem.value);
                    let IVA2 = numberNoCommas(IVA_elem.value);
                    let IMPUESTO_HOSPEDAJE2 = numberNoCommas(IMPUESTO_HOSPEDAJE_elem.value);
					
                    /*let tot = 0;
                    for (let i = 0; i < arr.length; i++) {
                        if (parseFloat(numberNoCommas(arr[i].value)))
							
                            tot += parseFloat(numberNoCommas(arr[i].value));
							
                    }*/
					let tot = 0;
					for (let i = 0; i < arr.length; i++) {
						const inputName = arr[i].getAttribute("name");
						const value = parseFloat(numberNoCommas(arr[i].value)) || 0;

						if (["TImpuestosRetenidosIVA", "TImpuestosRetenidosISR", "descuentos"].includes(inputName)) {
							tot -= value; // Se RESTA
						} else {
							tot += value; // Se SUMA
						}
					}
					
					
                    formatInputPreservingCursor(document.getElementById('MONTO_DEPOSITAR'), tot);
                    formatInputPreservingCursor(MONTO_PROPINA_elem, MONTO_PROPINA2);
                    formatInputPreservingCursor(MONTO_FACTURA_elem, MONTO_FACTURA2);
                    formatInputPreservingCursor(IVA_elem, IVA2);
                    formatInputPreservingCursor(IMPUESTO_HOSPEDAJE_elem, IMPUESTO_HOSPEDAJE2);					
                }, 0);
            }
        });
    });
}

// Ejecutamos todo cuando cargue el DOM
document.addEventListener("DOMContentLoaded", calcular);


document.addEventListener("DOMContentLoaded", function () {

    const numeroEventoInput = document.querySelector('input[name="NUMERO_EVENTO"]');

    const nombreReceptorInput = document.querySelector('input[name="DATOS_DE_EPC_INNOVACC_JUST"]');



    if (!numeroEventoInput || !nombreReceptorInput) {

        return;

    }



    const prefijosNumeroEvento = {

        "EVENTOS PROMOCIONES Y CONVENCIONES": "EPC",

        "INNOVA CONGRESOS Y CONVENCIONES": "INN",

        "EVENTOS 520": "EVE"

    };



    const nombreReceptor = nombreReceptorInput.value.trim();

    const prefijo = prefijosNumeroEvento[nombreReceptor];



    if (prefijo && numeroEventoInput.value.trim() === "") {

        numeroEventoInput.value = prefijo;

    }

});

      
      
      $(document).on('change','input[type="checkbox"]' ,function(e) {
          if(this.id=="MONTO_DEPOSITAR1") {
              if(this.checked) $('#FECHA_AUTORIZACION_RESPONSABLE').val(this.value);
              else $('#FECHA_AUTORIZACION_RESPONSABLE').val("");
          }
        
      });
	  
      $(document).on('change','input[type="checkbox"]' ,function(e) {
          if(this.id=="MONTO_DEPOSITAR2") {
              if(this.checked) $('#FECHA_AUTORIZACION_AUDITORIA').val(this.value);
              else $('#FECHA_AUTORIZACION_AUDITORIA').val("");
          }
        
      });
	  
      $(document).on('change','input[type="checkbox"]' ,function(e) {
          if(this.id=="MONTO_DEPOSITAR3") {
              if(this.checked) $('#FECHA_DE_LLENADO').val(this.value);
              else $('#FECHA_DE_LLENADO').val("");
          }
        
      });
      
      
      </script>

<!--<link href="inventario/css/style2.css" rel="stylesheet" type="text/css">-->





<div id="content">     
			<hr/>
	<strong> <P class="mb-0 text-uppercase">
<img src="includes/contraer31.png" id="mostrar101" style="cursor:pointer;"/>
<img src="includes/contraer41.png" id="ocultar101" style="cursor:pointer;"/>&nbsp;&nbsp;&nbsp;SUBE TU FACTURA</p></strong></div>


<div  id="mensajeSUBIRFACTURA2">
<div class="progress" style="width: 25%;">
									<div class="progress-bar" role="progressbar" style="width: <?php echo $contactosventasproveedoresporcentaje ; ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?php echo $contactosventasproveedoresporcentaje ; ?>%</div></div></div>


	        <div id="target101" style="display:block;"  class="content2">
        <div class="card">
          <div class="card-body">

  
	<form class="row g-3 needs-validation was-validated" novalidate="" id="SUBIRFACTURAform" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
	
	          
  <table  style="border-collapse: collapse;" border="1" class="table mb-0 table-striped">

				  
                  <tr>
           
                <th scope="col">FACTURA </th>
                <th scope="col">DATOS</th> 
                </tr>
				
				
				 
                 <tr  style="background: #d2faf1" > 
                 <th scope="row"> <label for="validationCustom03" class="form-label">ADJUNTAR FACTURA(FORMATO &nbsp;<a style="color:red;font:12px">(XML)</a></label></th>
                 <td>
				 
	

		<div id="drop_file_zone" ondrop="upload_file(event,'ADJUNTAR_FACTURA_XML')" ondragover="return false" >
		<p>Suelta aquí o busca tu archivo</p>
		<p><input class="form-control form-control-sm" id="ADJUNTAR_FACTURA_XML" type="text" onkeydown="return false" onclick="file_explorer('ADJUNTAR_FACTURA_XML');"  VALUE="<?php echo $ADJUNTAR_FACTURA_XML; ?>" required /></p>
		<input type="file" name="ADJUNTAR_FACTURA_XML" id="nono"/>
		<div id="1ADJUNTAR_FACTURA_XML">
		<?php
		if($ADJUNTAR_FACTURA_XML!=""){echo "<a target='_blank' href='includes/archivos/".$ADJUNTAR_FACTURA_XML."'></a>"; 
		}?></div>
		</div>
		
	</div>
				 
<div id="2ADJUNTAR_FACTURA_XML"><?php 


$listadosube = $SUBEFACTURA->Listado_subefacturadocto('ADJUNTAR_FACTURA_XML');

while($rowsube=mysqli_fetch_array($listadosube)){
	echo "<a target='_blank' href='includes/archivos/".$rowsube['ADJUNTAR_FACTURA_XML']."' id='A".$rowsube['id']."' >Visualizar!</a> "." <span id='".$rowsube['id']."' class='view_dataSBborrar2' style='cursor:pointer;color:blue;'>Borrar!</span> <span > ".$rowsube['fechaingreso']."</span>".'<br/>';		
	
}
	$NUMERO_CONSECUTIVO_PROVEE = '';

	$FECHA_DE_PAGO = '';

	$NUMERO_EVENTO = '';

	$regreso = $SUBEFACTURA->variable_SUBETUFACTURA();
$url = '';



if (is_array($regreso) && isset($regreso['ADJUNTAR_FACTURA_XML'])) {

		$NUMERO_EVENTO = isset($regreso['NUMERO_EVENTO']) ? $regreso['NUMERO_EVENTO'] : '';
		$FECHA_DE_PAGO = isset($regreso['FECHA_DE_PAGO']) ? $regreso['FECHA_DE_PAGO'] : '';

		$url = __ROOT1__.'/includes/archivos/'.$regreso['ADJUNTAR_FACTURA_XML'];

	}

if( $url && file_exists($url) ){

	$regreso = $conexion2->lectorxml($url);
	
	$Version = $regreso['Version'];
	$sello = $regreso['selo'];
	$Certificado = $regreso['Certificado'];
	$noCertificado = $regreso['noCertificado'];
	$fecha = $regreso['fecha'];
	$tipoDeComprobante = $regreso['tipoDeComprobante'];
	$metodoDePago = $regreso['metodoDePago'];
	$formaDePago = $regreso['formaDePago'];
	$condicionesDePago = $regreso['condicionesDePago'];
	$subTotal = $regreso['subTotal'];
	$TipoCambio = $regreso['TipoCambio'];
	$Moneda = $regreso['Moneda'];
	$total = $regreso['total'];
	$serie = $regreso['serie'];
	$folio = $regreso['folio'];
	$LugarExpedicion = $regreso['LugarExpedicion'];
	
	$rfcE = $regreso['rfcE'];					
	$nombreE = $regreso['nombreE'];	
	$regimenE = $regreso['regimenE'];
	$Descuento = $regreso['Descuento'];
	
	$rfcR = $regreso['rfcR'];
	$nombreR = $regreso['nombreR'];
	$UsoCFDI = $regreso['UsoCFDI'];
	$DomicilioFiscalReceptor = $regreso['DomicilioFiscalReceptor'];
	$RegimenFiscalReceptor = $regreso['RegimenFiscalReceptor'];
	
	$UUID = $regreso['UUID'];
	$selloCFD = $regreso['selloCFD'];
	$noCertificadoSAT = $regreso['noCertificadoSAT'];	
	$FechaTimbrado = $regreso['FechaTimbrado'];
	$RfcProvCertif = $regreso['RfcProvCertif'];	
	$TImpuestosRetenidos = $regreso['TImpuestosRetenidos'];
	$TImpuestosTrasladados = $regreso['TImpuestosTrasladados'];
    $prefijosNumeroEvento = $regreso['NUMERO_EVENTO'];
	$Cantidad = $regreso['Cantidad'];
	$ValorUnitario = $regreso['ValorUnitario'];
	$Importe = $regreso['Importe'];
	$ClaveProdServ = $regreso['ClaveProdServ'];
	$Unidad = $regreso['Unidad'];
	$Descripcion = $regreso['Descripcion'];
	$ClaveUnidad = $regreso['ClaveUnidad'];
	$NoIdentificacion = $regreso['NoIdentificacion'];
	$ObjetoImp = $regreso['ObjetoImp'];
    $impueRdesglosado002 = $regreso['impueRdesglosado002'];
	$impueRdesglosado001 = $regreso['impueRdesglosado001'];

	/*nuevo*/

	$fechaInicio=strtotime(date('Y-m-d'));
	$FECHA_domingo = date('Y-m-d', strtotime('next monday', $fechaInicio));
	$FECHA_jueves = date('Y-m-d', strtotime('next Thursday', strtotime($FECHA_domingo)));
	if(trim((string)$FECHA_DE_PAGO) === ''){
		$FECHA_DE_PAGO = $FECHA_jueves;//'2023-08-03';//. $conexion2->fechaEs($FECHA_jueves);
	}



	/*nuevo*/
	
	$NUMERO_CONSECUTIVO_PROVEE = $SUBEFACTURA->select_02XML()+1;
	
}

$prefijosNumeroEvento = [
        'EVENTOS PROMOCIONES Y CONVENCIONES' => 'EPC',
        'INNOVA CONGRESOS Y CONVENCIONES' => 'INN',
        'EVENTOS 520' => 'EVE',
];

if (isset($nombreR) && isset($prefijosNumeroEvento[$nombreR]) && trim((string)$NUMERO_EVENTO) === '') {
        $NUMERO_EVENTO = $prefijosNumeroEvento[$nombreR];
}

?></div>			 
				 			 
				 </td>
                 </tr>
                 <tr style="background: #d2faf1">
                 <th scope="row"> <label for="validationCustom03" class="form-label">ADJUNTAR FACTURA (FORMATO PDF)</label></th>
				 
				 
                 <td style="width: 600px;">
			 
				 
	  

		<div id="drop_file_zone" ondrop="upload_file(event,'ADJUNTAR_FACTURA_PDF')" ondragover="return false" >
		<p>Suelta aquí o busca tu archivo</p>
		<p><input class="form-control form-control-sm" id="ADJUNTAR_FACTURA_PDF" type="text" onkeydown="return false" onclick="file_explorer('ADJUNTAR_FACTURA_PDF');"  VALUE="<?php echo $ADJUNTAR_FACTURA_PDF; ?>" required /></p>
		<input type="file" name="ADJUNTAR_FACTURA_PDF" id="nono"/>
		<div id="1ADJUNTAR_FACTURA_PDF">
		<?php
		if($ADJUNTAR_FACTURA_PDF!=""){echo "<a target='_blank' href='includes/archivos/".$ADJUNTAR_FACTURA_PDF."'></a>"; 
		}?></div>
		</div>
		
	</div>
				 
<div id="2ADJUNTAR_FACTURA_PDF"><?php 

$listadosube = $SUBEFACTURA->Listado_subefacturadocto('ADJUNTAR_FACTURA_PDF');

while($rowsube=mysqli_fetch_array($listadosube)){
	echo "<a target='_blank' href='includes/archivos/".$rowsube['ADJUNTAR_FACTURA_PDF']."' id='A".$rowsube['id']."' >Visualizar!</a> "." <span id='".$rowsube['id']."' class='view_dataSBborrar2' style='cursor:pointer;color:blue;'>Borrar!</span> <span > ".$rowsube['fechaingreso']."</span>".'<br/>';		
	
}

?></div>			 			 
				 </td>
                 </tr>
				 
                 <tr  style="background:#fcf3cf"> 
                 <th scope="row"> <label for="validationCustom03" class="form-label">NÚMERO DE SOLICITUD</label></th>
                 <td>
				 <div id="NUMERO_CONSECUTIVO_PROVEE2">
				 <input type="text" class="form-control" id="NUMERO_CONSECUTIVO_PROVEE" required=""  value="<?php echo $NUMERO_CONSECUTIVO_PROVEE; ?>" name="NUMERO_CONSECUTIVO_PROVEE" placeholder="NÚMERO DE SOLICITUD" readonly="readonly">
				 </div>
				 </td>
                 </tr>
				 
				 <tr style="background: #d2faf1"> 
                 <th scope="row"> <label for="validationCustom03" class="form-label">NOMBRE COMERCIAL<br><a style="color:red;font-size:11px">OBLIGATORIO</a></label></th>
                 <td>
				 <div >
	<input type="text" class="form-control"  id="nommbrerazon" required=""  value="<?php echo $_SESSION["USUARIO_CRM"]; ?>" name="NOMBRE_COMERCIAL" placeholder="NOMBRE COMERCIAL" readonly="readonly"></div></td>
                 </tr>  
				 
				 
				  <input type="hidden" name="VIATICOSOPRO" value="PAGO A PROVEEDOR">
				                   <tr  style="background:#fcf3cf"> 
                 <th scope="row"> <label for="validationCustom03" class="form-label">RAZÓN SOCIAL</label></th>
                 <td>
				 <div id="RAZON_SOCIAL2">
				 <input type="text" class="form-control" id="RAZON_SOCIAL" required=""  value="<?php echo $P_NOMBRE_FISCAL_RS_EMPRESA; ?>" name="RAZON_SOCIAL"  placeholder="RAZÓN SOCIAL"  readonly="readonly">
				 </div>
				 </td>
                 </tr>

					<div id="FECHA_DE_PAGO2">
							<input type="hidden" class="form-control" id="FECHA_DE_PAGO2" required="" value="<?php echo $FECHA_DE_PAGO; ?>" name="FECHA_DE_PAGO" placeholder="FECHA DE PAGO">

                 <tr  style="background:#fcf3cf"> 
                 <th scope="row"> <label for="validationCustom03" class="form-label">RFC DEL PROVEEDOR:</label></th>
                 <td>
				 <div id="RFC_PROVEEDOR2">
				 <input type="text" class="form-control" id="RFC_PROVEEDOR" required=""  value="<?php echo $P_RFC_MTDP; ?>" name="RFC_PROVEEDOR" placeholder="RFC DEL PROVEEDOR" readonly="readonly">
				 </div>
				 </td>
				 
				 
				 
                 </tr>
				 
				 
                 <tr style="background: #d2faf1">
                 <th scope="row"> <label for="validationCustom03" class="form-label">AGREGA EL No. DE EVENTO:<br><a style="color:red;font-size:11px">OBLIGATORIO</a></label></th>
				  
        <td><div id="NUMERO_EVENTO2"><input type="text" class="form-control"  required=""  value="<?php echo $NUMERO_EVENTO; ?>" name="NUMERO_EVENTO" placeholder="No. DE EVENTO"></td>
                 </tr>

                
                 <tr style="background:#fcf3cf"> 
                 <th scope="row"> <label for="validationCustom03" class="form-label">CONCEPTO:</label></th>
                 <td>
				 <div id="CONCEPTO_PROVEE2">
				 <input type="text" class="form-control" id="CONCEPTO_PROVEE" required=""  value="<?php echo $Descripcion; ?>" name="CONCEPTO_PROVEE"placeholder="CONCEPTO " readonly="readonly">
				 </div>
				 </td>
                 </tr>
                 <tr style="background: #d2faf1">  

                 <th scope="row"> <label for="validationCustom03" class="form-label">MONTO TOTAL DE LA COTIZACIÓN O DEL ADEUDO CON IMPUESTOS<br><a style="color:red;font-size:11px">OBLIGATORIO</a></label></th>
                 <td>    <div class="input-group mb-3"> <span class="input-group-text">$</span> <input type="text" class="form-control" id="validationCustom03" required=""  value="<?php echo $MONTO_TOTAL_COTIZACION_ADEUDO; ?>" name="MONTO_TOTAL_COTIZACION_ADEUDO"  onkeyup="comasainput2('MONTO_TOTAL_COTIZACION_ADEUDO')" placeholder="MONTO TOTAL DE LA COTIZACÓN"></div></td>
                 </tr>
				 
				 
                 <tr style="background: #d2faf1"> 

  <th scope="row"> <label for="validationCustom03" class="form-label">ADJUNTAR COTIZACIÓN O REPORTE (CUALQUIER FORMATO VARIOS ARCHIVOS)<br><a style="color:red;font-size:11px">OBLIGATORIO</a></label></th>
                 <td>


		<div id="drop_file_zone" ondrop="upload_file(event,'ADJUNTAR_COTIZACION')" ondragover="return false" >
		<p>Suelta aquí o busca tu archivo</p>
		<p><input class="form-control form-control-sm" id="ADJUNTAR_COTIZACION" type="text" onkeydown="return false" onclick="file_explorer('ADJUNTAR_COTIZACION');"  VALUE="<?php echo $ADJUNTAR_COTIZACION; ?>" required /></p>
		<input type="file" name="ADJUNTAR_COTIZACION" id="nono"/>
		<div id="1ADJUNTAR_COTIZACION">
		<?php
		if($ADJUNTAR_COTIZACION!=""){echo "<a target='_blank' href='includes/archivos/".$ADJUNTAR_COTIZACION."'></a>"; 
		}?></div>
		</div>
		
	</div>
				 
				 <div id="2ADJUNTAR_COTIZACION"><?php $listadosube = $SUBEFACTURA->Listado_subefacturadocto('ADJUNTAR_COTIZACION');

while($rowsube=mysqli_fetch_array($listadosube)){
	echo "<a target='_blank' href='includes/archivos/".$rowsube['ADJUNTAR_COTIZACION']."' id='A".$rowsube['id']."' >Visualizar!</a> "." <span id='".$rowsube['id']."' class='view_dataSBborrar2' style='cursor:pointer;color:blue;'>Borrar!</span><span > ".$rowsube['fechaingreso']."</span>".'<br/>';	
}


				 ?></div>				 
				 </td>
				             </tr>
              
            <tr style="background:#fcf3cf">

<th scope="row"> <label for="validationCustom03" class="form-label">SUBTOTAL:</label></th>


 <td><div id="2MONTO_FACTURA"> <div class="input-group mb-3"> <span class="input-group-text">$</span> <input type="text"  style="width:300px;height:40px;"  id="MONTO_FACTURA" required="" onkeyup="calcular()"   value="<?php echo $subTotal; ?>" name="MONTO_FACTURA" class="total" placeholder="SUB TOTAL"></td>
</div></div>
</td>
</tr>

            <tr style="background:#fcf3cf">

<th scope="row"> <label for="validationCustom03" class="form-label">IVA:</label></th>
 <td><div id="2IVA"> <div class="input-group mb-3"> <span class="input-group-text">$</span> <input type="text"  style="width:300px;height:40px;"  id="total"  onkeyup="calcular()" value="<?php echo $TImpuestosTrasladados; ?>" name="IVA" class="total" placeholder="IVA"></td>
</div></div>
</td>
</tr>

			<tr style="background:#fcf3cf">
            <th scope="row"> <label  style="width:300px" for="validationCustom03" class="form-label">IMPUESTOS RETENIDOS &nbsp;<a style="color:red;font:12px">(IVA)</a></label></th>               				 
				 <td> 				 
				<div id="2TImpuestosRetenidosIVA">			 
     <div class="input-group mb-3"> <span class="input-group-text">$</span> <input type="text"  style="width:300px;height:40px;"  id="TImpuestosRetenidosIVA" required=""    name="TImpuestosRetenidosIVA"  value="<?php echo $impueRdesglosado002; ?>" class="total" placeholder="IMPUESTOS RETENIDOS IVA">
				
				</div></div>
				 </td>
                 </tr>
				 
				 
				<tr style="background:#fcf3cf">
            <th scope="row"> <label  style="width:300px" for="validationCustom03" class="form-label">IMPUESTOS RETENIDOS &nbsp;<a style="color:red;font:12px">(ISR)</a></label></th>               				 
				 <td> 				 
				<div id="2TImpuestosRetenidosISR">			 
     <div class="input-group mb-3"> <span class="input-group-text">$</span> <input type="text"  style="width:300px;height:40px;"  id="TImpuestosRetenidosISR" required=""    name="TImpuestosRetenidosISR"  value="<?php echo $impueRdesglosado001; ?>" class="total" placeholder="IMPUESTOS RETENIDOS ISR">
				
				</div></div>
				 </td>
                 </tr>

<tr style="background:#fcf3cf">

<th scope="row"> <label  style="width:300px" for="validationCustom03" class="form-label"><a style="color:red;font:12px">FAVOR DE PONER EL:&nbsp;</a>MONTO DE LA PROPINA O SERVICIO ESTÉ INCLUIDO O NO EN LA FACTURA</label></th>

<div>
 <td> <div class="input-group mb-3"> <span class="input-group-text">$</span> <input type="text"  style="width:300px;height:40px;"  id="total" required="" onkeyup="calcular()"   value="<?php echo $MONTO_PROPINA; ?>" name="MONTO_PROPINA" class="total" placeholder="MONTO DE LA PROPINA"></td>
</div></div>
</td>
</tr>
                 <tr style="background: #d2faf1">
                 <th scope="row"> <label  style="width:300px" for="validationCustom03" class="form-label"><a style="color:red;font:12px">FAVOR DE PONER EL:&nbsp;</a> IMPUESTO SOBRE <BR>HOSPEDAJE MÁS EL IMPUESTO DE SANEAMIENTO:</label></th>			
				 <td>
				 <div class="input-group mb-3"> <span class="input-group-text">$</span> <input type="text" class="total"  style="width:300px;height:40px;"  id="total" required=""  onkeyup="calcular()"   value="<?php echo $IMPUESTO_HOSPEDAJE; ?>" name="IMPUESTO_HOSPEDAJE"placeholder="IMPUESTO HOSPEDAJE">
			
				 
				 </td>
                 </tr></div>
			<tr style="background:#fcf3cf">
            <th scope="row"> <label  style="width:300px" for="validationCustom03" class="form-label">DESCUENTO:</label></th>               				 
				 <td> 				 
				<div id="2descuentos">			 
     <div class="input-group mb-3"> <span class="input-group-text">$</span> <input type="text"  style="width:300px;height:40px;"  id="descuentos" required=""    name="descuentos"  value="<?php echo $Descuento; ?>" class="total" placeholder="DESCUENTO">
				
				</div></div>
				 </td>
                 </tr>				 

                 <tr style="background: #fcf3cf"> 
                 <th scope="row"> <label for="validationCustom03" class="form-label">TOTAL:</label></th>
                 <td>
				 <div id="2MONTO_DEPOSITAR">
             <div class="input-group mb-3"> <span class="input-group-text">$</span>  <input type="text" class="form-control" id="MONTO_DEPOSITAR" required="" value="<?php echo $total;?>"  name="MONTO_DEPOSITAR"  placeholder="TOTAL" readonly="»readonly»">
				 </div></div>
				 </td>
                 </tr>


                 <!-- <tr  style="background: #d2faf1" > 				 
                  <th scope="row"> <label  style="width:300px" for="validationCustom03" class="form-label">MONTO DEPOSITADO:</label></th>
                 <td>
				 
				 <div>
             <div class="input-group mb-3"> <span class="input-group-text">$</span><input type="text" class="form-control" id="MONTO_DEPOSITADO" required=""   value="<?php echo $MONTO_DEPOSITADO; ?>" name="MONTO_DEPOSITADO" onkeyup="comasainput('MONTO_DEPOSITADO')"  placeholder="MONTO DEPOSITADO" readonly="»readonly»">
				</div> </div>
				 </td>
                 </tr> -->

                 <!-- <tr style="background:#fcf3cf">  
                 <th scope="row"> <label  style="width:300px" for="validationCustom03" class="form-label">PENDIENTE DE PAGO DE LA COTIZACÍON:</label></th>
                 <td>
				 
				 <div>
             <div class="input-group mb-3"> <span class="input-group-text">$</span><input type="text" class="form-control" id="PENDIENTE_PAGO" required=""   value="<?php// echo $PENDIENTE_PAGO; ?>" name="PENDIENTE_PAGO" onkeyup="comasainput('PENDIENTE_PAGO')"  placeholder="PENDIENTE DE PAGO" disabled>
				
				 </td>
                 </tr> </div> </div> -->

				 
				 <tr style="background:#fcf3cf">
                 <th scope="row"> <label for="validationCustom03" class="form-label">TIPO DE MONEDA O DIVISA:</label></th>
              
				
				            
             <td> <div id="TIPO_DE_MONEDA2"><select class="form-select mb-3" aria-label="Default select example" id="validationCustom02" required="" name="TIPO_DE_MONEDA"  > 
                         <option style="background: #c9e8e8" value="MXN" <?php if($Moneda=='MXN'){echo "selected";} ?>>MXN (Peso mexicano)</option>
                         <option style="background: #a3e4d7" value="USD" <?php if($Moneda=='USD'){echo "selected";} ?>>USD (Dolar)</option>
                         <option style="background: #e8f6f3" value="EUR" <?php if($Moneda=='EUR'){echo "selected";} ?>>EUR (Euro)</option>
                         <option style="background: #fdf2e9" value="GBP" <?php if($Moneda=='GBP'){echo "selected";} ?>>GBP (Libra esterlina)</option>
                         <option style="background: #eaeded" value="CHF" <?php if($Moneda=='CHF'){echo "selected";} ?>>CHF (Franco suizo)</option>
                         <option style="background: #fdebd0" value="CNY" <?php if($Moneda=='CNY'){echo "selected";} ?>>CNY (Yuan)</option>
                         <option style="background: #ebdef0" value="JPY" <?php if($Moneda=='JPY'){echo "selected";} ?>>JPY (Yen japonés)</option>
                         <option style="background: #d6eaf8" value="HKD" <?php if($Moneda=='HKD'){echo "selected";} ?>>HKD (Dólar hongkonés)</option>
                         <option style="background: #fef5e7" value="CAD" <?php if($Moneda=='CAD'){echo "selected";} ?>>CAD (Dólar canadiense)</option>
                         <option style="background: #ebedef" value="AUD" <?php if($Moneda=='AUD'){echo "selected";} ?>>AUD (Dólar australiano)</option>
                         <option style="background: #fbeee6" value="BRL" <?php if($Moneda=='BRL'){echo "selected";} ?>>BRL (Real brasileño)</option>
                         <option style="background: #e8f6f3" value="RUB" <?php if($Moneda=='RUB'){echo "selected";} ?>>RUB  (Rublo ruso)</option>

                         </select> 
                      
                          </div>
                          </div> </td>
                 </tr>
				 
                 <tr style="background:#fcf3cf">

                 <th><label style="width: 300px"  class="form-label">FORMA DE PAGO:</label></th>
				 
				 
             <td style="width: 45%;">



<div id="2PFORMADE_PAGO">



       <select name="PFORMADE_PAGO"  class="form-select mb-3"  id="validationCustom02" aria-label="Default select example">
                  
					<script type="text/javascript">  function EFECTIVO (texto) {    alert(texto);} </script>
                   
				 <option style="background:#f2b4f5"  name="PFORMADE_PAGO" value="03">03 TRANSFERENCIA ELECTRONICA DE FONDOS</option>	
		     <option style="background:#f2b4f5"  <?php if($formaDePago=='03'){echo "selected";} ?> value="03" name="PFORMADE_PAGO">03 TRANSFERENCIA ELECTRONICA DE FONDOS</option>	
					
					
              <option style="background:#dee6fc"  <?php if($formaDePago=='04'){echo "selected ";} ?> value="04" onclick="EFECTIVO('FAVOR DE SOLICITAR EL CAMBIO DE FACTURA POR NO COINCIDIR CON LA FORMA DE PAGO');" name="PFORMADE_PAGO">04 TARJETA DE CREDITO</option>
            

        
              <option style="background:#ddf5da"   <?php if($formaDePago=='01'){echo "selected";} ?>  value="01 EFECTIVO"   onclick="EFECTIVO('FAVOR DE SOLICITAR EL CAMBIO DE FACTURA POR NO COINCIDIR CON LA FORMA DE PAGO');" name="PFORMADE_PAGO">01 EFECTIVO</option>
        
              <option style="background:#fceade" <?php if($formaDePago=='02'){echo "selected";} ?> value="02" onclick="EFECTIVO('FAVOR DE SOLICITAR EL CAMBIO DE FACTURA POR NO COINCIDIR CON LA FORMA DE PAGO');" name="PFORMADE_PAGO">02 CHEQUE NOMITATIVO</option>
        

        
              <option style="background:#f6fcde" <?php if($formaDePago=='05'){echo "selected";} ?> value="05" onclick="EFECTIVO('FAVOR DE SOLICITAR EL CAMBIO DE FACTURA POR NO COINCIDIR CON LA FORMA DE PAGO');">05 MONEDERO ELECTRONICO</option>
        
              <option style="background:#dee2fc" <?php if($formaDePago=='06'){echo "selected";} ?> value="06" onclick="EFECTIVO('FAVOR DE SOLICITAR EL CAMBIO DE FACTURA POR NO COINCIDIR CON LA FORMA DE PAGO');">06 DINERO ELECTRONICO</option>
        
              <option style="background:#f9e5fa" <?php if($formaDePago=='08'){echo "selected";} ?> value="08" onclick="EFECTIVO('FAVOR DE SOLICITAR EL CAMBIO DE FACTURA POR NO COINCIDIR CON LA FORMA DE PAGO');">08 VALES DE DESPENSA</option>
        
              <option style="background:#eefcde" <?php if($formaDePago=='28'){echo "selected";} ?> value="28" onclick="EFECTIVO('FAVOR DE SOLICITAR EL CAMBIO DE FACTURA POR NO COINCIDIR CON LA FORMA DE PAGO');">28 TARJETA DE DEBITO</option>
        
              <option style="background:#fcfbde" <?php if($formaDePago=='29'){echo "selected";} ?> value="29" onclick="EFECTIVO('FAVOR DE SOLICITAR EL CAMBIO DE FACTURA POR NO COINCIDIR CON LA FORMA DE PAGO');">29 TARJETA DE SERVICIO</option>
        
              <option style="background:#f9e5fa" <?php if($formaDePago=='99'){echo "selected";} ?> value="99" onclick="EFECTIVO('FAVOR DE SOLICITAR EL CAMBIO DE FACTURA POR NO COINCIDIR CON LA FORMA DE PAGO');">99 OTRO</option>
        
              </select>
			  
        
    <div/>
        </td>

        </tr>
         
               
                 <tr style="background: #d2faf1" > 
                 <th scope="row">  <label for="validationCustom02" class="form-label">STATUS DE PAGO:</label></th>
                 <td>
				 
 <input type="text" class="form-control" id="STATUS_DE_PAGO" required=""  value="<?php echo 'SOLICITADO'; ?>" name="STATUS_DE_PAGO" placeholder="ESTATUS PAGO: SOLICITADO" readonly="»readonly»">
 

						 
						 </td>
                 </tr >


                 <tr   style="background: #d2faf1"> 

                 <th scope="row"> <label for="validationCustom03" class="form-label">NOMBRE DEL EJECUTIVO QUE SOLICITO O REALIZÓ LA COMPRA:<br><a style="color:red;font-size:11px">OBLIGATORIO</a></label></th>
                 <td><input type="text" class="form-control" id="validationCustom03" required=""  value="<?php echo $NOMBRE_DEL_EJECUTIVO; ?>" name="NOMBRE_DEL_EJECUTIVO"placeholder="NOMBRE DEL EJECUTIVO"></td>
                 </tr>
				 <tr style="background: #d2faf1">
				 				<th scope="row">
					<label for="validationCustom03" class="form-label">NOMBRE DEL QUE  INGRESO ESTA FACTURA:</label>
				</th>
				<td><input type="text" class="form-control" id="validationCustom03" required="" value="<?php echo $P_NOMBRE_FISCAL_RS_EMPRESA; ?>"  name="NOMBRE_DEL_AYUDO" placeholder="NOMBRE DEL EJECUTIVO" readonly="readonly">
				</td>
			</tr>
            
                 <tr  style="background: #d2faf1"> 

                 <th scope="row"> <label for="validationCustom03" class="form-label">OBSERVACIONES:</label></th>
                 <td><input type="text" class="form-control" id="validationCustom03" required=""  value="<?php echo $OBSERVACIONES_1; ?>" name="OBSERVACIONES_1"placeholder="OBSERVACIONES "></td>
                 </tr>
          
            
                 <!-- <tr style="background: #d2faf1">  

                 <th scope="row"> <label for="validationCustom03" class="form-label">ADJUNTAR ARCHIVO RELACIONADO A ESTE GASTO: (CUALQUIER FORMATO)</label></th>
                 <td>
				 	 
 
		<div id="drop_file_zone" ondrop="upload_file(event,'ADJUNTAR_ARCHIVO_1')" ondragover="return false" >
		<p>Suelta aquí o busca tu archivo</p>
		<p><input class="form-control form-control-sm" id="ADJUNTAR_ARCHIVO_1" type="text" onkeydown="return false" onclick="file_explorer('ADJUNTAR_ARCHIVO_1');"  VALUE="<?php echo $ADJUNTAR_ARCHIVO_1; ?>" required /></p>
		<input type="file" name="ADJUNTAR_ARCHIVO_1" id="nono"/>
		<div id="1ADJUNTAR_ARCHIVO_1">
		<?php
		if($ADJUNTAR_ARCHIVO_1!=""){echo "<a target='_blank' href='includes/archivos/".$ADJUNTAR_ARCHIVO_1."'></a>"; 
		}?></div>
		</div>
	</div>
				 
				 <div id="2ADJUNTAR_ARCHIVO_1"><?php 
	$listadosube = $SUBEFACTURA->Listado_subefacturadocto('ADJUNTAR_ARCHIVO_1');
	while($rowsube=mysqli_fetch_array($listadosube)){
	echo "<a target='_blank' href='includes/archivos/".$rowsube['ADJUNTAR_ARCHIVO_1']."'  id='A".$rowsube['id']."' >Visualizar!</a> "." <span id='".$rowsube['id']."' class='view_dataSBborrar2' style='cursor:pointer;color:blue;'>Borrar!</span><span > ".$rowsube['fechaingreso']."</span>".'<br/>';
	}
	?></div>	

				 </td> </tr>-->
 <input type="hidden" style="width:200px;" class="form-control" id="validationCustom03" value="<?php echo date('d-m-Y H:i:s'); ?>" name="FECHA_DE_LLENADO">
         
  <input type="hidden" id="FECHA_DE_PAGO" name="FECHA_DE_PAGO" value="<?php echo $FECHA_DE_PAGO; ?>">
         <input type="hidden" name="hiddensubefactura" value="hiddensubefactura">
		 
         
              
         	
 
	</table>

 
  
                   
						 
    	   
                
              

<BR/>
<BR/>

				       
                           <table  style="border-collapse:collapse;" border="1";  class="table mb-0 table-striped" id="resettabla">
	

                    <tr>
                    <th scope="col">FACTURA</th>
                    <th  scope="col">DATOS DE LA FACTURA</th>
                    </tr>

                   <tr>
                    <th scope="row"> <label for="validationCustom03" class="form-label">NOMBRE RECEPTOR:</label></th>
                 <td><input type="text" class="form-control" id="validationCustom03" required=""  value="<?php echo $nombreR; ?>" name="DATOS_DE_EPC_INNOVACC_JUST" placeholder="DATOS DE EPC, INNOVACC O JUST"readonly="readonly"></td>
                 </tr>
                 

                   <tr>
                    <th scope="row"> <label for="validationCustom03" class="form-label">RFC RECEPTOR:</label></th>
                 <td><input type="text" class="form-control" id="validationCustom03" required=""  value="<?php echo $rfcR; ?>" name="DATOS_DE_EPC_INNOVACC_JUST" placeholder="DATOS DE EPC, INNOVACC O JUST"readonly="readonly"></td>
                 </tr>
				 
             
                 
                    <tr>
                    <th scope="row"> <label for="validationCustom03" class="form-label">RAZÓN SOCIAL DEL PROVEEDOR:</label></th>
                 <td><input type="text" class="form-control" id="validationCustom03" required=""  value="<?php echo $nombreE; ?>" name="RAZON_SOCIAL_FACTURA" placeholder="RAZON SOCIAL DEL PROVEEDOR" readonly="readonly"></td>
                 </tr>

                 <tr>
                    <th scope="row"> <label for="validationCustom03" class="form-label">RFC:</label></th>
                 <td><input type="text" class="form-control" id="validationCustom03" required=""  value="<?php echo $rfcE; ?>" name="rfcE" placeholder="RFC" readonly="readonly"></td>
                 </tr>
                 
				 <tr>
                 <th scope="row"> <label for="validationCustom03" class="form-label">REGÍMEN FISCAL:</label></th>
                 <td><input type="text" class="form-control" id="validationCustom03" required=""  value="<?php echo $regimenE; ?>" name="RegimenFiscalReceptor" placeholder="REGIMEN FISCAL"readonly="readonly"></td>
                 </tr>
				 
		                 <tr>		 
                 <th scope="row"> <label for="validationCustom03" class="form-label">UUID:</label></th>
                 <td><input type="text" class="form-control" id="validationCustom03" required=""  value="<?php echo $UUID; ?>" name="UUID" placeholder="UUID" readonly="readonly"></td>
                 </tr>

                 <tr>
                    <th scope="row"> <label for="validationCustom03" class="form-label">FOLIO:</label></th>
                 <td><input type="text" class="form-control" id="validationCustom03" required=""  value="<?php echo $folio; ?>" name="FOLIO_FACTURA" placeholder="FOLIO" readonly="readonly"></td>
                 </tr>
				 
                 <tr>
                    <th scope="row"> <label for="validationCustom03" class="form-label">SERIE:</label></th>
                 <td><input type="text" class="form-control" id="validationCustom03" required=""  value="<?php echo $serie; ?>" name="SERIE_FACTURA" placeholder="SERIE" readonly="readonly"></td>
                 </tr>
                 <tr>
                 <th scope="row"><label for="validationCustom03" class="form-label">FECHA DE FACTURA:</label></th>
                 <td><input  type="text" class="form-control" id="validationCustom03" required=""  value="<?php echo $fecha; ?>" name="FECHA_DE_EMISION" placeholder="FECHA DE FACTURA" readonly="readonly"></td>
                 </tr>
                
                 <tr>
                    <th scope="row"> <label for="validationCustom03" class="form-label">CANTIDAD:</label></th>
                 <td><input type="text" class="form-control" id="validationCustom03" required=""  value="<?php echo $Cantidad; ?>" name="CANTIDAD" placeholder="CANTIDAD"readonly="readonly"></td>
                 </tr>
                 <tr>
                    <th scope="row"> <label for="validationCustom03" class="form-label">CLAVE DE PRODUCTO O SERVICIO:</label></th>
                 <td><input type="text" class="form-control" id="validationCustom03" required=""  value="<?php echo $ClaveProdServ; ?>" name="CLAVE-PRODUCTO_SERVICIO" placeholder="CLAVE DE PRODUCTO O SERVICIO"readonly="readonly"></td>
                 </tr>
                 <tr>
                 <th scope="row"> <label for="validationCustom03" class="form-label">CLAVE DE UNIDAD:</label></th>
                 <td><input type="text" class="form-control" id="validationCustom03" required=""  value="<?php echo $ClaveUnidad; ?>" name="CLAVE_DE_UNIDAD" placeholder="CLAVE DE UNIDAD"readonly="readonly"></td>
                 </tr>


				 
                 <tr>
                    <th scope="row"> <label for="validationCustom03" class="form-label">DESCRIPCIÓN:</label></th>
                 <td><input type="text" class="form-control" id="validationCustom03" required=""  value="<?php echo $Descripcion; ?>" name="DESCRIPCION" placeholder="DESCRIPCION"readonly="readonly"></td>
                 </tr>
                 <tr>
                    <th scope="row"> <label for="validationCustom03" class="form-label">DESCUENTO:</label></th>
                 <td><input type="text" class="form-control" id="validationCustom03" required=""  value="<?php echo $Descuento; ?>" name="DESCUENTO" placeholder="DESCUESTO"readonly="readonly"></td>
                 </tr>
                 
				 <tr> <th scope="row"> <label for="validationCustom03" class="form-label">IMPORTE:</label></th>
                 <td><input type="text" class="form-control" id="validationCustom03" required=""  value="<?php echo $Importe; ?>" name="IMPORTE" placeholder="IMPORTE"readonly="readonly"></td>
                 </tr>

                 <tr>
                 <th scope="row"> <label for="validationCustom03" class="form-label">No IDENTIFICACION:</label></th>
                 <td><input type="text" class="form-control" id="validationCustom03" required=""  value="<?php echo $NoIdentificacion; ?>" name="No_IDENTIFICACION" placeholder="No IDENTIFICACION"readonly="readonly"></td>
                 </tr>
                 <tr>
                    <th scope="row"> <label for="validationCustom03" class="form-label">OBJETO IMP:</label></th>
                 <td><input type="text" class="form-control" id="validationCustom03" required=""  value="<?php echo $ObjetoImp; ?>" name="OBJETO_IMP" placeholder="OBJETO IMP"readonly="readonly"></td>
                 </tr>
                 <tr>
                    <th scope="row"> <label for="validationCustom03" class="form-label">UNIDAD:</label></th>
                 <td><input type="text" class="form-control" id="validationCustom03" required=""  value="<?php echo $Unidad; ?>" name="IVA_FACTURA" placeholder="UNIDAD"readonly="readonly"></td>
                 </tr>
                 <tr>
                    <th scope="row"> <label for="validationCustom03" class="form-label">VALOR UNITARIO:</label></th>
                 <td><input type="text" class="form-control" id="validationCustom03" required=""  value="<?php echo $ValorUnitario; ?>" name="IVA_FACTURA" placeholder="VALOR UNITARIO"readonly="readonly"></td>
                 </tr>
                  <tr>
                    <th scope="row"> <label for="validationCustom03" class="form-label">BASE:</label></th>
                 <td><input type="text" class="form-control" id="validationCustom03" required=""  value="<?php echo $IVA_FACTURA; ?>" name="IVA_FACTURA" placeholder="BASE"readonly="readonly"></td>
                 </tr>
                 <tr>
                    <th scope="row"> <label for="validationCustom03" class="form-label">IMPUESTO:</label></th>
                 <td><input type="text" class="form-control" id="validationCustom03" required=""  value="<?php echo $IVA_FACTURA; ?>" name="IVA_FACTURA" placeholder="IMPUESTO"readonly="readonly"></td>
                 </tr>
                 <tr>
                    <th scope="row"> <label for="validationCustom03" class="form-label">TASA O CUOTA:</label></th>
                 <td><input type="text" class="form-control" id="validationCustom03" required=""  value="<?php echo $IVA_FACTURA; ?>" name="IVA_FACTURA" placeholder="TASA O CUOTA"readonly="readonly"></td>
				 
                 </tr>
                 <tr>
                    <th scope="row"> <label for="validationCustom03" class="form-label">TIPO FACTOR:</label></th>
                 <td><input type="text" class="form-control" id="validationCustom03" required=""  value="<?php echo $IVA_FACTURA; ?>" name="IVA_FACTURA" placeholder="TIPO FACTOR"readonly="readonly"></td>
                 </tr>
                 <tr>
                    <th scope="row"> <label for="validationCustom03" class="form-label">IVA:</label></th>
                 <td><input type="text" class="form-control" id="validationCustom03" required=""  value="<?php echo $TImpuestosTrasladados; ?>" name="IVA_FACTURA" placeholder="IVA" readonly="readonly"></td>
                 </tr>
                 <tr>

               
                 <tr>
                    <th scope="row"> <label  style="width:300px" for="validationCustom03" class="form-label">IMPUESTOS RETENIDOS:</label></th>
                 <td><input type="text" class="form-control" id="validationCustom03" required=""  value="<?php echo $TImpuestosRetenidos; ?>" name="TImpuestosRetenidos" placeholder="IMPUESTOS RETENIDO" readonly="readonly"></td>
                 </tr>
                
                 <!-- <tr> 
                    <th scope="row"> <label  style="width:300px" for="validationCustom03" class="form-label">I.S.R RETENIDO:</label></th>
                 <td><input type="text" class="form-control" id="validationCustom03" required=""  value="<?php echo $ISR_RETENIDO; ?>" name="ISR_RETENIDO" placeholder="I.S.R RETENIDO" readonly="readonly"></td>
                 </tr>-->
                
                 <tr>
                    <th scope="row"> <label for="validationCustom03" class="form-label">TUA:</label></th>
                 <td><input type="text" class="form-control" id="validationCustom03" required=""  value="<?php echo $TUA_FACTURA; ?>" name="TUA_FACTURA" placeholder="TUA"readonly="readonly"></td>
                 </tr>
                 <tr>
                    <th scope="row"> <label for="validationCustom03" class="form-label">I.S.H:</label></th>
                 <td><input type="text" class="form-control" id="validationCustom03" required=""  value="<?php echo $ISH_FACTURA; ?>" name="ISH_FACTURA" placeholder="I.S.H"readonly="readonly"></td>
                 </tr>
                 <tr>
                    <th scope="row"> <label for="validationCustom03" class="form-label">IEPS:</label></th>
                 <td><input type="text" class="form-control" id="validationCustom03" required=""  value="<?php echo $IEPS_FACTURA; ?>" name="IEPS_FACTURA" placeholder="IEPS"readonly="readonly"></td>
                 </tr>
                 <tr>
                    <th scope="row"> <label for="validationCustom03" class="form-label">PROPINA:</label></th>
                 <td><input type="text" class="form-control" id="validationCustom03" required=""  value="<?php echo $PROPINA_FACTURA; ?>" name="PROPINA_FACTURA" placeholder="PROPINA"readonly="readonly"></td>
                 </tr>
                 <tr>
                    <th scope="row"> <label for="validationCustom03" class="form-label">OTRO:</label></th>
                 <td><input type="text" class="form-control" id="validationCustom03" required=""  value="<?php echo $OTRO_FACTURA; ?>" name="OTRO_FACTURA" placeholder="OTRO" readonly="readonly"></td>
                 </tr>
                 <tr>
                    <th scope="row"> <label for="validationCustom03" class="form-label">TOTAL:</label></th>
                 <td><input type="text" class="form-control" id="validationCustom03" required=""  value="<?php echo $total; ?>" name="TOTAL_FACTURA" placeholder="TOTAL" readonly="readonly"></td>
                 </tr>
                 <tr>
                    <th scope="row"> <label for="validationCustom03" class="form-label">MONEDA:</label></th>
                 <td><input type="text" class="form-control" id="validationCustom03" required=""  value="<?php echo $Moneda; ?>" name="MONEDA_FACTURA" placeholder="MONEDA"readonly="readonly"></td>
                 </tr>
                 <tr>
                    <th scope="row"> <label for="validationCustom03" class="form-label">MONEDA EXTRANGERA:</label></th>
                 <td><input type="text" class="form-control" id="validationCustom03" required=""  value="<?php echo $MONEDA_EXTRANGERA_FACTURA; ?>" name="MONEDA_EXTRNGERA_FACTURA" placeholder="MONEDA EXTRANGERA"readonly="readonly"></td>
                 </tr>
                 
				 <tr>
                    <th scope="row"> <label for="validationCustom03" class="form-label">TIPO DE CAMBIO:</label></th>
                 <td><input type="text" class="form-control" id="validationCustom03" required=""  value="<?php echo $TipoCambio; ?>" name="TIPO_DE_CAMBIO" placeholder="TIPO DE CAMBIO"readonly="readonly"></td>
                 </tr>
                 
                  
                 <tr>
                    <th scope="row"> <label for="validationCustom03" class="form-label">USO DE CFDI:</label></th>
                 <td><input type="text" class="form-control" id="validationCustom03" required=""  value="<?php echo $UsoCFDI; ?>" name="USO_CFDI_FACTURA" placeholder="USO DE CFDI"readonly="readonly"></td>
                 </tr>
                 <tr>
                    <th scope="row"> <label for="validationCustom03" class="form-label">FORMA DE PAGO:</label></th>
                 <td><input type="text" class="form-control" id="validationCustom03" required=""  value="<?php echo $formaDePago; ?>" name="FORMA_DE_PAGO_FACTURA" placeholder="FORMA DE PAGO"readonly="readonly"></td>
                 </tr>
                 <tr>
                    <th scope="row"> <label for="validationCustom03" class="form-label">METODO DE PAGO:</label></th>
                 <td><input type="text" class="form-control" id="validationCustom03" required=""  value="<?php echo $metodoDePago; ?>" name="METODO_DE_PAGO_FACTURA" placeholder="METODO DE PAGO"readonly="readonly"></td>
                 </tr>
                 <tr>
                    <th scope="row"> <label for="validationCustom03" class="form-label">CONDICIONES DE PAGO:</label></th>
                 <td><input type="text" class="form-control" id="validationCustom03" required=""  value="<?php echo $CONDICIONES_DE_PAGO; ?>" name="CONDICIONES_DE_PAGO" placeholder="CONDICIONES DE PAGO" readonly="readonly"></td>
                 </tr>
                 <tr>
                    <th scope="row"> <label for="validationCustom03" class="form-label">TIPO DE COMPROBANTE:</label></th>
                 <td><input type="text" class="form-control" id="validationCustom03" required=""  value="<?php echo $tipoDeComprobante; ?>" name="TIPO_DE_COMPROBANTE" placeholder="TIPO DE COMPROBANTE" readonly="readonly"></td>
                 </tr>
             
                 <tr>
                    <th scope="row"> <label for="validationCustom03" class="form-label">CLAVE DE UNIDAD:</label></th>
                 <td><input type="text" class="form-control" id="validationCustom03" required=""  value="<?php echo $TIPO_DE_COMPROBANTE; ?>" name="TIPO_DE_COMPROBANTE" placeholder="CLAVE DE UNIDAD" readonly="readonly"></td>
                 </tr>
                 <tr>
                    <th scope="row"> <label for="validationCustom03" class="form-label">VERSIÓN:</label></th>
                 <td><input type="text" class="form-control" id="validationCustom03" required=""  value="<?php echo $Version; ?>" name="TIPO_DE_COMPROBANTE" placeholder="VERSION" readonly="readonly"></td>
                 </tr>
                 <tr>
                    <th scope="row"> <label for="validationCustom03" class="form-label">FECHA DE TIMBRADO:</label></th>
                 <td><input type="text" class="form-control" id="validationCustom03" required=""  value="<?php echo $FechaTimbrado; ?>" name="TIPO_DE_COMPROBANTE" placeholder="TIPO DE COMPROBANTE" readonly="readonly"></td>
                 </tr></table><table>
             
  <tr>

   <?php if($conexion->variablespermisos('','SUBIR_FACTURA','guardar')=='si'){ ?>	 
      <td style="text-align: right;"><button  class="btn btn-primary" type="button" id="enviarSUBIRFACTURA">GUARDAR</button><div style="
 position: absolute;
    top: 97%; 
    right: 50%;
    transform: translate(50%,-50%);
    text-transform: uppercase;
    font-family: verdana;
    font-size: 2em;
    font-weight: 500;
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
    1px 30px 60px rgba(16,16,16,0.4);"  id="mensajeSUBIRFACTURA">  <?php } ?>  
			        		 
 
        </td>
	
		
		</tr>               
			 
                 </table>  </form>
	
 
	



</div>
</div>

</div> 					  
</div>	