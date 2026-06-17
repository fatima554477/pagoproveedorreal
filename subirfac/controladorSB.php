<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    }

define('__ROOT1__', dirname(dirname(__FILE__)));
include_once (__ROOT1__."/includes/error_reporting.php");
include_once (__ROOT1__."/subirfactura/class.epcinnSB.php");

$SUBEFACTURA = NEW accesoclase();
$conexion = NEW colaboradores();
$conexion2 = new herramientas();


$hiddensubefactura = isset($_POST["hiddensubefactura"])?$_POST["hiddensubefactura"]:"";
$validaDATOSBANCARIOS1 = isset($_POST["validaDATOSBANCARIOS1"])?$_POST["validaDATOSBANCARIOS1"]:"";
$ENVIARRdatosbancario1p = isset($_POST["ENVIARRdatosbancario1p"])?$_POST["ENVIARRdatosbancario1p"]:"";
$ENVIARRdatosbancario1p = isset($_POST["ENVIARRdatosbancario1p"])?$_POST["ENVIARRdatosbancario1p"]:"";
$borra_datos_bancario1 = isset($_POST["borra_datos_bancario1"])?$_POST["borra_datos_bancario1"]:"";
$ENVIARRSB1p = isset($_POST["ENVIARRSB1p"])?$_POST["ENVIARRSB1p"]:""; 
$borrasb = isset($_POST["borrasb"])?$_POST["borrasb"]:""; 
$borrasbdoc = isset($_POST["borrasbdoc"])?$_POST["borrasbdoc"]:"";
$hNOTAS = isset($_POST["hNOTAS"])?$_POST["hNOTAS"]:"";//hNOTAS
$enviarNOTAS = isset($_POST["enviarNOTAS"])?$_POST["enviarNOTAS"]:"";
$IpNOTAS = isset($_POST["IpNOTAS"])?$_POST["IpNOTAS"]:"";
$DOCUMENTO_FISCAL = isset($_POST["DOCUMENTO_FISCAL"])?$_POST["DOCUMENTO_FISCAL"]:"";
$enviarnuevo_FISCAL = isset($_POST["enviarnuevo_FISCAL"])?$_POST["enviarnuevo_FISCAL"]:"";
$BORRARNUEVOFISCAL = isset($_POST["BORRARNUEVOFISCAL"])?$_POST["BORRARNUEVOFISCAL"]:"";

$validaDOCUMENTOSFISCAL = isset($_POST["validaDOCUMENTOSFISCAL"])?$_POST["validaDOCUMENTOSFISCAL"]:"";
$ENVIAFISCAL = isset($_POST["ENVIAFISCAL"])?$_POST["ENVIAFISCAL"]:"";
$borradocufiscal = isset($_POST["borradocufiscal"])?$_POST["borradocufiscal"]:"";
$ENVIAR_EMAIL_DOCUFISCAL = isset($_POST["ENVIAR_EMAIL_DOCUFISCAL"])?$_POST["ENVIAR_EMAIL_DOCUFISCAL"]:"";



$action = isset($_POST["action"])?$_POST["action"]:"";
if($action=='total_menos_dep'){
	
	
	//echo "ssssssssssssssssssssss";
$total_menos_depositado = isset($_POST["total_menos_depositado"])?$_POST["total_menos_depositado"]:"";
$numero_evento2a = isset($_POST["numero_evento2a"])?$_POST["numero_evento2a"]:"";
	echo $resultado = $SUBEFACTURA->pendiente_pago($total_menos_depositado,$numero_evento2a);
}


