<?php
/*
fecha sandor: 05/06/2025
fecha fatis : 07/04/2024
*/
?>
	<?php
$connecDB = $conexion->db();


if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
$idem_usuario = $_SESSION['idem'];
$pagoproveedores->borrar_historico_xml('02SUBETUFACTURADOCTOS',$idem_usuario);
$_SESSION['P_NOMBRE_COMERCIAL_EMPRESA12'] = '';
$_SESSION['idusuario12']= '';

}

?>
		<script type="text/javascript">

		function calcular() {
			const numberNoCommas = (x) => {
				return x.toString().replace(/,/g, "");
			}
			const numberWithCommas = (x) => {
			
				const num = parseFloat(x);
				if(isNaN(num)) return '';
				return num.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
			}

			function formatInputPreservingCursor(inputElement, value) {
				const originalValue = inputElement.value;
				const cursorPos = inputElement.selectionStart;
				const commasBefore = originalValue.slice(0, cursorPos).split(',').length - 1;
				const formattedValue = numberWithCommas(value);
				inputElement.value = formattedValue;
				let newCursorPos = cursorPos - commasBefore;
				let i = 0,
					charsPassed = 0;
				while(charsPassed < newCursorPos && i < formattedValue.length) {
					if(formattedValue[i] !== ',') {
						charsPassed++;
					}
					i++;
				}
				inputElement.setSelectionRange(i, i);
			}
			// Listener para inputs tipo .tol
			const inputs = document.querySelectorAll(".total");
			inputs.forEach(input => {
				input.addEventListener("keydown", function(e) {
					const keyCode = e.keyCode || e.which;
					// Teclas numéricas (teclado principal del 0 al 9 o numpad 0 al 9)
					const isNumberKey = (keyCode >= 48 && keyCode <= 57) || // Teclado principal
						(keyCode >= 96 && keyCode <= 105) || (keyCode === 46) || (keyCode === 8); // Numpad
					if(isNumberKey) {
						// Esperar a que el valor se actualice antes de formatear
						setTimeout(() => {
							const arr = document.getElementsByClassName("total");
							let MONTO_PROPINA_elem = document.getElementsByName("MONTO_PROPINA")[0];
							let MONTO_FACTURA_elem = document.getElementsByName("MONTO_FACTURA")[0];
							let MONTO_PROPINA2 = numberNoCommas(MONTO_PROPINA_elem.value);
							let MONTO_FACTURA2 = numberNoCommas(MONTO_FACTURA_elem.value);
					
							let tot = 0;
							for(let i = 0; i < arr.length; i++) {
								const inputName = arr[i].getAttribute("name");
								const value = parseFloat(numberNoCommas(arr[i].value)) || 0;
								if(["TImpuestosRetenidosIVA", "TImpuestosRetenidosISR", "descuentos"].includes(inputName)) {
									tot -= value; // Se RESTA
								} else {
									tot += value; // Se SUMA
								}
							}
							formatInputPreservingCursor(document.getElementById('MONTO_DEPOSITAR'), tot);
							formatInputPreservingCursor(MONTO_PROPINA_elem, MONTO_PROPINA2);
							formatInputPreservingCursor(MONTO_FACTURA_elem, MONTO_FACTURA2);

						}, 0);
					}
				});
			});
		}
               document.addEventListener("DOMContentLoaded", calcular);
                function toggleFacturaFields() {
                        const select = document.querySelector('select[name="VIATICOSOPRO"]');
                        if(!select) {
                                return;
                        }
                        const shouldHide = [
                                'VIATICOS',
                                'REEMBOLSO',
                                'PAGO A PROVEEDOR CON DOS O MAS FACTURAS'
                        ].includes(select.value);
                        const xmlRow = document.getElementById('row-adjuntar-factura-xml');
                        const pdfRow = document.getElementById('row-adjuntar-factura-pdf');
                        const xmlInput = document.getElementById('ADJUNTAR_FACTURA_XML');
                        const pdfInput = document.getElementById('ADJUNTAR_FACTURA_PDF');
                        const xmlFileInput = document.querySelector('input[type="file"][name="ADJUNTAR_FACTURA_XML"]');
                        const pdfFileInput = document.querySelector('input[type="file"][name="ADJUNTAR_FACTURA_PDF"]');

                        const inputs = [
                                [xmlRow, xmlInput, xmlFileInput],
                                [pdfRow, pdfInput, pdfFileInput]
                        ];

                        inputs.forEach(([row, textInput, fileInput]) => {
                                if(textInput && !textInput.dataset.originalRequired) {
                                        textInput.dataset.originalRequired = textInput.hasAttribute('required') ? 'true' : 'false';
                                }
                                if(shouldHide) {
                                        if(row) row.style.display = 'none';
                                        if(textInput) {
                                                textInput.setAttribute('disabled', 'disabled');
                                                textInput.removeAttribute('required');
                                        }
                                        if(fileInput) {
                                                fileInput.setAttribute('disabled', 'disabled');
                                        }
                                } else {
                                        if(row) row.style.display = '';
                                        if(textInput) {
                                                textInput.removeAttribute('disabled');
                                                if(textInput.dataset.originalRequired === 'true') {
                                                        textInput.setAttribute('required', '');
                                                }
                                        }
                                        if(fileInput) {
                                                fileInput.removeAttribute('disabled');
                                        }
                                }
                        });
                }
               function updateReembolsoLabels() {
                       const select = document.querySelector('select[name="VIATICOSOPRO"]');
                       if(!select) {
                               return;
                       }
                       const isReembolso = select.value === 'REEMBOLSO';
                       const nombreComercialLabel = document.getElementById('label-nombre-comercial-text');
                       if(nombreComercialLabel) {
                               nombreComercialLabel.textContent = isReembolso
                                       ? 'NOMBRE COMERCIAL DEL BENEFICIARIO DEL REEMBOLSO'
                                       : 'NOMBRE COMERCIAL';
                       }
                       const razonSocialLabel = document.getElementById('label-razon-social-text');
                       if(razonSocialLabel) {
                               razonSocialLabel.textContent = isReembolso
                                       ? 'RAZÓN SOCIAL DEL BENEFICIARIO DEL REEMBOLSO'
                                       : 'RAZÓN SOCIAL';
                       }
                       const rfcLabel = document.getElementById('label-rfc-text');
                       if(rfcLabel) {
                               rfcLabel.textContent = isReembolso
                                       ? 'RFC DEL BENEFICIARIO DEL REEMBOLSO:'
                                       : 'RFC DEL PROVEEDOR:';
                       }
               }
             function setCurrentFillingDate() {
                       const fechaInput = document.querySelector('input[name="FECHA_DE_LLENADO"]');
                       if(!fechaInput) {
                               return;
                       }
                       const now = new Date();
                       const pad = (value) => value.toString().padStart(2, '0');
                       const formatted = `${pad(now.getDate())}-${pad(now.getMonth() + 1)}-${now.getFullYear()} ${pad(now.getHours())}:${pad(now.getMinutes())}:${pad(now.getSeconds())}`;
                       fechaInput.value = formatted;
               }
               document.addEventListener('DOMContentLoaded', () => {
                       toggleFacturaFields();
                       updateReembolsoLabels();
                       setCurrentFillingDate();
                       const select = document.querySelector('select[name="VIATICOSOPRO"]');
                       if(select) {
                               select.addEventListener('change', () => {
                                       toggleFacturaFields();
                                       updateReembolsoLabels();
                               });
                       }
               });
			   
                $(document).on('change', 'input[type="checkbox"]', function(e) {
                        if(this.id == "MONTO_DEPOSITAR1") {
                                if(this.checked) $('#FECHA_AUTORIZACION_RESPONSABLE').val(this.value);
                                else $('#FECHA_AUTORIZACION_RESPONSABLE').val("");
                        }
			
		});
		$(document).on('change', 'input[type="checkbox"]', function(e) {
			if(this.id == "MONTO_DEPOSITAR2") {
				if(this.checked) $('#FECHA_AUTORIZACION_AUDITORIA').val(this.value);
				else $('#FECHA_AUTORIZACION_AUDITORIA').val("");
			}
		});
		$(document).on('change', 'input[type="checkbox"]', function(e) {
			if(this.id == "MONTO_DEPOSITAR3") {
				if(this.checked) $('#FECHA_DE_LLENADO').val(this.value);
				else $('#FECHA_DE_LLENADO').val("");
			}
		});
		</script>

		<div id="content">
			<hr/> <strong> <P class="mb-0 text-uppercase">
<img src="includes/contraer31.png" id="mostrar1" style="cursor:pointer;"/>
<img src="includes/contraer41.png" id="ocultar1" style="cursor:pointer;"/>&nbsp;&nbsp;&nbsp;PAGO A PROVEEDORES</p></strong></div>
		<div id="mensajepagoproveedores2">
			<div class="progress" style="width: 25%;">
				<div class="progress-bar" role="progressbar" style="width: <?php echo $pagoaproveedoress ; ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
					<?php echo $pagoaproveedoress ; ?>%</div>
			</div>
		</div>
		<div id="target1" style="display:block;" class="content2">
			<div class="card">
				<div class="card-body">
					<form class="row g-3 needs-validation was-validated" novalidate="" id="pagoaproveedoresform" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>"> 
						<table class="table table-striped table-bordered" style="width:100%">
							<tr>

							</tr>
							<tr style="background:#d2faf1">
				
								<th scope="row" style="width:45%">
									<label  for="validationCustom03" class="form-label"> PAGO A PROVEEDOR, VIÁTICO, REEMBOLSO,   etc.</label>
								</th>
								<td>
									<select class="form-select mb-3" aria-label="Default select example" id="validationCustom02" required="" name="VIATICOSOPRO"> 
						<option style="background:#fac3aa" value="PAGO A PROVEEDOR" <?php if($VIATICOSOPRO=='PAGOAPROVE' ){echo "selected";} ?>>SOLICITUD DE UN SOLO PAGO CON UNA SOLA FACTURA </option>
						<option style="background:#faf7aa" value="VIATICOS" <?php if($VIATICOSOPRO=='VIATICOS' ){echo "selected";} ?>>SOLICITUD DE VIATICOS</option>
						<option style="background:#c0c7f6" value="REEMBOLSO" <?php if($VIATICOSOPRO=='REEMBOLSO' ){echo "selected";} ?>>SOLICITUD DE REEMBOLSO</option>
					
						
						
						<option style="background:#f571f7" value="PAGO A PROVEEDOR CON DOS O MAS FACTURAS" <?php if($VIATICOSOPRO=='PAGO A PROVEEDOR CON DOS O MAS FACTURAS' ){echo "selected";} ?>>SOLICITUD DE UN SOLO PAGO  CON DOS O MÁS FACTURAS</option>
							<option style="background:#b3f39b" value="PAGOS CON UNA SOLA FACTURA" <?php if($VIATICOSOPRO=='PAGOS CON UNA SOLA FACTURA' ){echo "selected";} ?>>SOLICITUD DE VARIOS PAGOS CON UNA SOLA FACTURA</option>
                       
						
						
						
										
										
									</select>
								</td>
				</div>
				</tr>
				                               <tr style="background: #d2faf1" id="row-adjuntar-factura-xml">

					<th scope="row">
						<label style="width:300px" for="formFileSm" class="form-label">ADJUNTAR FACTURA FORMATO &nbsp;<a style="color:red;font:12px">(XML)</a></label>
					</th>
					<td>
						<div id="drop_file_zone" ondrop="upload_file(event,'ADJUNTAR_FACTURA_XML')" ondragover="return false">
							<p>Suelta aquí o busca tu archivo</p>
							<p>
								<input class="form-control form-control-sm" id="ADJUNTAR_FACTURA_XML" type="text" onkeydown="return false" onclick="file_explorer('ADJUNTAR_FACTURA_XML');" VALUE="<?php echo $ADJUNTAR_FACTURA_XML; ?>" required />
							</p>
							<input type="file" name="ADJUNTAR_FACTURA_XML" id="nono" />
							<div id="1ADJUNTAR_FACTURA_XML">
								<?php
		if($ADJUNTAR_FACTURA_XML!=""){echo "<a target='_blank' href='includes/archivos/".$ADJUNTAR_FACTURA_XML."'></a>"; 
		}?></div>
						</div>
						<div id="2ADJUNTAR_FACTURA_XML">
							<?php 

