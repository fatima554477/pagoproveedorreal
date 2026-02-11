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
    // Primero: ejecutar la actualización en la base de datos
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
	
	
	//echo "ssssssssssssssssssssss";
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
/////////////////////////////////////////////nuevo//////////////////////////////////
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
/*$RUTAFILTRO = 'pagoproveedores'; DescripcionConcepto
$claseactual = 'class.epcinnPP.php';
$tablesdb = '02SUBETUFACTURA';
include_once (__ROOT1__."/includes/crea_funciones_filtro_completo.php");*/
	
	if($NOMBRE_COMERCIAL == '' and $NOMBRE_COMERCIAL23 != ''){
		$NOMBRE_COMERCIAL = $NOMBRE_COMERCIAL23;
	}
	
	
if( $NUMERO_EVENTO == "" OR $NOMBRE_COMERCIAL == ""){
	echo "<P style='color:red; font-size:23px;'>FAVOR DE LLENAR CAMPOS OBLIGATORIOS</p>";
}else{		
	// Evita insertar dos veces el mismo pago cuando se envía el formulario más de una vez (doble clic).
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
	
	
              // include_once (__ROOT1__."/includes/crea_funciones.php");PFORMADE_PAGO
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
}if($FOTO_ESTADO_PROVEE=='2' or $FOTO_ESTADO_PROVEE=='' or $FOTO_ESTADO_PROVEE=='1'){
	$FOTO_ESTADO_PROVEE1="";
} else{
 $FOTO_ESTADO_PROVEE1 = $FOTO_ESTADO_PROVEE;
}

	echo $pagoproveedores->enviarDATOSBANCARIOS1($P_TIPO_DE_MONEDA_1 , $P_INSTITUCION_FINANCIERA_1 , $P_NUMERO_DE_CUENTA_DB_1 , $P_NUMERO_CLABE_1 ,$P_NUMERO_DE_SUCURSAL_1 , $P_NUMERO_IBAN_1 , $P_NUMERO_CUENTA_SWIFT_1, $FOTO_ESTADO_PROVEE1,$ULTIMA_CARGA_DATOBANCA,$ENVIARRdatosbancario1p,
	$IPdatosbancario1p );
	

}	

