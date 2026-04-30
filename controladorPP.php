<?php
/*
fecha sandor: 
fecha fatis : 03/04/2024
*/
?>



<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    }

define('__ROOT1__', dirname(dirname(__FILE__)));
include_once (__ROOT1__."/includes/error_reporting.php");
include_once (__ROOT1__."/pagoproveedores/class.epcinnPP.php");

$pagoproveedores= NEW accesoclase();
$conexion = NEW colaboradores();
$conexion2 = new herramientas();

if(!function_exists('normalizarTextoEmpresaVO')){
	function normalizarTextoEmpresaVO($texto){
		$texto = mb_strtoupper(trim((string)$texto), 'UTF-8');
		$texto = preg_replace('/\s+/', ' ', $texto);
		return $texto;
	}
}

if(!function_exists('esReceptorCorporativoVO')){
	function esReceptorCorporativoVO($nombreReceptor){
		$nombreNormalizado = normalizarTextoEmpresaVO($nombreReceptor);
		$empresasCorporativo = array(
			normalizarTextoEmpresaVO('EVENTOS PROMOCIONES Y CONVENCIONES'),
			normalizarTextoEmpresaVO('INNOVA CONGRESOS Y CONVENCIONES'),
			normalizarTextoEmpresaVO('EVENTOS 520')
		);
		return $nombreNormalizado !== '' && in_array($nombreNormalizado, $empresasCorporativo);
	}
}
                                               

$hiddenpagoproveedores = isset($_POST["hiddenpagoproveedores"])?$_POST["hiddenpagoproveedores"]:"";
$validaDATOSBANCARIOS1 = isset($_POST["validaDATOSBANCARIOS1"])?$_POST["validaDATOSBANCARIOS1"]:"";
$ENVIARRdatosbancario1p = isset($_POST["ENVIARRdatosbancario1p"])?$_POST["ENVIARRdatosbancario1p"]:"";
$borrapagoaproveedores = isset($_POST["borrapagoaproveedores"])?$_POST["borrapagoaproveedores"]:"";
$borra_datos_bancario1 = isset($_POST["borra_datos_bancario1"])?$_POST["borra_datos_bancario1"]:"";
$ENVIARPAGOprovee = isset($_POST["ENVIARPAGOprovee"])?$_POST["ENVIARPAGOprovee"]:""; 
$borrasb = isset($_POST["borrasb"])?$_POST["borrasb"]:""; 
$borrasbdoc = isset($_POST["borrasbdoc"])?$_POST["borrasbdoc"]:"";

$pasarpagado_text = isset($_POST["pasarpagado_text"])?$_POST["pasarpagado_text"]:"";
$pasarpagado_id = isset($_POST["pasarpagado_id"])?$_POST["pasarpagado_id"]:"";

$busqueda = isset($_POST["busqueda"])?$_POST["busqueda"]:"";

$AUDITORIA1_id = isset($_POST["AUDITORIA1_id"])?$_POST["AUDITORIA1_id"]:"";
$AUDITORIA1_text = isset($_POST["AUDITORIA1_text"])?$_POST["AUDITORIA1_text"]:"";

if($AUDITORIA1_id!='' and ($AUDITORIA1_text=='si' or $AUDITORIA1_text=='no') ){	
echo $pagoproveedores->ACTUALIZA_AUDITORIA1 ($AUDITORIA1_id , $AUDITORIA1_text  );
}

$CHECKBOX_id = isset($_POST["CHECKBOX_id"]) ? $_POST["CHECKBOX_id"] : "";
$CHECKBOX_text = isset($_POST["CHECKBOX_text"]) ? $_POST["CHECKBOX_text"] : "";

if($CHECKBOX_id != '' && ($CHECKBOX_text == 'si' || $CHECKBOX_text == 'no')) {
    echo $pagoproveedores->ACTUALIZA_CHECKBOX($CHECKBOX_id, $CHECKBOX_text);
}

$AUDITORIA3_id = isset($_POST["AUDITORIA3_id"])?$_POST["AUDITORIA3_id"]:"";
$AUDITORIA3_text = isset($_POST["AUDITORIA3_text"])?$_POST["AUDITORIA3_text"]:"";

if($AUDITORIA3_id!='' and ($AUDITORIA3_text=='si' or $AUDITORIA3_text=='no') ){	
echo $pagoproveedores->ACTUALIZA_AUDITORIA3 ($AUDITORIA3_id , $AUDITORIA3_text  );
}

$SINXML_id = isset($_POST["SINXML_id"])?$_POST["SINXML_id"]:"";
$SINXML_text = isset($_POST["SINXML_text"])?$_POST["SINXML_text"]:"";

if($SINXML_id!='' and ($SINXML_text=='si' or $SINXML_text=='no') ){	
echo $pagoproveedores->ACTUALIZA_SINXML ($SINXML_id , $SINXML_text  );
}

$AUDITORIA2_id = isset($_POST["AUDITORIA2_id"])?$_POST["AUDITORIA2_id"]:"";
$AUDITORIA2_text = isset($_POST["AUDITORIA2_text"])?$_POST["AUDITORIA2_text"]:"";

