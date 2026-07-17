<?php
// Exportación descargable: no imprimir HTML previo para no corromper el XLSX.
if(!isset($_SESSION)) { session_start(); }
define("__ROOT6__", dirname(__FILE__));
require(__ROOT6__."/class.filtro.php");

$database = new orders();
$DEPARTAMENTO = !empty($_POST["DEPARTAMENTO2"]) ? $_POST["DEPARTAMENTO2"] : "DEFAULT";
$nombreTabla = "SELECT * FROM `08pagoproveedoresfiltroDes`, 08altaeventosfiltroPLA WHERE 08pagoproveedoresfiltroDes.id = 08altaeventosfiltroPLA.idRelacion";
$altaeventos = "pagoProveedores";
$tables = "02SUBETUFACTURADOCTOS";
$campos = "02SUBETUFACTURA.*, 02XML.*, 04altaeventos.FECHA_INICIO_EVENTO AS FECHA_INICIO_EVENTO, 04altaeventos.FECHA_FINAL_EVENTO AS FECHA_FINAL_EVENTO";

$keys = array('NUMERO_CONSECUTIVO_PROVEE','NOMBRE_COMERCIAL','RAZON_SOCIAL','VIATICOSOPRO','RFC_PROVEEDOR','NUMERO_EVENTO','NOMBRE_EVENTO','MOTIVO_GASTO','CONCEPTO_PROVEE','MONTO_TOTAL_COTIZACION_ADEUDO','MONTO_FACTURA','MONTO_PROPINA','MONTO_DEPOSITAR','MONTO_DEPOSITADO','TIPO_DE_MONEDA','PFORMADE_PAGO','FECHA_DE_PAGO','FECHA_DE_PAGO2a','FECHA_DE_PAGO_VACIO','ADJUNTAR_FACTURA_XML_VACIO','FECHA_A_DEPOSITAR','STATUS_DE_PAGO','ACTIVO_FIJO','GASTO_FIJO','PAGAR_CADA','FECHA_PPAGO','FECHA_TPROGRAPAGO','NUMERO_EVENTOFIJO','CLASI_GENERAL','SUB_GENERAL','NUMERO_EVENTO1','CLASIFICACION_GENERAL','CLASIFICACION_ESPECIFICA','PLACAS_VEHICULO','MONTO_DE_COMISION','POLIZA_NUMERO','NOMBRE_DEL_EJECUTIVO','NOMBRE_DEL_AYUDO','FECHA_DE_LLENADO','hiddenpagoproveedores','TIPO_CAMBIOP','TOTAL_ENPESOS','IMPUESTO_HOSPEDAJE','ID_RELACIONADO','IVA','IEPS','UUID','metodoDePago','totalf','serie','folio','regimenE','UsoCFDI','TImpuestosTrasladados','TImpuestosRetenidos','Version','tipoDeComprobante','condicionesDePago','fechaTimbrado','nombreR','rfcR','Moneda','MonedaF','RFC_RECEPTOR','TipoCambio','ValorUnitarioConcepto','DescripcionConcepto','ClaveUnidadConcepto','ClaveProdServConcepto','CantidadConcepto','ImporteConcepto','UnidadConcepto','TUA','TuaTotalCargos','Descuento','subTotal','propina','IVAXML','IEPSXML','P_TIPO_DE_MONEDA_1','P_INSTITUCION_FINANCIERA_1','P_NUMERO_DE_CUENTA_DB_1','P_NUMERO_CLABE_1','P_NUMERO_IBAN_1','P_NUMERO_CUENTA_SWIFT_1','FOTO_ESTADO_PROVEE','ULTIMA_CARGA_DATOBANCA','RAZON_SOCIAL_orden','RFC_PROVEEDOR_orden','MONTO_FACTURA_orden','FECHA_DE_PAGO_orden','NUMERO_EVENTO_orden');
$search = array();
foreach($keys as $k){ $search[$k] = isset($_POST[$k]) ? trim((string)$_POST[$k]) : ''; }
$search['OBSERVACIONES_1'] = isset($_POST['OBSERVACIONES_1']) ? trim($_POST['OBSERVACIONES_1']) : (isset($_POST['OBSERVACIONES_2']) ? trim($_POST['OBSERVACIONES_2']) : '');
$search['TImpuestosRetenidosIVA'] = isset($_POST['TImpuestosRetenidosIVA_3']) ? trim($_POST['TImpuestosRetenidosIVA_3']) : '';
$search['TImpuestosRetenidosISR'] = isset($_POST['TImpuestosRetenidosISR_3']) ? trim($_POST['TImpuestosRetenidosISR_3']) : '';
$search['descuentos'] = isset($_POST['descuentos_3']) ? trim($_POST['descuentos_3']) : '';
$search['per_page'] = 100000;
$search['offset'] = 0;

