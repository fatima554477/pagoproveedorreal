<?php
/*
fecha fatis : 04/04/2024
ACTUALIZADO: fixes archivos desde 02SUBETUFACTURADOCTOS
MODIFICADO: campos bloqueados para coincidir con vista previa 2
*/

if(!isset($_SESSION)) { session_start(); }

$identioficador = isset($_POST["personal_id"]) ? $_POST["personal_id"] : '';

if($identioficador != '') {
    $output = '';
    require "controladorPP.php";

    $queryVISTAPREV = $pagoproveedores->Listado_pagoproveedor2($identioficador);

    while($row = mysqli_fetch_array($queryVISTAPREV)) {

        $row2xml = $pagoproveedores->busca_02XML($row['id']);
        $conn    = $pagoproveedores->db();

        // ── Obtener TODOS los archivos desde 02SUBETUFACTURADOCTOS ────────
        $columnasArchivos = [
            'ADJUNTAR_FACTURA_XML',
            'ADJUNTAR_FACTURA_PDF',
            'ADJUNTAR_COTIZACION',
            'CONPROBANTE_TRANSFERENCIA',
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
            'ADJUNTAR_ARCHIVO_1',
        ];

        $archivosActuales = array_fill_keys($columnasArchivos, '');
        $listaDoctos      = array_fill_keys($columnasArchivos, '');

        $qArchivos = mysqli_query($conn,
            "SELECT * FROM 02SUBETUFACTURADOCTOS 
             WHERE idTemporal = '" . intval($row['id']) . "' 
             ORDER BY id DESC"
        );

        if ($qArchivos) {
            while ($rowDoc = mysqli_fetch_assoc($qArchivos)) {
                foreach ($columnasArchivos as $col) {
                    if (!empty($rowDoc[$col])) {
                        if ($archivosActuales[$col] === '') {
                            $archivosActuales[$col] = $rowDoc[$col];
                        }
                        $listaDoctos[$col] .=
                            "<a target='_blank' href='includes/archivos/" . $rowDoc[$col] . "'>Visualizar!</a>"
                            
                            . " <span>" . $rowDoc['fechaingreso'] . "</span><br/>";
                    }
                }
            }
        }
        // ─────────────────────────────────────────────────────────────────

        // ── Status de pago (disabled + hidden para enviar el valor) ──────
        $SOLICITADO = $APROBADO = $PAGADO = $RECHAZADO = '';
        if($row['STATUS_DE_PAGO'] == "SOLICITADO")    { $SOLICITADO = "selected"; }
        elseif($row['STATUS_DE_PAGO'] == "APROBADO")  { $APROBADO   = "selected"; }
        elseif($row['STATUS_DE_PAGO'] == "PAGADO")    { $PAGADO     = "selected"; }
        elseif($row['STATUS_DE_PAGO'] == "RECHAZADO") { $RECHAZADO  = "selected"; }

        $STATUS_DE_PAGO  = '<select required name="STATUS_DE_PAGO" disabled>';
        $STATUS_DE_PAGO .= '<option value="SOLICITADO" ' . $SOLICITADO . '>SOLICITADO</option>';
        $STATUS_DE_PAGO .= '<option value="APROBADO"   ' . $APROBADO   . '>APROBADO</option>';
        $STATUS_DE_PAGO .= '<option value="PAGADO"     ' . $PAGADO     . '>PAGADO</option>';
        $STATUS_DE_PAGO .= '<option value="RECHAZADO"  ' . $RECHAZADO  . '>RECHAZADO</option>';
        $STATUS_DE_PAGO .= '</select>';
        $STATUS_DE_PAGO .= '<input type="hidden" name="STATUS_DE_PAGO" value="' . $row['STATUS_DE_PAGO'] . '">';

        // ── Bloqueo de fecha si ya está aprobado/pagado ───────────────────
        $fechaDePagoBloqueada    = '';
        $fechaProgramacionColor  = '#dfd9f3';
        if (in_array($row['STATUS_DE_PAGO'], ['APROBADO', 'PAGADO'])) {
            $fechaDePagoBloqueada   = ' readonly="readonly" style="background:#d7bde2"';
        }

        // ── Factura XML/PDF siempre bloqueadas en esta vista ─────────────

        // ── Helper zona de carga ACTIVA ───────────────────────────────────
        $zonaArchivo = function($campo, $valor, $historial, $extraAttr = '', $zoneStyle = 'style="width:300px;"') {
            return '
            <div id="drop_file_zone" ondrop="upload_file2(event,\''.$campo.'\')" ondragover="return false" '.$zoneStyle.'>
                <p>Suelta aquí o busca tu archivo</p>
                <p><input class="form-control form-control-sm" id="'.$campo.'" type="text"
                    onkeydown="return false"
                    onclick="file_explorer2(\''.$campo.'\');"
                    style="width:250px;"
                    VALUE="'.$valor.'"
                    required'.$extraAttr.' /></p>
                <input type="file" name="'.$campo.'" id="nono"'.$extraAttr.'/>
                <div id="3'.$campo.'">'.$historial.'</div>
            </div>';
        };

        // ── Helper zona de carga BLOQUEADA (igual que vista 2) ───────────
        $zonaArchivoBloqueada = function($campo, $valor, $historial) {
            return '
            <div id="drop_file_zone" style="width:300px; background-color:#d7bde2;">
                <p style="color:#999;">Suelta aquí o busca tu archivo</p>
                <p>
                    <input
                        class="form-control form-control-sm"
                        id="'.$campo.'"
                        type="text"
                        readonly
                        style="width:250px; background-color:#e9ecef;"
                        value="'.$valor.'"
                        required
                    />
                </p>
                <input type="file" name="'.$campo.'" id="nono" style="display:none;" disabled />
                <div id="3'.$campo.'">'.$historial.'</div>
            </div>';
        };

        // ── Bloque XML ────────────────────────────────────────────────────
        $campos_xml = '';
        if ($row2xml["Version"] == 'no' || $row2xml["Version"] == '') {
            $campos_xml = '
            <tr style="background:#fbf696;">
                <td width="30%"><label>NOMBRE RECEPTOR</label></td>
                <td width="70%"><input type="text" readonly style="background:#d7bde2" name="nombreR" value="'.$row2xml["nombreR"].'"></td>
            </tr>
            <tr style="background:#fbf696;">
                <td><label>RFC RECEPTOR</label></td>
                <td><input type="text" readonly style="background:#d7bde2" name="rfcR" value="'.$row2xml["rfcR"].'"></td>
            </tr>
            <tr style="background:#fbf696;">
                <td><label>RÉGIMEN FISCAL</label></td>
                <td><input type="text" readonly style="background:#d7bde2" name="regimenE" value="'.$row2xml["regimenE"].'"></td>
            </tr>
            <tr style="background:#fbf696;">
                <td><label>UUID</label></td>
                <td><input type="text" readonly style="background:#d7bde2" name="UUID" value="'.$row2xml["UUID"].'"></td>
            </tr>
            <tr style="background:#fbf696;">
                <td><label>FOLIO</label></td>
                <td><input type="text" readonly style="background:#d7bde2" name="folio" value="'.$row2xml["folio"].'"></td>
            </tr>
            <tr style="background:#fbf696;">
                <td><label>SERIE</label></td>
                <td><input type="text" readonly style="background:#d7bde2" name="serie" value="'.$row2xml["serie"].'"></td>
            </tr>
            <tr style="background:#fbf696;">
                <td><label>CLAVE DE UNIDAD</label></td>
                <td><input type="text" readonly style="background:#d7bde2" name="ClaveUnidadConcepto" value="'.$row2xml["ClaveUnidadConcepto"].'"></td>
            </tr>
            <tr style="background:#fbf696;">
                <td><label>FORMA DE PAGO</label></td>
                <td><input type="text" readonly style="background:#d7bde2" name="formaDePago" value="'.$row2xml["formaDePago"].'"></td>
            </tr>
            <tr style="background:#fbf696;">
                <td><label>CANTIDAD</label></td>
                <td><input type="text" readonly style="background:#d7bde2" name="CantidadConcepto" value="'.$row2xml["CantidadConcepto"].'"></td>
            </tr>
            <tr style="background:#fbf696;">
                <td><label>CLAVE DE PRODUCTO O SERVICIO</label></td>
                <td><input type="text" readonly style="background:#d7bde2" name="ClaveProdServConcepto" value="'.$row2xml["ClaveProdServConcepto"].'"></td>
            </tr>
            <tr style="background:#fbf696;">
                <td><label>DESCRIPCIÓN</label></td>
                <td><input type="text" readonly style="background:#d7bde2" name="DescripcionConcepto" value="'.$row2xml["DescripcionConcepto"].'"></td>
            </tr>
            <tr style="background:#fbf696;">
                <td><label>MONEDA</label></td>
                <td><input type="text" readonly style="background:#d7bde2" name="Moneda" value="'.$row2xml["Moneda"].'"></td>
            </tr>
            <tr style="background:#fbf696;">
                <td><label>TIPO DE CAMBIO</label></td>
                <td><input type="text" readonly style="background:#d7bde2" name="TipoCambio" value="'.$row2xml["TipoCambio"].'"></td>
            </tr>
            <tr style="background:#fbf696;">
                <td><label>USO DE CFDI</label></td>
                <td><input type="text" readonly style="background:#d7bde2" name="UsoCFDI" value="'.$row2xml["UsoCFDI"].'"></td>
            </tr>
            <tr style="background:#fbf696;">
                <td><label>MÉTODO DE PAGO</label></td>
                <td><input type="text" readonly style="background:#d7bde2" name="metodoDePago" value="'.$row2xml["metodoDePago"].'"></td>
            </tr>
            <tr style="background:#fbf696;">
                <td><label>CONDICIONES DE PAGO</label></td>
                <td><input type="text" readonly style="background:#d7bde2" name="condicionesDePago" value="'.$row2xml["condicionesDePago"].'"></td>
            </tr>
            <tr style="background:#fbf696;">
                <td><label>TIPO DE COMPROBANTE</label></td>
                <td><input type="text" readonly style="background:#d7bde2" name="tipoDeComprobante" value="'.$row2xml["tipoDeComprobante"].'"></td>
            </tr>
            <tr style="background:#fbf696;">
                <td><label>VERSIÓN</label></td>
                <td><input type="text" readonly style="background:#d7bde2" name="Version" value="'.$row2xml["Version"].'"></td>
            </tr>
            <input type="hidden" name="actualiza" value="true">
            <tr style="background:#fbf696;">
                <td><label>FECHA DE TIMBRADO</label></td>
                <td><input type="date" readonly style="background:#d7bde2" name="fechaTimbrado" value="'.$row2xml["fechaTimbrado"].'"></td>
            </tr>
            <tr style="background:#fbf696;">
                <td><label>SUBTOTAL</label></td>
                <td><input type="text" readonly style="background:#d7bde2" name="subTotal" value="'.$row2xml["subTotal"].'"></td>
            </tr>
            <tr style="background:#fbf696;">
                <td><label>SERVICIO, PROPINA, ISH Y SANEAMIENTO</label></td>
                <td><input type="text" readonly style="background:#d7bde2" name="Propina" value="'.$row2xml["Propina"].'"></td>
            </tr>
            <tr style="background:#fbf696;">
                <td><label>DESCUENTO</label></td>
                <td><input type="text" readonly style="background:#d7bde2" name="DESCUENTO" value="'.$row2xml["Descuento"].'"></td>
            </tr>
            <tr style="background:#fbf696;">
                <td><label>TOTAL DE IMPUESTOS TRASLADADOS</label></td>
                <td><input type="text" readonly style="background:#d7bde2" name="TImpuestosTrasladados" value="'.$row2xml["TImpuestosTrasladados"].'"></td>
            </tr>
            <tr style="background:#fbf696;">
                <td><label>TOTAL DE IMPUESTOS RETENIDOS</label></td>
                <td><input type="text" readonly style="background:#d7bde2" name="TImpuestosRetenidos" value="'.$row2xml["TImpuestosRetenidos"].'"></td>
            </tr>
            <tr style="background:#fbf696;">
                <td><label>TUA</label></td>
                <td><input type="text" readonly style="background:#d7bde2" name="TUA" value="'.$row2xml["TUA"].'"></td>
            </tr>
            <tr style="background:#fbf696;">
                <td><label>TUA TOTAL CARGOS</label></td>
                <td><input type="text" readonly style="background:#d7bde2" name="TuaTotalCargos" value="'.$row2xml["TuaTotalCargos"].'"></td>
            </tr>
            <tr style="background:#fbf696;">
                <td><label>TOTAL</label></td>
                <td><input type="text" readonly style="background:#d7bde2" name="totalf" value="'.$row2xml["totalf"].'"></td>
            </tr>';
        }

        // ── Campos hidden (no editables en esta vista) ────────────────────
        $hiddens  = '<input type="hidden" name="ACTIVO_FIJO"                      value="'.$row["ACTIVO_FIJO"].'">
                     <input type="hidden" name="GASTO_FIJO"                       value="'.$row["GASTO_FIJO"].'">
                     <input type="hidden" name="PAGAR_CADA"                       value="'.$row["PAGAR_CADA"].'">
                     <input type="hidden" name="FECHA_PPAGO"                      value="'.$row["FECHA_PPAGO"].'">
                     <input type="hidden" name="FECHA_TPROGRAPAGO"                value="'.$row["FECHA_TPROGRAPAGO"].'">
                     <input type="hidden" name="NUMERO_EVENTOFIJO"                value="'.$row["NUMERO_EVENTOFIJO"].'">
                     <input type="hidden" name="CLASI_GENERAL"                    value="'.$row["CLASI_GENERAL"].'">
                     <input type="hidden" name="SUB_GENERAL"                      value="'.$row["SUB_GENERAL"].'">
                     <input type="hidden" name="BANCO_ORIGEN"                     value="'.$row["BANCO_ORIGEN"].'">
                     <input type="hidden" name="PLACAS_VEHICULO"                  value="'.$row["PLACAS_VEHICULO"].'">
                     <input type="hidden" name="MONTO_DE_COMISION"                value="'.$row["MONTO_DE_COMISION"].'">
                     <input type="hidden" name="PFORMADE_PAGO"                    value="'.$row["PFORMADE_PAGO"].'">
                     <input type="hidden" name="TIPO_CAMBIOP"                     value="'.$row["TIPO_CAMBIOP"].'">
                     <input type="hidden" name="TOTAL_ENPESOS"                    value="'.$row["TOTAL_ENPESOS"].'">
                     <input type="hidden" name="MONTO_DEPOSITADO"                 value="'.$row["MONTO_DEPOSITADO"].'">
                     <input type="hidden" name="TIPO_DE_MONEDA"                   value="'.$row["TIPO_DE_MONEDA"].'">
                     <input type="hidden" name="NOMBRE_COMERCIAL"                 value="'.$row["NOMBRE_COMERCIAL"].'">
                     <input type="hidden" name="RAZON_SOCIAL"                     value="'.$row["RAZON_SOCIAL"].'">
                     <input type="hidden" name="RFC_PROVEEDOR"                    value="'.$row["RFC_PROVEEDOR"].'">
                     <input type="hidden" name="NUMERO_EVENTO"                    value="'.$row["NUMERO_EVENTO"].'">
                     <input type="hidden" name="NOMBRE_EVENTO"                    value="'.$row["NOMBRE_EVENTO"].'">
                     <input type="hidden" name="CONCEPTO_PROVEE"                  value="'.$row["CONCEPTO_PROVEE"].'">
                     <input type="hidden" name="VIATICOSOPRO"                     value="'.$row["VIATICOSOPRO"].'">
                     <input type="hidden" name="NUMERO_CONSECUTIVO_PROVEE"        value="'.$row["NUMERO_CONSECUTIVO_PROVEE"].'">
                     <input type="hidden" name="POLIZA_NUMERO"                    value="'.$row["POLIZA_NUMERO"].'">
                     <input type="hidden" name="NOMBRE_DEL_AYUDO"                 value="'.$row["NOMBRE_DEL_AYUDO"].'">
                     <input type="hidden" name="NOMBRE_DEL_EJECUTIVO"             value="'.$row["NOMBRE_DEL_EJECUTIVO"].'">
                     <input type="hidden" name="FECHA_A_DEPOSITAR"                value="'.$row["FECHA_A_DEPOSITAR"].'">
                     <input type="hidden" name="FECHA_DE_LLENADO"                 value="'.$row["FECHA_DE_LLENADO"].'">
                     <input type="hidden" name="TImpuestosRetenidosIVA"           value="'.$row["TImpuestosRetenidosIVA"].'">
                     <input type="hidden" name="TImpuestosRetenidosISR"           value="'.$row["TImpuestosRetenidosISR"].'">
                     <input type="hidden" name="descuentos"                       value="'.$row["descuentos"].'">
                     <input type="hidden" name="MOTIVO_GASTO"                     value="'.$row["MOTIVO_GASTO"].'">
                     <input type="hidden" name="MONTO_TOTAL_COTIZACION_ADEUDO"    value="'.$row["MONTO_TOTAL_COTIZACION_ADEUDO"].'">
                     <input type="hidden" name="MONTO_FACTURA"                    value="'.$row["MONTO_FACTURA"].'">
                     <input type="hidden" name="IVA"                              value="'.$row["IVA"].'">
                     <input type="hidden" name="MONTO_PROPINA"                    value="'.$row["MONTO_PROPINA"].'">
                     <input type="hidden" name="IMPUESTO_HOSPEDAJE"               value="'.$row["IMPUESTO_HOSPEDAJE"].'">
                     <input type="hidden" name="OBSERVACIONES_1"                  value="'.$row["OBSERVACIONES_1"].'">
                     <input type="hidden" name="CONPROBANTE_TRANSFERENCIA"        value="'.$archivosActuales['CONPROBANTE_TRANSFERENCIA'].'">
                     <input type="hidden" name="CANCELACIONES_PDF"                value="'.$archivosActuales['CANCELACIONES_PDF'].'">
                     <input type="hidden" name="CANCELACIONES_XML"                value="'.$archivosActuales['CANCELACIONES_XML'].'">
                     <input type="hidden" name="ADJUNTAR_FACTURA_DE_COMISION_PDF" value="'.$archivosActuales['ADJUNTAR_FACTURA_DE_COMISION_PDF'].'">
                     <input type="hidden" name="ADJUNTAR_FACTURA_DE_COMISION_XML" value="'.$archivosActuales['ADJUNTAR_FACTURA_DE_COMISION_XML'].'">
                     <input type="hidden" name="CALCULO_DE_COMISION"              value="'.$archivosActuales['CALCULO_DE_COMISION'].'">
                     <input type="hidden" name="COMPROBANTE_DE_DEVOLUCION"        value="'.$archivosActuales['COMPROBANTE_DE_DEVOLUCION'].'">
                     <input type="hidden" name="NOTA_DE_CREDITO_COMPRA"           value="'.$archivosActuales['NOTA_DE_CREDITO_COMPRA'].'">
                     <input type="hidden" name="FOTO_ESTADO_PROVEE11"             value="'.$archivosActuales['FOTO_ESTADO_PROVEE11'].'">';

        // ── HTML de la vista ──────────────────────────────────────────────
        $output .= '
        <div id="respuestaser"></div>
        <form id="ListadoPAGOPROVEEform">
        <div class="table-responsive">
        <table class="table table-bordered">

        <tr>
            <td width="30%" style="font-weight:bold;background:#dfd9f3;">ADJUNTAR FACTURA (FORMATO XML)</td>
            <td width="70%">'.$zonaArchivoBloqueada(
                'ADJUNTAR_FACTURA_XML',
                $archivosActuales['ADJUNTAR_FACTURA_XML'],
                $listaDoctos['ADJUNTAR_FACTURA_XML']
            ).'</td>
        </tr>

        <tr>
            <td width="30%" style="font-weight:bold;background:#dfd9f3;">ADJUNTAR FACTURA (FORMATO PDF)</td>
            <td width="70%">'.$zonaArchivoBloqueada(
                'ADJUNTAR_FACTURA_PDF',
                $archivosActuales['ADJUNTAR_FACTURA_PDF'],
                $listaDoctos['ADJUNTAR_FACTURA_PDF']
            ).'</td>
        </tr>

        <tr>
            <td style="background:#dfd9f3;"><label>NÚMERO CONSECUTIVO DE PAGO A PROVEEDORES</label></td>
            <td><input type="text" readonly style="background:#d7bde2" name="NUMERO_CONSECUTIVO_PROVEE" value="'.$row["NUMERO_CONSECUTIVO_PROVEE"].'"></td>
        </tr>

        <tr>
            <td style="background:#dfd9f3;"><label>TIPO DE PAGO</label></td>
            <td><input type="text" readonly style="background:#d7bde2" name="VIATICOSOPRO" value="'.$row["VIATICOSOPRO"].'"></td>
        </tr>

        <tr>
            <td style="background:#dfd9f3;"><label>NOMBRE COMERCIAL</label></td>
            <td><input type="text" readonly style="background:#d7bde2" name="NOMBRE_COMERCIAL" value="'.$row["NOMBRE_COMERCIAL"].'"></td>
        </tr>

        <tr>
            <td style="background:#dfd9f3;"><label>RAZÓN SOCIAL</label></td>
            <td><input type="text" readonly style="background:#d7bde2" name="RAZON_SOCIAL" value="'.$row["RAZON_SOCIAL"].'"></td>
        </tr>

        <tr>
            <td style="background:#dfd9f3;"><label>RFC DEL PROVEEDOR</label></td>
            <td><input type="text" readonly style="background:#d7bde2" name="RFC_PROVEEDOR" value="'.$row["RFC_PROVEEDOR"].'"></td>
        </tr>

        <tr>
            <td style="background:#dfd9f3;"><label>NÚMERO DE EVENTO</label></td>
            <td><input type="text" readonly style="background:#d7bde2" name="NUMERO_EVENTO" value="'.$row["NUMERO_EVENTO"].'"></td>
        </tr>

        <tr>
            <td style="background:#dfd9f3;"><label>NOMBRE DEL EVENTO</label></td>
            <td><input type="text" readonly style="background:#d7bde2" name="NOMBRE_EVENTO" value="'.$row["NOMBRE_EVENTO"].'"></td>
        </tr>

        <tr>
            <td style="background:#dfd9f3;"><label>MOTIVO DEL GASTO</label></td>
            <td><input type="text" readonly style="background:#d7bde2" name="MOTIVO_GASTO" value="'.$row["MOTIVO_GASTO"].'"></td>
        </tr>

        <tr>
            <td style="background:#dfd9f3;"><label>CONCEPTO</label></td>
            <td><input type="text" readonly style="background:#d7bde2" name="CONCEPTO_PROVEE" value="'.$row["CONCEPTO_PROVEE"].'"></td>
        </tr>

        <tr>
            <td style="background:#dfd9f3;"><label>MONTO TOTAL DE LA COTIZACIÓN O DEL ADEUDO</label></td>
            <td><input type="text" readonly style="background:#d7bde2" name="MONTO_TOTAL_COTIZACION_ADEUDO" value="'.$row["MONTO_TOTAL_COTIZACION_ADEUDO"].'"></td>
        </tr>

        <tr>
            <td style="background:#dfd9f3;"><label>SUB TOTAL</label></td>
            <td><input type="text" readonly style="background:#d7bde2" name="MONTO_FACTURA" id="montoTotalEvento" value="'.$row["MONTO_FACTURA"].'"></td>
        </tr>

        <tr>
            <td style="background:#dfd9f3;"><label>IVA</label></td>
            <td><input type="text" readonly style="background:#d7bde2" name="IVA" id="montoTotalAvion" value="'.$row["IVA"].'"></td>
        </tr>

        <tr>
            <td style="background:#dfd9f3;"><label>IMPUESTOS RETENIDOS IVA</label></td>
            <td><input type="text" readonly style="background:#d7bde2" name="TImpuestosRetenidosIVA" id="montoRetenidoIVA" value="'.$row["TImpuestosRetenidosIVA"].'"></td>
        </tr>

        <tr>
            <td style="background:#dfd9f3;"><label>IMPUESTOS RETENIDOS ISR</label></td>
            <td><input type="text" readonly style="background:#d7bde2" name="TImpuestosRetenidosISR" id="montoRetenidoISR" value="'.$row["TImpuestosRetenidosISR"].'"></td>
        </tr>

        <tr>
            <td style="background:#dfd9f3;"><label>MONTO DE LA PROPINA O SERVICIO NO INCLUIDO EN LA FACTURA</label></td>
            <td><input type="text" readonly style="background:#d7bde2" name="MONTO_PROPINA" id="montoTotalpropina" value="'.$row["MONTO_PROPINA"].'"></td>
        </tr>

        <tr>
            <td style="background:#dfd9f3;"><label>IMPUESTO SOBRE HOSPEDAJE MÁS EL IMPUESTO DE SANEAMIENTO</label></td>
            <td><input type="text" readonly style="background:#d7bde2" name="IMPUESTO_HOSPEDAJE" id="montoTotalhospedaje" value="'.$row["IMPUESTO_HOSPEDAJE"].'"></td>
        </tr>

        <tr>
            <td style="background:#dfd9f3;"><label>DESCUENTO</label></td>
            <td><input type="text" readonly style="background:#d7bde2" name="descuentos" id="montoDescuentos" value="'.$row["descuentos"].'"></td>
        </tr>

        <tr>
            <td style="background:#dfd9f3;"><label>TOTAL</label></td>
            <td><input type="text" readonly style="background:#decaf1" name="MONTO_DEPOSITAR" id="montoTotalEventoResultado" value="'.$row["MONTO_DEPOSITAR"].'"></td>
        </tr>

        <tr>
            <td style="background:#dfd9f3;"><label>TIPO DE CAMBIO</label></td>
            <td><input type="text" readonly style="background:#decaf1" name="TIPO_CAMBIOP" value="'.$row["TIPO_CAMBIOP"].'"></td>
        </tr>

        <tr>
            <td style="background:#dfd9f3;"><label>TOTAL DE LA CONVERSIÓN</label></td>
            <td><input type="text" readonly style="background:#decaf1" name="TOTAL_ENPESOS" value="'.$row["TOTAL_ENPESOS"].'"></td>
        </tr>

        <tr>
            <td style="background:#dfd9f3;"><label>FORMA DE PAGO</label></td>
            <td>
                <select name="PFORMADE_PAGO_VISUAL" style="background:#daddf5" disabled>
                    <option value="03" '.($row["PFORMADE_PAGO"]=="03"?"selected":"").'>03 TRANSFERENCIA ELECTRÓNICA</option>
                    <option value="01" '.($row["PFORMADE_PAGO"]=="01"?"selected":"").'>01 EFECTIVO</option>
                    <option value="02" '.($row["PFORMADE_PAGO"]=="02"?"selected":"").'>02 CHEQUE NOMINATIVO</option>
                    <option value="04" '.($row["PFORMADE_PAGO"]=="04"?"selected":"").'>04 TARJETA DE CRÉDITO</option>
                    <option value="05" '.($row["PFORMADE_PAGO"]=="05"?"selected":"").'>05 MONEDERO ELECTRÓNICO</option>
                    <option value="06" '.($row["PFORMADE_PAGO"]=="06"?"selected":"").'>06 DINERO ELECTRÓNICO</option>
                    <option value="08" '.($row["PFORMADE_PAGO"]=="08"?"selected":"").'>08 VALES DE DESPENSA</option>
                    <option value="28" '.($row["PFORMADE_PAGO"]=="28"?"selected":"").'>28 TARJETA DE DÉBITO</option>
                    <option value="29" '.($row["PFORMADE_PAGO"]=="29"?"selected":"").'>29 TARJETA DE SERVICIO</option>
                    <option value="99" '.($row["PFORMADE_PAGO"]=="99"?"selected":"").'>99 OTRO</option>
                </select>
                <input type="hidden" name="PFORMADE_PAGO" value="'.$row["PFORMADE_PAGO"].'">
            </td>
        </tr>

        <tr>
            <td style="background:#dfd9f3;"><label>MONTO DEPOSITADO</label></td>
            <td><input type="text" readonly style="background:#decaf1" name="MONTO_DEPOSITADO" value="'.$row["MONTO_DEPOSITADO"].'"></td>
        </tr>

        <tr>
            <td style="background:#dfd9f3;"><label>TIPO DE MONEDA O DIVISA</label></td>
            <td>
                <select name="TIPO_DE_MONEDA_VISUAL" style="background:#daddf5" disabled>
                    <option value="MXN" '.($row["TIPO_DE_MONEDA"]=="MXN"?"selected":"").'>MXN (Peso mexicano)</option>
                    <option value="USD" '.($row["TIPO_DE_MONEDA"]=="USD"?"selected":"").'>USD (Dólar)</option>
                    <option value="EUR" '.($row["TIPO_DE_MONEDA"]=="EUR"?"selected":"").'>EUR (Euro)</option>
                    <option value="GBP" '.($row["TIPO_DE_MONEDA"]=="GBP"?"selected":"").'>GBP (Libra esterlina)</option>
                    <option value="CHF" '.($row["TIPO_DE_MONEDA"]=="CHF"?"selected":"").'>CHF (Franco suizo)</option>
                    <option value="CNY" '.($row["TIPO_DE_MONEDA"]=="CNY"?"selected":"").'>CNY (Yuan)</option>
                    <option value="JPY" '.($row["TIPO_DE_MONEDA"]=="JPY"?"selected":"").'>JPY (Yen japonés)</option>
                    <option value="HKD" '.($row["TIPO_DE_MONEDA"]=="HKD"?"selected":"").'>HKD (Dólar hongkonés)</option>
                    <option value="CAD" '.($row["TIPO_DE_MONEDA"]=="CAD"?"selected":"").'>CAD (Dólar canadiense)</option>
                    <option value="AUD" '.($row["TIPO_DE_MONEDA"]=="AUD"?"selected":"").'>AUD (Dólar australiano)</option>
                    <option value="BRL" '.($row["TIPO_DE_MONEDA"]=="BRL"?"selected":"").'>BRL (Real brasileño)</option>
                    <option value="RUB" '.($row["TIPO_DE_MONEDA"]=="RUB"?"selected":"").'>RUB (Rublo ruso)</option>
                </select>
                <input type="hidden" name="TIPO_DE_MONEDA" value="'.$row["TIPO_DE_MONEDA"].'">
            </td>
        </tr>

        <tr>
            <td style="background:'.$fechaProgramacionColor.';"><label>FECHA DE PROGRAMACIÓN DEL PAGO</label></td>
            <td><input type="date" name="FECHA_DE_PAGO" value="'.$row["FECHA_DE_PAGO"].'"'.$fechaDePagoBloqueada.'></td>
        </tr>

        <tr>
            <td style="background:#dfd9f3;"><label>FECHA EFECTIVA DE PAGO</label></td>
            <td><input type="date" readonly style="background:#decaf1" name="FECHA_A_DEPOSITAR" value="'.$row["FECHA_A_DEPOSITAR"].'"></td>
        </tr>

        <tr>
            <td style="background:#dfd9f3;"><label>STATUS DE PAGO</label></td>
            <td class="form-control">'.$STATUS_DE_PAGO.'</td>
        </tr>

        <tr>
            <td style="font-weight:bold;background:#39FF14;"><label>COMPLEMENTOS DE PAGO (FORMATO XML)</label></td>
            <td>'.$zonaArchivo(
                'COMPLEMENTOS_PAGO_XML',
                $archivosActuales['COMPLEMENTOS_PAGO_XML'],
                $listaDoctos['COMPLEMENTOS_PAGO_XML']
            ).'</td>
        </tr>

        <tr>
            <td style="font-weight:bold;background:#39FF14;"><label>COMPLEMENTOS DE PAGO (FORMATO PDF)</label></td>
            <td>'.$zonaArchivo(
                'COMPLEMENTOS_PAGO_PDF',
                $archivosActuales['COMPLEMENTOS_PAGO_PDF'],
                $listaDoctos['COMPLEMENTOS_PAGO_PDF']
            ).'</td>
        </tr>

        <tr>
            <td style="background:#dfd9f3;"><label>ADJUNTAR COTIZACIÓN O REPORTE (CUALQUIER FORMATO)</label></td>
            <td>'.$zonaArchivoBloqueada(
                'ADJUNTAR_COTIZACION',
                $archivosActuales['ADJUNTAR_COTIZACION'],
                $listaDoctos['ADJUNTAR_COTIZACION']
            ).'</td>
        </tr>

        <tr>
            <td style="background:#dfd9f3;"><label>PÓLIZA NÚMERO</label></td>
            <td><input type="text" readonly style="background:#d7bde2" name="POLIZA_NUMERO" value="'.$row["POLIZA_NUMERO"].'"></td>
        </tr>

        <tr>
            <td style="background:#dfd9f3;"><label>NOMBRE DEL EJECUTIVO QUE INGRESÓ ESTA FACTURA</label></td>
            <td><input type="text" readonly style="background:#d7bde2" name="NOMBRE_DEL_AYUDO" value="'.$row["NOMBRE_DEL_AYUDO"].'"></td>
        </tr>

        <tr>
            <td style="background:#dfd9f3;"><label>NOMBRE DEL EJECUTIVO QUE REALIZÓ LA COMPRA</label></td>
            <td><input type="text" readonly style="background:#d7bde2" name="NOMBRE_DEL_EJECUTIVO" value="'.$row["NOMBRE_DEL_EJECUTIVO"].'"></td>
        </tr>

        <tr>
            <td style="background:#dfd9f3;"><label>OBSERVACIONES</label></td>
            <td><input type="text" readonly style="background:#d7bde2" name="OBSERVACIONES_1" value="'.$row["OBSERVACIONES_1"].'"></td>
        </tr>

        <tr>
            <td style="background:#dfd9f3;"><label>ADJUNTAR ARCHIVO RELACIONADO A ESTE GASTO</label></td>
            <td>'.$zonaArchivoBloqueada(
                'ADJUNTAR_ARCHIVO_1',
                $archivosActuales['ADJUNTAR_ARCHIVO_1'],
                $listaDoctos['ADJUNTAR_ARCHIVO_1']
            ).'</td>
        </tr>

        <tr>
            <td colspan="2">
                <table id="reseteaxml" style="width:100%;">'.$campos_xml.'</table>
            </td>
        </tr>

        <tr>
            <td><label>FECHA DE ÚLTIMA CARGA</label></td>
            <td><input type="text" readonly style="background:#decaf1" name="FECHA_DE_LLENADO" value="'.$row["FECHA_DE_LLENADO"].'"></td>
        </tr>

        </table>

        '.$hiddens.'

        <tr>
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp
            <td>
                <button class="btn btn-sm btn-outline-success px-5" type="button" id="clickPAGOP">GUARDAR</button></td><td>
                <div id="respuestaser2" class="d-inline-block ms-3"><div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

        <!-- Botón CERRAR al lado -->
        <button class="btn btn-sm btn-outline-success px-5" type="button" data-bs-dismiss="modal">CERRAR</button>
                <input type="hidden" value="ENVIARPAGOprovee" name="ENVIARPAGOprovee"/>
                <input type="hidden" value="'.$row["id"].'" name="IPpagoprovee" id="IPpagoprovee"/>
            </td>
        </tr>

        </div>
        </form>';

    } // end while

    echo $output;
}
?>