if($AUDITORIA2_id!='' and ($AUDITORIA2_text=='si' or $AUDITORIA2_text=='no') ){	
echo $pagoproveedores->ACTUALIZA_AUDITORIA2 ($AUDITORIA2_id , $AUDITORIA2_text  );
}

$RECHAZADO_id = isset($_POST["RECHAZADO_id"])?$_POST["RECHAZADO_id"]:"";
$RECHAZADO_text = isset($_POST["RECHAZADO_text"])?$_POST["RECHAZADO_text"]:"";

if($RECHAZADO_id!='' and ($RECHAZADO_text=='si' or $RECHAZADO_text=='no') ){
echo $pagoproveedores->ACTUALIZA_RECHAZADO($RECHAZADO_id, $RECHAZADO_text);
}

$RECHAZO_MOTIVO_id = isset($_POST["RECHAZO_MOTIVO_id"])?$_POST["RECHAZO_MOTIVO_id"]:"";
$RECHAZO_MOTIVO_text = isset($_POST["RECHAZO_MOTIVO_text"])?$_POST["RECHAZO_MOTIVO_text"]:"";

if($RECHAZO_MOTIVO_id!='' and trim($RECHAZO_MOTIVO_text) != ''){
	echo $pagoproveedores->guardar_motivo_rechazo($RECHAZO_MOTIVO_id, $RECHAZO_MOTIVO_text);
	exit;
}

$RECHAZO_MOTIVO_VER_id = isset($_POST["RECHAZO_MOTIVO_VER_id"])?$_POST["RECHAZO_MOTIVO_VER_id"]:"";
if($RECHAZO_MOTIVO_VER_id!=''){
	echo $pagoproveedores->obtener_motivo_rechazo($RECHAZO_MOTIVO_VER_id);
	exit;
}

$VENTAS_id = isset($_POST["VENTAS_id"])?$_POST["VENTAS_id"]:"";
$VENTAS_text = isset($_POST["VENTAS_text"])?$_POST["VENTAS_text"]:"";

if($VENTAS_id!='' and ($VENTAS_text=='si' or $VENTAS_text=='no') ){	
echo $pagoproveedores->ACTUALIZA_VENTAS ($VENTAS_id , $VENTAS_text  );
}

$FINANZAS_id = isset($_POST["FINANZAS_id"])?$_POST["FINANZAS_id"]:"";
$FINANZAS_text = isset($_POST["FINANZAS_text"])?$_POST["FINANZAS_text"]:"";

if($FINANZAS_id!='' and ($FINANZAS_text=='si' or $FINANZAS_text=='no') ){	
echo $pagoproveedores->ACTUALIZA_FINANZAS ($FINANZAS_id , $FINANZAS_text  );
}

$RESPONSABLE_EVENTO_id = isset($_POST["RESPONSABLE_EVENTO_id"])?$_POST["RESPONSABLE_EVENTO_id"]:"";
$RESPONSABLE_text = isset($_POST["RESPONSABLE_text"])?$_POST["RESPONSABLE_text"]:"";

if($RESPONSABLE_EVENTO_id!='' and ($RESPONSABLE_text=='si' or $RESPONSABLE_text=='no') ){	
echo $pagoproveedores->ACTUALIZA_RESPONSABLE_EVENTO ($RESPONSABLE_EVENTO_id , $RESPONSABLE_text  );
}

if($busqueda==true){
	 $resultado = $pagoproveedores->buscarnumero($busqueda);
	 echo json_encode($resultado);
}

if($pasarpagado_id!='' and ($pasarpagado_text=='si' or $pasarpagado_text=='no') ){	
echo $pagoproveedores->PASARPAGADOACTUALIZAR ($pasarpagado_id , $pasarpagado_text  );
}

$action = isset($_POST["action"])?$_POST["action"]:"";
if($action=='total_menos_dep'){
$total_menos_depositado = isset($_POST["total_menos_depositado"])?$_POST["total_menos_depositado"]:"";
$numero_evento2a = isset($_POST["numero_evento2a"])?$_POST["numero_evento2a"]:"";
	echo $resultado = $pagoproveedores->pendiente_pago($total_menos_depositado,$numero_evento2a);
}

if($action=='ajax'){
	$NUMERO_EVENTO = isset($_POST["NUMERO_EVENTO"])?$_POST["NUMERO_EVENTO"]:"";
	echo $resultado = $pagoproveedores->buscarnombre($NUMERO_EVENTO);
}

if($action=='ciudad_valor'){
	$NUMERO_EVENTO = isset($_POST["NUMERO_EVENTO"])?$_POST["NUMERO_EVENTO"]:"";
	echo $resultado = $pagoproveedores->buscarciudad($NUMERO_EVENTO);
}

if($action=='bitacora'){
	$idSubetufactura = isset($_POST["idSubetufactura"])?$_POST["idSubetufactura"]:"";
	$bitacora = $pagoproveedores->Listado_bitacora_pagoproveedor_array($idSubetufactura);
	echo json_encode($bitacora);
	exit;
}
 