if(!empty($_SESSION['num_evento'])) { $search['NUMERO_EVENTO'] = $_SESSION['num_evento']; }
if(!empty($_POST['NUMERO_EVENTO'])) { $search['NUMERO_EVENTO'] = $_POST['NUMERO_EVENTO']; }

// Columnas visibles del listado: se consulta la misma plantilla para no exportar campos ocultos.
$catalog = array(
 'NUMERO_CONSECUTIVO_PROVEE'=>'NÚMERO DE SOLICITUD','VIATICOSOPRO'=>'TIPO DE PAGO','NOMBRE_COMERCIAL'=>'NOMBRE COMERCIAL','RAZON_SOCIAL'=>'RAZON SOCIAL','RFC_PROVEEDOR'=>'RFC PROVEEDOR','NUMERO_EVENTO'=>'NÚMERO EVENTO','NOMBRE_EVENTO'=>'NOMBRE EVENTO','FECHA_INICIO_EVENTO'=>'FECHA INICIO EVENTO','FECHA_FINAL_EVENTO'=>'FECHA FINAL EVENTO','MOTIVO_GASTO'=>'MOTIVO GASTO','CONCEPTO_PROVEE'=>'CONCEPTO','MONTO_TOTAL_COTIZACION_ADEUDO'=>'MONTO COTIZACIÓN/ADEUDO','MONTO_FACTURA'=>'MONTO FACTURA','IVA'=>'IVA','IEPS'=>'IEPS','MONTO_PROPINA'=>'MONTO PROPINA','IMPUESTO_HOSPEDAJE'=>'IMPUESTO HOSPEDAJE','descuentos'=>'DESCUENTO','MONTO_DEPOSITAR'=>'TOTAL A PAGAR','MONTO_DEPOSITADO'=>'MONTO DEPOSITADO','TIPO_DE_MONEDA'=>'TIPO DE MONEDA','TIPO_CAMBIOP'=>'TIPO DE CAMBIO','TOTAL_ENPESOS'=>'TOTAL CONVERSIÓN','PFORMADE_PAGO'=>'FORMA DE PAGO','FECHA_DE_PAGO'=>'FECHA PROGRAMACIÓN PAGO','FECHA_A_DEPOSITAR'=>'FECHA EFECTIVA PAGO','STATUS_DE_PAGO'=>'STATUS DE PAGO','ACTIVO_FIJO'=>'ACTIVO FIJO','GASTO_FIJO'=>'GASTO FIJO','CLASIFICACION_GENERAL'=>'CLASIFICACION GENERAL','CLASIFICACION_ESPECIFICA'=>'CLASIFICACION ESPECIFICA','POLIZA_NUMERO'=>'POLIZA NUMERO','NOMBRE_DEL_EJECUTIVO'=>'NOMBRE DEL EJECUTIVO','NOMBRE_DEL_AYUDO'=>'EJECUTIVO QUE INGRESÓ','OBSERVACIONES_1'=>'OBSERVACIONES','FECHA_DE_LLENADO'=>'FECHA Y HORA DE LLENADO','UUID'=>'UUID','folio'=>'FOLIO','serie'=>'SERIE','metodoDePago'=>'METODO DE PAGO','UsoCFDI'=>'USO CFDI','subTotal'=>'SUBTOTAL','totalf'=>'TOTAL XML','P_INSTITUCION_FINANCIERA_1'=>'INSTITUCION FINANCIERA','P_NUMERO_DE_CUENTA_DB_1'=>'NÚMERO DE CUENTA','P_NUMERO_CLABE_1'=>'CUENTA CLABE'
);
$columns = array();
foreach($catalog as $field=>$label){
    if($database->plantilla_filtro($nombreTabla, $field, $altaeventos, $DEPARTAMENTO) == 'si') { $columns[$field]=$label; }
}
if(empty($columns)){ $columns = array_slice($catalog, 0, 20, true); }

$datos = $database->getData($tables, $campos, $search);
$rows = array();
while($datos && ($r = mysqli_fetch_array($datos, MYSQLI_ASSOC))){ $rows[] = $r; }