$listadosube = $pagoproveedores->Listado_subefacturadocto('ADJUNTAR_FACTURA_XML');

while($rowsube=mysqli_fetch_array($listadosube)){
	echo "<a target='_blank' href='includes/archivos/".$rowsube['ADJUNTAR_FACTURA_XML']."' id='A".$rowsube['id']."' >Visualizar!</a> "." <span id='".$rowsube['id']."' class='view_dataSBborrar2' style='cursor:pointer;color:blue;'>Borrar!</span> <span > ".$rowsube['fechaingreso']."</span>".'<br/>';		
	
}
	$NUMERO_CONSECUTIVO_PROVEE = '';	$FECHA_DE_PAGO = '';
	$regreso = $pagoproveedores->variable_SUBETUFACTURA();
	$url = __ROOT1__.'/includes/archivos/'.$regreso['ADJUNTAR_FACTURA_XML'];
    if( file_exists($url) ){
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

	$Cantidad = $regreso['Cantidad'];
	$ValorUnitario = $regreso['ValorUnitario'];
	$Importe = $regreso['Importe'];
	$ClaveProdServ = $regreso['ClaveProdServ'];
	$Unidad = $regreso['Unidad'];
	$Descripcion = $regreso['Descripcion'];
	$ClaveUnidad = $regreso['ClaveUnidad'];
	$NoIdentificacion = $regreso['NoIdentificacion'];
	$ObjetoImp = $regreso['ObjetoImp'];
	$Descuento = $regreso['Descuento'];
	$impueRdesglosado002 = $regreso['impueRdesglosado002'];	/*IVA*/
	$impueRdesglosado001 = $regreso['impueRdesglosado001'];	/*ISR*/
	/*nuevo*/

	$fechaInicio=strtotime(date('Y-m-d'));
	$FECHA_domingo = date('Y-m-d', strtotime('next monday', $fechaInicio));
	$FECHA_jueves = date('Y-m-d', strtotime('next Thursday', strtotime($FECHA_domingo)));
	$FECHA_DE_PAGO = $FECHA_jueves;//'2023-08-03';//. $conexion2->fechaEs($FECHA_jueves);

	/*nuevo*/
		
	$valor_base = (method_exists($pagoproveedores, 'select_02XML')) 
    ? $pagoproveedores->select_02XML() 
    : 0;
    
$NUMERO_CONSECUTIVO_PROVEE = $valor_base + 1;
}
?> </div>
					</td>
				</tr>
			                            <tr style="background: #d2faf1" id="row-adjuntar-factura-pdf">
	
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">ADJUNTAR FACTURA FORMATO (PDF)</label>
					</th>
					<td>
						<div id="drop_file_zone" ondrop="upload_file(event,'ADJUNTAR_FACTURA_PDF')" ondragover="return false">
							<p>Suelta aquí o busca tu archivo</p>
							<p>
								<input class="form-control form-control-sm" id="ADJUNTAR_FACTURA_PDF" type="text" onkeydown="return false" onclick="file_explorer('ADJUNTAR_FACTURA_PDF');" VALUE="<?php echo $ADJUNTAR_FACTURA_PDF; ?>" required />
							</p>
							<input type="file" name="ADJUNTAR_FACTURA_PDF" id="nono" />
							<div id="1ADJUNTAR_FACTURA_PDF">
								<?php
		if($ADJUNTAR_FACTURA_PDF!=""){echo "<a target='_blank' href='includes/archivos/".$ADJUNTAR_FACTURA_PDF."'></a>"; 
		}?></div>
						</div>
						<div id="2ADJUNTAR_FACTURA_PDF">
							<?php $listadosube = $pagoproveedores->Listado_subefacturadocto('ADJUNTAR_FACTURA_PDF');

while($rowsube=mysqli_fetch_array($listadosube)){
	echo "<a target='_blank' href='includes/archivos/".$rowsube['ADJUNTAR_FACTURA_PDF']."' id='A".$rowsube['id']."' >Visualizar!</a> "." <span id='".$rowsube['id']."' class='view_dataSBborrar2' style='cursor:pointer;color:blue;'>Borrar!</span><span > ".$rowsube['fechaingreso']."</span>".'<br/>';	
}


				 ?></div>
					</td>
				</tr>
				<tr style="background:#fcf3cf">
		
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">NÚMERO DE SOLICITUD</label>
					</th>
					<td>
						<div id="NUMERO_CONSECUTIVO_PROVEE2">
							<input type="text" class="form-control" id="NUMERO_CONSECUTIVO_PROVEE2" required="" value="<?php echo $NUMERO_CONSECUTIVO_PROVEE; ?>" name="NUMERO_CONSECUTIVO_PROVEE" placeholder="NÚMERO CONSECUTIVO DE PAGO A PROVEEDORES" readonly="readonly">
						</div>
					</td>
				</tr>
				<tr style="background: #d2faf1">
				
                                        <th scope="row">
                                                <?php
                                               $labelNombreComercial = ($VIATICOSOPRO == 'REEMBOLSO')
                                                       ? 'NOMBRE COMERCIAL DEL BENEFICIARIO DEL REEMBOLSO'
                                                       : 'NOMBRE COMERCIAL';
                                               $labelRazonSocial = ($VIATICOSOPRO == 'REEMBOLSO')
                                                       ? 'RAZÓN SOCIAL DEL BENEFICIARIO DEL REEMBOLSO'
                                                       : 'RAZÓN SOCIAL';
                                               $labelRfc = ($VIATICOSOPRO == 'REEMBOLSO')
                                                       ? 'RFC DEL BENEFICIARIO DEL REEMBOLSO:'
                                                       : 'RFC DEL PROVEEDOR:';
                                               $placeholderRazonSocial = $labelRazonSocial;
                                               $placeholderRfc = ($VIATICOSOPRO == 'REEMBOLSO')
                                                       ? 'RFC DEL BENEFICIARIO DEL REEMBOLSO'
                                                       : 'RFC DEL PROVEEDOR';
                                               ?>
                                               <label style="width:300px" for="validationCustom03" class="form-label"><span id="label-nombre-comercial-text"><?php echo $labelNombreComercial; ?></span>
                                                        <br><a style="color:red;font-size:11px">OBLIGATORIO</a></label>
                                        </th>
					<td>
						<select class="form-select mb-3" id="NOMBRE_COMERCIAL" name="NOMBRE_COMERCIAL" onchange="buscanombrecomercial(1);">
							<option value="<?php echo $evento_get; ?>">
								<?php echo $evento_get; ?>
							</option>
						</select>
						<script type="text/javascript">
						$('#NOMBRE_COMERCIAL').select2({
							placeholder: 'ESCRIBE Y SELECCIONA UNA OPCIÓN',
							ajax: {
								url: 'pagoproveedores/controladorNOMBRE_COMERCIAL.php',
								dataType: 'json',
								delay: 250,
								type: 'post',
								data: function(params) {
									return {
										BUSCA_NOMBRE_COMERCIAL: params.term // search term
									};
								},
								processResults: function(data) {
									return {
										results: data
									};
								},
								cache: true
							}
						});

						function buscanombrecomercial(page) {
							var NOMBRE_COMERCIAL = $("#NOMBRE_COMERCIAL").val();
							var parametros = {
								"action": "NOMBRE_COMERCIAL",
								"NOMBRE_COMERCIAL": NOMBRE_COMERCIAL
							};
							$("#loader").fadeIn('slow');
							$.ajax({
								url: 'pagoproveedores/controladorNOMBRE_COMERCIAL.php',
								type: 'POST',
								data: parametros,
								beforeSend: function(objeto) {
									$("#loader").html("Cargando...");
								},
								success: function(data) {
									var result = data.split('^^^');
									document.getElementsByName('RAZON_SOCIAL')[0].value = result[0];
									document.getElementsByName('RFC_PROVEEDOR')[0].value = result[1];
									$('#NOMBRE_COMERCIAL2').html('');
								}
							})
						}
						</script>
						<?php if($conexion->variablespermisos('','PAGO_PROVEEDOR1boton','ver')=='si'){ ?>
							<a href="listaproveedores.php" target="_blank" rel="noopener noreferrer">
								<button style="float: right;width:220px" class="btn btn-sm btn-primary px-5" type="button"> AGREGAR PROVEEDOR </button>
							</a>
							<?php } ?>
								<br> <span id="NOMBRE_COMERCIAL2">
<?php 
if($rfcE==true){
	$resutaldonombrecomercia = $pagoproveedores->buscarNOMBRECOMERCIAL22($rfcE);
	
	$explotado23 = explode('^^^^',$resutaldonombrecomercia);
	echo '<input type="hidden" name="NOMBRE_COMERCIAL23" value="'.$explotado23[0].'">
	<strong style="word-spacing: 10px; letter-spacing: 2px;font-size:16PX;background:#CCFF00;">'.$explotado23[1].'</strong>';
	}
