<?php
/*
clase EPC INNOVA
CREADO : 10/mayo/2023
fecha sandor: 21/ABRIL/2025
fecha fatis : 05/04/2025

se agregaron estos campos nuevos:
idRelacionU int(50)
TIPOARCHIVO varchar(3)
*/
	define('__ROOT3__', dirname(dirname(__FILE__)));
	require __ROOT3__."/includes/class.epcinn.php";	
	
	
	class accesoclase extends colaboradores{


	public function solocargartemp($archivo)/*new file*/
	{
		$nombre_carpeta=__ROOT3__.'/includes/archivos';
		$filehandle = opendir($nombre_carpeta);
		$nombretemp = $_FILES[$archivo]["tmp_name"];
		$nombrearchivo = $_FILES[$archivo]["name"];
		$tamanyoarchivo = $_FILES[$archivo]["size"];
		$tipoarchivo = getimagesize($nombretemp);
		$extension = explode('.',$nombrearchivo);
		$cuenta = count($extension) - 1;
		$nuevonombre =  $archivo.'_'.date('Y_m_d_h_i_s').'.'.$extension[$cuenta];
		//echo '1aaaaaaaaaaaaaaaa2'.$extension[$cuenta].'1aaaaaaaaaaaaaaaa2';
		
		if( 
		strtolower($extension[$cuenta]) == 'pdf' or 
		strtolower($extension[$cuenta]) == 'gif' or 
		strtolower($extension[$cuenta]) == 'jpeg' or 
		strtolower($extension[$cuenta]) == 'jpg' or 
		strtolower($extension[$cuenta]) == 'png' or 
		strtolower($extension[$cuenta]) == 'mp4' or 
		strtolower($extension[$cuenta]) == 'docx' or 
		strtolower($extension[$cuenta]) == 'doc' or 
		strtolower($extension[$cuenta]) == 'xml'
		){
		if(move_uploaded_file($nombretemp, $nombre_carpeta.'/'. $nuevonombre)){
		chmod ($nombre_carpeta.'/' . $nuevonombre, 0755);
		$tamanyo =fileSize($nombre_carpeta.'/'. $nuevonombre);
		$fp = fopen($nombre_carpeta.'/'.$nuevonombre, "rb"); 
		$contenido = fread($fp, $tamanyo);
		$contenido = addslashes($contenido);
		
		return trim($nuevonombre);
		
		}
		else{
			return "1";
		}
		
		}
		else{
			return "2";
		}
	}
    


	public function buscarnumero($filtro){
		$conn = $this->db();
		$variable = "select * from 04altaeventos where NUMERO_EVENTO like '%".$filtro."%' ";
$variablequery = mysqli_query($conn,$variable);
		while($row = mysqli_fetch_array($variablequery, MYSQLI_ASSOC)){
			$resultado [] = $row['NUMERO_EVENTO'];
		}
		return $resultado;
		
	}                          

	public function buscarnumero2($filtro){
		$conn = $this->db();
		$variable = "select * from 04altaeventos where NUMERO_EVENTO like '%".$filtro."%' ";
$variablequery = mysqli_query($conn,$variable);
		while($row = mysqli_fetch_array($variablequery, MYSQLI_ASSOC)){
			//$resultado [] = $row['NUMERO_DE_EVENTO'];
			$resultado[] = ['id'=>$row['NUMERO_EVENTO'],'text'=>$row['NUMERO_EVENTO']];
		}
		return $resultado;
		
	}

	public function ultimopago($filtro){
		$conn = $this->db();
		$variable = "select * from 02SUBETUFACTURA where NUMERO_EVENTO = '".$filtro."' ";
		$resultado = 0;
		$variablequery = mysqli_query($conn,$variable);
		while($row = mysqli_fetch_array($variablequery, MYSQLI_ASSOC)){
			$resultado += $row['MONTO_DEPOSITADO'];
		}
		
		$resultado2 = 'sssssssssssssss';
		return $resultado;

	}


	public function buscarnombre($filtro){
		$conn = $this->db();
		$variable = "select * from 04altaeventos where NUMERO_EVENTO = '".$filtro."' ";
$variablequery = mysqli_query($conn,$variable);
		while($row = mysqli_fetch_array($variablequery, MYSQLI_ASSOC)){
			$resultado=$row['NOMBRE_EVENTO'];
		}
		return $resultado;
		
	}
	
	
	
	public function variable_DIRECCIONP1(){
		$conn = $this->db();
		$variablequery = "select * from 02direccionproveedor1 where idRelacion = '".$_SESSION['idPROV']."' ";
		$arrayquery = mysqli_query($conn,$variablequery);
		return $row = mysqli_fetch_array($arrayquery, MYSQLI_ASSOC);		
	}
	
	public function variable_SUBETUFACTURA(){
		$conn = $this->db();
		$variablequery = "select * from 02SUBETUFACTURADOCTOS where idRelacion = '".$_SESSION['idPROV']."' and idTemporal = 'si' and (ADJUNTAR_FACTURA_XML is not null or ADJUNTAR_FACTURA_XML <> '') order by id desc ";
		$arrayquery = mysqli_query($conn,$variablequery);
		return $row = mysqli_fetch_array($arrayquery, MYSQLI_ASSOC);		
	}

	public function revisar_ventasoperaciones(){
		$conn = $this->db();
		$var1 = 'select id from 02SUBETUFACTURA where idRelacion =  "'.$_SESSION['idPROV'].'" ';
		$query = mysqli_query($conn,$var1) or die('P44'.mysqli_error($conn));
		$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
		return $row['id'];
	}

   	public function guardarxmlDB($ultimo_id,$conn){
	$conexion2 = new herramientas();
	$regreso = $this->variable_SUBETUFACTURA();
	$url = __ROOT3__.'/includes/archivos/'.$regreso['ADJUNTAR_FACTURA_XML'];

	$session = isset($_SESSION['idPROV'])?$_SESSION['idPROV']:'';    

	$conexion2->guardar_db_xml($url,$session,$ultimo_id,$conn);
	/*if( file_exists($url) ){
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

//ClaveProdServ
	$CantidadConcepto = $regreso['Cantidad'];
	$ValorUnitarioConcepto = $regreso['ValorUnitario'];
	$ImporteConcepto = $regreso['Importe'];
	$ClaveProdServConcepto = $regreso['ClaveProdServ'];
	$UnidadConcepto = $regreso['Unidad'];
	$DescripcionConcepto = $regreso['Descripcion'];
	$ClaveUnidadConcepto = $regreso['ClaveUnidad'];
	$NoIdentificacionConcepto = $regreso['NoIdentificacion'];
}
		$session = isset($_SESSION['idPROV'])?$_SESSION['idPROV']:'';    

		$conn = $this->db();
$var3 = "INSERT INTO `02XML` (
`id`, `Version`, `fechaTimbrado`, `tipoDeComprobante`, 
`metodoDePago`, `formaDePago`, `condicionesDePago`, `subTotal`, 
`TipoCambio`, `Moneda`, `totalf`, `serie`, 
`folio`, `LugarExpedicion`, `rfcE`, `nombreE`, 
`regimenE`, `rfcR`, `nombreR`, `UsoCFDI`, 
`DomicilioFiscalReceptor`, `RegimenFiscalReceptor`, `UUID`, `TImpuestosRetenidos`, 
`TImpuestosTrasladados`, `idRelacion`, `ultimo_id`,

CantidadConcepto,
ValorUnitarioConcepto,
ImporteConcepto,
ClaveProdServConcepto,
UnidadConcepto,
DescripcionConcepto,
ClaveUnidadConcepto,
NoIdentificacionConcepto

) VALUES (
'', '".$Version."', '".$FechaTimbrado."', '".$tipoDeComprobante."', 
'".$metodoDePago."', '".$formaDePago."', '".$condicionesDePago."', '".$subTotal."', 
'".$TipoCambio."', '".$Moneda."', '".$total."', '".$serie."', 
'".$folio."', '".$LugarExpedicion."', '".$rfcE."', '".$nombreE."', 
'".$regimenE."', '".$rfcR."', '".$nombreR."', '".$UsoCFDI."', 
'".$DomicilioFiscalReceptor."', '".$RegimenFiscalReceptor."', '".$UUID."', '".$TImpuestosRetenidos."', 
'".$TImpuestosTrasladados."', '".$session."', '".$ultimo_id."',


'".$CantidadConcepto."',
'".$ValorUnitarioConcepto."',
'".$ImporteConcepto."',
'".$ClaveProdServConcepto."',
'".$UnidadConcepto."',
'".$DescripcionConcepto."',
'".$ClaveUnidadConcepto."',
'".$NoIdentificacionConcepto."'


);  ";	
		mysqli_query($conn,$var3) or die('P156'.mysqli_error($conn));
		//return "1";*/	
	
	
	}


	public function busca_02XML($ultimo_id){
	$conn = $this->db();		
	$variablequery = "select * from 02XML where ultimo_id = '".$ultimo_id."' "; 
	$arrayquery = mysqli_query($conn,$variablequery);
	return $row = mysqli_fetch_array($arrayquery, MYSQLI_ASSOC);
	}

   	public function ActualizaxmlDB($FechaTimbrado, $tipoDeComprobante, 
		$metodoDePago, $formaDePago, $condicionesDePago, $subTotal, 
		$TipoCambio, $Moneda, $total, $serie, 
		$folio, $LugarExpedicion, $rfcE, $nombreE, 
		$regimenE, $rfcR, $nombreR, $UsoCFDI, 
		$DomicilioFiscalReceptor, $RegimenFiscalReceptor, $UUID, $TImpuestosRetenidos, 
		$TImpuestosTrasladados, $session, $ultimo_id, $TuaTotalCargos, $TUA, $Descuento, $Propina, $conn,$actualiza){

	$var3 = "update `02XML` set 
	`Version` = 'no', 
	`fechaTimbrado` = '".$FechaTimbrado."', 
	`tipoDeComprobante` = '".$tipoDeComprobante."', 
	`metodoDePago` = '".$metodoDePago."', 
	`formaDePago` = '".$formaDePago."', 
	`condicionesDePago` = '".$condicionesDePago."', 
	`subTotal` = '".$subTotal."', 
	`TipoCambio` = '".$TipoCambio."', 
	`Moneda` = '".$Moneda."', 
	`totalf` = '".$total."', 
	`serie` = '".$serie."', 
	`folio` = '".$folio."', 
	`LugarExpedicion` = '".$LugarExpedicion."', 
	`rfcE` = '".$rfcE."', 
	`nombreE` = '".$nombreE."', 
	`regimenE` = '".$regimenE."', 
	`rfcR` = '".$rfcR."', 
	`nombreR` = '".$nombreR."', 
	`UsoCFDI` = '".$UsoCFDI."', 
	`DomicilioFiscalReceptor` = '".$DomicilioFiscalReceptor."', 
	`RegimenFiscalReceptor` = '".$RegimenFiscalReceptor."', 
	`UUID` = '".$UUID."',
	`TuaTotalCargos` = '".$TuaTotalCargos."',
	`TUA` = '".$TUA."',	
	`Propina` = '".$Propina."',	
	`Descuento` = '".$Descuento."',	
	`TImpuestosRetenidos` = '".$TImpuestosRetenidos."', 
	`TImpuestosTrasladados` = '".$TImpuestosTrasladados."' 
	where
	`ultimo_id` = '".$ultimo_id."';  ";

	$var4 = "INSERT INTO `02XML` (
	`id`, `Version`, `fechaTimbrado`, `tipoDeComprobante`, 
	`metodoDePago`, `formaDePago`, `condicionesDePago`, `subTotal`, 
	`TipoCambio`, `Moneda`, `totalf`, `serie`, 
	`folio`, `LugarExpedicion`, `rfcE`, `nombreE`, 
	`regimenE`, `rfcR`, `nombreR`, `UsoCFDI`, 
	`DomicilioFiscalReceptor`, `RegimenFiscalReceptor`, `UUID`, `TImpuestosRetenidos`, 
	`TImpuestosTrasladados`, `idRelacion`, `ultimo_id`, `TuaTotalCargos`,Descuento, `TUA`, `Propina`) VALUES (
	'', 'no', '".$FechaTimbrado."', '".$tipoDeComprobante."', 
	'".$metodoDePago."', '".$formaDePago."', '".$condicionesDePago."', '".$subTotal."', 
	'".$TipoCambio."', '".$Moneda."', '".$total."', '".$serie."', 
	'".$folio."', '".$LugarExpedicion."', '".$rfcE."', '".$nombreE."', 
	'".$regimenE."', '".$rfcR."', '".$nombreR."', '".$UsoCFDI."', 
	'".$DomicilioFiscalReceptor."', '".$RegimenFiscalReceptor."', '".$UUID."', '".$TImpuestosRetenidos."', 
	'".$TImpuestosTrasladados."', '".$session."', '".$ultimo_id."', '".$TuaTotalCargos."', '".$Descuento."', '".$TUA."', '".$Propina."'
	);  ";

$row = $this->busca_02XML($ultimo_id);
if($actualiza=='true'){
if($row['ultimo_id']==0 or $row['ultimo_id']==''){
	mysqli_query($conn,$var4) or die('P350'.mysqli_error($conn));
}else{
	mysqli_query($conn,$var3) or die('P352'.mysqli_error($conn));
}
} 
		//return "1";	
	}




	public function listado3(){
		$conn = $this->db();

		$var = 'select *,02usuarios.id AS IDDD from 02usuarios left join 02direccionproveedor1 on 02usuarios.id = 02direccionproveedor1.idRelacion order by nommbrerazon asc';		
		RETURN $query = mysqli_query($conn,$var);

		
	}
	
	public function verificar_rfc($conn,$RFC_PROVEEDOR){
		$queryrfc = "SELECT * FROM 02direccionproveedor1 WHERE P_RFC_MTDP = '".$RFC_PROVEEDOR."' ";
		$arrayquery = mysqli_query($conn,$queryrfc);
		$row = mysqli_fetch_array($arrayquery, MYSQLI_ASSOC);
		return $row['id'];
	}

	public function verificar_usuario($conn,$nommbrerazon){
		 $queryrfc = "SELECT * FROM 02direccionproveedor1 WHERE P_NOMBRE_FISCAL_RS_EMPRESA = '".$nommbrerazon."' ";
		$arrayquery = mysqli_query($conn,$queryrfc);
		$row = mysqli_fetch_array($arrayquery, MYSQLI_ASSOC);
		return $row['id'];
	}
		
	public function ingresar_usuario($conn,$nommbrerazon){
		 $queryrfc = "insert into 02direccionproveedor1 (P_NOMBRE_FISCAL_RS_EMPRESA) values ('".$nommbrerazon."'); ";
		$arrayquery = mysqli_query($conn,$queryrfc) or die('P160'.mysqli_error($conn));
		RETURN $idwebc = mysqli_insert_id($conn);
	}		

	public function ingresar_rfc($conn,$RFC_PROVEEDOR,$idwebc){
		 $queryrfc = "UPDATE 02direccionproveedor1
		SET P_RFC_MTDP = '".$RFC_PROVEEDOR."', idRelacion = '".$idwebc."' WHERE id = '".$idwebc."' ";
		$arrayquery = mysqli_query($conn,$queryrfc);
		return $row = mysqli_fetch_array($arrayquery, MYSQLI_ASSOC);
	}

	public function variable_SUBETUFACTURA2($id12){
		$conn = $this->db();
		$variablequery = "select * from 02SUBETUFACTURADOCTOS where 
		idRelacion = '".$id12."' and 
		idTemporal = 'si' and (ADJUNTAR_FACTURA_XML is not null or ADJUNTAR_FACTURA_XML <> '') and
		idRelacionU = '".$_SESSION['idempermiso']."' and
		TIPOARCHIVO = 'xml'
		order by id desc ";
		$arrayquery = mysqli_query($conn,$variablequery);
		return $row = mysqli_fetch_array($arrayquery, MYSQLI_ASSOC);		
	}

	public function borrar_xmls($ruta,$id,$nombrearchivo,$tabla1,$tabla2){ 
		$conn = $this->db();
		//`07COMPROBACIONDOCT` WHERE `idTemporal`
		// `07XML` ORDER BY `07XML`.`ultimo_id`
		$var1 = "delete FROM ".$tabla1." WHERE `ultimo_id` = '".$id."' ";
		mysqli_query($conn,$var1);

		$var2 = "SELECT * FROM ".$tabla2." WHERE 
		`idTemporal` = '".$id."' and 
		ADJUNTAR_FACTURA_XML <> '".$nombrearchivo."' and ADJUNTAR_FACTURA_XML <> '' ";
		$QUERYVAR2 = mysqli_query($conn,$var2) or die('P44'.mysqli_error($conn));
		while($row = mysqli_fetch_array($QUERYVAR2, MYSQLI_ASSOC)){
			if( file_exists($ruta.''.$row['ADJUNTAR_FACTURA_XML']) ){
			UNLINK($ruta.''.$row['ADJUNTAR_FACTURA_XML']);
			}
		}
		$var3 = "DELETE FROM ".$tabla2." WHERE `idTemporal` = '".$id."'and 
		ADJUNTAR_FACTURA_XML <> '".$nombrearchivo."' and ADJUNTAR_FACTURA_XML <>'' ";
		mysqli_query($conn,$var3) or die('P44'.mysqli_error($conn));		
	}


	public function borrar_pdfs($ruta,$id,$nombrearchivo,$tabla1,$tabla2){
		$conn = $this->db();

		$var2 = "SELECT * FROM ".$tabla2." WHERE 
		`idTemporal` = '".$id."' and 
		ADJUNTAR_FACTURA_PDF <> '".$nombrearchivo."' and ADJUNTAR_FACTURA_PDF <> '' ";
		$QUERYVAR2 = mysqli_query($conn,$var2) or die('P44'.mysqli_error($conn));
		while($row = mysqli_fetch_array($QUERYVAR2, MYSQLI_ASSOC)){
			if( file_exists($ruta.''.$row['ADJUNTAR_FACTURA_PDF']) ){
			UNLINK($ruta.''.$row['ADJUNTAR_FACTURA_PDF']);
			}
		}
		$var3 = "DELETE FROM ".$tabla2." WHERE `idTemporal` = '".$id."'and 
		ADJUNTAR_FACTURA_PDF <> '".$nombrearchivo."' and ADJUNTAR_FACTURA_PDF <>'' ";
		mysqli_query($conn,$var3) or die('P44'.mysqli_error($conn));		
	}
	
	public function busca_07XML2($ultimo_id,$tabla){
	$conn = $this->db();		
	$variablequery = "select * from ".$tabla." where ultimo_id = '".$ultimo_id."' "; 
	$arrayquery = mysqli_query($conn,$variablequery);
	return $row = mysqli_fetch_array($arrayquery, MYSQLI_ASSOC);
	}
	
	public function guardarxmlDB2($ultimo_id,$session,$tabla, $url){
	$conn = $this->db();
	$conexion2 = new herramientas();   
	
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
		$Descuento = $regreso['Descuento'];
		$total = $regreso['total'];
		$serie = $regreso['serie'];
		$folio = $regreso['folio'];
		$LugarExpedicion = $regreso['LugarExpedicion'];
		$DescripcionConcepto = $regreso['DescripcionConcepto'];
		
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

		$var3 = "update ".$tabla." set 
		`Version` = '".$Version."', 
		`fechaTimbrado` = '".$FechaTimbrado."', 
		`tipoDeComprobante` = '".$tipoDeComprobante."', 
		`metodoDePago` = '".$metodoDePago."', 
		`formaDePago` = '".$formaDePago."', 
		`condicionesDePago` = '".$condicionesDePago."', 
		`subTotal` = '".$subTotal."', 
		`TipoCambio` = '".$TipoCambio."', 
		`Moneda` = '".$Moneda."', 
		`totalf` = '".$total."', 
		`serie` = '".$serie."', 
		`folio` = '".$folio."', 
		`LugarExpedicion` = '".$LugarExpedicion."', 
		`rfcE` = '".$rfcE."', 
		`nombreE` = '".$nombreE."', 
		`regimenE` = '".$regimenE."', 
		`rfcR` = '".$rfcR."', 
		`nombreR` = '".$nombreR."', 
		`UsoCFDI` = '".$UsoCFDI."', 
		`DomicilioFiscalReceptor` = '".$DomicilioFiscalReceptor."', 
		`RegimenFiscalReceptor` = '".$RegimenFiscalReceptor."', 
		`UUID` = '".$UUID."',
		`TuaTotalCargos` = '".$TuaTotalCargos."', /*aaa*/
		`TUA` = '".$TUA."',	
		`Propina` = '".$Propina."',	
		`Descuento` = '".$Descuento."',
		
		CantidadConcepto = '".$Cantidad."',
		ValorUnitarioConcepto = '".$ValorUnitario."',
		ImporteConcepto = '".$Importe."',
		ClaveProdServConcepto = '".$ClaveProdServ."',
		UnidadConcepto = '".$Unidad."',
		DescripcionConcepto = '".$Descripcion."',
		ClaveUnidadConcepto = '".$ClaveUnidad."',
		NoIdentificacionConcepto = '".$NoIdentificacion."',

		`TImpuestosRetenidos` = '".$TImpuestosRetenidos."', 
		`TImpuestosTrasladados` = '".$TImpuestosTrasladados."' 
		where
		`ultimo_id` = '".$ultimo_id."';  ";

		$var4 = "INSERT INTO ".$tabla." (
		`id`, `Version`, `fechaTimbrado`, `tipoDeComprobante`, 
		`metodoDePago`, `formaDePago`, `condicionesDePago`, `subTotal`, 
		`TipoCambio`, `Moneda`, `totalf`, `serie`, 
		`folio`, `LugarExpedicion`, `rfcE`, `nombreE`, 
		`regimenE`, `rfcR`, `nombreR`, `UsoCFDI`, 
		`DomicilioFiscalReceptor`, `RegimenFiscalReceptor`, `UUID`, `TImpuestosRetenidos`, 
		`TImpuestosTrasladados`, `idRelacion`, `ultimo_id`, `TuaTotalCargos`,Descuento, `TUA`, `Propina`, 
		
		
		CantidadConcepto , ValorUnitarioConcepto, ImporteConcepto, ClaveProdServConcepto, UnidadConcepto, DescripcionConcepto, ClaveUnidadConcepto, NoIdentificacionConcepto 
		
		
		
		) VALUES (
		'', '".$Version."', '".$FechaTimbrado."', '".$tipoDeComprobante."', 
		'".$metodoDePago."', '".$formaDePago."', '".$condicionesDePago."', '".$subTotal."', 
		'".$TipoCambio."', '".$Moneda."', '".$total."', '".$serie."', 
		'".$folio."', '".$LugarExpedicion."', '".$rfcE."', '".$nombreE."', 
		'".$regimenE."', '".$rfcR."', '".$nombreR."', '".$UsoCFDI."', 
		'".$DomicilioFiscalReceptor."', '".$RegimenFiscalReceptor."', '".$UUID."', '".$TImpuestosRetenidos."', 
		'".$TImpuestosTrasladados."', '".$session."', '".$ultimo_id."', '".$TuaTotalCargos."', 
		'".$Descuento."', '".$TUA."', '".$Propina."',
		'".$Cantidad."', '".$ValorUnitario."', '".$Importe."', '".$ClaveProdServ."', '".$Unidad."', '".$Descripcion."', '".$ClaveUnidad."', '".$NoIdentificacion."'
		
		
		);  ";