if($hiddenpagoproveedores == 'hiddenpagoproveedores' or $ENVIARPAGOprovee == 'ENVIARPAGOprovee'){            

$NUMERO_CONSECUTIVO_PROVEE = isset($_POST["NUMERO_CONSECUTIVO_PROVEE"])?$_POST["NUMERO_CONSECUTIVO_PROVEE"]:"";
$NOMBRE_COMERCIAL23 = isset($_POST["NOMBRE_COMERCIAL23"])?$_POST["NOMBRE_COMERCIAL23"]:"";
$ID_RELACIONADO = isset($_POST["ID_RELACIONADO"])?$_POST["ID_RELACIONADO"]:"";
$NOMBRE_COMERCIAL = isset($_POST["NOMBRE_COMERCIAL"])?$_POST["NOMBRE_COMERCIAL"]:"";
$RAZON_SOCIAL = isset($_POST["RAZON_SOCIAL"])?$_POST["RAZON_SOCIAL"]:"";
$VIATICOSOPRO = isset($_POST["VIATICOSOPRO"])?$_POST["VIATICOSOPRO"]:"";
$RFC_PROVEEDOR = isset($_POST["RFC_PROVEEDOR"])?$_POST["RFC_PROVEEDOR"]:"";
$NUMERO_EVENTO = isset($_POST["NUMERO_EVENTO"])?$_POST["NUMERO_EVENTO"]:"";
$NOMBRE_EVENTO = isset($_POST["NOMBRE_EVENTO"])?$_POST["NOMBRE_EVENTO"]:"";
$MOTIVO_GASTO = isset($_POST["MOTIVO_GASTO"])?$_POST["MOTIVO_GASTO"]:"";
$CONCEPTO_PROVEE = isset($_POST["CONCEPTO_PROVEE"])?$_POST["CONCEPTO_PROVEE"]:"";
$MONTO_TOTAL_COTIZACION_ADEUDO = isset($_POST["MONTO_TOTAL_COTIZACION_ADEUDO"])?$_POST["MONTO_TOTAL_COTIZACION_ADEUDO"]:"";
$MONTO_DEPOSITAR = isset($_POST["MONTO_DEPOSITAR"])?$_POST["MONTO_DEPOSITAR"]:"";
$MONTO_PROPINA = isset($_POST["MONTO_PROPINA"])?$_POST["MONTO_PROPINA"]:"";
$PENDIENTE_PAGO = isset($_POST["PENDIENTE_PAGO"])?$_POST["PENDIENTE_PAGO"]:"";
$FECHA_AUTORIZACION_RESPONSABLE = isset($_POST["FECHA_AUTORIZACION_RESPONSABLE"])?$_POST["FECHA_AUTORIZACION_RESPONSABLE"]:"";
$FECHA_AUTORIZACION_AUDITORIA = isset($_POST["FECHA_AUTORIZACION_AUDITORIA"])?$_POST["FECHA_AUTORIZACION_AUDITORIA"]:"";
$FECHA_DE_LLENADO = isset($_POST["FECHA_DE_LLENADO"])?$_POST["FECHA_DE_LLENADO"]:"";
$MONTO_FACTURA = isset($_POST["MONTO_FACTURA"])?$_POST["MONTO_FACTURA"]:"";
$TIPO_DE_MONEDA = isset($_POST["TIPO_DE_MONEDA"])?$_POST["TIPO_DE_MONEDA"]:"";
$PFORMADE_PAGO = isset($_POST["PFORMADE_PAGO"])?$_POST["PFORMADE_PAGO"]:"";
$FECHA_DE_PAGO = isset($_POST["FECHA_DE_PAGO"])?$_POST["FECHA_DE_PAGO"]:"";
$FECHA_A_DEPOSITAR = isset($_POST["FECHA_A_DEPOSITAR"])?$_POST["FECHA_A_DEPOSITAR"]:"";
$STATUS_DE_PAGO = isset($_POST["STATUS_DE_PAGO"])?$_POST["STATUS_DE_PAGO"]:"";
$ACTIVO_FIJO = isset($_POST["ACTIVO_FIJO"])?$_POST["ACTIVO_FIJO"]:"";
$GASTO_FIJO = isset($_POST["GASTO_FIJO"])?$_POST["GASTO_FIJO"]:"";
$PAGAR_CADA = isset($_POST["PAGAR_CADA"])?$_POST["PAGAR_CADA"]:"";
$FECHA_PPAGO = isset($_POST["FECHA_PPAGO"])?$_POST["FECHA_PPAGO"]:"";
$FECHA_TPROGRAPAGO = isset($_POST["FECHA_TPROGRAPAGO"])?$_POST["FECHA_TPROGRAPAGO"]:"";
$NUMERO_EVENTOFIJO = isset($_POST["NUMERO_EVENTOFIJO"])?$_POST["NUMERO_EVENTOFIJO"]:"";
$CLASI_GENERAL = isset($_POST["CLASI_GENERAL"])?$_POST["CLASI_GENERAL"]:"";
$SUB_GENERAL = isset($_POST["SUB_GENERAL"])?$_POST["SUB_GENERAL"]:"";
$BANCO_ORIGEN = isset($_POST["BANCO_ORIGEN"])?$_POST["BANCO_ORIGEN"]:"";
$MONTO_DEPOSITADO = isset($_POST["MONTO_DEPOSITADO"])?$_POST["MONTO_DEPOSITADO"]:"";
$CLASIFICACION_GENERAL = isset($_POST["CLASIFICACION_GENERAL"])?$_POST["CLASIFICACION_GENERAL"]:"";
$CLASIFICACION_ESPECIFICA = isset($_POST["CLASIFICACION_ESPECIFICA"])?$_POST["CLASIFICACION_ESPECIFICA"]:"";
$PLACAS_VEHICULO = isset($_POST["PLACAS_VEHICULO"])?$_POST["PLACAS_VEHICULO"]:"";
$MONTO_DE_COMISION = isset($_POST["MONTO_DE_COMISION"])?$_POST["MONTO_DE_COMISION"]:"";
$POLIZA_NUMERO = isset($_POST["POLIZA_NUMERO"])?$_POST["POLIZA_NUMERO"]:"";
$NOMBRE_DEL_EJECUTIVO = isset($_POST["NOMBRE_DEL_EJECUTIVO"])?$_POST["NOMBRE_DEL_EJECUTIVO"]:"";
$NOMBRE_DEL_AYUDO = isset($_POST["NOMBRE_DEL_AYUDO"])?$_POST["NOMBRE_DEL_AYUDO"]:"";
$OBSERVACIONES_1 = isset($_POST["OBSERVACIONES_1"])?$_POST["OBSERVACIONES_1"]:"";
$TIPO_CAMBIOP = isset($_POST["TIPO_CAMBIOP"])?$_POST["TIPO_CAMBIOP"]:"";
$TOTAL_ENPESOS = isset($_POST["TOTAL_ENPESOS"])?$_POST["TOTAL_ENPESOS"]:"";
$IMPUESTO_HOSPEDAJE = isset($_POST["IMPUESTO_HOSPEDAJE"])?$_POST["IMPUESTO_HOSPEDAJE"]:"";
$TImpuestosRetenidosIVA = isset($_POST["TImpuestosRetenidosIVA"])?$_POST["TImpuestosRetenidosIVA"]:"";
$TImpuestosRetenidosISR = isset($_POST["TImpuestosRetenidosISR"])?$_POST["TImpuestosRetenidosISR"]:"";
$descuentos = isset($_POST["descuentos"])?$_POST["descuentos"]:"";
$IVA = isset($_POST["IVA"])?$_POST["IVA"]:"";
$hiddenpagoproveedores = isset($_POST["hiddenpagoproveedores"])?$_POST["hiddenpagoproveedores"]:""; 
$IPpagoprovee = isset($_POST["IPpagoprovee"])?$_POST["IPpagoprovee"]:""; 
$FechaTimbrado = isset($_POST["FechaTimbrado"])?$_POST["FechaTimbrado"]:""; 
$tipoDeComprobante = isset($_POST["tipoDeComprobante"])?$_POST["tipoDeComprobante"]:""; 
$metodoDePago = isset($_POST["metodoDePago"])?$_POST["metodoDePago"]:""; 
$formaDePago = isset($_POST["formaDePago"])?$_POST["formaDePago"]:""; 
$condicionesDePago = isset($_POST["condicionesDePago"])?$_POST["condicionesDePago"]:""; 
$subTotal = isset($_POST["subTotal"])?$_POST["subTotal"]:""; 
$TipoCambio = isset($_POST["TipoCambio"])?$_POST["TipoCambio"]:""; 
$Moneda = isset($_POST["Moneda"])?$_POST["Moneda"]:""; 
$total = isset($_POST["total"])?$_POST["total"]:""; 
$serie = isset($_POST["serie"])?$_POST["serie"]:""; 
$folio = isset($_POST["folio"])?$_POST["folio"]:""; 
$LugarExpedicion = isset($_POST["LugarExpedicion"])?$_POST["LugarExpedicion"]:""; 
$rfcE = isset($_POST["rfcE"])?$_POST["rfcE"]:"";
$nombreE = isset($_POST["nombreE"])?$_POST["nombreE"]:""; 
$regimenE = isset($_POST["regimenE"])?$_POST["regimenE"]:""; 
$rfcR = isset($_POST["rfcR"])?$_POST["rfcR"]:""; 
$nombreR = isset($_POST["nombreR"])?$_POST["nombreR"]:""; 
$UsoCFDI = isset($_POST["UsoCFDI"])?$_POST["UsoCFDI"]:""; 
$DomicilioFiscalReceptor = isset($_POST["DomicilioFiscalReceptor"])?$_POST["DomicilioFiscalReceptor"]:""; 
$RegimenFiscalReceptor = isset($_POST["RegimenFiscalReceptor"])?$_POST["RegimenFiscalReceptor"]:""; 
$UUID = isset($_POST["UUID"])?$_POST["UUID"]:""; 
$TImpuestosRetenidos = isset($_POST["TImpuestosRetenidos"])?$_POST["TImpuestosRetenidos"]:""; 
$TImpuestosTrasladados = isset($_POST["TImpuestosTrasladados"])?$_POST["TImpuestosTrasladados"]:"";
$TuaTotalCargos = isset($_POST["TuaTotalCargos"])?$_POST["TuaTotalCargos"]:"";
$TUA = isset($_POST["TUA"])?$_POST["TUA"]:"";
$Descuento = isset($_POST["Descuento"])?$_POST["Descuento"]:"";
$Propina = isset($_POST["Propina"])?$_POST["Propina"]:"";
$actualiza = isset($_POST["actualiza"])?$_POST["actualiza"]:"";
$DescripcionConcepto = isset($_POST["DescripcionConcepto"])?$_POST["DescripcionConcepto"]:"";

	if($NOMBRE_COMERCIAL == '' and $NOMBRE_COMERCIAL23 != ''){
		$NOMBRE_COMERCIAL = $NOMBRE_COMERCIAL23;
	}
	
if( $NUMERO_EVENTO == "" OR $NOMBRE_COMERCIAL == "" OR $MOTIVO_GASTO == "" OR $FECHA_DE_PAGO == "" OR $MONTO_FACTURA == ""){
	echo "<P style='color:red; font-size:23px;'>FAVOR DE LLENAR CAMPOS OBLIGATORIOS</p>";
}else{		
	$esAltaNueva = ($ENVIARPAGOprovee == 'ENVIARPAGOprovee' && trim((string)$IPpagoprovee) == '');
	if ($esAltaNueva) {
		$huellaPago = md5(implode('|', array(
			trim((string)$NUMERO_EVENTO),
			trim((string)$NOMBRE_COMERCIAL),
			trim((string)$RFC_PROVEEDOR),
			trim((string)$MONTO_TOTAL_COTIZACION_ADEUDO),
			trim((string)$MONTO_DEPOSITAR),
			trim((string)$FECHA_DE_PAGO),
			trim((string)$UUID)
		)));
		$ultimoHashPago = isset($_SESSION['pp_ultimo_guardado_hash']) ? $_SESSION['pp_ultimo_guardado_hash'] : '';
		$ultimoHashTiempo = isset($_SESSION['pp_ultimo_guardado_ts']) ? intval($_SESSION['pp_ultimo_guardado_ts']) : 0;

		if ($ultimoHashPago === $huellaPago && $ultimoHashTiempo > 0 && (time() - $ultimoHashTiempo) <= 8) {
			echo "Ingresado";
			exit;
		}

		$_SESSION['pp_ultimo_guardado_hash'] = $huellaPago;
		$_SESSION['pp_ultimo_guardado_ts'] = time();
	}
	
echo $pagoproveedores->PAGOPRO ($NUMERO_CONSECUTIVO_PROVEE , $ID_RELACIONADO,$NOMBRE_COMERCIAL , $RAZON_SOCIAL ,$VIATICOSOPRO, $RFC_PROVEEDOR , $NUMERO_EVENTO ,$NOMBRE_EVENTO, $MOTIVO_GASTO , $CONCEPTO_PROVEE , $MONTO_TOTAL_COTIZACION_ADEUDO , $MONTO_DEPOSITAR , $MONTO_PROPINA ,$PENDIENTE_PAGO, $FECHA_AUTORIZACION_RESPONSABLE , $FECHA_AUTORIZACION_AUDITORIA , $FECHA_DE_LLENADO , $MONTO_FACTURA , $TIPO_DE_MONEDA , $PFORMADE_PAGO,$FECHA_DE_PAGO , $FECHA_A_DEPOSITAR , $STATUS_DE_PAGO ,$ACTIVO_FIJO, $GASTO_FIJO,$PAGAR_CADA,$FECHA_PPAGO,$FECHA_TPROGRAPAGO,$NUMERO_EVENTOFIJO,$CLASI_GENERAL,$SUB_GENERAL,$BANCO_ORIGEN , $MONTO_DEPOSITADO , $CLASIFICACION_GENERAL , $CLASIFICACION_ESPECIFICA , $PLACAS_VEHICULO , $MONTO_DE_COMISION , $POLIZA_NUMERO , $NOMBRE_DEL_EJECUTIVO ,$NOMBRE_DEL_AYUDO, $OBSERVACIONES_1 , $TIPO_CAMBIOP,  $TOTAL_ENPESOS,$IMPUESTO_HOSPEDAJE,$TImpuestosRetenidosIVA,$TImpuestosRetenidosISR,$descuentos,$IVA, $ENVIARPAGOprovee,$hiddenpagoproveedores,$IPpagoprovee,
	$FechaTimbrado, $tipoDeComprobante, 
		$metodoDePago, $formaDePago, $condicionesDePago, $subTotal, 
		$TipoCambio, $Moneda, $total, $serie, 
		$folio, $LugarExpedicion, $rfcE, $nombreE, 
		$regimenE, $rfcR, $nombreR, $UsoCFDI, 
		$DomicilioFiscalReceptor, $RegimenFiscalReceptor, $UUID, $TImpuestosRetenidos, 
		$TImpuestosTrasladados, $TuaTotalCargos, $Descuento,$Propina, $TUA, $actualiza,  $DescripcionConcepto);
}
}
elseif($borrapagoaproveedores == 'borrapagoaproveedores'){
	$borra_id_PAGOP = isset($_POST["borra_id_PAGOP"])?$_POST["borra_id_PAGOP"]:"";   
	echo  $pagoproveedores->borrapagoaproveedores($borra_id_PAGOP);
}