?>
</span> </td>
				</tr>
				<tr style="background:#fcf3cf">

					<th scope="row">
                                            <label style="width:300px" for="RAZON_SOCIAL" class="form-label"><span id="label-razon-social-text"><?php echo $labelRazonSocial; ?></span></label>
					</th>
					<td>
                                            <div id="RAZON_SOCIAL2">
                                                    <input type="text" class="form-control" id="RAZON_SOCIAL" required="" value="<?php echo $nombreE; ?>" name="RAZON_SOCIAL" placeholder="<?php echo $placeholderRazonSocial; ?>"> </div>
					</td>
				</tr>
				<tr style="background:#fcf3cf">
			
					<th scope="row">
                                            <label style="width:300px" for="validationCustom03" class="form-label"><span id="label-rfc-text"><?php echo $labelRfc; ?></span></label>
					</th>
					<td>
                                            <div id="RFC_PROVEEDOR2">
                                                    <input type="text" class="form-control" id="RFC_PROVEEDOR" required="" value="<?php echo $rfcE; ?>" name="RFC_PROVEEDOR" placeholder="<?php echo $placeholderRfc; ?>"> </div>
					</td>
				</tr>
				<tr style="background: #d2faf1">

					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">No. DE EVENTO:
							<br><a style="color:red;font-size:11px">OBLIGATORIO</a></label>
					</th>
					<td>
						<div style="">
							<select class="form-select mb-3" id="NUMERO_EVENTO" name="NUMERO_EVENTO" onchange="buscanombreevento(1);">
								<option value="<?php echo $numero_evento_get; ?>">
									<?php echo $numero_evento_get; ?>
								</option>
							</select>
						</div>
						<script type="text/javascript">
						$('#NUMERO_EVENTO').select2({
							placeholder: 'ESCRIBE Y SELECCIONA UNA OPCIÓN',
							ajax: {
								url: 'comprobaciones/controladorPP.php',
								dataType: 'json',
								delay: 250,
								type: 'post',
								processResults: function(data) {
									return {
										results: data
									};
								},
								cache: true
							}
						});

						function buscanombreevento(page) {
							var NUMERO_EVENTO = $("#NUMERO_EVENTO").val();
							var parametros = {
								"action": "ajax",
								"NUMERO_EVENTO": NUMERO_EVENTO
							};
							$("#loader").fadeIn('slow');
							$.ajax({
								url: 'pagoproveedores/controladorPP.php',
								type: 'POST',
								data: parametros,
								beforeSend: function(objeto) {
									$("#loader").html("Cargando...");
								},
								success: function(data) {
									document.getElementsByName('NOMBRE_EVENTO')[0].value = data;
								}
							})
						}
						</script>
					</td>
				</tr>
				<tr style="background:#fcf3cf">
			
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">NOMBRE DEL EVENTO:</label>
					</th>
					<td>
						<input type="text" class="form-control" id="NOMBRE_EVENTO" required="" value="<?php echo $NOMBRE_EVENTO_get ?>" name="NOMBRE_EVENTO" placeholder="NOMBRE DEL EVENTO">
					</td>
				</tr>
				<tr style="background: #d2faf1">
		
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">MOTIVO DEL GASTO:<br><a style="color:red;font-size:11px">OBLIGATORIO</a></label>
					</th>
					<td>
						<input type="text" class="form-control" id="validationCustom03" required="" value="<?php echo $MOTIVO_GASTO; ?>" name="MOTIVO_GASTO" placeholder="MOTIVO DEL GASTO ">
					</td>
				</tr>
				<tr style="background:#fcf3cf">
			
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">CONCEPTO DE LA FACTURA:</label>
					</th>
					<td>
						<div id="CONCEPTO_PROVEE2">
							<input type="text" class="form-control" id="CONCEPTO_PROVEE" required="" value="<?php echo $Descripcion; ?>" name="CONCEPTO_PROVEE" placeholder="CONCEPTO DE LA FACTURA">
						</div>
					</td>
				</tr>
				<tr style="background: #d2faf1">
				
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">MONTO TOTAL DE LA COTIZACIÓN O DEL ADEUDO<br><a style="color:red;font-size:11px">OBLIGATORIO</a></label>
					</th>
					<td>
						<div class="input-group mb-3"> <span class="input-group-text">$</span>
							<input type="text" style="width:300px;height:40px;" value="<?php echo $MONTO_TOTAL_COTIZACION_ADEUDO; ?>" name="MONTO_TOTAL_COTIZACION_ADEUDO" onkeyup="comasainput2('MONTO_TOTAL_COTIZACION_ADEUDO')" placeholder="MONTO TOTAL DE LA COTIZACÓN"> </div>
					</td>
				</tr>
				</td>
				</tr>
				<br></br>
				<tr style="background:#fcf3cf">
		
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">SUB TOTAL:</label>
					</th>
					<td>
						<div id="2MONTO_FACTURA">
							<div class="input-group mb-3"> <span class="input-group-text">$</span>
								<input type="text" style="width:300px;height:40px;" id="MONTO_FACTURA" required="" onkeyup="calcular()" value="<?php echo $subTotal; ?>" name="MONTO_FACTURA" class="total" placeholder="SUB TOTAL"> </div>
						</div>
					</td>
				</tr>
				<tr style="background:#fcf3cf">
					
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">IVA:</label>
					</th>
					<td>
						<div id="2IVA">
							<div class="input-group mb-3"> <span class="input-group-text">$</span>
								<input type="text" style="width:300px;height:40px;" id="IVA" required="" onkeyup="calcular()" name="IVA" class="total" value="<?php echo $TImpuestosTrasladados; ?>" placeholder="IVA"> </div>
						</div>
					</td>
				</tr>
				<tr style="background:#fcf3cf">
					
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">IMPUESTOS RETENIDOS &nbsp;<a style="color:red;font:12px">(IVA)</a></label>
					</th>
					<td>
						<div id="2TImpuestosRetenidosIVA">
							<div class="input-group mb-3"> <span class="input-group-text">$</span>
								<input type="text" style="width:300px;height:40px;" id="TImpuestosRetenidosIVA" required="" name="TImpuestosRetenidosIVA" value="<?php echo $impueRdesglosado002; ?>" placeholder="IMPUESTOS RETENIDOS IVA" class="total"> </div>
						</div>
					</td>
				</tr>
				<tr style="background:#fcf3cf">
				
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">IMPUESTOS RETENIDOS &nbsp;<a style="color:red;font:12px">(ISR)</a></label>
					</th>
					<td>
						<div id="2TImpuestosRetenidosISR">
							<div class="input-group mb-3"> <span class="input-group-text">$</span>
								<input type="text" style="width:300px;height:40px;" id="TImpuestosRetenidosISR" required="" name="TImpuestosRetenidosISR" value="<?php echo $impueRdesglosado001; ?>" placeholder="IMPUESTOS RETENIDOS ISR" class="total"> </div>
						</div>
					</td>
				</tr>
				<tr style="background: #d2faf1">
					
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label"><a style="color:red;font:12px">FAVOR DE PONER EL:&nbsp;</a>MONTO DE LA PROPINA O SERVICIO ESTÉ INCLUIDO O NO EN LA FACTURA</label>
					</th>
					<td>
						<div class="input-group mb-3"> <span class="input-group-text">$</span>
							<input type="text" class="total" style="width:300px;height:40px;" id="total" required="" onkeyup="calcular()" value="<?php echo $MONTO_PROPINA; ?>" name="MONTO_PROPINA" placeholder="MONTO DE LA PROPINA"> </td>
				</tr>
				</div>
				<tr style="background: #d2faf1">
				
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label"><a style="color:red;font:12px">FAVOR DE PONER EL:&nbsp;</a> IMPUESTO SOBRE
							<BR>HOSPEDAJE MÁS EL IMPUESTO DE SANEAMIENTO:</label>
					</th>
					<td>
						<div class="input-group mb-3"> <span class="input-group-text">$</span>
							<input type="text" class="total" style="width:300px;height:40px;" onkeyup="calcular()" id="total" required="" value="<?php echo $IMPUESTO_HOSPEDAJE; ?>" name="IMPUESTO_HOSPEDAJE" placeholder="IMPUESTO HOSPEDAJE"> </td>
				</tr>
				</div>
				<tr style="background:#fcf3cf">
		
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">DESCUENTO </label>
					</th>
					<td>
						<div id="2descuentos">
							<div class="input-group mb-3"> <span class="input-group-text">$</span>
								<input type="text" style="width:300px;height:40px;" id="descuentos" required="" name="descuentos" value="<?php echo $Descuento; ?>" placeholder="DESCUENTO" class="total"> </div>
						</div>
					</td>
				</tr>
				
<tr style="background:#fcf3cf">
  <th scope="row" style="width:50%;">
    <label for="MONTO_DEPOSITAR" class="form-label">TOTAL A PAGAR:</label>
  </th>
  <td style="width:50%;">
    <div id="2MONTO_DEPOSITAR" class="input-group mb-3">
      <span class="input-group-text">$</span>
      <input type="text" style="width:300px;height:40px;" id="MONTO_DEPOSITAR"
             required value="<?php echo $total; ?>"
             name="MONTO_DEPOSITAR" placeholder="TOTAL"  readonly="readonly">
    </div>
  </td>
</tr>

<tr style="background:#d2faf1">
  <th scope="row" style="width:50%;">
    <label for="MONTO_DEPOSITADO" class="form-label">MONTO DEPOSITADO:</label>
  </th>
  <td style="width:50%;">
    <div class="input-group mb-3">
      <span class="input-group-text">$</span>
      <input type="text" style="width:300px;height:40px;" id="MONTO_DEPOSITADO"
             required value="<?php echo $MONTO_DEPOSITADO; ?>"
             name="MONTO_DEPOSITADO"
             onkeyup="comasainput('MONTO_DEPOSITADO')"
             placeholder="MONTO DEPOSITADO">
    </div>
  </td>
</tr>

<tr style="background:#fcf3cf">
  <th scope="row" style="width:50%;">
    <label for="PENDIENTE_PAGO" class="form-label">PENDIENTE DE PAGO DE LA COTIZACIÓN:</label>
  </th>
  <td style="width:50%;">
    <div class="input-group mb-3">
      <span class="input-group-text">$</span>
      <input type="text" style="width:300px;height:40px;"id="PENDIENTE_PAGO"
             required value="<?php echo $PENDIENTE_PAGO; ?>"
             name="PENDIENTE_PAGO"
             onkeyup="comasainput('PENDIENTE_PAGO')"
             placeholder="PENDIENTE DE PAGO" disabled>
    </div>
  </td>