//print_r($regreso);
			$row = $this->busca_07XML2($ultimo_id,$tabla);
			//if($actualiza=='true'){
				if($row['ultimo_id']==0 or $row['ultimo_id']==''){
					mysqli_query($conn,$var4) or die('P350'.mysqli_error($conn));
					echo "Ingresado";					
				}else{
					mysqli_query($conn,$var3) or die('P352'.mysqli_error($conn));
					echo "Actualizado";
				}
			//}	
		}
	}		

	/*public function ingresar_02direccionproveedor1($conn,$idwebc){
		$queryrfc = "insert into 02direccionproveedor1 (idRelacion)values('".$idwebc."')";
		$arrayquery = mysqli_query($conn,$queryrfc);
		return $row = mysqli_fetch_array($arrayquery, MYSQLI_ASSOC);
	}    */
//ingresar_02direccionproveedor1

	public function verificar_usuario_comercial($conn,$nommbrerazon){
		$queryrfc = "SELECT * FROM 02direccionproveedor1 WHERE P_NOMBRE_COMERCIAL_EMPRESA = '".$nommbrerazon."' ";
		$arrayquery = mysqli_query($conn,$queryrfc);
		$row = mysqli_fetch_array($arrayquery, MYSQLI_ASSOC);
		return $row['id'];
	}

	public function revisar_pagoproveedor2($id){
		$conn = $this->db();
		$var1 = 'select id from 02SUBETUFACTURA where id =  "'.$id.'" ';
		$query = mysqli_query($conn,$var1) or die('P44'.mysqli_error($conn));
		$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
		return $row['id'];
	}

	public function ventasyoperacionesP ($NUMERO_CONSECUTIVO_PROVEE , $NOMBRE_COMERCIAL , $RAZON_SOCIAL ,$VIATICOSOPRO, $RFC_PROVEEDOR , $NUMERO_EVENTO ,$NOMBRE_EVENTO, $MOTIVO_GASTO , $CONCEPTO_PROVEE , $MONTO_TOTAL_COTIZACION_ADEUDO , $MONTO_DEPOSITAR , $MONTO_PROPINA , $FECHA_AUTORIZACION_RESPONSABLE , $FECHA_AUTORIZACION_AUDITORIA , $FECHA_DE_LLENADO , $MONTO_FACTURA , $TIPO_DE_MONEDA ,$PFORMADE_PAGO, $FECHA_DE_PAGO , $FECHA_A_DEPOSITAR , $STATUS_DE_PAGO , $BANCO_ORIGEN , $MONTO_DEPOSITADO , $CLASIFICACION_GENERAL , $CLASIFICACION_ESPECIFICA , $PLACAS_VEHICULO , $MONTO_DE_COMISION , $POLIZA_NUMERO , $NOMBRE_DEL_EJECUTIVO ,$NOMBRE_DEL_AYUDO, $OBSERVACIONES_1, $TIPO_CAMBIOP,  $TOTAL_ENPESOS,$IMPUESTO_HOSPEDAJE,$TImpuestosRetenidosIVA,$TImpuestosRetenidosISR,$descuentos,$IVA,  $ENVIARventasoper,$hiddenVENTASOPERACIONES,$IPventasoperar,
	$FechaTimbrado, $tipoDeComprobante, 
		$metodoDePago, $formaDePago, $condicionesDePago, $subTotal, 
		$TipoCambio, $Moneda, $total, $serie, 
		$folio, $LugarExpedicion, $rfcE, $nombreE, 
		$regimenE, $rfcR, $nombreR, $UsoCFDI, 
		$DomicilioFiscalReceptor, $RegimenFiscalReceptor, $UUID, $TImpuestosRetenidos, 
		$TImpuestosTrasladados, $TuaTotalCargos, $Descuento,$Propina, $TUA,$actualiza )
		{
			//ECHO "ASASFSS222";
		$MONTO_TOTAL_COTIZACION_ADEUDO = str_replace(',','',$MONTO_TOTAL_COTIZACION_ADEUDO);
		$MONTO_DEPOSITAR = str_replace(',','',$MONTO_DEPOSITAR);
		$MONTO_FACTURA = str_replace(',','',$MONTO_FACTURA);		
		$MONTO_PROPINA = str_replace(',','',$MONTO_PROPINA);
		$MONTO_DEPOSITADO = str_replace(',','',$MONTO_DEPOSITADO);
		$MONTO_DE_COMISION = str_replace(',','',$MONTO_DE_COMISION);
		$PENDIENTE_PAGO = str_replace(',','',$PENDIENTE_PAGO);	
	    $TOTAL_ENPESOS = str_replace(',','',$TOTAL_ENPESOS);		
		$TIPO_CAMBIOP = str_replace(',','',$TIPO_CAMBIOP);
		$IMPUESTO_HOSPEDAJE = str_replace(',','',$IMPUESTO_HOSPEDAJE);
		$IVA = str_replace(',','',$IVA);
	//hiddensubefactura
		/*$conn = $this->db();
		$existe = $this->revisar_ventasoperaciones();
		$session = isset($_SESSION['idPROV'])?$_SESSION['idPROV']:'';  */

		$conn = $this->db();
		$NOMBRE_COMERCIALvar = "SELECT * FROM `02direccionproveedor1` where idRelacion = '".$NOMBRE_COMERCIAL."' ";
		$query_NOMBRE_COMERCIAL = mysqli_query($conn,$NOMBRE_COMERCIALvar) or die('P160'.mysqli_error($conn));
		$row_NOMBRE_COMERCIAL = mysqli_fetch_array($query_NOMBRE_COMERCIAL, MYSQLI_ASSOC);
		$NOMBRE_COMERCIAL2 = $row_NOMBRE_COMERCIAL['P_NOMBRE_COMERCIAL_EMPRESA'];

		
		if( $this->verificar_rfc($conn,$RFC_PROVEEDOR)!=''){
			$session = $this->verificar_rfc($conn,$RFC_PROVEEDOR);
		}elseif($this->verificar_usuario_comercial($conn,$NOMBRE_COMERCIAL2)!=''){
			$session = $this->verificar_usuario_comercial($conn,$NOMBRE_COMERCIAL2);
		}else{$session = 1;

		}
		
/*		

11select * from 02SUBETUFACTURADOCTOS where idRelacion = '535' and idTemporal = 'si' and (ADJUNTAR_FACTURA_XML is not null or ADJUNTAR_FACTURA_XML <> '') and idRelacionU = '1' and TIPOARCHIVO = 'xml' order by id desc /home/u492963066/domains/epcinn.com/public_html/pruebas/crm2/main-files/syn-ui/sistemaPRUEBAS/includes/archivos/Ingresado


if( $ventasoperaciones->verificar_rfc($conn,$rfcE) ==''){
			$idwebc = $ventasoperaciones->ingresar_usuario($conn,TRIM($nombreE));
			$ventasoperaciones->ingresar_rfc($conn,TRIM($rfcE),$idwebc);
		}elseif($ventasoperaciones->verificar_rfc($conn,$rfcE) !=''){
			$idwebc = $ventasoperaciones->verificar_rfc($conn,$rfcE);
		}else{
			$idwebc = $ventasoperaciones->verificar_usuario($conn,$nombreE);
		}*/
		
                $existe = $this->revisar_pagoproveedor2($IPventasoperar);
                $registroId = $IPventasoperar;

                if($registroId == '' && $existe != ''){
                        $registroId = $existe;
                }
		
		$idRelacionU = isset($_SESSION['idempermiso'])?$_SESSION['idempermiso']:'';

		$idem = isset($_SESSION['idem'])?$_SESSION['idem']:'';

		if($idem != ''){                           
			//ADJUNTAR_FACTURA_XML idPROV
		$var1 = "update 02SUBETUFACTURA set
		NUMERO_CONSECUTIVO_PROVEE = '".$NUMERO_CONSECUTIVO_PROVEE."' , NOMBRE_COMERCIAL = '".$NOMBRE_COMERCIAL."' , RAZON_SOCIAL = '".$RAZON_SOCIAL."' , VIATICOSOPRO = '".$VIATICOSOPRO."' , RFC_PROVEEDOR = '".$RFC_PROVEEDOR."' , NUMERO_EVENTO = '".$NUMERO_EVENTO."' , NOMBRE_EVENTO = '".$NOMBRE_EVENTO."' , MOTIVO_GASTO = '".$MOTIVO_GASTO."' , CONCEPTO_PROVEE = '".$CONCEPTO_PROVEE."' , MONTO_TOTAL_COTIZACION_ADEUDO = '".$MONTO_TOTAL_COTIZACION_ADEUDO."' , MONTO_DEPOSITAR = '".$MONTO_DEPOSITAR."' , MONTO_PROPINA = '".$MONTO_PROPINA."' , FECHA_AUTORIZACION_RESPONSABLE = '".$FECHA_AUTORIZACION_RESPONSABLE."' , FECHA_AUTORIZACION_AUDITORIA = '".$FECHA_AUTORIZACION_AUDITORIA."' ,FECHA_DE_LLENADO = '".$FECHA_DE_LLENADO."' , MONTO_FACTURA = '".$MONTO_FACTURA."' , TIPO_DE_MONEDA = '".$TIPO_DE_MONEDA."' , PFORMADE_PAGO = '".$PFORMADE_PAGO."' , FECHA_DE_PAGO = '".$FECHA_DE_PAGO."' , FECHA_A_DEPOSITAR = '".$FECHA_A_DEPOSITAR."' , STATUS_DE_PAGO = '".$STATUS_DE_PAGO."' , BANCO_ORIGEN = '".$BANCO_ORIGEN."' , MONTO_DEPOSITADO = '".$MONTO_DEPOSITADO."' , CLASIFICACION_GENERAL = '".$CLASIFICACION_GENERAL."' , CLASIFICACION_ESPECIFICA = '".$CLASIFICACION_ESPECIFICA."' , PLACAS_VEHICULO = '".$PLACAS_VEHICULO."' , MONTO_DE_COMISION = '".$MONTO_DE_COMISION."' , POLIZA_NUMERO = '".$POLIZA_NUMERO."' , NOMBRE_DEL_EJECUTIVO = '".$NOMBRE_DEL_EJECUTIVO."' , NOMBRE_DEL_AYUDO = '".$NOMBRE_DEL_AYUDO."' , OBSERVACIONES_1 = '".$OBSERVACIONES_1."' , TIPO_CAMBIOP = '".$TIPO_CAMBIOP."' , TOTAL_ENPESOS = '".$TOTAL_ENPESOS."' , IMPUESTO_HOSPEDAJE = '".$IMPUESTO_HOSPEDAJE."' , TImpuestosRetenidosIVA = '".$TImpuestosRetenidosIVA."' , TImpuestosRetenidosISR = '".$TImpuestosRetenidosISR."' , descuentos = '".$descuentos."' , IVA = '".$IVA."' where id = '".$registroId."' ; ";
		
		//hiddenVENTASOPERACIONES
		$var2 = "insert into 02SUBETUFACTURA ( 
		NUMERO_CONSECUTIVO_PROVEE, 
		NOMBRE_COMERCIAL, 
		RAZON_SOCIAL, 
		VIATICOSOPRO, 
		RFC_PROVEEDOR, 
		NUMERO_EVENTO,
		NOMBRE_EVENTO,
		MOTIVO_GASTO, 
		CONCEPTO_PROVEE, 
		MONTO_TOTAL_COTIZACION_ADEUDO, 
		MONTO_DEPOSITAR, 
		MONTO_PROPINA,
		FECHA_AUTORIZACION_RESPONSABLE,
		FECHA_AUTORIZACION_AUDITORIA, 
		FECHA_DE_LLENADO, 
		MONTO_FACTURA, 
		TIPO_DE_MONEDA,
        PFORMADE_PAGO,		
		FECHA_DE_PAGO, 
		FECHA_A_DEPOSITAR, 
		STATUS_DE_PAGO, 
		BANCO_ORIGEN, 
		MONTO_DEPOSITADO, 
		CLASIFICACION_GENERAL, 
		CLASIFICACION_ESPECIFICA, 
		PLACAS_VEHICULO, 
		MONTO_DE_COMISION, 
		POLIZA_NUMERO, 
		NOMBRE_DEL_EJECUTIVO, 
		NOMBRE_DEL_AYUDO, 
		
		OBSERVACIONES_1,
		TIPO_CAMBIOP,
		TOTAL_ENPESOS,
		IMPUESTO_HOSPEDAJE,		
		TImpuestosRetenidosIVA,		
		TImpuestosRetenidosISR,		
		descuentos,		
		IVA,		

		idRelacion) values ( 
		'".$NUMERO_CONSECUTIVO_PROVEE."' , 
		'".$NOMBRE_COMERCIAL2."' , 
		'".$RAZON_SOCIAL."' , 
		'".$VIATICOSOPRO."' , 
		'".$RFC_PROVEEDOR."' , 
		'".$NUMERO_EVENTO."' , 
		'".$NOMBRE_EVENTO."' , 
		'".$MOTIVO_GASTO."' , 
		'".$CONCEPTO_PROVEE."' , 
		'".$MONTO_TOTAL_COTIZACION_ADEUDO."' , 
		'".$MONTO_DEPOSITAR."' , 
		'".$MONTO_PROPINA."' , 	
		'".$FECHA_AUTORIZACION_RESPONSABLE."' , 
		'".$FECHA_AUTORIZACION_AUDITORIA."' , 
		'".$FECHA_DE_LLENADO."' , 
		'".$MONTO_FACTURA."' , 
		'".$TIPO_DE_MONEDA."' , 
		'".$PFORMADE_PAGO."' , 
		'".$FECHA_DE_PAGO."' , 
		'".$FECHA_A_DEPOSITAR."' , 
		'".$STATUS_DE_PAGO."' , 
		'".$BANCO_ORIGEN."' , 
		'".$MONTO_DEPOSITADO."' ,
		'".$CLASIFICACION_GENERAL."' , 
		'".$CLASIFICACION_ESPECIFICA."' , 
		'".$PLACAS_VEHICULO."' , 
		'".$MONTO_DE_COMISION."' , 
		'".$POLIZA_NUMERO."' , 
		'".$NOMBRE_DEL_EJECUTIVO."' , 
		'".$NOMBRE_DEL_AYUDO."' , 
		
		'".$OBSERVACIONES_1."',
		'".$TIPO_CAMBIOP."',
		'".$TOTAL_ENPESOS."',
		'".$IMPUESTO_HOSPEDAJE."',
		'".$TImpuestosRetenidosIVA."',
		'".$TImpuestosRetenidosISR."',
		'".$descuentos."',
		'".$IVA."',

		'".$session."' );  ";			

     // Se actualiza cuando existe un identificador de registro
                // en lugar de depender del texto del botón de envío.
                if($IPventasoperar != ''){

		$this->ActualizaxmlDB($FechaTimbrado, $tipoDeComprobante, 
		$metodoDePago, $formaDePago, $condicionesDePago, $subTotal, 
		$TipoCambio, $Moneda, $total, $serie, 
		$folio, $LugarExpedicion, $rfcE, $nombreE, 
		$regimenE, $rfcR, $nombreR, $UsoCFDI, 
		$DomicilioFiscalReceptor, $RegimenFiscalReceptor, $UUID, $TImpuestosRetenidos, 
                $TImpuestosTrasladados, $session, $registroId, $TuaTotalCargos, $TUA, $Descuento, $Propina, $conn,$actualiza );


		mysqli_query($conn,$var1) or die('P1561'.mysqli_error($conn));
		return "Actualizado";
		}else{

		mysqli_query($conn,$var2) or die('P160'.mysqli_error($conn));

		$ultimo_id ='';	
		$ultimo_id = mysqli_insert_id($conn);
		//$this->guardarxmlDB($ultimo_id,$conn);
		$regresourl = $this->variable_SUBETUFACTURA2($_SESSION['idPROV']);
		$url = __ROOT3__.'/includes/archivos/'.$regresourl['ADJUNTAR_FACTURA_XML'];
		ob_start();
		$this->guardarxmlDB2($ultimo_id,$_SESSION['idPROV'],'02XML',$url);
		ob_end_clean();
		$var3 = "UPDATE 02SUBETUFACTURADOCTOS SET idTemporal ='".$ultimo_id."' where idRelacion = '".$_SESSION['idPROV']."' and idTemporal ='si' "; 			
		mysqli_query($conn,$var3);	
		return "Ingresado";
		}
			
        }else{
		echo "NO HAY UN PROVEEDOR SELECCIONADO";	
		}
    }