elseif($borrasbdoc =='borrasbdoc'){
	$borra_id_sb = isset($_POST["borra_id_sb"])?$_POST["borra_id_sb"]:"";   
	echo  $pagoproveedores->delete_subefacturadocto2($borra_id_sb);
}


// ── VALIDACIÓN DE FORMATO DE ARCHIVOS ─────────────────────────────────────

$xmlFacturaInvalido = isset($_FILES['ADJUNTAR_FACTURA_XML'])
	&& is_array($_FILES['ADJUNTAR_FACTURA_XML'])
	&& isset($_FILES['ADJUNTAR_FACTURA_XML']['error'])
	&& intval($_FILES['ADJUNTAR_FACTURA_XML']['error']) === 0
	&& strtolower(pathinfo(isset($_FILES['ADJUNTAR_FACTURA_XML']['name']) ? $_FILES['ADJUNTAR_FACTURA_XML']['name'] : '', PATHINFO_EXTENSION)) !== 'xml';

if($xmlFacturaInvalido){
	echo '4';
	exit;
}

$pdfFacturaInvalido = isset($_FILES['ADJUNTAR_FACTURA_PDF'])
	&& is_array($_FILES['ADJUNTAR_FACTURA_PDF'])
	&& isset($_FILES['ADJUNTAR_FACTURA_PDF']['error'])
	&& intval($_FILES['ADJUNTAR_FACTURA_PDF']['error']) === 0
	&& strtolower(pathinfo(isset($_FILES['ADJUNTAR_FACTURA_PDF']['name']) ? $_FILES['ADJUNTAR_FACTURA_PDF']['name'] : '', PATHINFO_EXTENSION)) !== 'pdf';

