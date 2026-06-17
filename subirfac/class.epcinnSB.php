<?php
/*
clase EPC INNOVA
CREADO : 10/mayo/2023
TESTER: FATIMA ARELLANO
PROGRAMER: SANDOR ACTUALIZACION: 1 MAY 2023
fecha sandor: 
fecha fatis : 07/04/2024
*/

define('__ROOT3__', dirname(dirname(__FILE__)));
require __ROOT3__."/includes/class.epcinn.php";


class accesoclase extends colaboradores{

	// ══════════════════════════════════════════════════════════════════════
	//  BITÁCORA
	// ══════════════════════════════════════════════════════════════════════

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

		$idcomprobacion    = intval($idcomprobacion);
		$tipoMovimiento    = mysqli_real_escape_string($conn, $tipoMovimiento);
		$detalle           = mysqli_real_escape_string($conn, $detalle);
		$nombreQuienIngreso    = mysqli_real_escape_string($conn, $nombreQuienIngreso);
		$nombreQuienActualizo  = mysqli_real_escape_string($conn, $nombreQuienActualizo);

		$insertBitacora = "INSERT INTO 02SUBETUFACTURA_BITACORA
		(id_subetufactura, tipo_movimiento, detalle, fecha_hora, nombre_quien_ingreso, nombre_quien_actualizo)
		VALUES
		('".$idcomprobacion."', '".$tipoMovimiento."', '".$detalle."', NOW(), '".$nombreQuienIngreso."', '".$nombreQuienActualizo."')";

		mysqli_query($conn, $insertBitacora);
	}

	/**
	 * Método público para registrar en bitácora desde acciones del módulo SB.
	 * Se usa en lectorxmlX, borra_sube_factura, documentofiscal, NOTAS,
	 * enviarDATOSBANCARIOS1rr, borra_datos_bancario1, borrasbdoc, etc.
	 *
	 * @param string $accion      Tipo de acción: 'crear', 'actualizar', 'eliminar', 'adjuntar'
	 * @param string $detalle     Descripción del movimiento
	 * @param mixed  $id         ID del registro afectado (puede ser numérico o 'si')
	 * @param string $tabla      Nombre de la tabla afectada (informativo)
	 */
	public function registrar_bitacora_sb($accion, $detalle, $id, $tabla = ''){
		$conn = $this->db();

		// Mapa de acciones a tipo_movimiento
		$mapaAcciones = array(
			'crear'      => 'INGRESO',
			'actualizar' => 'ACTUALIZACION',
			'eliminar'   => 'BAJA',
			'adjuntar'   => 'ADJUNTO',
		);

		$tipoMovimiento = isset($mapaAcciones[$accion]) ? $mapaAcciones[$accion] : strtoupper($accion);

		// Si el id no es numérico (ej. 'si'), usamos 0
		$idNum = is_numeric($id) ? intval($id) : 0;

		$usuario = $this->nombre_usuario_bitacora();

		// Para ingresos: indicar que vino desde Sube Tu Factura, sin mencionar tabla
		if($accion == 'crear'){
			$detalleCompleto = 'Registro ingresado desde el módulo SUBE TU FACTURA.';
			if($detalle != ''){
				$detalleCompleto .= ' '.$detalle;
			}
		}else{
			// Para otras acciones: usar el detalle tal cual, sin mencionar tabla
			$detalleCompleto = $detalle;
		}

		$this->registrar_bitacora($conn, $idNum, $tipoMovimiento, $detalleCompleto, '', $usuario);
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
			'MONTO_TOTAL_COTIZACION_ADEUDO' => 'MONTO TOTAL / COTIZACIÓN',
			'MONTO_PROPINA'                 => 'PROPINA',
			'MONTO_FACTURA'                 => 'MONTO DE FACTURA',
			'TIPO_DE_MONEDA'                => 'TIPO DE MONEDA',
			'BANCO_ORIGEN'                  => 'BANCO ORIGEN',
			'MONTO_DEPOSITADO'              => 'MONTO DEPOSITADO',
			'CLASIFICACION_GENERAL'         => 'CLASIFICACIÓN GENERAL',
			'CLASIFICACION_ESPECIFICA'      => 'CLASIFICACIÓN ESPECÍFICA',
			'MONTO_DE_COMISION'             => 'MONTO DE COMISIÓN',
			'POLIZA_NUMERO'                 => 'NÚMERO DE PÓLIZA',
			'NOMBRE_DEL_EJECUTIVO'          => 'NOMBRE DEL EJECUTIVO',
			'NOMBRE_DEL_AYUDO'              => 'NOMBRE DE QUIEN AYUDÓ',
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
			'VIATICOSOPRO'                  => 'VIÁTICOS / PRO',
		);

		return isset($etiquetas[$campo]) ? $etiquetas[$campo] : str_replace('_', ' ', $campo);
	}

	public function registrar_bitacora_adjuntos($idcomprobacion, $tipoAdjunto, $nombreArchivo){
		$conn = $this->db();
		$idcomprobacion = intval($idcomprobacion);
		if($idcomprobacion <= 0){ return; }

		$tipoAdjunto   = trim($tipoAdjunto);
		$nombreArchivo = trim($nombreArchivo);
		if($tipoAdjunto == ''){ return; }

		$detalle = 'Se subió archivo '.$tipoAdjunto;
		if($nombreArchivo != ''){ $detalle .= ': '.$nombreArchivo; }
		$detalle .= '.';

		$this->registrar_bitacora($conn, $idcomprobacion, 'ADJUNTO', $detalle, '', $this->nombre_usuario_bitacora());
	}

	// ══════════════════════════════════════════════════════════════════════
	//  HELPERS / BÚSQUEDAS
	// ══════════════════════════════════════════════════════════════════════

	public function var_altaeventos(){
		$conn = $this->db();
		$variablequery = "select * from 04altaeventos where id = '".$_SESSION['idevento']."' ";
		$arrayquery = mysqli_query($conn,$variablequery);
		return $row = mysqli_fetch_array($arrayquery, MYSQLI_ASSOC);
	}

	public function buscarNOMBRECOMERCIAL($filtro){
		$conn = $this->db();
		$variable = "select * from 02usuarios where nommbrerazon like '%".$filtro."%' limit 20 ";
		$variablequery = mysqli_query($conn,$variable);
		while($row2 = mysqli_fetch_array($variablequery, MYSQLI_ASSOC)){
			$resultado2[] = ['id'=>$row2['id'],'text'=>$row2['nommbrerazon']];
		}
		return $resultado2;
	}

	public function buscarrasonsocial($filtro){
		$conn = $this->db();
		$_SESSION['QUERYaaa'] = $variable = "select * from 02direccionproveedor1 where idRelacion = '".$filtro."' ";
		$variablequery = mysqli_query($conn,$variable);
		$row2 = mysqli_fetch_array($variablequery, MYSQLI_ASSOC);
		return $row2['P_NOMBRE_FISCAL_RS_EMPRESA'].'^^^'.$row2['P_RFC_MTDP'];
	}

	public function buscarnumero($filtro){
		$conn = $this->db();
		$variable = "select * from 04NUMEROevento where NUMERO_DE_EVENTO like '%".$filtro."%' ";
		$variablequery = mysqli_query($conn,$variable);
		while($row = mysqli_fetch_array($variablequery, MYSQLI_ASSOC)){
			$resultado[] = $row['NUMERO_DE_EVENTO'];
		}
		return $resultado;
	}

	public function listadoEventos(){
		$conn = $this->db();
		$variablequery = "select NUMERO_EVENTO, NOMBRE_EVENTO from 04altaeventos order by NUMERO_EVENTO";
		return mysqli_query($conn,$variablequery);
	}

	public function obtenerNombreEvento($NUMERO_EVENTO){
		$conn = $this->db();
		$sql = "SELECT NOMBRE_EVENTO FROM 04altaeventos WHERE NUMERO_EVENTO = '".mysqli_real_escape_string($conn,$NUMERO_EVENTO)."' LIMIT 1";
		$res = mysqli_query($conn,$sql);
		if($row = mysqli_fetch_array($res, MYSQLI_ASSOC)){
			return $row['NOMBRE_EVENTO'];
		}
		return '';
	}

	public function obtener_nombrecomercial($id){
		$conn = $this->db();
		$variable = "SELECT * FROM `02direccionproveedor1` where id = '".$id."' ";
		$variablequery = mysqli_query($conn,$variable);
		$row = mysqli_fetch_array($variablequery, MYSQLI_ASSOC);
		return $row['P_NOMBRE_COMERCIAL_EMPRESA'];
	}

	public function buscarNOMBRECOMERCIAL22($rfc){
		$conn = $this->db();
		$variable = "select *,02direccionproveedor1.idRelacion as idusuario from
		02direccionproveedor1 left join 02usuarios
		on 02direccionproveedor1.idRelacion = 02usuarios.id
		where P_RFC_MTDP ='".$rfc."' ";
		$variablequery = mysqli_query($conn,$variable);
		$row2 = mysqli_fetch_array($variablequery, MYSQLI_ASSOC);
		$_SESSION['idusuario12'] = $row2['idusuario'];
		$_SESSION['P_NOMBRE_COMERCIAL_EMPRESA12'] = $row2['P_NOMBRE_COMERCIAL_EMPRESA'];
		return $row2['idusuario'].'^^^^'.$row2['P_NOMBRE_COMERCIAL_EMPRESA'];
	}

	public function buscarnombre($filtro){
		$conn = $this->db();
		$variable = "select * from 04altaeventos where NUMERO_EVENTO = '".$filtro."' ";
		$variablequery = mysqli_query($conn,$variable);
		while($row = mysqli_fetch_array($variablequery, MYSQLI_ASSOC)){
			$resultado = $row['NOMBRE_EVENTO'];
		}
		return $resultado;
	}

	public function buscarciudad($filtro){
		$conn = $this->db();
		$variable = "select * from 04altaeventos where NUMERO_EVENTO = '".$filtro."' ";
		$variablequery = mysqli_query($conn,$variable);
		while($row = mysqli_fetch_array($variablequery, MYSQLI_ASSOC)){
			$resultado = $row['CIUDAD_DEL_EVENTO'];
		}
		return $resultado;
	}

	// ══════════════════════════════════════════════════════════════════════
	//  ARCHIVOS / CARGA
	// ══════════════════════════════════════════════════════════════════════

	/**
	 * Sube un archivo a /includes/archivos (carpeta original).
	 */