</tr>

				
				
				
				<tr style="background:#fcf3cf">
			
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">TIPO DE MONEDA O DIVISA:</label>
					</th>
					<td>
						<div id="TIPO_DE_MONEDA2">
							<select class="form-select mb-3" aria-label="Default select example" id="validationCustom02" required="" name="TIPO_DE_MONEDA">
								<option style="background: #c9e8e8" name="TIPO_DE_MONEDA" value="MXN" <?php if($Moneda=='MXN' ){echo "selected";} ?>>MXN (Peso mexicano)</option>
								<option style="background: #a3e4d7" name="TIPO_DE_MONEDA" value="USD" <?php if($Moneda=='USD' ){echo "selected";} ?>>USD (Dolar)</option>
								<option style="background: #e8f6f3" name="TIPO_DE_MONEDA" value="EUR" <?php if($Moneda=='EUR' ){echo "selected";} ?>>EUR (Euro)</option>
								<option style="background: #fdf2e9" name="TIPO_DE_MONEDA" value="GBP" <?php if($Moneda=='GBP' ){echo "selected";} ?>>GBP (Libra esterlina)</option>
								<option style="background: #eaeded" name="TIPO_DE_MONEDA" value="CHF" <?php if($Moneda=='CHF' ){echo "selected";} ?>>CHF (Franco suizo)</option>
								<option style="background: #fdebd0" name="TIPO_DE_MONEDA" value="CNY" <?php if($Moneda=='CNY' ){echo "selected";} ?>>CNY (Yuan)</option>
								<option style="background: #ebdef0" name="TIPO_DE_MONEDA" value="JPY" <?php if($Moneda=='JPY' ){echo "selected";} ?>>JPY (Yen japonés)</option>
								<option style="background: #d6eaf8" name="TIPO_DE_MONEDA" value="HKD" <?php if($Moneda=='HKD' ){echo "selected";} ?>>HKD (Dólar hongkonés)</option>
								<option style="background: #fef5e7" name="TIPO_DE_MONEDA" value="CAD" <?php if($Moneda=='CAD' ){echo "selected";} ?>>CAD (Dólar canadiense)</option>
								<option style="background: #ebedef" name="TIPO_DE_MONEDA" value="AUD" <?php if($Moneda=='AUD' ){echo "selected";} ?>>AUD (Dólar australiano)</option>
								<option style="background: #fbeee6" name="TIPO_DE_MONEDA" value="BRL" <?php if($Moneda=='BRL' ){echo "selected";} ?>>BRL (Real brasileño)</option>
								<option style="background: #e8f6f3" name="TIPO_DE_MONEDA" value="RUB" <?php if($Moneda=='RUB' ){echo "selected";} ?>>RUB (Rublo ruso)</option>
							</select>
						</div>
					</td>
				</tr>
				<tr style="background:#fcf3cf">
					
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">TIPO DE CAMBIO:</label>
					</th>
					<td>
						<div class="input-group mb-3"> <span class="input-group-text">$</span>
							<input type="text" style="width:300px;height:40px;" value="<?php echo $TIPO_CAMBIOP; ?>" name="TIPO_CAMBIOP" onkeyup="comasainput2('TIPO_CAMBIOP')" placeholder="TIPO DE CAMBIO"> </div>
					</td>
				</tr>
				<tr style="background:#fcf3cf">
		
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">TOTAL DE LA CONVERSIÓN:</label>
					</th>
					<td>
						<div class="input-group mb-3"> <span class="input-group-text">$</span>
							<input type="text" style="width:300px;height:40px;" value="<?php echo $TOTAL_ENPESOS; ?>" name="TOTAL_ENPESOS" onkeyup="comasainput2('TOTAL_ENPESOS')" placeholder="TOTAL DE LA CONVERSIÓN"> </div>
					</td>
				</tr>
				<tr style="background: #fcf3cf">
				
					<th>
						<label style="width: 300px" class="form-label">FORMA DE PAGO:</label>
					</th>
					<td style="width: 45%;">
						<div id="2PFORMADE_PAGO">
							<select name="PFORMADE_PAGO" class="form-select mb-3" id="validationCustom02" aria-label="Default select example">
								<script type="text/javascript">
								function EFECTIVO(texto) {
									alert(texto);
								}
								</script>
								<option style="background:#f2b4f5" name="PFORMADE_PAGO" value="03">03 TRANSFERENCIA ELECTRONICA DE FONDOS</option>
								<option style="background:#f2b4f5" <?php if($formaDePago=='03' ){echo "selected";} ?> value="03" name="PFORMADE_PAGO">03 TRANSFERENCIA ELECTRONICA DE FONDOS</option>
								<option style="background:#dee6fc" <?php if($formaDePago=='04' ){echo "selected ";} ?> value="04" onclick="EFECTIVO('FAVOR DE SOLICITAR EL CAMBIO DE FACTURA POR NO COINCIDIR CON LA FORMA DE PAGO');" name="PFORMADE_PAGO">04 TARJETA DE CREDITO</option>
								<option style="background:#ddf5da" <?php if($formaDePago=='01' ){echo "selected";} ?> value="01 EFECTIVO" onclick="EFECTIVO('FAVOR DE SOLICITAR EL CAMBIO DE FACTURA POR NO COINCIDIR CON LA FORMA DE PAGO');" name="PFORMADE_PAGO">01 EFECTIVO</option>
								<option style="background:#fceade" <?php if($formaDePago=='02' ){echo "selected";} ?> value="02" onclick="EFECTIVO('FAVOR DE SOLICITAR EL CAMBIO DE FACTURA POR NO COINCIDIR CON LA FORMA DE PAGO');" name="PFORMADE_PAGO">02 CHEQUE NOMITATIVO</option>
								<option style="background:#f6fcde" <?php if($formaDePago=='05' ){echo "selected";} ?> value="05" onclick="EFECTIVO('FAVOR DE SOLICITAR EL CAMBIO DE FACTURA POR NO COINCIDIR CON LA FORMA DE PAGO');">05 MONEDERO ELECTRONICO</option>
								<option style="background:#dee2fc" <?php if($formaDePago=='06' ){echo "selected";} ?> value="06" onclick="EFECTIVO('FAVOR DE SOLICITAR EL CAMBIO DE FACTURA POR NO COINCIDIR CON LA FORMA DE PAGO');">06 DINERO ELECTRONICO</option>
								<option style="background:#f9e5fa" <?php if($formaDePago=='08' ){echo "selected";} ?> value="08" onclick="EFECTIVO('FAVOR DE SOLICITAR EL CAMBIO DE FACTURA POR NO COINCIDIR CON LA FORMA DE PAGO');">08 VALES DE DESPENSA</option>
								<option style="background:#eefcde" <?php if($formaDePago=='28' ){echo "selected";} ?> value="28" onclick="EFECTIVO('FAVOR DE SOLICITAR EL CAMBIO DE FACTURA POR NO COINCIDIR CON LA FORMA DE PAGO');">28 TARJETA DE DEBITO</option>
								<option style="background:#fcfbde" <?php if($formaDePago=='29' ){echo "selected";} ?> value="29" onclick="EFECTIVO('FAVOR DE SOLICITAR EL CAMBIO DE FACTURA POR NO COINCIDIR CON LA FORMA DE PAGO');">29 TARJETA DE SERVICIO</option>
								<option style="background:#f9e5fa" <?php if($formaDePago=='99' ){echo "selected";} ?> value="99" onclick="EFECTIVO('FAVOR DE SOLICITAR EL CAMBIO DE FACTURA POR NO COINCIDIR CON LA FORMA DE PAGO');">99 OTRO</option>
							</select>
							<div/> </td>
				</tr>
				<tr style="background:#fcf3cf">
			
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">FECHA DE PROGRAMACIÓN DEL PAGO:</label>
					</th>
					<td>
						<div id="FECHA_DE_PAGO2">
							<input type="date" class="form-control" id="FECHA_DE_PAGO2" required="" value="<?php echo $FECHA_DE_PAGO; ?>" name="FECHA_DE_PAGO" placeholder="FECHA DE PAGO">
						</div>
					</td>
				</tr>
				<tr style="background:#d2faf1">
	
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">FECHA EFECTIVA DE PAGO:</label>
					</th>
					<td>
						<input type="date" class="form-control" id="validationCustom03" required="" value="<?php echo $FECHA_A_DEPOSITAR; ?>" name="FECHA_A_DEPOSITAR" placeholder="FECHA A DEPOSITAR">
					</td>
				</tr>
				<tr style="background:#d2faf1">
			
					<th scope="row">
						<label style="width:300px" for="validationCustom02" class="form-label">STATUS DE PAGO:</label>
					</th>
					<td>
						<select class="form-select mb-3" aria-label="Default select example" id="validationCustom02" value="<?php echo $STATUS_DE_PAGO; ?>" required="" name="STATUS_DE_PAGO">
							<option style="background:#d9f9fa " <?php if($SOLICITADO=='SOLICITADO' ){echo "selected";} ?> value="SOLICITADO">SOLICITADO</option>
							<option style="background:#e1f5de " <?php if($APROBADO=='APROBADO' ){echo "selected";} ?> value="APROBADO">APROBADO</option>
							<option style="background:#f5deee " <?php if($PAGADO=='PAGADO' ){echo "selected";} ?> value="PAGADO">PAGADO</option>
							<option style="background:#f5f4de " <?php if($RECHAZADO=='RECHAZADO' ){echo "selected";} ?> value="RECHAZADO">RECHAZADO</option>
						</select>
					</td>
				</tr>
				<tr style="background: #d2faf1">
			
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">ADJUNTAR COTIZACIÓN O REPORTE: (CUALQUIER FORMATO)</label>
					</th>
					<td>
						<div id="drop_file_zone" ondrop="upload_file(event,'ADJUNTAR_COTIZACION')" ondragover="return false">
							<p>Suelta aquí o busca tu archivo</p>
							<p>
								<input class="form-control form-control-sm" id="ADJUNTAR_COTIZACION" type="text" onkeydown="return false" onclick="file_explorer('ADJUNTAR_COTIZACION');" VALUE="<?php echo $ADJUNTAR_COTIZACION; ?>" required />
							</p>
							<input type="file" name="ADJUNTAR_COTIZACION" id="nono" />
							<div id="1ADJUNTAR_COTIZACION">
								<?php
		if($ADJUNTAR_COTIZACION!=""){echo "<a target='_blank' href='includes/archivos/".$ADJUNTAR_COTIZACION."'></a>"; 
		}?></div>
						</div>
						<div id="2ADJUNTAR_COTIZACION">
							<?php $listadosube = $pagoproveedores->Listado_subefacturadocto('ADJUNTAR_COTIZACION');

