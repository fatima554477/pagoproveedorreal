<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
 
define('__ROOT1__', dirname(dirname(__FILE__)));
include_once (__ROOT1__."/includes/error_reporting.php");
include_once (__ROOT1__."/comprobaciones/class.epcinnPP.php");
 
$pagoproveedores= NEW accesoclase();
$conexion = NEW colaboradores();
$conexion2 = new herramientas();
 
function normalizarTextoEmpresaVO($texto){
    $texto = mb_strtoupper(trim((string)$texto), 'UTF-8');
    $texto = preg_replace('/\s+/', ' ', $texto);
    return $texto;
}
 
function receptorPermitidoEmpresaVO($nombreReceptor){
    $empresasCorporativo = array(
        normalizarTextoEmpresaVO('EVENTOS PROMOCIONES Y CONVENCIONES'),
        normalizarTextoEmpresaVO('INNOVA CONGRESOS Y CONVENCIONES'),
        normalizarTextoEmpresaVO('EVENTOS 520')
    );
    $nombreReceptorNormalizado = normalizarTextoEmpresaVO($nombreReceptor);
    return $nombreReceptorNormalizado !== '' && in_array($nombreReceptorNormalizado, $empresasCorporativo, true);
}
 
$hiddenpagoproveedores = isset($_POST["hiddenpagoproveedores"])?$_POST["hiddenpagoproveedores"]:"";
$validaDATOSBANCARIOS1 = isset($_POST["validaDATOSBANCARIOS1"])?$_POST["validaDATOSBANCARIOS1"]:"";
$ENVIARRdatosbancario1p = isset($_POST["ENVIARRdatosbancario1p"])?$_POST["ENVIARRdatosbancario1p"]:"";
$borrapagoaproveedores = isset($_POST["borrapagoaproveedores"])?$_POST["borrapagoaproveedores"]:"";
$borra_datos_bancario1 = isset($_POST["borra_datos_bancario1"])?$_POST["borra_datos_bancario1"]:"";
$ENVIARPAGOprovee = isset($_POST["ENVIARPAGOprovee"])?$_POST["ENVIARPAGOprovee"]:"";
$borrasb = isset($_POST["borrasb"])?$_POST["borrasb"]:"";
$borrasbdoc = isset($_POST["borrasbdoc"])?$_POST["borrasbdoc"]:"";
$reset_historial_xml = isset($_POST["reset_historial_xml"])?$_POST["reset_historial_xml"]:"";
 
if($reset_historial_xml == '1' or $reset_historial_xml == 'true'){
    $idRelacionHistorial = isset($_SESSION["idCG"])?$_SESSION["idCG"]:"";
    if($idRelacionHistorial != ''){
        $pagoproveedores->limpiar_historial_factura_xml($idRelacionHistorial,__ROOT1__.'/includes/archivos/');
        echo "Historial limpiado";
    }else{
        echo "Sin relacion";
    }
    exit;
}
 
$busqueda = isset($_POST["busqueda"])?$_POST["busqueda"]:"";
$q = isset($_POST["q"])?$_POST["q"]:"";
 
$action = isset($_POST["action"])?$_POST["action"]:"";
if($action=='ajax'){
    $NUMERO_EVENTO = isset($_POST["NUMERO_EVENTO"])?$_POST["NUMERO_EVENTO"]:"";
    echo $resultado = $pagoproveedores->buscarnombre($NUMERO_EVENTO);
}
 
if($q==true){
    $json = [];
    $json = $pagoproveedores->buscarnumero2($q);
    echo json_encode($json);
}
 
$pasarpagado_text = isset($_POST["pasarpagado_text"])?$_POST["pasarpagado_text"]:"";
$pasarpagado_id = isset($_POST["pasarpagado_id"])?$_POST["pasarpagado_id"]:"";
 
$AUDITORIA1_id = isset($_POST["AUDITORIA1_id"])?$_POST["AUDITORIA1_id"]:"";
$AUDITORIA1_text = isset($_POST["AUDITORIA1_text"])?$_POST["AUDITORIA1_text"]:"";
if($AUDITORIA1_id!='' and ($AUDITORIA1_text=='si' or $AUDITORIA1_text=='no') ){	
    echo $pagoproveedores->ACTUALIZA_AUDITORIA1($AUDITORIA1_id, $AUDITORIA1_text);
}
 
$AUDITORIA2_id = isset($_POST["AUDITORIA2_id"])?$_POST["AUDITORIA2_id"]:"";
$AUDITORIA2_text = isset($_POST["AUDITORIA2_text"])?$_POST["AUDITORIA2_text"]:"";
if($AUDITORIA2_id!='' and ($AUDITORIA2_text=='si' or $AUDITORIA2_text=='no') ){	
    echo $pagoproveedores->ACTUALIZA_AUDITORIA2($AUDITORIA2_id, $AUDITORIA2_text);
}
 