public function solocargartemp($archivo) {

    $nombre_carpeta = __ROOT3__ . '/includes/archivos';

    // ── Validar error de subida y archivo vacío ───────────────────────
    if (!isset($_FILES[$archivo]) || $_FILES[$archivo]['error'] !== UPLOAD_ERR_OK) {
        return "ERROR_SUBIDA";
    }

    if ($_FILES[$archivo]['size'] === 0) {
        return "VACIO";
    }

    $nombretemp = $_FILES[$archivo]["tmp_name"];

    // Nombre original
    $nombrearchivo = $_FILES[$archivo]["name"];

    // Corregir codificación
    $nombrearchivo = urldecode($nombrearchivo);

    if (!mb_check_encoding($nombrearchivo, 'UTF-8')) {
        $nombrearchivo = mb_convert_encoding($nombrearchivo, 'UTF-8', 'ISO-8859-1');
    }

    $nombrearchivo = iconv('UTF-8', 'UTF-8//IGNORE', $nombrearchivo);

    $extension = explode('.', $nombrearchivo);
    $cuenta = count($extension) - 1;
    $ext = strtolower($extension[$cuenta]);

    // ── Validar que tiene extensión real ─────────────────────────────
    if ($cuenta === 0 || trim($ext) === '') {
        return "SIN_EXTENSION";
    }

    // ── Sanitizar nombre ─────────────────────────────────────────────
    $nombrebase = pathinfo($nombrearchivo, PATHINFO_FILENAME);

    // Quitar caracteres conflictivos
    $nombrebase = preg_replace('/[^a-zA-Z0-9_\-áéíóúÁÉÍÓÚñÑüÜ]/u', '_', $nombrebase);

    // Colapsar guiones bajos múltiples
    $nombrebase = preg_replace('/_+/', '_', $nombrebase);

    // Quitar guiones bajos al inicio y al final
    $nombrebase = trim($nombrebase, '_');

    // Limitar longitud
    if (mb_strlen($nombrebase) > 60) {
        $nombrebase = mb_substr($nombrebase, 0, 60);
    }

    // Fallback si quedó vacío
    if ($nombrebase === '') {
        $nombrebase = 'archivo';
    }

    $nuevonombre = $archivo . '_' . $nombrebase . '_' . date('Y_m_d_H_i_s') . '.' . $ext;

    $permitidos = ['pdf', 'gif', 'jpeg', 'jpg', 'png', 'mp4', 'docx', 'doc', 'xml'];

    if (!in_array($ext, $permitidos)) {
        return "2";
    }

    if (move_uploaded_file($nombretemp, $nombre_carpeta . '/' . $nuevonombre)) {
        chmod($nombre_carpeta . '/' . $nuevonombre, 0755);
        return trim($nuevonombre);
    }

    return "1";
}





	// ══════════════════════════════════════════════════════════════════════
	//  PENDIENTE DE PAGO
	// ══════════════════════════════════════════════════════════════════════

	public function pendiente_pago($total_menos_depositado, $NUMERO_EVENTO){
		$total_menos_depositado = str_replace(',', '', $total_menos_depositado);
		$conn = $this->db();
		$variable = "select * from 02SUBETUFACTURA where NUMERO_EVENTO = '".$NUMERO_EVENTO."' ";
		$resultado = 0;
		$variablequery = mysqli_query($conn, $variable);
		while($row = mysqli_fetch_array($variablequery, MYSQLI_ASSOC)){
			$resultado += $row['MONTO_DEPOSITADO'];
		}
		return $total_menos_depositado - $resultado;
	}

	// ══════════════════════════════════════════════════════════════════════
	//  VARIABLES / DIRECCIÓN PROVEEDOR
	// ══════════════════════════════════════════════════════════════════════

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

	// ══════════════════════════════════════════════════════════════════════
	//  REVISORES (verificar existencia)
	// ══════════════════════════════════════════════════════════════════════

	public function revisar_pagoproveedor(){
		$conn = $this->db();
		$var1 = 'select id from 02SUBETUFACTURA where idRelacion = "'.$_SESSION['idPROV'].'" ';
		$query = mysqli_query($conn,$var1) or die('P44'.mysqli_error($conn));
		$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
		return $row['id'];
	}

	public function revisar_pagoproveedor2($id){
		$conn = $this->db();
		$var1 = 'select id from 02SUBETUFACTURA where id = "'.$id.'" ';
		$query = mysqli_query($conn,$var1) or die('P44'.mysqli_error($conn));
		$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
		return $row['id'];
	}

	public function revisar_SUBETUFACTURA(){
		$conn = $this->db();
		$var1 = 'select id from 02SUBETUFACTURA where idRelacion = "'.$_SESSION['idPROV'].'" ';
		$query = mysqli_query($conn,$var1) or die('P44'.mysqli_error($conn));
		$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
		return $row['id'];
	}

	public function revisar_DATOSBANCARIOS1(){
		$conn = $this->db();
		$var1 = 'select id from 02DATOSBANCARIOS1 where idRelacion = "'.$_SESSION['idPROV'].'" ';
		$query = mysqli_query($conn,$var1) or die('P44'.mysqli_error($conn));
		$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
		return $row['id'];
	}

	public function revisar_documentosfiscales(){
		$conn = $this->db();
		$var1 = 'select id from 02DOCUMENTOSFISCALES where idRelacion = "'.$_SESSION['idPROV'].'" ';
		$query = mysqli_query($conn,$var1) or die('P44'.mysqli_error($conn));
		$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
		return $row['id'];
	}

	public function revisar_nuevodocumento(){
		$conn = $this->db();
		$var1 = 'select id from 02NUEVODOCUMENTO where idRelacion = "'.$_SESSION['idPROV'].'" ';
		$query = mysqli_query($conn,$var1) or die('P44'.mysqli_error($conn));
		$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
		return $row['id'];
	}

	public function revisar_notas(){
		$conn = $this->db();
		$var1 = 'select id from 02NOTAS where idRelacion = "'.$_SESSION['id'].'" ';
		$query = mysqli_query($conn,$var1) or die('P44'.mysqli_error($conn));
		$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
		return $row['id'];
	}

	// ══════════════════════════════════════════════════════════════════════
	//  XML
	// ══════════════════════════════════════════════════════════════════════

	public function busca_02XML($ultimo_id){
		$conn = $this->db();
		$variablequery = "select * from 02XML where ultimo_id = '".$ultimo_id."' ";
		$arrayquery = mysqli_query($conn,$variablequery);
		return $row = mysqli_fetch_array($arrayquery, MYSQLI_ASSOC);
	}

	public function busca_07XML2($ultimo_id, $tabla){
		$conn = $this->db();
		$variablequery = "select * from ".$tabla." where ultimo_id = '".$ultimo_id."' ";
		$arrayquery = mysqli_query($conn,$variablequery);
		return $row = mysqli_fetch_array($arrayquery, MYSQLI_ASSOC);
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
	    $uuid = mysqli_real_escape_string($conn, trim((string)$uuid));

		if($uuid === ''){

			return 'S';

	}
		$variablequery = "SELECT 02XML.id, 02XML.UUID, 02XML.ultimo_id, 02SUBETUFACTURA.id AS idSolicitud, 02SUBETUFACTURA.NUMERO_CONSECUTIVO_PROVEE, 02SUBETUFACTURA.NUMERO_EVENTO

			FROM 02XML

			INNER JOIN 02SUBETUFACTURA ON 02XML.ultimo_id = 02SUBETUFACTURA.id

			WHERE 02XML.UUID = '".$uuid."'

			ORDER BY 02XML.id DESC LIMIT 1";

		$arrayquery = mysqli_query($conn,$variablequery);

		$row = $arrayquery ? mysqli_fetch_array($arrayquery, MYSQLI_ASSOC) : null;

		if(!empty($row['id'])){

			$numero = !empty($row['NUMERO_CONSECUTIVO_PROVEE']) ? $row['NUMERO_CONSECUTIVO_PROVEE'] : $row['idSolicitud'];

			$numeroEvento = isset($row['NUMERO_EVENTO']) ? trim((string)$row['NUMERO_EVENTO']) : '';

			return '3^^'.$numero.'^^'.$numeroEvento;

		}



		$query7 = mysqli_query($conn, "SELECT id, ultimo_id FROM 07XML WHERE UUID = '".$uuid."' LIMIT 1");

		$row7 = $query7 ? mysqli_fetch_array($query7, MYSQLI_ASSOC) : null;

		if(!empty($row7['id'])){

			$numero7 = ($row7['ultimo_id'] != '') ? $row7['ultimo_id'] : $row7['id'];

			return '7^^^'.$numero7;

		}



		return 'S';

	}


	public function actualizar_forma_pago($id, $formaDePago){
		if($id == '' || $formaDePago == ''){ return false; }
		$conn = $this->db();
		$var1 = "update 02SUBETUFACTURA set PFORMADE_PAGO = '".$formaDePago."' where id = '".$id."' ";
		return mysqli_query($conn,$var1);
	}

	public function guardarxmlDB($ultimo_id){
		$conexion2 = new herramientas();
		$regreso   = $this->variable_SUBETUFACTURA();
		$url       = __ROOT3__.'/includes/archivos/'.$regreso['ADJUNTAR_FACTURA_XML'];
		if(!file_exists($url)){ return; }

		$regreso = $conexion2->lectorxml($url);

		$Version                = $regreso['Version'];
		$tipoDeComprobante      = $regreso['tipoDeComprobante'];
		$metodoDePago           = $regreso['metodoDePago'];
		$formaDePago            = $regreso['formaDePago'];
		$condicionesDePago      = $regreso['condicionesDePago'];
		$subTotal               = $regreso['subTotal'];
		$TipoCambio             = $regreso['TipoCambio'];
		$Moneda                 = $regreso['Moneda'];
		$total                  = $regreso['total'];
		$serie                  = $regreso['serie'];
		$folio                  = $regreso['folio'];
		$LugarExpedicion        = $regreso['LugarExpedicion'];
		$rfcE                   = $regreso['rfcE'];
		$nombreE                = $regreso['nombreE'];
		$regimenE               = $regreso['regimenE'];
		$rfcR                   = $regreso['rfcR'];
		$nombreR                = $regreso['nombreR'];
		$UsoCFDI                = $regreso['UsoCFDI'];
		$DomicilioFiscalReceptor   = $regreso['DomicilioFiscalReceptor'];
		$RegimenFiscalReceptor     = $regreso['RegimenFiscalReceptor'];
		$UUID                   = $regreso['UUID'];
		$FechaTimbrado          = $regreso['FechaTimbrado'];
		$TImpuestosRetenidos    = $regreso['TImpuestosRetenidos'];
		$TImpuestosTrasladados  = $regreso['TImpuestosTrasladados'];
		$CantidadConcepto       = $regreso['Cantidad'];
		$ValorUnitarioConcepto  = $regreso['ValorUnitario'];
		$ImporteConcepto        = $regreso['Importe'];
		$ClaveProdServConcepto  = $regreso['ClaveProdServ'];
		$UnidadConcepto         = $regreso['Unidad'];
		$DescripcionConcepto    = $regreso['Descripcion'];
		$ClaveUnidadConcepto    = $regreso['ClaveUnidad'];
		$NoIdentificacionConcepto = $regreso['NoIdentificacion'];
		$Descuento              = $regreso['Descuento'];

		$session = isset($_SESSION['idPROV']) ? $_SESSION['idPROV'] : '';
		$conn    = $this->db();

		$var3 = "INSERT INTO `02XML` (
		`id`, `Version`, `fechaTimbrado`, `tipoDeComprobante`,
		`metodoDePago`, `formaDePago`, `condicionesDePago`, `subTotal`,
		`TipoCambio`, `Moneda`, `totalf`, `serie`,
		`folio`, `LugarExpedicion`, `rfcE`, `nombreE`,
		`regimenE`, `rfcR`, `nombreR`, `UsoCFDI`,
		`DomicilioFiscalReceptor`, `RegimenFiscalReceptor`, `UUID`, `TImpuestosRetenidos`,
		`TImpuestosTrasladados`, Descuento, `idRelacion`, `ultimo_id`,
		CantidadConcepto, ValorUnitarioConcepto, ImporteConcepto,
		ClaveProdServConcepto, UnidadConcepto, DescripcionConcepto,
		ClaveUnidadConcepto, NoIdentificacionConcepto
		) VALUES (
		'', '".$Version."', '".$FechaTimbrado."', '".$tipoDeComprobante."',
		'".$metodoDePago."', '".$formaDePago."', '".$condicionesDePago."', '".$subTotal."',
		'".$TipoCambio."', '".$Moneda."', '".$total."', '".$serie."',
		'".$folio."', '".$LugarExpedicion."', '".$rfcE."', '".$nombreE."',
		'".$regimenE."', '".$rfcR."', '".$nombreR."', '".$UsoCFDI."',
		'".$DomicilioFiscalReceptor."', '".$RegimenFiscalReceptor."', '".$UUID."', '".$TImpuestosRetenidos."',
		'".$TImpuestosTrasladados."', '".$Descuento."', '".$session."', '".$ultimo_id."',
		'".$CantidadConcepto."', '".$ValorUnitarioConcepto."', '".$ImporteConcepto."',
		'".$ClaveProdServConcepto."', '".$UnidadConcepto."', '".$DescripcionConcepto."',
		'".$ClaveUnidadConcepto."', '".$NoIdentificacionConcepto."'
		);";
		mysqli_query($conn,$var3) or die('P156'.mysqli_error($conn));
	}

	public function guardarxmlDB2($ultimo_id, $session, $tabla, $url){
		$conn     = $this->db();
		$conexion2 = new herramientas();
		if(!file_exists($url)){ return; }

		$regreso = $conexion2->lectorxml($url);

		$Version               = $regreso['Version'];
		$tipoDeComprobante     = $regreso['tipoDeComprobante'];
		$metodoDePago          = $regreso['metodoDePago'];
		$formaDePago           = $regreso['formaDePago'];
		$condicionesDePago     = $regreso['condicionesDePago'];
		$subTotal              = $regreso['subTotal'];
		$TipoCambio            = $regreso['TipoCambio'];
		$Moneda                = $regreso['Moneda'];
		$Descuento             = $regreso['Descuento'];
		$total                 = $regreso['total'];
		$serie                 = $regreso['serie'];
		$folio                 = $regreso['folio'];
		$LugarExpedicion       = $regreso['LugarExpedicion'];
		$DescripcionConcepto   = $regreso['DescripcionConcepto'];
		$rfcE                  = $regreso['rfcE'];
		$nombreE               = $regreso['nombreE'];
		$regimenE              = $regreso['regimenE'];
		$rfcR                  = $regreso['rfcR'];
		$nombreR               = $regreso['nombreR'];
		$UsoCFDI               = $regreso['UsoCFDI'];
		$DomicilioFiscalReceptor  = $regreso['DomicilioFiscalReceptor'];
		$RegimenFiscalReceptor    = $regreso['RegimenFiscalReceptor'];
		$UUID                  = $regreso['UUID'];
		$FechaTimbrado         = $regreso['FechaTimbrado'];
		$TImpuestosRetenidos   = $regreso['TImpuestosRetenidos'];
		$TImpuestosTrasladados = $regreso['TImpuestosTrasladados'];
		$Cantidad              = $regreso['Cantidad'];
		$ValorUnitario         = $regreso['ValorUnitario'];
		$Importe               = $regreso['Importe'];
		$ClaveProdServ         = $regreso['ClaveProdServ'];
		$Unidad                = $regreso['Unidad'];
		$Descripcion           = $regreso['Descripcion'];
		$ClaveUnidad           = $regreso['ClaveUnidad'];
		$NoIdentificacion      = $regreso['NoIdentificacion'];

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
		where `ultimo_id` = '".$ultimo_id."';";

		$var4 = "INSERT INTO ".$tabla." (
		`id`, `Version`, `fechaTimbrado`, `tipoDeComprobante`,
		`metodoDePago`, `formaDePago`, `condicionesDePago`, `subTotal`,
		`TipoCambio`, `Moneda`, `totalf`, `serie`,
		`folio`, `LugarExpedicion`, `rfcE`, `nombreE`,
		`regimenE`, `rfcR`, `nombreR`, `UsoCFDI`,
		`DomicilioFiscalReceptor`, `RegimenFiscalReceptor`, `UUID`, `TImpuestosRetenidos`,
		`TImpuestosTrasladados`, `idRelacion`, `ultimo_id`, Descuento,
		CantidadConcepto, ValorUnitarioConcepto, ImporteConcepto,
		ClaveProdServConcepto, UnidadConcepto, DescripcionConcepto,
		ClaveUnidadConcepto, NoIdentificacionConcepto
		) VALUES (
		'', '".$Version."', '".$FechaTimbrado."', '".$tipoDeComprobante."',
		'".$metodoDePago."', '".$formaDePago."', '".$condicionesDePago."', '".$subTotal."',
		'".$TipoCambio."', '".$Moneda."', '".$total."', '".$serie."',
		'".$folio."', '".$LugarExpedicion."', '".$rfcE."', '".$nombreE."',
		'".$regimenE."', '".$rfcR."', '".$nombreR."', '".$UsoCFDI."',
		'".$DomicilioFiscalReceptor."', '".$RegimenFiscalReceptor."', '".$UUID."', '".$TImpuestosRetenidos."',
		'".$TImpuestosTrasladados."', '".$session."', '".$ultimo_id."', '".$Descuento."',
		'".$Cantidad."', '".$ValorUnitario."', '".$Importe."',
		'".$ClaveProdServ."', '".$Unidad."', '".$Descripcion."',
		'".$ClaveUnidad."', '".$NoIdentificacion."'
		);";

		$row = $this->busca_07XML2($ultimo_id, $tabla);
		if($row['ultimo_id'] == 0 || $row['ultimo_id'] == ''){
			mysqli_query($conn,$var4) or die('P350'.mysqli_error($conn));
			echo "Ingresado";
		}else{
			mysqli_query($conn,$var3) or die('P352'.mysqli_error($conn));
			echo "Actualizado";
		}
	}

	// ══════════════════════════════════════════════════════════════════════
	//  VERIFICAR / INGRESAR RFC Y USUARIO
	// ══════════════════════════════════════════════════════════════════════

	public function verificar_rfc($conn, $RFC_PROVEEDOR){
		$queryrfc = "SELECT * FROM 02direccionproveedor1 WHERE P_RFC_MTDP = '".$RFC_PROVEEDOR."' ";
		$arrayquery = mysqli_query($conn,$queryrfc);
		$row = mysqli_fetch_array($arrayquery, MYSQLI_ASSOC);
		return $row['id'];
	}

	public function verificar_usuario($conn, $nommbrerazon){
		$queryrfc = "SELECT * FROM 02direccionproveedor1 WHERE P_NOMBRE_FISCAL_RS_EMPRESA = '".$nommbrerazon."' ";
		$arrayquery = mysqli_query($conn,$queryrfc);
		$row = mysqli_fetch_array($arrayquery, MYSQLI_ASSOC);
		return $row['id'];
	}

	public function verificar_usuario_comercial($conn, $nommbrerazon){
		$queryrfc = "SELECT * FROM 02direccionproveedor1 WHERE P_NOMBRE_COMERCIAL_EMPRESA = '".$nommbrerazon."' ";
		$arrayquery = mysqli_query($conn,$queryrfc);
		$row = mysqli_fetch_array($arrayquery, MYSQLI_ASSOC);
		return $row['id'];
	}

	public function ingresar_usuario($conn, $nommbrerazon){
		$queryrfc = "insert into 02direccionproveedor1 (P_NOMBRE_FISCAL_RS_EMPRESA) values ('".$nommbrerazon."'); ";
		mysqli_query($conn,$queryrfc) or die('P160'.mysqli_error($conn));
		return mysqli_insert_id($conn);
	}

	public function ingresar_rfc($conn, $RFC_PROVEEDOR, $nommbrerazon){
		$queryrfc = "UPDATE 02direccionproveedor1 SET P_RFC_MTDP = '".$RFC_PROVEEDOR."', idRelacion = '".$nommbrerazon."' WHERE id = '".$nommbrerazon."' ";
		return mysqli_query($conn,$queryrfc);
	}

	public function listado3(){
		$conn = $this->db();
		$var = 'select *,02usuarios.id AS IDDD from 02usuarios left join 02direccionproveedor1 on 02usuarios.id = 02direccionproveedor1.idRelacion order by nommbrerazon asc';
		return mysqli_query($conn,$var);
	}

	// ══════════════════════════════════════════════════════════════════════
	//  lectorxmlX  (módulo Sube Tu Factura — formulario SB)
	// ══════════════════════════════════════════════════════════════════════

	public function lectorxmlX($NUMERO_CONSECUTIVO_PROVEE, $NOMBRE_COMERCIAL, $RAZON_SOCIAL, $VIATICOSOPRO,
		$RFC_PROVEEDOR, $NUMERO_EVENTO, $NOMBRE_EVENTO, $CONCEPTO_PROVEE,
		$MONTO_TOTAL_COTIZACION_ADEUDO, $MONTO_DEPOSITAR, $MONTO_PROPINA, $MONTO_FACTURA,
		$TIPO_DE_MONEDA, $PFORMADE_PAGO, $FECHA_DE_PAGO, $STATUS_DE_PAGO,
		$NOMBRE_DEL_EJECUTIVO, $OBSERVACIONES_1, $FECHA_DE_LLENADO,
		$ADJUNTAR_FACTURA_XML, $ADJUNTAR_FACTURA_PDF, $ADJUNTAR_COTIZACION11,
		$CONPROBANTE_TRANSFERENCIA, $ADJUNTAR_ARCHIVO_1, $IMPUESTO_HOSPEDAJE,
		$MONTO_DEPOSITADO, $PENDIENTE_PAGO, $IVA, $NOMBRE_DEL_AYUDO,
		$TImpuestosRetenidosIVA, $TImpuestosRetenidosISR, $descuentos,
		$hiddensubefactura, $ENVIARRSB1p, $IPSB1p)
	{
		$conn    = $this->db();
		$session = isset($_SESSION['idPROV']) ? $_SESSION['idPROV'] : '';
		if($session == ''){ echo "NO HAY UN PROVEEDOR SELECCIONADO"; return; }

		// Sanitizar montos
		foreach(array('MONTO_TOTAL_COTIZACION_ADEUDO','MONTO_DEPOSITAR','MONTO_PROPINA',
			'MONTO_FACTURA','IMPUESTO_HOSPEDAJE','MONTO_DEPOSITADO','PENDIENTE_PAGO',
			'IVA','TImpuestosRetenidosIVA','TImpuestosRetenidosISR','descuentos') as $var){
			$$var = str_replace(',', '', $$var);
		}

		$var1 = "update 02SUBETUFACTURA set
		NUMERO_CONSECUTIVO_PROVEE = '".$NUMERO_CONSECUTIVO_PROVEE."',
		NOMBRE_COMERCIAL = '".$NOMBRE_COMERCIAL."',
		RAZON_SOCIAL = '".$RAZON_SOCIAL."',
		VIATICOSOPRO = '".$VIATICOSOPRO."',
		RFC_PROVEEDOR = '".$RFC_PROVEEDOR."',
		NUMERO_EVENTO = '".$NUMERO_EVENTO."',
		NOMBRE_EVENTO = '".$NOMBRE_EVENTO."',
		CONCEPTO_PROVEE = '".$CONCEPTO_PROVEE."',
		MONTO_TOTAL_COTIZACION_ADEUDO = '".$MONTO_TOTAL_COTIZACION_ADEUDO."',
		MONTO_DEPOSITAR = '".$MONTO_DEPOSITAR."',
		MONTO_PROPINA = '".$MONTO_PROPINA."',
		IMPUESTO_HOSPEDAJE = '".$IMPUESTO_HOSPEDAJE."',
		MONTO_DEPOSITADO = '".$MONTO_DEPOSITADO."',
		PENDIENTE_PAGO = '".$PENDIENTE_PAGO."',
		IVA = '".$IVA."',
		NOMBRE_DEL_AYUDO = '".$NOMBRE_DEL_AYUDO."',
		TImpuestosRetenidosIVA = '".$TImpuestosRetenidosIVA."',
		TImpuestosRetenidosISR = '".$TImpuestosRetenidosISR."',
		descuentos = '".$descuentos."',
		MONTO_FACTURA = '".$MONTO_FACTURA."',
		TIPO_DE_MONEDA = '".$TIPO_DE_MONEDA."',
		PFORMADE_PAGO = '".$PFORMADE_PAGO."',
		FECHA_DE_PAGO = '".$FECHA_DE_PAGO."',
		STATUS_DE_PAGO = '".$STATUS_DE_PAGO."',
		NOMBRE_DEL_EJECUTIVO = '".$NOMBRE_DEL_EJECUTIVO."',
		OBSERVACIONES_1 = '".$OBSERVACIONES_1."',
		FECHA_DE_LLENADO = '".$FECHA_DE_LLENADO."'
		where id = '".$IPSB1p."';";

		$var2 = "insert into 02SUBETUFACTURA (
		ADJUNTAR_FACTURA_XML, ADJUNTAR_FACTURA_PDF, ADJUNTAR_COTIZACION,
		CONPROBANTE_TRANSFERENCIA, ADJUNTAR_ARCHIVO_1,
		NUMERO_CONSECUTIVO_PROVEE, NOMBRE_COMERCIAL, RAZON_SOCIAL, VIATICOSOPRO,
		RFC_PROVEEDOR, NUMERO_EVENTO, NOMBRE_EVENTO, CONCEPTO_PROVEE,
		MONTO_TOTAL_COTIZACION_ADEUDO, MONTO_DEPOSITAR, MONTO_PROPINA,
		IMPUESTO_HOSPEDAJE, MONTO_DEPOSITADO, PENDIENTE_PAGO, IVA,
		NOMBRE_DEL_AYUDO, TImpuestosRetenidosIVA, TImpuestosRetenidosISR, descuentos,
		MONTO_FACTURA, TIPO_DE_MONEDA, PFORMADE_PAGO, FECHA_DE_PAGO,
		STATUS_DE_PAGO, NOMBRE_DEL_EJECUTIVO, OBSERVACIONES_1, FECHA_DE_LLENADO,
		idRelacion) values (
		'".$ADJUNTAR_FACTURA_XML."', '".$ADJUNTAR_FACTURA_PDF."',
		'".$ADJUNTAR_COTIZACION11."', '".$CONPROBANTE_TRANSFERENCIA."',
		'".$ADJUNTAR_ARCHIVO_1."',
		'".$NUMERO_CONSECUTIVO_PROVEE."', '".$NOMBRE_COMERCIAL."', '".$RAZON_SOCIAL."', '".$VIATICOSOPRO."',
		'".$RFC_PROVEEDOR."', '".$NUMERO_EVENTO."', '".$NOMBRE_EVENTO."', '".$CONCEPTO_PROVEE."',
		'".$MONTO_TOTAL_COTIZACION_ADEUDO."', '".$MONTO_DEPOSITAR."', '".$MONTO_PROPINA."',
		'".$IMPUESTO_HOSPEDAJE."', '".$MONTO_DEPOSITADO."', '".$PENDIENTE_PAGO."', '".$IVA."',
		'".$NOMBRE_DEL_AYUDO."', '".$TImpuestosRetenidosIVA."', '".$TImpuestosRetenidosISR."', '".$descuentos."',
		'".$MONTO_FACTURA."', '".$TIPO_DE_MONEDA."', '".$PFORMADE_PAGO."', '".$FECHA_DE_PAGO."',
		'".$STATUS_DE_PAGO."', '".$NOMBRE_DEL_EJECUTIVO."', '".$OBSERVACIONES_1."', '".$FECHA_DE_LLENADO."',
		'".$session."');";

		if($ENVIARRSB1p == 'ENVIARRSB1p'){
			$this->registrar_bitacora_sb('actualizar', 'Se actualizó un registro en 02SUBETUFACTURA', $IPSB1p, '02SUBETUFACTURA');
			mysqli_query($conn,$var1) or die('P156'.mysqli_error($conn));
			return "Actualizado";
		}else{
			mysqli_query($conn,$var2) or die('P160'.mysqli_error($conn));
			$ultimo_id = mysqli_insert_id($conn);
			$this->registrar_bitacora_sb('crear', '', $ultimo_id, '02SUBETUFACTURA');
			$this->guardarxmlDB($ultimo_id);
			$var3 = "UPDATE 02SUBETUFACTURADOCTOS SET idTemporal ='".$ultimo_id."' where idRelacion = '".$_SESSION['idPROV']."' and idTemporal ='si' ";
			mysqli_query($conn,$var3);
			return "Ingresado";
		}
	}

	// ══════════════════════════════════════════════════════════════════════
	//  BORRAR
	// ══════════════════════════════════════════════════════════════════════

	public function borra_sube_factura($id){
		$conn = $this->db();
		mysqli_query($conn, "delete from 02SUBETUFACTURADOCTOS where idTemporal = '".$id."' ");
		mysqli_query($conn, "delete from 02XML where ultimo_id = '".$id."' ");
		mysqli_query($conn, "delete from 02SUBETUFACTURA where id = '".$id."' ");
		$this->registrar_bitacora_sb('eliminar', 'Se eliminó un registro en 02SUBETUFACTURA', $id, '02SUBETUFACTURA');
		return "ELEMENTO BORRADO";
	}

	public function borrapagoaproveedores($id){
		$conn = $this->db();
		mysqli_query($conn, "DELETE FROM 02SUBETUFACTURA where id = '".$id."' ") or die('P44'.mysqli_error($conn));
		mysqli_query($conn, "DELETE FROM `02XML` WHERE `ultimo_id` = '".$id."' ") or die('P44'.mysqli_error($conn));
		mysqli_query($conn, "DELETE FROM `02SUBETUFACTURADOCTOS` WHERE `idTemporal` = '".$id."' ") or die('P44'.mysqli_error($conn));
		echo "ELEMENTO BORRADO";
	}

	public function borrar_xmls($ruta, $id, $nombrearchivo, $tabla1, $tabla2){
		$conn = $this->db();
		mysqli_query($conn, "delete FROM ".$tabla1." WHERE `ultimo_id` = '".$id."' ");

		$QUERYVAR2 = mysqli_query($conn,
			"SELECT * FROM ".$tabla2." WHERE `idTemporal` = '".$id."'
			and ADJUNTAR_FACTURA_XML <> '".$nombrearchivo."' and ADJUNTAR_FACTURA_XML <> ''")
			or die('P44'.mysqli_error($conn));
		while($row = mysqli_fetch_array($QUERYVAR2, MYSQLI_ASSOC)){
			if(file_exists($ruta.$row['ADJUNTAR_FACTURA_XML'])){ unlink($ruta.$row['ADJUNTAR_FACTURA_XML']); }
		}
		mysqli_query($conn,
			"DELETE FROM ".$tabla2." WHERE `idTemporal` = '".$id."'
			and ADJUNTAR_FACTURA_XML <> '".$nombrearchivo."' and ADJUNTAR_FACTURA_XML <>''")
			or die('P44'.mysqli_error($conn));
	}

	public function borrar_pdfs($ruta, $id, $nombrearchivo, $tabla1, $tabla2){
		$conn = $this->db();
		$QUERYVAR2 = mysqli_query($conn,
			"SELECT * FROM ".$tabla2." WHERE `idTemporal` = '".$id."'
			and ADJUNTAR_FACTURA_PDF <> '".$nombrearchivo."' and ADJUNTAR_FACTURA_PDF <> ''")
			or die('P44'.mysqli_error($conn));
		while($row = mysqli_fetch_array($QUERYVAR2, MYSQLI_ASSOC)){
			if(file_exists($ruta.$row['ADJUNTAR_FACTURA_PDF'])){ unlink($ruta.$row['ADJUNTAR_FACTURA_PDF']); }
		}
		mysqli_query($conn,
			"DELETE FROM ".$tabla2." WHERE `idTemporal` = '".$id."'
			and ADJUNTAR_FACTURA_PDF <> '".$nombrearchivo."' and ADJUNTAR_FACTURA_PDF <>''")
			or die('P44'.mysqli_error($conn));
	}

	public function borrar_historico_xml($nombretabla, $idusuario){
		$conn = $this->db();
		$ruta = __ROOT3__;
		$QUERYVAR2 = mysqli_query($conn,
			"SELECT * FROM ".$nombretabla." WHERE `idRelacionU` = '".$idusuario."' and TIPOARCHIVO = 'xml' and idTemporal = 'si'")
			or die('P44'.mysqli_error($conn));
		while($row = mysqli_fetch_array($QUERYVAR2, MYSQLI_ASSOC)){
			if(file_exists($ruta.$row['ADJUNTAR_FACTURA_XML'])){ unlink($ruta.$row['ADJUNTAR_FACTURA_XML']); }
		}
		mysqli_query($conn, "DELETE FROM ".$nombretabla." WHERE `idRelacionU` = '".$idusuario."' and TIPOARCHIVO = 'xml' and idTemporal = 'si'") or die('P441'.mysqli_error($conn));
		mysqli_query($conn, "DELETE FROM ".$nombretabla." WHERE `idRelacionU` = '".$idusuario."' and idTemporal = 'si' and TIPOARCHIVO = 'OTR'") or die('P442'.mysqli_error($conn));
	}

	// ══════════════════════════════════════════════════════════════════════
	//  LISTADOS
	// ══════════════════════════════════════════════════════════════════════

	public function Listado_pagoproveedor(){
		$conn = $this->db();
		return mysqli_query($conn, "select * from 02SUBETUFACTURA where idRelacion = '".$_SESSION['idPROV']."' order by id desc ");
	}

	public function Listado_pagoproveedor2($id){
		$conn = $this->db();
		return mysqli_query($conn, "select * from 02SUBETUFACTURA where id = '".$id."' ");
	}

	public function Listado_subefactura(){
		$conn = $this->db();
		return mysqli_query($conn, "select * from 02SUBETUFACTURA where idRelacion = '".$_SESSION['idPROV']."' order by id desc ");
	}

	public function Listado_subefactura2($id){
		$conn = $this->db();
		return mysqli_query($conn, "select * from 02SUBETUFACTURA where id = '".$id."' ");
	}

	public function Listado_subefacturaDOCTOS($ID){
		$conn = $this->db();
		return mysqli_query($conn, "select * from 02SUBETUFACTURADOCTOS where idRelacion = '".$_SESSION['idPROV']."' and idTemporal = '".$ID."' order by id desc ");
	}

	public function Listado_subefacturadocto($ADJUNTAR_COTIZACION){
		$conn = $this->db();
		return mysqli_query($conn, "select id,".$ADJUNTAR_COTIZACION.",fechaingreso from 02SUBETUFACTURADOCTOS where idRelacion = '".$_SESSION['idPROV']."' and idTemporal = 'si' and (".$ADJUNTAR_COTIZACION." is not null or ".$ADJUNTAR_COTIZACION." <> '') ORDER BY id DESC ");
	}

	public function getDoctos_subefactura($ID){
		$conn = $this->db();
		$sql = "SELECT COMPLEMENTOS_PAGO_PDF, COMPLEMENTOS_PAGO_XML
		FROM 02SUBETUFACTURADOCTOS
		WHERE idTemporal = '".mysqli_real_escape_string($conn,$ID)."'
		ORDER BY id DESC LIMIT 1";
		$query = mysqli_query($conn, $sql);
		return $query ? mysqli_fetch_array($query, MYSQLI_ASSOC) : null;
	}

	public function delete_subefacturadocto2($id){
		$conn = $this->db();
		$resultado = mysqli_query($conn, "SELECT idTemporal, ADJUNTAR_FACTURA_XML FROM 02SUBETUFACTURADOCTOS WHERE id = '".$id."' ");
		$row = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
		if($row && $row['ADJUNTAR_FACTURA_XML'] != ''){
			mysqli_query($conn, "DELETE FROM 02XML WHERE ultimo_id = '".$row['idTemporal']."' ");
		}
		return mysqli_query($conn, "delete from 02SUBETUFACTURADOCTOS where id = '".$id."' ");
	}

	public function delete_subefactura2nombre($nombre){
		$conn = $this->db();
		mysqli_query($conn, "delete from 02SUBETUFACTURADOCTOS where ADJUNTAR_FACTURA_XML = '".$nombre."' ");
	}

	public function Listado_bitacora_pagoproveedor_array($idcomprobacion){
		$conn = $this->db();
		$idcomprobacion = intval($idcomprobacion);

		// Asegura que la tabla exista
		mysqli_query($conn, "CREATE TABLE IF NOT EXISTS `02SUBETUFACTURA_BITACORA` (
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
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

		$arrayquery = mysqli_query($conn,
			"SELECT tipo_movimiento, detalle, fecha_hora, nombre_quien_ingreso, nombre_quien_actualizo
			FROM 02SUBETUFACTURA_BITACORA
			WHERE id_subetufactura = '".$idcomprobacion."'
			ORDER BY id DESC");

		$resultado = array();
		if($arrayquery){
			while($row = mysqli_fetch_array($arrayquery, MYSQLI_ASSOC)){
				if(isset($row['fecha_hora']) && $row['fecha_hora'] != ''){
					$f = DateTime::createFromFormat('Y-m-d H:i:s', $row['fecha_hora'], new DateTimeZone('UTC'));
					if($f){
						$f->setTimezone(new DateTimeZone('America/Mexico_City'));
						$row['fecha_hora'] = $f->format('d/m/Y H:i:s');
					}
				}
				$resultado[] = $row;
			}
		}
		return $resultado;
	}

	// ══════════════════════════════════════════════════════════════════════
	//  DATOS BANCARIOS
	// ══════════════════════════════════════════════════════════════════════

	public function variable_DATOSBANCARIOS1(){
		$conn = $this->db();
		$variablequery = "select * from 02DATOSBANCARIOS1 where idRelacion = '".$_SESSION['idPROV']."' ";
		$arrayquery = mysqli_query($conn,$variablequery);
		return mysqli_fetch_array($arrayquery, MYSQLI_ASSOC);
	}

	public function enviarDATOSBANCARIOS1($P_TIPO_DE_MONEDA_1, $P_INSTITUCION_FINANCIERA_1,
		$P_NUMERO_DE_CUENTA_DB_1, $P_NUMERO_CLABE_1, $P_NUMERO_DE_SUCURSAL_1,
		$P_NUMERO_IBAN_1, $P_NUMERO_CUENTA_SWIFT_1, $FOTO_ESTADO_PROVEE,
		$ULTIMA_CARGA_DATOBANCA, $ENVIARRdatosbancario1p, $IPdatosbancario1p){

		$conn    = $this->db();
		$session = isset($_SESSION['idPROV']) ? $_SESSION['idPROV'] : '';
		if($session == ''){ echo "NO HAY UN PROVEEDOR SELECCIONADO"; return; }

		$var1 = "update 02DATOSBANCARIOS1 set
		P_TIPO_DE_MONEDA_1 = '".$P_TIPO_DE_MONEDA_1."',
		P_INSTITUCION_FINANCIERA_1 = '".$P_INSTITUCION_FINANCIERA_1."',
		P_NUMERO_DE_CUENTA_DB_1 = '".$P_NUMERO_DE_CUENTA_DB_1."',
		P_NUMERO_CLABE_1 = '".$P_NUMERO_CLABE_1."',
		P_NUMERO_DE_SUCURSAL_1 = '".$P_NUMERO_DE_SUCURSAL_1."',
		P_NUMERO_IBAN_1 = '".$P_NUMERO_IBAN_1."',
		P_NUMERO_CUENTA_SWIFT_1 = '".$P_NUMERO_CUENTA_SWIFT_1."',
		ULTIMA_CARGA_DATOBANCA = '".$ULTIMA_CARGA_DATOBANCA."'
		where id = '".$IPdatosbancario1p."';";

		$var2 = "insert into 02DATOSBANCARIOS1 (
		P_TIPO_DE_MONEDA_1, P_INSTITUCION_FINANCIERA_1, P_NUMERO_DE_CUENTA_DB_1,
		P_NUMERO_CLABE_1, P_NUMERO_DE_SUCURSAL_1, P_NUMERO_IBAN_1,
		P_NUMERO_CUENTA_SWIFT_1, FOTO_ESTADO_PROVEE, ULTIMA_CARGA_DATOBANCA, idRelacion
		) values (
		'".$P_TIPO_DE_MONEDA_1."', '".$P_INSTITUCION_FINANCIERA_1."', '".$P_NUMERO_DE_CUENTA_DB_1."',
		'".$P_NUMERO_CLABE_1."', '".$P_NUMERO_DE_SUCURSAL_1."', '".$P_NUMERO_IBAN_1."',
		'".$P_NUMERO_CUENTA_SWIFT_1."', '".$FOTO_ESTADO_PROVEE."', '".$ULTIMA_CARGA_DATOBANCA."', '".$session."');";

		if($ENVIARRdatosbancario1p == 'ENVIARRdatosbancario1p'){
			mysqli_query($conn,$var1) or die('P156'.mysqli_error($conn));
			return "Actualizado";
		}else{
			mysqli_query($conn,$var2) or die('P160'.mysqli_error($conn));
			return "Ingresado";
		}
	}

	// Versión con bitácora (usada desde class.epcinnSB)
	public function enviarDATOSBANCARIOS1rr($P_TIPO_DE_MONEDA_1, $P_INSTITUCION_FINANCIERA_1,
		$P_NUMERO_DE_CUENTA_DB_1, $P_NUMERO_CLABE_1, $P_NUMERO_DE_SUCURSAL_1,
		$P_NUMERO_IBAN_1, $P_NUMERO_CUENTA_SWIFT_1, $FOTO_ESTADO_PROVEE,
		$ULTIMA_CARGA_DATOBANCA, $ENVIARRdatosbancario1p, $IPdatosbancario1p){

		$conn    = $this->db();
		$session = isset($_SESSION['idPROV']) ? $_SESSION['idPROV'] : '';
		if($session == ''){ echo "NO HAY UN PROVEEDOR SELECCIONADO"; return; }

		$var1 = "update 02DATOSBANCARIOS1 set
		P_TIPO_DE_MONEDA_1 = '".$P_TIPO_DE_MONEDA_1."',
		P_INSTITUCION_FINANCIERA_1 = '".$P_INSTITUCION_FINANCIERA_1."',
		P_NUMERO_DE_CUENTA_DB_1 = '".$P_NUMERO_DE_CUENTA_DB_1."',
		P_NUMERO_CLABE_1 = '".$P_NUMERO_CLABE_1."',
		P_NUMERO_DE_SUCURSAL_1 = '".$P_NUMERO_DE_SUCURSAL_1."',
		P_NUMERO_IBAN_1 = '".$P_NUMERO_IBAN_1."',
		P_NUMERO_CUENTA_SWIFT_1 = '".$P_NUMERO_CUENTA_SWIFT_1."',
		ULTIMA_CARGA_DATOBANCA = '".$ULTIMA_CARGA_DATOBANCA."'
		where id = '".$IPdatosbancario1p."';";

		$var2 = "insert into 02DATOSBANCARIOS1 (
		P_TIPO_DE_MONEDA_1, P_INSTITUCION_FINANCIERA_1, P_NUMERO_DE_CUENTA_DB_1,
		P_NUMERO_CLABE_1, P_NUMERO_DE_SUCURSAL_1, P_NUMERO_IBAN_1,
		P_NUMERO_CUENTA_SWIFT_1, FOTO_ESTADO_PROVEE, ULTIMA_CARGA_DATOBANCA, idRelacion
		) values (
		'".$P_TIPO_DE_MONEDA_1."', '".$P_INSTITUCION_FINANCIERA_1."', '".$P_NUMERO_DE_CUENTA_DB_1."',
		'".$P_NUMERO_CLABE_1."', '".$P_NUMERO_DE_SUCURSAL_1."', '".$P_NUMERO_IBAN_1."',
		'".$P_NUMERO_CUENTA_SWIFT_1."', '".$FOTO_ESTADO_PROVEE."', '".$ULTIMA_CARGA_DATOBANCA."', '".$session."');";

		if($ENVIARRdatosbancario1p == 'ENVIARRdatosbancario1p'){
			mysqli_query($conn,$var1) or die('P156'.mysqli_error($conn));
			$this->registrar_bitacora_sb('actualizar', 'Se actualizó un registro en 02DATOSBANCARIOS1', $IPdatosbancario1p, '02DATOSBANCARIOS1');
			return "Actualizado";
		}else{
			mysqli_query($conn,$var2) or die('P160'.mysqli_error($conn));
			$nuevo_id = mysqli_insert_id($conn);
			$this->registrar_bitacora_sb('crear', '', $nuevo_id, '02DATOSBANCARIOS1');
			return "Ingresado";
		}
	}

	public function Listado_datos_bancariosPRO(){
		$conn = $this->db();
		return mysqli_query($conn, "select * from 02DATOSBANCARIOS1 where idRelacion = '".$_SESSION['idPROV']."' order by id desc ");
	}

	public function Listado_datos_bancariosPRO2($id){
		$conn = $this->db();
		return mysqli_query($conn, "select * from 02DATOSBANCARIOS1 where id = '".$id."' ");
	}

	public function borra_datos_bancario1($id){
		$conn = $this->db();
		mysqli_query($conn, "delete from 02DATOSBANCARIOS1 where id = '".$id."' ");
		$this->registrar_bitacora_sb('eliminar', 'Se eliminó un registro en 02DATOSBANCARIOS1', $id, '02DATOSBANCARIOS1');
		return "<P style='color:green; font-size:18px;'>ELEMENTO BORRADO</P>";
	}

	public function datos_bancario_default($pasarDID, $pasarD_text){
		$conn    = $this->db();
		$session = isset($_SESSION['idPROV']) ? $_SESSION['idPROV'] : '';
		if($session == ''){ echo "TU SESION HA TERMINADO"; return; }
		mysqli_query($conn, "update 02DATOSBANCARIOS1 set checkbox = 'no' where idRelacion = '".$session."';") or die('p1328'.mysqli_error($conn));
		mysqli_query($conn, "update 02DATOSBANCARIOS1 set checkbox = '".$pasarD_text."' where id = '".$pasarDID."';") or die('p1328'.mysqli_error($conn));
		echo "Actualizado: ".$pasarD_text;
	}

	// ══════════════════════════════════════════════════════════════════════
	//  DOCUMENTOS FISCALES
	// ══════════════════════════════════════════════════════════════════════

	public function variable_documentosfiscales(){
		$conn = $this->db();
		$variablequery = "select * from 02DOCUMENTOSFISCALES where idRelacion = '".$_SESSION['idPROV']."' ";
		$arrayquery = mysqli_query($conn,$variablequery);
		return mysqli_fetch_array($arrayquery, MYSQLI_ASSOC);
	}

	public function documentofiscal($DOCUMENTO_LEGAL, $ADJUNTAR_DOCUMENTO_LEGAL,
		$ADJUNTAR_DOCUMENTO_OBSERVACIONES, $FECHA_ULTIMA_DOCUMEN,
		$validaDOCUMENTOSFISCAL, $IPdocumentosfiscales, $ENVIAFISCAL){

		$conn    = $this->db();
		$session = isset($_SESSION['idPROV']) ? $_SESSION['idPROV'] : '';
		if($session == ''){ echo '<p class="fs-4">NO HAY UN PROVEEDOR SELECCIONADO</p>'; return; }

		$var1 = "update 02DOCUMENTOSFISCALES set
		DOCUMENTO_LEGAL = '".$DOCUMENTO_LEGAL."',
		ADJUNTAR_DOCUMENTO_OBSERVACIONES = '".$ADJUNTAR_DOCUMENTO_OBSERVACIONES."',
		FECHA_ULTIMA_DOCUMEN = '".$FECHA_ULTIMA_DOCUMEN."'
		where id = '".$IPdocumentosfiscales."';";

		$var2 = "insert into 02DOCUMENTOSFISCALES
		(DOCUMENTO_LEGAL, ADJUNTAR_DOCUMENTO_LEGAL, ADJUNTAR_DOCUMENTO_OBSERVACIONES, FECHA_ULTIMA_DOCUMEN, idRelacion)
		values ('".$DOCUMENTO_LEGAL."', '".$ADJUNTAR_DOCUMENTO_LEGAL."', '".$ADJUNTAR_DOCUMENTO_OBSERVACIONES."', '".$FECHA_ULTIMA_DOCUMEN."', '".$session."');";

		if($ENVIAFISCAL == 'ENVIAFISCAL'){
			mysqli_query($conn,$var1) or die('P156'.mysqli_error($conn));
			$this->registrar_bitacora_sb('actualizar', 'Se actualizó un registro en 02DOCUMENTOSFISCALES', $IPdocumentosfiscales, '02DOCUMENTOSFISCALES');
			return "Actualizado";
		}else{
			mysqli_query($conn,$var2) or die('P160'.mysqli_error($conn));
			$nuevo_id = mysqli_insert_id($conn);
			$this->registrar_bitacora_sb('crear', '', $nuevo_id, '02DOCUMENTOSFISCALES');
			return "Ingresado";
		}
	}

	public function listadoDOCUMENTOSFISCALES(){
		$conn = $this->db();
		return mysqli_query($conn, "select * from 02DOCUMENTOSFISCALES where idRelacion = '".$_SESSION['idPROV']."' order by id desc ");
	}

	public function listadoDOCUMENTOSFISCALES2($id){
		$conn = $this->db();
		return mysqli_query($conn, "select * from 02DOCUMENTOSFISCALES where id = '".$id."' ");
	}

	public function borradocufiscal($id){
		$conn = $this->db();
		mysqli_query($conn, "delete from 02DOCUMENTOSFISCALES where id = '".$id."' ");
		$this->registrar_bitacora_sb('eliminar', 'Se eliminó un registro en 02DOCUMENTOSFISCALES', $id, '02DOCUMENTOSFISCALES');
		return "<P style='color:green; font-size:25px;'>ELEMENTO BORRADO</P>";
	}

	public function listado_empresas1a(){
		$conn = $this->db();
		return mysqli_query($conn, "select * from 03datosdelaempresa order by id desc");
	}

	public function descargar_documentos($NUMERO_EMPRESA, $documento_legal){
		$conn = $this->db();
		$query = "SELECT * FROM `03DOCUMENTOSFISCALES` WHERE idRelacion = '".$NUMERO_EMPRESA."' AND DOCUMENTO_LEGAL = '".$documento_legal."' ORDER BY FECHA_ULTIMA_DOCUMEN DESC LIMIT 1;";
		$query1 = mysqli_query($conn,$query);
		return mysqli_fetch_array($query1);
	}

	// ══════════════════════════════════════════════════════════════════════
	//  NUEVO DOCUMENTO
	// ══════════════════════════════════════════════════════════════════════

	public function variable_nuevodocumentotodos(){
		$conn = $this->db();
		return mysqli_query($conn, "select * from 02NUEVODOCUMENTO order by id desc");
	}

	public function variable_nuevodocumento(){
		$conn = $this->db();
		$variablequery = "select * from 02NUEVODOCUMENTO where idRelacion = '".$_SESSION['idPROV']."' ";
		$arrayquery = mysqli_query($conn,$variablequery);
		return mysqli_fetch_array($arrayquery, MYSQLI_ASSOC);
	}

	public function nuevodocumento($nuevo_documento, $DOCUMENTO_FISCAL, $enviarnuevo_FISCAL, $IPnuevodocumento){
		$conn    = $this->db();
		$session = isset($_SESSION['idPROV']) ? $_SESSION['idPROV'] : '';
		if($session == ''){ echo '<p class="fs-4">NO HAY UN PROVEEDOR SELECCIONADO</p>'; return; }

		$var1 = "update 02NUEVODOCUMENTO set nuevo_documento = '".$nuevo_documento."', DOCUMENTO_FISCAL = '".$DOCUMENTO_FISCAL."' where id = '".$IPnuevodocumento."';";
		$var2 = "insert into 02NUEVODOCUMENTO (nuevo_documento, DOCUMENTO_FISCAL, idRelacion) values ('".$nuevo_documento."', '".$DOCUMENTO_FISCAL."', '".$session."');";

		if($enviarnuevo_FISCAL == 'enviarnuevo_FISCAL'){
			mysqli_query($conn,$var1) or die('P156'.mysqli_error($conn));
			return "Actualizado";
		}else{
			mysqli_query($conn,$var2) or die('P160'.mysqli_error($conn));
			return "Ingresado";
		}
	}

	public function listadoNUEVODOCUMENTO(){
		$conn = $this->db();
		return mysqli_query($conn, "select * from 02NUEVODOCUMENTO order by id desc ");
	}

	public function listadoNUEVODOCUMENTO2($id){
		$conn = $this->db();
		return mysqli_query($conn, "select * from 02NUEVODOCUMENTO where id = '".$id."' ");
	}

	public function BORRARNUEVOFISCAL($id){
		$conn = $this->db();
		mysqli_query($conn, "delete from 02NUEVODOCUMENTO where id = '".$id."' ");
		return "<P style='color:green; font-size:25px;'>ELEMENTO BORRADO</P>";
	}

	// ══════════════════════════════════════════════════════════════════════
	//  NOTAS
	// ══════════════════════════════════════════════════════════════════════

	public function NOTAS($DOCUMENTO_NOTAS, $ADJUNTO_NOTAS, $OBSERVACIONES_NOTAS,
		$FECHA_NOTAS, $hNOTAS, $IpNOTAS, $enviarNOTAS){

		$conn    = $this->db();
		$session = isset($_SESSION['id']) ? $_SESSION['id'] : '';
		if($session == ''){ echo "TU SESIÓN HA TERMINADO"; return; }

		$var1 = "update 02NOTAS set
		DOCUMENTO_NOTAS = '".$DOCUMENTO_NOTAS."',
		ADJUNTO_NOTAS = '".$ADJUNTO_NOTAS."',
		OBSERVACIONES_NOTAS = '".$OBSERVACIONES_NOTAS."',
		hNOTAS = '".$hNOTAS."'
		where id = '".$IpNOTAS."';";

		$var2 = "insert into 02NOTAS
		(DOCUMENTO_NOTAS, ADJUNTO_NOTAS, OBSERVACIONES_NOTAS, FECHA_NOTAS, hNOTAS, idRelacion)
		values ('".$DOCUMENTO_NOTAS."', '".$ADJUNTO_NOTAS."', '".$OBSERVACIONES_NOTAS."', '".$FECHA_NOTAS."', '".$hNOTAS."', '".$session."');";

		if($enviarNOTAS == 'enviarNOTAS'){
			mysqli_query($conn,$var1) or die('P156'.mysqli_error($conn));
			$this->registrar_bitacora_sb('actualizar', 'Se actualizó un registro en 02NOTAS', $IpNOTAS, '02NOTAS');
			return "Actualizado";
		}else{
			mysqli_query($conn,$var2) or die('P160'.mysqli_error($conn));
			$nuevo_id = mysqli_insert_id($conn);
			$this->registrar_bitacora_sb('crear', '', $nuevo_id, '02NOTAS');
			return "Ingresado";
		}
	}

	public function Listado_NOTAS(){
		$conn = $this->db();
		return mysqli_query($conn, "select * from 02NOTAS order by id desc ");
	}

}
?>