while($rowsube=mysqli_fetch_array($listadosube)){
	echo "<a target='_blank' href='includes/archivos/".$rowsube['ADJUNTAR_COTIZACION']."' id='A".$rowsube['id']."' >Visualizar!</a> "." <span id='".$rowsube['id']."' class='view_dataSBborrar2' style='cursor:pointer;color:blue;'>Borrar!</span><span > ".$rowsube['fechaingreso']."</span>".'<br/>';	
}
?></div>
					</td>
				</tr>
				<tr style="background: #d2faf1">
			
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">ACTIVO FIJO:</label>
					</th>
					<td>
						<select class="form-select mb-3" aria-label="Default select example" id="validationCustom02" required="" name="ACTIVO_FIJO"> >
							<option selected="">SELECCIONA UNA OPCION</option>
							<option style="background: #c9e8e8" value="SI" <?php if($ACTIVO_FIJO=='SI' ){echo "selected";} ?>>SI</option>
							<option style="background: #a3e4d7" value="NO" <?php if($ACTIVO_FIJO=='NO' ){echo "selected";} ?>>NO</option>
						</select>
						</div>
				</tr>
				<tr style="background: #d2faf1">
				
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">GASTO FIJO:</label>
					</th>
					<td>
						<select class="form-select mb-3" aria-label="Default select example" id="validationCustom02" required="" name="GASTO_FIJO"> >
							<option selected="">SELECCIONA UNA OPCION</option>
							<option style="background: #c9e8e8" value="SI" <?php if($GASTO_FIJO=='SI' ){echo "selected";} ?>>SI</option>
							<option style="background: #a3e4d7" value="NO" <?php if($GASTO_FIJO=='NO' ){echo "selected";} ?>>NO</option>
						</select>
			</div>
			</tr>
			<tr style="background: #d2faf1">
				
				<th scope="row">
					<label style="width:300px" for="validationCustom03" class="form-label"> PAGAR CADA:</label>
				</th>
				<td>
					<select class="form-select mb-3" aria-label="Default select example" id="validationCustom02" value="<?php echo $PAGAR_CADA; ?>" required="" name="PAGAR_CADA">
						<option style="background:#e1f5de " <?php if($PAGAR_CADA=='NINGUNA' ){echo "selected";} ?> value="NINGUNA">NINGUNA</option>
						<option style="background:#f5deee " <?php if($PAGAR_CADA=='MES' ){echo "selected";} ?> value="MES">MES</option>
						<option style="background:#d9f9fa " <?php if($PAGAR_CADA=='SEMANA' ){echo "selected";} ?> value="SEMANA">SEMANA</option>
						<option style="background:#e1f5de " <?php if($PAGAR_CADA=='QUINCENA' ){echo "selected";} ?> value="QUINCENA">QUINCENA</option>
						<option style="background:#f5f4de " <?php if($PAGAR_CADA=='AÑO' ){echo "selected";} ?> value="AÑO">AÑO</option>
					</select>
				</td>
			</tr>
			<tr style="background: #d2faf1">
				
				<th scope="row">
					<label style="width:300px" for="validationCustom03" class="form-label"> FECHA DE PROGRAMACIÓN DE PAGO:</label>
				</th>
				<td>
					<input type="date" class="form-control" id="validationCustom03" required="" value="<?php echo $FECHA_PPAGO; ?>" name="FECHA_PPAGO" placeholder="FECHA DE PROGRAMACIÓN DE PAGO ">
				</td>
			</tr>
			<tr style="background: #d2faf1">
			
				<th scope="row">
					<label style="width:300px" for="validationCustom03" class="form-label"> FECHA DE TERMINACIÓN DE LA PROGRAMACIÓN:</label>
				</th>
				<td>
					<input type="date" class="form-control" id="validationCustom03" required="" value="<?php echo $FECHA_TPROGRAPAGO; ?>" name="FECHA_TPROGRAPAGO" placeholder="FECHA DE TERMINACIÓN DE LA PROGRAMACIÓN ">
				</td>
			</tr>
			<tr style="background: #d2faf1">
		
				<th scope="row">
					<label style="width:300px" for="validationCustom03" class="form-label"> NÚMERO DE EVENTO (FIJO) PARA PROGRAMACIÓN:</label>
				</th>
				<td>
					<input type="text" class="form-control" id="validationCustom03" required="" value="<?php echo $NUMERO_EVENTOFIJO; ?>" name="NUMERO_EVENTOFIJO" placeholder="NÚMERO DE EVENTO (FIJO) PARA PROGRAMACIÓN ">
				</td>
			</tr>
			<tr style="background: #d2faf1">
				
				<th scope="row">
					<label style="width:300px" for="validationCustom03" class="form-label"> CLASIFICACIÓN GENERAL:</label>
				</th>
				<td>
					<input type="text" class="form-control" id="validationCustom03" required="" value="<?php echo $CLASI_GENERAL; ?>" name="CLASI_GENERAL" placeholder="CLASIFICACIÓN GENERAL: ">
				</td>
			</tr>
			<tr style="background: #d2faf1">
	
				<th scope="row">
					<label style="width:300px" for="validationCustom03" class="form-label"> SUB CLASIFICACIÓN GENERAL:</label>
				</th>
				<td>
					<input type="text" class="form-control" id="validationCustom03" required="" value="<?php echo $SUB_GENERAL; ?>" name="SUB_GENERAL" placeholder=" SUB CLASIFICACIÓN GENERAL">
				</td>
			</tr>
			<tr style="background: #d2faf1">
	
				<th scope="row">
					<label style="width:300px" for="validationCustom03" class="form-label">ADJUNTAR COMPROBANTE DE TRANSFERENCIA: (FORMATO PDF)</label>
				</th>
				<td>
					<div id="drop_file_zone" ondrop="upload_file(event,'CONPROBANTE_TRANSFERENCIA')" ondragover="return false">
						<p>Suelta aquí o busca tu archivo</p>
						<p>
							<input class="form-control form-control-sm" id="CONPROBANTE_TRANSFERENCIA" type="text" onkeydown="return false" onclick="file_explorer('CONPROBANTE_TRANSFERENCIA');" VALUE="<?php echo $CONPROBANTE_TRANSFERENCIA; ?>" required />
						</p>
						<input type="file" name="CONPROBANTE_TRANSFERENCIA" id="nono" />
						<div id="1CONPROBANTE_TRANSFERENCIA">
							<?php
		if($CONPROBANTE_TRANSFERENCIA!=""){echo "<a target='_blank' href='includes/archivos/".$CONPROBANTE_TRANSFERENCIA."'></a>"; 
		}?></div>
					</div>
					<div id="2CONPROBANTE_TRANSFERENCIA">
						<?php $listadosube = $pagoproveedores->Listado_subefacturadocto('CONPROBANTE_TRANSFERENCIA');

while($rowsube=mysqli_fetch_array($listadosube)){
	echo "<a target='_blank' href='includes/archivos/".$rowsube['CONPROBANTE_TRANSFERENCIA']."' id='A".$rowsube['id']."' >Visualizar!</a> "." <span id='".$rowsube['id']."' class='view_dataSBborrar2' style='cursor:pointer;color:blue;'>Borrar!</span><span > ".$rowsube['fechaingreso']."</span>".'<br/>';	
}


				 ?> </div>
				</td>
			</tr>
			<tr style="background: #d2faf1">
	
				<th scope="row">
					<label style="width:300px" for="validationCustom03" class="form-label"> CUENTA ORIGEN:</label>
				</th>
				<td>
					<input type="text" class="form-control" id="validationCustom03" required="" value="<?php echo $ACTIVO_FIJO; ?>" name="ACTIVO_FIJO" placeholder="BANCO ORIGEN">
				</td>
			</tr>
			<tr style="background: #d2faf1">
		
				<th scope="row">
					<label style="width:300px" for="validationCustom03" class="form-label">NÚMERO DE EVENTO (FIJO):</label>
				</th>
				<td>
					<input type="text" class="form-control" id="validationCustom03" required="" value="<?php echo $NUMERO_EVENTO1; ?>" name="NUMERO_EVENTO1" placeholder="No. DE EVENTO">
				</td>
			</tr>
			<tr style="background: #d2faf1">
				
				<th scope="row">
					<label style="width:300px" for="validationCustom03" class="form-label">CLASIFICACIÓN GENERAL:</label>
				</th>
				<td>
					<input type="text" class="form-control" id="validationCustom03" required="" value="<?php echo $CLASIFICACION_GENERAL; ?>" name="CLASIFICACION_GENERAL" placeholder="CLASIFICACIÓN GENERAL">
				</td>
			</tr>
			<tr style="background: #d2faf1">
		
				<th scope="row">
					<label style="width:300px" for="validationCustom03" class="form-label">CLASIFICACIÓN ESPECIFICA:</label>
				</th>
				<td>
					<input type="text" class="form-control" id="validationCustom03" required="" value="<?php echo $CLASIFICACION_ESPECIFICA; ?>" name="CLASIFICACION_ESPECIFICA" placeholder="CLASIFICACIÓN ESPECIFICA">
				</td>
			</tr>
			<tr style="background: #d2faf1">
			
				<th scope="row">
					<label style="width:300px" for="validationCustom03" class="form-label">PLACAS DEL VEHICULO:</label>
				</th>
				<td>
					<input type="text" class="form-control" id="validationCustom03" required="" value="<?php echo $PLACAS_VEHICULO; ?>" name="PLACAS_VEHICULO" placeholder="PLACAS DEL VEHICULO">
				</td>
			</tr>
			<tr style="background: #d2faf1">
			
				<th scope="row">
					<label style="width:300px" for="validationCustom03" class="form-label">COMPLEMENTOS DE PAGO (FORMATO PDF)</label>
				</th>
				<td style="width:300px;">
					<div id="drop_file_zone" ondrop="upload_file(event,'COMPLEMENTOS_PAGO_PDF')" ondragover="return false">
						<p>Suelta aquí o busca tu archivo</p>
						<p>
							<input class="form-control form-control-sm" id="COMPLEMENTOS_PAGO_PDF" type="text" onkeydown="return false" onclick="file_explorer('COMPLEMENTOS_PAGO_PDF');" VALUE="<?php echo $COMPLEMENTOS_PAGO_PDF; ?>" required />
						</p>
						<input type="file" name="COMPLEMENTOS_PAGO_PDF" id="nono" />
						<div id="1COMPLEMENTOS_PAGO_PDF">
							<?php
		if($COMPLEMENTOS_PAGO_PDF!=""){echo "<a target='_blank' href='includes/archivos/".$COMPLEMENTOS_PAGO_PDF."'></a>"; 
		}?></div>
					</div>
					<div id="2COMPLEMENTOS_PAGO_PDF">
						<?php $listadosube = $pagoproveedores->Listado_subefacturadocto('COMPLEMENTOS_PAGO_PDF');

while($rowsube=mysqli_fetch_array($listadosube)){
	echo "<a target='_blank' href='includes/archivos/".$rowsube['COMPLEMENTOS_PAGO_PDF']."' id='A".$rowsube['id']."' >Visualizar!</a> "." <span id='".$rowsube['id']."' class='view_dataSBborrar2' style='cursor:pointer;color:blue;'>Borrar!</span><span > ".$rowsube['fechaingreso']."</span>".'<br/>';	
}


				 ?></div>
				</td>
			</tr>
			<tr style="background: #d2faf1">
		
				<th scope="row">
					<label style="width:300px" for="validationCustom03" class="form-label">COMPLEMENTOS DE PAGO (FORMATO XML)</label>
				</th>
				<td style="width:300px;">
					<div id="drop_file_zone" ondrop="upload_file(event,'COMPLEMENTOS_PAGO_XML')" ondragover="return false">
						<p>Suelta aquí o busca tu archivo</p>
						<p>
							<input class="form-control form-control-sm" id="COMPLEMENTOS_PAGO_XML" type="text" onkeydown="return false" onclick="file_explorer('COMPLEMENTOS_PAGO_XML');" VALUE="<?php echo $COMPLEMENTOS_PAGO_XML; ?>" required />
						</p>
						<input type="file" name="COMPLEMENTOS_PAGO_XML" id="nono" />
						<div id="1COMPLEMENTOS_PAGO_XML">
							<?php
		if($COMPLEMENTOS_PAGO_XML!=""){echo "<a target='_blank' href='includes/archivos/".$COMPLEMENTOS_PAGO_XML."'></a>"; 
		}?></div>
					</div>
					<div id="2COMPLEMENTOS_PAGO_XML">
						<?php $listadosube = $pagoproveedores->Listado_subefacturadocto('COMPLEMENTOS_PAGO_XML');