$AUDITORIA3_id = isset($_POST["AUDITORIA3_id"])?$_POST["AUDITORIA3_id"]:"";
$AUDITORIA3_text = isset($_POST["AUDITORIA3_text"])?$_POST["AUDITORIA3_text"]:"";
if($AUDITORIA3_id!='' and ($AUDITORIA3_text=='si' or $AUDITORIA3_text=='no') ){	
    echo $pagoproveedores->ACTUALIZA_AUDITORIA3($AUDITORIA3_id, $AUDITORIA3_text);
}
 
$VENTAS_id = isset($_POST["VENTAS_id"])?$_POST["VENTAS_id"]:"";
$VENTAS_text = isset($_POST["VENTAS_text"])?$_POST["VENTAS_text"]:"";
if($VENTAS_id!='' and ($VENTAS_text=='si' or $VENTAS_text=='no') ){	
    echo $pagoproveedores->ACTUALIZA_VENTAS($VENTAS_id, $VENTAS_text);
}
 
$FINANZAS_id = isset($_POST["FINANZAS_id"])?$_POST["FINANZAS_id"]:"";
$FINANZAS_text = isset($_POST["FINANZAS_text"])?$_POST["FINANZAS_text"]:"";
if($FINANZAS_id!='' and ($FINANZAS_text=='si' or $FINANZAS_text=='no') ){	
    echo $pagoproveedores->ACTUALIZA_FINANZAS($FINANZAS_id, $FINANZAS_text);
}
 
$CHECKBOX_id = isset($_POST["CHECKBOX_id"]) ? $_POST["CHECKBOX_id"] : "";
$CHECKBOX_text = isset($_POST["CHECKBOX_text"]) ? $_POST["CHECKBOX_text"] : "";
if($CHECKBOX_id != '' && ($CHECKBOX_text == 'si' || $CHECKBOX_text == 'no')) {
    echo $pagoproveedores->ACTUALIZA_CHECKBOX($CHECKBOX_id, $CHECKBOX_text);
}
 