if($pdfFacturaInvalido){
	echo '4';
	exit;
}


// ── PRE-CARGA DEL XML ────────────────────────────────────────────────────

if( $_FILES["ADJUNTAR_FACTURA_XML"] == true){

	$ADJUNTAR_FACTURA_XML2 = $pagoproveedores->solocargartemp('ADJUNTAR_FACTURA_XML');
	$url = __ROOT1__.'/includes/archivos/'.$ADJUNTAR_FACTURA_XML2;	
	$regreso = $conexion2->lectorxml($url);

	// ── VALIDACIÓN: XML vacío o sin contenido válido ──────────────────────
	if(empty($regreso) || !isset($regreso['UUID']) || trim($regreso['UUID']) === '') {
		echo '5^^';
		UNLINK($url);
		$pagoproveedores->delete_subefactura2nombre($ADJUNTAR_FACTURA_XML2);
		exit;
	}
// ─────────────────────────────────────────────────────────────────────

	$nombreRxml = isset($regreso['nombreR']) ? trim((string)$regreso['nombreR']) : '';
	if($nombreRxml !== '' && !esReceptorCorporativoVO($nombreRxml)){
		echo '6^^'.$nombreRxml;
		UNLINK($url);
		$pagoproveedores->delete_subefactura2nombre($ADJUNTAR_FACTURA_XML2);
		exit;
	}

	$rfcE = $regreso['rfcE'];					
	$nombreE = $regreso['nombreE'];	
    $conn = $conexion->db();
    $idwebc = '';

    if ($pagoproveedores->verificar_rfc($conn, $rfcE) != '') {
        $idwebc = $pagoproveedores->verificar_rfc($conn, $rfcE);
    } elseif ($pagoproveedores->verificar_usuario($conn, $nombreE) != '') {
        $idwebc = $pagoproveedores->verificar_usuario($conn, $nombreE);
    } elseif (isset($_SESSION["idPROV"]) && $_SESSION["idPROV"] != '') {
        $idwebc = $_SESSION["idPROV"];
    } else {
        $idwebc = 1;
    }

	$_SESSION["idPROV"] = $idwebc;
}