while($rowsube=mysqli_fetch_array($listadosube)){
	echo "<a target='_blank' href='includes/archivos/".$rowsube['COMPLEMENTOS_PAGO_XML']."' id='A".$rowsube['id']."' >Visualizar!</a> "." <span id='".$rowsube['id']."' class='view_dataSBborrar2' style='cursor:pointer;color:blue;'>Borrar!</span><span > ".$rowsube['fechaingreso']."</span>".'<br/>';	
}


				 ?></div>
				</td>
			</tr>
			<tr style="background: #d2faf1">
		
				<th scope="row">
					<label style="width:300px" for="validationCustom03" class="form-label">ADJUNTAR CANCELACIONES (FORMATO PDF)</label>
				</th>
				<td style="width:300px;">
					<div id="drop_file_zone" ondrop="upload_file(event,'CANCELACIONES_PDF')" ondragover="return false">
						<p>Suelta aquí o busca tu archivo</p>
						<p>
							<input class="form-control form-control-sm" id="CANCELACIONES_PDF" type="text" onkeydown="return false" onclick="file_explorer('CANCELACIONES_PDF');" VALUE="<?php echo $CANCELACIONES_PDF; ?>" required />
						</p>
						<input type="file" name="CANCELACIONES_PDF" id="nono" />
						<div id="1CANCELACIONES_PDF">
							<?php
		if($CANCELACIONES_PDF!=""){echo "<a target='_blank' href='includes/archivos/".$CANCELACIONES_PDF."'></a>"; 
		}?></div>
					</div>
					<div id="2CANCELACIONES_PDF">
						<?php $listadosube = $pagoproveedores->Listado_subefacturadocto('CANCELACIONES_PDF');

while($rowsube=mysqli_fetch_array($listadosube)){
	echo "<a target='_blank' href='includes/archivos/".$rowsube['CANCELACIONES_PDF']."' id='A".$rowsube['id']."' >Visualizar!</a> "." <span id='".$rowsube['id']."' class='view_dataSBborrar2' style='cursor:pointer;color:blue;'>Borrar!</span><span > ".$rowsube['fechaingreso']."</span>".'<br/>';	
}


				 ?></div>
				</td>
			</tr>
			<tr style="background: #d2faf1">

				<th scope="row">
					<label style="width:300px" for="validationCustom03" class="form-label">ADJUNTAR CANCELACIONES (FORMATO XML)</label>
				</th>
				<td style="width:300px;">
					<div id="drop_file_zone" ondrop="upload_file(event,'CANCELACIONES_XML')" ondragover="return false">
						<p>Suelta aquí o busca tu archivo</p>
						<p>
							<input class="form-control form-control-sm" id="CANCELACIONES_XML" type="text" onkeydown="return false" onclick="file_explorer('CANCELACIONES_XML');" VALUE="<?php echo $CANCELACIONES_XML; ?>" required />
						</p>
						<input type="file" name="CANCELACIONES_XML" id="nono" />
						<div id="1CANCELACIONES_XML">
							<?php
		if($CANCELACIONES_XML!=""){echo "<a target='_blank' href='includes/archivos/".$CANCELACIONES_XML."'></a>"; 
		}?></div>
					</div>
					<div id="2CANCELACIONES_XML">
						<?php $listadosube = $pagoproveedores->Listado_subefacturadocto('CANCELACIONES_XML');

while($rowsube=mysqli_fetch_array($listadosube)){
	echo "<a target='_blank' href='includes/archivos/".$rowsube['CANCELACIONES_XML']."' id='A".$rowsube['id']."' >Visualizar!</a> "." <span id='".$rowsube['id']."' class='view_dataSBborrar2' style='cursor:pointer;color:blue;'>Borrar!</span><span > ".$rowsube['fechaingreso']."</span>".'<br/>';	
}


				 ?></div>
				</td>
			</tr>
			<tr style="background: #d2faf1">
	
				<th scope="row">
					<label style="width:300px" for="validationCustom03" class="form-label">ADJUNTAR FACTURA DE COMISIÓN (FORMATO PDF)</label>
				</th>
				<td style="width:300px;">
					<div id="drop_file_zone" ondrop="upload_file(event,'ADJUNTAR_FACTURA_DE_COMISION_PDF')" ondragover="return false">
						<p>Suelta aquí o busca tu archivo</p>
						<p>
							<input class="form-control form-control-sm" id="ADJUNTAR_FACTURA_DE_COMISION_PDF" type="text" onkeydown="return false" onclick="file_explorer('ADJUNTAR_FACTURA_DE_COMISION_PDF');" VALUE="<?php echo $ADJUNTAR_FACTURA_DE_COMISION_PDF; ?>" required />
						</p>
						<input type="file" name="ADJUNTAR_FACTURA_DE_COMISION_PDF" id="nono" />
						<div id="1ADJUNTAR_FACTURA_DE_COMISION_PDF">
							<?php
		if($ADJUNTAR_FACTURA_DE_COMISION_PDF!=""){echo "<a target='_blank' href='includes/archivos/".$ADJUNTAR_FACTURA_DE_COMISION_PDF."'></a>"; 
		}?></div>
					</div>
					<div id="2ADJUNTAR_FACTURA_DE_COMISION_PDF">
						<?php $listadosube = $pagoproveedores->Listado_subefacturadocto('ADJUNTAR_FACTURA_DE_COMISION_PDF');

while($rowsube=mysqli_fetch_array($listadosube)){
	echo "<a target='_blank' href='includes/archivos/".$rowsube['ADJUNTAR_FACTURA_DE_COMISION_PDF']."' id='A".$rowsube['id']."' >Visualizar!</a> "." <span id='".$rowsube['id']."' class='view_dataSBborrar2' style='cursor:pointer;color:blue;'>Borrar!</span><span > ".$rowsube['fechaingreso']."</span>".'<br/>';	
}


				 ?></div>
				</td>
			</tr>
			<tr style="background: #d2faf1">
		
				<th scope="row">
					<label style="width:300px" for="validationCustom03" class="form-label"> ADJUNTAR FACTURA DE COMISIÓN(FORMATO XML)</label>
				</th>
				<td style="width:300px;">
					<div id="drop_file_zone" ondrop="upload_file(event,'ADJUNTAR_FACTURA_DE_COMISION_XML')" ondragover="return false">
						<p>Suelta aquí o busca tu archivo</p>
						<p>
							<input class="form-control form-control-sm" id="ADJUNTAR_FACTURA_DE_COMISION_XML" type="text" onkeydown="return false" onclick="file_explorer('ADJUNTAR_FACTURA_DE_COMISION_XML');" VALUE="<?php echo $ADJUNTAR_FACTURA_DE_COMISION_XML; ?>" required />
						</p>
						<input type="file" name="ADJUNTAR_FACTURA_DE_COMISION_XML" id="nono" />
						<div id="1ADJUNTAR_FACTURA_DE_COMISION_XML">
							<?php
		if($ADJUNTAR_FACTURA_DE_COMISION_XML!=""){echo "<a target='_blank' href='includes/archivos/".$ADJUNTAR_FACTURA_DE_COMISION_XML."'></a>"; 
		}?></div>
					</div>
					<div id="2ADJUNTAR_FACTURA_DE_COMISION_XML">
						<?php $listadosube = $pagoproveedores->Listado_subefacturadocto('ADJUNTAR_FACTURA_DE_COMISION_XML');

while($rowsube=mysqli_fetch_array($listadosube)){
	echo "<a target='_blank' href='includes/archivos/".$rowsube['ADJUNTAR_FACTURA_DE_COMISION_XML']."' id='A".$rowsube['id']."' >Visualizar!</a> "." <span id='".$rowsube['id']."' class='view_dataSBborrar2' style='cursor:pointer;color:blue;'>Borrar!</span><span > ".$rowsube['fechaingreso']."</span>".'<br/>';	
}


				 ?></div>
				</td>
			</tr>
			<tr style="background: #d2faf1">
	
				<th scope="row">
					<label style="width:300px" for="validationCustom03" class="form-label"> ADJUNTAR CALCULO DE COMISIÓN: (CUALQUIER FORMATO)</label>
				</th>
				<td style="width:300px;">
					<div id="drop_file_zone" ondrop="upload_file(event,'CALCULO_DE_COMISION')" ondragover="return false">
						<p>Suelta aquí o busca tu archivo</p>
						<p>
							<input class="form-control form-control-sm" id="CALCULO_DE_COMISION" type="text" onkeydown="return false" onclick="file_explorer('CALCULO_DE_COMISION');" VALUE="<?php echo $CALCULO_DE_COMISION; ?>" required />
						</p>
						<input type="file" name="CALCULO_DE_COMISION" id="nono" />
						<div id="1CALCULO_DE_COMISION">
							<?php
		if($CALCULO_DE_COMISION!=""){echo "<a target='_blank' href='includes/archivos/".$CALCULO_DE_COMISION."'></a>"; 
		}?></div>
					</div>
					<div id="2CALCULO_DE_COMISION">
						<?php $listadosube = $pagoproveedores->Listado_subefacturadocto('CALCULO_DE_COMISION');

while($rowsube=mysqli_fetch_array($listadosube)){
	echo "<a target='_blank' href='includes/archivos/".$rowsube['CALCULO_DE_COMISION']."' id='A".$rowsube['id']."' >Visualizar!</a> "." <span id='".$rowsube['id']."' class='view_dataSBborrar2' style='cursor:pointer;color:blue;'>Borrar!</span><span > ".$rowsube['fechaingreso']."</span>".'<br/>';	
}


				 ?></div>
				</td>
			</tr>
			<tr style="background: #d2faf1">
	
				<th scope="row">
					<label style="width:300px" for="validationCustom03" class="form-label">MONTO DE COMISIÓN:</label>
				</th>
				<td>
					<input type="text" class="form-control" id="validationCustom03" required="" value="<?php echo $MONTO_DE_COMISION; ?>" name="MONTO_DE_COMISION" placeholder="MONTO DE COMISION">
				</td>
			</tr>
			<tr style="background: #d2faf1">
	
				<th scope="row">
					<label style="width:300px" for="validationCustom03" class="form-label"> ADJUNTAR COMPROBANTE DE DEVOLUCIÓN DE DINERO (CUALQUIER FORMATO)</label>
				</th>
				<td style="width:300px;">
					<div id="drop_file_zone" ondrop="upload_file(event,'COMPROBANTE_DE_DEVOLUCION')" ondragover="return false">
						<p>Suelta aquí o busca tu archivo</p>
						<p>
							<input class="form-control form-control-sm" id="COMPROBANTE_DE_DEVOLUCION" type="text" onkeydown="return false" onclick="file_explorer('COMPROBANTE_DE_DEVOLUCION');" VALUE="<?php echo $COMPROBANTE_DE_DEVOLUCION; ?>" required />
						</p>
						<input type="file" name="COMPROBANTE_DE_DEVOLUCION" id="nono" />
						<div id="1COMPROBANTE_DE_DEVOLUCION">
							<?php
		if($COMPROBANTE_DE_DEVOLUCION!=""){echo "<a target='_blank' href='includes/archivos/".$COMPROBANTE_DE_DEVOLUCION."'></a>"; 
		}?></div>
					</div>
					<div id="2COMPROBANTE_DE_DEVOLUCION">
						<?php $listadosube = $pagoproveedores->Listado_subefacturadocto('COMPROBANTE_DE_DEVOLUCION');

