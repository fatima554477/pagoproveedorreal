<?php
/*
clase EPC INNOVA
CREADO : 10/mayo/2023
fecha sandor: 
fecha fatis : 07/04/2024

*/



	define('__ROOT3__', dirname(dirname(__FILE__)));
	require __ROOT3__."/includes/class.epcinn.php";	
	
	
class accesoclase extends colaboradores{

	private function nombre_usuario_bitacora(){
		if(isset($_SESSION['NOMBREUSUARIO']) && $_SESSION['NOMBREUSUARIO'] != ''){
			return $_SESSION['NOMBREUSUARIO'];
		}
		if(isset($_SESSION['nombreusuario']) && $_SESSION['nombreusuario'] != ''){
			return $_SESSION['nombreusuario'];
		}
		if(isset($_SESSION['usuario']) && $_SESSION['usuario'] != ''){
			return $_SESSION['usuario'];
		}
		if(isset($_SESSION['idem']) && $_SESSION['idem'] != ''){
			return 'ID:'.$_SESSION['idem'];
		}
		return 'SIN_USUARIO';
	}

	private function registrar_bitacora($conn, $idcomprobacion, $tipoMovimiento, $detalle, $nombreQuienIngreso = '', $nombreQuienActualizo = ''){
		$crearTabla = "CREATE TABLE IF NOT EXISTS `02SUBETUFACTURA_BITACORA` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`id_subetufactura` int(11) NOT NULL DEFAULT 0,
			`tipo_movimiento` varchar(50) NOT NULL,
			`detalle` text,
			`fecha_hora` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`nombre_quien_ingreso` varchar(255) DEFAULT NULL,
			`nombre_quien_actualizo` varchar(255) DEFAULT NULL,
			PRIMARY KEY (`id`),
			KEY `idx_id_subetufactura` (`id_subetufactura`),
			KEY `idx_fecha_hora` (`fecha_hora`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
		mysqli_query($conn, $crearTabla);

		$idcomprobacion = intval($idcomprobacion);
		$tipoMovimiento = mysqli_real_escape_string($conn, $tipoMovimiento);
		$detalle = mysqli_real_escape_string($conn, $detalle);
		$nombreQuienIngreso = mysqli_real_escape_string($conn, $nombreQuienIngreso);
		$nombreQuienActualizo = mysqli_real_escape_string($conn, $nombreQuienActualizo);

		$insertBitacora = "INSERT INTO 02SUBETUFACTURA_BITACORA
		(id_subetufactura, tipo_movimiento, detalle, fecha_hora, nombre_quien_ingreso, nombre_quien_actualizo)
		VALUES
		('".$idcomprobacion."', '".$tipoMovimiento."', '".$detalle."', NOW(), '".$nombreQuienIngreso."', '".$nombreQuienActualizo."')";

		mysqli_query($conn, $insertBitacora);
	}

	private function valor_actual_campo_subetufactura($conn, $idcomprobacion, $campo){
		$camposPermitidos = array(
			'STATUS_RESPONSABLE_EVENTO',
			'STATUS_DE_PAGO',
			'STATUS_AUDITORIA3',
			'STATUS_SINXML',
			'STATUS_CHECKBOX',
			'STATUS_AUDITORIA2',	
            'STATUS_RECHAZADO',
			
			'STATUS_FINANZAS',
			'STATUS_VENTAS'
		);

		if(!in_array($campo, $camposPermitidos)){
			return '';
		}

		$idcomprobacion = intval($idcomprobacion);
		$consulta = "SELECT ".$campo." AS valor FROM 02SUBETUFACTURA WHERE id = '".$idcomprobacion."' LIMIT 1";
		$query = mysqli_query($conn, $consulta);
		if($query){
			$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
			if($row && isset($row['valor'])){
				return $row['valor'];
			}
		}
		return '';
	}

	private function registrar_cambio_estado_detallado($conn, $idcomprobacion, $campo, $valorAnterior, $valorNuevo, $descripcion = ''){
		$detalle = 'Se actualizó '.$this->etiqueta_bitacora_campo($campo).' de "'.$valorAnterior.'" a "'.$valorNuevo.'".';
		if($descripcion != ''){
			$detalle .= ' '.$descripcion;
		}
		$this->registrar_bitacora($conn, $idcomprobacion, 'ACTUALIZACION', $detalle, '', $this->nombre_usuario_bitacora());
	}

	private function etiqueta_bitacora_campo($campo){
		$etiquetas = array(
			'STATUS_RESPONSABLE_EVENTO'     => 'ESTATUS RESPONSABLE DEL EVENTO',
			'STATUS_DE_PAGO'                => 'ESTATUS DE PAGO',
			'STATUS_AUDITORIA3'             => 'CHECK BOX VoBo CxP',
			'STATUS_SINXML'                 => 'SIN EFECTO XML',
			'STATUS_CHECKBOX'               => 'SE QUITO EL 46% PERDIDA FISCAL',
			'STATUS_AUDITORIA2'             => 'AUTORIZACIÓN POR AUDITORÍA',
			'STATUS_RECHAZADO'              => 'PAGO RECHAZADO',
			'STATUS_FINANZAS'               => 'AUTORIZACIÓN POR DIRECCIÓN',
			'STATUS_VENTAS'                 => 'AUTORIZACIÓN POR VENTAS',
			'MONTO_DEPOSITAR'               => 'TOTAL A PAGAR',
			'FECHA_A_DEPOSITAR'             => 'FECHA EFECTIVA DE PAGO',
			'FECHA_DE_PAGO'                 => 'FECHA DE PROGRAMACIÓN DEL PAGO',
			'PFORMADE_PAGO'                 => 'FORMA DE PAGO',
			'NUMERO_EVENTO'                 => 'NÚMERO DE EVENTO',
			'NOMBRE_EVENTO'                 => 'NOMBRE DEL EVENTO',
			'NOMBRE_COMERCIAL'              => 'NOMBRE COMERCIAL',
			'RAZON_SOCIAL'                  => 'RAZÓN SOCIAL',
			'RFC_PROVEEDOR'                 => 'RFC DEL PROVEEDOR',
			'MOTIVO_GASTO'                  => 'MOTIVO DEL GASTO',
			'CONCEPTO_PROVEE'               => 'CONCEPTO',
			'MONTO_TOTAL_COTIZACION_ADEUDO' => 'COTIZACIÓN',
			'MONTO_PROPINA'                 => 'PROPINA',
			'MONTO_FACTURA'                 => 'SUB TOTAL',
			'TIPO_DE_MONEDA'                => 'TIPO DE MONEDA',
			'BANCO_ORIGEN'                  => 'INSTITUCIÓN BANCARIA',
			'MONTO_DEPOSITADO'              => 'MONTO DEPOSITADO',
			'CLASIFICACION_GENERAL'         => 'CLASIFICACIÓN GENERAL',
			'CLASIFICACION_ESPECIFICA'      => 'CLASIFICACIÓN ESPECÍFICA',
			'MONTO_DE_COMISION'             => 'MONTO DE COMISIÓN',
			'POLIZA_NUMERO'                 => 'NÚMERO DE PÓLIZA',
			'NOMBRE_DEL_EJECUTIVO'          => 'NOMBRE DEL EJECUTIVO',
			'NOMBRE_DEL_AYUDO'              => 'NOMBRE DE QUIEN INGRESO',
			'OBSERVACIONES_1'               => 'OBSERVACIONES',
			'TIPO_CAMBIOP'                  => 'TIPO DE CAMBIO',
			'TOTAL_ENPESOS'                 => 'TOTAL EN PESOS',
			'IMPUESTO_HOSPEDAJE'            => 'IMPUESTO DE HOSPEDAJE',
			'TImpuestosRetenidosIVA'        => 'IVA RETENIDO',
			'TImpuestosRetenidosISR'        => 'ISR RETENIDO',
			'descuentos'                    => 'DESCUENTOS',
			'IVA'                           => 'IVA',
			'ACTIVO_FIJO'                   => 'ACTIVO FIJO',
			'GASTO_FIJO'                    => 'GASTO FIJO',
			'VIATICOSOPRO'                  => 'TIPO DE PAGO',
		);

		if(isset($etiquetas[$campo])){
			return $etiquetas[$campo];
		}

		return str_replace('_', ' ', $campo);
	}

	public function registrar_bitacora_adjuntos($idcomprobacion, $tipoAdjunto, $nombreArchivo){
		$conn = $this->db();
		$idcomprobacion = intval($idcomprobacion);
		if($idcomprobacion <= 0){
			return;
		}

		$tipoAdjunto = trim($tipoAdjunto);
		$nombreArchivo = trim($nombreArchivo);
		if($tipoAdjunto == ''){
			return;
		}

		$detalle = 'Se subió archivo '.$tipoAdjunto;
		if($nombreArchivo != ''){
			$detalle .= ': '.$nombreArchivo;
		}
		$detalle .= '.';

		$this->registrar_bitacora(
			$conn,
			$idcomprobacion,
			'ADJUNTO',
			$detalle,
			'',
			$this->nombre_usuario_bitacora()
		);
	}

	public function var_altaeventos(){
		$conn = $this->db();
		$variablequery = "select * from 04altaeventos where id = '".$_SESSION['idevento']."' ";
		$arrayquery = mysqli_query($conn,$variablequery);
		return $row = mysqli_fetch_array($arrayquery, MYSQLI_ASSOC);		
	}


	public function buscarNOMBRECOMERCIAL($filtro){
		
		$conn = $this->db();
$variable = "select * from 02usuarios where 
			nommbrerazon like '%".$filtro."%' /*ORDER BY 
  CASE
    WHEN nommbrerazon like '%".$filtro."%' THEN 1
	else nommbrerazon
  END*/
  
  limit 20 ";
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
	
public function buscarnumero($filtro){
		$conn = $this->db();
		$variable = "select * from 04NUMEROevento where NUMERO_DE_EVENTO like '%".$filtro."%' ";
$variablequery = mysqli_query($conn,$variable);
		while($row = mysqli_fetch_array($variablequery, MYSQLI_ASSOC)){
			$resultado [] = $row['NUMERO_DE_EVENTO'];
		}
		return $resultado;
		
	}

	public function listadoEventos(){
		$conn = $this->db();
		$variablequery = "select NUMERO_EVENTO, NOMBRE_EVENTO from 04altaeventos order by NUMERO_EVENTO";
		return mysqli_query($conn,$variablequery);
	}

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

	public function pendiente_pago($total_menos_depositado,$NUMERO_EVENTO){
		$total_menos_depositado = str_replace(',','',$total_menos_depositado);
		$conn = $this->db();
		$variable = "select * from 02SUBETUFACTURA where NUMERO_EVENTO = '".$NUMERO_EVENTO."' ";
		$resultado = 0;
		$variablequery = mysqli_query($conn,$variable);
		while($row = mysqli_fetch_array($variablequery, MYSQLI_ASSOC)){
			$resultado += $row['MONTO_DEPOSITADO'];
		}
		
		$resultado2 = 'sssssssssssssss';
		return $total_menos_depositado - $resultado;
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

	public function buscarciudad($filtro){
		$conn = $this->db();
		$variable = "select * from 04altaeventos where NUMERO_EVENTO = '".$filtro."' ";
$variablequery = mysqli_query($conn,$variable);
		while($row = mysqli_fetch_array($variablequery, MYSQLI_ASSOC)){
			$resultado=$row['CIUDAD_DEL_EVENTO'];
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

	public function variable_SUBETUFACTURA2($id12){
		$conn = $this->db();
		$variablequery = "select * from 02SUBETUFACTURADOCTOS where idRelacion = '".$id12."' and idTemporal = 'si' and (ADJUNTAR_FACTURA_XML is not null or ADJUNTAR_FACTURA_XML <> '') order by id desc ";
		$arrayquery = mysqli_query($conn,$variablequery);
		return $row = mysqli_fetch_array($arrayquery, MYSQLI_ASSOC);		
	}

	public function revisar_pagoproveedor(){
		$conn = $this->db();
		$var1 = 'select id from 02SUBETUFACTURA where idRelacion =  "'.$_SESSION['idPROV'].'" ';
		$query = mysqli_query($conn,$var1) or die('P44'.mysqli_error($conn));
		$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
		return $row['id'];
	}



	public function revisar_pagoproveedor2($id){
		$conn = $this->db();
		$var1 = 'select id from 02SUBETUFACTURA where id =  "'.$id.'" ';
		$query = mysqli_query($conn,$var1) or die('P44'.mysqli_error($conn));
		$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
		return $row['id'];
	}
	
	public function busca_02XML($ultimo_id){
	$conn = $this->db();		
	$variablequery = "select * from 02XML where ultimo_id = '".$ultimo_id."' "; 
	$arrayquery = mysqli_query($conn,$variablequery);
	return $row = mysqli_fetch_array($arrayquery, MYSQLI_ASSOC);
	}

	public function busca_07XML2($ultimo_id,$tabla){
	$conn = $this->db();		
	$variablequery = "select * from ".$tabla." where ultimo_id = '".$ultimo_id."' "; 
	$arrayquery = mysqli_query($conn,$variablequery);
	return $row = mysqli_fetch_array($arrayquery, MYSQLI_ASSOC);
	}



  	public function ActualizaxmlDB($FechaTimbrado, $tipoDeComprobante, 
		$metodoDePago, $formaDePago, $condicionesDePago, $subTotal, 
		$TipoCambio, $Moneda, $total, $serie, 
		$folio, $LugarExpedicion, $rfcE, $nombreE, 
		$regimenE, $rfcR, $nombreR, $UsoCFDI, 
		$DomicilioFiscalReceptor, $RegimenFiscalReceptor, $UUID, $TImpuestosRetenidos, 
		$TImpuestosTrasladados, $session, $ultimo_id, $TuaTotalCargos, $TUA, $Descuento, $Propina, $conn,  $actualiza,$DescripcionConcepto){

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
	`TImpuestosTrasladados` = '".$TImpuestosTrasladados."',
	DescripcionConcepto = '".$DescripcionConcepto."'
	where
	`ultimo_id` = '".$ultimo_id."';  ";

	$var4 = "INSERT INTO `02XML` (
	`id`, `Version`, `fechaTimbrado`, `tipoDeComprobante`, 
	`metodoDePago`, `formaDePago`, `condicionesDePago`, `subTotal`, 
	`TipoCambio`, `Moneda`, `totalf`, `serie`, 
	`folio`, `LugarExpedicion`, `rfcE`, `nombreE`, 
	`regimenE`, `rfcR`, `nombreR`, `UsoCFDI`, 
	`DomicilioFiscalReceptor`, `RegimenFiscalReceptor`, `UUID`, `TImpuestosRetenidos`, 
	`TImpuestosTrasladados`, `idRelacion`, `ultimo_id`, `TuaTotalCargos`,Descuento, `TUA`, `Propina`, DescripcionConcepto) VALUES (
	'', 'no', '".$FechaTimbrado."', '".$tipoDeComprobante."', 
	'".$metodoDePago."', '".$formaDePago."', '".$condicionesDePago."', '".$subTotal."', 
	'".$TipoCambio."', '".$Moneda."', '".$total."', '".$serie."', 
	'".$folio."', '".$LugarExpedicion."', '".$rfcE."', '".$nombreE."', 
	'".$regimenE."', '".$rfcR."', '".$nombreR."', '".$UsoCFDI."', 
	'".$DomicilioFiscalReceptor."', '".$RegimenFiscalReceptor."', '".$UUID."', '".$TImpuestosRetenidos."', 
	'".$TImpuestosTrasladados."', '".$session."', '".$ultimo_id."', '".$TuaTotalCargos."', '".$Descuento."', '".$TUA."', '".$Propina."', 
	'".$DescripcionConcepto."'
	);  ";

$row = $this->busca_02XML($ultimo_id);
if($actualiza=='true'){
if($row['ultimo_id']==0 or $row['ultimo_id']==''){
	mysqli_query($conn,$var4) or die('P350'.mysqli_error($conn));
}else{
	mysqli_query($conn,$var3) or die('P352'.mysqli_error($conn));
}
}
		
	}

   	public function guardarxmlDB($ultimo_id,$conn){
	$conexion2 = new herramientas();
	$regreso = $this->variable_SUBETUFACTURA();
	$url = __ROOT3__.'/includes/archivos/'.$regreso['ADJUNTAR_FACTURA_XML'];

	$session = isset($_SESSION['idPROV'])?$_SESSION['idPROV']:'';    

	$conexion2->guardar_db_xml($url,$session,$ultimo_id,$conn);
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

		$this->actualizar_forma_pago($ultimo_id, $formaDePago);

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
		`TuaTotalCargos` = '".$TuaTotalCargos."',
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

			$row = $this->busca_07XML2($ultimo_id,$tabla);
				if($row['ultimo_id']==0 or $row['ultimo_id']==''){
					mysqli_query($conn,$var4) or die('P350'.mysqli_error($conn));
					echo "Ingresado";					
				}else{
					mysqli_query($conn,$var3) or die('P352'.mysqli_error($conn));
					echo "Actualizado";
				}
		}
	}	

	public function actualizar_forma_pago($id, $formaDePago){
		if($id == '' || $formaDePago == ''){
			return false;
		}

		$conn = $this->db();
		$var1 = "update 02SUBETUFACTURA set PFORMADE_PAGO = '".$formaDePago."' where id = '".$id."' ";
		return mysqli_query($conn,$var1);
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

        public function verificar_usuario_comercial($conn,$nommbrerazon){
                $queryrfc = "SELECT * FROM 02direccionproveedor1 WHERE P_NOMBRE_COMERCIAL_EMPRESA = '".$nommbrerazon."' ";
                $arrayquery = mysqli_query($conn,$queryrfc);
                $row = mysqli_fetch_array($arrayquery, MYSQLI_ASSOC);
                return $row['id'];
        }
	public function ingresar_usuario($conn,$nommbrerazon){
		 $queryrfc = "insert into 02direccionproveedor1 (P_NOMBRE_FISCAL_RS_EMPRESA) values ('".$nommbrerazon."'); ";
		$arrayquery = mysqli_query($conn,$queryrfc) or die('P160'.mysqli_error($conn));
		RETURN $idwebc = mysqli_insert_id($conn);
	}
	

	public function ingresar_rfc($conn,$RFC_PROVEEDOR,$nommbrerazon){
		 $queryrfc = "UPDATE 02direccionproveedor1
		SET P_RFC_MTDP = '".$RFC_PROVEEDOR."', idRelacion = '".$nommbrerazon."' WHERE id = '".$nommbrerazon."' ";
		$arrayquery = mysqli_query($conn,$queryrfc);
		return $row = mysqli_fetch_array($arrayquery, MYSQLI_ASSOC);
	}

	
	public function PAGOPRO ($NUMERO_CONSECUTIVO_PROVEE , $ID_RELACIONADO,$NOMBRE_COMERCIAL , $RAZON_SOCIAL ,$VIATICOSOPRO, $RFC_PROVEEDOR , $NUMERO_EVENTO ,$NOMBRE_EVENTO, $MOTIVO_GASTO , $CONCEPTO_PROVEE , $MONTO_TOTAL_COTIZACION_ADEUDO , $MONTO_DEPOSITAR , $MONTO_PROPINA ,$PENDIENTE_PAGO, $FECHA_AUTORIZACION_RESPONSABLE , $FECHA_AUTORIZACION_AUDITORIA , $FECHA_DE_LLENADO , $MONTO_FACTURA , $TIPO_DE_MONEDA , $PFORMADE_PAGO,$FECHA_DE_PAGO , $FECHA_A_DEPOSITAR , $STATUS_DE_PAGO ,$ACTIVO_FIJO, $GASTO_FIJO,$PAGAR_CADA,$FECHA_PPAGO,$FECHA_TPROGRAPAGO,$NUMERO_EVENTOFIJO,$CLASI_GENERAL,$SUB_GENERAL,$BANCO_ORIGEN , $MONTO_DEPOSITADO , $CLASIFICACION_GENERAL , $CLASIFICACION_ESPECIFICA , $PLACAS_VEHICULO , $MONTO_DE_COMISION , $POLIZA_NUMERO , $NOMBRE_DEL_EJECUTIVO ,$NOMBRE_DEL_AYUDO, $OBSERVACIONES_1 , $TIPO_CAMBIOP,  $TOTAL_ENPESOS,$IMPUESTO_HOSPEDAJE,$TImpuestosRetenidosIVA,$TImpuestosRetenidosISR,$descuentos,$IVA, $ENVIARPAGOprovee,$hiddenpagoproveedores,$IPpagoprovee,
	$FechaTimbrado, $tipoDeComprobante, 
		$metodoDePago, $formaDePago, $condicionesDePago, $subTotal, 
		$TipoCambio, $Moneda, $total, $serie, 
		$folio, $LugarExpedicion, $rfcE, $nombreE, 
		$regimenE, $rfcR, $nombreR, $UsoCFDI, 
		$DomicilioFiscalReceptor, $RegimenFiscalReceptor, $UUID, $TImpuestosRetenidos, 
		$TImpuestosTrasladados, $TuaTotalCargos, $Descuento,$Propina, $TUA, $actualiza,  $DescripcionConcepto
	)
	{
		$MONTO_TOTAL_COTIZACION_ADEUDO = str_replace(',','',$MONTO_TOTAL_COTIZACION_ADEUDO);
		$MONTO_DEPOSITAR = str_replace(',','',$MONTO_DEPOSITAR);
		$MONTO_FACTURA = str_replace(',','',$MONTO_FACTURA);		
		$MONTO_PROPINA = str_replace(',','',$MONTO_PROPINA);
		$MONTO_DEPOSITADO = str_replace(',','',$MONTO_DEPOSITADO);
		$MONTO_DE_COMISION = str_replace(',','',$MONTO_DE_COMISION);
		$PENDIENTE_PAGO = str_replace(',','',$PENDIENTE_PAGO);		
		$TOTAL_ENPESOS = str_replace(',','',$TOTAL_ENPESOS);		
		$TIPO_CAMBIOP = str_replace(',','',$TIPO_CAMBIOP);		
		$TImpuestosRetenidosIVA = str_replace(',','',$TImpuestosRetenidosIVA);		
		$TImpuestosRetenidosISR = str_replace(',','',$TImpuestosRetenidosISR);		
		$descuentos = str_replace(',','',$descuentos);		
		$IVA = str_replace(',','',$IVA);		
		$conn = $this->db();
		$NOMBRE_COMERCIALvar = "SELECT * FROM `02direccionproveedor1` where idRelacion = '".$NOMBRE_COMERCIAL."' ";
		$query_NOMBRE_COMERCIAL = mysqli_query($conn,$NOMBRE_COMERCIALvar) or die('P160'.mysqli_error($conn));
		$row_NOMBRE_COMERCIAL = mysqli_fetch_array($query_NOMBRE_COMERCIAL, MYSQLI_ASSOC);
		$NOMBRE_COMERCIAL2 = $row_NOMBRE_COMERCIAL['P_NOMBRE_COMERCIAL_EMPRESA'];
                                                                      
		if( $this->verificar_rfc($conn,$RFC_PROVEEDOR)!=''){
			$session = $this->verificar_rfc($conn,$RFC_PROVEEDOR);
		}elseif($this->verificar_usuario_comercial($conn,$NOMBRE_COMERCIAL2)!=''){
			$session = $this->verificar_usuario_comercial($conn,$NOMBRE_COMERCIAL2);		
		}else{$session = 1;}
		
		$existe = $this->revisar_pagoproveedor2($IPpagoprovee);		

		$idRelacionU = isset($_SESSION['idempermiso'])?$_SESSION['idempermiso']:'';

		$idem = isset($_SESSION['idem'])?$_SESSION['idem']:'';
		$usuarioBitacora = $this->nombre_usuario_bitacora();

		if($idem != ''){
		$var1 = "update 02SUBETUFACTURA set                    
		NUMERO_CONSECUTIVO_PROVEE = '".$NUMERO_CONSECUTIVO_PROVEE."' , ID_RELACIONADO = '".$ID_RELACIONADO."' , NOMBRE_COMERCIAL = '".$NOMBRE_COMERCIAL."' , RAZON_SOCIAL = '".$RAZON_SOCIAL."' , VIATICOSOPRO = '".$VIATICOSOPRO."' , RFC_PROVEEDOR = '".$RFC_PROVEEDOR."' , NUMERO_EVENTO = '".$NUMERO_EVENTO."' , NOMBRE_EVENTO = '".$NOMBRE_EVENTO."' , MOTIVO_GASTO = '".$MOTIVO_GASTO."' , CONCEPTO_PROVEE = '".$CONCEPTO_PROVEE."' , MONTO_TOTAL_COTIZACION_ADEUDO = '".$MONTO_TOTAL_COTIZACION_ADEUDO."' , MONTO_DEPOSITAR = '".$MONTO_DEPOSITAR."' , MONTO_PROPINA = '".$MONTO_PROPINA."' ,
		PENDIENTE_PAGO = '".$PENDIENTE_PAGO."' ,
		FECHA_AUTORIZACION_RESPONSABLE = '".$FECHA_AUTORIZACION_RESPONSABLE."' , FECHA_AUTORIZACION_AUDITORIA = '".$FECHA_AUTORIZACION_AUDITORIA."' ,FECHA_DE_LLENADO = '".$FECHA_DE_LLENADO."' , MONTO_FACTURA = '".$MONTO_FACTURA."' , TIPO_DE_MONEDA = '".$TIPO_DE_MONEDA."' , PFORMADE_PAGO = '".$PFORMADE_PAGO."' , FECHA_DE_PAGO = '".$FECHA_DE_PAGO."' , FECHA_A_DEPOSITAR = '".$FECHA_A_DEPOSITAR."' , STATUS_DE_PAGO = '".$STATUS_DE_PAGO."' , ACTIVO_FIJO = '".$ACTIVO_FIJO."' , GASTO_FIJO = '".$GASTO_FIJO."' , PAGAR_CADA = '".$PAGAR_CADA."' , FECHA_PPAGO = '".$FECHA_PPAGO."' , FECHA_TPROGRAPAGO = '".$FECHA_TPROGRAPAGO."' , NUMERO_EVENTOFIJO = '".$NUMERO_EVENTOFIJO."' , CLASI_GENERAL = '".$CLASI_GENERAL."' , SUB_GENERAL = '".$SUB_GENERAL."' , BANCO_ORIGEN = '".$BANCO_ORIGEN."' , MONTO_DEPOSITADO = '".$MONTO_DEPOSITADO."' , CLASIFICACION_GENERAL = '".$CLASIFICACION_GENERAL."' , CLASIFICACION_ESPECIFICA = '".$CLASIFICACION_ESPECIFICA."' , PLACAS_VEHICULO = '".$PLACAS_VEHICULO."' , MONTO_DE_COMISION = '".$MONTO_DE_COMISION."' , POLIZA_NUMERO = '".$POLIZA_NUMERO."' , NOMBRE_DEL_EJECUTIVO = '".$NOMBRE_DEL_EJECUTIVO."' , NOMBRE_DEL_AYUDO = '".$NOMBRE_DEL_AYUDO."' , OBSERVACIONES_1 = '".$OBSERVACIONES_1."' , TIPO_CAMBIOP = '".$TIPO_CAMBIOP."' , TOTAL_ENPESOS = '".$TOTAL_ENPESOS."' , IMPUESTO_HOSPEDAJE = '".$IMPUESTO_HOSPEDAJE."' , TImpuestosRetenidosIVA = '".$TImpuestosRetenidosIVA."' , TImpuestosRetenidosISR = '".$TImpuestosRetenidosISR."' , descuentos = '".$descuentos."' , IVA = '".$IVA."', idRelacionU  = '".$idRelacionU."' where id = '".$IPpagoprovee."' ; ";
		
		
		$var2 = "insert into 02SUBETUFACTURA ( 
		NUMERO_CONSECUTIVO_PROVEE, 
		ID_RELACIONADO, 
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
		ACTIVO_FIJO,
		GASTO_FIJO,
		PAGAR_CADA,
		FECHA_PPAGO,
		FECHA_TPROGRAPAGO,
		NUMERO_EVENTOFIJO,
		CLASI_GENERAL,
		SUB_GENERAL,		
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
		PENDIENTE_PAGO,
		hiddenpagoproveedores, 
		idRelacion,
		idRelacionU) values ( 
		'".$NUMERO_CONSECUTIVO_PROVEE."' , 
		'".$ID_RELACIONADO."' , 
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
		'".$ACTIVO_FIJO."' , 
		'".$GASTO_FIJO."' , 
		'".$PAGAR_CADA."' , 
		'".$FECHA_PPAGO."' , 
		'".$FECHA_TPROGRAPAGO."' , 
		'".$NUMERO_EVENTOFIJO."' , 
		'".$CLASI_GENERAL."' , 
		'".$SUB_GENERAL."' , 		
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
		'".$PENDIENTE_PAGO."',
		'".$hiddenpagoproveedores."' ,
		'".$session."',
		'".$idRelacionU."'
		);  ";			

		if($ENVIARPAGOprovee=='ENVIARPAGOprovee'){
			
		$this->ActualizaxmlDB($FechaTimbrado, $tipoDeComprobante, 
		$metodoDePago, $formaDePago, $condicionesDePago, $subTotal, 
		$TipoCambio, $Moneda, $total, $serie, 
		$folio, $LugarExpedicion, $rfcE, $nombreE, 
		$regimenE, $rfcR, $nombreR, $UsoCFDI, 
		$DomicilioFiscalReceptor, $RegimenFiscalReceptor, $UUID, $TImpuestosRetenidos, 
		$TImpuestosTrasladados, $session, $existe, $TuaTotalCargos, $TUA, $Descuento, $Propina, $conn, $actualiza, $DescripcionConcepto);

		$consultaAnterior = mysqli_query($conn,
			"SELECT 
				STATUS_DE_PAGO, MONTO_DEPOSITAR, FECHA_DE_PAGO, FECHA_A_DEPOSITAR, PFORMADE_PAGO,
				NUMERO_EVENTO, NOMBRE_EVENTO, NOMBRE_COMERCIAL, RAZON_SOCIAL, RFC_PROVEEDOR,
				MOTIVO_GASTO, CONCEPTO_PROVEE, MONTO_TOTAL_COTIZACION_ADEUDO, MONTO_FACTURA,
				MONTO_PROPINA, TIPO_DE_MONEDA, BANCO_ORIGEN, MONTO_DEPOSITADO,
				CLASIFICACION_GENERAL, CLASIFICACION_ESPECIFICA, MONTO_DE_COMISION,
				POLIZA_NUMERO, NOMBRE_DEL_EJECUTIVO, NOMBRE_DEL_AYUDO, OBSERVACIONES_1,
				TIPO_CAMBIOP, TOTAL_ENPESOS, IMPUESTO_HOSPEDAJE,
				TImpuestosRetenidosIVA, TImpuestosRetenidosISR, descuentos, IVA,
				ACTIVO_FIJO, GASTO_FIJO, VIATICOSOPRO
			FROM 02SUBETUFACTURA
			WHERE id = '".intval($IPpagoprovee)."' LIMIT 1"
		);
		$registroAnterior = $consultaAnterior ? mysqli_fetch_array($consultaAnterior, MYSQLI_ASSOC) : array();

		mysqli_query($conn,$var1) or die('P156'.mysqli_error($conn));

		$mapaComparacion = array(
			'STATUS_DE_PAGO'                => $STATUS_DE_PAGO,
			'MONTO_DEPOSITAR'               => $MONTO_DEPOSITAR,
			'FECHA_DE_PAGO'                 => $FECHA_DE_PAGO,
			'FECHA_A_DEPOSITAR'             => $FECHA_A_DEPOSITAR,
			'PFORMADE_PAGO'                 => $PFORMADE_PAGO,
			'NUMERO_EVENTO'                 => $NUMERO_EVENTO,
			'NOMBRE_EVENTO'                 => $NOMBRE_EVENTO,
			'NOMBRE_COMERCIAL'              => $NOMBRE_COMERCIAL,
			'RAZON_SOCIAL'                  => $RAZON_SOCIAL,
			'RFC_PROVEEDOR'                 => $RFC_PROVEEDOR,
			'MOTIVO_GASTO'                  => $MOTIVO_GASTO,
			'CONCEPTO_PROVEE'               => $CONCEPTO_PROVEE,
			'MONTO_TOTAL_COTIZACION_ADEUDO' => $MONTO_TOTAL_COTIZACION_ADEUDO,
			'MONTO_FACTURA'                 => $MONTO_FACTURA,
			'MONTO_PROPINA'                 => $MONTO_PROPINA,
			'TIPO_DE_MONEDA'                => $TIPO_DE_MONEDA,
			'BANCO_ORIGEN'                  => $BANCO_ORIGEN,
			'MONTO_DEPOSITADO'              => $MONTO_DEPOSITADO,
			'CLASIFICACION_GENERAL'         => $CLASIFICACION_GENERAL,
			'CLASIFICACION_ESPECIFICA'      => $CLASIFICACION_ESPECIFICA,
			'MONTO_DE_COMISION'             => $MONTO_DE_COMISION,
			'POLIZA_NUMERO'                 => $POLIZA_NUMERO,
			'NOMBRE_DEL_EJECUTIVO'          => $NOMBRE_DEL_EJECUTIVO,
			'NOMBRE_DEL_AYUDO'              => $NOMBRE_DEL_AYUDO,
			'OBSERVACIONES_1'               => $OBSERVACIONES_1,
			'TIPO_CAMBIOP'                  => $TIPO_CAMBIOP,
			'TOTAL_ENPESOS'                 => $TOTAL_ENPESOS,
			'IMPUESTO_HOSPEDAJE'            => $IMPUESTO_HOSPEDAJE,
			'TImpuestosRetenidosIVA'        => $TImpuestosRetenidosIVA,
			'TImpuestosRetenidosISR'        => $TImpuestosRetenidosISR,
			'descuentos'                    => $descuentos,
			'IVA'                           => $IVA,
			'ACTIVO_FIJO'                   => $ACTIVO_FIJO,
			'GASTO_FIJO'                    => $GASTO_FIJO,
			'VIATICOSOPRO'                  => $VIATICOSOPRO,
		);

		$cambiosDetectados = array();
		foreach($mapaComparacion as $campo => $valorNuevo){
			$valorViejo = isset($registroAnterior[$campo]) ? $registroAnterior[$campo] : '';
			$viejoNorm = trim((string)$valorViejo);
			$nuevoNorm = trim((string)$valorNuevo);
			if($viejoNorm !== $nuevoNorm && !($viejoNorm === '' && $nuevoNorm === '0')){
				$etiqueta = $this->etiqueta_bitacora_campo($campo);
				$cambiosDetectados[] = $etiqueta.': "'.$viejoNorm.'" → "'.$nuevoNorm.'"';
			}
		}

		if(count($cambiosDetectados) > 0){
			$detalleActualizacion = 'Se actualizó.  Cambios detectados: '.implode(' | ', $cambiosDetectados).'.';
		} else {
			$detalleActualizacion = 'Se guardó  sin cambios detectados en los campos monitoreados.';
		}

		$this->registrar_bitacora(
			$conn,
			$IPpagoprovee,
			'ACTUALIZACION',
			$detalleActualizacion,
			'',
			$usuarioBitacora
		);
		return "Actualizado";
		}
		ELSE{
		mysqli_query($conn,$var2) or die('P160'.mysqli_error($conn));
		$ultimo_id ='';	
		$ultimo_id = mysqli_insert_id($conn);
		$this->registrar_bitacora(
			$conn,
			$ultimo_id,
			'INGRESO',
			'Registro ingresado desde el módulo PAGO A PROVEEDORES.',
			$usuarioBitacora,
			''
		);
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


	public function ACTUALIZA_RESPONSABLE_EVENTO (
	$RESPONSABLE_EVENTO_id , $RESPONSABLE_text ){
	
		$conn = $this->db();
		$session = isset($_SESSION['idem'])?$_SESSION['idem']:'';    
		if($session != ''){
		
		$valorAnterior = $this->valor_actual_campo_subetufactura($conn, $RESPONSABLE_EVENTO_id, 'STATUS_RESPONSABLE_EVENTO');
		$var1 = "update 02SUBETUFACTURA SET STATUS_RESPONSABLE_EVENTO = '".$RESPONSABLE_text."' WHERE id = '".$RESPONSABLE_EVENTO_id."'  ";	
	
		
		mysqli_query($conn,$var1) or die('P156'.mysqli_error($conn));
		$this->registrar_cambio_estado_detallado($conn, $RESPONSABLE_EVENTO_id, 'STATUS_RESPONSABLE_EVENTO', $valorAnterior, $RESPONSABLE_text);
		return "Actualizado^".$RESPONSABLE_text;
	
			
        }else{
		echo "NO HAY UN PROVEEDOR SELECCIONADO";	
		}
    }


	public function borrar_xmls($ruta,$id,$nombrearchivo,$tabla1,$tabla2){ 
		$conn = $this->db();
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
	
	public function PASARPAGADOACTUALIZAR (
	$pasarpagado_id , $pasarpagado_text ){
	
		$conn = $this->db();
		$session = isset($_SESSION['idem'])?$_SESSION['idem']:'';    
		if($session != ''){
			if($pasarpagado_text=='si'){
				$STATUS_DE_PAGO = 'PAGADO';
			}else{
				$STATUS_DE_PAGO = 'SOLICITADO';				
			}
		$valorAnterior = $this->valor_actual_campo_subetufactura($conn, $pasarpagado_id, 'STATUS_DE_PAGO');
		$var1 = "update 02SUBETUFACTURA SET STATUS_DE_PAGO = '".$STATUS_DE_PAGO."' WHERE id = '".$pasarpagado_id."'  ";	
	
		mysqli_query($conn,$var1) or die('P156'.mysqli_error($conn));
		$this->registrar_cambio_estado_detallado($conn, $AUDITORIA1_id, 'STATUS_DE_PAGO', $valorAnterior, $STATUS_DE_PAGO, 'Cambio realizado por FINANZAS Y TESORERÍA.');
		return "Actualizado";
			
        }else{
		echo "NO HAY UN PROVEEDOR SELECCIONADO";	
		}
    }

	public function ACTUALIZA_AUDITORIA3 (
	$AUDITORIA3_id , $AUDITORIA3_text ){
	
		$conn = $this->db();
		$session = isset($_SESSION['idem'])?$_SESSION['idem']:'';    
		if($session != ''){
		$valorAnterior = $this->valor_actual_campo_subetufactura($conn, $AUDITORIA3_id, 'STATUS_AUDITORIA3');
		 $var1 = "update 02SUBETUFACTURA SET STATUS_AUDITORIA3 = '".$AUDITORIA3_text."' WHERE id = '".$AUDITORIA3_id."'  ";	
	
		mysqli_query($conn,$var1) or die('P156'.mysqli_error($conn));
		$this->registrar_cambio_estado_detallado($conn, $AUDITORIA3_id, 'STATUS_AUDITORIA3', $valorAnterior, $AUDITORIA3_text);
		return "Actualizado^".$AUDITORIA3_text;
			
        }else{
		echo "NO HAY UN PROVEEDOR SELECCIONADO";	
		}
    }
	
	
	
public function ACTUALIZA_RECHAZADO($idcomprobacion, $estatusRechazado){

    $conn = $this->db();
    $session = isset($_SESSION['idem'])?$_SESSION['idem']:'';

    if($session != ''){

        $valorAnteriorRechazado  = $this->valor_actual_campo_subetufactura($conn, $idcomprobacion, 'STATUS_RECHAZADO');
        $valorAnteriorStatusPago = $this->valor_actual_campo_subetufactura($conn, $idcomprobacion, 'STATUS_DE_PAGO');

        $camposActualizar = "STATUS_RECHAZADO = '".$estatusRechazado."'";
        if($estatusRechazado === 'si'){
            $camposActualizar .= ", STATUS_DE_PAGO = 'RECHAZADO'";
            $nuevoStatusPago = 'RECHAZADO';
        } elseif($estatusRechazado === 'no'){
            $camposActualizar .= ", STATUS_DE_PAGO = 'SOLICITADO'";
            $nuevoStatusPago = 'SOLICITADO';
        }

        $var1 = "update 02SUBETUFACTURA SET ".$camposActualizar." WHERE id = '".$idcomprobacion."'";
        mysqli_query($conn,$var1) or die('P156'.mysqli_error($conn));

        $this->registrar_cambio_estado_detallado($conn, $idcomprobacion, 'STATUS_RECHAZADO', $valorAnteriorRechazado, $estatusRechazado);

        if(isset($nuevoStatusPago) && $valorAnteriorStatusPago !== $nuevoStatusPago){
            $this->registrar_cambio_estado_detallado($conn, $idcomprobacion, 'STATUS_DE_PAGO', $valorAnteriorStatusPago, $nuevoStatusPago);
        }

        return "Actualizado^".$estatusRechazado;

    }else{
		echo "NO HAY UN PROVEEDOR SELECCIONADO";
    }
}



	private function crear_tabla_rechazos_si_no_existe($conn){
		$crearTabla = "CREATE TABLE IF NOT EXISTS `02SUBETUFACTURA_RECHAZOS` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`id_subetufactura` int(11) NOT NULL,
			`motivo_rechazo` text,
			`usuario_registro` varchar(255) DEFAULT NULL,
			`fecha_registro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (`id`),
			UNIQUE KEY `uniq_subetufactura` (`id_subetufactura`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
		mysqli_query($conn, $crearTabla);
	}

	public function guardar_motivo_rechazo($idcomprobacion, $motivoRechazo){
		$conn = $this->db();
		$session = isset($_SESSION['idem'])?$_SESSION['idem']:'';
		if($session == ''){
			return "Sesion_invalida";
		}

		$idcomprobacion = intval($idcomprobacion);
		$motivoRechazo = trim($motivoRechazo);
		if($idcomprobacion <= 0 || $motivoRechazo == ''){
			return "Datos_invalidos";
		}

		$this->crear_tabla_rechazos_si_no_existe($conn);
		$motivoEscapado = mysqli_real_escape_string($conn, $motivoRechazo);
		$usuario = mysqli_real_escape_string($conn, $this->nombre_usuario_bitacora());

		$insert = "INSERT INTO 02SUBETUFACTURA_RECHAZOS (id_subetufactura, motivo_rechazo, usuario_registro, fecha_registro)
		VALUES ('".$idcomprobacion."', '".$motivoEscapado."', '".$usuario."', NOW())
		ON DUPLICATE KEY UPDATE motivo_rechazo = VALUES(motivo_rechazo), usuario_registro = VALUES(usuario_registro), fecha_registro = NOW()";
		mysqli_query($conn, $insert) or die('P156'.mysqli_error($conn));

		$this->registrar_bitacora($conn, $idcomprobacion, 'RECHAZO', 'Se registró motivo de rechazo: "'.$motivoRechazo.'".', '', $this->nombre_usuario_bitacora());
		return "ok";
	}

	public function obtener_motivo_rechazo($idcomprobacion){
		$conn = $this->db();
		$idcomprobacion = intval($idcomprobacion);
		if($idcomprobacion <= 0){
			return '';
		}

		$this->crear_tabla_rechazos_si_no_existe($conn);
		$query = mysqli_query($conn, "SELECT motivo_rechazo FROM 02SUBETUFACTURA_RECHAZOS WHERE id_subetufactura = '".$idcomprobacion."' LIMIT 1");
		if($query){
			$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
			if($row && isset($row['motivo_rechazo'])){
				return $row['motivo_rechazo'];
			}
		}
		return '';
	}


	public function ACTUALIZA_SINXML (
	    $SINXML_id , $SINXML_text ){
	
		$conn = $this->db();
		$session = isset($_SESSION['idem'])?$_SESSION['idem']:'';    
		if($session != ''){
		$valorAnterior = $this->valor_actual_campo_subetufactura($conn, $SINXML_id, 'STATUS_SINXML');
		 $var1 = "update 02SUBETUFACTURA SET STATUS_SINXML = '".$SINXML_text."' WHERE id = '".$SINXML_id."'  ";	
	
		mysqli_query($conn,$var1) or die('P156'.mysqli_error($conn));
		$this->registrar_cambio_estado_detallado($conn, $SINXML_id, 'STATUS_SINXML', $valorAnterior, $SINXML_text);
		return "Actualizado^".$SINXML_text;
			
        }else{
		echo "NO HAY UN PROVEEDOR SELECCIONADO";	
		}
    }

	public function ACTUALIZA_AUDITORIA1 (
	$AUDITORIA1_id , $AUDITORIA1_text ){
	
		$conn = $this->db();
		$session = isset($_SESSION['idem'])?$_SESSION['idem']:'';    
		if($session != ''){
			if($AUDITORIA1_text=='si'){
				$STATUS_DE_PAGO = 'APROBADO';
			}else{
				$STATUS_DE_PAGO = 'SOLICITADO';				
			}
		$valorAnterior = $this->valor_actual_campo_subetufactura($conn, $AUDITORIA1_id, 'STATUS_DE_PAGO');
		$var1 = "update 02SUBETUFACTURA SET STATUS_DE_PAGO = '".$STATUS_DE_PAGO."' WHERE id = '".$AUDITORIA1_id."'  ";	
	
		mysqli_query($conn,$var1) or die('P156'.mysqli_error($conn));
		$this->registrar_cambio_estado_detallado($conn, $AUDITORIA1_id, 'STATUS_DE_PAGO', $valorAnterior, $STATUS_DE_PAGO, 'Cambio realizado por CUENTAS POR PAGAR.');
		return "Actualizado";
			
        }else{
		echo "NO HAY UN PROVEEDOR SELECCIONADO";	
		}
    }


	public function ACTUALIZA_CHECKBOX (
	    $CHECKBOX_id , $CHECKBOX_text ){
	
		$conn = $this->db();
		$session = isset($_SESSION['idem'])?$_SESSION['idem']:'';    
		if($session != ''){

		$valorAnterior = $this->valor_actual_campo_subetufactura($conn, $CHECKBOX_id, 'STATUS_CHECKBOX');
		$var1 = "update 02SUBETUFACTURA SET STATUS_CHECKBOX = '".$CHECKBOX_text."' WHERE id = '".$CHECKBOX_id."'  ";	
	
		mysqli_query($conn,$var1) or die('P156'.mysqli_error($conn));
		$this->registrar_cambio_estado_detallado($conn, $CHECKBOX_id, 'STATUS_CHECKBOX', $valorAnterior, $CHECKBOX_text);
		return "Actualizado";
			
        }else{
		echo "NO HAY UN PROVEEDOR SELECCIONADO";	
		}
    }

	public function ACTUALIZA_AUDITORIA2 (
	$RESPONSABLE_EVENTO_id , $RESPONSABLE_text ){
	
		$conn = $this->db();
		$session = isset($_SESSION['idem'])?$_SESSION['idem']:'';    
		if($session != ''){
		$valorAnterior = $this->valor_actual_campo_subetufactura($conn, $RESPONSABLE_EVENTO_id, 'STATUS_AUDITORIA2');
		 $var1 = "update 02SUBETUFACTURA SET STATUS_AUDITORIA2 = '".$RESPONSABLE_text."' WHERE id = '".$RESPONSABLE_EVENTO_id."'  ";	
	
		mysqli_query($conn,$var1) or die('P156'.mysqli_error($conn));
		$this->registrar_cambio_estado_detallado($conn, $RESPONSABLE_EVENTO_id, 'STATUS_AUDITORIA2', $valorAnterior, $RESPONSABLE_text);
		return "Actualizado^".$RESPONSABLE_text;
			
        }else{
		echo "NO HAY UN PROVEEDOR SELECCIONADO";	
		}
    }

	public function ACTUALIZA_FINANZAS (
	$RESPONSABLE_EVENTO_id , $RESPONSABLE_text ){
	
		$conn = $this->db();
		$session = isset($_SESSION['idem'])?$_SESSION['idem']:'';    
		if($session != ''){
		$valorAnterior = $this->valor_actual_campo_subetufactura($conn, $RESPONSABLE_EVENTO_id, 'STATUS_FINANZAS');
		 $var1 = "update 02SUBETUFACTURA SET STATUS_FINANZAS = '".$RESPONSABLE_text."' WHERE id = '".$RESPONSABLE_EVENTO_id."'  ";	
	
		mysqli_query($conn,$var1) or die('P156'.mysqli_error($conn));
		$this->registrar_cambio_estado_detallado($conn, $RESPONSABLE_EVENTO_id, 'STATUS_FINANZAS', $valorAnterior, $RESPONSABLE_text);
		return "Actualizado^".$RESPONSABLE_text;
			
        }else{
		echo "NO HAY UN PROVEEDOR SELECCIONADO";	
		}
    }

	public function ACTUALIZA_VENTAS (
	$RESPONSABLE_EVENTO_id , $RESPONSABLE_text ){
	
		$conn = $this->db();
		$session = isset($_SESSION['idem'])?$_SESSION['idem']:'';    
		if($session != ''){
		$valorAnterior = $this->valor_actual_campo_subetufactura($conn, $RESPONSABLE_EVENTO_id, 'STATUS_VENTAS');
		 $var1 = "update 02SUBETUFACTURA SET STATUS_VENTAS = '".$RESPONSABLE_text."' WHERE id = '".$RESPONSABLE_EVENTO_id."'  ";	
	
		mysqli_query($conn,$var1) or die('P156'.mysqli_error($conn));
		$this->registrar_cambio_estado_detallado($conn, $RESPONSABLE_EVENTO_id, 'STATUS_VENTAS', $valorAnterior, $RESPONSABLE_text);
		return "Actualizado^".$RESPONSABLE_text;
			
        }else{
		echo "NO HAY UN PROVEEDOR SELECCIONADO";	
		}
    }


	public function borrapagoaproveedores($id){ 
		$conn = $this->db();
		$var1 = "DELETE FROM 02SUBETUFACTURA where id = '".$id."' "; 
		mysqli_query($conn,$var1) or die('P44'.mysqli_error($conn));
		
		$var2 = "DELETE FROM `02XML` WHERE `ultimo_id` = '".$id."' ";
		mysqli_query($conn,$var2) or die('P44'.mysqli_error($conn));
		
		$var3 = "DELETE FROM `02SUBETUFACTURADOCTOS` WHERE `idTemporal` = '".$id."' ";
		mysqli_query($conn,$var3) or die('P44'.mysqli_error($conn));
		ECHO "ELEMENTO BORRADO";
	}

    public function select_02XML(){
    $conn = $this->db(); 
    $variablequery = "select id from 02XML order by id desc "; 
    $arrayquery = mysqli_query($conn,$variablequery);
    $row = mysqli_fetch_array($arrayquery, MYSQLI_ASSOC);
	return $row['id'];	
}

	// ── VALIDA02XMLUUID actualizado — igual que ventasoperaciones ─────────
	public function VALIDA02XMLUUID($uuid){
		$conn = $this->db();
		$variablequery = "select 02XML.id, 02XML.UUID, 02SUBETUFACTURA.NUMERO_CONSECUTIVO_PROVEE
		from 02XML
		left join 02SUBETUFACTURA on 02XML.ultimo_id = 02SUBETUFACTURA.id
		where 02XML.UUID = '".$uuid."' ";
		$arrayquery = mysqli_query($conn,$variablequery);
		$row = mysqli_fetch_array($arrayquery, MYSQLI_ASSOC);
		if($row['id'] == 0 || $row['id'] == ''){
			return 'S';
		} else {
			$numero = ($row['NUMERO_CONSECUTIVO_PROVEE'] != '') ? $row['NUMERO_CONSECUTIVO_PROVEE'] : $row['id'];
			return 'UUID_DUPLICADO:'.$numero;
		}
	}


public function Listado_pagoproveedor(){ $conn = $this->db(); $variablequery = "select * from 02SUBETUFACTURA where idRelacion = '".$_SESSION['idPROV']."' order by id desc "; return $arrayquery = mysqli_query($conn,$variablequery); } 

public function Listado_bitacora_pagoproveedor_array($idcomprobacion){
	$conn = $this->db();
	$idcomprobacion = intval($idcomprobacion);

	$crearTabla = "CREATE TABLE IF NOT EXISTS `02SUBETUFACTURA_BITACORA` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`id_subetufactura` int(11) NOT NULL DEFAULT 0,
		`tipo_movimiento` varchar(50) NOT NULL,
		`detalle` text,
		`fecha_hora` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
		`nombre_quien_ingreso` varchar(255) DEFAULT NULL,
		`nombre_quien_actualizo` varchar(255) DEFAULT NULL,
		PRIMARY KEY (`id`),
		KEY `idx_id_subetufactura` (`id_subetufactura`),
		KEY `idx_fecha_hora` (`fecha_hora`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
	mysqli_query($conn, $crearTabla);

$variablequery = "SELECT 
		b.tipo_movimiento,
		b.detalle,
		b.fecha_hora,
		b.nombre_quien_ingreso,
		b.nombre_quien_actualizo,
		s.NUMERO_CONSECUTIVO_PROVEE,
		s.VIATICOSOPRO
	FROM 02SUBETUFACTURA_BITACORA b
	LEFT JOIN 02SUBETUFACTURA s ON s.id = b.id_subetufactura
	WHERE b.id_subetufactura = '".$idcomprobacion."'
	ORDER BY b.id DESC";

	$arrayquery = mysqli_query($conn, $variablequery);
	$resultado = array();

	if($arrayquery){
		while($row = mysqli_fetch_array($arrayquery, MYSQLI_ASSOC)){
			if(isset($row['fecha_hora']) && $row['fecha_hora'] != ''){
				$fechaBitacora = DateTime::createFromFormat('Y-m-d H:i:s', $row['fecha_hora'], new DateTimeZone('UTC'));
				if($fechaBitacora){
					$fechaBitacora->setTimezone(new DateTimeZone('America/Mexico_City'));
					$row['fecha_hora'] = $fechaBitacora->format('d/m/Y H:i:s');
				}
			}
			$resultado[] = $row;
		}
	}

	return $resultado;
}


    public function Listado_pagoproveedor2($id){ 
	$conn = $this->db(); 
	$variablequery = "select * from 02SUBETUFACTURA where id = '".$id."' "; 
	return $arrayquery = mysqli_query($conn,$variablequery); 
	}

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

    public function Listado_subefacturaDOCTOS($ID){ $conn = $this->db(); $variablequery = "select * from 02SUBETUFACTURADOCTOS where idTemporal = '".$ID."'  order by id desc "; return $arrayquery = mysqli_query($conn,$variablequery); }

    public function Listado_subefacturadocto($ADJUNTAR_COTIZACION){ $conn = $this->db(); $variablequery = "select id,".$ADJUNTAR_COTIZACION.",fechaingreso from 02SUBETUFACTURADOCTOS where idRelacion = '".$_SESSION['idPROV']."' and idTemporal = 'si' and (".$ADJUNTAR_COTIZACION." is not null or ".$ADJUNTAR_COTIZACION." <> '') ORDER BY id DESC "; return $arrayquery = mysqli_query($conn,$variablequery); }
	
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