//Listado_subefacturaDOCTOS
	public function borraventasoperaciones($id){
	$conn = $this->db();
	//papa
	$var1 = "DELETE FROM 02SUBETUFACTURA where id = '".$id."' "; 
	mysqli_query($conn,$var1) or die('P44'.mysqli_error($conn));
		
	$var2 = "DELETE FROM `02XML` WHERE `ultimo_id` = '".$id."' ";
	mysqli_query($conn,$var2) or die('P44'.mysqli_error($conn));
	ECHO "ELEMENTO BORRADO";
	
	$var3 = "DELETE FROM `02SUBETUFACTURADOCTOS` WHERE `idTemporal` = '".$id."' ";
	mysqli_query($conn,$var3) or die('P44'.mysqli_error($conn));
	ECHO "ELEMENTO BORRADO";	

	}
    
	//Listado_subefacturadocto
public function getDoctos_subefactura($ID)
{
    $conn = $this->db();

    $sql = "
        SELECT 
            COMPLEMENTOS_PAGO_PDF,
            COMPLEMENTOS_PAGO_XML
        FROM 02SUBETUFACTURADOCTOS
        WHERE idTemporal = '".mysqli_real_escape_string($conn,$ID)."'
        ORDER BY id DESC
        LIMIT 1
    ";

    $query = mysqli_query($conn, $sql);
    return $query ? mysqli_fetch_array($query, MYSQLI_ASSOC) : null;
}
    public function select_02XML(){
    $conn = $this->db(); 
    $variablequery = "select id from 02XML order by id desc "; 
    $arrayquery = mysqli_query($conn,$variablequery);
    $row = mysqli_fetch_array($arrayquery, MYSQLI_ASSOC);
	return $row['id'];	
}

    public function VALIDA02XMLUUID($uuid){
    $conn = $this->db(); 
    $variablequery = "select id,UUID from 02XML where UUID = '".$uuid."' "; 
    $arrayquery = mysqli_query($conn,$variablequery);
    $row = mysqli_fetch_array($arrayquery, MYSQLI_ASSOC);
    if($row['id']==0 or $row['id']==''){
	return 'S';
}   else{
	return $row['id'];	
}
}