function xml_escape($v){ return htmlspecialchars((string)$v, ENT_QUOTES | ENT_XML1, 'UTF-8'); }
function col_name($n){ $s=''; while($n>0){ $m=($n-1)%26; $s=chr(65+$m).$s; $n=(int)(($n-$m)/26); } return $s; }
function excel_upper($value){ return function_exists('mb_strtoupper') ? mb_strtoupper(trim((string)$value),'UTF-8') : strtoupper(trim((string)$value)); }

/**
 * Replica exactamente la lógica de color de fila usada en el listado (bitacoraFiltro.php),
 * basada en $fondo_existe_xml2. Devuelve una de: 'BLANCO', 'ROJO', 'ROSA', 'AMARILLO'.
 */
function color_de_fila($database, $row){
    $rowDoc = $database->getDoctos_subefactura($row['02SUBETUFACTURAid']);
    $complementoPdf = isset($rowDoc['COMPLEMENTOS_PAGO_PDF']) ? trim((string)$rowDoc['COMPLEMENTOS_PAGO_PDF']) : '';
    $complementoXml = isset($rowDoc['COMPLEMENTOS_PAGO_XML']) ? trim((string)$rowDoc['COMPLEMENTOS_PAGO_XML']) : '';
    $tieneComplemento = ($complementoPdf !== '' || $complementoXml !== '');

    if (isset($row['STATUS_AUDITORIA3']) && trim($row['STATUS_AUDITORIA3']) === 'si') {
        return 'BLANCO';
    } else if ($tieneComplemento) {
        return 'BLANCO';
    } else if (isset($row['STATUS_DE_PAGO']) && $row['STATUS_DE_PAGO'] === 'RECHAZADO') {
        return 'ROJO';
    } else if (!$tieneComplemento && (
        (isset($row['metodoDePago']) && trim($row['metodoDePago']) !== '' && strtoupper(trim($row['metodoDePago'])) !== 'PUE')
        || (isset($row['PFORMADE_PAGO']) && $row['PFORMADE_PAGO'] !== '03')
    )) {
        return 'ROSA';
    } else if (!empty($row['ClaveUnidadConcepto'])) {
        return 'BLANCO';
    } else {
        return 'AMARILLO';
    }
}

$money = array('MONTO_TOTAL_COTIZACION_ADEUDO','MONTO_FACTURA','IVA','IEPS','MONTO_PROPINA','IMPUESTO_HOSPEDAJE','descuentos','MONTO_DEPOSITAR','MONTO_DEPOSITADO','TOTAL_ENPESOS','subTotal','totalf');
$dates = array('FECHA_DE_PAGO','FECHA_A_DEPOSITAR','FECHA_DE_LLENADO','FECHA_INICIO_EVENTO','FECHA_FINAL_EVENTO');

// Mapa de color de fila -> índice de estilo de texto (s) e índice de estilo de dinero (s)
// s=1  texto normal (blanco/ sin relleno)
// s=7  dinero normal
// s=12 texto rojo      | s=15 dinero rojo
// s=13 texto rosa      | s=16 dinero rosa
// s=14 texto amarillo  | s=17 dinero amarillo
$estiloTexto = array('BLANCO'=>1, 'ROJO'=>12, 'ROSA'=>13, 'AMARILLO'=>14);
$estiloDinero = array('BLANCO'=>7, 'ROJO'=>15, 'ROSA'=>16, 'AMARILLO'=>17);

$sheet = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main"><cols>';
$i=1; foreach($columns as $field=>$label){ $sheet.='<col min="'.$i.'" max="'.$i.'" width="'.min(max(strlen($label)+8,14),45).'" customWidth="1"/>'; $i++; }
$sheet .= '</cols><sheetData>';
$sheet .= '<row r="1">'; $c=1; foreach($columns as $label){ $sheet.='<c r="'.col_name($c).'1" t="inlineStr" s="2"><is><t>'.xml_escape($label).'</t></is></c>'; $c++; } $sheet.='</row>';