$pasarD_text = isset($_POST['pasarD_text'])?$_POST['pasarD_text']:'';
if($pasarD_text =='si' or $pasarD_text =='no'){
$pasarDID = isset($_POST['pasarDID'])?$_POST['pasarDID']:'';
$SUBEFACTURA->datos_bancario_default($pasarDID,$pasarD_text);
}

  
 elseif($validaDOCUMENTOSFISCAL == 'validaDOCUMENTOSFISCAL' or $ENVIAFISCAL == 'ENVIAFISCAL'){
	 
if( $_FILES["ADJUNTAR_DOCUMENTO_LEGAL"] == true){
$ADJUNTAR_DOCUMENTO_LEGAL = $conexion->solocargar("ADJUNTAR_DOCUMENTO_LEGAL");
}if($ADJUNTAR_DOCUMENTO_LEGAL=='2' or $ADJUNTAR_DOCUMENTO_LEGAL=='' or $ADJUNTAR_DOCUMENTO_LEGAL=='1'){
	$ADJUNTAR_DOCUMENTO_LEGAL1="";
} else{
 $ADJUNTAR_DOCUMENTO_LEGAL1 = $ADJUNTAR_DOCUMENTO_LEGAL;
}	 
	 
$DOCUMENTO_LEGAL = isset($_POST["DOCUMENTO_LEGAL"])?$_POST["DOCUMENTO_LEGAL"]:"";

$ADJUNTAR_DOCUMENTO_OBSERVACIONES = isset($_POST["ADJUNTAR_DOCUMENTO_OBSERVACIONES"])?$_POST["ADJUNTAR_DOCUMENTO_OBSERVACIONES"]:"";
$FECHA_ULTIMA_DOCUMEN = isset($_POST["FECHA_ULTIMA_DOCUMEN"])?$_POST["FECHA_ULTIMA_DOCUMEN"]:"";
$validaDOCUMENTOSFISCAL = isset($_POST["validaDOCUMENTOSFISCAL"])?$_POST["validaDOCUMENTOSFISCAL"]:"";
$IPdocumentosfiscales = isset($_POST["IPdocumentosfiscales"])?$_POST["IPdocumentosfiscales"]:""; 
//ENVIAFISCAL

//print_r($_POST);
	echo $SUBEFACTURA->documentofiscal ($DOCUMENTO_LEGAL ,$ADJUNTAR_DOCUMENTO_LEGAL, $ADJUNTAR_DOCUMENTO_OBSERVACIONES , $FECHA_ULTIMA_DOCUMEN , $validaDOCUMENTOSFISCAL,$IPdocumentosfiscales,$ENVIAFISCAL);
}