while($rowsube=mysqli_fetch_array($listadosube)){
	echo "<a target='_blank' href='includes/archivos/".$rowsube['CALCULO_DE_COMISION']."' id='A".$rowsube['id']."' >Visualizar!</a> "." <span id='".$rowsube['id']."' class='view_dataSBborrar2' style='cursor:pointer;color:blue;'>Borrar!</span><span > ".$rowsube['fechaingreso']."</span>".'<br/>';	
}


				 ?></div>
				</td>
			</tr>
			<tr style="background: #d2faf1">

		<th scope="row">
					<label style="width:300px" for="validationCustom03" class="form-label"> ADJUNTAR NOTA DE CREDITO DE COMPRA: (CUALQUIER FORMATO)</label>
				</th>
				<td style="width:300px;">
					<div id="drop_file_zone" ondrop="upload_file(event,'NOTA_DE_CREDITO_COMPRA')" ondragover="return false">
						<p>Suelta aquí o busca tu archivo</p>
						<p>
							<input class="form-control form-control-sm" id="NOTA_DE_CREDITO_COMPRA" type="text" onkeydown="return false" onclick="file_explorer('NOTA_DE_CREDITO_COMPRA');" VALUE="<?php echo $NOTA_DE_CREDITO_COMPRA; ?>" required />
						</p>
						<input type="file" name="NOTA_DE_CREDITO_COMPRA" id="nono" />
						<div id="1NOTA_DE_CREDITO_COMPRA">
							<?php
		if($NOTA_DE_CREDITO_COMPRA!=""){echo "<a target='_blank' href='includes/archivos/".$NOTA_DE_CREDITO_COMPRA."'></a>"; 
		}?></div>
					</div>
					<div id="2NOTA_DE_CREDITO_COMPRA">
						<?php $listadosube = $pagoproveedores->Listado_subefacturadocto('NOTA_DE_CREDITO_COMPRA');

while($rowsube=mysqli_fetch_array($listadosube)){
	echo "<a target='_blank' href='includes/archivos/".$rowsube['NOTA_DE_CREDITO_COMPRA']."' id='A".$rowsube['id']."' >Visualizar!</a> "." <span id='".$rowsube['id']."' class='view_dataSBborrar2' style='cursor:pointer;color:blue;'>Borrar!</span><span > ".$rowsube['fechaingreso']."</span>".'<br/>';	
}


				 ?></div>
				</td>
			</tr>
			
			
			
			<tr style="background: #d2faf1">
	
				<th scope="row">
					<label style="width:300px" for="validationCustom03" class="form-label">PÓLIZA NÚMERO:</label>
				</th>
				<td>
					<input type="text" class="form-control" id="POLIZA_NUMERO" required="" value="<?php echo $POLIZA_NUMERO;  ?>" name="POLIZA_NUMERO" placeholder="POLIZA NÚMERO">
				</td>
			</tr>
			<tr style="background:#fcf3cf">
		
				<th scope="row">
					<label for="validationCustom03" class="form-label">NOMBRE DEL EJECUTIVO QUE INGRESO ESTA FACTURA:</label>
				</th>
				<td><input type="text" class="form-control" id="validationCustom03" required="" value="<?php echo $_SESSION["NOMBREUSUARIO"]; ?>" name="NOMBRE_DEL_AYUDO" placeholder="NOMBRE DEL EJECUTIVO" readonly="readonly">
				</td>
			</tr>
			<tr style="background:#fcf3cf">
		
				<th style="text-align:left" scope="col">NOMBRE DEL EJECUTIVO QUE REALIZÓ LA COMPRA:</th>
				<td>
					<?php
$encabezadoA = '';
$queryper = $conexion->colaborador_generico_bueno();
$encabezadoA = '<select class="form-select mb-3" aria-label="Default select example" id="NOMBRE_DEL_EJECUTIVO" required="" name="NOMBRE_DEL_EJECUTIVO"  placeholder="SELECIONA UNA OPCIÓN">
<option> SELECIONA UNA OPCIÓN</option>';


$fondos = array("fff0df","f4ffdf","dfffed","dffeff","dfe8ff","efdfff","ffdffd","efdfff","ffdfe9");
$num = 0;