public function Listado_ventasoperaciones(){ $conn = $this->db(); $variablequery = "select * from 02SUBETUFACTURA where idRelacion = '".$_SESSION['idPROV']."' order by id desc "; return $arrayquery = mysqli_query($conn,$variablequery); } 




 

    public function Listado_ventasoperaciones2($id){ $conn = $this->db(); $variablequery = "select * from 02SUBETUFACTURA where id = '".$id."' "; return $arrayquery = mysqli_query($conn,$variablequery); }
//Listado_subefacturadocto

    public function Listado_subefacturaDOCTOS($ID){ $conn = $this->db(); $variablequery = "select * from 02SUBETUFACTURADOCTOS where idTemporal = '".$ID."'  order by id desc "; return $arrayquery = mysqli_query($conn,$variablequery); }

    public function Listado_subefacturadocto($ADJUNTAR_COTIZACION){
	$conn = $this->db(); 
	
	$CIERRE_TOTAL11= strtotime('-1 hours', strtotime(date("Y-m-d")));
	$nuevafecha2 = date ( 'Y-m-d' , $CIERRE_TOTAL11 );

	$variablequeryborra = "DELETE FROM 02SUBETUFACTURADOCTOS WHERE `fechaingreso` <= '".$nuevafecha2."' and idRelacion = '".$_SESSION['idPROV']."' and idTemporal = 'si'  ";
	mysqli_query($conn,$variablequeryborra);
	
	$variablequery = "select id,".$ADJUNTAR_COTIZACION.",fechaingreso from 02SUBETUFACTURADOCTOS where idRelacion = '".$_SESSION['idPROV']."' and idTemporal = 'si' and (".$ADJUNTAR_COTIZACION." is not null or ".$ADJUNTAR_COTIZACION." <> '') ORDER BY id DESC "; 
	return $arrayquery = mysqli_query($conn,$variablequery); 
	} 
	
  public function delete_subefacturadocto2($id){ $conn = $this->db();

    $query = "SELECT idTemporal, ADJUNTAR_FACTURA_XML FROM 02SUBETUFACTURADOCTOS WHERE id = '".$id."' ";
    $resultado = mysqli_query($conn,$query);
    $row = mysqli_fetch_array($resultado, MYSQLI_ASSOC);

    if ($row && $row['ADJUNTAR_FACTURA_XML'] != '') {
        $variablequery = "DELETE FROM 02XML WHERE ultimo_id = '".$row['idTemporal']."' ";
        mysqli_query($conn,$variablequery);


    }

    $variablequery = "delete from 02SUBETUFACTURADOCTOS where id = '".$id."' ";
    return $arrayquery = mysqli_query($conn,$variablequery);

}




   public function delete_subefactura2nombre($nombre){ $conn = $this->db(); 
   $variablequery = "delete from 02SUBETUFACTURADOCTOS where ADJUNTAR_FACTURA_XML = '".$nombre."' ";
   mysqli_query($conn,$variablequery); 

}