<script>
(function () {

    function calcularTotal() {
        var ids = ['montoTotalEvento','montoTotalAvion','montoTotalpropina',
                   'montoTotalhospedaje','montoRetenidoIVA','montoRetenidoISR','montoDescuentos'];
        var vals = ids.map(function(id) {
            var el = document.getElementById(id);
            return parseFloat((el ? el.value : '0').replace(/,/g,'')) || 0;
        });
        var total = vals[0] + vals[1] + vals[2] + vals[3] - vals[4] - vals[5] - vals[6];
        var res = document.getElementById('montoTotalEventoResultado');
        if (res) res.value = total.toFixed(2);
    }

    // Calcular al cargar
    calcularTotal();

    // ── Guardar ───────────────────────────────────────────────────────────
    $(document).ready(function () {
        $(document)
            .off('click', '#clickPAGOP')
            .on('click',  '#clickPAGOP', function () {
                $.ajax({
                    url: "pagoproveedores/controladorPP.php",
                    method: "POST",
                    data: $('#ListadoPAGOPROVEEform').serialize(),
                    beforeSend: function () {
                        $('#mensajepagoproveedores').html('cargando...');
                    },
        success: function (data) {
                        var r = $.trim(data).toLowerCase();
                        if (r.indexOf('actualizado') !== -1 || r.indexOf('ingresado') !== -1) {
                            $('#dataModal').modal('hide');
                            if (typeof load === 'function') load(1);
                            $("#mensajepagoproveedores").html("<span id='ACTUALIZADO'>" + $.trim(data) + "</span>");
                            $("#respuestaser2").html("<span id='ACTUALIZADO'>" + $.trim(data) + "</span>");
                        } else {
                            if (r.indexOf('favor de llenar campos obligatorios') !== -1) {
                                $("#respuestaser2").html("<span id='ACTUALIZADO'>" + $.trim(data) + "</span>");
                                $("#mensajepagoproveedores").html('');
                            } else {
                                $("#mensajepagoproveedores").html(data);
                            }
                        }
                    }
                });
            });
    });


    // ── Subida de archivos (zonas activas: COMPLEMENTOS_PAGO_XML y COMPLEMENTOS_PAGO_PDF) ──
    window.upload_file2 = function (e, name) {
        e.preventDefault();
        ajax_file_upload2(e.dataTransfer.files[0], name);
    };

    window.file_explorer2 = function (name) {
        var input = document.getElementsByName(name)[0];
        if (!input) return;
        input.click();
        input.onchange = function () { ajax_file_upload2(input.files[0], name); };
    };

    function ajax_file_upload2(file_obj, nombre) {
        if (!file_obj) return;
        var form_data = new FormData();
        form_data.append(nombre, file_obj);
        form_data.append("IPpagoprovee", $("#IPpagoprovee").val());

        $.ajax({
            type: 'POST',
            url: "pagoproveedores/controladorPP.php",
            dataType: "html",
            contentType: false,
            processData: false,
            data: form_data,
            beforeSend: function () {
                $('#3' + nombre).html('<p style="color:green;"><span class="spinner-border spinner-border-sm"></span> Cargando archivo...</p>');
                $('#respuestaser').html('<p style="color:green;">Actualizando...</p>');
            },
            success: function (response) {
                var resp  = $.trim(response);
                var parts = resp.split('^^');

                if (resp === '2') {
                    $('#3' + nombre).html('<p style="color:red;">Error: archivo diferente a PDF, JPG o GIF.</p>');
                    $('[name="' + nombre + '"]').val('');

                } else if (parts[0] === '3') {
                    var numSol = $.trim(parts[1] || '');
                    $('#3' + nombre).html(numSol
                        ? '<p style="color:red;font-weight:600;">⚠️ UUID YA REGISTRADO — Solicitud: <strong>' + numSol + '</strong></p>'
                        : '<p style="color:red;font-weight:600;">⚠️ UUID PREVIAMENTE CARGADO.</p>');
                    $('[name="' + nombre + '"]').val('');

                } else if (resp === '4') {
                    var fmt = (nombre.indexOf('XML') !== -1) ? 'XML' : 'PDF';
                    $('#3' + nombre).html('<p style="color:red;">ESTE ARCHIVO TIENE QUE SER EN FORMATO ' + fmt + '.</p>');
                    $('[name="' + nombre + '"]').val('');

                } else if (parts[0] === '5') {
                    $('#3' + nombre).html('<p style="color:red;font-weight:600;">⚠️ El XML está vacío o no contiene información válida.</p>');
                    $('[name="' + nombre + '"]').val('');

                } else {
                    var nombreArchivo = parts[0];
                    var uuid          = $.trim(parts[1] || '');
                    var formaPago     = $.trim(parts[2] || '');

                    $('#3' + nombre).html(
                        '<p style="color:green;">✅ ¡Archivo cargado con éxito!</p>' +
                        '<a target="_blank" href="includes/archivos/' + nombreArchivo + '">Visualizar!</a>'
                    );

                    if (formaPago.length) {
                        $('input[name="PFORMADE_PAGO"]').val(formaPago);
                    }

                    if (nombre === 'ADJUNTAR_FACTURA_XML' && uuid.length > 1) {
                        $('#respuestaser').html(
                            '<p style="color:green;font-size:14px;font-weight:bold;">✅ XML cargado — UUID: ' + uuid + '</p>'
                        );
                        $('#reseteaxml').remove();
                    } else {
                        $('#respuestaser').html('<p style="color:green;">✅ Actualizado</p>');
                    }
                }
            }
        });
    }

})();
</script>