while($row = mysqli_fetch_array($queryper))
{

if($num==8){$num=0;}else{$num++;}

$select='';
if($_SESSION['idem']==$row['idRelacion']){
$select='selected';
}

$option2 .= '<option style="background: #'.$fondos[$num].'" '.$select.' 
value="'.$row['NOMBRE_1'].' '.$row['NOMBRE_2'].' '.$row['APELLIDO_PATERNO'].' '.$row['APELLIDO_MATERNO'].'">'.$row['NOMBRE_1'].' '.$row['NOMBRE_2'].' '.$row['APELLIDO_PATERNO'].' '.$row['APELLIDO_MATERNO'].
'</option>';
}
echo $encabezadoA.$option2.'</select>';		
?>
				</td>
			</tr>
			<tr style="background: #d2faf1">
	
				<th scope="row">
					<label style="width:300px" for="validationCustom03" class="form-label">MATCH CON EL ESTADO DE CUENTA:</label>
				</th>
				<td>
					<div id="drop_file_zone" ondrop="upload_file(event,'FOTO_ESTADO_PROVEE11')" ondragover="return false">
						<p>Suelta aquí o busca tu archivo</p>
						<p>
							<input class="form-control form-control-sm" id="FOTO_ESTADO_PROVEE11" type="text" onkeydown="return false" onclick="file_explorer('FOTO_ESTADO_PROVEE11');" VALUE="<?php echo $FOTO_ESTADO_PROVEE11; ?>" required />
						</p>
						<input type="file" name="FOTO_ESTADO_PROVEE11" id="nono" />
						<div id="1FOTO_ESTADO_PROVEE11">
							<?php
		if($FOTO_ESTADO_PROVEE11!=""){echo "<a target='_blank' href='includes/archivos/".$FOTO_ESTADO_PROVEE11."'></a>"; 
		}?></div>
					</div>
					<div id="2FOTO_ESTADO_PROVEE11">
						<?php 
	$listadosube = $pagoproveedores->Listado_subefacturadocto('FOTO_ESTADO_PROVEE11');

	while($rowsube=mysqli_fetch_array($listadosube)){
	echo "<a target='_blank' href='includes/archivos/".$rowsube['FOTO_ESTADO_PROVEE11']."'  id='A".$rowsube['id']."' >Visualizar!</a> "." <span id='".$rowsube['id']."' class='view_dataSBborrar2' style='cursor:pointer;color:blue;'>Borrar!</span><span > ".$rowsube['fechaingreso']."</span>".'<br/>';
	}


				 ?></div>
				</td>
			</tr>
			<tr style="background: #d2faf1">
		
				<th scope="row">
					<label style="width:300px" for="validationCustom03" class="form-label">OBSERVACIONES:</label>
				</th>
				<td>
					<input type="text" class="form-control" id="validationCustom03" required="" value="<?php echo $OBSERVACIONES_1; ?>" name="OBSERVACIONES_1" placeholder="OBSERVACIONES 1">
				</td>
			</tr>
			<tr style="background: #d2faf1">
			
				<th scope="row">
					<label style="width:300px" for="validationCustom03" class="form-label">ADJUNTAR ARCHIVO RELACIONADO A ESTE GASTO: (CUALQUIER FORMATO)</label>
				</th>
				<td>
					<div id="drop_file_zone" ondrop="upload_file(event,'ADJUNTAR_ARCHIVO_1')" ondragover="return false">
						<p>Suelta aquí o busca tu archivo</p>
						<p>
							<input class="form-control form-control-sm" id="ADJUNTAR_ARCHIVO_1" type="text" onkeydown="return false" onclick="file_explorer('ADJUNTAR_ARCHIVO_1');" VALUE="<?php echo $ADJUNTAR_ARCHIVO_1; ?>" required />
						</p>
						<input type="file" name="ADJUNTAR_ARCHIVO_1" id="nono" />
						<div id="1ADJUNTAR_ARCHIVO_1">
							<?php
		if($ADJUNTAR_ARCHIVO_1!=""){echo "<a target='_blank' href='includes/archivos/".$ADJUNTAR_ARCHIVO_1."'></a>"; 
		}?></div>
					</div>
					<div id="2ADJUNTAR_ARCHIVO_1">
						<?php 
	$listadosube = $pagoproveedores->Listado_subefacturadocto('ADJUNTAR_ARCHIVO_1');

	while($rowsube=mysqli_fetch_array($listadosube)){
	echo "<a target='_blank' href='includes/archivos/".$rowsube['ADJUNTAR_ARCHIVO_1']."'  id='A".$rowsube['id']."' >Visualizar!</a> "." <span id='".$rowsube['id']."' class='view_dataSBborrar2' style='cursor:pointer;color:blue;'>Borrar!</span><span > ".$rowsube['fechaingreso']."</span>".'<br/>';
	}


				 ?></div>
				</td>
				
			
 <input type="hidden" style="width:200px;" class="form-control" id="validationCustom03" value="<?php echo date('d-m-Y H:i:s'); ?>" name="FECHA_DE_LLENADO">
			</tr>
			
			
			<input type="hidden" name="hiddenpagoproveedores" value="hiddenpagoproveedores"> </table>
			<BR/>
			<BR/>
			<table  class="table mb-0 table-striped" id="resettabla">
				<tr>
					<th scope="col">FACTURA</th>
					<th scope="col">DATOS DE LA FACTURA</th>
				</tr>
				<tr>
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">NOMBRE RECEPTOR:</label>
					</th>
					<td>
						<input type="text" class="form-control" id="validationCustom03" required="" value="<?php echo $nombreR; ?>" name="DATOS_DE_EPC_INNOVACC_JUST" placeholder="DATOS DE EPC, INNOVACC O JUST" readonly="readonly">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">RFC RECEPTOR:</label>
					</th>
					<td>
						<input type="text" class="form-control" id="validationCustom03" required="" value="<?php echo $rfcR; ?>" name="DATOS_DE_EPC_INNOVACC_JUST" placeholder="DATOS DE EPC, INNOVACC O JUST" readonly="readonly">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">RAZÓN SOCIAL DEL PROVEEDOR:</label>
					</th>
					<td>
						<input type="text" class="form-control" id="validationCustom03" required="" value="<?php echo $nombreE; ?>" name="RAZON_SOCIAL_FACTURA" placeholder="RAZON SOCIAL DEL PROVEEDOR" readonly="readonly">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">RFC:</label>
					</th>
					<td>
						<input type="text" class="form-control" id="validationCustom03" required="" value="<?php echo $rfcE; ?>" name="rfcE" placeholder="RFC" readonly="readonly">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">REGÍMEN FISCAL:</label>
					</th>
					<td>
						<input type="text" class="form-control" id="validationCustom03" required="" value="<?php echo $regimenE; ?>" name="RegimenFiscalReceptor" placeholder="REGIMEN FISCAL" readonly="readonly">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">UUID:</label>
					</th>
					<td>
						<input type="text" class="form-control" id="validationCustom03" required="" value="<?php echo $UUID; ?>" name="UUID" placeholder="UUID" readonly="readonly">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">FOLIO:</label>
					</th>
					<td>
						<input type="text" class="form-control" id="validationCustom03" required="" value="<?php echo $folio; ?>" name="FOLIO_FACTURA" placeholder="FOLIO" readonly="readonly">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">SERIE:</label>
					</th>
					<td>
						<input type="text" class="form-control" id="validationCustom03" required="" value="<?php echo $serie; ?>" name="SERIE_FACTURA" placeholder="SERIE" readonly="readonly">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">FECHA DE FACTURA:</label>
					</th>
					<td>
						<input type="text" class="form-control" id="validationCustom03" required="" value="<?php echo $fecha; ?>" name="FECHA_DE_EMISION" placeholder="FECHA DE FACTURA" readonly="readonly">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">CANTIDAD:</label>
					</th>
					<td>
						<input type="text" class="form-control" id="validationCustom03" required="" value="<?php echo $Cantidad; ?>" name="CANTIDAD" placeholder="CANTIDAD" readonly="readonly">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">CLAVE DE PRODUCTO O SERVICIO:</label>
					</th>
					<td>
						<input type="text" class="form-control" id="validationCustom03" required="" value="<?php echo $ClaveProdServ; ?>" name="CLAVE-PRODUCTO_SERVICIO" placeholder="CLAVE DE PRODUCTO O SERVICIO" readonly="readonly">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">CLAVE DE UNIDAD:</label>
					</th>
					<td>
						<input type="text" class="form-control" id="validationCustom03" required="" value="<?php echo $ClaveUnidad; ?>" name="CLAVE_DE_UNIDAD" placeholder="CLAVE DE UNIDAD" readonly="readonly">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">DESCRIPCIÓN:</label>
					</th>
					<td>
						<input type="text" class="form-control" id="validationCustom03" required="" value="<?php echo $Descripcion; ?>" name="DESCRIPCION" placeholder="DESCRIPCION" readonly="readonly">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">DESCUENTO:</label>
					</th>
					<td>
						<input type="text" class="form-control" id="validationCustom03" required="" value="<?php echo $Descuento; ?>" name="Descuento" placeholder="Descuento" readonly="readonly">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">IMPORTE:</label>
					</th>
					<td>
						<input type="text" class="form-control" id="validationCustom03" required="" value="<?php echo $Importe; ?>" name="IMPORTE" placeholder="IMPORTE" readonly="readonly">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">No IDENTIFICACION:</label>
					</th>
					<td>
						<input type="text" class="form-control" id="validationCustom03" required="" value="<?php echo $NoIdentificacion; ?>" name="No_IDENTIFICACION" placeholder="No IDENTIFICACION" readonly="readonly">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">OBJETO IMP:</label>
					</th>
					<td>
						<input type="text" class="form-control" id="validationCustom03" required="" value="<?php echo $ObjetoImp; ?>" name="OBJETO_IMP" placeholder="OBJETO IMP" readonly="readonly">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">UNIDAD:</label>
					</th>
					<td>
						<input type="text" class="form-control" id="validationCustom03" required="" value="<?php echo $Unidad; ?>" name="IVA_FACTURA" placeholder="UNIDAD" readonly="readonly">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">VALOR UNITARIO:</label>
					</th>
					<td>
						<input type="text" class="form-control" id="validationCustom03" required="" value="<?php echo $ValorUnitario; ?>" name="IVA_FACTURA" placeholder="VALOR UNITARIO" readonly="readonly">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">BASE:</label>
					</th>
					<td>
						<input type="text" class="form-control" id="validationCustom03" required="" value="<?php echo $IVA_FACTURA; ?>" name="IVA_FACTURA" placeholder="BASE" readonly="readonly">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">IMPUESTO:</label>
					</th>
					<td>
						<input type="text" class="form-control" id="validationCustom03" required="" value="<?php echo $IVA_FACTURA; ?>" name="IVA_FACTURA" placeholder="IMPUESTO" readonly="readonly">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">TASA O CUOTA:</label>
					</th>
					<td>
						<input type="text" class="form-control" id="validationCustom03" required="" value="<?php echo $IVA_FACTURA; ?>" name="IVA_FACTURA" placeholder="TASA O CUOTA" readonly="readonly">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">TIPO FACTOR:</label>
					</th>
					<td>
						<input type="text" class="form-control" id="validationCustom03" required="" value="<?php echo $IVA_FACTURA; ?>" name="IVA_FACTURA" placeholder="TIPO FACTOR" readonly="readonly">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">IVA:</label>
					</th>
					<td>
						<input type="text" class="form-control" id="validationCustom03" required="" value="<?php echo $TImpuestosTrasladados; ?>" name="IVA_FACTURA" placeholder="IVA" readonly="readonly">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">IMPUESTOS RETENIDOS:</label>
					</th>
					<td>
						<input type="text" class="form-control" id="validationCustom03" required="" value="<?php echo $TImpuestosRetenidos; ?>" name="TImpuestosRetenidos" placeholder="IMPUESTOS RETENIDO" readonly="readonly">
					</td>
				</tr>
			
				<tr>
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">TUA:</label>
					</th>
					<td>
						<input type="text" class="form-control" id="validationCustom03" required="" value="<?php echo $TUA_FACTURA; ?>" name="TUA_FACTURA" placeholder="TUA" readonly="readonly">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">I.S.H:</label>
					</th>
					<td>
						<input type="text" class="form-control" id="validationCustom03" required="" value="<?php echo $ISH_FACTURA; ?>" name="ISH_FACTURA" placeholder="I.S.H" readonly="readonly">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">IEPS:</label>
					</th>
					<td>
						<input type="text" class="form-control" id="validationCustom03" required="" value="<?php echo $IEPS_FACTURA; ?>" name="IEPS_FACTURA" placeholder="IEPS" readonly="readonly">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">PROPINA:</label>
					</th>
					<td>
						<input type="text" class="form-control" id="validationCustom03" required="" value="<?php echo $PROPINA_FACTURA; ?>" name="PROPINA_FACTURA" placeholder="PROPINA" readonly="readonly">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">OTRO:</label>
					</th>
					<td>
						<input type="text" class="form-control" id="validationCustom03" required="" value="<?php echo $OTRO_FACTURA; ?>" name="OTRO_FACTURA" placeholder="OTRO" readonly="readonly">
					</td>
				</tr>
                 <tr>
                    <th scope="row"> <label for="validationCustom03" class="form-label">TOTAL:</label></th>
                 <td><input type="text" class="form-control" id="validationCustom03" required=""  value="<?php echo $total; ?>" name="TOTAL_FACTURA" placeholder="TOTAL" readonly="readonly"></td>
                 </tr>
				<tr>
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">MONEDA:</label>
					</th>
					<td>
						<input type="text" class="form-control" id="validationCustom03" required="" value="<?php echo $Moneda; ?>" name="MONEDA_FACTURA" placeholder="MONEDA" readonly="readonly">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">MONEDA EXTRANJERA:</label>
					</th>
					<td>
						<input type="text" class="form-control" id="validationCustom03" required="" value="<?php echo $MONEDA_EXTRANGERA_FACTURA; ?>" name="MONEDA_EXTRNGERA_FACTURA" placeholder="MONEDA EXTRANJERA" readonly="readonly">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">TIPO DE CAMBIO:</label>
					</th>
					<td>
						<input type="text" class="form-control" id="validationCustom03" required="" value="<?php echo $TipoCambio; ?>" name="TIPO_DE_CAMBIO" placeholder="TIPO DE CAMBIO" readonly="readonly">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">USO DE CFDI:</label>
					</th>
					<td>
						<input type="text" class="form-control" id="validationCustom03" required="" value="<?php echo $UsoCFDI; ?>" name="USO_CFDI_FACTURA" placeholder="USO DE CFDI" readonly="readonly">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">FORMA DE PAGO:</label>
					</th>
					<td>
						<input type="text" class="form-control" id="validationCustom03" required="" value="<?php echo $formaDePago; ?>" name="FORMA_DE_PAGO_FACTURA" placeholder="FORMA DE PAGO" readonly="readonly">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">METODO DE PAGO:</label>
					</th>
					<td>
						<input type="text" class="form-control" id="validationCustom03" required="" value="<?php echo $metodoDePago; ?>" name="METODO_DE_PAGO_FACTURA" placeholder="METODO DE PAGO" readonly="readonly">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">CONDICIONES DE PAGO:</label>
					</th>
					<td>
						<input type="text" class="form-control" id="validationCustom03" required="" value="<?php echo $CONDICIONES_DE_PAGO; ?>" name="CONDICIONES_DE_PAGO" placeholder="CONDICIONES DE PAGO" readonly="readonly">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">TIPO DE COMPROBANTE:</label>
					</th>
					<td>
						<input type="text" class="form-control" id="validationCustom03" required="" value="<?php echo $tipoDeComprobante; ?>" name="TIPO_DE_COMPROBANTE" placeholder="TIPO DE COMPROBANTE" readonly="readonly">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">CLAVE DE UNIDAD:</label>
					</th>
					<td>
						<input type="text" class="form-control" id="validationCustom03" required="" value="<?php echo $TIPO_DE_COMPROBANTE; ?>" name="TIPO_DE_COMPROBANTE" placeholder="CLAVE DE UNIDAD" readonly="readonly">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">VERSIÓN:</label>
					</th>
					<td>
						<input type="text" class="form-control" id="validationCustom03" required="" value="<?php echo $Version; ?>" name="TIPO_DE_COMPROBANTE" placeholder="VERSION" readonly="readonly">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label style="width:300px" for="validationCustom03" class="form-label">FECHA DE TIMBRADO:</label>
					</th>
					<td>
						<input type="text" class="form-control" id="validationCustom03" required="" value="<?php echo $FechaTimbrado; ?>" name="TIPO_DE_COMPROBANTE" placeholder="TIPO DE COMPROBANTE" readonly="readonly">
					</td>
				</tr>
			</table>
			<table style="text-align:right;">
				<tr>
					<td>
						<?php if($conexion->variablespermisos('','PAGO_PROVEEDOR1','guardar')=='si'){ ?>
							<button class="btn btn-primary" type="button" id="enviarPAGOPROVEEDORES">GUARDAR</button>
							<div style="
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
}" id="mensajepagoproveedores" /> </td>
					<?php } ?>
				</tr>
			</table>
			</form>
		</div>
		</div>
		</div>
		</div>