$rnum=2;
foreach($rows as $row){
    $color = color_de_fila($database, $row);
    $styleTexto = isset($estiloTexto[$color]) ? $estiloTexto[$color] : 1;
    $styleDinero = isset($estiloDinero[$color]) ? $estiloDinero[$color] : 7;

    $sheet.='<row r="'.$rnum.'">';
    $c=1;
    foreach($columns as $field=>$label){
        $val=isset($row[$field])?$row[$field]:'';
        $cell=col_name($c).$rnum;
        if(in_array($field,$money,true) && is_numeric(str_replace(array(',','$'),'',$val))){
            $num=str_replace(array(',','$'),'',$val);
            $sheet.='<c r="'.$cell.'" s="'.$styleDinero.'"><v>'.$num.'</v></c>';
        } else {
            $sheet.='<c r="'.$cell.'" t="inlineStr" s="'.$styleTexto.'"><is><t>'.xml_escape(strip_tags((string)$val)).'</t></is></c>';
        }
        $c++;
    }
    $sheet.='</row>';
    $rnum++;
}
$sheet .= '</sheetData></worksheet>';

function descargar_excel_html($database, $filename, $columns, $rows, $money){
    while (ob_get_level() > 0) { ob_end_clean(); }
    header('Content-Description: File Transfer');
    header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
    header('Content-Disposition: attachment; filename="'.$filename.'"');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    echo "\xEF\xBB\xBF";
    echo '<html><head><meta charset="UTF-8"><style>';
    echo 'table{border-collapse:collapse;font-family:Arial;font-size:11px;}th{background:#4F81BD;color:#fff;font-weight:bold;}th,td{border:1px solid #777;padding:4px;}';
    echo ' .rojo{background:#FF0000;} .rosa{background:#FFB6C1;} .amarillo{background:#FDFE87;} .blanco{background:#FFFFFF;} .money{mso-number-format:"$#,##0.00";}';
    echo '</style></head><body><table><thead><tr>';
    foreach($columns as $label){ echo '<th>'.htmlspecialchars((string)$label, ENT_QUOTES, 'UTF-8').'</th>'; }
    echo '</tr></thead><tbody>';
    foreach($rows as $row){
        $color = color_de_fila($database, $row);
        $class = strtolower($color);
        echo '<tr class="'.$class.'">';
        foreach($columns as $field=>$label){
            $val = isset($row[$field]) ? strip_tags((string)$row[$field]) : '';
            $isMoney = in_array($field, $money, true) && is_numeric(str_replace(array(',','$'), '', $val));
            echo '<td'.($isMoney ? ' class="money"' : '').'>'.htmlspecialchars($val, ENT_QUOTES, 'UTF-8').'</td>';
        }
        echo '</tr>';
    }
    echo '</tbody></table></body></html>';
    exit;
}