$idPROV = isset($_SESSION["idPROV"])?$_SESSION["idPROV"]:$idwebc;
$IPpagoprovee = isset($_POST["IPpagoprovee"])?$_POST["IPpagoprovee"]:"";


// ── BLOQUE 1: Subida con IPpagoprovee (registro existente) ────────────────

if($IPpagoprovee !=''  and ($_FILES["ADJUNTAR_FACTURA_XML"] == true or $_FILES["ADJUNTAR_FACTURA_PDF"] == true or  $_FILES["ADJUNTAR_COTIZACION"] == true  or  $_FILES["CONPROBANTE_TRANSFERENCIA"] == true  or  $_FILES["ADJUNTAR_ARCHIVO_1"] == true or $_FILES["FOTO_ESTADO_PROVEE11"] == true  or  $_FILES["COMPLEMENTOS_PAGO_PDF"] == true or  $_FILES["COMPLEMENTOS_PAGO_XML"] == true or  $_FILES["CANCELACIONES_PDF"] == true or  $_FILES["CANCELACIONES_XML"] == true or  $_FILES ["ADJUNTAR_FACTURA_DE_COMISION_PDF"] == true or  $_FILES ["ADJUNTAR_FACTURA_DE_COMISION_XML"] == true or  $_FILES["CALCULO_DE_COMISION"] == true or  $_FILES["COMPROBANTE_DE_DEVOLUCION"] == true or  $_FILES["NOTA_DE_CREDITO_COMPRA"] == true )){
if($IPpagoprovee != ''){
foreach($_FILES AS $ETQIETA => $VALOR){

	if($_FILES['ADJUNTAR_FACTURA_XML']==true){
		// ── Verificar UUID ANTES de mover el archivo ──────────────────────
		$_resultadoUUID = $pagoproveedores->VALIDA02XMLUUID($regreso['UUID']);
		
		// ── CORRECCIÓN: comparar con lo que realmente retorna la función ──
		if(strpos($_resultadoUUID, '3^^') === 0) {
			// Duplicado en 02XML (Pago Proveedores)
			UNLINK(__ROOT1__.'/includes/archivos/'.$ADJUNTAR_FACTURA_XML2);
			$pagoproveedores->delete_subefactura2nombre($ADJUNTAR_FACTURA_XML2);
			echo $_resultadoUUID;
			exit;
		} elseif(strpos($_resultadoUUID, '7^^^') === 0) {
			// Duplicado en 07XML (Comprobación de Gastos)
			$_numSol7 = str_replace('7^^^', '', $_resultadoUUID);
			UNLINK(__ROOT1__.'/includes/archivos/'.$ADJUNTAR_FACTURA_XML2);
			$pagoproveedores->delete_subefactura2nombre($ADJUNTAR_FACTURA_XML2);
			echo '7^^^'.$_numSol7;
			exit;
		} elseif($_resultadoUUID !== 'S') {
			UNLINK(__ROOT1__.'/includes/archivos/'.$ADJUNTAR_FACTURA_XML2);
			$pagoproveedores->delete_subefactura2nombre($ADJUNTAR_FACTURA_XML2);
			echo '3^^';
			exit;
		}
		// ──────────────────────────────────────────────────────────────────
	ob_start();
	$ADJUNTAR_FACTURA_XML = $conexion->sologuardar6($ETQIETA,$ADJUNTAR_FACTURA_XML2,'02SUBETUFACTURADOCTOS',$idPROV,$IPpagoprovee);
	ob_end_clean();


	}else{
	$ADJUNTAR_FACTURA_XML = $conexion->cargar($ETQIETA,'02SUBETUFACTURADOCTOS','6',$IPpagoprovee,'si',$IPpagoprovee);
		if($_FILES['ADJUNTAR_FACTURA_PDF']==true){
			$pagoproveedores->borrar_pdfs(__ROOT1__.'/includes/archivos/',$IPpagoprovee,$ADJUNTAR_FACTURA_XML,'','02SUBETUFACTURADOCTOS');
		}	
	}

	$url ='';
	if($_FILES['ADJUNTAR_FACTURA_XML']==true){
		$url = __ROOT1__.'/includes/archivos/'.$ADJUNTAR_FACTURA_XML;
		if( file_exists($url) ){
			$regreso = $conexion2->lectorxml($url);

			// ── VALIDACIÓN: XML vacío ──────────────────────────────────────
			if(empty($regreso) || !isset($regreso['UUID']) || trim($regreso['UUID']) === '') {
				echo '5^^';
				UNLINK($url);
				$pagoproveedores->delete_subefactura2nombre($ADJUNTAR_FACTURA_XML);
				continue;
			}
			// ──────────────────────────────────────────────────────────────

			$nombreRxml = isset($regreso['nombreR']) ? trim((string)$regreso['nombreR']) : '';
			if($nombreRxml !== '' && !esReceptorCorporativoVO($nombreRxml)){
				echo '6^^'.$nombreRxml;
				UNLINK($url);
				$pagoproveedores->delete_subefactura2nombre($ADJUNTAR_FACTURA_XML);
				continue;
			}

			$resultado = $pagoproveedores->VALIDA02XMLUUID($regreso['UUID']);
			if($resultado == 'S'){
				$pagoproveedores->borrar_xmls(__ROOT1__.'/includes/archivos/',$IPpagoprovee,$ADJUNTAR_FACTURA_XML,'02XML','02SUBETUFACTURADOCTOS');
				echo $ADJUNTAR_FACTURA_XML.'^^'.$regreso['UUID'].'^^'.$regreso['formaDePago'].'^^'.$regreso['Descripcion'];
				ob_start();
				$pagoproveedores->guardarxmlDB2($IPpagoprovee,$idPROV,'02XML', $url);
				ob_end_clean();
				$pagoproveedores->registrar_bitacora_adjuntos($IPpagoprovee, 'XML', $_FILES[$ETQIETA]['name']);

			// ── CORRECCIÓN: comparar con '3^^' en vez de 'UUID_DUPLICADO:' ──
			} elseif(strpos($resultado, '3^^') === 0) {
				// Duplicado en 02XML (Pago Proveedores)
				echo $resultado;
				UNLINK($url);
				$pagoproveedores->delete_subefactura2nombre($ADJUNTAR_FACTURA_XML);

			// ── CORRECCIÓN: comparar con '7^^^' en vez de 'UUID_DUPLICADO_07:' ──
			} elseif(strpos($resultado, '7^^^') === 0) {
				// Duplicado en 07XML (Comprobación de Gastos)
				$numeroGasto = str_replace('7^^^', '', $resultado);
				echo '7^^^'.$numeroGasto;
				UNLINK($url);
				$pagoproveedores->delete_subefactura2nombre($ADJUNTAR_FACTURA_XML);

			} else {
				// UUID duplicado sin número
				echo '3^^';
				UNLINK($url);
				$pagoproveedores->delete_subefactura2nombre($ADJUNTAR_FACTURA_XML);
			}
		}
	}else{
	
		if($ADJUNTAR_FACTURA_XML != ''){
			$tipoLabel = ($ETQIETA == 'ADJUNTAR_FACTURA_PDF') ? 'PDF' : $ETQIETA;
			$pagoproveedores->registrar_bitacora_adjuntos($IPpagoprovee, $tipoLabel, $_FILES[$ETQIETA]['name']);

		}


		echo $ADJUNTAR_FACTURA_XML;
	}
}

}else{ echo "no hay usuario seleccionado";}
}


