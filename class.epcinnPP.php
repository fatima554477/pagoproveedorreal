<?php
/*
clase EPC INNOVA
CREADO : 10/mayo/2023
fecha sandor: 
fecha fatis : 07/04/2024

*/

    define('__ROOT3__', dirname(dirname(__FILE__)));
    require __ROOT3__."/includes/class.epcinn.php";


class accesoclase extends colaboradores {


    private function inicializar_tablas_auxiliares() {
        $flagKey = '__tablas_pp_inicializadas__';
        if (!empty($_SESSION[$flagKey])) {
            return; 
        }

        $conn = $this->db();

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

        mysqli_query($conn, "CREATE TABLE IF NOT EXISTS `02SUBETUFACTURA_RECHAZOS` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `id_subetufactura` int(11) NOT NULL,
            `motivo_rechazo` text,
            `usuario_registro` varchar(255) DEFAULT NULL,
            `fecha_registro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE KEY `uniq_subetufactura` (`id_subetufactura`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $_SESSION[$flagKey] = true;
    }


    private function nombre_usuario_bitacora() {
        foreach (['NOMBREUSUARIO', 'nombreusuario', 'usuario'] as $key) {
            if (!empty($_SESSION[$key])) return $_SESSION[$key];
        }
        if (!empty($_SESSION['idem'])) return 'ID:' . $_SESSION['idem'];
        return 'SIN_USUARIO';
    }

    private function registrar_bitacora($conn, $idcomprobacion, $tipoMovimiento, $detalle, $nombreQuienIngreso = '', $nombreQuienActualizo = '') {
        $this->inicializar_tablas_auxiliares(); 

        $idcomprobacion      = intval($idcomprobacion);
        $tipoMovimiento      = mysqli_real_escape_string($conn, $tipoMovimiento);
        $detalle             = mysqli_real_escape_string($conn, $detalle);
        $nombreQuienIngreso  = mysqli_real_escape_string($conn, $nombreQuienIngreso);
        $nombreQuienActualizo = mysqli_real_escape_string($conn, $nombreQuienActualizo);

        mysqli_query($conn, "INSERT INTO 02SUBETUFACTURA_BITACORA
            (id_subetufactura, tipo_movimiento, detalle, fecha_hora, nombre_quien_ingreso, nombre_quien_actualizo)
            VALUES
            ('{$idcomprobacion}', '{$tipoMovimiento}', '{$detalle}', NOW(), '{$nombreQuienIngreso}', '{$nombreQuienActualizo}')");
    }

    private function valor_actual_campo_subetufactura($conn, $idcomprobacion, $campo) {
        $camposPermitidos = [
            'STATUS_RESPONSABLE_EVENTO', 'STATUS_DE_PAGO', 'STATUS_AUDITORIA3',
            'STATUS_SINXML', 'STATUS_CHECKBOX', 'STATUS_AUDITORIA2',
            'STATUS_RECHAZADO', 'STATUS_FINANZAS', 'STATUS_VENTAS'
        ];
        if (!in_array($campo, $camposPermitidos)) return '';

        $idcomprobacion = intval($idcomprobacion);
        $query = mysqli_query($conn, "SELECT {$campo} AS valor FROM 02SUBETUFACTURA WHERE id = '{$idcomprobacion}' LIMIT 1");
        if ($query) {
            $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
            if ($row && isset($row['valor'])) return $row['valor'];
        }
        return '';
    }

    private function registrar_cambio_estado_detallado($conn, $idcomprobacion, $campo, $valorAnterior, $valorNuevo, $descripcion = '') {
        $detalle = 'Se actualizó ' . $this->etiqueta_bitacora_campo($campo) . ' de "' . $valorAnterior . '" a "' . $valorNuevo . '".';
        if ($descripcion != '') $detalle .= ' ' . $descripcion;
        $this->registrar_bitacora($conn, $idcomprobacion, 'ACTUALIZACION', $detalle, '', $this->nombre_usuario_bitacora());
    }

    private function etiqueta_bitacora_campo($campo) {
        $etiquetas = [
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
        ];
        return isset($etiquetas[$campo]) ? $etiquetas[$campo] : str_replace('_', ' ', $campo);
    }

public function registrar_bitacora_adjuntos($idcomprobacion, $tipoAdjunto, $nombreArchivo) {
    $conn = $this->db();

    $idcomprobacion = intval($idcomprobacion);
    $tipoAdjunto    = trim($tipoAdjunto);
    $nombreArchivo  = trim($nombreArchivo);

    if ($idcomprobacion <= 0 || $tipoAdjunto == '') {
        return;
    }

    $tipoLegible = $this->nombre_legible_adjunto($tipoAdjunto);

    $detalle = 'Se subió archivo ' . $tipoLegible;

    if ($nombreArchivo != '') {
        $detalle .= ': ' . $nombreArchivo;
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

private function nombre_legible_adjunto($tipo) {
    $map = [
        'ADJUNTAR_FACTURA_XML'              => 'FACTURA XML',
        'ADJUNTAR_FACTURA_PDF'              => 'FACTURA PDF',
        'ADJUNTAR_COTIZACION'               => 'COTIZACIÓN',
        'CONPROBANTE_TRANSFERENCIA'         => 'COMPROBANTE DE TRANSFERENCIA',
        'ADJUNTAR_ARCHIVO_1'                => 'ARCHIVO ADICIONAL',
        'FOTO_ESTADO_PROVEE11'              => 'ESTADO DE CUENTA DEL PROVEEDOR',
        'COMPLEMENTOS_PAGO_PDF'             => 'COMPLEMENTO DE PAGO PDF',
        'COMPLEMENTOS_PAGO_XML'             => 'COMPLEMENTO DE PAGO XML',
        'CANCELACIONES_PDF'                 => 'CANCELACIÓN PDF',
        'CANCELACIONES_XML'                 => 'CANCELACIÓN XML',
        'ADJUNTAR_FACTURA_DE_COMISION_PDF'  => 'FACTURA DE COMISIÓN PDF',
        'ADJUNTAR_FACTURA_DE_COMISION_XML'  => 'FACTURA DE COMISIÓN XML',
        'CALCULO_DE_COMISION'               => 'CÁLCULO DE COMISIÓN',
        'COMPROBANTE_DE_DEVOLUCION'         => 'COMPROBANTE DE DEVOLUCIÓN',
        'NOTA_DE_CREDITO_COMPRA'            => 'NOTA DE CRÉDITO DE COMPRA',
    ];

    return isset($map[$tipo]) ? $map[$tipo] : str_replace('_', ' ', $tipo);
}



    public function guardar_motivo_rechazo($idcomprobacion, $motivoRechazo) {
        $conn = $this->db();
        if (empty($_SESSION['idem'])) return "Sesion_invalida";

        $idcomprobacion = intval($idcomprobacion);
        $motivoRechazo  = trim($motivoRechazo);
        if ($idcomprobacion <= 0 || $motivoRechazo == '') return "Datos_invalidos";

        $this->inicializar_tablas_auxiliares();

        $motivoEscapado = mysqli_real_escape_string($conn, $motivoRechazo);
        $usuario        = mysqli_real_escape_string($conn, $this->nombre_usuario_bitacora());

        mysqli_query($conn, "INSERT INTO 02SUBETUFACTURA_RECHAZOS (id_subetufactura, motivo_rechazo, usuario_registro, fecha_registro)
            VALUES ('{$idcomprobacion}', '{$motivoEscapado}', '{$usuario}', NOW())
            ON DUPLICATE KEY UPDATE motivo_rechazo = VALUES(motivo_rechazo), usuario_registro = VALUES(usuario_registro), fecha_registro = NOW()")
            or die('P156' . mysqli_error($conn));

        $this->registrar_bitacora($conn, $idcomprobacion, 'RECHAZO', 'Se registró motivo de rechazo: "' . $motivoRechazo . '".', '', $this->nombre_usuario_bitacora());
        return "ok";
    }

    public function obtener_motivo_rechazo($idcomprobacion) {
        $conn = $this->db();
        $idcomprobacion = intval($idcomprobacion);
        if ($idcomprobacion <= 0) return '';

        $this->inicializar_tablas_auxiliares();

        $query = mysqli_query($conn, "SELECT motivo_rechazo FROM 02SUBETUFACTURA_RECHAZOS WHERE id_subetufactura = '{$idcomprobacion}' LIMIT 1");
        if ($query) {
            $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
            if ($row && isset($row['motivo_rechazo'])) return $row['motivo_rechazo'];
        }
        return '';
    }


    public function var_altaeventos() {
        $conn = $this->db();
        $query = mysqli_query($conn, "SELECT * FROM 04altaeventos WHERE id = '" . $_SESSION['idevento'] . "'");
        return mysqli_fetch_array($query, MYSQLI_ASSOC);
    }

    public function buscarNOMBRECOMERCIAL($filtro) {
        $conn    = $this->db();
        $filtro  = mysqli_real_escape_string($conn, $filtro);
        $query   = mysqli_query($conn, "SELECT * FROM 02usuarios WHERE nommbrerazon LIKE '%{$filtro}%' LIMIT 20");
        $result  = [];
        while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
            $result[] = ['id' => $row['id'], 'text' => $row['nommbrerazon']];
        }
        return $result;
    }

    public function buscarrasonsocial($filtro) {
        $conn  = $this->db();
        $filtro = mysqli_real_escape_string($conn, $filtro);
        $query = mysqli_query($conn, "SELECT * FROM 02direccionproveedor1 WHERE idRelacion = '{$filtro}'");
        $row   = mysqli_fetch_array($query, MYSQLI_ASSOC);
        return $row['P_NOMBRE_FISCAL_RS_EMPRESA'] . '^^^' . $row['P_RFC_MTDP'];
    }

    public function buscarnumero($filtro) {
        $conn   = $this->db();
        $filtro = mysqli_real_escape_string($conn, $filtro);
        $query  = mysqli_query($conn, "SELECT * FROM 04NUMEROevento WHERE NUMERO_DE_EVENTO LIKE '%{$filtro}%'");
        $result = [];
        while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
            $result[] = $row['NUMERO_DE_EVENTO'];
        }
        return $result;
    }

    public function listadoEventos() {
        $conn = $this->db();
        return mysqli_query($conn, "SELECT NUMERO_EVENTO, NOMBRE_EVENTO FROM 04altaeventos ORDER BY NUMERO_EVENTO");
    }

    public function solocargartemp($archivo) {
        $nombre_carpeta = __ROOT3__ . '/includes/archivos';
        $nombretemp     = $_FILES[$archivo]["tmp_name"];
        $nombrearchivo  = $_FILES[$archivo]["name"];
        $extension      = explode('.', $nombrearchivo);
        $cuenta         = count($extension) - 1;
        $ext            = strtolower($extension[$cuenta]);
        $nuevonombre    = $archivo . '_' . date('Y_m_d_h_i_s') . '.' . $ext;

        $permitidos = ['pdf', 'gif', 'jpeg', 'jpg', 'png', 'mp4', 'docx', 'doc', 'xml'];
        if (!in_array($ext, $permitidos)) return "2";

        if (move_uploaded_file($nombretemp, $nombre_carpeta . '/' . $nuevonombre)) {
            chmod($nombre_carpeta . '/' . $nuevonombre, 0755);
            return trim($nuevonombre);
        }
        return "1";
    }

    public function pendiente_pago($total_menos_depositado, $NUMERO_EVENTO) {
        $total_menos_depositado = str_replace(',', '', $total_menos_depositado);
        $conn    = $this->db();
        $NUMERO_EVENTO = mysqli_real_escape_string($conn, $NUMERO_EVENTO);
        $query   = mysqli_query($conn, "SELECT MONTO_DEPOSITADO FROM 02SUBETUFACTURA WHERE NUMERO_EVENTO = '{$NUMERO_EVENTO}'");
        $suma    = 0;
        while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
            $suma += $row['MONTO_DEPOSITADO'];
        }
        return $total_menos_depositado - $suma;
    }

    public function buscarnombre($filtro) {
        $conn   = $this->db();
        $filtro = mysqli_real_escape_string($conn, $filtro);
        $query  = mysqli_query($conn, "SELECT NOMBRE_EVENTO FROM 04altaeventos WHERE NUMERO_EVENTO = '{$filtro}'");
        $row    = mysqli_fetch_array($query, MYSQLI_ASSOC);
        return isset($row['NOMBRE_EVENTO']) ? $row['NOMBRE_EVENTO'] : '';
    }

    public function buscarciudad($filtro) {
        $conn   = $this->db();
        $filtro = mysqli_real_escape_string($conn, $filtro);
        $query  = mysqli_query($conn, "SELECT CIUDAD_DEL_EVENTO FROM 04altaeventos WHERE NUMERO_EVENTO = '{$filtro}'");
        $row    = mysqli_fetch_array($query, MYSQLI_ASSOC);
        return isset($row['CIUDAD_DEL_EVENTO']) ? $row['CIUDAD_DEL_EVENTO'] : '';
    }

    public function variable_DIRECCIONP1() {
        $conn  = $this->db();
        $query = mysqli_query($conn, "SELECT * FROM 02direccionproveedor1 WHERE idRelacion = '" . $_SESSION['idPROV'] . "'");
        return mysqli_fetch_array($query, MYSQLI_ASSOC);
    }

public function variable_SUBETUFACTURA() {
    $conn = $this->db();
    if (empty($_SESSION['idPROV'])) return [];
    
    // Verificar que el documento temporal pertenece al usuario activo
    $idem = intval($_SESSION['idem']);
    $query = mysqli_query($conn, 
        "SELECT * FROM 02SUBETUFACTURADOCTOS 
         WHERE idRelacion = '" . $_SESSION['idPROV'] . "' 
         AND idRelacionU = '{$idem}'   -- <-- agregar esta validación
         AND idTemporal = 'si' 
         AND (ADJUNTAR_FACTURA_XML IS NOT NULL OR ADJUNTAR_FACTURA_XML <> '') 
         ORDER BY id DESC"
    );
    return mysqli_fetch_array($query, MYSQLI_ASSOC);
}

    public function variable_SUBETUFACTURA2($id12) {
        $conn  = $this->db();
        $id12  = mysqli_real_escape_string($conn, $id12);
        $query = mysqli_query($conn, "SELECT * FROM 02SUBETUFACTURADOCTOS WHERE idRelacion = '{$id12}' AND idTemporal = 'si' AND (ADJUNTAR_FACTURA_XML IS NOT NULL OR ADJUNTAR_FACTURA_XML <> '') ORDER BY id DESC");
        return mysqli_fetch_array($query, MYSQLI_ASSOC);
    }

    public function revisar_pagoproveedor() {
        $conn  = $this->db();
        $query = mysqli_query($conn, "SELECT id FROM 02SUBETUFACTURA WHERE idRelacion = '" . $_SESSION['idPROV'] . "'") or die('P44' . mysqli_error($conn));
        $row   = mysqli_fetch_array($query, MYSQLI_ASSOC);
        return $row['id'];
    }

    public function revisar_pagoproveedor2($id) {
        $conn  = $this->db();
        $id    = intval($id);
        $query = mysqli_query($conn, "SELECT id FROM 02SUBETUFACTURA WHERE id = '{$id}'") or die('P44' . mysqli_error($conn));
        $row   = mysqli_fetch_array($query, MYSQLI_ASSOC);
        return $row['id'];
    }

    public function busca_02XML($ultimo_id) {
        $conn  = $this->db();
        $query = mysqli_query($conn, "SELECT * FROM 02XML WHERE ultimo_id = '{$ultimo_id}'");
        return mysqli_fetch_array($query, MYSQLI_ASSOC);
    }

    public function busca_07XML2($ultimo_id, $tabla) {
        $conn  = $this->db();
        $query = mysqli_query($conn, "SELECT * FROM {$tabla} WHERE ultimo_id = '{$ultimo_id}'");
        return mysqli_fetch_array($query, MYSQLI_ASSOC);
    }

 
    public function ActualizaxmlDB($FechaTimbrado, $tipoDeComprobante,
        $metodoDePago, $formaDePago, $condicionesDePago, $subTotal,
        $TipoCambio, $Moneda, $total, $serie,
        $folio, $LugarExpedicion, $rfcE, $nombreE,
        $regimenE, $rfcR, $nombreR, $UsoCFDI,
        $DomicilioFiscalReceptor, $RegimenFiscalReceptor, $UUID, $TImpuestosRetenidos,
        $TImpuestosTrasladados, $session, $ultimo_id, $TuaTotalCargos, $TUA, $Descuento, $Propina, $conn, $actualiza, $DescripcionConcepto) {

        if ($actualiza !== 'true') return;

        $row = $this->busca_02XML($ultimo_id);
        $existe = ($row['ultimo_id'] != 0 && $row['ultimo_id'] != '');

        $campos = "`Version`='no',`fechaTimbrado`='{$FechaTimbrado}',`tipoDeComprobante`='{$tipoDeComprobante}',
            `metodoDePago`='{$metodoDePago}',`formaDePago`='{$formaDePago}',`condicionesDePago`='{$condicionesDePago}',
            `subTotal`='{$subTotal}',`TipoCambio`='{$TipoCambio}',`Moneda`='{$Moneda}',`totalf`='{$total}',
            `serie`='{$serie}',`folio`='{$folio}',`LugarExpedicion`='{$LugarExpedicion}',
            `rfcE`='{$rfcE}',`nombreE`='{$nombreE}',`regimenE`='{$regimenE}',
            `rfcR`='{$rfcR}',`nombreR`='{$nombreR}',`UsoCFDI`='{$UsoCFDI}',
            `DomicilioFiscalReceptor`='{$DomicilioFiscalReceptor}',`RegimenFiscalReceptor`='{$RegimenFiscalReceptor}',
            `UUID`='{$UUID}',`TuaTotalCargos`='{$TuaTotalCargos}',`TUA`='{$TUA}',
            `Propina`='{$Propina}',`Descuento`='{$Descuento}',
            `TImpuestosRetenidos`='{$TImpuestosRetenidos}',`TImpuestosTrasladados`='{$TImpuestosTrasladados}',
            DescripcionConcepto='{$DescripcionConcepto}'";

        if ($existe) {
            mysqli_query($conn, "UPDATE `02XML` SET {$campos} WHERE `ultimo_id`='{$ultimo_id}'") or die('P352' . mysqli_error($conn));
        } else {
            mysqli_query($conn, "INSERT INTO `02XML` (`id`,`Version`,`fechaTimbrado`,`tipoDeComprobante`,
                `metodoDePago`,`formaDePago`,`condicionesDePago`,`subTotal`,`TipoCambio`,`Moneda`,`totalf`,
                `serie`,`folio`,`LugarExpedicion`,`rfcE`,`nombreE`,`regimenE`,`rfcR`,`nombreR`,`UsoCFDI`,
                `DomicilioFiscalReceptor`,`RegimenFiscalReceptor`,`UUID`,`TImpuestosRetenidos`,
                `TImpuestosTrasladados`,`idRelacion`,`ultimo_id`,`TuaTotalCargos`,Descuento,`TUA`,`Propina`,DescripcionConcepto)
                VALUES ('','no','{$FechaTimbrado}','{$tipoDeComprobante}','{$metodoDePago}','{$formaDePago}',
                '{$condicionesDePago}','{$subTotal}','{$TipoCambio}','{$Moneda}','{$total}','{$serie}','{$folio}',
                '{$LugarExpedicion}','{$rfcE}','{$nombreE}','{$regimenE}','{$rfcR}','{$nombreR}','{$UsoCFDI}',
                '{$DomicilioFiscalReceptor}','{$RegimenFiscalReceptor}','{$UUID}','{$TImpuestosRetenidos}',
                '{$TImpuestosTrasladados}','{$session}','{$ultimo_id}','{$TuaTotalCargos}','{$Descuento}',
                '{$TUA}','{$Propina}','{$DescripcionConcepto}')") or die('P350' . mysqli_error($conn));
        }
    }

    public function guardarxmlDB($ultimo_id, $conn) {
        $conexion2 = new herramientas();
        $regreso   = $this->variable_SUBETUFACTURA();
        $url       = __ROOT3__ . '/includes/archivos/' . $regreso['ADJUNTAR_FACTURA_XML'];
        $session   = isset($_SESSION['idPROV']) ? $_SESSION['idPROV'] : '';
        $conexion2->guardar_db_xml($url, $session, $ultimo_id, $conn);
    }


    public function guardarxmlDB2($ultimo_id, $session, $tabla, $url, $datosXml = null) {
        $conn = $this->db();


        if ($datosXml === null) {
            if (!file_exists($url)) return;
            $conexion2 = new herramientas();
            $datosXml  = $conexion2->lectorxml($url);
        }

        if (empty($datosXml) || !isset($datosXml['UUID']) || trim($datosXml['UUID']) === '') return;

        $regreso = $datosXml;

        // Extraer campos
        $Version              = $regreso['Version'];
        $FechaTimbrado        = $regreso['FechaTimbrado'];
        $tipoDeComprobante    = $regreso['tipoDeComprobante'];
        $metodoDePago         = $regreso['metodoDePago'];
        $formaDePago          = $regreso['formaDePago'];
        $condicionesDePago    = $regreso['condicionesDePago'];
        $subTotal             = $regreso['subTotal'];
        $TipoCambio           = $regreso['TipoCambio'];
        $Moneda               = $regreso['Moneda'];
        $Descuento            = $regreso['Descuento'];
        $total                = $regreso['total'];
        $serie                = $regreso['serie'];
        $folio                = $regreso['folio'];
        $LugarExpedicion      = $regreso['LugarExpedicion'];
        $DescripcionConcepto  = $regreso['DescripcionConcepto'];
        $rfcE                 = $regreso['rfcE'];
        $nombreE              = $regreso['nombreE'];
        $regimenE             = $regreso['regimenE'];
        $rfcR                 = $regreso['rfcR'];
        $nombreR              = $regreso['nombreR'];
        $UsoCFDI              = $regreso['UsoCFDI'];
        $DomicilioFiscalReceptor  = $regreso['DomicilioFiscalReceptor'];
        $RegimenFiscalReceptor    = $regreso['RegimenFiscalReceptor'];
        $UUID                 = $regreso['UUID'];
        $TImpuestosRetenidos  = $regreso['TImpuestosRetenidos'];
        $TImpuestosTrasladados = $regreso['TImpuestosTrasladados'];
        $Cantidad             = $regreso['Cantidad'];
        $ValorUnitario        = $regreso['ValorUnitario'];
        $Importe              = $regreso['Importe'];
        $ClaveProdServ        = $regreso['ClaveProdServ'];
        $Unidad               = $regreso['Unidad'];
        $Descripcion          = $regreso['Descripcion'];
        $ClaveUnidad          = $regreso['ClaveUnidad'];
        $NoIdentificacion     = $regreso['NoIdentificacion'];
        $TuaTotalCargos       = isset($regreso['TuaTotalCargos']) ? $regreso['TuaTotalCargos'] : '';
        $TUA                  = isset($regreso['TUA']) ? $regreso['TUA'] : '';
        $Propina              = isset($regreso['Propina']) ? $regreso['Propina'] : '';

        $this->actualizar_forma_pago($ultimo_id, $formaDePago);
				$nombreE                  = mysqli_real_escape_string($conn, $nombreE);

        $camposComunes = "`Version`='{$Version}',`fechaTimbrado`='{$FechaTimbrado}',`tipoDeComprobante`='{$tipoDeComprobante}',
            `metodoDePago`='{$metodoDePago}',`formaDePago`='{$formaDePago}',`condicionesDePago`='{$condicionesDePago}',
            `subTotal`='{$subTotal}',`TipoCambio`='{$TipoCambio}',`Moneda`='{$Moneda}',`totalf`='{$total}',
            `serie`='{$serie}',`folio`='{$folio}',`LugarExpedicion`='{$LugarExpedicion}',
            `rfcE`='{$rfcE}',`nombreE`='{$nombreE}',`regimenE`='{$regimenE}',
            `rfcR`='{$rfcR}',`nombreR`='{$nombreR}',`UsoCFDI`='{$UsoCFDI}',
            `DomicilioFiscalReceptor`='{$DomicilioFiscalReceptor}',`RegimenFiscalReceptor`='{$RegimenFiscalReceptor}',
            `UUID`='{$UUID}',`TuaTotalCargos`='{$TuaTotalCargos}',`TUA`='{$TUA}',
            `Propina`='{$Propina}',`Descuento`='{$Descuento}',
            CantidadConcepto='{$Cantidad}',ValorUnitarioConcepto='{$ValorUnitario}',ImporteConcepto='{$Importe}',
            ClaveProdServConcepto='{$ClaveProdServ}',UnidadConcepto='{$Unidad}',DescripcionConcepto='{$Descripcion}',
            ClaveUnidadConcepto='{$ClaveUnidad}',NoIdentificacionConcepto='{$NoIdentificacion}',
            `TImpuestosRetenidos`='{$TImpuestosRetenidos}',`TImpuestosTrasladados`='{$TImpuestosTrasladados}'";

        $rowXml = $this->busca_07XML2($ultimo_id, $tabla);

        if ($rowXml['ultimo_id'] == 0 || $rowXml['ultimo_id'] == '') {
            mysqli_query($conn, "INSERT INTO {$tabla} (`id`,`Version`,`fechaTimbrado`,`tipoDeComprobante`,
                `metodoDePago`,`formaDePago`,`condicionesDePago`,`subTotal`,`TipoCambio`,`Moneda`,`totalf`,
                `serie`,`folio`,`LugarExpedicion`,`rfcE`,`nombreE`,`regimenE`,`rfcR`,`nombreR`,`UsoCFDI`,
                `DomicilioFiscalReceptor`,`RegimenFiscalReceptor`,`UUID`,`TImpuestosRetenidos`,
                `TImpuestosTrasladados`,`idRelacion`,`ultimo_id`,`TuaTotalCargos`,Descuento,`TUA`,`Propina`,
                CantidadConcepto,ValorUnitarioConcepto,ImporteConcepto,ClaveProdServConcepto,UnidadConcepto,
                DescripcionConcepto,ClaveUnidadConcepto,NoIdentificacionConcepto)
                VALUES ('','{$Version}','{$FechaTimbrado}','{$tipoDeComprobante}','{$metodoDePago}','{$formaDePago}',
                '{$condicionesDePago}','{$subTotal}','{$TipoCambio}','{$Moneda}','{$total}','{$serie}','{$folio}',
                '{$LugarExpedicion}','{$rfcE}','{$nombreE}','{$regimenE}','{$rfcR}','{$nombreR}','{$UsoCFDI}',
                '{$DomicilioFiscalReceptor}','{$RegimenFiscalReceptor}','{$UUID}','{$TImpuestosRetenidos}',
                '{$TImpuestosTrasladados}','{$session}','{$ultimo_id}','{$TuaTotalCargos}','{$Descuento}',
                '{$TUA}','{$Propina}','{$Cantidad}','{$ValorUnitario}','{$Importe}','{$ClaveProdServ}',
                '{$Unidad}','{$Descripcion}','{$ClaveUnidad}','{$NoIdentificacion}')") or die('P350' . mysqli_error($conn));
            echo "Ingresado";
        } else {
            mysqli_query($conn, "UPDATE {$tabla} SET {$camposComunes} WHERE `ultimo_id`='{$ultimo_id}'") or die('P352' . mysqli_error($conn));
            echo "Actualizado";
        }
    }

    public function actualizar_forma_pago($id, $formaDePago) {
        if ($id == '' || $formaDePago == '') return false;
        $conn = $this->db();
        return mysqli_query($conn, "UPDATE 02SUBETUFACTURA SET PFORMADE_PAGO='{$formaDePago}' WHERE id='{$id}'");
    }

    public function listado3() {
        $conn = $this->db();
        return mysqli_query($conn, "SELECT *,02usuarios.id AS IDDD FROM 02usuarios LEFT JOIN 02direccionproveedor1 ON 02usuarios.id = 02direccionproveedor1.idRelacion ORDER BY nommbrerazon ASC");
    }


    public function verificar_rfc($conn, $RFC_PROVEEDOR) {
        $RFC_PROVEEDOR = mysqli_real_escape_string($conn, $RFC_PROVEEDOR);
        $query = mysqli_query($conn, "SELECT id FROM 02direccionproveedor1 WHERE P_RFC_MTDP='{$RFC_PROVEEDOR}'");
        $row   = mysqli_fetch_array($query, MYSQLI_ASSOC);
        return isset($row['id']) ? $row['id'] : '';
    }

    public function verificar_usuario($conn, $nommbrerazon) {
        $nommbrerazon = mysqli_real_escape_string($conn, $nommbrerazon);
        $query = mysqli_query($conn, "SELECT id FROM 02direccionproveedor1 WHERE P_NOMBRE_FISCAL_RS_EMPRESA='{$nommbrerazon}'");
        $row   = mysqli_fetch_array($query, MYSQLI_ASSOC);
        return isset($row['id']) ? $row['id'] : '';
    }

    public function verificar_usuario_comercial($conn, $nommbrerazon) {
        $nommbrerazon = mysqli_real_escape_string($conn, $nommbrerazon);
        $query = mysqli_query($conn, "SELECT id FROM 02direccionproveedor1 WHERE P_NOMBRE_COMERCIAL_EMPRESA='{$nommbrerazon}'");
        $row   = mysqli_fetch_array($query, MYSQLI_ASSOC);
        return isset($row['id']) ? $row['id'] : '';
    }

    public function ingresar_usuario($conn, $nommbrerazon) {
        $nommbrerazon = mysqli_real_escape_string($conn, $nommbrerazon);
        mysqli_query($conn, "INSERT INTO 02direccionproveedor1 (P_NOMBRE_FISCAL_RS_EMPRESA) VALUES ('{$nommbrerazon}')") or die('P160' . mysqli_error($conn));
        return mysqli_insert_id($conn);
    }

    public function ingresar_rfc($conn, $RFC_PROVEEDOR, $nommbrerazon) {
        $RFC_PROVEEDOR = mysqli_real_escape_string($conn, $RFC_PROVEEDOR);
        $nommbrerazon  = mysqli_real_escape_string($conn, $nommbrerazon);
        $query = mysqli_query($conn, "UPDATE 02direccionproveedor1 SET P_RFC_MTDP='{$RFC_PROVEEDOR}', idRelacion='{$nommbrerazon}' WHERE id='{$nommbrerazon}'");
        return mysqli_fetch_array($query, MYSQLI_ASSOC);
    }


    public function PAGOPRO($NUMERO_CONSECUTIVO_PROVEE, $ID_RELACIONADO, $NOMBRE_COMERCIAL, $RAZON_SOCIAL, $VIATICOSOPRO, $RFC_PROVEEDOR, $NUMERO_EVENTO, $NOMBRE_EVENTO, $MOTIVO_GASTO, $CONCEPTO_PROVEE, $MONTO_TOTAL_COTIZACION_ADEUDO, $MONTO_DEPOSITAR, $MONTO_PROPINA, $PENDIENTE_PAGO, $FECHA_AUTORIZACION_RESPONSABLE, $FECHA_AUTORIZACION_AUDITORIA, $FECHA_DE_LLENADO, $MONTO_FACTURA, $TIPO_DE_MONEDA, $PFORMADE_PAGO, $FECHA_DE_PAGO, $FECHA_A_DEPOSITAR, $STATUS_DE_PAGO, $ACTIVO_FIJO, $GASTO_FIJO, $PAGAR_CADA, $FECHA_PPAGO, $FECHA_TPROGRAPAGO, $NUMERO_EVENTOFIJO, $CLASI_GENERAL, $SUB_GENERAL, $BANCO_ORIGEN, $MONTO_DEPOSITADO, $CLASIFICACION_GENERAL, $CLASIFICACION_ESPECIFICA, $PLACAS_VEHICULO, $MONTO_DE_COMISION, $POLIZA_NUMERO, $NOMBRE_DEL_EJECUTIVO, $NOMBRE_DEL_AYUDO, $OBSERVACIONES_1, $TIPO_CAMBIOP, $TOTAL_ENPESOS, $IMPUESTO_HOSPEDAJE, $TImpuestosRetenidosIVA, $TImpuestosRetenidosISR, $descuentos, $IVA, $ENVIARPAGOprovee, $hiddenpagoproveedores, $IPpagoprovee,
        $FechaTimbrado, $tipoDeComprobante, $metodoDePago, $formaDePago, $condicionesDePago, $subTotal,
        $TipoCambio, $Moneda, $total, $serie, $folio, $LugarExpedicion, $rfcE, $nombreE,
        $regimenE, $rfcR, $nombreR, $UsoCFDI, $DomicilioFiscalReceptor, $RegimenFiscalReceptor,
        $UUID, $TImpuestosRetenidos, $TImpuestosTrasladados, $TuaTotalCargos, $Descuento, $Propina, $TUA, $actualiza, $DescripcionConcepto
    ) {
        // Limpiar montos
        foreach (['MONTO_TOTAL_COTIZACION_ADEUDO','MONTO_DEPOSITAR','MONTO_FACTURA','MONTO_PROPINA',
                  'MONTO_DEPOSITADO','MONTO_DE_COMISION','PENDIENTE_PAGO','TOTAL_ENPESOS',
                  'TIPO_CAMBIOP','TImpuestosRetenidosIVA','TImpuestosRetenidosISR','descuentos','IVA'] as $var) {
            $$var = str_replace(',', '', $$var);
        }

            $conn = $this->db();

    // ESCAPAR TEXTOS

    $NOMBRE_COMERCIAL            = mysqli_real_escape_string($conn, $NOMBRE_COMERCIAL);
    $RAZON_SOCIAL                = mysqli_real_escape_string($conn, $RAZON_SOCIAL);
	$OBSERVACIONES_1             = mysqli_real_escape_string($conn, $OBSERVACIONES_1);

        // Obtener nombre comercial
        $queryNC   = mysqli_query($conn, "SELECT P_NOMBRE_COMERCIAL_EMPRESA FROM 02direccionproveedor1 WHERE idRelacion='{$NOMBRE_COMERCIAL}'") or die('P160' . mysqli_error($conn));
        $rowNC     = mysqli_fetch_array($queryNC, MYSQLI_ASSOC);
        $NOMBRE_COMERCIAL2 = $rowNC['P_NOMBRE_COMERCIAL_EMPRESA'];

        // ── FIX: verificar_rfc llamado UNA sola vez ───────────────────────
        $sessionRFC = $this->verificar_rfc($conn, $RFC_PROVEEDOR);
        if ($sessionRFC != '') {
            $session = $sessionRFC;
        } elseif (($sessionNC = $this->verificar_usuario_comercial($conn, $NOMBRE_COMERCIAL2)) != '') {
            $session = $sessionNC;
        } else {
            $session = 1;
        }
        // ─────────────────────────────────────────────────────────────────

        $existe         = $this->revisar_pagoproveedor2($IPpagoprovee);
        $idRelacionU    = isset($_SESSION['idempermiso']) ? $_SESSION['idempermiso'] : '';
        $idem           = isset($_SESSION['idem']) ? $_SESSION['idem'] : '';
        $usuarioBitacora = $this->nombre_usuario_bitacora();

        if ($idem == '') {
            echo "NO HAY UN PROVEEDOR SELECCIONADO";
            return;
        }

        $var1 = "UPDATE 02SUBETUFACTURA SET
            NUMERO_CONSECUTIVO_PROVEE='{$NUMERO_CONSECUTIVO_PROVEE}',ID_RELACIONADO='{$ID_RELACIONADO}',
            NOMBRE_COMERCIAL='{$NOMBRE_COMERCIAL}',RAZON_SOCIAL='{$RAZON_SOCIAL}',VIATICOSOPRO='{$VIATICOSOPRO}',
            RFC_PROVEEDOR='{$RFC_PROVEEDOR}',NUMERO_EVENTO='{$NUMERO_EVENTO}',NOMBRE_EVENTO='{$NOMBRE_EVENTO}',
            MOTIVO_GASTO='{$MOTIVO_GASTO}',CONCEPTO_PROVEE='{$CONCEPTO_PROVEE}',
            MONTO_TOTAL_COTIZACION_ADEUDO='{$MONTO_TOTAL_COTIZACION_ADEUDO}',MONTO_DEPOSITAR='{$MONTO_DEPOSITAR}',
            MONTO_PROPINA='{$MONTO_PROPINA}',PENDIENTE_PAGO='{$PENDIENTE_PAGO}',
            FECHA_AUTORIZACION_RESPONSABLE='{$FECHA_AUTORIZACION_RESPONSABLE}',
            FECHA_AUTORIZACION_AUDITORIA='{$FECHA_AUTORIZACION_AUDITORIA}',
            FECHA_DE_LLENADO='{$FECHA_DE_LLENADO}',MONTO_FACTURA='{$MONTO_FACTURA}',
            TIPO_DE_MONEDA='{$TIPO_DE_MONEDA}',PFORMADE_PAGO='{$PFORMADE_PAGO}',
            FECHA_DE_PAGO='{$FECHA_DE_PAGO}',FECHA_A_DEPOSITAR='{$FECHA_A_DEPOSITAR}',
            STATUS_DE_PAGO='{$STATUS_DE_PAGO}',ACTIVO_FIJO='{$ACTIVO_FIJO}',GASTO_FIJO='{$GASTO_FIJO}',
            PAGAR_CADA='{$PAGAR_CADA}',FECHA_PPAGO='{$FECHA_PPAGO}',FECHA_TPROGRAPAGO='{$FECHA_TPROGRAPAGO}',
            NUMERO_EVENTOFIJO='{$NUMERO_EVENTOFIJO}',CLASI_GENERAL='{$CLASI_GENERAL}',SUB_GENERAL='{$SUB_GENERAL}',
            BANCO_ORIGEN='{$BANCO_ORIGEN}',MONTO_DEPOSITADO='{$MONTO_DEPOSITADO}',
            CLASIFICACION_GENERAL='{$CLASIFICACION_GENERAL}',CLASIFICACION_ESPECIFICA='{$CLASIFICACION_ESPECIFICA}',
            PLACAS_VEHICULO='{$PLACAS_VEHICULO}',MONTO_DE_COMISION='{$MONTO_DE_COMISION}',
            POLIZA_NUMERO='{$POLIZA_NUMERO}',NOMBRE_DEL_EJECUTIVO='{$NOMBRE_DEL_EJECUTIVO}',
            NOMBRE_DEL_AYUDO='{$NOMBRE_DEL_AYUDO}',OBSERVACIONES_1='{$OBSERVACIONES_1}',
            TIPO_CAMBIOP='{$TIPO_CAMBIOP}',TOTAL_ENPESOS='{$TOTAL_ENPESOS}',
            IMPUESTO_HOSPEDAJE='{$IMPUESTO_HOSPEDAJE}',TImpuestosRetenidosIVA='{$TImpuestosRetenidosIVA}',
            TImpuestosRetenidosISR='{$TImpuestosRetenidosISR}',descuentos='{$descuentos}',IVA='{$IVA}',
            idRelacionU='{$idRelacionU}'
            WHERE id='{$IPpagoprovee}'";

        $var2 = "INSERT INTO 02SUBETUFACTURA (NUMERO_CONSECUTIVO_PROVEE,ID_RELACIONADO,NOMBRE_COMERCIAL,
            RAZON_SOCIAL,VIATICOSOPRO,RFC_PROVEEDOR,NUMERO_EVENTO,NOMBRE_EVENTO,MOTIVO_GASTO,CONCEPTO_PROVEE,
            MONTO_TOTAL_COTIZACION_ADEUDO,MONTO_DEPOSITAR,MONTO_PROPINA,FECHA_AUTORIZACION_RESPONSABLE,
            FECHA_AUTORIZACION_AUDITORIA,FECHA_DE_LLENADO,MONTO_FACTURA,TIPO_DE_MONEDA,PFORMADE_PAGO,
            FECHA_DE_PAGO,FECHA_A_DEPOSITAR,STATUS_DE_PAGO,ACTIVO_FIJO,GASTO_FIJO,PAGAR_CADA,FECHA_PPAGO,
            FECHA_TPROGRAPAGO,NUMERO_EVENTOFIJO,CLASI_GENERAL,SUB_GENERAL,BANCO_ORIGEN,MONTO_DEPOSITADO,
            CLASIFICACION_GENERAL,CLASIFICACION_ESPECIFICA,PLACAS_VEHICULO,MONTO_DE_COMISION,POLIZA_NUMERO,
            NOMBRE_DEL_EJECUTIVO,NOMBRE_DEL_AYUDO,OBSERVACIONES_1,TIPO_CAMBIOP,TOTAL_ENPESOS,
            IMPUESTO_HOSPEDAJE,TImpuestosRetenidosIVA,TImpuestosRetenidosISR,descuentos,IVA,
            PENDIENTE_PAGO,hiddenpagoproveedores,idRelacion,idRelacionU)
            VALUES ('{$NUMERO_CONSECUTIVO_PROVEE}','{$ID_RELACIONADO}','{$NOMBRE_COMERCIAL2}',
            '{$RAZON_SOCIAL}','{$VIATICOSOPRO}','{$RFC_PROVEEDOR}','{$NUMERO_EVENTO}','{$NOMBRE_EVENTO}',
            '{$MOTIVO_GASTO}','{$CONCEPTO_PROVEE}','{$MONTO_TOTAL_COTIZACION_ADEUDO}','{$MONTO_DEPOSITAR}',
            '{$MONTO_PROPINA}','{$FECHA_AUTORIZACION_RESPONSABLE}','{$FECHA_AUTORIZACION_AUDITORIA}',
            '{$FECHA_DE_LLENADO}','{$MONTO_FACTURA}','{$TIPO_DE_MONEDA}','{$PFORMADE_PAGO}',
            '{$FECHA_DE_PAGO}','{$FECHA_A_DEPOSITAR}','{$STATUS_DE_PAGO}','{$ACTIVO_FIJO}','{$GASTO_FIJO}',
            '{$PAGAR_CADA}','{$FECHA_PPAGO}','{$FECHA_TPROGRAPAGO}','{$NUMERO_EVENTOFIJO}','{$CLASI_GENERAL}',
            '{$SUB_GENERAL}','{$BANCO_ORIGEN}','{$MONTO_DEPOSITADO}','{$CLASIFICACION_GENERAL}',
            '{$CLASIFICACION_ESPECIFICA}','{$PLACAS_VEHICULO}','{$MONTO_DE_COMISION}','{$POLIZA_NUMERO}',
            '{$NOMBRE_DEL_EJECUTIVO}','{$NOMBRE_DEL_AYUDO}','{$OBSERVACIONES_1}','{$TIPO_CAMBIOP}',
            '{$TOTAL_ENPESOS}','{$IMPUESTO_HOSPEDAJE}','{$TImpuestosRetenidosIVA}','{$TImpuestosRetenidosISR}',
            '{$descuentos}','{$IVA}','{$PENDIENTE_PAGO}','{$hiddenpagoproveedores}','{$session}','{$idRelacionU}')";

        if ($ENVIARPAGOprovee == 'ENVIARPAGOprovee') {

            $this->ActualizaxmlDB($FechaTimbrado, $tipoDeComprobante, $metodoDePago, $formaDePago,
                $condicionesDePago, $subTotal, $TipoCambio, $Moneda, $total, $serie, $folio,
                $LugarExpedicion, $rfcE, $nombreE, $regimenE, $rfcR, $nombreR, $UsoCFDI,
                $DomicilioFiscalReceptor, $RegimenFiscalReceptor, $UUID, $TImpuestosRetenidos,
                $TImpuestosTrasladados, $session, $existe, $TuaTotalCargos, $TUA, $Descuento, $Propina, $conn, $actualiza, $DescripcionConcepto);

            // Leer valores anteriores para bitácora
            $consultaAnterior = mysqli_query($conn, "SELECT STATUS_DE_PAGO,MONTO_DEPOSITAR,FECHA_DE_PAGO,
                FECHA_A_DEPOSITAR,PFORMADE_PAGO,NUMERO_EVENTO,NOMBRE_EVENTO,NOMBRE_COMERCIAL,RAZON_SOCIAL,
                RFC_PROVEEDOR,MOTIVO_GASTO,CONCEPTO_PROVEE,MONTO_TOTAL_COTIZACION_ADEUDO,MONTO_FACTURA,
                MONTO_PROPINA,TIPO_DE_MONEDA,BANCO_ORIGEN,MONTO_DEPOSITADO,CLASIFICACION_GENERAL,
                CLASIFICACION_ESPECIFICA,MONTO_DE_COMISION,POLIZA_NUMERO,NOMBRE_DEL_EJECUTIVO,
                NOMBRE_DEL_AYUDO,OBSERVACIONES_1,TIPO_CAMBIOP,TOTAL_ENPESOS,IMPUESTO_HOSPEDAJE,
                TImpuestosRetenidosIVA,TImpuestosRetenidosISR,descuentos,IVA,ACTIVO_FIJO,GASTO_FIJO,VIATICOSOPRO
                FROM 02SUBETUFACTURA WHERE id='" . intval($IPpagoprovee) . "' LIMIT 1");
            $registroAnterior = $consultaAnterior ? mysqli_fetch_array($consultaAnterior, MYSQLI_ASSOC) : [];

            mysqli_query($conn, $var1) or die('P156' . mysqli_error($conn));

// ── Re-procesar XML si se subió uno nuevo durante la edición ──────────────
$doctoActual = mysqli_query($conn,
    "SELECT ADJUNTAR_FACTURA_XML FROM 02SUBETUFACTURADOCTOS 
     WHERE idTemporal = '{$IPpagoprovee}' 
     AND ADJUNTAR_FACTURA_XML <> '' 
     ORDER BY id DESC LIMIT 1"
);
if ($doctoActual) {
    $rowDocto = mysqli_fetch_assoc($doctoActual);
    if (!empty($rowDocto['ADJUNTAR_FACTURA_XML'])) {
        $urlXmlEdicion = __ROOT3__ . '/includes/archivos/' . $rowDocto['ADJUNTAR_FACTURA_XML'];
        if (file_exists($urlXmlEdicion)) {
            $conexion2edicion = new herramientas();
            $datosXmlEdicion  = $conexion2edicion->lectorxml($urlXmlEdicion);
            if (!empty($datosXmlEdicion['UUID'])) {
                // Solo actualiza si el UUID no está ya registrado para OTRO registro
                $uuidCheck = mysqli_query($conn,
                    "SELECT ultimo_id FROM 02XML 
                     WHERE UUID = '" . mysqli_real_escape_string($conn, $datosXmlEdicion['UUID']) . "' 
                     AND ultimo_id <> '{$IPpagoprovee}' LIMIT 1"
                );
                if (!mysqli_fetch_assoc($uuidCheck)) {
                    $this->guardarxmlDB2(
                        $IPpagoprovee,
                        $session,
                        '02XML',
                        $urlXmlEdicion,
                        $datosXmlEdicion
                    );
                }
            }
        }
    }
}

            $mapaComparacion = [
                'STATUS_DE_PAGO' => $STATUS_DE_PAGO, 'MONTO_DEPOSITAR' => $MONTO_DEPOSITAR,
                'FECHA_DE_PAGO' => $FECHA_DE_PAGO, 'FECHA_A_DEPOSITAR' => $FECHA_A_DEPOSITAR,
                'PFORMADE_PAGO' => $PFORMADE_PAGO, 'NUMERO_EVENTO' => $NUMERO_EVENTO,
                'NOMBRE_EVENTO' => $NOMBRE_EVENTO, 'NOMBRE_COMERCIAL' => $NOMBRE_COMERCIAL,
                'RAZON_SOCIAL' => $RAZON_SOCIAL, 'RFC_PROVEEDOR' => $RFC_PROVEEDOR,
                'MOTIVO_GASTO' => $MOTIVO_GASTO, 'CONCEPTO_PROVEE' => $CONCEPTO_PROVEE,
                'MONTO_TOTAL_COTIZACION_ADEUDO' => $MONTO_TOTAL_COTIZACION_ADEUDO,
                'MONTO_FACTURA' => $MONTO_FACTURA, 'MONTO_PROPINA' => $MONTO_PROPINA,
                'TIPO_DE_MONEDA' => $TIPO_DE_MONEDA, 'BANCO_ORIGEN' => $BANCO_ORIGEN,
                'MONTO_DEPOSITADO' => $MONTO_DEPOSITADO, 'CLASIFICACION_GENERAL' => $CLASIFICACION_GENERAL,
                'CLASIFICACION_ESPECIFICA' => $CLASIFICACION_ESPECIFICA,
                'MONTO_DE_COMISION' => $MONTO_DE_COMISION, 'POLIZA_NUMERO' => $POLIZA_NUMERO,
                'NOMBRE_DEL_EJECUTIVO' => $NOMBRE_DEL_EJECUTIVO, 'NOMBRE_DEL_AYUDO' => $NOMBRE_DEL_AYUDO,
                'OBSERVACIONES_1' => $OBSERVACIONES_1, 'TIPO_CAMBIOP' => $TIPO_CAMBIOP,
                'TOTAL_ENPESOS' => $TOTAL_ENPESOS, 'IMPUESTO_HOSPEDAJE' => $IMPUESTO_HOSPEDAJE,
                'TImpuestosRetenidosIVA' => $TImpuestosRetenidosIVA,
                'TImpuestosRetenidosISR' => $TImpuestosRetenidosISR,
                'descuentos' => $descuentos, 'IVA' => $IVA,
                'ACTIVO_FIJO' => $ACTIVO_FIJO, 'GASTO_FIJO' => $GASTO_FIJO, 'VIATICOSOPRO' => $VIATICOSOPRO,
            ];

            $cambiosDetectados = [];
            foreach ($mapaComparacion as $campo => $valorNuevo) {
                $valorViejo = isset($registroAnterior[$campo]) ? $registroAnterior[$campo] : '';
                $viejoNorm  = trim((string)$valorViejo);
                $nuevoNorm  = trim((string)$valorNuevo);
                if ($viejoNorm !== $nuevoNorm && !($viejoNorm === '' && $nuevoNorm === '0')) {
                    $cambiosDetectados[] = $this->etiqueta_bitacora_campo($campo) . ': "' . $viejoNorm . '" → "' . $nuevoNorm . '"';
                }
            }

            if (count($cambiosDetectados) > 0) {
                $detalleActualizacion = 'Se actualizó. Cambios detectados: ' . implode(' | ', $cambiosDetectados) . '.';
                $this->registrar_bitacora($conn, $IPpagoprovee, 'ACTUALIZACION', $detalleActualizacion, '', $usuarioBitacora);
            }

            return "Actualizado";

        } else {

            mysqli_query($conn, $var2) or die('P160' . mysqli_error($conn));
            $ultimo_id = mysqli_insert_id($conn);

            $this->registrar_bitacora($conn, $ultimo_id, 'INGRESO', 'Registro ingresado desde el módulo PAGO A PROVEEDORES.', $usuarioBitacora, '');

            // ── Parsear XML una sola vez y reutilizar los datos ───────────
            $regresourl = $this->variable_SUBETUFACTURA2($_SESSION['idPROV']);
            $urlXml     = __ROOT3__ . '/includes/archivos/' . $regresourl['ADJUNTAR_FACTURA_XML'];
            $datosXml   = null;
            if (file_exists($urlXml)) {
                $conexion2 = new herramientas();
                $datosXml  = $conexion2->lectorxml($urlXml);
            }
            // Pasar $datosXml ya leídos — guardarxmlDB2 NO releerá el archivo
            $this->guardarxmlDB2($ultimo_id, $_SESSION['idPROV'], '02XML', $urlXml, $datosXml);

            mysqli_query($conn, "UPDATE 02SUBETUFACTURADOCTOS SET idTemporal='{$ultimo_id}' WHERE idRelacion='" . $_SESSION['idPROV'] . "' AND idTemporal='si'");

            return "Ingresado";
        }
    }


    private function actualizar_campo_status($id, $campo, $valor, $descripcionExtra = '') {
        $conn = $this->db();
        if (empty($_SESSION['idem'])) { echo "NO HAY UN PROVEEDOR SELECCIONADO"; return null; }
        $valorAnterior = $this->valor_actual_campo_subetufactura($conn, $id, $campo);
        mysqli_query($conn, "UPDATE 02SUBETUFACTURA SET {$campo}='{$valor}' WHERE id='{$id}'") or die('P156' . mysqli_error($conn));
        $this->registrar_cambio_estado_detallado($conn, $id, $campo, $valorAnterior, $valor, $descripcionExtra);
        return "Actualizado^{$valor}";
    }

    public function ACTUALIZA_RESPONSABLE_EVENTO($id, $texto) {
        return $this->actualizar_campo_status($id, 'STATUS_RESPONSABLE_EVENTO', $texto);
    }

    public function ACTUALIZA_AUDITORIA3($id, $texto) {
        return $this->actualizar_campo_status($id, 'STATUS_AUDITORIA3', $texto);
    }

    public function ACTUALIZA_SINXML($id, $texto) {
        return $this->actualizar_campo_status($id, 'STATUS_SINXML', $texto);
    }

    public function ACTUALIZA_CHECKBOX($id, $texto) {
        // retorna "Actualizado" sin el valor (compatibilidad original)
        $res = $this->actualizar_campo_status($id, 'STATUS_CHECKBOX', $texto);
        return $res !== null ? "Actualizado" : null;
    }

    public function ACTUALIZA_AUDITORIA2($id, $texto) {
        return $this->actualizar_campo_status($id, 'STATUS_AUDITORIA2', $texto);
    }

    public function ACTUALIZA_FINANZAS($id, $texto) {
        return $this->actualizar_campo_status($id, 'STATUS_FINANZAS', $texto);
    }

    public function ACTUALIZA_VENTAS($id, $texto) {
        return $this->actualizar_campo_status($id, 'STATUS_VENTAS', $texto);
    }

    public function ACTUALIZA_AUDITORIA1($id, $texto) {
        $nuevoStatus = ($texto == 'si') ? 'APROBADO' : 'SOLICITADO';
        $conn = $this->db();
        if (empty($_SESSION['idem'])) { echo "NO HAY UN PROVEEDOR SELECCIONADO"; return null; }
        $valorAnterior = $this->valor_actual_campo_subetufactura($conn, $id, 'STATUS_DE_PAGO');
        mysqli_query($conn, "UPDATE 02SUBETUFACTURA SET STATUS_DE_PAGO='{$nuevoStatus}' WHERE id='{$id}'") or die('P156' . mysqli_error($conn));
        $this->registrar_cambio_estado_detallado($conn, $id, 'STATUS_DE_PAGO', $valorAnterior, $nuevoStatus, 'Cambio realizado por CUENTAS POR PAGAR.');
        return "Actualizado";
    }

    public function PASARPAGADOACTUALIZAR($id, $texto) {
        $nuevoStatus = ($texto == 'si') ? 'PAGADO' : 'SOLICITADO';
        $conn = $this->db();
        if (empty($_SESSION['idem'])) { echo "NO HAY UN PROVEEDOR SELECCIONADO"; return null; }
        $valorAnterior = $this->valor_actual_campo_subetufactura($conn, $id, 'STATUS_DE_PAGO');
        mysqli_query($conn, "UPDATE 02SUBETUFACTURA SET STATUS_DE_PAGO='{$nuevoStatus}' WHERE id='{$id}'") or die('P156' . mysqli_error($conn));
        $this->registrar_cambio_estado_detallado($conn, $id, 'STATUS_DE_PAGO', $valorAnterior, $nuevoStatus, 'Cambio realizado por FINANZAS Y TESORERÍA.');
        return "Actualizado";
    }

    public function ACTUALIZA_RECHAZADO($id, $estatusRechazado) {
        $conn = $this->db();
        if (empty($_SESSION['idem'])) { echo "NO HAY UN PROVEEDOR SELECCIONADO"; return null; }

        $valorAnteriorRechazado  = $this->valor_actual_campo_subetufactura($conn, $id, 'STATUS_RECHAZADO');
        $valorAnteriorStatusPago = $this->valor_actual_campo_subetufactura($conn, $id, 'STATUS_DE_PAGO');
        $nuevoStatusPago         = ($estatusRechazado === 'si') ? 'RECHAZADO' : 'SOLICITADO';

        mysqli_query($conn, "UPDATE 02SUBETUFACTURA SET STATUS_RECHAZADO='{$estatusRechazado}', STATUS_DE_PAGO='{$nuevoStatusPago}' WHERE id='{$id}'") or die('P156' . mysqli_error($conn));

        $this->registrar_cambio_estado_detallado($conn, $id, 'STATUS_RECHAZADO', $valorAnteriorRechazado, $estatusRechazado);
        if ($valorAnteriorStatusPago !== $nuevoStatusPago) {
            $this->registrar_cambio_estado_detallado($conn, $id, 'STATUS_DE_PAGO', $valorAnteriorStatusPago, $nuevoStatusPago);
        }
        return "Actualizado^{$estatusRechazado}";
    }

    public function borrapagoaproveedores($id) {
        $conn = $this->db();
        $id   = intval($id);
        mysqli_query($conn, "DELETE FROM 02SUBETUFACTURA WHERE id='{$id}'") or die('P44' . mysqli_error($conn));
        mysqli_query($conn, "DELETE FROM 02XML WHERE ultimo_id='{$id}'") or die('P44' . mysqli_error($conn));
        mysqli_query($conn, "DELETE FROM 02SUBETUFACTURADOCTOS WHERE idTemporal='{$id}'") or die('P44' . mysqli_error($conn));
 mysqli_query($conn, "DELETE FROM 02SUBETUFACTURA_BITACORA WHERE id_subetufactura='{$id}'") or die('P44' . mysqli_error($conn));
        echo "ELEMENTO BORRADO";
    }

    public function borrar_xmls($ruta, $id, $nombrearchivo, $tabla1, $tabla2) {
        $conn = $this->db();
        mysqli_query($conn, "DELETE FROM {$tabla1} WHERE ultimo_id='{$id}'");
        $q = mysqli_query($conn, "SELECT * FROM {$tabla2} WHERE idTemporal='{$id}' AND ADJUNTAR_FACTURA_XML<>'{$nombrearchivo}' AND ADJUNTAR_FACTURA_XML<>''") or die('P44' . mysqli_error($conn));
        while ($row = mysqli_fetch_array($q, MYSQLI_ASSOC)) {
            if (file_exists($ruta . $row['ADJUNTAR_FACTURA_XML'])) unlink($ruta . $row['ADJUNTAR_FACTURA_XML']);
        }
        mysqli_query($conn, "DELETE FROM {$tabla2} WHERE idTemporal='{$id}' AND ADJUNTAR_FACTURA_XML<>'{$nombrearchivo}' AND ADJUNTAR_FACTURA_XML<>''") or die('P44' . mysqli_error($conn));
    }

    public function borrar_pdfs($ruta, $id, $nombrearchivo, $tabla1, $tabla2) {
        $conn = $this->db();
        $q    = mysqli_query($conn, "SELECT * FROM {$tabla2} WHERE idTemporal='{$id}' AND ADJUNTAR_FACTURA_PDF<>'{$nombrearchivo}' AND ADJUNTAR_FACTURA_PDF<>''") or die('P44' . mysqli_error($conn));
        while ($row = mysqli_fetch_array($q, MYSQLI_ASSOC)) {
            if (file_exists($ruta . $row['ADJUNTAR_FACTURA_PDF'])) unlink($ruta . $row['ADJUNTAR_FACTURA_PDF']);
        }
        mysqli_query($conn, "DELETE FROM {$tabla2} WHERE idTemporal='{$id}' AND ADJUNTAR_FACTURA_PDF<>'{$nombrearchivo}' AND ADJUNTAR_FACTURA_PDF<>''") or die('P44' . mysqli_error($conn));
    }


    public function select_02XML() {
        $conn  = $this->db();
        $query = mysqli_query($conn, "SELECT id FROM 02XML ORDER BY id DESC");
        $row   = mysqli_fetch_array($query, MYSQLI_ASSOC);
        return $row['id'];
    }

public function VALIDA02XMLUUID($uuid) {
    $conn  = $this->db();
    $uuid  = mysqli_real_escape_string($conn, $uuid);

    // ── Verificar en 02XML ──
    $query = mysqli_query($conn, "SELECT 02XML.id, 02XML.UUID, 02SUBETUFACTURA.NUMERO_CONSECUTIVO_PROVEE, 02SUBETUFACTURA.NUMERO_EVENTO
        FROM 02XML LEFT JOIN 02SUBETUFACTURA ON 02XML.ultimo_id = 02SUBETUFACTURA.id
        WHERE 02XML.UUID='{$uuid}'");
    $row = mysqli_fetch_array($query, MYSQLI_ASSOC);

    if ($row['id']) {
        $numero = ($row['NUMERO_CONSECUTIVO_PROVEE'] != '') ? $row['NUMERO_CONSECUTIVO_PROVEE'] : $row['id'];
        $numeroEvento = isset($row['NUMERO_EVENTO']) ? trim((string)$row['NUMERO_EVENTO']) : '';
        return '3^^' . $numero . '^^' . $numeroEvento;
    }

    // ── Verificar en 07XML (Comprobación de Gastos) ──
    $query7 = mysqli_query($conn, "SELECT id, ultimo_id FROM 07XML WHERE UUID='{$uuid}'");
    $row7   = mysqli_fetch_array($query7, MYSQLI_ASSOC);

    if ($row7['id']) {
        $numero7 = ($row7['ultimo_id'] != '') ? $row7['ultimo_id'] : $row7['id'];
        return '7^^^' . $numero7;
    }

    return 'S';
}


    public function Listado_pagoproveedor() {
        $conn = $this->db();
        return mysqli_query($conn, "SELECT * FROM 02SUBETUFACTURA WHERE idRelacion='" . $_SESSION['idPROV'] . "' ORDER BY id DESC");
    }

    public function Listado_pagoproveedor2($id) {
        $conn = $this->db();
        $id   = intval($id);
        return mysqli_query($conn, "SELECT * FROM 02SUBETUFACTURA WHERE id='{$id}'");
    }

    public function Listado_bitacora_pagoproveedor_array($idcomprobacion) {
        $conn = $this->db();
        $idcomprobacion = intval($idcomprobacion);

        $this->inicializar_tablas_auxiliares(); // garantiza tabla sin DDL repetido

        $query = mysqli_query($conn, "SELECT b.tipo_movimiento, b.detalle, b.fecha_hora,
            b.nombre_quien_ingreso, b.nombre_quien_actualizo,
            s.NUMERO_CONSECUTIVO_PROVEE, s.VIATICOSOPRO
            FROM 02SUBETUFACTURA_BITACORA b
            LEFT JOIN 02SUBETUFACTURA s ON s.id = b.id_subetufactura
            WHERE b.id_subetufactura='{$idcomprobacion}'
            ORDER BY b.id DESC");

        $resultado = [];
        if ($query) {
            while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
                if (!empty($row['fecha_hora'])) {
                    $fecha = DateTime::createFromFormat('Y-m-d H:i:s', $row['fecha_hora'], new DateTimeZone('UTC'));
                    if ($fecha) {
                        $fecha->setTimezone(new DateTimeZone('America/Mexico_City'));
                        $row['fecha_hora'] = $fecha->format('d/m/Y H:i:s');
                    }
                }
                $resultado[] = $row;
            }
        }
        return $resultado;
    }

    public function getDoctos_subefactura($ID) {
        $conn = $this->db();
        $ID   = mysqli_real_escape_string($conn, $ID);
        $q    = mysqli_query($conn, "SELECT COMPLEMENTOS_PAGO_PDF, COMPLEMENTOS_PAGO_XML FROM 02SUBETUFACTURADOCTOS WHERE idTemporal='{$ID}' ORDER BY id DESC LIMIT 1");
        return $q ? mysqli_fetch_array($q, MYSQLI_ASSOC) : null;
    }

    public function Listado_subefacturaDOCTOS($ID) {
        $conn = $this->db();
        $ID   = intval($ID);
        return mysqli_query($conn, "SELECT * FROM 02SUBETUFACTURADOCTOS WHERE idTemporal='{$ID}' ORDER BY id DESC");
    }

    public function Listado_subefacturadocto($ADJUNTAR_COTIZACION) {
        $conn = $this->db();
        return mysqli_query($conn, "SELECT id,{$ADJUNTAR_COTIZACION},fechaingreso FROM 02SUBETUFACTURADOCTOS
            WHERE idRelacion='" . $_SESSION['idPROV'] . "' AND idTemporal='si'
            AND ({$ADJUNTAR_COTIZACION} IS NOT NULL OR {$ADJUNTAR_COTIZACION}<>'') ORDER BY id DESC");
    }

    public function delete_subefacturadocto2($id) {
        $conn  = $this->db();
        $id    = intval($id);
        $query = mysqli_query($conn, "SELECT idTemporal, ADJUNTAR_FACTURA_XML FROM 02SUBETUFACTURADOCTOS WHERE id='{$id}'");
        $row   = mysqli_fetch_array($query, MYSQLI_ASSOC);
        if ($row && $row['ADJUNTAR_FACTURA_XML'] != '') {
            mysqli_query($conn, "DELETE FROM 02XML WHERE ultimo_id='" . $row['idTemporal'] . "'");
        }
        return mysqli_query($conn, "DELETE FROM 02SUBETUFACTURADOCTOS WHERE id='{$id}'");
    }

    public function delete_subefactura2nombre($nombre) {
        $conn   = $this->db();
        $nombre = mysqli_real_escape_string($conn, $nombre);
        mysqli_query($conn, "DELETE FROM 02SUBETUFACTURADOCTOS WHERE ADJUNTAR_FACTURA_XML='{$nombre}'");
    }

public function borrar_historico_xml($nombretabla, $idusuario) {
    $conn      = $this->db();
    $ruta      = __ROOT3__ . '/includes/archivos/';
    $idusuario = intval($idusuario);

    // Columnas de archivos físicos que hay que borrar del servidor
    $columnas_archivos = [
        'ADJUNTAR_FACTURA_XML',
        'ADJUNTAR_FACTURA_PDF',
        'ADJUNTAR_COTIZACION',
        'CONPROBANTE_TRANSFERENCIA',
        'ADJUNTAR_ARCHIVO_1',
        'FOTO_ESTADO_PROVEE11',
        'COMPLEMENTOS_PAGO_PDF',
        'COMPLEMENTOS_PAGO_XML',
        'CANCELACIONES_PDF',
        'CANCELACIONES_XML',
        'ADJUNTAR_FACTURA_DE_COMISION_PDF',
        'ADJUNTAR_FACTURA_DE_COMISION_XML',
        'CALCULO_DE_COMISION',
        'COMPROBANTE_DE_DEVOLUCION',
        'NOTA_DE_CREDITO_COMPRA',
    ];

    // 1. Traer todos los registros temporales del usuario
    $q = mysqli_query($conn,
        "SELECT * FROM {$nombretabla} 
         WHERE idRelacionU='{$idusuario}' 
         AND idTemporal='si'"
    ) or die('P44' . mysqli_error($conn));

    // 2. Borrar cada archivo físico encontrado
    while ($row = mysqli_fetch_array($q, MYSQLI_ASSOC)) {
        foreach ($columnas_archivos as $col) {
            if (!empty($row[$col])) {
                $archivo = $ruta . $row[$col];
                if (file_exists($archivo)) {
                    unlink($archivo);
                }
            }
        }
    }

    // 3. Borrar TODOS los registros temporales del usuario de la tabla
    mysqli_query($conn,
        "DELETE FROM {$nombretabla} 
         WHERE idRelacionU='{$idusuario}' 
         AND idTemporal='si'"
    ) or die('P441' . mysqli_error($conn));

    // 4. Limpiar sesión para evitar que cargue datos de sesiones anteriores
    $_SESSION['idPROV']                       = '';
    $_SESSION['P_NOMBRE_COMERCIAL_EMPRESA12'] = '';
    $_SESSION['idusuario12']                  = '';
}

    public function buscarNOMBRECOMERCIAL22($rfc) {
        $conn = $this->db();
        $rfc  = mysqli_real_escape_string($conn, $rfc);
        $q    = mysqli_query($conn, "SELECT 02direccionproveedor1.idRelacion AS idusuario, P_NOMBRE_COMERCIAL_EMPRESA
            FROM 02direccionproveedor1 LEFT JOIN 02usuarios ON 02direccionproveedor1.idRelacion = 02usuarios.id
            WHERE P_RFC_MTDP='{$rfc}'");
        $row  = mysqli_fetch_array($q, MYSQLI_ASSOC);
        $_SESSION['idusuario12']                  = $row['idusuario'];
        $_SESSION['P_NOMBRE_COMERCIAL_EMPRESA12'] = $row['P_NOMBRE_COMERCIAL_EMPRESA'];
        return $row['idusuario'] . '^^^^' . $row['P_NOMBRE_COMERCIAL_EMPRESA'];
    }
}
?>