$styles = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
    .'<numFmts count="1"><numFmt numFmtId="164" formatCode="$#,##0.00"/></numFmts>'
    .'<fonts count="2"><font><sz val="11"/><name val="Calibri"/></font><font><b/><sz val="11"/><color rgb="FFFFFFFF"/><name val="Calibri"/></font></fonts>'
    .'<fills count="6">'
        .'<fill><patternFill patternType="none"/></fill>'
        .'<fill><patternFill patternType="gray125"/></fill>'
        .'<fill><patternFill patternType="solid"><fgColor rgb="FF4F81BD"/><bgColor indexed="64"/></patternFill></fill>' // encabezado
        .'<fill><patternFill patternType="solid"><fgColor rgb="FFFF0000"/><bgColor indexed="64"/></patternFill></fill>' // rojo (RECHAZADO)
        .'<fill><patternFill patternType="solid"><fgColor rgb="FFFFB6C1"/><bgColor indexed="64"/></patternFill></fill>' // rosa (forma de pago distinta)
        .'<fill><patternFill patternType="solid"><fgColor rgb="FFFDFE87"/><bgColor indexed="64"/></patternFill></fill>' // amarillo (sin ClaveUnidadConcepto)
    .'</fills>'
    .'<borders count="2"><border><left/><right/><top/><bottom/><diagonal/></border><border><left style="thin"/><right style="thin"/><top style="thin"/><bottom style="thin"/><diagonal/></border></borders>'
    .'<cellXfs count="18">'
        .'<xf numFmtId="0" fontId="0" fillId="0" borderId="0" xfId="0"/>' /*0*/
        .'<xf numFmtId="0" fontId="0" fillId="0" borderId="1" xfId="0"/>' /*1 texto blanco*/
        .'<xf numFmtId="0" fontId="1" fillId="2" borderId="1" xfId="0" applyFill="1"/>' /*2 encabezado*/
        .'<xf numFmtId="0" fontId="0" fillId="0" borderId="1" xfId="0"/>' /*3 (sin uso, se conserva por compatibilidad)*/
        .'<xf numFmtId="0" fontId="0" fillId="0" borderId="1" xfId="0"/>' /*4 (sin uso)*/
        .'<xf numFmtId="0" fontId="0" fillId="0" borderId="1" xfId="0"/>' /*5 (sin uso)*/
        .'<xf numFmtId="0" fontId="0" fillId="0" borderId="1" xfId="0"/>' /*6 (sin uso)*/
        .'<xf numFmtId="164" fontId="0" fillId="0" borderId="1" xfId="0" applyNumberFormat="1"/>' /*7 dinero blanco*/
        .'<xf numFmtId="164" fontId="0" fillId="0" borderId="1" xfId="0" applyNumberFormat="1"/>' /*8 (sin uso)*/
        .'<xf numFmtId="164" fontId="0" fillId="0" borderId="1" xfId="0" applyNumberFormat="1"/>' /*9 (sin uso)*/
        .'<xf numFmtId="164" fontId="0" fillId="0" borderId="1" xfId="0" applyNumberFormat="1"/>' /*10 (sin uso)*/
        .'<xf numFmtId="0" fontId="0" fillId="0" borderId="1" xfId="0"/>' /*11 (sin uso)*/
        .'<xf numFmtId="0" fontId="0" fillId="3" borderId="1" xfId="0" applyFill="1"/>' /*12 texto rojo*/
        .'<xf numFmtId="0" fontId="0" fillId="4" borderId="1" xfId="0" applyFill="1"/>' /*13 texto rosa*/
        .'<xf numFmtId="0" fontId="0" fillId="5" borderId="1" xfId="0" applyFill="1"/>' /*14 texto amarillo*/
        .'<xf numFmtId="164" fontId="0" fillId="3" borderId="1" xfId="0" applyNumberFormat="1" applyFill="1"/>' /*15 dinero rojo*/
        .'<xf numFmtId="164" fontId="0" fillId="4" borderId="1" xfId="0" applyNumberFormat="1" applyFill="1"/>' /*16 dinero rosa*/
        .'<xf numFmtId="164" fontId="0" fillId="5" borderId="1" xfId="0" applyNumberFormat="1" applyFill="1"/>' /*17 dinero amarillo*/
    .'</cellXfs>'
    .'<cellStyleXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0"/></cellStyleXfs>'
    .'<cellStyles count="1"><cellStyle name="Normal" xfId="0" builtinId="0"/></cellStyles>'
    .'<dxfs count="0"/><tableStyles count="0" defaultTableStyle="TableStyleMedium9" defaultPivotStyle="PivotStyleLight16"/>'
    .'</styleSheet>';

if(!class_exists('ZipArchive')){
    descargar_excel_html($database, 'reporte_filtrado_'.date('Ymd_His').'.xls', $columns, $rows, $money);
}
$tmp = tempnam(sys_get_temp_dir(), 'xlsx');
$zip = new ZipArchive();
if($zip->open($tmp, ZipArchive::OVERWRITE) !== true){
    descargar_excel_html($database, 'reporte_filtrado_'.date('Ymd_His').'.xls', $columns, $rows, $money);
}
$zip->addFromString('[Content_Types].xml','<?xml version="1.0" encoding="UTF-8" standalone="yes"?><Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types"><Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/><Default Extension="xml" ContentType="application/xml"/><Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/><Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/><Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/></Types>');
$zip->addFromString('_rels/.rels','<?xml version="1.0" encoding="UTF-8" standalone="yes"?><Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships"><Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/></Relationships>');
$zip->addFromString('xl/workbook.xml','<?xml version="1.0" encoding="UTF-8" standalone="yes"?><workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships"><sheets><sheet name="Reporte filtrado" sheetId="1" r:id="rId1"/></sheets></workbook>');
$zip->addFromString('xl/_rels/workbook.xml.rels','<?xml version="1.0" encoding="UTF-8" standalone="yes"?><Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships"><Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/><Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/></Relationships>');
$zip->addFromString('xl/worksheets/sheet1.xml',$sheet);
$zip->addFromString('xl/styles.xml',$styles);
$zip->close();
$filename = 'reporte_filtrado_'.date('Ymd_His').'.xlsx';
while (ob_get_level() > 0) { ob_end_clean(); }
header('Content-Description: File Transfer');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'.$filename.'"');
header('Content-Transfer-Encoding: binary');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: '.filesize($tmp));
readfile($tmp); unlink($tmp); exit;