elseif($DAbancaPRO_ENVIAR_IMAIL ==true){
$conexion2 = new herramientas();
$NOMBRE_1 = 'Peticion';
$EMAILnombre = array($DAbancaPRO_ENVIAR_IMAIL=>$NOMBRE_1);
$adjuntos = array(''=>'');
$Subject = 'DATOS SOLICITADOS';
/*nuevo*/
$array = isset($_POST['datosbancPRO'])?$_POST['datosbancPRO']:'';
if($array != ''){
$loopcuenta = count($array) - 1;$loopcuenta2 = count($array) - 2;
$or1='';
for($rrr=0;$rrr<=$loopcuenta;$rrr++){
	if($rrr<=$loopcuenta2){$or1 = ' or ';}else{$or1 = '';}
	$query1 .= ' id= '.$array[$rrr].$or1;
}
$query2 = str_replace('[object Object]','',$query1);
$query2 = "and (".$query2.") ";
}else{
	echo "SELECCIONA UNA CASILLA DEL LISTADO DE ABAJO."; exit;
}                                                                   
/*nuevo variables_informacionfiscal_logo*/                           



$MANDA_INFORMACION = $pagoproveedores->MANDA_INFORMACION('P_TIPO_DE_MONEDA_1,P_INSTITUCION_FINANCIERA_1,P_NUMERO_DE_CUENTA_DB_1,P_NUMERO_CLABE_1,P_NUMERO_DE_SUCURSAL_1,P_NUMERO_IBAN_1,P_NUMERO_CUENTA_SWIFT_1,FOTO_ESTADO_PROVEE',

'TIPO DE MONEDA ,NOMBRE DE LA INSTITUCIÓN FINANCIERA,NUMERO DE CUENTA,CLABE,NÚMERO DE SUCURSAL,NUMERO IBAN,NUMERO DE CUENTA SWIFT,FOTO DE ESTADO DE CUENTA', '02DATOSBANCARIOS1',  " where idRelacion = '".$_SESSION['idPROV']."' 
".$query2/*nuevo*/ );

$variables = 'FOTO_ESTADO_PROVEE, ';
// trim($variables, ',');

 $cadenacompleta =substr($variables, 0, -2);
 
$adjuntos = $pagoproveedores->ADJUNTA_IMAGENES_EMAIL($cadenacompleta,'02DATOSBANCARIOS1', " where idRelacion = '".$_SESSION['idPROV']."' ".$query2 );

$html = $pagoproveedores->html2(' DATOS BANCARIOS',$MANDA_INFORMACION );
//$logo = 'ADJUNTAR_LOGO_INFORMACION_2023_05_31_07_45_49.jpg';
$idlogo = $pagoproveedores->variable_comborelacion1a();
$logo = $pagoproveedores->variables_informacionfiscal_logo($idlogo);
$embebida = array('../includes/archivos/'.$logo => 'ver');;
echo $conexion2->email($EMAILnombre, $html, $adjuntos, $embebida, $Subject);
}

elseif($borra_datos_bancario1 == 'borra_datos_bancario1'){
	$borra_id_bancaP = isset($_POST["borra_id_bancaP"])?$_POST["borra_id_bancaP"]:"";   
		
	echo  $pagoproveedores->borra_datos_bancario1($borra_id_bancaP);
 
}

elseif($borrasbdoc =='borrasbdoc'){
	$borra_id_sb = isset($_POST["borra_id_sb"])?$_POST["borra_id_sb"]:"";   
	
		echo  $pagoproveedores->delete_subefacturadocto2($borra_id_sb);
}

//ob_start();
if( $_FILES["ADJUNTAR_FACTURA_XML"] == true){
//foreach($_FILES AS $ETQIETA => $VALOR){
	
	$ADJUNTAR_FACTURA_XML2 = $pagoproveedores->solocargartemp('ADJUNTAR_FACTURA_XML');
	//$explotado = explode('^',$ADJUNTAR_FACTURA_XML2);
	$url = __ROOT1__.'/includes/archivos/'.$ADJUNTAR_FACTURA_XML2;	
	$regreso = $conexion2->lectorxml($url);
	$rfcE = $regreso['rfcE'];					
	$nombreE = $regreso['nombreE'];	
        $conn = $conexion->db();//verificar_usuario
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
		//echo $explotado[1];
//}
$_SESSION["idPROV"] = $idwebc;
}
       // ob_end_clean();
		
$idPROV = isset($_SESSION["idPROV"])?$_SESSION["idPROV"]:$idwebc;
$IPpagoprovee = isset($_POST["IPpagoprovee"])?$_POST["IPpagoprovee"]:"";

if($IPpagoprovee !=''  and ($_FILES["ADJUNTAR_FACTURA_XML"] == true or $_FILES["ADJUNTAR_FACTURA_PDF"] == true or  $_FILES["ADJUNTAR_COTIZACION"] == true  or  $_FILES["CONPROBANTE_TRANSFERENCIA"] == true  or  $_FILES["ADJUNTAR_ARCHIVO_1"] == true or $_FILES["FOTO_ESTADO_PROVEE11"] == true  or  $_FILES["COMPLEMENTOS_PAGO_PDF"] == true or  $_FILES["COMPLEMENTOS_PAGO_XML"] == true or  $_FILES["CANCELACIONES_PDF"] == true or  $_FILES["CANCELACIONES_XML"] == true or  $_FILES ["ADJUNTAR_FACTURA_DE_COMISION_PDF"] == true or  $_FILES ["ADJUNTAR_FACTURA_DE_COMISION_XML"] == true or  $_FILES["CALCULO_DE_COMISION"] == true or  $_FILES["COMPROBANTE_DE_DEVOLUCION"] == true or  $_FILES["NOTA_DE_CREDITO_COMPRA"] == true )){
if($IPpagoprovee != ''){
foreach($_FILES AS $ETQIETA => $VALOR){

//ECHO $ETQIETA;
//ECHO "<BR>";
//ECHO $idPROV;
//AAAQUI

	if($_FILES['ADJUNTAR_FACTURA_XML']==true){
	$ADJUNTAR_FACTURA_XML = $conexion->sologuardar6($ETQIETA,$ADJUNTAR_FACTURA_XML2,'02SUBETUFACTURADOCTOS',$idPROV,$IPpagoprovee);	
	}else{
	$ADJUNTAR_FACTURA_XML = $conexion->cargar($ETQIETA,'02SUBETUFACTURADOCTOS','6',$IPpagoprovee,'si',$IPpagoprovee);
		if($_FILES['ADJUNTAR_FACTURA_PDF']==true){
			$pagoproveedores->borrar_pdfs(__ROOT1__.'/includes/archivos/',$IPpagoprovee,$ADJUNTAR_FACTURA_XML,'','02SUBETUFACTURADOCTOS');
		}	
	}
	
	
	/*NUEVO INICIO*///$ADJUNTAR_FACTURA_XML = <------NUEVO
	$url ='';
	if($_FILES['ADJUNTAR_FACTURA_XML']==true){
	$url = __ROOT1__.'/includes/archivos/'.$ADJUNTAR_FACTURA_XML;
	if( file_exists($url) ){
		$regreso = $conexion2->lectorxml($url);
		$resultado = $pagoproveedores->VALIDA02XMLUUID($regreso['UUID']);
	if($resultado == 'S'){

			$pagoproveedores->borrar_xmls(__ROOT1__.'/includes/archivos/',$IPpagoprovee,$ADJUNTAR_FACTURA_XML,'02XML','02SUBETUFACTURADOCTOS');
			echo $ADJUNTAR_FACTURA_XML.'^^'.$regreso['UUID'].'^^'.$regreso['formaDePago'];
				ob_start();
			$pagoproveedores->guardarxmlDB2($IPpagoprovee,$idPROV,'02XML', $url);
				ob_end_clean();
		}else{
			echo '3';
			UNLINK($url);
			$pagoproveedores->delete_subefactura2nombre($ADJUNTAR_FACTURA_XML);
		}
	}
}else{echo $ADJUNTAR_FACTURA_XML;}
	/*NUEVO FIN*/
}

}else{	echo "no hay usuario seleccionado";}
}


if($IPpagoprovee =='' and $hiddenpagoproveedores != 'hiddenpagoproveedores' and ($_FILES["ADJUNTAR_FACTURA_XML"] == true or $_FILES["ADJUNTAR_FACTURA_PDF"] == true or  $_FILES["ADJUNTAR_COTIZACION"] == true  or  $_FILES["CONPROBANTE_TRANSFERENCIA"] == true  or  $_FILES["ADJUNTAR_ARCHIVO_1"] == true  or $_FILES["FOTO_ESTADO_PROVEE11"] ==  true or  $_FILES["COMPLEMENTOS_PAGO_PDF"] == true or  $_FILES["COMPLEMENTOS_PAGO_XML"] == true or  $_FILES["CANCELACIONES_PDF"] == true or  $_FILES["CANCELACIONES_XML"] == true or  $_FILES ["ADJUNTAR_FACTURA_DE_COMISION_PDF"] == true or  $_FILES ["ADJUNTAR_FACTURA_DE_COMISION_XML"] == true or  $_FILES["CALCULO_DE_COMISION"] == true or  $_FILES["COMPROBANTE_DE_DEVOLUCION"] == true or  $_FILES["NOTA_DE_CREDITO_COMPRA"] == true )){
if($idPROV != ''){
foreach($_FILES AS $ETQIETA => $VALOR){
	//ECHO "AAAAAAAAAAAA2";	
	if($_FILES['ADJUNTAR_FACTURA_XML']==true){
	$idem1 = $_SESSION['idem'];
	$ADJUNTAR_FACTURA_XML = $conexion->sologuardar6_usuario($ETQIETA,$ADJUNTAR_FACTURA_XML2,'02SUBETUFACTURADOCTOS',$idPROV,$IPpagoprovee,$idem1,'xml');	
	}else{
	$idem1 = $_SESSION['idem'];
	$ADJUNTAR_FACTURA_XML = $conexion->cargar($ETQIETA,'02SUBETUFACTURADOCTOS','8',$idPROV,'si','',$idem1);
	}		
	/*NUEVO INICIO*///$ADJUNTAR_FACTURA_XML = <------NUEVO
	$url ='';
	if($_FILES['ADJUNTAR_FACTURA_XML']==true){
	$url = __ROOT1__.'/includes/archivos/'.$ADJUNTAR_FACTURA_XML;
	if( file_exists($url) ){
		$regreso = $conexion2->lectorxml($url);
		$resultado = $pagoproveedores->VALIDA02XMLUUID($regreso['UUID']);
		if($resultado == 'S'){
			echo $ADJUNTAR_FACTURA_XML;
		}else{
			echo '3';
			UNLINK($url);
			$pagoproveedores->delete_subefactura2nombre($ADJUNTAR_FACTURA_XML);
		}
	}
}else{echo $ADJUNTAR_FACTURA_XML;}
	/*NUEVO FIN*/


}

}else{	echo "no hay usuario seleccionado";}
}


?>