/* DATOS BANCARIOS 1 */ 


	public function variable_DATOSBANCARIOS1(){
		$conn = $this->db();
		$variablequery = "select * from 02DATOSBANCARIOS1 where idRelacion = '".$_SESSION['idPROV']."' ";
		$arrayquery = mysqli_query($conn,$variablequery);
		return $row = mysqli_fetch_array($arrayquery, MYSQLI_ASSOC);		
	}

	public function revisar_DATOSBANCARIOS1(){
		$conn = $this->db();
		$var1 = 'select id from 02DATOSBANCARIOS1 where idRelacion =  "'.$_SESSION['idPROV'].'" ';
		$query = mysqli_query($conn,$var1) or die('P44'.mysqli_error($conn));
		$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
		return $row['id'];
	}

	public function enviarDATOSBANCARIOS1 (
	$P_TIPO_DE_MONEDA_1 , $P_INSTITUCION_FINANCIERA_1 , $P_NUMERO_DE_CUENTA_DB_1 , $P_NUMERO_CLABE_1 , 
	$P_NUMERO_DE_SUCURSAL_1 , $P_NUMERO_IBAN_1 , $P_NUMERO_CUENTA_SWIFT_1,$FOTO_ESTADO_PROVEE,$ULTIMA_CARGA_DATOBANCA, $ENVIARRdatosbancario1p,$IPdatosbancario1p ){
	
		$conn = $this->db();
		$existe = $this->revisar_DATOSBANCARIOS1();
		$session = isset($_SESSION['idPROV'])?$_SESSION['idPROV']:'';    
		if($session != ''){
			
		$var1 = "update 02DATOSBANCARIOS1 set P_TIPO_DE_MONEDA_1 = '".$P_TIPO_DE_MONEDA_1."' , P_INSTITUCION_FINANCIERA_1 = '".$P_INSTITUCION_FINANCIERA_1."' , P_NUMERO_DE_CUENTA_DB_1 = '".$P_NUMERO_DE_CUENTA_DB_1."' , P_NUMERO_CLABE_1 = '".$P_NUMERO_CLABE_1."' , P_NUMERO_DE_SUCURSAL_1 = '".$P_NUMERO_DE_SUCURSAL_1."' , P_NUMERO_IBAN_1 = '".$P_NUMERO_IBAN_1."' , P_NUMERO_CUENTA_SWIFT_1 = '".$P_NUMERO_CUENTA_SWIFT_1."' ,ULTIMA_CARGA_DATOBANCA = '".$ULTIMA_CARGA_DATOBANCA."'  where id = '".$IPdatosbancario1p."' ; ";
		
		
		$var2 = "insert into 02DATOSBANCARIOS1 (P_TIPO_DE_MONEDA_1, P_INSTITUCION_FINANCIERA_1, P_NUMERO_DE_CUENTA_DB_1, P_NUMERO_CLABE_1, P_NUMERO_DE_SUCURSAL_1, P_NUMERO_IBAN_1, P_NUMERO_CUENTA_SWIFT_1,FOTO_ESTADO_PROVEE, ULTIMA_CARGA_DATOBANCA, idRelacion) values ( '".$P_TIPO_DE_MONEDA_1."' , '".$P_INSTITUCION_FINANCIERA_1."' , '".$P_NUMERO_DE_CUENTA_DB_1."' , '".$P_NUMERO_CLABE_1."' , '".$P_NUMERO_DE_SUCURSAL_1."' , '".$P_NUMERO_IBAN_1."' , '".$P_NUMERO_CUENTA_SWIFT_1."' , '".$FOTO_ESTADO_PROVEE."' , '".$ULTIMA_CARGA_DATOBANCA."' , '".$session."' );  ";			
	
		if($ENVIARRdatosbancario1p=='ENVIARRdatosbancario1p'){	

		mysqli_query($conn,$var1) or die('P1563'.mysqli_error($conn));
		return "Actualizado";
		}else{
		mysqli_query($conn,$var2) or die('P1604'.mysqli_error($conn));
		return "Ingresado";
		}
			
        }else{
		echo "NO HAY UN PROVEEDOR SELECCIONADO";	
		}
    }



	public function Listado_datos_bancariosPRO(){
		$conn = $this->db();

		$variablequery = "select * from 02DATOSBANCARIOS1 where idRelacion = '".$_SESSION['idPROV']."' order by id desc ";
		return $arrayquery = mysqli_query($conn,$variablequery);
	}


        public function Listado_datos_bancariosPRO2($id){
		$conn = $this->db();
		$variablequery = "select * from 02DATOSBANCARIOS1 where id = '".$id."' "; 
		return $arrayquery = mysqli_query($conn,$variablequery);
		}


		function borra_datos_bancario1($id){
			$conn = $this->db();
			$variablequery = "delete from 02DATOSBANCARIOS1 where id = '".$id."' ";
			$arrayquery = mysqli_query($conn,$variablequery);
			RETURN 
			
			"<P style='color:green; font-size:18px;'>ELEMENTO BORRADO</P>";
		}
	
		public function borrar_historico_xml($nombretabla,$idusuario){
			$conn = $this->db();
			$ruta = __ROOT3__;
			
			$var2 = "SELECT * FROM ".$nombretabla." WHERE 
			`idRelacionU` = '".$idusuario."' and TIPOARCHIVO = 'xml' and idTemporal = 'si' ";
			$QUERYVAR2 = mysqli_query($conn,$var2) or die('P44'.mysqli_error($conn));
			while($row = mysqli_fetch_array($QUERYVAR2, MYSQLI_ASSOC)){
				if( file_exists($ruta.''.$row['ADJUNTAR_FACTURA_XML']) ){
				UNLINK($ruta.''.$row['ADJUNTAR_FACTURA_XML']);
				}
			}
			$var3 = "DELETE FROM ".$nombretabla." WHERE 
			`idRelacionU` = '".$idusuario."' and 
			TIPOARCHIVO = 'xml' and idTemporal = 'si' ";
			mysqli_query($conn,$var3) or die('P441'.mysqli_error($conn));	
			
			$var3 = "DELETE FROM ".$nombretabla." WHERE 
			`idRelacionU` = '".$idusuario."' and 
			idTemporal = 'si' and 
			TIPOARCHIVO = 'OTR'  ";
			mysqli_query($conn,$var3) or die('P442'.mysqli_error($conn));
		}

		public function buscarNOMBRECOMERCIAL($filtro){
			$conn = $this->db();
				$variable = "select * from 02usuarios where 
				nommbrerazon like '%".$filtro."%' /*ORDER BY 
				CASE
				WHEN nommbrerazon like '%".$filtro."%' THEN 1
				else nommbrerazon
				END*/ limit 20 ";
			$variablequery = mysqli_query($conn,$variable);
			while($row2 = mysqli_fetch_array($variablequery, MYSQLI_ASSOC)){
				$resultado2[] = ['id'=>$row2['id'],'text'=>$row2['nommbrerazon']];
			}			
			return $resultado2;	
		}
		
		public function buscarrasonsocial($filtro){
			$conn = $this->db();
			$_SESSION['QUERYaaa']=$variable = "select * from 02direccionproveedor1 where idRelacion = '".$filtro."' ";
			$variablequery = mysqli_query($conn,$variable);
			$row2 = mysqli_fetch_array($variablequery, MYSQLI_ASSOC);	
			return $row2['P_NOMBRE_FISCAL_RS_EMPRESA'].'^^^'.$row2['P_RFC_MTDP'];	
		}

		public function buscarNOMBRECOMERCIAL22($rfc){
			$conn = $this->db();
			$variable = "select *,02direccionproveedor1.idRelacion as idusuario  from 
			02direccionproveedor1 left join 02usuarios
			on 02direccionproveedor1.idRelacion = 02usuarios.id
			where P_RFC_MTDP ='".$rfc."' " ;


			
			$variablequery = mysqli_query($conn,$variable);
			$row2 = mysqli_fetch_array($variablequery, MYSQLI_ASSOC);

			$_SESSION['idusuario12'] = $row2['idusuario'];
			$_SESSION['P_NOMBRE_COMERCIAL_EMPRESA12'] = $row2['P_NOMBRE_COMERCIAL_EMPRESA'];

			return $row2['idusuario'].'^^^^'.$row2['P_NOMBRE_COMERCIAL_EMPRESA'];	
		}

}


	?>