$RECHAZADO_id = isset($_POST["RECHAZADO_id"])?$_POST["RECHAZADO_id"]:"";
$RECHAZADO_text = isset($_POST["RECHAZADO_text"])?$_POST["RECHAZADO_text"]:"";
if($RECHAZADO_id!='' and ($RECHAZADO_text=='si' or $RECHAZADO_text=='no') ){
    echo $pagoproveedores->ACTUALIZA_RECHAZADO($RECHAZADO_id, $RECHAZADO_text);
    exit;
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
 
$RESPONSABLE_EVENTO_id = isset($_POST["RESPONSABLE_EVENTO_id"])?$_POST["RESPONSABLE_EVENTO_id"]:"";
$RESPONSABLE_text = isset($_POST["RESPONSABLE_text"])?$_POST["RESPONSABLE_text"]:"";
if($RESPONSABLE_EVENTO_id!='' and ($RESPONSABLE_text=='si' or $RESPONSABLE_text=='no') ){	
    echo $pagoproveedores->ACTUALIZA_RESPONSABLE_EVENTO($RESPONSABLE_EVENTO_id, $RESPONSABLE_text);
}
 
if($busqueda==true){
    $resultado = $pagoproveedores->buscarnumero($busqueda);
    echo json_encode($resultado);
}
 
if($pasarpagado_id!='' and ($pasarpagado_text=='si' or $pasarpagado_text=='no') ){	
    echo $pagoproveedores->PASARPAGADOACTUALIZAR($pasarpagado_id, $pasarpagado_text);
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
 
if($hiddenpagoproveedores == 'hiddenpagoproveedores' or $ENVIARPAGOprovee == 'ENVIARPAGOprovee'){            
	
$NUMERO_CONSECUTIVO_PROVEE = isset($_POST["NUMERO_CONSECUTIVO_PROVEE"])?$_POST["NUMERO_CONSECUTIVO_PROVEE"]:"";
$NOMBRE_COMERCIAL = isset($_POST["NOMBRE_COMERCIAL"])?$_POST["NOMBRE_COMERCIAL"]:"";
$RAZON_SOCIAL = isset($_POST["RAZON_SOCIAL"])?$_POST["RAZON_SOCIAL"]:"";
$RFC_PROVEEDOR = isset($_POST["RFC_PROVEEDOR"])?$_POST["RFC_PROVEEDOR"]:"";
$NUMERO_EVENTO = isset($_POST["NUMERO_EVENTO"])?$_POST["NUMERO_EVENTO"]:"";
$NOMBRE_EVENTO = isset($_POST["NOMBRE_EVENTO"])?$_POST["NOMBRE_EVENTO"]:"";
$MOTIVO_GASTO = isset($_POST["MOTIVO_GASTO"])?$_POST["MOTIVO_GASTO"]:"";
$CONCEPTO_PROVEE = isset($_POST["CONCEPTO_PROVEE"])?$_POST["CONCEPTO_PROVEE"]:"";
$MONTO_TOTAL_COTIZACION_ADEUDO = isset($_POST["MONTO_TOTAL_COTIZACION_ADEUDO"])?$_POST["MONTO_TOTAL_COTIZACION_ADEUDO"]:"";
$MONTO_DEPOSITAR = isset($_POST["MONTO_DEPOSITAR"])?$_POST["MONTO_DEPOSITAR"]:"";
$MONTO_PROPINA = isset($_POST["MONTO_PROPINA"])?$_POST["MONTO_PROPINA"]:"";
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
$EJECUTIVOTARJETA = isset($_POST["EJECUTIVOTARJETA"])?$_POST["EJECUTIVOTARJETA"]:"";
$IVA = isset($_POST["IVA"])?$_POST["IVA"]:"";
$TImpuestosRetenidosIVA = isset($_POST["TImpuestosRetenidosIVA"])?$_POST["TImpuestosRetenidosIVA"]:"";
$TImpuestosRetenidosISR = isset($_POST["TImpuestosRetenidosISR"])?$_POST["TImpuestosRetenidosISR"]:"";
$descuentos = isset($_POST["descuentos"])?$_POST["descuentos"]:"";
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
$Cantidad = isset($_POST["Cantidad"])?$_POST["Cantidad"]:"";
$ClaveUnidad = isset($_POST["ClaveUnidad"])?$_POST["ClaveUnidad"]:"";
$ClaveProdServ = isset($_POST["ClaveProdServ"])?$_POST["ClaveProdServ"]:"";
 
if($IPpagoprovee != '' && ($NOMBRE_EVENTO == '' || $MOTIVO_GASTO == '')){
    $resultadoActual = $pagoproveedores->Listado_pagoproveedor2($IPpagoprovee);
    $registroActual = mysqli_fetch_array($resultadoActual, MYSQLI_ASSOC);
    if($registroActual){
        if($NOMBRE_EVENTO == '' && isset($registroActual["NOMBRE_EVENTO"])){
            $NOMBRE_EVENTO = $registroActual["NOMBRE_EVENTO"];
        }
        if($MOTIVO_GASTO == '' && isset($registroActual["MOTIVO_GASTO"])){
            $MOTIVO_GASTO = $registroActual["MOTIVO_GASTO"];
        }
    }
}
 
if( $MOTIVO_GASTO == "" or $EJECUTIVOTARJETA == "" or $FECHA_A_DEPOSITAR == ""){
    echo "<P style='color:#b22222; font-size:23px;'>FAVOR DE LLENAR TODOS LOS CAMPOS OBLIGATORIOS</p>";
}else{
    echo $pagoproveedores->PAGOPRO($NUMERO_CONSECUTIVO_PROVEE, $NOMBRE_COMERCIAL, $RAZON_SOCIAL, $RFC_PROVEEDOR, $NUMERO_EVENTO, $NOMBRE_EVENTO, $MOTIVO_GASTO, $CONCEPTO_PROVEE, $MONTO_TOTAL_COTIZACION_ADEUDO, $MONTO_DEPOSITAR, $MONTO_PROPINA, $FECHA_AUTORIZACION_RESPONSABLE, $FECHA_AUTORIZACION_AUDITORIA, $FECHA_DE_LLENADO, $MONTO_FACTURA, $TIPO_DE_MONEDA, $PFORMADE_PAGO, $FECHA_DE_PAGO, $FECHA_A_DEPOSITAR, $STATUS_DE_PAGO, $ACTIVO_FIJO, $GASTO_FIJO, $PAGAR_CADA, $FECHA_PPAGO, $FECHA_TPROGRAPAGO, $NUMERO_EVENTOFIJO, $CLASI_GENERAL, $SUB_GENERAL, $BANCO_ORIGEN, $MONTO_DEPOSITADO, $CLASIFICACION_GENERAL, $CLASIFICACION_ESPECIFICA, $PLACAS_VEHICULO, $MONTO_DE_COMISION, $POLIZA_NUMERO, $EJECUTIVOTARJETA, $NOMBRE_DEL_EJECUTIVO, $NOMBRE_DEL_AYUDO, $OBSERVACIONES_1, $TIPO_CAMBIOP, $TOTAL_ENPESOS, $IMPUESTO_HOSPEDAJE, $IVA, $TImpuestosRetenidosIVA, $TImpuestosRetenidosISR, $descuentos, $ENVIARPAGOprovee, $hiddenpagoproveedores, $IPpagoprovee,
    $FechaTimbrado, $tipoDeComprobante, 
    $metodoDePago, $formaDePago, $condicionesDePago, $subTotal, 
    $TipoCambio, $Moneda, $total, $serie, 
    $folio, $LugarExpedicion, $rfcE, $nombreE, 
    $regimenE, $rfcR, $nombreR, $UsoCFDI, 
    $DomicilioFiscalReceptor, $RegimenFiscalReceptor, $UUID, $TImpuestosRetenidos, 
    $TImpuestosTrasladados, $TuaTotalCargos, $Descuento, $Propina, $TUA, $actualiza, $DescripcionConcepto, $Cantidad, $ClaveUnidad, $ClaveProdServ);
}
}
 
elseif($borrapagoaproveedores == 'borrapagoaproveedores'){
    $borra_id_PAGOP = isset($_POST["borra_id_PAGOP"])?$_POST["borra_id_PAGOP"]:"";   
    echo $pagoproveedores->borrapagoaproveedores($borra_id_PAGOP);
}
 
elseif($validaDATOSBANCARIOS1 == 'validaDATOSBANCARIOS1' or $ENVIARRdatosbancario1p == 'ENVIARRdatosbancario1p'){
    $P_TIPO_DE_MONEDA_1 = isset($_POST["P_TIPO_DE_MONEDA_1"])?$_POST["P_TIPO_DE_MONEDA_1"]:"";
    $P_INSTITUCION_FINANCIERA_1 = isset($_POST["P_INSTITUCION_FINANCIERA_1"])?$_POST["P_INSTITUCION_FINANCIERA_1"]:"";
    $P_NUMERO_DE_CUENTA_DB_1 = isset($_POST["P_NUMERO_DE_CUENTA_DB_1"])?$_POST["P_NUMERO_DE_CUENTA_DB_1"]:"";
    $P_NUMERO_CLABE_1 = isset($_POST["P_NUMERO_CLABE_1"])?$_POST["P_NUMERO_CLABE_1"]:"";
    $P_NUMERO_DE_SUCURSAL_1 = isset($_POST["P_NUMERO_DE_SUCURSAL_1"])?$_POST["P_NUMERO_DE_SUCURSAL_1"]:"";
    $P_NUMERO_IBAN_1 = isset($_POST["P_NUMERO_IBAN_1"])?$_POST["P_NUMERO_IBAN_1"]:"";
    $P_NUMERO_CUENTA_SWIFT_1 = isset($_POST["P_NUMERO_CUENTA_SWIFT_1"])?$_POST["P_NUMERO_CUENTA_SWIFT_1"]:"";
    $ULTIMA_CARGA_DATOBANCA = isset($_POST["ULTIMA_CARGA_DATOBANCA"])?$_POST["ULTIMA_CARGA_DATOBANCA"]:"";
    $IPdatosbancario1p = isset($_POST["IPdatosbancario1p"])?$_POST["IPdatosbancario1p"]:"";
 
    if( $_FILES["FOTO_ESTADO_PROVEE"] == true){
        $FOTO_ESTADO_PROVEE = $conexion->solocargar("FOTO_ESTADO_PROVEE");
    }
    if($FOTO_ESTADO_PROVEE=='2' or $FOTO_ESTADO_PROVEE=='' or $FOTO_ESTADO_PROVEE=='1'){
        $FOTO_ESTADO_PROVEE1="";
    } else{
        $FOTO_ESTADO_PROVEE1 = $FOTO_ESTADO_PROVEE;
    }
    echo $pagoproveedores->enviarDATOSBANCARIOS1($P_TIPO_DE_MONEDA_1, $P_INSTITUCION_FINANCIERA_1, $P_NUMERO_DE_CUENTA_DB_1, $P_NUMERO_CLABE_1, $P_NUMERO_DE_SUCURSAL_1, $P_NUMERO_IBAN_1, $P_NUMERO_CUENTA_SWIFT_1, $FOTO_ESTADO_PROVEE1, $ULTIMA_CARGA_DATOBANCA, $ENVIARRdatosbancario1p, $IPdatosbancario1p);
}
 
elseif($borra_datos_bancario1 == 'borra_datos_bancario1'){
    $borra_id_bancaP = isset($_POST["borra_id_bancaP"])?$_POST["borra_id_bancaP"]:"";   
    echo $pagoproveedores->borra_datos_bancario1($borra_id_bancaP);
}
 
elseif($borrasbdoc =='borrasbdoc'){
    $borra_id_sb = isset($_POST["borra_id_sb"])?$_POST["borra_id_sb"]:"";
    $borra_archivo_sb = isset($_POST["borra_archivo_sb"])?$_POST["borra_archivo_sb"]:"";
    $borra_campo_sb = isset($_POST["borra_campo_sb"])?$_POST["borra_campo_sb"]:"";

    if($borra_id_sb != ''){
        echo $pagoproveedores->delete_subefacturadocto2($borra_id_sb, __ROOT1__.'/includes/archivos/');
    }else{
        echo $pagoproveedores->delete_subefacturadocto2nombre($borra_archivo_sb, $borra_campo_sb, __ROOT1__.'/includes/archivos/');
    }
    exit;
}
 
 
// ══════════════════════════════════════════════════════════════════════════
// HELPER: detectar uploads válidos de forma centralizada
// ══════════════════════════════════════════════════════════════════════════
$hasUpload = static function($field) {
    return isset($_FILES[$field])
        && is_array($_FILES[$field])
        && isset($_FILES[$field]['error'])
        && intval($_FILES[$field]['error']) === UPLOAD_ERR_OK
        && isset($_FILES[$field]['name'])
        && trim((string)$_FILES[$field]['name']) !== '';
};
 
$subidaFacturaXML       = $hasUpload('ADJUNTAR_FACTURA_XML');
$subidaFacturaPDF       = $hasUpload('ADJUNTAR_FACTURA_PDF');
$subidaCotizacion       = $hasUpload('ADJUNTAR_COTIZACION');
$subidaTransfer         = $hasUpload('CONPROBANTE_TRANSFERENCIA');
$subidaArchivo1         = $hasUpload('ADJUNTAR_ARCHIVO_1');
$subidaFotoEstado       = $hasUpload('FOTO_ESTADO_PROVEE11');
$subidaCompPagoPDF      = $hasUpload('COMPLEMENTOS_PAGO_PDF');
$subidaCompPagoXML      = $hasUpload('COMPLEMENTOS_PAGO_XML');
$subidaCancelPDF        = $hasUpload('CANCELACIONES_PDF');
$subidaCancelXML        = $hasUpload('CANCELACIONES_XML');
$subidaFactComPDF       = $hasUpload('ADJUNTAR_FACTURA_DE_COMISION_PDF');
$subidaFactComXML       = $hasUpload('ADJUNTAR_FACTURA_DE_COMISION_XML');
$subidaCalculoComision  = $hasUpload('CALCULO_DE_COMISION');
$subidaComprobanteDevol = $hasUpload('COMPROBANTE_DE_DEVOLUCION');
$subidaNotaCredito      = $hasUpload('NOTA_DE_CREDITO_COMPRA');
 
$hayAlgunaSubida = (
    $subidaFacturaXML || $subidaFacturaPDF || $subidaCotizacion  || $subidaTransfer  ||
    $subidaArchivo1   || $subidaFotoEstado || $subidaCompPagoPDF || $subidaCompPagoXML ||
    $subidaCancelPDF  || $subidaCancelXML  || $subidaFactComPDF  || $subidaFactComXML  ||
    $subidaCalculoComision || $subidaComprobanteDevol || $subidaNotaCredito
);
 
 
// ══════════════════════════════════════════════════════════════════════════
// VALIDACIONES GLOBALES DE ARCHIVOS
// Aplican a TODOS los campos antes de cualquier procesamiento
// ══════════════════════════════════════════════════════════════════════════
 
// ── Archivos vacíos (0 bytes) ─────────────────────────────────────────────
foreach ($_FILES as $campo => $datos) {
    if (isset($datos['error']) && intval($datos['error']) === UPLOAD_ERR_OK) {
        if (isset($datos['size']) && intval($datos['size']) === 0) {
            echo 'VACIO^^' . $campo;
            exit;
        }
    }
}
 
// ── Archivos sin extensión ────────────────────────────────────────────────
foreach ($_FILES as $campo => $datos) {
    if (isset($datos['error']) && intval($datos['error']) === UPLOAD_ERR_OK) {
        $nombreArchivo = isset($datos['name']) ? $datos['name'] : '';
        $partes = explode('.', $nombreArchivo);
        if (count($partes) < 2 || trim(end($partes)) === '') {
            echo 'SIN_EXTENSION^^' . $campo;
            exit;
        }
    }
}
 
// ── Validación de formato XML obligatorio ─────────────────────────────────
if (!empty($_FILES["ADJUNTAR_FACTURA_XML"]["name"])) {
    $extensionFactura = strtolower(pathinfo($_FILES["ADJUNTAR_FACTURA_XML"]["name"], PATHINFO_EXTENSION));
    if($extensionFactura !== 'xml'){
        echo "El archivo debe estar en formato XML.";
        exit;
    }
}
 
 
// ══════════════════════════════════════════════════════════════════════════
// PRE-CARGA DEL XML TEMPORAL
// ══════════════════════════════════════════════════════════════════════════
 
$ADJUNTAR_FACTURA_XML2 = '';
$regreso               = [];
$idwebc                = '';
 
if ($subidaFacturaXML) {
 
    $ADJUNTAR_FACTURA_XML2 = $pagoproveedores->solocargartemp('ADJUNTAR_FACTURA_XML');
 
    // ── Interceptar errores de solocargartemp ─────────────────────────────
    if ($ADJUNTAR_FACTURA_XML2 === 'VACIO') {
        echo 'VACIO^^ADJUNTAR_FACTURA_XML';
        exit;
    }
    if ($ADJUNTAR_FACTURA_XML2 === 'SIN_EXTENSION') {
        echo 'SIN_EXTENSION^^ADJUNTAR_FACTURA_XML';
        exit;
    }
    if ($ADJUNTAR_FACTURA_XML2 === 'ERROR_SUBIDA') {
        echo 'ERROR_SUBIDA^^ADJUNTAR_FACTURA_XML';
        exit;
    }
    if ($ADJUNTAR_FACTURA_XML2 === '1' || $ADJUNTAR_FACTURA_XML2 === '2') {
        echo "El archivo debe estar en formato XML.";
        exit;
    }
    // ─────────────────────────────────────────────────────────────────────
 
    $url    = __ROOT1__ . '/includes/archivos/' . $ADJUNTAR_FACTURA_XML2;
    $regreso = $conexion2->lectorxml($url);
 
    // ── Receptor no válido ────────────────────────────────────────────────
    $nombreR_xml = isset($regreso['nombreR']) ? $regreso['nombreR'] : '';
    if (!receptorPermitidoEmpresaVO($nombreR_xml)) {
        echo '6^^' . trim((string)$nombreR_xml);
        if (file_exists($url)) { UNLINK($url); }
        $pagoproveedores->delete_subefactura2nombre($ADJUNTAR_FACTURA_XML2);
        exit;
    }
 
    $rfcE   = $regreso['rfcE'];
    $nombreE = $regreso['nombreE'];
    $conn   = $conexion->db();
 
    if ($pagoproveedores->verificar_rfc($conn, $rfcE) == '') {
        $idwebc = $pagoproveedores->ingresar_usuario($conn, TRIM($nombreE));
        $pagoproveedores->ingresar_rfc($conn, TRIM($rfcE), $idwebc);
    } elseif ($pagoproveedores->verificar_rfc($conn, $rfcE) != '') {
        $idwebc = $pagoproveedores->verificar_rfc($conn, $rfcE);
    } else {
        $idwebc = $pagoproveedores->verificar_usuario($conn, $nombreE);
    }
 
    $_SESSION["idCG"] = $idwebc;
}
 
if (!isset($idwebc)) { $idwebc = ''; }
 
$idCG = isset($_SESSION["idCG"]) ? $_SESSION["idCG"] : $idwebc;
$idCG = ($idCG == null) ? '' : $idCG;
$IPpagoprovee = isset($_POST["IPpagoprovee"]) ? $_POST["IPpagoprovee"] : "";
 
// ── Resolución de idCG cuando no viene de XML ─────────────────────────────
if ($idCG == '' && ($NOMBRE_COMERCIAL != '' || $RFC_PROVEEDOR != '')) {
    $conn = $conexion->db();
    if ($RFC_PROVEEDOR != '' && $pagoproveedores->verificar_rfc($conn, $RFC_PROVEEDOR) != '') {
        $idCG = $pagoproveedores->verificar_rfc($conn, $RFC_PROVEEDOR);
    } elseif ($NOMBRE_COMERCIAL != '' && $pagoproveedores->verificar_usuario($conn, $NOMBRE_COMERCIAL) != '') {
        $idCG = $pagoproveedores->verificar_usuario($conn, $NOMBRE_COMERCIAL);
    } else {
        $nombreTemporal = $NOMBRE_COMERCIAL != '' ? trim($NOMBRE_COMERCIAL) : 'PROVEEDOR_TEMPORAL';
        $idCG = $pagoproveedores->ingresar_usuario($conn, $nombreTemporal);
        if ($RFC_PROVEEDOR != '') {
            $pagoproveedores->ingresar_rfc($conn, TRIM($RFC_PROVEEDOR), $idCG);
        }
    }
    $_SESSION["idCG"] = $idCG;
}
 
if ($idCG == '') {
    $conn = $conexion->db();
    $nombreTemporal = 'PROVEEDOR_TEMPORAL_' . date('Ymd_His');
    $idCG = $pagoproveedores->ingresar_usuario($conn, $nombreTemporal);
    $_SESSION["idCG"] = $idCG;
}
 
 
// ══════════════════════════════════════════════════════════════════════════
// BLOQUE 1: Subida con IPpagoprovee (registro existente)
// ══════════════════════════════════════════════════════════════════════════
 
if ($IPpagoprovee != '' && $hayAlgunaSubida) {
 
    foreach ($_FILES AS $ETQIETA => $VALOR) {
 
        if (!isset($_FILES[$ETQIETA]['name']) || trim((string)$_FILES[$ETQIETA]['name']) === '') {
            continue;
        }
 
        // ── Validar vacío por campo ───────────────────────────────────────
        if (isset($VALOR['size']) && intval($VALOR['size']) === 0) {
            echo 'VACIO^^' . $ETQIETA;
            exit;
        }
 
        // ── Validar extensión por campo ───────────────────────────────────
        $partesNombreCG = explode('.', $VALOR['name']);
        if (count($partesNombreCG) < 2 || trim(end($partesNombreCG)) === '') {
            echo 'SIN_EXTENSION^^' . $ETQIETA;
            exit;
        }
 
        if ($ETQIETA === 'ADJUNTAR_FACTURA_XML') {
            $ADJUNTAR_FACTURA_XML = $conexion->sologuardar6($ETQIETA, $ADJUNTAR_FACTURA_XML2, '07COMPROBACIONDOCT', $idCG, $IPpagoprovee);
        } else {
            // ── Interceptar errores de cargar() para campos no-XML ────────
            $resultadoCarga = $conexion->cargar($ETQIETA, '07COMPROBACIONDOCT', '6', $IPpagoprovee, 'si', $IPpagoprovee);
 
            if ($resultadoCarga === 'VACIO') {
                echo 'VACIO^^' . $ETQIETA; exit;
            }
            if ($resultadoCarga === 'SIN_EXTENSION') {
                echo 'SIN_EXTENSION^^' . $ETQIETA; exit;
            }
            if ($resultadoCarga === 'ERROR_SUBIDA') {
                echo 'ERROR_SUBIDA^^' . $ETQIETA; exit;
            }
 
            $ADJUNTAR_FACTURA_XML = $resultadoCarga;
        }
 
        if ($ETQIETA === 'ADJUNTAR_FACTURA_XML' || $ETQIETA === 'ADJUNTAR_FACTURA_PDF') {
            $pagoproveedores->reemplazar_adjunto_unico_pago($idCG, $IPpagoprovee, $ETQIETA, $ADJUNTAR_FACTURA_XML, __ROOT1__.'/includes/archivos/');
        }
 
        if ($ETQIETA === 'ADJUNTAR_FACTURA_XML') {
            $url = __ROOT1__ . '/includes/archivos/' . $ADJUNTAR_FACTURA_XML;
            if (file_exists($url)) {
                $regreso  = $conexion2->lectorxml($url);
                $resultado = $pagoproveedores->VALIDA02XMLUUID_DETALLE($regreso['UUID']);
 
                if ($resultado == 'S') {
                    $pagoproveedores->borrar_xmls(__ROOT1__.'/includes/archivos/', $IPpagoprovee, $ADJUNTAR_FACTURA_XML, '07XML', '07COMPROBACIONDOCT');
                    echo $ADJUNTAR_FACTURA_XML;
                    ob_start();
                    $pagoproveedores->guardarxmlDB2($IPpagoprovee, $idCG, '07XML', $url);
                    ob_end_clean();
                    $pagoproveedores->registrar_bitacora_adjuntos($IPpagoprovee, 'XML', $ADJUNTAR_FACTURA_XML);
                } else {
                    echo '3|' . $resultado;
                    UNLINK($url);
                    $pagoproveedores->delete_subefactura2nombre($ADJUNTAR_FACTURA_XML);
                }
            }
        } else {
            $tiposAdjuntosBitacora = array(
                'ADJUNTAR_FACTURA_PDF'             => 'PDF',
                'ADJUNTAR_COTIZACION'              => 'COTIZACIÓN',
                'CONPROBANTE_TRANSFERENCIA'        => 'COMPROBANTE DE TRANSFERENCIA',
                'ADJUNTAR_ARCHIVO_1'               => 'ADJUNTO 1',
                'FOTO_ESTADO_PROVEE11'             => 'FOTO ESTADO PROVEEDOR',
                'COMPLEMENTOS_PAGO_PDF'            => 'COMPLEMENTO PAGO PDF',
                'COMPLEMENTOS_PAGO_XML'            => 'COMPLEMENTO PAGO XML',
                'CANCELACIONES_PDF'                => 'CANCELACIÓN PDF',
                'CANCELACIONES_XML'                => 'CANCELACIÓN XML',
                'ADJUNTAR_FACTURA_DE_COMISION_PDF' => 'FACTURA COMISIÓN PDF',
                'ADJUNTAR_FACTURA_DE_COMISION_XML' => 'FACTURA COMISIÓN XML',
                'CALCULO_DE_COMISION'              => 'CÁLCULO DE COMISIÓN',
                'COMPROBANTE_DE_DEVOLUCION'        => 'COMPROBANTE DE DEVOLUCIÓN',
                'NOTA_DE_CREDITO_COMPRA'           => 'NOTA DE CRÉDITO COMPRA'
            );
            if (isset($tiposAdjuntosBitacora[$ETQIETA]) && $ADJUNTAR_FACTURA_XML != '') {
                $pagoproveedores->registrar_bitacora_adjuntos($IPpagoprovee, $tiposAdjuntosBitacora[$ETQIETA], $ADJUNTAR_FACTURA_XML);
            }
            echo $ADJUNTAR_FACTURA_XML;
        }
    }
}
 
 
// ══════════════════════════════════════════════════════════════════════════
// BLOQUE 2: Subida sin IPpagoprovee (registro nuevo)
// ══════════════════════════════════════════════════════════════════════════
 
if ($IPpagoprovee == '' && $hiddenpagoproveedores != 'hiddenpagoproveedores' && $hayAlgunaSubida) {
 
    foreach ($_FILES AS $ETQIETA => $VALOR) {
 
        if (!isset($_FILES[$ETQIETA]['name']) || trim((string)$_FILES[$ETQIETA]['name']) === '') {
            continue;
        }
 
        // ── Validar vacío por campo ───────────────────────────────────────
        if (isset($VALOR['size']) && intval($VALOR['size']) === 0) {
            echo 'VACIO^^' . $ETQIETA;
            exit;
        }
 
        // ── Validar extensión por campo ───────────────────────────────────
        $partesNombreCG2 = explode('.', $VALOR['name']);
        if (count($partesNombreCG2) < 2 || trim(end($partesNombreCG2)) === '') {
            echo 'SIN_EXTENSION^^' . $ETQIETA;
            exit;
        }
 
        if ($ETQIETA === 'ADJUNTAR_FACTURA_XML') {
            $ADJUNTAR_FACTURA_XML = $pagoproveedores->sologuardar6($ETQIETA, $ADJUNTAR_FACTURA_XML2, '07COMPROBACIONDOCT', $idCG, $IPpagoprovee);
        } else {
            // ── Interceptar errores de cargar() para campos no-XML ────────
            $resultadoCarga2 = $conexion->cargar($ETQIETA, '07COMPROBACIONDOCT', '6', $idCG, 'si', '');
 
            if ($resultadoCarga2 === 'VACIO') {
                echo 'VACIO^^' . $ETQIETA; exit;
            }
            if ($resultadoCarga2 === 'SIN_EXTENSION') {
                echo 'SIN_EXTENSION^^' . $ETQIETA; exit;
            }
            if ($resultadoCarga2 === 'ERROR_SUBIDA') {
                echo 'ERROR_SUBIDA^^' . $ETQIETA; exit;
            }
 
            $ADJUNTAR_FACTURA_XML = $resultadoCarga2;
        }
 
        if ($ETQIETA === 'ADJUNTAR_FACTURA_XML' || $ETQIETA === 'ADJUNTAR_FACTURA_PDF') {
            $pagoproveedores->reemplazar_adjunto_unico_pago($idCG, 'si', $ETQIETA, $ADJUNTAR_FACTURA_XML, __ROOT1__.'/includes/archivos/');
        }
 
        if ($ETQIETA === 'ADJUNTAR_FACTURA_XML') {
            $url = __ROOT1__ . '/includes/archivos/' . $ADJUNTAR_FACTURA_XML;
            if (file_exists($url)) {
                $regreso  = $conexion2->lectorxml($url);
                $resultado = $pagoproveedores->VALIDA02XMLUUID_DETALLE($regreso['UUID']);
 
                if ($resultado == 'S') {
                    echo $ADJUNTAR_FACTURA_XML;
                } else {
                    echo '3|' . $resultado;
                    UNLINK($url);
                    $pagoproveedores->delete_subefactura2nombre($ADJUNTAR_FACTURA_XML);
                }
            }
        } else {
            echo $ADJUNTAR_FACTURA_XML;
        }
    }
}
