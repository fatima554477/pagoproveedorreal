<?php
/*
fecha sandor: 21/ABRIL/2025
fecha fatis : 27/04/2025
*/
?>


<?php
    if(!isset($_SESSION))
    { 
        session_start(); 
    }

define('__ROOT1__', dirname(dirname(__FILE__)));
include_once (__ROOT1__."/includes/error_reporting.php");
include_once (__ROOT1__."/ventasoperaciones/class.epcinnVO.php");

$ventasoperaciones= NEW accesoclase();
$conexion = NEW colaboradores();                            
$conexion2 = new herramientas();
                                               

$hiddenVENTASOPERACIONES = isset($_POST["hiddenVENTASOPERACIONES"])?$_POST["hiddenVENTASOPERACIONES"]:"";
$borraventasoperaciones = isset($_POST["borraventasoperaciones"])?$_POST["borraventasoperaciones"]:"";
$validaDATOSBANCARIOS1 = isset($_POST["validaDATOSBANCARIOS1"])?$_POST["validaDATOSBANCARIOS1"]:"";
$ENVIARRdatosbancario1p = isset($_POST["ENVIARRdatosbancario1p"])?$_POST["ENVIARRdatosbancario1p"]:"";
$ENVIARventasoper = isset($_POST["ENVIARventasoper"])?$_POST["ENVIARventasoper"]:""; 
$borra_datos_bancario1 = isset($_POST["borra_datos_bancario1"])?$_POST["borra_datos_bancario1"]:"";
$DAbancaPRO_ENVIAR_IMAIL = isset($_POST["DAbancaPRO_ENVIAR_IMAIL"])?$_POST["DAbancaPRO_ENVIAR_IMAIL"]:"";
$borrasb = isset($_POST["borrasb"])?$_POST["borrasb"]:""; 
$borrasbdoc = isset($_POST["borrasbdoc"])?$_POST["borrasbdoc"]:"";
	$busqueda = isset($_POST["busqueda"])?$_POST["busqueda"]:"";
	
	
$q = isset($_POST["q"])?$_POST["q"]:"";
if($q==true){
	$json = [];
	$json = $ventasoperaciones->buscarnumero2($q);
	 echo json_encode($json);	
}


$action = isset($_POST["action"])?$_POST["action"]:"";

if($action=='ultimopago'){
	$NUMERO_EVENTO = isset($_POST["NUMERO_EVENTO"])?$_POST["NUMERO_EVENTO"]:"";
	echo $resultado = $ventasoperaciones->ultimopago($NUMERO_EVENTO);
}

if($action=='ajax'){
	$NUMERO_EVENTO = isset($_POST["NUMERO_EVENTO"])?$_POST["NUMERO_EVENTO"]:"";
	echo $resultado = $ventasoperaciones->buscarnombre($NUMERO_EVENTO);
}






if($busqueda==true){

	 $resultado = $ventasoperaciones->buscarnumero($busqueda);
	 echo json_encode($resultado);
}
 
 
 
 
 
