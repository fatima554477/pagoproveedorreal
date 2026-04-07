<?php
/*
fecha fatis : 04/04/2024
ACTUALIZADO: fixes archivos desde 02SUBETUFACTURADOCTOS — ventasoperaciones3
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
            'ADJUNTAR_FACTURA_XML', 'ADJUNTAR_FACTURA_PDF', 'ADJUNTAR_COTIZACION',
            'CONPROBANTE_TRANSFERENCIA', 'FOTO_ESTADO_PROVEE11', 'COMPLEMENTOS_PAGO_PDF',
            'COMPLEMENTOS_PAGO_XML', 'CANCELACIONES_PDF', 'CANCELACIONES_XML',
            'ADJUNTAR_FACTURA_DE_COMISION_PDF', 'ADJUNTAR_FACTURA_DE_COMISION_XML',
            'CALCULO_DE_COMISION', 'COMPROBANTE_DE_DEVOLUCION', 'NOTA_DE_CREDITO_COMPRA',
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
                            . " <span id='" . $rowDoc['id'] . "' class='view_dataSBborrar2' style='cursor:pointer;color:blue;'>Borrar!</span>"
                            . " <span>" . $rowDoc['fechaingreso'] . "</span><br/>";
                    }
                }
            }
        }
        // ─────────────────────────────────────────────────────────────────

        // Status de pago (editable en doc7)
        $SOLICITADO = $APROBADO = $PAGADO = $RECHAZADO = '';
        if($row['STATUS_DE_PAGO'] == "SOLICITADO")    { $SOLICITADO = "selected"; }
        elseif($row['STATUS_DE_PAGO'] == "APROBADO")  { $APROBADO   = "selected"; }
        elseif($row['STATUS_DE_PAGO'] == "PAGADO")    { $PAGADO     = "selected"; }
        elseif($row['STATUS_DE_PAGO'] == "RECHAZADO") { $RECHAZADO  = "selected"; }

        $STATUS_DE_PAGO  = '<select required name="STATUS_DE_PAGO">';
        $STATUS_DE_PAGO .= '<option style="background:#d9f9fa" value="SOLICITADO" '.$SOLICITADO.'>SOLICITADO</option>';
        $STATUS_DE_PAGO .= '<option style="background:#e1f5de" value="APROBADO"   '.$APROBADO.'>APROBADO</option>';
        $STATUS_DE_PAGO .= '<option style="background:#f5deee" value="PAGADO"     '.$PAGADO.'>PAGADO</option>';
        $STATUS_DE_PAGO .= '<option style="background:#f5f4de" value="RECHAZADO"  '.$RECHAZADO.'>RECHAZADO</option>';
        $STATUS_DE_PAGO .= '</select>';

        // Bloquear facturas si ID_RELACIONADO vacío
        $disableFactura   = (empty($row["ID_RELACIONADO"]) || trim($row["ID_RELACIONADO"]) == "");
        $facturaAttr      = $disableFactura ? ' disabled="disabled"' : '';
        $facturaZoneStyle = $disableFactura
            ? 'style="width:300px;pointer-events:none;opacity:0.6;"'
            : 'style="width:300px;"';

        // Forma de pago: bloquear si viene del XML
        $lockFormaPago  = (!empty(trim((string)$row2xml["formaDePago"]))) ? '1' : '0';

        // ── Helper zona de carga ──────────────────────────────────────────
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

        // ── Bloque XML ────────────────────────────────────────────────────
        $campos_xml = '';
        if ($row2xml["Version"] == 'no' || $row2xml["Version"] == '') {
            $campos_xml = '
            <tr style="background:#fbf696;"><td style="font-weight:bold;"><label>NOMBRE RECEPTOR</label></td>
                <td><input type="text" readonly style="background:#decaf1" name="nombreR" value="'.$row2xml["nombreR"].'"></td></tr>
            <tr style="background:#fbf696;"><td style="font-weight:bold;"><label>RFC RECEPTOR</label></td>
                <td><input type="text" readonly style="background:#decaf1" name="rfcR" value="'.$row2xml["rfcR"].'"></td></tr>
            <tr style="background:#fbf696;"><td style="font-weight:bold;"><label>RÉGIMEN FISCAL</label></td>
                <td><input type="text" readonly style="background:#decaf1" name="regimenE" value="'.$row2xml["regimenE"].'"></td></tr>
            <tr style="background:#fbf696;"><td style="font-weight:bold;"><label>UUID</label></td>
                <td><input type="text" readonly style="background:#decaf1" name="UUID" value="'.$row2xml["UUID"].'"></td></tr>
            <tr style="background:#fbf696;"><td style="font-weight:bold;"><label>FOLIO</label></td>
                <td><input type="text" readonly style="background:#decaf1" name="folio" value="'.$row2xml["folio"].'"></td></tr>
            <tr style="background:#fbf696;"><td style="font-weight:bold;"><label>SERIE</label></td>
                <td><input type="text" readonly style="background:#decaf1" name="serie" value="'.$row2xml["serie"].'"></td></tr>
            <tr style="background:#fbf696;"><td style="font-weight:bold;"><label>CLAVE DE UNIDAD</label></td>
                <td><input type="text" readonly style="background:#decaf1" name="ClaveUnidadConcepto" value="'.$row2xml["ClaveUnidadConcepto"].'"></td></tr>
            <tr style="background:#fbf696;"><td style="font-weight:bold;"><label>CANTIDAD</label></td>
                <td><input type="text" readonly style="background:#decaf1" name="CantidadConcepto" value="'.$row2xml["CantidadConcepto"].'"></td></tr>
            <tr style="background:#fbf696;"><td style="font-weight:bold;"><label>CLAVE DE PRODUCTO O SERVICIO</label></td>
                <td><input type="text" readonly style="background:#decaf1" name="ClaveProdServConcepto" value="'.$row2xml["ClaveProdServConcepto"].'"></td></tr>
            <tr style="background:#fbf696;"><td style="font-weight:bold;"><label>DESCRIPCIÓN</label></td>
                <td><input type="text" readonly style="background:#decaf1" name="DescripcionConcepto" value="'.$row2xml["DescripcionConcepto"].'"></td></tr>
            <tr style="background:#fbf696;"><td style="font-weight:bold;"><label>MONEDA</label></td>
                <td><input type="text" readonly style="background:#decaf1" name="Moneda" value="'.$row2xml["Moneda"].'"></td></tr>
            <tr style="background:#fbf696;"><td style="font-weight:bold;"><label>TIPO DE CAMBIO</label></td>
                <td><input type="text" readonly style="background:#decaf1" name="TipoCambio" value="'.$row2xml["TipoCambio"].'"></td></tr>
            <tr style="background:#fbf696;"><td style="font-weight:bold;"><label>USO DE CFDI</label></td>
                <td><input type="text" readonly style="background:#decaf1" name="UsoCFDI" value="'.$row2xml["UsoCFDI"].'"></td></tr>
            <tr style="background:#fbf696;"><td style="font-weight:bold;"><label>MÉTODO DE PAGO</label></td>
                <td><input type="text" readonly style="background:#decaf1" name="metodoDePago" value="'.$row2xml["metodoDePago"].'"></td></tr>
            <tr style="background:#fbf696;"><td style="font-weight:bold;"><label>CONDICIONES DE PAGO</label></td>
                <td><input type="text" readonly style="background:#decaf1" name="condicionesDePago" value="'.$row2xml["condicionesDePago"].'"></td></tr>
            <tr style="background:#fbf696;"><td style="font-weight:bold;"><label>TIPO DE COMPROBANTE</label></td>
                <td><input type="text" readonly style="background:#decaf1" name="tipoDeComprobante" value="'.$row2xml["tipoDeComprobante"].'"></td></tr>
            <tr style="background:#fbf696;"><td style="font-weight:bold;"><label>VERSIÓN</label></td>
                <td><input type="text" readonly style="background:#decaf1" name="Version" value="'.$row2xml["Version"].'"></td></tr>
            <input type="hidden" name="actualiza" value="true">
            <tr style="background:#fbf696;"><td style="font-weight:bold;"><label>FECHA DE TIMBRADO</label></td>
                <td><input type="text" readonly style="background:#decaf1" name="fechaTimbrado" value="'.$row2xml["fechaTimbrado"].'"></td></tr>
            <tr style="background:#fbf696;"><td style="font-weight:bold;"><label>SUBTOTAL</label></td>
                <td><input type="text" readonly style="background:#decaf1" name="subTotal" value="'.$row2xml["subTotal"].'"></td></tr>
            <tr style="background:#fbf696;"><td style="font-weight:bold;"><label>SERVICIO, PROPINA, ISH Y SANEAMIENTO</label></td>
                <td><input type="text" readonly style="background:#decaf1" name="Propina" value="'.$row2xml["Propina"].'"></td></tr>
            <tr style="background:#fbf696;"><td style="font-weight:bold;"><label>DESCUENTO</label></td>
                <td><input type="text" readonly style="background:#decaf1" name="DESCUENTO" value="'.$row2xml["Descuento"].'"></td></tr>
            <tr style="background:#fbf696;"><td style="font-weight:bold;"><label>TOTAL DE IMPUESTOS TRASLADADOS</label></td>
                <td><input type="text" readonly style="background:#decaf1" name="TImpuestosTrasladados" value="'.$row2xml["TImpuestosTrasladados"].'"></td></tr>
            <tr style="background:#fbf696;"><td style="font-weight:bold;"><label>TOTAL DE IMPUESTOS RETENIDOS</label></td>
                <td><input type="text" readonly style="background:#decaf1" name="TImpuestosRetenidos" value="'.$row2xml["TImpuestosRetenidos"].'"></td></tr>
            <tr style="background:#fbf696;"><td style="font-weight:bold;"><label>TUA</label></td>
                <td><input type="text" readonly style="background:#decaf1" name="TUA" value="'.$row2xml["TUA"].'"></td></tr>
            <tr style="background:#fbf696;"><td style="font-weight:bold;"><label>TOTAL</label></td>
                <td><input type="text" readonly style="background:#decaf1" name="totalf" value="'.$row2xml["totalf"].'"></td></tr>
            <tr style="background:#fbf696;"><td style="font-weight:bold;"><label>TUA TOTAL CARGOS</label></td>
                <td><input type="text" readonly style="background:#decaf1" name="TuaTotalCargos" value="'.$row2xml["TuaTotalCargos"].'"></td></tr>';
        }

        $output .= '
        <div id="respuestaser"></div>
        <form id="ListadoPAGOPROVEEform">
        <div class="table-responsive">
        <table class="table table-bordered" style="background:#ebf9e9;">

        <tr>
            <td width="30%" style="font-weight:bold;">ADJUNTAR FACTURA (FORMATO XML)</td>
            <td width="70%">'.$zonaArchivo('ADJUNTAR_FACTURA_XML', $archivosActuales['ADJUNTAR_FACTURA_XML'], $listaDoctos['ADJUNTAR_FACTURA_XML'], $facturaAttr, $facturaZoneStyle).'</td>
        </tr>
        <tr>
            <td width="30%" style="font-weight:bold;">ADJUNTAR FACTURA (FORMATO PDF)</td>
            <td width="70%">'.$zonaArchivo('ADJUNTAR_FACTURA_PDF', $archivosActuales['ADJUNTAR_FACTURA_PDF'], $listaDoctos['ADJUNTAR_FACTURA_PDF'], $facturaAttr, $facturaZoneStyle).'</td>
        </tr>

        <tr style="background:#F368E7;">
            <td style="font-weight:bold;">NÚMERO DE SOLICITUD</td>
            <td><input type="text" name="NUMERO_CONSECUTIVO_PROVEE" value="'.$row["NUMERO_CONSECUTIVO_PROVEE"].'"></td>
        </tr>
        <tr style="background:#F368E7;">
            <td style="font-weight:bold;">ID RELACIONADO</td>
            <td><input type="text" name="ID_RELACIONADO" value="'.$row["ID_RELACIONADO"].'"></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">TIPO DE PAGO</td>
            <td>
                <select name="VIATICOSOPRO" style="background:#daddf5">
                    <option value="SELECCIONA UNA OPCIÓN">SELECCIONA UNA OPCIÓN</option>
                    <option value="PAGO A PROVEEDOR"                        '.($row["VIATICOSOPRO"]=="PAGO A PROVEEDOR"?"selected":"").'>PAGO A PROVEEDOR</option>
                    <option value="PAGO A PROVEEDOR CON DOS O MAS FACTURAS" '.($row["VIATICOSOPRO"]=="PAGO A PROVEEDOR CON DOS O MAS FACTURAS"?"selected":"").'>PAGO A PROVEEDOR CON DOS O MAS FACTURAS</option>
                    <option value="PAGOS CON UNA SOLA FACTURA"              '.($row["VIATICOSOPRO"]=="PAGOS CON UNA SOLA FACTURA"?"selected":"").'>PAGOS CON UNA SOLA FACTURA</option>
                    <option value="VIATICOS"                                '.($row["VIATICOSOPRO"]=="VIATICOS"?"selected":"").'>VIATICOS</option>
                    <option value="REEMBOLSO"                               '.($row["VIATICOSOPRO"]=="REEMBOLSO"?"selected":"").'>REEMBOLSO</option>
                </select>
            </td>
        </tr>
        <tr>
            <td style="font-weight:bold;">NOMBRE COMERCIAL</td>
            <td><input type="text" name="NOMBRE_COMERCIAL" value="'.$row["NOMBRE_COMERCIAL"].'"></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">RAZÓN SOCIAL</td>
            <td><input type="text" name="RAZON_SOCIAL" value="'.$row["RAZON_SOCIAL"].'"></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">RFC DEL PROVEEDOR</td>
            <td><input type="text" name="RFC_PROVEEDOR" value="'.$row["RFC_PROVEEDOR"].'"></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">NÚMERO DE EVENTO</td>
            <td><input type="text" name="NUMERO_EVENTO" value="'.$row["NUMERO_EVENTO"].'"></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">NOMBRE DEL EVENTO</td>
            <td><input type="text" name="NOMBRE_EVENTO" value="'.$row["NOMBRE_EVENTO"].'"></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">MOTIVO DEL GASTO</td>
            <td><input type="text" name="MOTIVO_GASTO" value="'.$row["MOTIVO_GASTO"].'"></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">CONCEPTO</td>
            <td><input type="text" name="CONCEPTO_PROVEE" value="'.$row["CONCEPTO_PROVEE"].'"></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">MONTO TOTAL DE LA COTIZACIÓN O DEL ADEUDO</td>
            <td><input type="text" name="MONTO_TOTAL_COTIZACION_ADEUDO" value="'.$row["MONTO_TOTAL_COTIZACION_ADEUDO"].'"></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">SUB TOTAL</td>
            <td><input type="text" name="MONTO_FACTURA" id="montoTotalEvento" value="'.$row["MONTO_FACTURA"].'"></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">IVA</td>
            <td><input type="text" name="IVA" id="montoTotalAvion" value="'.$row["IVA"].'"></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">IMPUESTOS RETENIDOS IVA</td>
            <td><input type="text" name="TImpuestosRetenidosIVA" id="montoRetenidoIVA" value="'.$row["TImpuestosRetenidosIVA"].'"></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">IMPUESTOS RETENIDOS ISR</td>
            <td><input type="text" name="TImpuestosRetenidosISR" id="montoRetenidoISR" value="'.$row["TImpuestosRetenidosISR"].'"></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">MONTO DE LA PROPINA O SERVICIO NO INCLUIDO EN LA FACTURA</td>
            <td><input type="text" name="MONTO_PROPINA" id="montoTotalpropina" value="'.$row["MONTO_PROPINA"].'"></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">IMPUESTO SOBRE HOSPEDAJE MÁS EL IMPUESTO DE SANEAMIENTO</td>
            <td><input type="text" name="IMPUESTO_HOSPEDAJE" id="montoTotalhospedaje" value="'.$row["IMPUESTO_HOSPEDAJE"].'"></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">DESCUENTO</td>
            <td><input type="text" name="descuentos" id="montoDescuentos" value="'.$row["descuentos"].'"></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">TOTAL</td>
            <td><input type="text" readonly style="background:#decaf1" name="MONTO_DEPOSITAR" id="montoTotalEventoResultado" value="'.$row["MONTO_DEPOSITAR"].'"></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">TIPO DE CAMBIO</td>
            <td><input type="text" name="TIPO_CAMBIOP" value="'.$row["TIPO_CAMBIOP"].'"></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">TOTAL DE LA CONVERSIÓN</td>
            <td><input type="text" name="TOTAL_ENPESOS" value="'.$row["TOTAL_ENPESOS"].'"></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">FORMA DE PAGO</td>
            <td>
                <select id="formaDePagoSelect" name="PFORMADE_PAGO" data-lock-xml="'.$lockFormaPago.'" style="background:#daddf5">
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
                <input type="hidden" id="formaDePagoHidden" name="" value="">
            </td>
        </tr>
        <tr style="background:#f1a766;">
            <td style="font-weight:bold;">MONTO DEPOSITADO</td>
            <td><input type="text" name="MONTO_DEPOSITADO" value="'.$row["MONTO_DEPOSITADO"].'"></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">TIPO DE MONEDA O DIVISA</td>
            <td>
                <select name="TIPO_DE_MONEDA" style="background:#daddf5">
                    <option value="SELECCIONA UNA OPCIÓN">SELECCIONA UNA OPCIÓN</option>
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
            </td>
        </tr>
        <tr>
            <td style="font-weight:bold;">FECHA DE PROGRAMACIÓN DEL PAGO</td>
            <td><input type="date" name="FECHA_DE_PAGO" value="'.$row["FECHA_DE_PAGO"].'"></td>
        </tr>
        <tr style="background:#f1a766;">
            <td style="font-weight:bold;">FECHA EFECTIVA DE PAGO</td>
            <td><input type="date" name="FECHA_A_DEPOSITAR" value="'.$row["FECHA_A_DEPOSITAR"].'"></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">STATUS DE PAGO</td>
            <td class="form-control">'.$STATUS_DE_PAGO.'</td>
        </tr>
        <tr style="background:#f1a766;">
            <td style="font-weight:bold;">ADJUNTAR COTIZACIÓN O REPORTE (CUALQUIER FORMATO)</td>
            <td>'.$zonaArchivo('ADJUNTAR_COTIZACION', $archivosActuales['ADJUNTAR_COTIZACION'], $listaDoctos['ADJUNTAR_COTIZACION']).'</td>
        </tr>
        <tr>
            <td style="font-weight:bold;">ACTIVO FIJO</td>
            <td><input type="text" name="ACTIVO_FIJO" value="'.$row["ACTIVO_FIJO"].'"></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">GASTO FIJO</td>
            <td><input type="text" name="GASTO_FIJO" value="'.$row["GASTO_FIJO"].'"></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">PAGAR CADA</td>
            <td><input type="text" name="PAGAR_CADA" value="'.$row["PAGAR_CADA"].'"></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">FECHA DE PROGRAMACIÓN DE PAGO</td>
            <td><input type="date" name="FECHA_PPAGO" value="'.$row["FECHA_PPAGO"].'"></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">FECHA DE TERMINACIÓN DE LA PROGRAMACIÓN</td>
            <td><input type="date" name="FECHA_TPROGRAPAGO" value="'.$row["FECHA_TPROGRAPAGO"].'"></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">NÚMERO DE EVENTO (FIJO) PARA PROGRAMACIÓN</td>
            <td><input type="text" name="NUMERO_EVENTOFIJO" value="'.$row["NUMERO_EVENTOFIJO"].'"></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">CLASIFICACIÓN GENERAL</td>
            <td><input type="text" name="CLASI_GENERAL" value="'.$row["CLASI_GENERAL"].'"></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">SUB CLASIFICACIÓN GENERAL</td>
            <td><input type="text" name="SUB_GENERAL" value="'.$row["SUB_GENERAL"].'"></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">INSTITUCIÓN BANCARIA</td>
            <td><input type="text" name="BANCO_ORIGEN" value="'.$row["BANCO_ORIGEN"].'"></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">PLACAS DEL VEHÍCULO</td>
            <td><input type="text" name="PLACAS_VEHICULO" value="'.$row["PLACAS_VEHICULO"].'"></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">COMPROBANTE DE TRANSFERENCIA (FORMATO PDF)</td>
            <td>'.$zonaArchivo('CONPROBANTE_TRANSFERENCIA', $archivosActuales['CONPROBANTE_TRANSFERENCIA'], $listaDoctos['CONPROBANTE_TRANSFERENCIA']).'</td>
        </tr>
        <tr>
            <td style="font-weight:bold;">COMPLEMENTOS DE PAGO (FORMATO PDF)</td>
            <td>'.$zonaArchivo('COMPLEMENTOS_PAGO_PDF', $archivosActuales['COMPLEMENTOS_PAGO_PDF'], $listaDoctos['COMPLEMENTOS_PAGO_PDF']).'</td>
        </tr>
        <tr>
            <td style="font-weight:bold;">COMPLEMENTOS DE PAGO (FORMATO XML)</td>
            <td>'.$zonaArchivo('COMPLEMENTOS_PAGO_XML', $archivosActuales['COMPLEMENTOS_PAGO_XML'], $listaDoctos['COMPLEMENTOS_PAGO_XML']).'</td>
        </tr>
        <tr>
            <td style="font-weight:bold;">ADJUNTAR CANCELACIONES (FORMATO PDF)</td>
            <td>'.$zonaArchivo('CANCELACIONES_PDF', $archivosActuales['CANCELACIONES_PDF'], $listaDoctos['CANCELACIONES_PDF']).'</td>
        </tr>
        <tr>
            <td style="font-weight:bold;">ADJUNTAR CANCELACIONES (FORMATO XML)</td>
            <td>'.$zonaArchivo('CANCELACIONES_XML', $archivosActuales['CANCELACIONES_XML'], $listaDoctos['CANCELACIONES_XML']).'</td>
        </tr>
        <tr>
            <td style="font-weight:bold;">ADJUNTAR FACTURA DE COMISIÓN DESCONTADA (FORMATO PDF)</td>
            <td>'.$zonaArchivo('ADJUNTAR_FACTURA_DE_COMISION_PDF', $archivosActuales['ADJUNTAR_FACTURA_DE_COMISION_PDF'], $listaDoctos['ADJUNTAR_FACTURA_DE_COMISION_PDF']).'</td>
        </tr>
        <tr>
            <td style="font-weight:bold;">ADJUNTAR FACTURA DE COMISIÓN DESCONTADA (FORMATO XML)</td>
            <td>'.$zonaArchivo('ADJUNTAR_FACTURA_DE_COMISION_XML', $archivosActuales['ADJUNTAR_FACTURA_DE_COMISION_XML'], $listaDoctos['ADJUNTAR_FACTURA_DE_COMISION_XML']).'</td>
        </tr>
        <tr>
            <td style="font-weight:bold;">ADJUNTAR CÁLCULO DE COMISIÓN</td>
            <td>'.$zonaArchivo('CALCULO_DE_COMISION', $archivosActuales['CALCULO_DE_COMISION'], $listaDoctos['CALCULO_DE_COMISION']).'</td>
        </tr>
        <tr>
            <td style="font-weight:bold;">MONTO DE COMISIÓN</td>
            <td><input type="text" name="MONTO_DE_COMISION" value="'.$row["MONTO_DE_COMISION"].'"></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">ADJUNTAR COMPROBANTE DE DEVOLUCIÓN DE DINERO A EPC</td>
            <td>'.$zonaArchivo('COMPROBANTE_DE_DEVOLUCION', $archivosActuales['COMPROBANTE_DE_DEVOLUCION'], $listaDoctos['COMPROBANTE_DE_DEVOLUCION']).'</td>
        </tr>
        <tr>
            <td style="font-weight:bold;">ADJUNTAR NOTA DE CRÉDITO DE COMPRA</td>
            <td>'.$zonaArchivo('NOTA_DE_CREDITO_COMPRA', $archivosActuales['NOTA_DE_CREDITO_COMPRA'], $listaDoctos['NOTA_DE_CREDITO_COMPRA']).'</td>
        </tr>
        <tr style="background:#f1a766;">
            <td style="font-weight:bold;">PÓLIZA NÚMERO</td>
            <td><input type="text" name="POLIZA_NUMERO" value="'.$row["POLIZA_NUMERO"].'"></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">NOMBRE DEL EJECUTIVO QUE INGRESÓ ESTA FACTURA</td>
            <td><input type="text" name="NOMBRE_DEL_AYUDO" value="'.$row["NOMBRE_DEL_AYUDO"].'"></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">NOMBRE DEL EJECUTIVO QUE REALIZÓ LA COMPRA</td>
            <td><input type="text" name="NOMBRE_DEL_EJECUTIVO" value="'.$row["NOMBRE_DEL_EJECUTIVO"].'"></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">OBSERVACIONES</td>
            <td><input type="text" name="OBSERVACIONES_1" value="'.$row["OBSERVACIONES_1"].'"></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">ADJUNTAR ARCHIVO RELACIONADO A ESTE GASTO</td>
            <td>'.$zonaArchivo('ADJUNTAR_ARCHIVO_1', $archivosActuales['ADJUNTAR_ARCHIVO_1'], $listaDoctos['ADJUNTAR_ARCHIVO_1']).'</td>
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

        <tr>
            <td></td>
            <td>
                <button class="btn btn-sm btn-outline-success px-5" type="button" id="clickPAGOP">GUARDAR</button>
                <div id="respuestaser2" class="d-inline-block ms-3"></div>
                <button class="btn btn-sm btn-outline-success px-5" type="button" data-bs-dismiss="modal">CERRAR</button>
                <input type="hidden" value="ENVIARPAGOprovee" name="ENVIARPAGOprovee"/>
                <input type="hidden" value="'.$row["id"].'" name="IPpagoprovee" id="IPpagoprovee"/>
            </td>
        </tr>
        </div></form>';

    } // end while

    echo $output;
}
?>

<script>
(function () {

    // ── Forma de pago: bloquear si viene del XML ──────────────────────────
    $(document).ready(function () {
        var sel = document.getElementById('formaDePagoSelect');
        if (sel && sel.getAttribute('data-lock-xml') === '1') {
            sel.disabled = true;
            document.getElementById('formaDePagoHidden').name  = 'PFORMADE_PAGO';
            document.getElementById('formaDePagoHidden').value = sel.value;
        }
    });

    window.bloquearFormaPagoDesdeXml = function(formaPago) {
        var sel = document.getElementById('formaDePagoSelect');
        if (!sel || !formaPago) return;
        sel.value    = formaPago;
        sel.disabled = true;
        var hidden   = document.getElementById('formaDePagoHidden');
        hidden.name  = 'PFORMADE_PAGO';
        hidden.value = formaPago;
    };

    // ── Calcular total ────────────────────────────────────────────────────
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

    calcularTotal();
    ['montoTotalEvento','montoTotalAvion','montoTotalpropina','montoTotalhospedaje',
     'montoRetenidoIVA','montoRetenidoISR','montoDescuentos'].forEach(function(id) {
        var el = document.getElementById(id);
        if (el) el.addEventListener('input', calcularTotal);
    });

    // ── Subida de archivos (inmediata — ventasoperaciones3) ───────────────
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
            url: "ventasoperaciones3/controladorPP.php",
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
                    var fmt = (nombre === 'ADJUNTAR_FACTURA_XML') ? 'XML' : 'PDF';
                    $('#3' + nombre).html('<p style="color:red;">ESTE ARCHIVO TIENE QUE SER EN FORMATO ' + fmt + '.</p>');
                    $('[name="' + nombre + '"]').val('');

                } else if (parts[0] === '5') {
                    $('#3' + nombre).html('<p style="color:red;font-weight:600;">⚠️ El XML está vacío o no contiene información válida.</p>');
                    $('[name="' + nombre + '"]').val('');

                } else {
                    var nombreArchivo = $.trim(parts[0]);
                    var uuid          = $.trim(parts[1] || '');
                    var formaPago     = $.trim(parts[2] || '');

                    $('#3' + nombre).html(
                        '<p style="color:green;">✅ ¡Archivo cargado!</p>' +
                        '<a target="_blank" href="includes/archivos/' + nombreArchivo + '">Visualizar!</a>'
                    );

                    if (formaPago.length) {
                        bloquearFormaPagoDesdeXml(formaPago);
                    }

                    if (nombre === 'ADJUNTAR_FACTURA_XML' && uuid.length > 1) {
                        $('#respuestaser').html(
                            '<p style="color:green;font-size:18px;font-weight:bold;">✅ XML cargado — UUID: ' + uuid + '</p>'
                        );
                        $('#reseteaxml').remove();
                    } else {
                        $('#respuestaser').html('<p style="color:green;">✅ Actualizado</p>');
                    }
                }
            }
        });
    }

    // ── Guardar ───────────────────────────────────────────────────────────
    $(document).ready(function () {
        $(document)
            .off('click', '#clickPAGOP')
            .on('click',  '#clickPAGOP', function () {
                $.ajax({
                    url: "ventasoperaciones3/controladorPP.php",
                    method: "POST",
                    data: $('#ListadoPAGOPROVEEform').serialize(),
                    success: function (data) {
                        var r = $.trim(data).toLowerCase();
                        if (r.indexOf('actualizado') !== -1 || r.indexOf('ingresado') !== -1) {
                            if (typeof load === 'function') load(1);
                            $("#respuestaser").html("<span id='ACTUALIZADO'>" + $.trim(data) + "</span>");
                            $("#respuestaser2").html("<span id='ACTUALIZADO'>" + $.trim(data) + "</span>");
                            setTimeout(function () {
                                $("#respuestaser2").fadeOut(300, function(){ $(this).html('').show(); });
                            }, 2000);
                        } else {
                            $("#respuestaser").html(data);
                        }
                    }
                });
            });
    });

})();
</script>