elseif($ENVIAR_EMAIL_DOCUFISCAL ==true){
$conexion2 = new herramientas();
$NOMBRE_1 = 'Peticion';
$EMAILnombre = array($ENVIAR_EMAIL_DOCUFISCAL=>$NOMBRE_1);
$adjuntos = array(''=>'');
$Subject = 'DATOS SOLICITADOS';
/*nuevo*/
$array = isset($_POST['fiscalesdocu'])?$_POST['fiscalesdocu']:'';
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



$MANDA_INFORMACION = $SUBEFACTURA->MANDA_INFORMACION('DOCUMENTO_LEGAL,ADJUNTAR_DOCUMENTO_LEGAL,ADJUNTAR_DOCUMENTO_OBSERVACIONES',

'NOMBRE DEL DOCUMENTO , DOCUMENTO, OBSERVACIONES', '02DOCUMENTOSFISCALES',  " where idRelacion = '".$_SESSION['idPROV']."' 
".$query2/*nuevo*/ );

$variables = 'ADJUNTAR_DOCUMENTO_LEGAL, ';
// trim($variables, ',');

 $cadenacompleta =substr($variables, 0, -2);
 
$adjuntos = $SUBEFACTURA->ADJUNTA_IMAGENES_EMAIL($cadenacompleta,'02DOCUMENTOSFISCALES', " where idRelacion = '".$_SESSION['idPROV']."' ".$query2 );

$html = $SUBEFACTURA->html2('DOCUMENTOS FISCALES DEL PROVEEDOR',$MANDA_INFORMACION );
//$logo = 'ADJUNTAR_LOGO_INFORMACION_2023_05_31_07_45_49.jpg';
$idlogo = $SUBEFACTURA->variable_comborelacion1a();
$logo = $SUBEFACTURA->variables_informacionfiscal_logo($idlogo);
$embebida = array('../includes/archivos/'.$logo => 'ver');
echo $conexion2->email($EMAILnombre, $html, $adjuntos, $embebida, $Subject);
}

elseif($borradocufiscal == 'borradocufiscal'){
	$borra_id_FISCAL = isset($_POST["borra_id_FISCAL"])?$_POST["borra_id_FISCAL"]:"";
		
	echo $SUBEFACTURA->borradocufiscal($borra_id_FISCAL);
   	//include_once (__ROOT1__."/includes/crea_funciones.php");
} 







//enviarnuevo_FISCAL/////////////////////////////////////////////////////////////////////////////////////////
if($DOCUMENTO_FISCAL =='DOCUMENTO_FISCAL' or $enviarnuevo_FISCAL == 'enviarnuevo_FISCAL'){
$nuevo_documento = isset($_POST["nuevo_documento"])?$_POST["nuevo_documento"]:"";
$DOCUMENTO_FISCAL = isset($_POST["DOCUMENTO_FISCAL"])?$_POST["DOCUMENTO_FISCAL"]:""; 
$IPnuevodocumento = isset($_POST["IPnuevodocumento"])?$_POST["IPnuevodocumento"]:"";

echo $SUBEFACTURA->nuevodocumento($nuevo_documento , $DOCUMENTO_FISCAL,$enviarnuevo_FISCAL,$IPnuevodocumento);
}

elseif($BORRARNUEVOFISCAL == 'BORRARNUEVOFISCAL'){
	$borra_id_NUEVOD = isset($_POST["borra_id_NUEVOD"])?$_POST["borra_id_NUEVOD"]:"";
		
	echo $SUBEFACTURA->BORRARNUEVOFISCAL($borra_id_NUEVOD);
   	//include_once (__ROOT1__."/includes/crea_funciones.php");


}
 
 
 
 
 

if($hiddensubefactura =='hiddensubefactura' or $ENVIARRSB1p=='ENVIARRSB1p'){

$NUMERO_CONSECUTIVO_PROVEE = isset($_POST["NUMERO_CONSECUTIVO_PROVEE"])?$_POST["NUMERO_CONSECUTIVO_PROVEE"]:"";
$NOMBRE_COMERCIAL = isset($_POST["NOMBRE_COMERCIAL"])?$_POST["NOMBRE_COMERCIAL"]:"";
$RAZON_SOCIAL = isset($_POST["RAZON_SOCIAL"])?$_POST["RAZON_SOCIAL"]:"";
$VIATICOSOPRO = isset($_POST["VIATICOSOPRO"])?$_POST["VIATICOSOPRO"]:"";
$RFC_PROVEEDOR = isset($_POST["RFC_PROVEEDOR"])?$_POST["RFC_PROVEEDOR"]:"";
$NUMERO_EVENTO = isset($_POST["NUMERO_EVENTO"])?$_POST["NUMERO_EVENTO"]:"";
// Obtener el nombre del evento a partir del número proporcionado
$NOMBRE_EVENTO = $SUBEFACTURA->obtenerNombreEvento($NUMERO_EVENTO);
$CONCEPTO_PROVEE = isset($_POST["CONCEPTO_PROVEE"])?$_POST["CONCEPTO_PROVEE"]:"";
$MONTO_TOTAL_COTIZACION_ADEUDO = isset($_POST["MONTO_TOTAL_COTIZACION_ADEUDO"])?$_POST["MONTO_TOTAL_COTIZACION_ADEUDO"]:"";
$MONTO_DEPOSITAR = isset($_POST["MONTO_DEPOSITAR"])?$_POST["MONTO_DEPOSITAR"]:"";
$MONTO_PROPINA = isset($_POST["MONTO_PROPINA"])?$_POST["MONTO_PROPINA"]:"";
$MONTO_FACTURA = isset($_POST["MONTO_FACTURA"])?$_POST["MONTO_FACTURA"]:"";
$TIPO_DE_MONEDA = isset($_POST["TIPO_DE_MONEDA"])?$_POST["TIPO_DE_MONEDA"]:"";
$PFORMADE_PAGO = isset($_POST["PFORMADE_PAGO"])?$_POST["PFORMADE_PAGO"]:"";
$FECHA_DE_PAGO = isset($_POST["FECHA_DE_PAGO"])?$_POST["FECHA_DE_PAGO"]:"";
$STATUS_DE_PAGO = isset($_POST["STATUS_DE_PAGO"])?$_POST["STATUS_DE_PAGO"]:"";
$NOMBRE_DEL_EJECUTIVO = isset($_POST["NOMBRE_DEL_EJECUTIVO"])?$_POST["NOMBRE_DEL_EJECUTIVO"]:"";
$OBSERVACIONES_1 = isset($_POST["OBSERVACIONES_1"])?$_POST["OBSERVACIONES_1"]:"";
$FECHA_DE_LLENADO = isset($_POST["FECHA_DE_LLENADO"])?$_POST["FECHA_DE_LLENADO"]:"";
$hiddensubefactura = isset($_POST["hiddensubefactura"])?$_POST["hiddensubefactura"]:""; 
$IMPUESTO_HOSPEDAJE = isset($_POST["IMPUESTO_HOSPEDAJE"])?$_POST["IMPUESTO_HOSPEDAJE"]:"";
$MONTO_DEPOSITADO = isset($_POST["MONTO_DEPOSITADO"])?$_POST["MONTO_DEPOSITADO"]:"";
$PENDIENTE_PAGO = isset($_POST["PENDIENTE_PAGO"])?$_POST["PENDIENTE_PAGO"]:"";
$NOMBRE_DEL_AYUDO = isset($_POST["NOMBRE_DEL_AYUDO"])?$_POST["NOMBRE_DEL_AYUDO"]:"";
$IPSB1p = isset($_POST["IPSB1p"])?$_POST["IPSB1p"]:"";
$IVA = isset($_POST["IVA"])?$_POST["IVA"]:"";
$TImpuestosRetenidosIVA = isset($_POST["TImpuestosRetenidosIVA"])?$_POST["TImpuestosRetenidosIVA"]:"";
$TImpuestosRetenidosISR = isset($_POST["TImpuestosRetenidosISR"])?$_POST["TImpuestosRetenidosISR"]:"";
$descuentos = isset($_POST["descuentos"])?$_POST["descuentos"]:"";

$prefijosNumeroEvento = array('EPC','INN','EVE');

if(in_array(strtoupper(trim($NUMERO_EVENTO)),$prefijosNumeroEvento)){
        echo "<P style='color:red; font-size:23px;'>FAVOR DE COMPLETAR EL NÚMERO DE EVENTO AGREGANDO EL NÚMERO CORRESPONDIENTE DESPUÉS DE LAS INICIALES DE LA EMPRESA SIN ESPACIOS.</p>";
}elseif($NOMBRE_COMERCIAL == "" or  $NUMERO_EVENTO == "" or  $NOMBRE_DEL_EJECUTIVO == "" or  $MONTO_TOTAL_COTIZACION_ADEUDO == ""){
echo "<P style='color:red; font-size:23px;'>FAVOR DE LLENAR TODOS LOS CAMPOS OBLIGATORIOS</p>";
}else{


	echo $SUBEFACTURA->lectorxmlX ($NUMERO_CONSECUTIVO_PROVEE , $NOMBRE_COMERCIAL , $RAZON_SOCIAL ,$VIATICOSOPRO, $RFC_PROVEEDOR , $NUMERO_EVENTO , $NOMBRE_EVENTO , $CONCEPTO_PROVEE , $MONTO_TOTAL_COTIZACION_ADEUDO , $MONTO_DEPOSITAR , $MONTO_PROPINA , $MONTO_FACTURA , $TIPO_DE_MONEDA ,$PFORMADE_PAGO, $FECHA_DE_PAGO , $STATUS_DE_PAGO , $NOMBRE_DEL_EJECUTIVO , $OBSERVACIONES_1 ,$FECHA_DE_LLENADO, $ADJUNTAR_FACTURA_XML , $ADJUNTAR_FACTURA_PDF, $ADJUNTAR_COTIZACION11, $CONPROBANTE_TRANSFERENCIA, $ADJUNTAR_ARCHIVO_1,$IMPUESTO_HOSPEDAJE, $MONTO_DEPOSITADO,$PENDIENTE_PAGO,$IVA,$NOMBRE_DEL_AYUDO,$TImpuestosRetenidosIVA,$TImpuestosRetenidosISR,$descuentos,$hiddensubefactura, $ENVIARRSB1p, $IPSB1p);
	//include_once (__ROOT1__."/includes/crea_funciones.php");


}
}


elseif($borrasb == 'borrasb'){
	//borra_id_sb
	$borra_id_sb = isset($_POST["borra_id_sb"])?$_POST["borra_id_sb"]:"";   
		
	echo  $SUBEFACTURA->borra_sube_factura($borra_id_sb);
 
}


///////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////
if($hNOTAS == 'hNOTAS' or $enviarNOTAS=='enviarNOTAS'){
	  
	
 if( $_FILES["ADJUNTO_NOTAS"] == true){
$ADJUNTO_NOTAS = $conexion->solocargar("ADJUNTO_NOTAS");
}if($ADJUNTO_NOTAS=='2' or $ADJUNTO_NOTAS=='' or $ADJUNTO_NOTAS=='1'){
$ADJUNTO_NOTAS1 = "";	
}else{
$ADJUNTO_NOTAS1 = $ADJUNTO_NOTAS;
}

$DOCUMENTO_NOTAS = isset($_POST["DOCUMENTO_NOTAS"])?$_POST["DOCUMENTO_NOTAS"]:"";
$OBSERVACIONES_NOTAS = isset($_POST["OBSERVACIONES_NOTAS"])?$_POST["OBSERVACIONES_NOTAS"]:"";
$FECHA_NOTAS = isset($_POST["FECHA_NOTAS"])?$_POST["FECHA_NOTAS"]:"";
$hNOTAS = isset($_POST["hNOTAS"])?$_POST["hNOTAS"]:""; 



echo $SUBEFACTURA->NOTAS($DOCUMENTO_NOTAS,$ADJUNTO_NOTAS1,$OBSERVACIONES_NOTAS,$FECHA_NOTAS,$hNOTAS,$IpNOTAS,$enviarNOTAS);



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


	echo $SUBEFACTURA->enviarDATOSBANCARIOS1($P_TIPO_DE_MONEDA_1 , $P_INSTITUCION_FINANCIERA_1 , $P_NUMERO_DE_CUENTA_DB_1 , $P_NUMERO_CLABE_1 ,$P_NUMERO_DE_SUCURSAL_1 , $P_NUMERO_IBAN_1 , $P_NUMERO_CUENTA_SWIFT_1, $FOTO_ESTADO_PROVEE,$ULTIMA_CARGA_DATOBANCA,$ENVIARRdatosbancario1p,
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



$MANDA_INFORMACION = $SUBEFACTURA->MANDA_INFORMACION('P_TIPO_DE_MONEDA_1,P_INSTITUCION_FINANCIERA_1,P_NUMERO_DE_CUENTA_DB_1,P_NUMERO_CLABE_1,P_NUMERO_DE_SUCURSAL_1,P_NUMERO_IBAN_1,P_NUMERO_CUENTA_SWIFT_1,FOTO_ESTADO_PROVEE',

'TIPO DE MONEDA ,NOMBRE DE LA INSTITUCIÓN FINANCIERA,NUMERO DE CUENTA,CLABE,NÚMERO DE SUCURSAL,NUMERO IBAN,NUMERO DE CUENTA SWIFT,FOTO DE ESTADO DE CUENTA', '02DATOSBANCARIOS1',  " where idRelacion = '".$_SESSION['idPROV']."' 
".$query2/*nuevo*/ );

$variables = 'FOTO_ESTADO_PROVEE, ';
// trim($variables, ',');

 $cadenacompleta =substr($variables, 0, -2);
 
$adjuntos = $SUBEFACTURA->ADJUNTA_IMAGENES_EMAIL($cadenacompleta,'02DATOSBANCARIOS1', " where idRelacion = '".$_SESSION['idPROV']."' ".$query2 );

$html = $SUBEFACTURA->html2(' DATOS BANCARIOS',$MANDA_INFORMACION );
//$logo = 'ADJUNTAR_LOGO_INFORMACION_2023_05_31_07_45_49.jpg';
$idlogo = $SUBEFACTURA->variable_comborelacion1a();
$logo = $SUBEFACTURA->variables_informacionfiscal_logo($idlogo);
$embebida = array('../includes/archivos/'.$logo => 'ver');;
echo $conexion2->email($EMAILnombre, $html, $adjuntos, $embebida, $Subject);
}

elseif($borra_datos_bancario1 == 'borra_datos_bancario1'){
	$borra_id_bancaP = isset($_POST["borra_id_bancaP"])?$_POST["borra_id_bancaP"]:"";   
		
	echo  $SUBEFACTURA->borra_datos_bancario1($borra_id_bancaP);
 
}

elseif($borrasbdoc =='borrasbdoc'){
	$borra_id_sb = isset($_POST["borra_id_sb"])?$_POST["borra_id_sb"]:"";   
	
		echo  $SUBEFACTURA->delete_subefacturadocto2($borra_id_sb);
			$SUBEFACTURA->registrar_bitacora_sb('eliminar', 'Se eliminó un documento temporal en 02SUBETUFACTURADOCTOS', $borra_id_sb, '02SUBETUFACTURADOCTOS');

}


$idPROV = isset($_SESSION["idPROV"])?$_SESSION["idPROV"]:"";
$IPSB1p = isset($_POST["IPSB1p"])?$_POST["IPSB1p"]:"";
$camposArchivoSB = array('ADJUNTAR_FACTURA_PDF','ADJUNTAR_FACTURA_XML','ADJUNTAR_COTIZACION','CONPROBANTE_TRANSFERENCIA','ADJUNTAR_ARCHIVO_1');

foreach($camposArchivoSB as $campoArchivoSB){

	if(isset($_FILES[$campoArchivoSB]) && is_array($_FILES[$campoArchivoSB]) && isset($_FILES[$campoArchivoSB]['error']) && intval($_FILES[$campoArchivoSB]['error']) !== 0){

		echo 'ERROR_SUBIDA^^'.$campoArchivoSB;

		exit;

	}

	if(isset($_FILES[$campoArchivoSB]) && is_array($_FILES[$campoArchivoSB]) && isset($_FILES[$campoArchivoSB]['error']) && intval($_FILES[$campoArchivoSB]['error']) === 0){

		if(isset($_FILES[$campoArchivoSB]['size']) && intval($_FILES[$campoArchivoSB]['size']) === 0){

			echo 'VACIO^^'.$campoArchivoSB;

			exit;

		}

		$extensionSB = strtolower(pathinfo(isset($_FILES[$campoArchivoSB]['name']) ? $_FILES[$campoArchivoSB]['name'] : '', PATHINFO_EXTENSION));

		if($extensionSB === ''){

			echo 'SIN_EXTENSION^^'.$campoArchivoSB;

			exit;

		}

		if($campoArchivoSB === 'ADJUNTAR_FACTURA_XML' && $extensionSB !== 'xml'){

			echo '2';

			exit;

		}

		if($campoArchivoSB === 'ADJUNTAR_FACTURA_PDF' && $extensionSB !== 'pdf'){

			echo '2';

			exit;

		}

	}

}

if( $IPSB1p != '' and ($_FILES["ADJUNTAR_FACTURA_PDF"] == true or $_FILES["ADJUNTAR_FACTURA_XML"] == true or  $_FILES["ADJUNTAR_COTIZACION"] == true  or  $_FILES["CONPROBANTE_TRANSFERENCIA"] == true  or  $_FILES["ADJUNTAR_ARCHIVO_1"] == true )) {
if($idPROV != ''){

foreach($_FILES AS $ETQIETA => $VALOR){
	$ADJUNTAR_FACTURA_XML = $conexion->cargar($ETQIETA,'02SUBETUFACTURADOCTOS','6',$idPROV,'',$IPSB1p);
	$url ='';
	if($_FILES['ADJUNTAR_FACTURA_XML']==true){
	$url = __ROOT1__.'/includes/archivos/'.$ADJUNTAR_FACTURA_XML;
	if( file_exists($url) ){
		$regreso = $conexion2->lectorxml($url);
		if(empty($regreso) || !isset($regreso['UUID']) || trim($regreso['UUID']) === ''){

			echo '5^^ADJUNTAR_FACTURA_XML';

			UNLINK($url);

			$SUBEFACTURA->delete_subefactura2nombre($ADJUNTAR_FACTURA_XML);

			exit;

		}

		$resultado = $SUBEFACTURA->VALIDA02XMLUUID($regreso['UUID']);
		if($resultado == 'S'){
			echo $ADJUNTAR_FACTURA_XML;
		}else{
			echo $resultado;

			UNLINK($url);
			$SUBEFACTURA->delete_subefactura2nombre($ADJUNTAR_FACTURA_XML);
		}
	}
}else{echo $ADJUNTAR_FACTURA_XML;}
$SUBEFACTURA->registrar_bitacora_sb('adjuntar', 'Se adjuntó/actualizó un documento en 02SUBETUFACTURADOCTOS', $IPSB1p, '02SUBETUFACTURADOCTOS');

}

}else{	echo "no hay usuario seleccionado";}

}

if(  $IPSB1p == '' and $hiddensubefactura!= 'hiddensubefactura' and ($_FILES["ADJUNTAR_FACTURA_PDF"] == true or $_FILES["ADJUNTAR_FACTURA_XML"] == true or  $_FILES["ADJUNTAR_COTIZACION"] == true  or  $_FILES["CONPROBANTE_TRANSFERENCIA"] == true  or  $_FILES["ADJUNTAR_ARCHIVO_1"] == true )) {
if($idPROV != ''){

foreach($_FILES AS $ETQIETA => $VALOR){
	
	$ADJUNTAR_FACTURA_XML = $conexion->cargar($ETQIETA,'02SUBETUFACTURADOCTOS','6',$idPROV,'si');
	$url ='';
	if($_FILES['ADJUNTAR_FACTURA_XML']==true){
	$url = __ROOT1__.'/includes/archivos/'.$ADJUNTAR_FACTURA_XML;
	if( file_exists($url) ){
		$regreso = $conexion2->lectorxml($url);
		if(empty($regreso) || !isset($regreso['UUID']) || trim($regreso['UUID']) === ''){

			echo '5^^ADJUNTAR_FACTURA_XML';

			UNLINK($url);

			$SUBEFACTURA->delete_subefactura2nombre($ADJUNTAR_FACTURA_XML);

			exit;

		}

		$resultado = $SUBEFACTURA->VALIDA02XMLUUID($regreso['UUID']);
		if($resultado == 'S'){
			echo $ADJUNTAR_FACTURA_XML;
		}else{
			echo $resultado;

			UNLINK($url);
			$SUBEFACTURA->delete_subefactura2nombre($ADJUNTAR_FACTURA_XML);
		}
	}
}else{echo $ADJUNTAR_FACTURA_XML;}


	$SUBEFACTURA->registrar_bitacora_sb('adjuntar', 'Se adjuntó un documento temporal en 02SUBETUFACTURADOCTOS', 'si', '02SUBETUFACTURADOCTOS');




}

}else{	echo "no hay usuario seleccionado";}
}

?>