if($hiddenVENTASOPERACIONES == 'hiddenVENTASOPERACIONES' or $ENVIARventasoper == 'ENVIARventasoper'){            
	

$NUMERO_CONSECUTIVO_PROVEE = isset($_POST["NUMERO_CONSECUTIVO_PROVEE"])?$_POST["NUMERO_CONSECUTIVO_PROVEE"]:"";
$NOMBRE_COMERCIAL = isset($_POST["NOMBRE_COMERCIAL"])?$_POST["NOMBRE_COMERCIAL"]:"";
$NOMBRE_COMERCIAL23 = isset($_POST["NOMBRE_COMERCIAL23"])?$_POST["NOMBRE_COMERCIAL23"]:"";
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
$FECHA_AUTORIZACION_RESPONSABLE = isset($_POST["FECHA_AUTORIZACION_RESPONSABLE"])?$_POST["FECHA_AUTORIZACION_RESPONSABLE"]:"";
$FECHA_AUTORIZACION_AUDITORIA = isset($_POST["FECHA_AUTORIZACION_AUDITORIA"])?$_POST["FECHA_AUTORIZACION_AUDITORIA"]:"";
$FECHA_DE_LLENADO = isset($_POST["FECHA_DE_LLENADO"])?$_POST["FECHA_DE_LLENADO"]:"";
$MONTO_FACTURA = isset($_POST["MONTO_FACTURA"])?$_POST["MONTO_FACTURA"]:"";
$TIPO_DE_MONEDA = isset($_POST["TIPO_DE_MONEDA"])?$_POST["TIPO_DE_MONEDA"]:"";
$PFORMADE_PAGO = isset($_POST["PFORMADE_PAGO"])?$_POST["PFORMADE_PAGO"]:"";
$FECHA_DE_PAGO = isset($_POST["FECHA_DE_PAGO"])?$_POST["FECHA_DE_PAGO"]:"";
$FECHA_A_DEPOSITAR = isset($_POST["FECHA_A_DEPOSITAR"])?$_POST["FECHA_A_DEPOSITAR"]:"";
$STATUS_DE_PAGO = isset($_POST["STATUS_DE_PAGO"])?$_POST["STATUS_DE_PAGO"]:"";
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
$hiddenVENTASOPERACIONES = isset($_POST["hiddenVENTASOPERACIONES"])?$_POST["hiddenVENTASOPERACIONES"]:""; 
$IPventasoperar = isset($_POST["IPventasoperar"])?$_POST["IPventasoperar"]:""; 
////////////////////////////////////////////////////////////////////////////////////////////////
$TIPO_CAMBIOP = isset($_POST["TIPO_CAMBIOP"])?$_POST["TIPO_CAMBIOP"]:"";
$TOTAL_ENPESOS = isset($_POST["TOTAL_ENPESOS"])?$_POST["TOTAL_ENPESOS"]:"";
$IMPUESTO_HOSPEDAJE = isset($_POST["IMPUESTO_HOSPEDAJE"])?$_POST["IMPUESTO_HOSPEDAJE"]:"";
$IVA = isset($_POST["IVA"])?$_POST["IVA"]:"";
$TImpuestosRetenidosIVA = isset($_POST["TImpuestosRetenidosIVA"])?$_POST["TImpuestosRetenidosIVA"]:"";
$TImpuestosRetenidosISR = isset($_POST["TImpuestosRetenidosISR"])?$_POST["TImpuestosRetenidosISR"]:"";
$descuentos = isset($_POST["descuentos"])?$_POST["descuentos"]:"";

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
	
	
$actualiza = isset($_POST["actualiza"])?trim($_POST["actualiza"]):"";
	
	if($NOMBRE_COMERCIAL == '' and $NOMBRE_COMERCIAL23 != ''){
		$NOMBRE_COMERCIAL = $NOMBRE_COMERCIAL23;
	}
	
	
if($NOMBRE_COMERCIAL == "" OR $NUMERO_EVENTO == "" ){
	echo "<P style='color:red; font-size:23px;'>FAVOR DE LLENAR CAMPOS OBLIGATORIOS</p>";
}else{	
	
	
	
	
	echo $ventasoperaciones->ventasyoperacionesP ($NUMERO_CONSECUTIVO_PROVEE , $NOMBRE_COMERCIAL , $RAZON_SOCIAL ,$VIATICOSOPRO, $RFC_PROVEEDOR , $NUMERO_EVENTO ,$NOMBRE_EVENTO, $MOTIVO_GASTO , $CONCEPTO_PROVEE , $MONTO_TOTAL_COTIZACION_ADEUDO , $MONTO_DEPOSITAR , $MONTO_PROPINA , $FECHA_AUTORIZACION_RESPONSABLE , $FECHA_AUTORIZACION_AUDITORIA , $FECHA_DE_LLENADO , $MONTO_FACTURA , $TIPO_DE_MONEDA ,$PFORMADE_PAGO, $FECHA_DE_PAGO , $FECHA_A_DEPOSITAR , $STATUS_DE_PAGO , $BANCO_ORIGEN , $MONTO_DEPOSITADO , $CLASIFICACION_GENERAL , $CLASIFICACION_ESPECIFICA , $PLACAS_VEHICULO , $MONTO_DE_COMISION , $POLIZA_NUMERO , $NOMBRE_DEL_EJECUTIVO ,$NOMBRE_DEL_AYUDO, $OBSERVACIONES_1, $TIPO_CAMBIOP,  $TOTAL_ENPESOS,$IMPUESTO_HOSPEDAJE,$TImpuestosRetenidosIVA,$TImpuestosRetenidosISR,$descuentos,$IVA,  $ENVIARventasoper,$hiddenVENTASOPERACIONES,$IPventasoperar,
	$FechaTimbrado, $tipoDeComprobante, 
		$metodoDePago, $formaDePago, $condicionesDePago, $subTotal, 
		$TipoCambio, $Moneda, $total, $serie, 
		$folio, $LugarExpedicion, $rfcE, $nombreE, 
		$regimenE, $rfcR, $nombreR, $UsoCFDI, 
		$DomicilioFiscalReceptor, $RegimenFiscalReceptor, $UUID, $TImpuestosRetenidos, 
		$TImpuestosTrasladados, $TuaTotalCargos, $Descuento,$Propina, $TUA,$actualiza  );

}

}	
elseif($borraventasoperaciones == 'borraventasoperaciones'){
	$borra_id_VO = isset($_POST["borra_id_VO"])?$_POST["borra_id_VO"]:"";   
		
	echo  $ventasoperaciones->borraventasoperaciones($borra_id_VO);
 
}