// ── BLOQUE 2: Subida sin IPpagoprovee (registro nuevo) ───────────────────

if($IPpagoprovee =='' and $hiddenpagoproveedores != 'hiddenpagoproveedores' and ($_FILES["ADJUNTAR_FACTURA_XML"] == true or $_FILES["ADJUNTAR_FACTURA_PDF"] == true or  $_FILES["ADJUNTAR_COTIZACION"] == true  or  $_FILES["CONPROBANTE_TRANSFERENCIA"] == true  or  $_FILES["ADJUNTAR_ARCHIVO_1"] == true  or $_FILES["FOTO_ESTADO_PROVEE11"] ==  true or  $_FILES["COMPLEMENTOS_PAGO_PDF"] == true or  $_FILES["COMPLEMENTOS_PAGO_XML"] == true or  $_FILES["CANCELACIONES_PDF"] == true or  $_FILES["CANCELACIONES_XML"] == true or  $_FILES ["ADJUNTAR_FACTURA_DE_COMISION_PDF"] == true or  $_FILES ["ADJUNTAR_FACTURA_DE_COMISION_XML"] == true or  $_FILES["CALCULO_DE_COMISION"] == true or  $_FILES["COMPROBANTE_DE_DEVOLUCION"] == true or  $_FILES["NOTA_DE_CREDITO_COMPRA"] == true )){
if($idPROV != ''){
foreach($_FILES AS $ETQIETA => $VALOR){

	if($_FILES['ADJUNTAR_FACTURA_XML']==true){
	$idem1 = $_SESSION['idem'];
	$ADJUNTAR_FACTURA_XML = $conexion->sologuardar6_usuario($ETQIETA,$ADJUNTAR_FACTURA_XML2,'02SUBETUFACTURADOCTOS',$idPROV,$IPpagoprovee,$idem1,'xml');	
	}else{
	$idem1 = $_SESSION['idem'];
	$ADJUNTAR_FACTURA_XML = $conexion->cargar($ETQIETA,'02SUBETUFACTURADOCTOS','8',$idPROV,'si','',$idem1);
	}

	$url ='';
	if($_FILES['ADJUNTAR_FACTURA_XML']==true){
		$url = __ROOT1__.'/includes/archivos/'.$ADJUNTAR_FACTURA_XML;
		if( file_exists($url) ){
			$regreso = $conexion2->lectorxml($url);

			// ── VALIDACIÓN: XML vacío ──────────────────────────────────────
			if(empty($regreso) || !isset($regreso['UUID']) || trim($regreso['UUID']) === '') {
				echo '5^^';
				UNLINK($url);
				$pagoproveedores->delete_subefactura2nombre($ADJUNTAR_FACTURA_XML);
				continue;
			}
			// ──────────────────────────────────────────────────────────────

			$nombreRxml = isset($regreso['nombreR']) ? trim((string)$regreso['nombreR']) : '';
			if($nombreRxml !== '' && !esReceptorCorporativoVO($nombreRxml)){
				echo '6^^'.$nombreRxml;
				UNLINK($url);
				$pagoproveedores->delete_subefactura2nombre($ADJUNTAR_FACTURA_XML);
				continue;
			}

			$resultado = $pagoproveedores->VALIDA02XMLUUID($regreso['UUID']);
			if($resultado == 'S'){
				echo $ADJUNTAR_FACTURA_XML;

			// ── CORRECCIÓN: comparar con '3^^' en vez de 'UUID_DUPLICADO:' ──
			} elseif(strpos($resultado, '3^^') === 0) {
				// Duplicado en 02XML (Pago Proveedores)
				$numeroSolicitud = str_replace('3^^', '', $resultado);
				echo '3^^'.$numeroSolicitud;
				UNLINK($url);
				$pagoproveedores->delete_subefactura2nombre($ADJUNTAR_FACTURA_XML);

			// ── CORRECCIÓN: comparar con '7^^^' en vez de 'UUID_DUPLICADO_07:' ──
			} elseif(strpos($resultado, '7^^^') === 0) {
				// Duplicado en 07XML (Comprobación de Gastos)
				$numeroGasto = str_replace('7^^^', '', $resultado);
				echo '7^^^'.$numeroGasto;
				UNLINK($url);
				$pagoproveedores->delete_subefactura2nombre($ADJUNTAR_FACTURA_XML);

			} else {
				// UUID duplicado sin número
				echo '3^^';
				UNLINK($url);
				$pagoproveedores->delete_subefactura2nombre($ADJUNTAR_FACTURA_XML);
			}
		}
	}else{echo $ADJUNTAR_FACTURA_XML;}
}

}else{ echo "no hay usuario seleccionado";}
}

?>