elseif($validaDATOSBANCARIOS1 == 'validaDATOSBANCARIOS1' or $ENVIARRdatosbancario1p == 'ENVIARRdatosbancario1p'){            
	

if( $_FILES["FOTO_ESTADO_PROVEE"] == true){
$FOTO_ESTADO_PROVEE = $conexion->solocargar("FOTO_ESTADO_PROVEE");
}if($FOTO_ESTADO_PROVEE=='2' or $FOTO_ESTADO_PROVEE=='' or $FOTO_ESTADO_PROVEE=='1'){
	$FOTO_ESTADO_PROVEE1="";
} else{
 $FOTO_ESTADO_PROVEE1 = $FOTO_ESTADO_PROVEE;
}

$P_TIPO_DE_MONEDA_1 = isset($_POST["P_TIPO_DE_MONEDA_1"])?$_POST["P_TIPO_DE_MONEDA_1"]:"";
$P_INSTITUCION_FINANCIERA_1 = isset($_POST["P_INSTITUCION_FINANCIERA_1"])?$_POST["P_INSTITUCION_FINANCIERA_1"]:"";
$P_NUMERO_DE_CUENTA_DB_1 = isset($_POST["P_NUMERO_DE_CUENTA_DB_1"])?$_POST["P_NUMERO_DE_CUENTA_DB_1"]:"";
$P_NUMERO_CLABE_1 = isset($_POST["P_NUMERO_CLABE_1"])?$_POST["P_NUMERO_CLABE_1"]:"";
$P_NUMERO_DE_SUCURSAL_1 = isset($_POST["P_NUMERO_DE_SUCURSAL_1"])?$_POST["P_NUMERO_DE_SUCURSAL_1"]:"";
$P_NUMERO_IBAN_1 = isset($_POST["P_NUMERO_IBAN_1"])?$_POST["P_NUMERO_IBAN_1"]:"";
$P_NUMERO_CUENTA_SWIFT_1 = isset($_POST["P_NUMERO_CUENTA_SWIFT_1"])?$_POST["P_NUMERO_CUENTA_SWIFT_1"]:"";
$ULTIMA_CARGA_DATOBANCA = isset($_POST["ULTIMA_CARGA_DATOBANCA"])?$_POST["ULTIMA_CARGA_DATOBANCA"]:"";
$IPdatosbancario1p = isset($_POST["IPdatosbancario1p"])?$_POST["IPdatosbancario1p"]:"";


	echo $ventasoperaciones->enviarDATOSBANCARIOS1($P_TIPO_DE_MONEDA_1 , $P_INSTITUCION_FINANCIERA_1 , $P_NUMERO_DE_CUENTA_DB_1 , $P_NUMERO_CLABE_1 ,$P_NUMERO_DE_SUCURSAL_1 , $P_NUMERO_IBAN_1 , $P_NUMERO_CUENTA_SWIFT_1, $FOTO_ESTADO_PROVEE1,$ULTIMA_CARGA_DATOBANCA,$ENVIARRdatosbancario1p,
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



$MANDA_INFORMACION = $ventasoperaciones->MANDA_INFORMACION('P_TIPO_DE_MONEDA_1,P_INSTITUCION_FINANCIERA_1,P_NUMERO_DE_CUENTA_DB_1,P_NUMERO_CLABE_1,P_NUMERO_DE_SUCURSAL_1,P_NUMERO_IBAN_1,P_NUMERO_CUENTA_SWIFT_1,FOTO_ESTADO_PROVEE',

'TIPO DE MONEDA ,NOMBRE DE LA INSTITUCIÓN FINANCIERA,NUMERO DE CUENTA,CLABE,NÚMERO DE SUCURSAL,NUMERO IBAN,NUMERO DE CUENTA SWIFT,FOTO DE ESTADO DE CUENTA', '02DATOSBANCARIOS1',  " where idRelacion = '".$_SESSION['idPROV']."' 
".$query2/*nuevo*/ );

$variables = 'FOTO_ESTADO_PROVEE, ';
// trim($variables, ',');

 $cadenacompleta =substr($variables, 0, -2);
 
$adjuntos = $ventasoperaciones->ADJUNTA_IMAGENES_EMAIL($cadenacompleta,'02DATOSBANCARIOS1', " where idRelacion = '".$_SESSION['idPROV']."' ".$query2 );

$html = $ventasoperaciones->html2(' DATOS BANCARIOS',$MANDA_INFORMACION );
//$logo = 'ADJUNTAR_LOGO_INFORMACION_2023_05_31_07_45_49.jpg';
$idlogo = $ventasoperaciones->variable_comborelacion1a();
$logo = $ventasoperaciones->variables_informacionfiscal_logo($idlogo);
$embebida = array('../includes/archivos/'.$logo => 'ver');;
echo $conexion2->email($EMAILnombre, $html, $adjuntos, $embebida, $Subject);
}

elseif($borra_datos_bancario1 == 'borra_datos_bancario1'){
	$borra_id_bancaP = isset($_POST["borra_id_bancaP"])?$_POST["borra_id_bancaP"]:"";   
		
	echo  $ventasoperaciones->borra_datos_bancario1($borra_id_bancaP);
 
}

elseif($borrasbdoc =='borrasbdoc'){
	$borra_id_sb = isset($_POST["borra_id_sb"])?$_POST["borra_id_sb"]:"";   
	
		echo  $ventasoperaciones->delete_subefacturadocto2($borra_id_sb);
}





if( $_FILES["ADJUNTAR_FACTURA_XML"] == true){
//foreach($_FILES AS $ETQIETA => $VALOR){ventasoperaciones
	
	$ADJUNTAR_FACTURA_XML2 = $ventasoperaciones->solocargartemp('ADJUNTAR_FACTURA_XML');
	//$explotado = explode('^',$ADJUNTAR_FACTURA_XML2);pagoproveedores
	$url = __ROOT1__.'/includes/archivos/'.$ADJUNTAR_FACTURA_XML2;	
	$regreso = $conexion2->lectorxml($url);
	$rfcE = $regreso['rfcE'];					
	$nombreE = $regreso['nombreE'];	
		
		                if ($ventasoperaciones->verificar_rfc($conn, $rfcE) != '') {
                        $idwebc = $ventasoperaciones->verificar_rfc($conn, $rfcE);
                } elseif ($ventasoperaciones->verificar_usuario($conn, $nombreE) != '') {
                        $idwebc = $ventasoperaciones->verificar_usuario($conn, $nombreE);
                } elseif (isset($_SESSION["idPROV"]) && $_SESSION["idPROV"] != '') {
                        $idwebc = $_SESSION["idPROV"];
                } else {
                        $idwebc = 1;
                }
				
				
		//echo $explotado[1];
//}
$_SESSION["idPROV"] = $idwebc;
}


$idPROV = isset($_SESSION["idPROV"])?$_SESSION["idPROV"]: $idwebc;
$IPventasoperar = isset($_POST["IPventasoperar"])?$_POST["IPventasoperar"]:"";

if($IPventasoperar !=''  and ($_FILES["ADJUNTAR_FACTURA_PDF"] == true or $_FILES["ADJUNTAR_FACTURA_XML"] == true or  $_FILES["ADJUNTAR_COTIZACION"] == true  or  $_FILES["CONPROBANTE_TRANSFERENCIA"] == true  or  $_FILES["ADJUNTAR_ARCHIVO_1"] == true or    $_FILES["COMPLEMENTOS_PAGO_PDF"] == true or  $_FILES["COMPLEMENTOS_PAGO_XML"] == true or  $_FILES["CANCELACIONES_PDF"] == true or  $_FILES["CANCELACIONES_XML"] == true or  $_FILES ["ADJUNTAR_FACTURA_DE_COMISION_PDF"] == true or  $_FILES ["ADJUNTAR_FACTURA_COMISION_XML"] == true or  $_FILES["CALCULO_DE_COMISION"] == true or  $_FILES["COMPROBANTE_DE_DEVOLUCION"] == true or  $_FILES["NOTA_DE_CREDITO_COMPRA"] == true )){ 
if($IPventasoperar != ''){	
foreach($_FILES AS $ETQIETA => $VALOR){


$errorArchivo = isset($VALOR['error'])?intval($VALOR['error']):1;
$nombreArchivoOriginal = isset($VALOR['name'])?$VALOR['name']:'';
if($errorArchivo === 0 && $nombreArchivoOriginal != '' && ($ETQIETA == 'ADJUNTAR_FACTURA_XML' || $ETQIETA == 'ADJUNTAR_FACTURA_PDF')){
$ventasoperaciones->limpiarAdjuntoFacturaUnico($ETQIETA,$IPventasoperar,$idPROV);
}


if($_FILES['ADJUNTAR_FACTURA_XML']==true){
$ADJUNTAR_FACTURA_XML = $conexion->sologuardar6($ETQIETA,$ADJUNTAR_FACTURA_XML2,'02SUBETUFACTURADOCTOS',$idPROV,$IPventasoperar);
}else{
	$ADJUNTAR_FACTURA_XML = $conexion->cargar($ETQIETA,'02SUBETUFACTURADOCTOS','6',$IPventasoperar,'si',$IPventasoperar);
		if($_FILES['ADJUNTAR_FACTURA_PDF']==true){
			$pagoproveedores->borrar_pdfs(__ROOT1__.'/includes/archivos/',$IPventasoperar,$ADJUNTAR_FACTURA_XML,'','02SUBETUFACTURADOCTOS');
		}		
	}



	$url ='';
	if($_FILES['ADJUNTAR_FACTURA_XML']==true){
	$url = __ROOT1__.'/includes/archivos/'.$ADJUNTAR_FACTURA_XML;
	if( file_exists($url) ){
		$regreso = $conexion2->lectorxml($url);
		$resultado = $ventasoperaciones->VALIDA02XMLUUID($regreso['UUID']);
		if($resultado == 'S'){
			$pagoproveedores->borrar_xmls(__ROOT1__.'/includes/archivos/',$IPventasoperar,$ADJUNTAR_FACTURA_XML,'02XML','02SUBETUFACTURADOCTOS');
			echo $ADJUNTAR_FACTURA_XML.'^^'.$regreso['UUID'];
				ob_start();
			$pagoproveedores->guardarxmlDB2($IPventasoperar,$idPROV,'02XML', $url);
				ob_end_clean();
		}else{
			echo '3';
			UNLINK($url);
			$ventasoperaciones->delete_subefactura2nombre($ADJUNTAR_FACTURA_XML);
		}
	}
}else{echo $ADJUNTAR_FACTURA_XML;}
	/*NUEVO FIN*/


}

}else{	echo "no hay usuario seleccionado";}
}



if($IPventasoperar =='' and $hiddenVENTASOPERACIONES != 'hiddenVENTASOPERACIONES' and ($_FILES["ADJUNTAR_FACTURA_PDF"] == true or $_FILES["ADJUNTAR_FACTURA_XML"] == true or  $_FILES["ADJUNTAR_COTIZACION"] == true  or  $_FILES["CONPROBANTE_TRANSFERENCIA"] == true  or  $_FILES["ADJUNTAR_ARCHIVO_1"] == true or    $_FILES["COMPLEMENTOS_PAGO_PDF"] == true or  $_FILES["COMPLEMENTOS_PAGO_XML"] == true or  $_FILES["CANCELACIONES_PDF"] == true or  $_FILES["CANCELACIONES_XML"] == true or  $_FILES ["ADJUNTAR_FACTURA_DE_COMISION_PDF"] == true or  $_FILES ["ADJUNTAR_FACTURA_COMISION_XML"] == true or  $_FILES["CALCULO_DE_COMISION"] == true or  $_FILES["COMPROBANTE_DE_DEVOLUCION"] == true or  $_FILES["NOTA_DE_CREDITO_COMPRA"] == true )){ 
if($idPROV != ''){	
foreach($_FILES AS $ETQIETA => $VALOR){
//ECHO "AAAAAAAAAAAAAAAAAAAA";
	if($_FILES['ADJUNTAR_FACTURA_XML']==true){
	$idem1 = $_SESSION['idem'];
	$ADJUNTAR_FACTURA_XML = $conexion->sologuardar6_usuario($ETQIETA,$ADJUNTAR_FACTURA_XML2,'02SUBETUFACTURADOCTOS',$idPROV,$IPventasoperar,$idem1,'xml');
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
		$resultado = $ventasoperaciones->VALIDA02XMLUUID($regreso['UUID']);
		if($resultado == 'S'){
			echo $ADJUNTAR_FACTURA_XML;
		}else{
			echo '3';
			UNLINK($url);
			$ventasoperaciones->delete_subefactura2nombre($ADJUNTAR_FACTURA_XML);
		}
	}
}else{echo $ADJUNTAR_FACTURA_XML;}
	/*NUEVO FIN*/


}

}else{	echo "no hay usuario seleccionado";}
}


?>