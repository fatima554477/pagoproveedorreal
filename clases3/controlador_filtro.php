<?php

/**
 	--------------------------
	Autor: Sandor Matamoros
	Programer: Fatima Arellano
	Propietario: EPC
    fecha sandor: 05/JUNIO/2025
    fecha fatis : 05/04/2025

	----------------------------
 
*/


	if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
	define("__ROOT6__", dirname(__FILE__));
$action = (isset($_POST["action"])&& $_POST["action"] !=NULL)?$_POST["action"]:"";
if($action == "ajax"){

        require(__ROOT6__."/class.filtro.php");
        $database=new orders();

        $usuarioActual = isset($_SESSION['idem']) ? $_SESSION['idem'] : '';
       $eventosAutorizadosVentas = array_flip($database->puedeAutorizarVentas($usuarioActual));

	$DEPARTAMENTO = !empty($_POST["DEPARTAMENTO2"])?$_POST["DEPARTAMENTO2"]:"DEFAULT";	
	$nombreTabla = "SELECT * FROM `08pagoproveedoresfiltroDes`, 08altaeventosfiltroPLA WHERE 08pagoproveedoresfiltroDes.id = 08altaeventosfiltroPLA.idRelacion";
	$altaeventos = "pagoProveedores";
	$tables = "02SUBETUFACTURADOCTOS";
	

	

$NUMERO_CONSECUTIVO_PROVEE = isset($_POST["NUMERO_CONSECUTIVO_PROVEE"])?trim($_POST["NUMERO_CONSECUTIVO_PROVEE"]):"";  
$NOMBRE_COMERCIAL = isset($_POST["NOMBRE_COMERCIAL"])?trim($_POST["NOMBRE_COMERCIAL"]):"";  
$RAZON_SOCIAL = isset($_POST["RAZON_SOCIAL"])?trim($_POST["RAZON_SOCIAL"]):"";  
$VIATICOSOPRO = isset($_POST["VIATICOSOPRO"])?trim($_POST["VIATICOSOPRO"]):"";  
$RFC_PROVEEDOR = isset($_POST["RFC_PROVEEDOR"])?trim($_POST["RFC_PROVEEDOR"]):"";  
$NUMERO_EVENTO = isset($_POST["NUMERO_EVENTO"])?trim($_POST["NUMERO_EVENTO"]):"";  
$NOMBRE_EVENTO = isset($_POST["NOMBRE_EVENTO"])?trim($_POST["NOMBRE_EVENTO"]):"";  
$MOTIVO_GASTO = isset($_POST["MOTIVO_GASTO"])?trim($_POST["MOTIVO_GASTO"]):"";  
$CONCEPTO_PROVEE = isset($_POST["CONCEPTO_PROVEE"])?trim($_POST["CONCEPTO_PROVEE"]):"";  
$MONTO_TOTAL_COTIZACION_ADEUDO = isset($_POST["MONTO_TOTAL_COTIZACION_ADEUDO"])?trim($_POST["MONTO_TOTAL_COTIZACION_ADEUDO"]):"";  
$MONTO_FACTURA = isset($_POST["MONTO_FACTURA"])?trim($_POST["MONTO_FACTURA"]):"";  
$MONTO_PROPINA = isset($_POST["MONTO_PROPINA"])?trim($_POST["MONTO_PROPINA"]):"";  
$MONTO_DEPOSITAR = isset($_POST["MONTO_DEPOSITAR"])?trim($_POST["MONTO_DEPOSITAR"]):"";  
$MONTO_DEPOSITADO = isset($_POST["MONTO_DEPOSITADO"])?trim($_POST["MONTO_DEPOSITADO"]):"";  
$TIPO_DE_MONEDA = isset($_POST["TIPO_DE_MONEDA"])?trim($_POST["TIPO_DE_MONEDA"]):"";  
$PFORMADE_PAGO = isset($_POST["PFORMADE_PAGO"])?trim($_POST["PFORMADE_PAGO"]):""; 
 
$FECHA_DE_PAGO = isset($_POST["FECHA_DE_PAGO"])?trim($_POST["FECHA_DE_PAGO"]):"";
$FECHA_DE_PAGO2a = isset($_POST["FECHA_DE_PAGO2a"])?trim($_POST["FECHA_DE_PAGO2a"]):"";
$FECHA_DE_PAGO_VACIO = isset($_POST["FECHA_DE_PAGO_VACIO"])?trim($_POST["FECHA_DE_PAGO_VACIO"]):"";
  
$FECHA_A_DEPOSITAR = isset($_POST["FECHA_A_DEPOSITAR"])?trim($_POST["FECHA_A_DEPOSITAR"]):"";  
$STATUS_DE_PAGO = isset($_POST["STATUS_DE_PAGO"])?trim($_POST["STATUS_DE_PAGO"]):"";  
$ACTIVO_FIJO = isset($_POST["ACTIVO_FIJO"])?trim($_POST["ACTIVO_FIJO"]):"";  
$GASTO_FIJO = isset($_POST["GASTO_FIJO"])?trim($_POST["GASTO_FIJO"]):"";  
$PAGAR_CADA = isset($_POST["PAGAR_CADA"])?trim($_POST["PAGAR_CADA"]):"";  
$FECHA_PPAGO = isset($_POST["FECHA_PPAGO"])?trim($_POST["FECHA_PPAGO"]):"";  
$FECHA_TPROGRAPAGO = isset($_POST["FECHA_TPROGRAPAGO"])?trim($_POST["FECHA_TPROGRAPAGO"]):"";  
$NUMERO_EVENTOFIJO = isset($_POST["NUMERO_EVENTOFIJO"])?trim($_POST["NUMERO_EVENTOFIJO"]):"";  
$CLASI_GENERAL = isset($_POST["CLASI_GENERAL"])?trim($_POST["CLASI_GENERAL"]):"";  
$SUB_GENERAL = isset($_POST["SUB_GENERAL"])?trim($_POST["SUB_GENERAL"]):"";  
$NUMERO_EVENTO1 = isset($_POST["NUMERO_EVENTO1"])?trim($_POST["NUMERO_EVENTO1"]):"";  
$CLASIFICACION_GENERAL = isset($_POST["CLASIFICACION_GENERAL"])?trim($_POST["CLASIFICACION_GENERAL"]):"";  
$CLASIFICACION_ESPECIFICA = isset($_POST["CLASIFICACION_ESPECIFICA"])?trim($_POST["CLASIFICACION_ESPECIFICA"]):"";  
$PLACAS_VEHICULO = isset($_POST["PLACAS_VEHICULO"])?trim($_POST["PLACAS_VEHICULO"]):"";  
$MONTO_DE_COMISION = isset($_POST["MONTO_DE_COMISION"])?trim($_POST["MONTO_DE_COMISION"]):"";  
$POLIZA_NUMERO = isset($_POST["POLIZA_NUMERO"])?trim($_POST["POLIZA_NUMERO"]):"";  
$NOMBRE_DEL_EJECUTIVO = isset($_POST["NOMBRE_DEL_EJECUTIVO"])?trim($_POST["NOMBRE_DEL_EJECUTIVO"]):"";  
$NOMBRE_DEL_AYUDO = isset($_POST["NOMBRE_DEL_AYUDO"])?trim($_POST["NOMBRE_DEL_AYUDO"]):"";  
$OBSERVACIONES_1 = isset($_POST["OBSERVACIONES_1"])?trim($_POST["OBSERVACIONES_1"]):"";  
$FECHA_DE_LLENADO = isset($_POST["FECHA_DE_LLENADO"])?trim($_POST["FECHA_DE_LLENADO"]):"";  
$hiddenpagoproveedores = isset($_POST["hiddenpagoproveedores"])?trim($_POST["hiddenpagoproveedores"]):""; 
$TIPO_CAMBIOP = isset($_POST["TIPO_CAMBIOP"])?$_POST["TIPO_CAMBIOP"]:""; 
$TOTAL_ENPESOS = isset($_POST["TOTAL_ENPESOS"])?$_POST["TOTAL_ENPESOS"]:""; 
$IMPUESTO_HOSPEDAJE = isset($_POST["IMPUESTO_HOSPEDAJE"])?$_POST["IMPUESTO_HOSPEDAJE"]:""; 
$ID_RELACIONADO = isset($_POST["ID_RELACIONADO"])?$_POST["ID_RELACIONADO"]:""; 

$FECHA_INICIO_EVENTO = isset($_POST["FECHA_INICIO_EVENTO"])?$_POST["FECHA_INICIO_EVENTO"]:""; 
$FECHA_FINAL_EVENTO = isset($_POST["FECHA_FINAL_EVENTO"])?$_POST["FECHA_FINAL_EVENTO"]:""; 

$IVA = isset($_POST["IVA"])?$_POST["IVA"]:""; 
$IEPS = isset($_POST["IEPS"])?$_POST["IEPS"]:""; 
$TImpuestosRetenidosIVA = isset($_POST["TImpuestosRetenidosIVA_3"])?$_POST["TImpuestosRetenidosIVA_3"]:""; 
$TImpuestosRetenidosISR = isset($_POST["TImpuestosRetenidosISR_3"])?$_POST["TImpuestosRetenidosISR_3"]:""; 
$descuentos = isset($_POST["descuentos_3"])?$_POST["descuentos_3"]:""; 


$RAZON_SOCIAL_orden = isset($_POST["RAZON_SOCIAL_orden"])?trim($_POST["RAZON_SOCIAL_orden"]):"";  
$RFC_PROVEEDOR_orden = isset($_POST["NOMBRE_COMERCIAL_orden"])?trim($_POST["RFC_PROVEEDOR_orden"]):""; 
$MONTO_FACTURA_orden = isset($_POST["MONTO_FACTURA_orden"])?trim($_POST["MONTO_FACTURA_orden"]):""; 
$FECHA_DE_PAGO_orden = isset($_POST["FECHA_DE_PAGO_orden"])?trim($_POST["FECHA_DE_PAGO_orden"]):""; 
$NUMERO_EVENTO_orden = isset($_POST["NUMERO_EVENTO_orden"])?trim($_POST["NUMERO_EVENTO_orden"]):""; 


$UUID = isset($_POST["UUID"])?trim($_POST["UUID"]):""; 
$metodoDePago = isset($_POST["metodoDePago"])?trim($_POST["metodoDePago"]):""; 
$totalf = isset($_POST["totalf"])?trim($_POST["totalf"]):""; 
$serie = isset($_POST["serie"])?trim($_POST["serie"]):""; 
$folio = isset($_POST["folio"])?trim($_POST["folio"]):""; 
$regimenE = isset($_POST["regimenE"])?trim($_POST["regimenE"]):""; 
$UsoCFDI = isset($_POST["UsoCFDI"])?trim($_POST["UsoCFDI"]):""; 
$TImpuestosTrasladados = isset($_POST["TImpuestosTrasladados"])?trim($_POST["TImpuestosTrasladados"]):""; 
$TImpuestosRetenidos = isset($_POST["TImpuestosRetenidos"])?trim($_POST["TImpuestosRetenidos"]):""; 
$Version = isset($_POST["Version"])?trim($_POST["Version"]):""; 
$tipoDeComprobante = isset($_POST["tipoDeComprobante"])?trim($_POST["tipoDeComprobante"]):""; 
$condicionesDePago = isset($_POST["condicionesDePago"])?trim($_POST["condicionesDePago"]):""; 
$fechaTimbrado = isset($_POST["fechaTimbrado"])?trim($_POST["fechaTimbrado"]):""; 
$nombreR = isset($_POST["nombreR"])?trim($_POST["nombreR"]):""; 
$rfcR = isset($_POST["rfcR"])?trim($_POST["rfcR"]):""; 
$Moneda = isset($_POST["Moneda"])?trim($_POST["Moneda"]):""; 
$TipoCambio = isset($_POST["TipoCambio"])?trim($_POST["TipoCambio"]):""; 
$ValorUnitarioConcepto = isset($_POST["ValorUnitarioConcepto"])?trim($_POST["ValorUnitarioConcepto"]):""; 
$DescripcionConcepto = isset($_POST["DescripcionConcepto"])?trim($_POST["DescripcionConcepto"]):""; 
$ClaveUnidadConcepto = isset($_POST["ClaveUnidadConcepto"])?trim($_POST["ClaveUnidadConcepto"]):""; 
$ClaveProdServConcepto = isset($_POST["ClaveProdServConcepto"])?trim($_POST["ClaveProdServConcepto"]):""; 
$CantidadConcepto = isset($_POST["CantidadConcepto"])?trim($_POST["CantidadConcepto"]):""; 
$ImporteConcepto = isset($_POST["ImporteConcepto"])?trim($_POST["ImporteConcepto"]):""; 
$UnidadConcepto = isset($_POST["UnidadConcepto"])?trim($_POST["UnidadConcepto"]):""; 
$TUA = isset($_POST["TUA"])?trim($_POST["TUA"]):""; 
$TuaTotalCargos = isset($_POST["TuaTotalCargos"])?trim($_POST["TuaTotalCargos"]):""; 
$Descuento = isset($_POST["Descuento"])?trim($_POST["Descuento"]):""; 
$subTotal = isset($_POST["subTotal"])?trim($_POST["subTotal"]):""; 
$propina = isset($_POST["propina"])?trim($_POST["propina"]):"";
$IVAXML = isset($_POST["IVAXML"])?trim($_POST["IVAXML"]):"";
$IEPSXML = isset($_POST["IEPSXML"])?trim($_POST["IEPSXML"]):"";

$P_TIPO_DE_MONEDA_1 = isset($_POST["P_TIPO_DE_MONEDA_1"])?trim($_POST["P_TIPO_DE_MONEDA_1"]):"";  
$P_INSTITUCION_FINANCIERA_1 = isset($_POST["P_INSTITUCION_FINANCIERA_1"])?trim($_POST["P_INSTITUCION_FINANCIERA_1"]):"";  
$P_INSTITUCION_FINANCIERA_1 = isset($_POST["P_INSTITUCION_FINANCIERA_1"])?trim($_POST["P_INSTITUCION_FINANCIERA_1"]):"";  
$P_NUMERO_DE_CUENTA_DB_1 = isset($_POST["P_NUMERO_DE_CUENTA_DB_1"])?trim($_POST["P_NUMERO_DE_CUENTA_DB_1"]):"";  
$P_NUMERO_CLABE_1 = isset($_POST["P_NUMERO_CLABE_1"])?trim($_POST["P_NUMERO_CLABE_1"]):"";  
$P_NUMERO_CUENTA_SWIFT_1 = isset($_POST["P_NUMERO_CUENTA_SWIFT_1"])?trim($_POST["P_NUMERO_CUENTA_SWIFT_1"]):"";  
$FOTO_ESTADO_PROVEE = isset($_POST["FOTO_ESTADO_PROVEE"])?trim($_POST["FOTO_ESTADO_PROVEE"]):"";  
$ULTIMA_CARGA_DATOBANCA = isset($_POST["ULTIMA_CARGA_DATOBANCA"])?trim($_POST["ULTIMA_CARGA_DATOBANCA"]):"";  

if($_SESSION['num_evento']==true){
	$NUMERO_EVENTO = $_SESSION['num_evento'];
}
if($_POST['NUMERO_EVENTO']==true){
	$NUMERO_EVENTO = $_POST['NUMERO_EVENTO'];	
}

$per_page=intval($_POST["per_page"]);
	$max_per_page = 500;
	if ($per_page < 1) {
		$per_page = 10;
	}
	$per_page = min($per_page, $max_per_page);
	$campos="*";
	$campos="02SUBETUFACTURA.*, 02XML.*, 04altaeventos.FECHA_INICIO_EVENTO AS FECHA_INICIO_EVENTO, 04altaeventos.FECHA_FINAL_EVENTO AS FECHA_FINAL_EVENTO";
	//Variables de paginación
	$page = (isset($_POST["page"]) && !empty($_POST["page"]))?$_POST["page"]:1;
	$adjacents  = 4; //espacio entre páginas después del número de adyacentes
	$offset = ($page - 1) * $per_page;
	
	$search=array(

"NUMERO_CONSECUTIVO_PROVEE"=>$NUMERO_CONSECUTIVO_PROVEE,
"NOMBRE_COMERCIAL"=>$NOMBRE_COMERCIAL,
"RAZON_SOCIAL"=>$RAZON_SOCIAL,
"VIATICOSOPRO"=>$VIATICOSOPRO,
"RFC_PROVEEDOR"=>$RFC_PROVEEDOR,
"NUMERO_EVENTO"=>$NUMERO_EVENTO,
"NOMBRE_EVENTO"=>$NOMBRE_EVENTO,
"MOTIVO_GASTO"=>$MOTIVO_GASTO,
"CONCEPTO_PROVEE"=>$CONCEPTO_PROVEE,
"MONTO_TOTAL_COTIZACION_ADEUDO"=>$MONTO_TOTAL_COTIZACION_ADEUDO,
"MONTO_FACTURA"=>$MONTO_FACTURA,
"MONTO_PROPINA"=>$MONTO_PROPINA,
"MONTO_DEPOSITAR"=>$MONTO_DEPOSITAR,
"MONTO_DEPOSITADO"=>$MONTO_DEPOSITADO,
"TIPO_DE_MONEDA"=>$TIPO_DE_MONEDA,
"PFORMADE_PAGO"=>$PFORMADE_PAGO,

"FECHA_DE_PAGO"=>$FECHA_DE_PAGO,
"FECHA_DE_PAGO2a"=>$FECHA_DE_PAGO2a,
"FECHA_DE_PAGO_VACIO"=>$FECHA_DE_PAGO_VACIO,

"FECHA_INICIO_EVENTO"=>$FECHA_INICIO_EVENTO,
"FECHA_FINAL_EVENTO"=>$FECHA_FINAL_EVENTO,

"FECHA_A_DEPOSITAR"=>$FECHA_A_DEPOSITAR,
"STATUS_DE_PAGO"=>$STATUS_DE_PAGO,
"ACTIVO_FIJO"=>$ACTIVO_FIJO,
"GASTO_FIJO"=>$GASTO_FIJO,
"PAGAR_CADA"=>$PAGAR_CADA,
"FECHA_PPAGO"=>$FECHA_PPAGO,
"FECHA_TPROGRAPAGO"=>$FECHA_TPROGRAPAGO,
"NUMERO_EVENTOFIJO"=>$NUMERO_EVENTOFIJO,
"CLASI_GENERAL"=>$CLASI_GENERAL,
"SUB_GENERAL"=>$SUB_GENERAL,
"NUMERO_EVENTO1"=>$NUMERO_EVENTO1,
"CLASIFICACION_GENERAL"=>$CLASIFICACION_GENERAL,
"CLASIFICACION_ESPECIFICA"=>$CLASIFICACION_ESPECIFICA,
"PLACAS_VEHICULO"=>$PLACAS_VEHICULO,
"MONTO_DE_COMISION"=>$MONTO_DE_COMISION,
"POLIZA_NUMERO"=>$POLIZA_NUMERO,
"NOMBRE_DEL_EJECUTIVO"=>$NOMBRE_DEL_EJECUTIVO,
"NOMBRE_DEL_AYUDO"=>$NOMBRE_DEL_AYUDO,
"OBSERVACIONES_1"=>$OBSERVACIONES_1,
"FECHA_DE_LLENADO"=>$FECHA_DE_LLENADO,
"hiddenpagoproveedores"=>$hiddenpagoproveedores,
"RAZON_SOCIAL_orden"=>$RAZON_SOCIAL_orden,
"RFC_PROVEEDOR_orden"=>$RFC_PROVEEDOR_orden,
"MONTO_FACTURA_orden"=>$MONTO_FACTURA_orden,
"FECHA_DE_PAGO_orden"=>$FECHA_DE_PAGO_orden,
"NUMERO_EVENTO_orden"=>$NUMERO_EVENTO_orden,
"TIPO_CAMBIOP"=>$TIPO_CAMBIOP,
"TOTAL_ENPESOS"=>$TOTAL_ENPESOS,
"IMPUESTO_HOSPEDAJE"=>$IMPUESTO_HOSPEDAJE,
"P_TIPO_DE_MONEDA_1"=>$P_TIPO_DE_MONEDA_1,
"P_INSTITUCION_FINANCIERA_1"=>$P_INSTITUCION_FINANCIERA_1,
"P_NUMERO_DE_CUENTA_DB_1"=>$P_NUMERO_DE_CUENTA_DB_1,
"P_NUMERO_CLABE_1"=>$P_NUMERO_CLABE_1,
"P_NUMERO_IBAN_1"=>$P_NUMERO_IBAN_1,
"P_NUMERO_CUENTA_SWIFT_1"=>$P_NUMERO_CUENTA_SWIFT_1,
"FOTO_ESTADO_PROVEE"=>$FOTO_ESTADO_PROVEE,
"ULTIMA_CARGA_DATOBANCA"=>$ULTIMA_CARGA_DATOBANCA,
"ID_RELACIONADO"=>$ID_RELACIONADO,
"TImpuestosRetenidosIVA"=>$TImpuestosRetenidosIVA,
"TImpuestosRetenidosISR"=>$TImpuestosRetenidosISR,
"descuentos"=>$descuentos,
"IVA"=>$IVA,
"IEPS"=>$IEPS,

"UUID"=>$UUID,
"totalf"=>$totalf,
"metodoDePago"=>$metodoDePago,
"serie"=>$serie,
"folio"=>$folio,
"regimenE"=>$regimenE,
"UsoCFDI"=>$UsoCFDI,
"TImpuestosTrasladados"=>$TImpuestosTrasladados,
"TImpuestosRetenidos"=>$TImpuestosRetenidos,
"Version"=>$Version,
"tipoDeComprobante"=>$tipoDeComprobante,
"condicionesDePago"=>$condicionesDePago,
"fechaTimbrado"=>$fechaTimbrado,
"nombreR"=>$nombreR,
"rfcR"=>$rfcR,
"MonedaF"=>$MonedaF,
"TipoCambio"=>$TipoCambio,
"ValorUnitarioConcepto"=>$ValorUnitarioConcepto,
"DescripcionConcepto"=>$DescripcionConcepto,
"ClaveUnidadConcepto"=>$ClaveUnidadConcepto,
"ClaveProdServConcepto"=>$ClaveProdServConcepto,
"CantidadConcepto"=>$CantidadConcepto,
"ImporteConcepto"=>$ImporteConcepto,
"UnidadConcepto"=>$UnidadConcepto,
"Moneda"=>$Moneda,
"TUA"=>$TUA,
"TuaTotalCargos"=>$TuaTotalCargos,
"Descuento"=>$Descuento,
"subTotal"=>$subTotal,
"propina"=>$propina,
"IVAXML"=>$IVAXML,
"IEPSXML"=>$IEPSXML,


 "per_page"=>$per_page,
	"query"=>$query,
	"offset"=>$offset);
	//consulta principal para recuperar los datos
	$datos=$database->getData($tables,$campos,$search);
$countAll=$database->getCounter();
	$row = $countAll;
	
	if ($row>0){
		$numrows = $countAll;;
	} else {
		$numrows=0;
	}	
	$total_pages = ceil($numrows/$per_page);
	
	
	//Recorrer los datos recuperados
		?>

		<input type="hidden" id="total_registros_filtrados" value="<?php echo (int) $numrows; ?>">

		<div class="clearfix">
			<?php 
				
				require __ROOT6__."/pagination.php"; //include pagination class
				$pagination=new Pagination($page, $total_pages, $adjacents);
								$inicios=$offset+1;
				$finales+=$inicios -1;
				echo '<div class="hint-text">Mostrando '.$inicios.' al '.$finales.' de '.$numrows.' registros</div>';
				
				echo $pagination->paginate();
			?>

        </div>

	<div class="table-responsive">
<style>
    thead tr:first-child th {
        position: sticky;
        top: 0;
        background: #c9e8e8;
        z-index: 10;
    }

    thead tr:nth-child(2) td {
        position: sticky;
        top: 70px; /* Altura del primer encabezado */
        background: #e2f2f2;
        z-index: 9;
    }
</style>
<div style="max-height: 600px; overflow-y: auto;">
	 <table class="table table-striped table-bordered">   
	 
	
		<thead>
            <tr>
<th style="background:#c9e8e8"></th>
<th style="background:#c9e8e8">#</th>
<th style="background:#c9e8e8">SOLICITANTE</th>
<th style="background:#c9e8e8">VENTAS</th><!-NUEVO VENTAS->
<th style="background:#c9e8e8">CUENTAS <br>POR PAGAR</th><!-AUDITORIA 1->
<th style="background:#c9e8e8">DIRECCIÓN </th><!-antes finanzas y tesoreria->
<th style="background:#c9e8e8">FINANZAS Y <br>TESORERÍA <br>(PAGADO)</th><!-antes pagado->
<th style="background:#c9e8e8">AUDITORÍA</th>


<?php 
if($database->plantilla_filtro($nombreTabla,"ADJUNTAR_FACTURA_XML",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center">FACTURA XML</th>
<?php } ?>


<?php 
if($database->plantilla_filtro($nombreTabla,"ADJUNTAR_FACTURA_PDF",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center">FACTURA PDF</th>
<?php } ?><?php 
if($database->plantilla_filtro($nombreTabla,"NUMERO_CONSECUTIVO_PROVEE",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center">NÚMERO DE SOLICITUD</th>
<?php } ?>



<?php 
if($database->plantilla_filtro($nombreTabla,"VIATICOSOPRO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center">TIPO DE PAGO</th>
<?php } ?>

<?php 
if($database->plantilla_filtro($nombreTabla,"NOMBRE_COMERCIAL",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center">NOMBRE COMERCIAL</th>
<?php } ?><?php 
if($database->plantilla_filtro($nombreTabla,"RAZON_SOCIAL",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center">RAZON SOCIAL<br/>
			</th>
<?php } ?><?php 
if($database->plantilla_filtro($nombreTabla,"RFC_PROVEEDOR",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center">RFC PROVEEDOR</th>
<?php } ?><?php 
if($database->plantilla_filtro($nombreTabla,"NUMERO_EVENTO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center">NÚMERO EVENTO</th>
<?php } ?>

<?php 
if($database->plantilla_filtro($nombreTabla,"NOMBRE_EVENTO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center">NOMBRE EVENTO</th>
<?php } ?>
<?php 
if($database->plantilla_filtro($nombreTabla,"FECHA_INICIO_EVENTO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center">FECHA INICIO DEL EVENTO</th>
<?php } ?>
<?php 
if($database->plantilla_filtro($nombreTabla,"FECHA_FINAL_EVENTO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center">FECHA FINAL DEL EVENTO</th>
<?php } ?>

<?php 
if($database->plantilla_filtro($nombreTabla,"MOTIVO_GASTO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center">MOTIVO GASTO</th>
<?php } ?><?php 
if($database->plantilla_filtro($nombreTabla,"CONCEPTO_PROVEE",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center">CONCEPTO DE LA FACTURA</th>
<?php } ?><?php 
if($database->plantilla_filtro($nombreTabla,"MONTO_TOTAL_COTIZACION_ADEUDO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center">MONTO TOTAL <br>COTIZACIÓN ADEUDO</th>
<?php } ?>

<?php 
if($database->plantilla_filtro($nombreTabla,"MONTO_FACTURA",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center">SUBTOTAL</th>
<?php } ?>
<?php 
if($database->plantilla_filtro($nombreTabla,"IVA",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center">IVA</th>
<?php } ?>

<?php 
if($database->plantilla_filtro($nombreTabla,"TImpuestosRetenidosIVA",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center">IMPUESTOS RETENIDOS IVA</th>
<?php } ?>

<?php 
if($database->plantilla_filtro($nombreTabla,"TImpuestosRetenidosISR",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center">IMPUESTOS RETENIDOS ISR</th>
<?php } ?>



<?php 
if($database->plantilla_filtro($nombreTabla,"MONTO_PROPINA",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center">MONTO PROPINA</th>
<?php } ?>


<?php 
if($database->plantilla_filtro($nombreTabla,"IMPUESTO_HOSPEDAJE",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8"> IMPUESTO SOBRE HOSPEDAJE MÁS<br> EL IMPUESTO DE SANEAMIENTO</th>
<?php } ?>
<?php 
if($database->plantilla_filtro($nombreTabla,"descuentos",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8"> DESCUENTO</th>
<?php } ?>
<?php 
if($database->plantilla_filtro($nombreTabla,"MONTO_DEPOSITAR",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center">TOTAL A PAGAR</th>
<?php } ?><?php 
if($database->plantilla_filtro($nombreTabla,"MONTO_DEPOSITADO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#f48a81;text-align:center">MONTO DEPOSITADO</th>
<?php } ?><?php 
if($database->plantilla_filtro($nombreTabla,"PENDIENTE_PAGO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center">PENDIENTE DE PAGO</th>
<?php } ?><?php 
if($database->plantilla_filtro($nombreTabla,"TIPO_DE_MONEDA",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center">TIPO DE MONEDA</th>
<?php } ?>

<?php 
if($database->plantilla_filtro($nombreTabla,"TIPO_CAMBIOP",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8">TIPO DE CAMBIO</th>
<?php } ?>
<?php 
if($database->plantilla_filtro($nombreTabla,"TOTAL_ENPESOS",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8">TOTAL DE LA CONVERSIÓN</th>
<?php } ?>

<?php 
if($database->plantilla_filtro($nombreTabla,"PFORMADE_PAGO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center">FORMA DE PAGO</th>
<?php } ?>
<?php 
if($database->plantilla_filtro($nombreTabla,"FECHA_DE_PAGO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center">FECHA DE PROGRAMACIÓN  DEL PAGO</th>
<?php } ?>

<?php 
if($database->plantilla_filtro($nombreTabla,"FECHA_A_DEPOSITAR",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#f48a81;text-align:center">FECHA EFECTIVA DE PAGO</th>
<?php } ?>


<?php 
if($database->plantilla_filtro($nombreTabla,"STATUS_DE_PAGO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#f48a81;text-align:center">STATUS DE PAGO</th>
<?php } ?>

<?php                                     
if($database->plantilla_filtro($nombreTabla,"ADJUNTAR_COTIZACION",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center"> COTIZACIÓN O REPORTE</th>
<?php } ?><?php                                     
if($database->plantilla_filtro($nombreTabla,"CONPROBANTE_TRANSFERENCIA",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#f48a81"> COMPROBANTE DE TRANSFERENCIA</th>
<?php } ?><?php 
if($database->plantilla_filtro($nombreTabla,"ACTIVO_FIJO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center">ACTIVO FIJO</th>
<?php } ?><?php 
if($database->plantilla_filtro($nombreTabla,"GASTO_FIJO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center">GASTO FIJO</th>
<?php } ?><?php 
if($database->plantilla_filtro($nombreTabla,"PAGAR_CADA",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center">PAGAR CADA (GASTO FIJO)</th>
<?php } ?><?php 
if($database->plantilla_filtro($nombreTabla,"FECHA_PPAGO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center">FECHA  DE PAGO (GASTO FIJO)</th>
<?php } ?><?php 
if($database->plantilla_filtro($nombreTabla,"FECHA_TPROGRAPAGO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center">FECHA DE PROGRAPAGRAMACIÓN <br>DE PAGO (GASTO FIJO)</th>
<?php } ?><?php 
if($database->plantilla_filtro($nombreTabla,"NUMERO_EVENTOFIJO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center">NUMERO EVENTO (GASTO FIJO)</th>
<?php } ?><?php 
if($database->plantilla_filtro($nombreTabla,"CLASI_GENERAL",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center">CLASIFICACÓN GENERAL (GASTO FIJO)</th>
<?php } ?><?php 
if($database->plantilla_filtro($nombreTabla,"SUB_GENERAL",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center">SUB CLASIFICACÓN GENERAL (GASTO FIJO)</th>
<?php } ?><?php 
if($database->plantilla_filtro($nombreTabla,"NUMERO_EVENTO1",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center">NÚMERO EVENTO FIJO</th>
<?php } ?><?php 
if($database->plantilla_filtro($nombreTabla,"CLASIFICACION_GENERAL",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center">CLASIFICACION GENERAL</th>
<?php } ?><?php 
if($database->plantilla_filtro($nombreTabla,"CLASIFICACION_ESPECIFICA",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center">CLASIFICACION ESPECIFICA</th>
<?php } ?><?php 
if($database->plantilla_filtro($nombreTabla,"PLACAS_VEHICULO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center">PLACAS VEHICULO</th>
<?php } ?><?php 
if($database->plantilla_filtro($nombreTabla,"COMPLEMENTOS_PAGO_PDF",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center">COMPLEMENTOS DE PAGO PDF</th>
<?php } ?><?php 
if($database->plantilla_filtro($nombreTabla,"COMPLEMENTOS_PAGO_XML",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center">COMPLEMENTOS DE PAGO XML</th>
<?php } ?><?php 
if($database->plantilla_filtro($nombreTabla,"CANCELACIONES_PDF",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center">CANCELACIONES PDF</th>
<?php } ?><?php 
if($database->plantilla_filtro($nombreTabla,"CANCELACIONES_XML",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center">CANCELACIONES XML</th>
<?php } ?><?php 
if($database->plantilla_filtro($nombreTabla,"ADJUNTAR_FACTURA_DE_COMISION_PDF",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center">FACTURA DE COMISIÓN PDF</th>
<?php } ?><?php 
if($database->plantilla_filtro($nombreTabla,"ADJUNTAR_FACTURA_DE_COMISION_XML",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center">FACTURA DE COMISIÓN XML</th>
<?php } ?><?php 
if($database->plantilla_filtro($nombreTabla,"CALCULO_DE_COMISION",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center"> CALCULO DE COMISIÓN</th>
<?php } ?><?php 
if($database->plantilla_filtro($nombreTabla,"MONTO_DE_COMISION",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center"> MONTO DE COMISIÓN</th>
<?php } ?>

<?php 
if($database->plantilla_filtro($nombreTabla,"COMPROBANTE_DE_DEVOLUCION",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center">COMPROBANTE DE DEVOLUCIÓN<br> DE DINERO</th>
<?php } ?>

<?php 
if($database->plantilla_filtro($nombreTabla,"NOTA_DE_CREDITO_COMPRA",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center">NOTA DE CREDITO DE COMPRA</th>
<?php } ?><?php 
if($database->plantilla_filtro($nombreTabla,"POLIZA_NUMERO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#f48a81;text-align:center">POLIZA NUMERO</th>
<?php } ?><?php 
if($database->plantilla_filtro($nombreTabla,"NOMBRE_DEL_EJECUTIVO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center">NOMBRE DEL EJECUTIVO</th>
<?php } ?><?php 
if($database->plantilla_filtro($nombreTabla,"NOMBRE_DEL_AYUDO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center">NOMBRE DEL EJECUTIVO QUE<br> INGRESO ESTA FACTURA</th>
<?php } ?>



<?php 
if($database->plantilla_filtro($nombreTabla,"OBSERVACIONES_1",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center;width:700px;min-width:700px;max-width:700px;">OBSERVACIONES 1</th>
<?php } ?>


<?php 
if($database->plantilla_filtro($nombreTabla,"ADJUNTAR_ARCHIVO_1",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center">ARCHIVO RELACIONADO A ESTE GASTO:</th>
<?php } ?><?php 
if($database->plantilla_filtro($nombreTabla,"FECHA_DE_LLENADO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center">FECHA Y HORA <br>DE LLENADO</th>
<?php } ?>





<?php 
if($database->plantilla_filtro($nombreTabla,"CSF",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#ffd1d1;text-align:center">CONSTANCIA SITUACIÓN FISCAL</th>
<?php } ?><?php 
if($database->plantilla_filtro($nombreTabla,"OPINION_CUMPLIMIENTO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#ffd1d1;text-align:center">OPINION DE CUMPLIMIENTO</th>
<?php } ?>






<?php /*INICIA copiar y PEGAR XML */ ?>
<?php 
if($database->plantilla_filtro($nombreTabla,"NOMBRE_RECEPTOR",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<th style="background:#f9f3a1;text-align:center">NOMBRE RECEPTOR</th>
<?php } ?>
<?php 
if($database->plantilla_filtro($nombreTabla,"RFC_RECEPTOR",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<th style="background:#f9f3a1;text-align:center">RFC RECEPTOR</th>
<?php } ?>
<?php 
if($database->plantilla_filtro($nombreTabla,"REGIMEN_FISCAL",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<th style="background:#f9f3a1;text-align:center">REGÍMEN FISCAL</th>
<?php } ?>
<?php 
if($database->plantilla_filtro($nombreTabla,"UUID",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<th style="background:#f9f3a1;text-align:center">UUID:</th>
<?php } ?>

<?php 
if($database->plantilla_filtro($nombreTabla,"FOLIO",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<th style="background:#f9f3a1;text-align:center">FOLIO</th>
<?php } ?>

<?php 
if($database->plantilla_filtro($nombreTabla,"SERIE",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<th style="background:#f9f3a1;text-align:center">SERIE</th>
<?php } ?>
<?php 
if($database->plantilla_filtro($nombreTabla,"CLAVE_UNIDAD",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<th style="background:#f9f3a1;text-align:center">CLAVE DE UNIDAD:</th>
<?php } ?>
<?php 
if($database->plantilla_filtro($nombreTabla,"CANTIDAD",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<th style="background:#f9f3a1;text-align:center">CANTIDAD</th>
<?php } ?>
<?php 
if($database->plantilla_filtro($nombreTabla,"CLAVE_PODUCTO",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<th style="background:#f9f3a1;text-align:center">CLAVE DE PRODUCTO O SERVICIO</th>
<?php } ?>
<?php 
if($database->plantilla_filtro($nombreTabla,"DESCRIPCION",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<th style="background:#f9f3a1;text-align:center">DESCRIPCIÓN</th>
<?php } ?>




<?php 
if($database->plantilla_filtro($nombreTabla,"MonedaF",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<th style="background:#f9f3a1;text-align:center">MONEDA:</th>
<?php } ?>

<?php 
if($database->plantilla_filtro($nombreTabla,"TIPO_CAMBIO",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<th style="background:#f9f3a1;text-align:center">TIPO DE CAMBIO:</th>
<?php } ?>



<?php 
if($database->plantilla_filtro($nombreTabla,"USO_CFDI",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<th style="background:#f9f3a1;text-align:center">USO DE CFDI</th>
<?php } ?>
<?php 
if($database->plantilla_filtro($nombreTabla,"metodoDePago",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<th style="background:#f9f3a1;text-align:center">METODO DE PAGO:</th>
<?php } ?>
<?php 
if($database->plantilla_filtro($nombreTabla,"CONDICIONES_PAGO",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<th style="background:#f9f3a1;text-align:center">CONDICIONES DE PAGO:</th>
<?php } ?>
<?php 
if($database->plantilla_filtro($nombreTabla,"TIPO_COMPROBANTE",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<th style="background:#f9f3a1;text-align:center">TIPO DE COMPROBANTE:</th>
<?php } ?>
<?php 
if($database->plantilla_filtro($nombreTabla,"VERSION",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<th style="background:#f9f3a1;text-align:center">VERSIÓN:</th>
<?php } ?>

<?php 
if($database->plantilla_filtro($nombreTabla,"FECHA_TIMBRADO",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<th style="background:#f9f3a1;text-align:center">FECHA DE TIMBRADO:</th>
<?php } ?>




<?php 
if($database->plantilla_filtro($nombreTabla,"subTotal",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<th style="background:#f9f3a1;text-align:center">SUBTOTAL</th>
<?php } ?>

<?php 
if($database->plantilla_filtro($nombreTabla,"propina",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<th style="background:#f9f3a1;text-align:center">SERVICIO, PROPINA,<br>ISH Y SANAMIENTO</th>
<?php } ?>


<?php 
if($database->plantilla_filtro($nombreTabla,"Descuento",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<th style="background:#f9f3a1;text-align:center">DESCUENTO</th>
<?php } ?>



<?php 
if($database->plantilla_filtro($nombreTabla,"TOTAL_IMPUESTOS_TRASLADADOS",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<th style="background:#f9f3a1;text-align:center">IVA</th>
<?php } ?>

<?php 
if($database->plantilla_filtro($nombreTabla,"TOTAL_IMPUESTOS_RETENIDOS",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<th style="background:#f9f3a1;text-align:center">TOTAL DE IMPUESTOS<br> RETENIDOS</th>
<?php } ?>


<?php  if($database->plantilla_filtro($nombreTabla,"TUA",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<th style="background:#f9f3a1;text-align:center">TUA:</th> 
<?php } ?>

<?php 
if($database->plantilla_filtro($nombreTabla,"total",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<th style="background:#f9f3a1;text-align:center">TOTAL:</th>
<?php } ?>                                                                           



<th style="background:#f16c4f;text-align:center">46% PERDIDA DE COSTO FISCAL</th>


<?php if($database->variablespermisos('','boton_sinxml','ver')=='si'){ ?>
<th style="background:#BB27F5;text-align:center">SIN EFECTO<br> XML</th>
<?php } ?>

<?php if($database->variablespermisos('','boton_sin','ver')=='si'){ ?>
<th style="background:#c6eaaa;text-align:center">SIN 46%</th>
<?php } ?>

<?php if($database->variablespermisos('','boton_VOBO','ver')=='si'){ ?>
<th style="background:#94A2F5;text-align:center">VoBo CxP</th>
<?php } ?>



<?php 
if($database->plantilla_filtro($nombreTabla,"P_TIPO_DE_MONEDA_1",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center">TIPO DE MONEDA</th>
<?php } ?>

<?php 
if($database->plantilla_filtro($nombreTabla,"P_INSTITUCION_FINANCIERA_1",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center">INSTITUCION FINANCIERA</th>
<?php } ?>
<?php 
if($database->plantilla_filtro($nombreTabla,"P_NUMERO_DE_CUENTA_DB_1",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center">NÚMERO DE CUENTA</th>
<?php } ?>
<?php 
if($database->plantilla_filtro($nombreTabla,"P_NUMERO_CLABE_1",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center">CUENTA CLABE</th>
<?php } ?>
<?php 
if($database->plantilla_filtro($nombreTabla,"P_NUMERO_IBAN_1",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center">NÚMERO IBAN</th>
<?php } ?>
<?php 
if($database->plantilla_filtro($nombreTabla,"P_NUMERO_CUENTA_SWIFT_1",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center">NÚMERO DE CUENTA SWIFT</th>
<?php } ?>
<?php 
if($database->plantilla_filtro($nombreTabla,"FOTO_ESTADO_PROVEE",$altaeventos,$DEPARTAMENTO)=="si"){ ?><th style="background:#c9e8e8;text-align:center">FOTO ESTADO DE CUENTA</th><?php } ?>  


<th style="background:#c9e8e8"></th>
<th style="background:#c9e8e8"></th>
<th style="background:#c9e8e8"></th>
<th style="background:#c9e8e8"></th>

</tr>











          
            <tr>
<td style="background:#c9e8e8"></td>
<td style="background:#c9e8e8"></td>
<td style="background:#c9e8e8"></td>
<td style="background:#c9e8e8"></td>
<td style="background:#c9e8e8"></td>
<td style="background:#c9e8e8"></td>
<td style="background:#c9e8e8"></td>
<td style="background:#c9e8e8"></td>



<?php  
if($database->plantilla_filtro($nombreTabla,"ADJUNTAR_FACTURA_XML",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8;text-align:center"><input type="text" class="form-control" id="ADJUNTAR_FACTURA_XML" value="<?php
echo $ADJUNTAR_FACTURA_XML; ?>"></td>
<?php } ?>

<?php  
if($database->plantilla_filtro($nombreTabla,"ADJUNTAR_FACTURA_PDF",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8;text-align:center"><input type="text" class="form-control" id="ADJUNTAR_FACTURA_PDF" value="<?php
echo $ADJUNTAR_FACTURA_PDF; ?>"></td>
<?php } ?>

<?php if($database->plantilla_filtro($nombreTabla,"NUMERO_CONSECUTIVO_PROVEE",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8"><input type="text" class="form-control" id="NUMERO_CONSECUTIVO_PROVEE_2" value="<?php 
echo $NUMERO_CONSECUTIVO_PROVEE; ?>"></td>
<?php } ?>


<?php  
if($database->plantilla_filtro($nombreTabla,"VIATICOSOPRO",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
             <td style="background:#c9e8e8">
				
			<select class="form-select mb-3" aria-label="Default select example" id="VIATICOSOPRO_2" onchange="load(1);">
			<option value="">TODOS</option>
			
			<option value="PAGO A PROVEEDOR" <?php if($_POST['VIATICOSOPRO']=='PAGO A PROVEEDOR'){echo 'selected';} ?>>PAGO A PROVEEDOR</option>
			
			<option value="VIATICOS" <?php if($_POST['VIATICOSOPRO']=='VIATICOS'){echo 'selected';} ?>>VIATICOS</option>
			
			<option value="REEMBOLSO" <?php if($_POST['VIATICOSOPRO']=='REEMBOLSO'){echo 'selected';} ?>>REEMBOLSOS</option>
			
			
			<option value="PAGOS CON UNA SOLA FACTURA" <?php if($_POST['VIATICOSOPRO']=='PAGOS CON UNA SOLA FACTURA'){echo 'selected';} ?>>PAGOS CON UNA SOLA FACTURA</option>
			<option value="PAGO A PROVEEDOR CON DOS O MAS FACTURAS" <?php if($_POST['VIATICOSOPRO']=='PAGO A PROVEEDOR CON DOS O MAS FACTURAS'){echo 'selected';} ?>>PAGO A PROVEEDOR CON DOS O MAS FACTURAS</option>
			<option value="SELECCIONA UNA OPCION" <?php if($_POST['VIATICOSOPRO']=='SELECCIONA UNA OPCION'){echo 'selected';} ?>>SELECCIONA UNA OPCION</option>								
			</select>
</td>
<?php } ?>



<?php  
if($database->plantilla_filtro($nombreTabla,"NOMBRE_COMERCIAL",$altaeventos,$DEPARTAMENTO)=="si"){ ?>

<td style="background:#c9e8e8"><input type="text" class="form-control" id="NOMBRE_COMERCIAL_2" value="<?php 
echo $NOMBRE_COMERCIAL; ?>"></td>
<?php } ?>

<?php  
if($database->plantilla_filtro($nombreTabla,"RAZON_SOCIAL",$altaeventos,$DEPARTAMENTO)=="si"){ ?>

<td style="background:#c9e8e8;text-align:center"  >
    <!-- Contenedor flex sin espacio entre elementos -->
    <div style="display: flex; align-items: center; gap: 0;">
        <input style="width:300px; margin-right: 0; border-right: none; border-top-right-radius: 0; border-bottom-right-radius: 0;" 
               type="text" 
               class="form-control" 
               id="RAZON_SOCIAL_2" 
               value="<?php echo $RAZON_SOCIAL; ?>"/>
        
        <select style="width:80px; border-top-left-radius: 0; border-bottom-left-radius: 0; margin-left: 0;"
                id="RAZON_SOCIAL_orden" 
                onchange="load('<?php echo $_POST['page']; ?>')">
            <option value="">NORMAL</option>
            <option value="asc" <?= $_POST['RAZON_SOCIAL_orden']=='asc' ? 'selected' : '' ?>>ASC</option>
            <option value="desc" <?= $_POST['RAZON_SOCIAL_orden']=='desc' ? 'selected' : '' ?>>DESC</option>
        </select>
    </div>
</td>
<?php } ?>


<?php  
if($database->plantilla_filtro($nombreTabla,"RFC_PROVEEDOR",$altaeventos,$DEPARTAMENTO)=="si"){ ?>

<td style="background:#c9e8e8">

<div style="display: flex; justify-content: space-between; align-items: center;">
<input type="text"  style="width:200PX;" class="form-control" id="RFC_PROVEEDOR_2" value="<?php 
echo $RFC_PROVEEDOR; ?>"/>

<select style="width:80PX; padding-bottom:0px; margin-bottom:0px;" id="RFC_PROVEEDOR_orden" href="javascript:void(0);" onchange="load('<?php echo $_POST['page']; ?>')">

			<option value="">NORMAL</option>
			
			<option value="asc" <?php if($_POST['RFC_PROVEEDOR_orden']=='asc'){echo 'selected';} ?>>ASC</option>
			
			<option value="desc" <?php if($_POST['RFC_PROVEEDOR_orden']=='desc'){echo 'selected';} ?>>DESC</option>
</select>
</div>

</td>
<?php } ?>



<?php  
if($database->plantilla_filtro($nombreTabla,"NUMERO_EVENTO",$altaeventos,$DEPARTAMENTO)=="si"){ ?>

<td style="background:#c9e8e8">



<div style="display: flex; justify-content: space-between; align-items: center;">

<input type="text" style="width:200PX;" class="form-control" id="NUMERO_EVENTO_2" value="<?php 
echo $NUMERO_EVENTO; ?>">

<select style="width:80PX; padding-bottom:0px; margin-bottom:0px;" id="NUMERO_EVENTO_orden" href="javascript:void(0);" onchange="load('<?php echo $_POST['page']; ?>')">

			<option value="">NORMAL</option>
			
			<option value="asc" <?php if($_POST['NUMERO_EVENTO_orden']=='asc'){echo 'selected';} ?>>ASC</option>
			
			<option value="desc" <?php if($_POST['NUMERO_EVENTO_orden']=='desc'){echo 'selected';} ?>>DESC</option>
</select>

</div>
</td>
<?php } ?>



<?php  
if($database->plantilla_filtro($nombreTabla,"NOMBRE_EVENTO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8"><input type="text" class="form-control" id="NOMBRE_EVENTO_2" value="<?php 
echo $NOMBRE_EVENTO; ?>">
</td>
<?php } ?>

<?php  
if($database->plantilla_filtro($nombreTabla,"FECHA_INICIO_EVENTO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8"><input type="date" class="form-control" id="FECHA_INICIO_EVENTO" value="<?php 
echo $FECHA_INICIO_EVENTO; ?>">
</td>
<?php } ?>

<?php  
if($database->plantilla_filtro($nombreTabla,"FECHA_FINAL_EVENTO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8"><input type="date" class="form-control" id="FECHA_FINAL_EVENTO" value="<?php 
echo $FECHA_FINAL_EVENTO; ?>">
</td>
<?php } ?>


<?php  
if($database->plantilla_filtro($nombreTabla,"MOTIVO_GASTO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8"><input type="text" class="form-control" id="MOTIVO_GASTO_2" value="<?php 
echo $MOTIVO_GASTO; ?>"></td>
<?php } ?><?php  
if($database->plantilla_filtro($nombreTabla,"CONCEPTO_PROVEE",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8"><input type="text" class="form-control" id="CONCEPTO_PROVEE_2" value="<?php 
echo $CONCEPTO_PROVEE; ?>"></td>
<?php } ?><?php  
if($database->plantilla_filtro($nombreTabla,"MONTO_TOTAL_COTIZACION_ADEUDO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8"><input type="text" class="form-control" id="MONTO_TOTAL_COTIZACION_ADEUDO_2" value="<?php 
echo $MONTO_TOTAL_COTIZACION_ADEUDO; ?>"></td>
<?php } ?>

<?php  
if($database->plantilla_filtro($nombreTabla,"MONTO_FACTURA",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8">


<div style="display: flex; justify-content: space-between; align-items: center;">


<input type="text"  style="width:200PX;" class="form-control" id="MONTO_FACTURA_2" value="<?php 
echo $MONTO_FACTURA; ?>">


<select style="width:80PX; padding-bottom:0px; margin-bottom:0px;" id="MONTO_FACTURA_orden" href="javascript:void(0);" onchange="load('<?php echo $_POST['page']; ?>')">

			<option value="">NORMAL</option>
			
			<option value="asc" <?php if($_POST['MONTO_FACTURA_orden']=='asc'){echo 'selected';} ?>>ASC</option>
			
			<option value="desc" <?php if($_POST['MONTO_FACTURA_orden']=='desc'){echo 'selected';} ?>>DESC</option>
</select>

</div>

</td>
<?php } ?>


<?php  
if($database->plantilla_filtro($nombreTabla,"IVA",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8"><input type="text" class="form-control" id="IVA_1" value="<?php 
echo $IVA; ?>"></td>
<?php } ?>

<?php  
if($database->plantilla_filtro($nombreTabla,"TImpuestosRetenidosIVA",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8"><input type="text" class="form-control" id="TImpuestosRetenidosIVA_3" value="<?php 
echo $TImpuestosRetenidosIVA; ?>"></td>
<?php } ?>

<?php  
if($database->plantilla_filtro($nombreTabla,"TImpuestosRetenidosISR",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8"><input type="text" class="form-control" id="TImpuestosRetenidosISR_3" value="<?php 
echo $TImpuestosRetenidosISR; ?>"></td>
<?php } ?>

<?php  
if($database->plantilla_filtro($nombreTabla,"MONTO_PROPINA",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8"><input type="text" class="form-control" id="MONTO_PROPINA_2" value="<?php 
echo $MONTO_PROPINA; ?>"></td>
<?php } ?>

<?php  
if($database->plantilla_filtro($nombreTabla,"IMPUESTO_HOSPEDAJE",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8"><input type="text" class="form-control" id="IMPUESTO_HOSPEDAJE_2" value="<?php 
echo $IMPUESTO_HOSPEDAJE; ?>"></td>
<?php } ?>

<?php  
if($database->plantilla_filtro($nombreTabla,"descuentos",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8"><input type="text" class="form-control" id="descuentos_3" value="<?php 
echo $descuentos; ?>"></td>
<?php } ?>

<?php  
if($database->plantilla_filtro($nombreTabla,"MONTO_DEPOSITAR",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8"><input type="text" class="form-control" id="MONTO_DEPOSITAR_2" value="<?php 
echo $MONTO_DEPOSITAR; ?>"></td>
<?php } ?><?php  
if($database->plantilla_filtro($nombreTabla,"MONTO_DEPOSITADO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#f48a81"><input type="text" class="form-control" id="MONTO_DEPOSITADO_2" value="<?php 
echo $MONTO_DEPOSITADO; ?>"></td>
<?php } ?><?php  
if($database->plantilla_filtro($nombreTabla,"PENDIENTE_PAGO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8"><input type="text" class="form-control" id="PENDIENTE_PAGO_2" value="<?php 
echo $PENDIENTE_PAGO; ?>"></td>
<?php } ?>

<?php  
if($database->plantilla_filtro($nombreTabla,"TIPO_DE_MONEDA",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
    <td style="background:#c9e8e8">
        <select class="form-select mb-3" aria-label="Default select example" id="TIPO_DE_MONEDA_2" name="TIPO_DE_MONEDA" onchange="load(1);">
            <option value="">TODOS</option>
            <option style="background: #c9e8e8" value="MXN" <?php if($TIPO_DE_MONEDA=='MXN'){echo "selected";} ?>>MXN (Peso mexicano)</option>
            <option style="background: #a3e4d7" value="USD" <?php if($TIPO_DE_MONEDA=='USD'){echo "selected";} ?>>USD (Dólar estadounidense)</option>
            <option style="background: #e8f6f3" value="EUR" <?php if($TIPO_DE_MONEDA=='EUR'){echo "selected";} ?>>EUR (Euro)</option>
            <option style="background: #fdf2e9" value="GBP" <?php if($TIPO_DE_MONEDA=='GBP'){echo "selected";} ?>>GBP (Libra esterlina)</option>
            <option style="background: #eaeded" value="CHF" <?php if($TIPO_DE_MONEDA=='CHF'){echo "selected";} ?>>CHF (Franco suizo)</option>
            <option style="background: #fdebd0" value="CNY" <?php if($TIPO_DE_MONEDA=='CNY'){echo "selected";} ?>>CNY (Yuan chino)</option>
            <option style="background: #ebdef0" value="JPY" <?php if($TIPO_DE_MONEDA=='JPY'){echo "selected";} ?>>JPY (Yen japonés)</option>
            <option style="background: #d6eaf8" value="HKD" <?php if($TIPO_DE_MONEDA=='HKD'){echo "selected";} ?>>HKD (Dólar hongkonés)</option>
            <option style="background: #fef5e7" value="CAD" <?php if($TIPO_DE_MONEDA=='CAD'){echo "selected";} ?>>CAD (Dólar canadiense)</option>
            <option style="background: #ebedef" value="AUD" <?php if($TIPO_DE_MONEDA=='AUD'){echo "selected";} ?>>AUD (Dólar australiano)</option>
            <option style="background: #fbeee6" value="BRL" <?php if($TIPO_DE_MONEDA=='BRL'){echo "selected";} ?>>BRL (Real brasileño)</option>
            <option style="background: #e8f6f3" value="RUB" <?php if($TIPO_DE_MONEDA=='RUB'){echo "selected";} ?>>RUB (Rublo ruso)</option>
			<option value="SELECCIONA UNA OPCION" <?php if($_POST['TIPO_DE_MONEDA']=='SELECCIONA UNA OPCION'){echo 'selected';} ?>>SELECCIONA UNA OPCION</option>								
			</select>
</td>
<?php } ?>


<?php  
if($database->plantilla_filtro($nombreTabla,"TIPO_CAMBIOP",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8"><input type="text" class="form-control" id="TIPO_CAMBIOP_2" value="<?php 
echo $TIPO_CAMBIOP; ?>"></td>
<?php } ?><?php  
if($database->plantilla_filtro($nombreTabla,"TOTAL_ENPESOS",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8"><input type="text" class="form-control" id="TOTAL_ENPESOS_2" value="<?php 
echo $TOTAL_ENPESOS; ?>"></td>
<?php } ?>



<?php  
if($database->plantilla_filtro($nombreTabla,"PFORMADE_PAGO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8"><input type="text" class="form-control" id="PFORMADE_PAGO_2" value="<?php 
echo $PFORMADE_PAGO; ?>"></td>
<?php } ?>


<?php  
if($database->plantilla_filtro($nombreTabla,"FECHA_DE_PAGO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8;text-align:center">
<table>
<tr>
<td><strong>INICIA&nbsp;</strong></td>
<td><input type="date" class="form-control" id="FECHA_DE_PAGO" value="<?php 
echo $FECHA_DE_PAGO; ?>"></td>

<td><strong>TERMINA&nbsp;</strong></td>
<td><input type="date" class="form-control" id="FECHA_DE_PAGO2a" value="<?php 
echo $FECHA_DE_PAGO2a; ?>"></td>
<td style="padding-left:10px;">
	<div class="form-check">
		<input class="form-check-input" type="checkbox" value="1" id="FECHA_DE_PAGO_VACIO" <?php if($FECHA_DE_PAGO_VACIO==='1'){echo 'checked';} ?>>
		<label class="form-check-label" for="FECHA_DE_PAGO_VACIO">
			VACÍOS
		</label>
	</div>
</td>
</tr>
</table>
</div>
</td>
<?php } ?>



<?php  
if($database->plantilla_filtro($nombreTabla,"FECHA_A_DEPOSITAR",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#f48a81"><input type="date" class="form-control" id="FECHA_A_DEPOSITAR_2" value="<?php 
echo $FECHA_A_DEPOSITAR; ?>"></td>
<?php } ?>

<?php  
if($database->plantilla_filtro($nombreTabla,"STATUS_DE_PAGO",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
             </br><td style="background:#f48a81">
				
			<select class="form-select mb-3" aria-label="Default select example" id="STATUS_DE_PAGO_2" onchange="load(1);">
			<option value="">TODOS</option>
			<option value="SOLICITADO" <?php if($_POST['STATUS_DE_PAGO']=='SOLICITADO'){echo 'selected';} ?>>SOLICITADO</option>
			<option value="APROBADO" <?php if($_POST['STATUS_DE_PAGO']=='APROBADO'){echo 'selected';} ?>>APROBADO</option>
			<option value="PAGADO" <?php if($_POST['STATUS_DE_PAGO']=='PAGADO'){echo 'selected';} ?>>PAGADO</option>
			<option value="RECHAZADO" <?php if($_POST['STATUS_DE_PAGO']=='RECHAZADO'){echo 'selected';} ?>>RECHAZADO</option>
			<option value="SELECCIONA UNA OPCION" <?php if($_POST['STATUS_DE_PAGO']=='SELECCIONA UNA OPCION'){echo 'selected';} ?>>SELECCIONA UNA OPCION</option>								
			</select>
</td>
<?php } ?>


<?php  
if($database->plantilla_filtro($nombreTabla,"ADJUNTAR_COTIZACION",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8;text-align:center"><input type="text" class="form-control" id="ADJUNTAR_COTIZACION" value="<?php
echo $ADJUNTAR_COTIZACION; ?>"></td>
<?php } ?>
<?php  
if($database->plantilla_filtro($nombreTabla,"CONPROBANTE_TRANSFERENCIA",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#f48a81;text-align:center"><input type="text" class="form-control" id="CONPROBANTE_TRANSFERENCIA" value="<?php
echo $CONPROBANTE_TRANSFERENCIA; ?>"></td>
<?php } ?>

<?php  
if($database->plantilla_filtro($nombreTabla,"ACTIVO_FIJO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8"><input type="text" class="form-control" id="ACTIVO_FIJO_2" value="<?php 
echo $ACTIVO_FIJO; ?>"></td>
<?php } ?><?php  
if($database->plantilla_filtro($nombreTabla,"GASTO_FIJO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8"><input type="text" class="form-control" id="GASTO_FIJO_2" value="<?php 
echo $GASTO_FIJO; ?>"></td>
<?php } ?><?php  
if($database->plantilla_filtro($nombreTabla,"PAGAR_CADA",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8"><input type="text" class="form-control" id="PAGAR_CADA_2" value="<?php 
echo $PAGAR_CADA; ?>"></td>
<?php } ?><?php  
if($database->plantilla_filtro($nombreTabla,"FECHA_PPAGO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8"><input type="date" class="form-control" id="FECHA_PPAGO_2" value="<?php 
echo $FECHA_PPAGO; ?>"></td>
<?php } ?><?php  
if($database->plantilla_filtro($nombreTabla,"FECHA_TPROGRAPAGO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8"><input type="date" class="form-control" id="FECHA_TPROGRAPAGO_2" value="<?php 
echo $FECHA_TPROGRAPAGO; ?>"></td>
<?php } ?><?php  
if($database->plantilla_filtro($nombreTabla,"NUMERO_EVENTOFIJO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8"><input type="text" class="form-control" id="NUMERO_EVENTOFIJO_2" value="<?php 
echo $NUMERO_EVENTOFIJO; ?>"></td>
<?php } ?><?php  
if($database->plantilla_filtro($nombreTabla,"CLASI_GENERAL",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8"><input type="text" class="form-control" id="CLASI_GENERAL_2" value="<?php 
echo $CLASI_GENERAL; ?>"></td>
<?php } ?><?php  
if($database->plantilla_filtro($nombreTabla,"SUB_GENERAL",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8"><input type="text" class="form-control" id="SUB_GENERAL_2" value="<?php 
echo $SUB_GENERAL; ?>"></td>
<?php } ?><?php  
if($database->plantilla_filtro($nombreTabla,"NUMERO_EVENTO1",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8"><input type="text" class="form-control" id="NUMERO_EVENTO1_2" value="<?php 
echo $NUMERO_EVENTO1; ?>"></td>
<?php } ?><?php  
if($database->plantilla_filtro($nombreTabla,"CLASIFICACION_GENERAL",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8"><input type="text" class="form-control" id="CLASIFICACION_GENERAL_2" value="<?php 
echo $CLASIFICACION_GENERAL; ?>"></td>
<?php } ?><?php  
if($database->plantilla_filtro($nombreTabla,"CLASIFICACION_ESPECIFICA",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8"><input type="text" class="form-control" id="CLASIFICACION_ESPECIFICA_2" value="<?php 
echo $CLASIFICACION_ESPECIFICA; ?>"></td>
<?php } ?><?php  
if($database->plantilla_filtro($nombreTabla,"PLACAS_VEHICULO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8"><input type="text" class="form-control" id="PLACAS_VEHICULO_2" value="<?php 
echo $PLACAS_VEHICULO; ?>"></td>
<?php } ?>
<?php  
if($database->plantilla_filtro($nombreTabla,"COMPLEMENTOS_PAGO_PDF",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8;text-align:center"><input type="text" class="form-control" id="COMPLEMENTOS_PAGO_PDF" value="<?php
echo $COMPLEMENTOS_PAGO_PDF; ?>"></td>
<?php } ?>
<?php  
if($database->plantilla_filtro($nombreTabla,"COMPLEMENTOS_PAGO_XML",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8;text-align:center"><input type="text" class="form-control" id="COMPLEMENTOS_PAGO_XML" value="<?php
echo $COMPLEMENTOS_PAGO_XML; ?>"></td>
<?php } ?>
<?php  
if($database->plantilla_filtro($nombreTabla,"CANCELACIONES_PDF",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8;text-align:center"><input type="text" class="form-control" id="CANCELACIONES_PDF" value="<?php
echo $CANCELACIONES_PDF; ?>"></td>
<?php } ?>
<?php  
if($database->plantilla_filtro($nombreTabla,"CANCELACIONES_XML",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8;text-align:center"><input type="text" class="form-control" id="CANCELACIONES_XML" value="<?php
echo $CANCELACIONES_XML; ?>"></td>
<?php } ?>
<?php  
if($database->plantilla_filtro($nombreTabla,"ADJUNTAR_FACTURA_DE_COMISION_PDF",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8;text-align:center"><input type="text" class="form-control" id="ADJUNTAR_FACTURA_DE_COMISION_PDF" value="<?php
echo $ADJUNTAR_FACTURA_DE_COMISION_PDF; ?>"></td>
<?php } ?>
<?php  
if($database->plantilla_filtro($nombreTabla,"ADJUNTAR_FACTURA_DE_COMISION_XML",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8;text-align:center"><input type="text" class="form-control" id="ADJUNTAR_FACTURA_DE_COMISION_XML" value="<?php
echo $ADJUNTAR_FACTURA_DE_COMISION_XML; ?>"></td>
<?php } ?>
<?php  
if($database->plantilla_filtro($nombreTabla,"CALCULO_DE_COMISION",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8;text-align:center"><input type="text" class="form-control" id="CALCULO_DE_COMISION" value="<?php
echo $CALCULO_DE_COMISION; ?>"></td>
<?php } ?>
<?php  
if($database->plantilla_filtro($nombreTabla,"MONTO_DE_COMISION",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8"><input type="text" class="form-control" id="MONTO_DE_COMISION_2" value="<?php 
echo $MONTO_DE_COMISION; ?>"></td>
<?php } ?>
<?php  
if($database->plantilla_filtro($nombreTabla,"COMPROBANTE_DE_DEVOLUCION",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8;text-align:center"><input type="text" class="form-control" id="COMPROBANTE_DE_DEVOLUCION" value="<?php
echo $COMPROBANTE_DE_DEVOLUCION; ?>"></td>
<?php } ?>

<?php  
if($database->plantilla_filtro($nombreTabla,"NOTA_DE_CREDITO_COMPRA",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8;text-align:center"><input type="text" class="form-control" id="NOTA_DE_CREDITO_COMPRA" value="<?php
echo $NOTA_DE_CREDITO_COMPRA; ?>"></td>
<?php } ?>

<?php  
if($database->plantilla_filtro($nombreTabla,"POLIZA_NUMERO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#f48a81"><input type="text" class="form-control" id="POLIZA_NUMERO_2" value="<?php 
echo $POLIZA_NUMERO; ?>"></td>
<?php } ?><?php  
if($database->plantilla_filtro($nombreTabla,"NOMBRE_DEL_EJECUTIVO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8"><input type="text" class="form-control" id="NOMBRE_DEL_EJECUTIVO_2" value="<?php 
echo $NOMBRE_DEL_EJECUTIVO; ?>"></td>
<?php } ?>
<?php  
if($database->plantilla_filtro($nombreTabla,"NOMBRE_DEL_AYUDO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8"><input type="text" class="form-control" id="NOMBRE_DEL_AYUDO_2" value="<?php 
echo $NOMBRE_DEL_AYUDO; ?>"></td>
<?php } ?>



<?php  
if($database->plantilla_filtro($nombreTabla,"OBSERVACIONES_1",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8;width:700px;min-width:700px;max-width:700px;"><input type="text" class="form-control" id="OBSERVACIONES_1_2" value="<?php 
echo $OBSERVACIONES_1; ?>"></td>
<?php } ?>
<?php  
if($database->plantilla_filtro($nombreTabla,"ADJUNTAR_ARCHIVO_1",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8;text-align:center"><input type="text" class="form-control" id="ADJUNTAR_ARCHIVO_2" value="<?php
echo $ADJUNTAR_ARCHIVO_1; ?>"></td>
<?php } ?>

<?php  
if($database->plantilla_filtro($nombreTabla,"FECHA_DE_LLENADO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8"><input type="date" class="form-control" id="FECHA_DE_LLENADO_2" value="<?php 
echo $FECHA_DE_LLENADO; ?>"></td>
<?php } ?>






<?php 
if($database->plantilla_filtro($nombreTabla,"CSF",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#ffd1d1;"></td>
<?php } ?><?php 
if($database->plantilla_filtro($nombreTabla,"OPINION_CUMPLIMIENTO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#ffd1d1;"></td>
<?php } ?>









<?php  
if($database->plantilla_filtro($nombreTabla,"NOMBRE_RECEPTOR",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<td style="background:#f9f3a1;text-align:center"><input type="text" class="form-control" id="nombreR_1" value="<?php
echo $nombreR; ?>"></td>
<?php } ?>
<?php  
if($database->plantilla_filtro($nombreTabla,"RFC_RECEPTOR",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<td style="background:#f9f3a1;text-align:center"><input type="text" class="form-control" id="rfcR_1" value="<?php
echo $rfcR; ?>"></td>
<?php } ?>
<?php  
if($database->plantilla_filtro($nombreTabla,"REGIMEN_FISCAL",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<td style="background:#f9f3a1;text-align:center"><input type="text" class="form-control" id="regimenE_1" value="<?php
echo $regimenE; ?>"></td>
<?php } ?>
<?php  
if($database->plantilla_filtro($nombreTabla,"UUID",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<td style="background:#f9f3a1;text-align:center"><input type="text" class="form-control" id="UUID_1" value="<?php
echo $UUID; ?>"></td>
<?php } ?>
<?php  
if($database->plantilla_filtro($nombreTabla,"FOLIO",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<td style="background:#f9f3a1;text-align:center"><input type="text" class="form-control" id="folio_1" value="<?php
echo $folio; ?>"></td>
<?php } ?>
<?php  
if($database->plantilla_filtro($nombreTabla,"SERIE",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<td style="background:#f9f3a1;text-align:center"><input type="text" class="form-control" id="serie_1" value="<?php echo $serie; ?>"></td>
<?php } ?>
<?php  
if($database->plantilla_filtro($nombreTabla,"CLAVE_UNIDAD",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<td style="background:#f9f3a1;text-align:center"><input type="text" class="form-control" id="ClaveUnidadConcepto_1" value="<?php
echo $ClaveUnidadConcepto; ?>"></td>
<?php } ?>
<?php  
if($database->plantilla_filtro($nombreTabla,"CANTIDAD",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<td style="background:#f9f3a1;text-align:center"><input type="text" class="form-control" id="CantidadConcepto_1" value="<?php
echo $CantidadConcepto; ?>"></td>
<?php } ?>
<?php  
if($database->plantilla_filtro($nombreTabla,"CLAVE_PODUCTO",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<td style="background:#f9f3a1;text-align:center"><input type="text" class="form-control" id="ClaveProdServConcepto_1" value="<?php
echo $ClaveProdServConcepto; ?>"></td>
<?php } ?>
<?php  
if($database->plantilla_filtro($nombreTabla,"DESCRIPCION",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<td style="background:#f9f3a1;text-align:center"><input type="text" class="form-control" id="DescripcionConcepto_1" value="<?php
echo $DescripcionConcepto ; ?>"></td>
<?php } ?>




<?php  
if($database->plantilla_filtro($nombreTabla,"MonedaF",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<td style="background:#f9f3a1;text-align:center"><input type="text" class="form-control" id="Moneda_1" value="<?php
echo $Moneda; ?>"></td>
<?php } ?>


<?php  
if($database->plantilla_filtro($nombreTabla,"TIPO_CAMBIO",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<td style="background:#f9f3a1;text-align:center"><input type="text" class="form-control" id="TipoCambio_1" value="<?php
echo $TipoCambio; ?>"></td>
<?php } ?>


<?php  
if($database->plantilla_filtro($nombreTabla,"USO_CFDI",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<td style="background:#f9f3a1;text-align:center"><input type="text" class="form-control" id="UsoCFDI_1" value="<?php
echo $UsoCFDI; ?>"></td>
<?php } ?>
<?php  
if($database->plantilla_filtro($nombreTabla,"metodoDePago",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<td style="background:#f9f3a1;text-align:center"><input type="text" class="form-control" id="metodoDePago_1" value="<?php
echo $metodoDePago; ?>"></td>
<?php } ?>
<?php  
if($database->plantilla_filtro($nombreTabla,"CONDICIONES_PAGO",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<td style="background:#f9f3a1;text-align:center"><input type="text" class="form-control" id="condicionesDePago_1" value="<?php
echo $condicionesDePago; ?>"></td>
<?php } ?>
<?php  
if($database->plantilla_filtro($nombreTabla,"TIPO_COMPROBANTE",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<td style="background:#f9f3a1;text-align:center"><input type="text" class="form-control" id="tipoDeComprobante_1" value="<?php
echo $tipoDeComprobante; ?>"></td>
<?php } ?>
<?php  
if($database->plantilla_filtro($nombreTabla,"VERSION",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<td style="background:#f9f3a1;text-align:center"><input type="text" class="form-control" id="Version_1" value="<?php
echo $Version; ?>"></td>
<?php } ?>





<?php  
if($database->plantilla_filtro($nombreTabla,"FECHA_TIMBRADO",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<td style="background:#f9f3a1;text-align:center"><input type="text" class="form-control" id="fechaTimbrado_1" value="<?php
echo $fechaTimbrado; ?>"></td>
<?php } ?>



<?php  
if($database->plantilla_filtro($nombreTabla,"subTotal",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<td style="background:#f9f3a1;text-align:center"><input type="text" class="form-control" id="subTotal11" value="<?php
echo $subTotal; ?>"></td>
<?php } ?>


<?php  
if($database->plantilla_filtro($nombreTabla,"propina",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<td style="background:#f9f3a1;text-align:center"><input type="text" class="form-control" id="propina_1" value="<?php
echo $propina; ?>"></td>
<?php } ?>

<?php  
if($database->plantilla_filtro($nombreTabla,"Descuento",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<td style="background:#f9f3a1;text-align:center"><input type="text" class="form-control" id="Descuento_1" value="<?php
echo $Descuento; ?>"></td>
<?php } ?>


<?php  
if($database->plantilla_filtro($nombreTabla,"TOTAL_IMPUESTOS_TRASLADADOS",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<td style="background:#f9f3a1;text-align:center"><input type="text" class="form-control" id="TImpuestosTrasladados_1" value="<?php
echo $TImpuestosTrasladados; ?>"></td>
<?php } ?>

<?php  
if($database->plantilla_filtro($nombreTabla,"TOTAL_IMPUESTOS_RETENIDOS",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<td style="background:#f9f3a1;text-align:center"><input type="text" class="form-control" id="TImpuestosRetenidos_1" value="<?php
echo $TImpuestosRetenidos; ?>"></td>
<?php } ?>



<?php  if($database->plantilla_filtro($nombreTabla,"TUA",$altaeventos,$DEPARTAMENTO)=="si"){ ?>

<td style="background:#f9f3a1;text-align:center"><input type="text" class="form-control" id="TUA_1" value="<?php
echo $TUA; ?>"></td>
<?php } ?>

<?php  
if($database->plantilla_filtro($nombreTabla,"total",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<td style="background:#f9f3a1;text-align:center"><input type="text" class="form-control" id="totalf_1" value="<?php echo $totalf; ?>"></td>
<?php } ?>

<td style="background:#f16c4f;text-align:center"><input type="text" class="form-control" id="PorfaltaDeFactura_1" value="<?php
echo $PorfaltaDeFactura; ?>"></td>


<?php if($database->variablespermisos('','boton_sinxml','ver')=='si'){ ?>     
<td style="background:#BB27F5;text-align:center"></td>
<?php } ?>


<?php if($database->variablespermisos('','boton_sin','ver')=='si'){ ?>     
<td style="background:#c6eaaa;text-align:center"></td>
<?php } ?>




<?php if($database->variablespermisos('','boton_VOBO','ver')=='si'){ ?> 
<td style="background:#94A2F5;text-align:center"></td>
<?php } ?>


<?php  
if($database->plantilla_filtro($nombreTabla,"P_TIPO_DE_MONEDA_1",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8;text-align:center"></td>
<?php } ?>
<?php  
if($database->plantilla_filtro($nombreTabla,"P_INSTITUCION_FINANCIERA_1",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8;text-align:center"></td>
<?php } ?>
<?php  
if($database->plantilla_filtro($nombreTabla,"P_NUMERO_DE_CUENTA_DB_1",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8;text-align:center"></td>
<?php } ?>
<?php  
if($database->plantilla_filtro($nombreTabla,"P_NUMERO_CLABE_1",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8;text-align:center"></td>
<?php } ?>
<?php  
if($database->plantilla_filtro($nombreTabla,"P_NUMERO_IBAN_1",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8;text-align:center"></td>
<?php } ?>
<?php  
if($database->plantilla_filtro($nombreTabla,"P_NUMERO_CUENTA_SWIFT_1",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8;text-align:center"></td>
<?php } ?>
<?php  
if($database->plantilla_filtro($nombreTabla,"FOTO_ESTADO_PROVEE",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="background:#c9e8e8;text-align:center"></td>
<?php } ?>





		<td style="background:#c9e8e8"></td>
		<td style="background:#c9e8e8"></td>
		<td style="background:#c9e8e8"></td>
		<td style="background:#c9e8e8"></td>
            </tr>			
        </thead>
		<?php 	if ($numrows<0){ ?>
		</table>
		<table>
		<?php }else{ ?>		
        <tbody>
		<?php
		$finales=0;
		$totales = 'no';




             $database->TruncateingresarTemproal2();//borramos los temporales
                $balance2 = 0 ;//no calcula ningun balance, va en 000 ceros
                foreach ($datos as $key2=>$row2){
                        $nombreComercialTemporal = isset($row2['NOMBRE_COMERCIAL']) ? trim($row2['NOMBRE_COMERCIAL']) : '';
                        $identificadorProveedor = $nombreComercialTemporal !== '' ? $nombreComercialTemporal : (isset($row2['RFC_PROVEEDOR']) ? trim($row2['RFC_PROVEEDOR']) : '');
                        $database->ingresarTemproal2($identificadorProveedor,$row2['MONTO_TOTAL_COTIZACION_ADEUDO'],$row2['MONTO_DEPOSITADO'],$row2['02SUBETUFACTURAid'],$balance2);//guardamos en el priemr temporal
                }
                $datos2 = $database->resultadoTemproal2();//regresamos ordenamos por rfc y id ascendente

                $database->TruncateingresarTemproal();//borramos temporales
                $ultimoNombreComercial = '';
                $balance = 0;
                foreach ($datos2 as $key=>$row){

                        $identificadorProveedor = isset($row['RFC_PROVEEDOR']) ? trim($row['RFC_PROVEEDOR']) : '';

                        if ($ultimoNombreComercial =='') {//sino está vacío guardamos en memoria el rfc
                                $ultimoNombreComercial = $identificadorProveedor;
                        }

                        if ($identificadorProveedor != $ultimoNombreComercial) {//si el rfc es diferente lo mandamos a ceros
                                                $balance = 0;
                        }

                        if($row['MONTO_DEPOSITADO']!='' or $row['MONTO_DEPOSITADO']<0){//revisamos que MONTO_DEPOSITADO sea mayor a ceros
                                $balance += $row['MONTO_TOTAL_COTIZACION_ADEUDO']-$row['MONTO_DEPOSITADO'];
                        }else{
                                $balance = $balance-$row['MONTO_DEPOSITADO'];
                        }

                        $database->ingresarTemproal($identificadorProveedor,$row['MONTO_TOTAL_COTIZACION_ADEUDO'],$row['MONTO_DEPOSITADO'],$row['idRelacion'],$balance);//guardamos en el segundo temporal

                        $ultimoNombreComercial = $identificadorProveedor;

                }
		
		
		
		
foreach ($datos as $key=>$row){
    $colspan = 0;
    $colspan2 = 0;
    $fondo_existe_xml = "";
    $fondo_existe_xml2 = "";
    $nombreComercialActual = isset($row['NOMBRE_COMERCIAL']) ? trim($row['NOMBRE_COMERCIAL']) : '';
    $identificadorProveedor = $nombreComercialActual !== '' ? $nombreComercialActual : (isset($row['RFC_PROVEEDOR']) ? trim($row['RFC_PROVEEDOR']) : '');
    $nombreComercialMostrar = $nombreComercialActual !== '' ? $nombreComercialActual : $identificadorProveedor;

// 0. Si está AUTORIZADO (AUDITORIA3) → blanco SIEMPRE



// 0. Si está AUTORIZADO (AUDITORIA3) → blanco SIEMPRE

$rowDoc = $database->getDoctos_subefactura($row['02SUBETUFACTURAid']); // 1 fila

$complementoPdf = isset($rowDoc['COMPLEMENTOS_PAGO_PDF']) ? trim((string)$rowDoc['COMPLEMENTOS_PAGO_PDF']) : '';
$complementoXml = isset($rowDoc['COMPLEMENTOS_PAGO_XML']) ? trim((string)$rowDoc['COMPLEMENTOS_PAGO_XML']) : '';

$tieneComplemento = ($complementoPdf !== '' || $complementoXml !== '');

if (
    isset($row['STATUS_AUDITORIA3']) &&
    trim($row['STATUS_AUDITORIA3']) === 'si'
) {
    $fondo_existe_xml  = "style='background-color:#ffffff'";
    $fondo_existe_xml2 = "style='background-color:#ffffff'";
}

// 0.1 TIENE COMPLEMENTO DE PAGO → BLANCO SIEMPRE
else if ($tieneComplemento) {
    $fondo_existe_xml  = "style='background-color:#ffffff'";
    $fondo_existe_xml2 = "style='background-color:#ffffff'";
}

// 1. RECHAZADO → ROJO
else if (
    isset($row['STATUS_DE_PAGO']) &&
    $row['STATUS_DE_PAGO'] === 'RECHAZADO'
) {
    $fondo_existe_xml  = "style='background-color:#ff0000'";
    $fondo_existe_xml2 = "style='background-color:#ff0000'";
}

// 2. ROSADO → SOLO SI NO TIENE COMPLEMENTO
else if (
    !$tieneComplemento &&
    (
        (
            isset($row['metodoDePago']) &&
            trim($row['metodoDePago']) !== '' &&
            strtoupper(trim($row['metodoDePago'])) !== 'PUE'
        )
        ||
        (
            isset($row['PFORMADE_PAGO']) &&
            $row['PFORMADE_PAGO'] !== '03'
        )
    )
) {
    $fondo_existe_xml  = "style='background-color:#ffb6c1'";
    $fondo_existe_xml2 = "style='background-color:#ffb6c1'";
}

// 3. Tiene ClaveUnidadConcepto → BLANCO
else if (!empty($row['ClaveUnidadConcepto'])) {
    $fondo_existe_xml  = "style='background-color:#ffffff'";
    $fondo_existe_xml2 = "style='background-color:#ffffff'";
}

// 4. ClaveUnidadConcepto vacío → AMARILLO
else if (empty($row['ClaveUnidadConcepto'])) {
    $fondo_existe_xml  = "style='background-color:#fdfe87'";
    $fondo_existe_xml2 = "style='background-color:#fdfe87'";
}

// 5. DEFAULT
else {
    $fondo_existe_xml  = "";
    $fondo_existe_xml2 = "";
}
?>



<tr <?php echo $fondo_existe_xml2; ?> >
<td>
    <input type="checkbox" 
           class="checkbox"
           data-id="<?php echo $row['02SUBETUFACTURAid'];?>" 
           style="transform: scale(1.1); cursor: pointer;" 
           onchange="
               const fila = this.closest('tr');
               const id = this.getAttribute('data-id');
               if (this.checked) {
                      fila.style.filter = 'brightness(65%) sepia(100%) saturate(200%) hue-rotate(0deg)';
                   localStorage.setItem('checkbox_' + id, 'checked');
               } else {
                   fila.style.filter = 'none';
                   localStorage.removeItem('checkbox_' + id);
               }">
</td>

    <td <?php echo $fondo_existe_xml; ?>>
        <?php echo $row['02SUBETUFACTURAid']; $colspan += 1; ?>
    </td>

<?php
                                                               
 
	
	$ADJUNTAR_FACTURA_PDF = '';$ADJUNTAR_FACTURA_XML='';$ADJUNTAR_COTIZACION='';$CONPROBANTE_TRANSFERENCIA='';$ADJUNTAR_ARCHIVO_1='';$COMPLEMENTOS_PAGO_PDF='';
   $COMPLEMENTOS_PAGO_XML='';$CANCELACIONES_PDF='';$CANCELACIONES_XML='';$ADJUNTAR_FACTURA_DE_COMISION_PDF='';$ADJUNTAR_FACTURA_DE_COMISION_XML='';$CALCULO_DE_COMISION='';
   $COMPROBANTE_DE_DEVOLUCION='';  $NOTA_DE_CREDITO_COMPRA='';$FOTO_ESTADO_PROVEE11='';$ADJUNTAR_ARCHIVO_1='';
	$querycontrasDOCTOS = $database->Listado_subefacturaDOCTOS($row['02SUBETUFACTURAid']);
	while($rowDOCTOS = mysqli_fetch_array($querycontrasDOCTOS))
	{
			//$ADJUNTAR_FACTURA_PDF = '';				
		if($rowDOCTOS["ADJUNTAR_FACTURA_PDF"]!=''){
			$ADJUNTAR_FACTURA_PDF .= '<a href="includes/archivos/'.$rowDOCTOS["ADJUNTAR_FACTURA_PDF"].'" target ="_blank">Ver!</a><br/>';
		}
		
		if($rowDOCTOS["ADJUNTAR_FACTURA_XML"]!=''){
			$ADJUNTAR_FACTURA_XML .= '<a href="includes/archivos/'.$rowDOCTOS["ADJUNTAR_FACTURA_XML"].'" target ="_blank">Ver!</a><br/>';
		}
		if($rowDOCTOS["ADJUNTAR_COTIZACION"]!=''){
			$ADJUNTAR_COTIZACION .= '<a href="includes/archivos/'.$rowDOCTOS["ADJUNTAR_COTIZACION"].'" target ="_blank">Ver!</a><br/>';
		}
		if($rowDOCTOS["CONPROBANTE_TRANSFERENCIA"]!=''){
			$CONPROBANTE_TRANSFERENCIA .= '<a href="includes/archivos/'.$rowDOCTOS["CONPROBANTE_TRANSFERENCIA"].'" target ="_blank">Ver!</a><br/>';
		}
      if($rowDOCTOS["COMPLEMENTOS_PAGO_PDF"]!=''){
			$COMPLEMENTOS_PAGO_PDF .= '<a href="includes/archivos/'.$rowDOCTOS["COMPLEMENTOS_PAGO_PDF"].'" target ="_blank">Ver!</a><br/>';
		}
      if($rowDOCTOS["COMPLEMENTOS_PAGO_XML"]!=''){
			$COMPLEMENTOS_PAGO_XML .= '<a href="includes/archivos/'.$rowDOCTOS["COMPLEMENTOS_PAGO_XML"].'" target ="_blank">Ver!</a><br/>';
		}
      if($rowDOCTOS["CANCELACIONES_PDF"]!=''){
			$CANCELACIONES_PDF .= '<a href="includes/archivos/'.$rowDOCTOS["CANCELACIONES_PDF"].'" target ="_blank">Ver!</a><br/>';
		}
      if($rowDOCTOS["CANCELACIONES_XML"]!=''){
			$CANCELACIONES_XML .= '<a href="includes/archivos/'.$rowDOCTOS["CANCELACIONES_XML"].'" target ="_blank">Ver!</a><br/>';
		}
      if($rowDOCTOS["ADJUNTAR_FACTURA_DE_COMISION_PDF"]!=''){
			$ADJUNTAR_FACTURA_DE_COMISION_PDF .= '<a href="includes/archivos/'.$rowDOCTOS["ADJUNTAR_FACTURA_DE_COMISION_PDF"].'" target ="_blank">Ver!</a><br/>';
		}
      if($rowDOCTOS["ADJUNTAR_FACTURA_DE_COMISION_XML"]!=''){
			$ADJUNTAR_FACTURA_DE_COMISION_XML .= '<a href="includes/archivos/'.$rowDOCTOS["ADJUNTAR_FACTURA_DE_COMISION_XML"].'" target ="_blank">Ver!</a><br/>';
		}
      if($rowDOCTOS["CALCULO_DE_COMISION"]!=''){
			$CALCULO_DE_COMISION .= '<a href="includes/archivos/'.$rowDOCTOS["CALCULO_DE_COMISION"].'" target ="_blank">Ver!</a><br/>';
		}
      if($rowDOCTOS["COMPROBANTE_DE_DEVOLUCION"]!=''){
			$COMPROBANTE_DE_DEVOLUCION .= '<a href="includes/archivos/'.$rowDOCTOS["COMPROBANTE_DE_DEVOLUCION"].'" target ="_blank">Ver!</a><br/>';
		}
      if($rowDOCTOS["NOTA_DE_CREDITO_COMPRA"]!=''){
			$NOTA_DE_CREDITO_COMPRA .= '<a href="includes/archivos/'.$rowDOCTOS["NOTA_DE_CREDITO_COMPRA"].'" target ="_blank">Ver!</a><br/>';
		}
      if($rowDOCTOS["FOTO_ESTADO_PROVEE11"]!=''){
			$FOTO_ESTADO_PROVEE11 .= '<a href="includes/archivos/'.$rowDOCTOS["FOTO_ESTADO_PROVEE11"].'" target ="_blank">Ver!</a><br/>';
		}
	
		if($rowDOCTOS["ADJUNTAR_ARCHIVO_1"]!=''){
			$ADJUNTAR_ARCHIVO_1 .= '<a href="includes/archivos/'.$rowDOCTOS["ADJUNTAR_ARCHIVO_1"].'" target ="_blank">Ver!</a><br/>';
		}

	}



?>



<td style="text-align:center; background:#ceffcc">

<input type="checkbox" style="width:30PX;" checked="checked" disabled = "disabled" class="form-check-input" id="STATUS_RESPONSABLE_EVENTO<?php echo $row["02SUBETUFACTURAid"]; ?>"  name="STATUS_RESPONSABLE_EVENTO<?php echo $row["02SUBETUFACTURAid"]; ?>" value="<?php echo $row["02SUBETUFACTURAid"]; ?>" onclick="STATUS_RESPONSABLE_EVENTO(<?php echo $row["02SUBETUFACTURAid"]; ?>)" <?php if($row["STATUS_RESPONSABLE_EVENTO"]=='si'){
	echo "checked";
}
$colspan += 1; ?>/>
</td>


<td style="text-align:center; background:<?php echo ($row["STATUS_VENTAS"] == 'si') ? '#ceffcc' : '#e9d8ee'; ?>;" 
    id="color_VENTAS<?php echo $row["02SUBETUFACTURAid"]; ?>" >

    <input type="checkbox"
        style="width:30px;"
        class="form-check-input"
        id="STATUS_VENTAS<?php echo $row["02SUBETUFACTURAid"]; ?>"
        name="STATUS_VENTAS<?php echo $row["02SUBETUFACTURAid"]; ?>"
        value="<?php echo $row["02SUBETUFACTURAid"]; ?>"
        onclick="STATUS_VENTAS(<?php echo $row["02SUBETUFACTURAid"]; ?>)"
       <?php
$atributosVentas = [];

// 1) Bloqueo total si ya está en "si"
if ($row["STATUS_VENTAS"] === 'si') {
    $atributosVentas[] = 'checked';
    $atributosVentas[] = 'disabled';
} else {
    // 2) Si NO está en "si", aquí decides si se puede marcar o no (permiso)
    $numeroEventoRegistro = isset($row["NUMERO_EVENTO"]) ? strtoupper(trim((string)$row["NUMERO_EVENTO"])) : '';
    $tienePermisoVenta = $numeroEventoRegistro !== '' && isset($eventosAutorizadosVentas[$numeroEventoRegistro]);

    if (!$tienePermisoVenta) {
        $atributosVentas[] = 'disabled';
    }
}

echo implode(' ', $atributosVentas);
?>
    />
    <?php $colspan += 1; ?>

</td>



<td style="text-align:center; background:
    <?php
    if ($row["STATUS_DE_PAGO"] == 'APROBADO') {
        echo '#ceffcc'; // verde claro para aprobado
    } elseif ($row["STATUS_DE_PAGO"] == 'PAGADO') {
        echo '#ceffcc'; // verde más intenso para pagado
    } else {
        echo '#e9d8ee'; // lila claro para pendiente
    }
    ?>" 
    id="color_pagado1a<?php echo $row["02SUBETUFACTURAid"]; ?>">

    <input type="checkbox" style="width:30PX;" class="form-check-input"
           id="STATUS_AUDITORIA1<?php echo $row["02SUBETUFACTURAid"]; ?>"
           name="STATUS_AUDITORIA1<?php echo $row["02SUBETUFACTURAid"]; ?>"
           value="<?php echo $row["02SUBETUFACTURAid"]; ?>"
           <?php
           $permisoVerAUDITORIA1       = $database->variablespermisos('', 'AUDITORIA1', 'ver') == 'si';
           $permisoModificarAUDITORIA1 = $database->variablespermisos('', 'AUDITORIA1', 'modificar') == 'si';

           // Condición de estatus
           if ($row["STATUS_DE_PAGO"] == 'APROBADO' || $row["STATUS_DE_PAGO"] == 'PAGADO') {
               echo $permisoModificarAUDITORIA1
                   ? 'checked onclick="STATUS_AUDITORIA1('.$row["02SUBETUFACTURAid"].')"'
                   : 'checked disabled';
           } else {
               // Validación de permisoS
               if ($permisoVerAUDITORIA1) {
                   echo 'onclick="STATUS_AUDITORIA1('.$row["02SUBETUFACTURAid"].')"';
               } else {
                   echo 'disabled';
               }
           }
           ?>
    />
</td>



<td style="text-align:center; background:

    <?php echo ($row["STATUS_FINANZAS"] == 'si') ? '#ceffcc' : '#e9d8ee'; ?>;" 
    id="color_FINANZAS<?php echo $row["02SUBETUFACTURAid"]; ?>">

    <input type="checkbox" 
        style="width:30px;" 
        class="form-check-input" 
        id="STATUS_FINANZAS<?php echo $row["02SUBETUFACTURAid"]; ?>"  
        name="STATUS_FINANZAS<?php echo $row["02SUBETUFACTURAid"]; ?>" 
        value="<?php echo $row["02SUBETUFACTURAid"]; ?>"
       <?php
        $permisoVerFINANZAS       = $database->variablespermisos('', 'DIRECCION1', 'ver') == 'si';
        $permisoModificarFINANZAS = $database->variablespermisos('', 'DIRECCION1', 'modificar') == 'si';

        if ($row["STATUS_FINANZAS"] == 'si') {
            // Ya autorizado → marcado y bloqueado salvo que exista permiso de modificación
            echo $permisoModificarFINANZAS
                ? 'checked onclick="STATUS_FINANZAS('.$row["02SUBETUFACTURAid"].')"'
                : 'checked disabled style="cursor:not-allowed;" title="Sin permiso para modificar"';
        } else {
            // Validar permiso antes de habilitar
            if($permisoVerFINANZAS){
                echo 'onclick="STATUS_FINANZAS('.$row["02SUBETUFACTURAid"].')"';
            } else {
                // Sin permiso → deshabilitado y con aviso
                echo 'disabled style="cursor:not-allowed;" title="Sin permiso para modificar"';
            }
        }
        ?>
    />
    <?php $colspan += 1; ?>
</td>


<td style="text-align:center; background:
    <?php echo ($row["STATUS_DE_PAGO"] == 'PAGADO') ? '#ceffcc' : '#e9d8ee'; ?>;" 
    id="color_pagado1a<?php echo $row["02SUBETUFACTURAid"]; ?>">

    <input type="checkbox"
        style="width:30px;"
        class="form-check-input"
        id="pasarpagado1a<?php echo $row["02SUBETUFACTURAid"]; ?>"
        name="pasarpagado1a<?php echo $row["02SUBETUFACTURAid"]; ?>"
        value="<?php echo $row["02SUBETUFACTURAid"]; ?>"
        <?php
            $permisoVerFINANZAS       = $database->variablespermisos('', 'FINANZAS', 'ver') == 'si';
            $permisoModificarFINANZAS = $database->variablespermisos('', 'FINANZAS', 'modificar') == 'si';

            if ($row["STATUS_DE_PAGO"] == 'PAGADO') {
                echo $permisoModificarFINANZAS
                    ? 'checked onclick="pasarpagado2('.$row["02SUBETUFACTURAid"].')"'
                    : 'checked disabled style="cursor:not-allowed;" title="Ya está pagado"';
            } else {
                if($permisoVerFINANZAS){
                    echo 'onclick="pasarpagado2('.$row["02SUBETUFACTURAid"].')"';
                } else {
                    // Sin permiso → bloqueado y con aviso
                    echo 'disabled style="cursor:not-allowed;" title="Sin permiso para modificar"';
                }
            }
        ?>
    />
    <?php $colspan += 1; ?>

</td>



<td style="text-align:center; background:
    <?php echo ($row["STATUS_AUDITORIA2"] == 'si') ? '#ceffcc' : '#e9d8ee'; ?>;" 
    id="color_AUDITORIA2<?php echo $row["02SUBETUFACTURAid"]; ?>">

    <input type="checkbox"
        style="width:30px; cursor:pointer;"
        class="form-check-input"
        id="STATUS_AUDITORIA2<?php echo $row["02SUBETUFACTURAid"]; ?>"
        name="STATUS_AUDITORIA2<?php echo $row["02SUBETUFACTURAid"]; ?>"
        value="<?php echo $row["02SUBETUFACTURAid"]; ?>"
        <?php
        $permisoVerAUDITORIA2       = $database->variablespermisos('', 'AUDITORIA2', 'ver') == 'si';
        $permisoModificarAUDITORIA2 = $database->variablespermisos('', 'AUDITORIA2', 'modificar') == 'si';

        if ($row["STATUS_AUDITORIA2"] == 'si') {
            // Ya autorizado → marcado y bloqueado salvo permiso de modificación
            echo $permisoModificarAUDITORIA2
                ? 'checked onclick="STATUS_AUDITORIA2('.$row["02SUBETUFACTURAid"].')"'
                : 'checked disabled style="cursor:not-allowed;" title="Ya autorizado"';
        } else {
            if($permisoVerAUDITORIA2){
                // Permitir acción → al marcar se llama a tu función y se bloquea el checkbox
                echo 'onclick="STATUS_AUDITORIA2('.$row["02SUBETUFACTURAid"].'); this.disabled=true; this.style.cursor=\'not-allowed\';"';
            } else {
                // Sin permiso → bloqueado
                echo 'disabled style="cursor:not-allowed;" title="Sin permiso para modificar"';
            }
        }
        ?>
    />
    <?php $colspan += 1; ?>

</td>





<?php  if($database->plantilla_filtro($nombreTabla,"ADJUNTAR_FACTURA_XML",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php $colspan += 1; echo $ADJUNTAR_FACTURA_XML; ?></td>
<?php } ?>
<?php  if($database->plantilla_filtro($nombreTabla,"ADJUNTAR_FACTURA_PDF",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php $colspan += 1; echo $ADJUNTAR_FACTURA_PDF; ?></td>
<?php } ?>
<?php  if($database->plantilla_filtro($nombreTabla,"NUMERO_CONSECUTIVO_PROVEE",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php $colspan += 1; echo $row['NUMERO_CONSECUTIVO_PROVEE'];?></td>
<?php } ?>

<?php  if($database->plantilla_filtro($nombreTabla,"VIATICOSOPRO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php $colspan += 1; echo $row['VIATICOSOPRO'];?></td>
<?php } ?>
<?php  if($database->plantilla_filtro($nombreTabla,"NOMBRE_COMERCIAL",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php $colspan += 1; echo $nombreComercialMostrar;?></td>
<?php } ?>


<?php  if($database->plantilla_filtro($nombreTabla,"RAZON_SOCIAL",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center;"> 
    <a href="PROVEEDORES.php?idPROV=<?php echo urlencode($database->obtener_rfc_a_id($row['RAZON_SOCIAL'], $nombreComercialMostrar)); ?>"target="_blank">
        <?php $colspan += 1; echo $row['RAZON_SOCIAL']; ?>

    </a>

</td>

<?php } ?>




<?php  if($database->plantilla_filtro($nombreTabla,"RFC_PROVEEDOR",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php $colspan += 1; echo $row['RFC_PROVEEDOR'];?></td>
<?php } ?>


<?php  if($database->plantilla_filtro($nombreTabla,"NUMERO_EVENTO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center;"> 
    <a href="calendarioDEeventos2.php?idevento=<?php echo urlencode($database->iralevento($row['NUMERO_EVENTO'])); ?>"target="_blank">
        <?php $colspan += 1; echo $row['NUMERO_EVENTO']; ?>
    </a>
</td>
<?php } ?>



<?php  if($database->plantilla_filtro($nombreTabla,"NOMBRE_EVENTO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php $colspan += 1; echo $row['NOMBRE_EVENTO'];?></td>
<?php } ?>
<?php  
if ($database->plantilla_filtro($nombreTabla,"FECHA_INICIO_EVENTO",$altaeventos,$DEPARTAMENTO)=="si") {
    $colspan += 1;

    $fecha = isset($row['FECHA_INICIO_EVENTO']) ? trim($row['FECHA_INICIO_EVENTO']) : '';
    if ($fecha !== '' && $fecha !== '0000-00-00') {
        echo "<td style='text-align:center'>".date('d/m/Y', strtotime($fecha))."</td>";
    } else {
        echo "<td style='text-align:center'></td>";
    }
}
?>

<?php  
if ($database->plantilla_filtro($nombreTabla,"FECHA_FINAL_EVENTO",$altaeventos,$DEPARTAMENTO)=="si") {
    $colspan += 1;

    $fecha2 = isset($row['FECHA_FINAL_EVENTO']) ? trim($row['FECHA_FINAL_EVENTO']) : '';
    if ($fecha2 !== '' && $fecha2 !== '0000-00-00') {
        echo "<td style='text-align:center'>".date('d/m/Y', strtotime($fecha2))."</td>";
    } else {
        echo "<td style='text-align:center'></td>";
    }
}
?>




<?php  if($database->plantilla_filtro($nombreTabla,"MOTIVO_GASTO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php $colspan += 1; echo $row['MOTIVO_GASTO'];?></td>
<?php } ?>
<?php  if($database->plantilla_filtro($nombreTabla,"CONCEPTO_PROVEE",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php $colspan += 1; echo $row['CONCEPTO_PROVEE'];?></td>
<?php } ?>



<?php $colspan2 = $colspan; ?>

<?php  if($database->plantilla_filtro($nombreTabla,"MONTO_TOTAL_COTIZACION_ADEUDO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php 
		$totales = 'si';
echo  number_format($row['MONTO_TOTAL_COTIZACION_ADEUDO'],2,'.',',');
$MONTO_TOTAL_COTIZACION_ADEUDO12 += $row['MONTO_TOTAL_COTIZACION_ADEUDO'];

 $colspan2 += 1;

?></td>
<?php } ?>


<?php  if($database->plantilla_filtro($nombreTabla,"MONTO_FACTURA",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php
		$totales = 'si';
echo number_format($row['MONTO_FACTURA'],2,'.',',');
$MONTO_FACTURA12 += $row['MONTO_FACTURA'];
 $colspan2 += 1;
?></td>
<?php } ?>

<?php  if($database->plantilla_filtro($nombreTabla,"IVA",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php
		$totales = 'si';
echo number_format($row['IVA'],2,'.',',');
$IVA12 += $row['IVA'];
 $colspan2 += 1;
?></td>
<?php } ?>

<?php  if($database->plantilla_filtro($nombreTabla,"TImpuestosRetenidosIVA",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php
		$totales = 'si';
echo number_format($row['TImpuestosRetenidosIVA'],2,'.',',');
$TImpuestosRetenidosIVA12 += $row['TImpuestosRetenidosIVA'];
 $colspan2 += 1;
?></td>
<?php } ?>

<?php  if($database->plantilla_filtro($nombreTabla,"TImpuestosRetenidosISR",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php
		$totales = 'si';
echo number_format($row['TImpuestosRetenidosISR'],2,'.',',');
$TImpuestosRetenidosISR12 += $row['TImpuestosRetenidosISR'];
 $colspan2 += 1;
?></td>
<?php } ?>


<?php  if($database->plantilla_filtro($nombreTabla,"MONTO_PROPINA",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php
		$totales = 'si';
echo number_format($row['MONTO_PROPINA'],2,'.',',');
$MONTO_PROPINA12 += $row['MONTO_PROPINA'];
 $colspan2 += 1;
 ?></td>
<?php } ?>

<?php  if($database->plantilla_filtro($nombreTabla,"IMPUESTO_HOSPEDAJE",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center">$<?php 
echo  number_format($row['IMPUESTO_HOSPEDAJE'],2,'.',',');
		$totales = 'si';
		$IMPUESTO_HOSPEDAJE12 += $row['IMPUESTO_HOSPEDAJE'];
		$colspan2 += 1;
		
		$supropinamashospedaje = $row['MONTO_PROPINA'] + $row['IMPUESTO_HOSPEDAJE'];
		
		
?></td>
<?php } ?>

<?php  if($database->plantilla_filtro($nombreTabla,"descuentos",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php
		$totales = 'si';
echo number_format($row['descuentos'],2,'.',',');
$descuentos12 += $row['descuentos'];
 $colspan2 += 1;
?></td>
<?php } ?>



<?php  if($database->plantilla_filtro($nombreTabla,"MONTO_DEPOSITAR",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php
		$totales = 'si';
echo number_format($row['MONTO_DEPOSITAR'],2,'.',',');
$MONTO_DEPOSITAR12 += $row['MONTO_DEPOSITAR'];
 $colspan2 += 1;
?></td>
<?php } ?>

<?php  if($database->plantilla_filtro($nombreTabla,"MONTO_DEPOSITADO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php 
		$totales = 'si';
		
echo number_format($row['MONTO_DEPOSITADO'],2,'.',',');


$idrelacion['idrelacion'][$row['02SUBETUFACTURAid']]=$row['02SUBETUFACTURAid'];
$idactual = $row['02SUBETUFACTURAid'];
$gran_total = $database->getTotalAmaunt2($identificadorProveedor);
$gran_totalid = $database->getTotalAmaunt2id($identificadorProveedor,$idrelacion,$idactual);
$gran_total2 = $gran_totalid + $gran_total;

$MONTO_DEPOSITADO12 += $row['MONTO_DEPOSITADO'];

 $colspan2 += 1;

?></td>

<?php }



$resultadoEstadoCuenta = $database->resultadoTemproal($idactual,$identificadorProveedor);
 if($database->plantilla_filtro($nombreTabla,"PENDIENTE_PAGO",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<td style="text-align:center"><?php
                $totales = 'si';



 if (!in_array($row['VIATICOSOPRO'], [
     'VIATICOS',
     'REEMBOLSO',
     'PAGO A PROVEEDOR CON DOS O MAS FACTURAS'
 ])) {
     echo number_format((float)$resultadoEstadoCuenta, 2, '.', ',');
     $PENDIENTE_PAGO12 += $gran_total2;
 }
 $colspan2 += 1;
?></td>
<?php } ?>


<?php  if($database->plantilla_filtro($nombreTabla,"TIPO_DE_MONEDA",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php echo $row['TIPO_DE_MONEDA'];
 $colspan2 += 1;
?></td>
<?php } ?>

<?php  if($database->plantilla_filtro($nombreTabla,"TIPO_CAMBIOP",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center">$<?php 
echo  number_format($row['TIPO_CAMBIOP'],2,'.',',');
		$totales = 'si';
		$TIPO_CAMBIOP12 += $row['TIPO_CAMBIOP'];
		$colspan2 += 1;
?></td>
<?php } ?>
<?php  if($database->plantilla_filtro($nombreTabla,"TOTAL_ENPESOS",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center">$<?php 
echo  number_format($row['TOTAL_ENPESOS'],2,'.',',');
		$totales = 'si';
		$TOTAL_ENPESOS12 += $row['TOTAL_ENPESOS'];
		$colspan2 += 1;
?></td>
<?php } ?>


<?php  if($database->plantilla_filtro($nombreTabla,"PFORMADE_PAGO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php echo $row['PFORMADE_PAGO'];
 $colspan2 += 1;
 ?></td>
<?php } ?>
<?php  if($database->plantilla_filtro($nombreTabla,"FECHA_DE_PAGO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php echo $row['FECHA_DE_PAGO'];
 $colspan2 += 1;
 ?></td>
<?php } ?>
<?php  if($database->plantilla_filtro($nombreTabla,"FECHA_A_DEPOSITAR",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php echo $row['FECHA_A_DEPOSITAR'];
 $colspan2 += 1;
 ?></td>
<?php } ?>
<?php  if($database->plantilla_filtro($nombreTabla,"STATUS_DE_PAGO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php echo $row['STATUS_DE_PAGO'];
 $colspan2 += 1;
 ?></td>
<?php } ?>
<?php  if($database->plantilla_filtro($nombreTabla,"ADJUNTAR_COTIZACION",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php echo $ADJUNTAR_COTIZACION; 
 $colspan2 += 1;
 ?></td>
<?php } ?>
<?php  if($database->plantilla_filtro($nombreTabla,"CONPROBANTE_TRANSFERENCIA",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php echo $CONPROBANTE_TRANSFERENCIA; 
 $colspan2 += 1;
 ?></td>
<?php } ?>
<?php  if($database->plantilla_filtro($nombreTabla,"ACTIVO_FIJO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php echo $row['ACTIVO_FIJO'];
 $colspan2 += 1;
 ?></td>
<?php } ?>
<?php  if($database->plantilla_filtro($nombreTabla,"GASTO_FIJO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php echo $row['GASTO_FIJO'];
 $colspan2 += 1;
 ?></td>
<?php } ?>
<?php  if($database->plantilla_filtro($nombreTabla,"PAGAR_CADA",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php echo $row['PAGAR_CADA'];
 $colspan2 += 1;
 ?></td>
<?php } ?>
<?php  if($database->plantilla_filtro($nombreTabla,"FECHA_PPAGO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php echo $row['FECHA_PPAGO'];
 $colspan2 += 1;
 ?></td>
<?php } ?>
<?php  if($database->plantilla_filtro($nombreTabla,"FECHA_TPROGRAPAGO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php echo $row['FECHA_TPROGRAPAGO'];
 $colspan2 += 1;
 ?></td>
<?php } ?>
<?php  if($database->plantilla_filtro($nombreTabla,"NUMERO_EVENTOFIJO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php echo $row['NUMERO_EVENTOFIJO'];
 $colspan2 += 1;
 ?></td>
<?php } ?>
<?php  if($database->plantilla_filtro($nombreTabla,"CLASI_GENERAL",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php echo $row['CLASI_GENERAL'];
 $colspan2 += 1;
 ?></td>
<?php } ?>
<?php  if($database->plantilla_filtro($nombreTabla,"SUB_GENERAL",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php echo $row['SUB_GENERAL'];
 $colspan2 += 1;
 ?></td>
<?php } ?>
<?php  if($database->plantilla_filtro($nombreTabla,"NUMERO_EVENTO1",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php echo $row['NUMERO_EVENTO1'];
 $colspan2 += 1;
 ?></td>
<?php } ?>
<?php  if($database->plantilla_filtro($nombreTabla,"CLASIFICACION_GENERAL",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php echo $row['CLASIFICACION_GENERAL'];
 $colspan2 += 1;
 ?></td>
<?php } ?>
<?php  if($database->plantilla_filtro($nombreTabla,"CLASIFICACION_ESPECIFICA",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php echo $row['CLASIFICACION_ESPECIFICA'];
 $colspan2 += 1;
 ?></td>
<?php } ?>
<?php  if($database->plantilla_filtro($nombreTabla,"PLACAS_VEHICULO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php echo $row['PLACAS_VEHICULO'];
 $colspan2 += 1;
 ?></td>
<?php } ?>
<?php  if($database->plantilla_filtro($nombreTabla,"COMPLEMENTOS_PAGO_PDF",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php echo $COMPLEMENTOS_PAGO_PDF;
 $colspan2 += 1;
 ?></td>
<?php } ?>
<?php  if($database->plantilla_filtro($nombreTabla,"COMPLEMENTOS_PAGO_XML",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php echo $COMPLEMENTOS_PAGO_XML;
 $colspan2 += 1;
 ?></td>
<?php } ?>
<?php  if($database->plantilla_filtro($nombreTabla,"CANCELACIONES_PDF",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php echo $CANCELACIONES_PDF;
 $colspan2 += 1;
 ?></td>
<?php } ?>
<?php  if($database->plantilla_filtro($nombreTabla,"CANCELACIONES_XML",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php echo $CANCELACIONES_XML;
 $colspan2 += 1;
 ?></td>
<?php } ?>
<?php  if($database->plantilla_filtro($nombreTabla,"ADJUNTAR_FACTURA_DE_COMISION_PDF",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php echo $ADJUNTAR_FACTURA_DE_COMISION_PDF;
 $colspan2 += 1;
 ?></td>
<?php } ?>
<?php  if($database->plantilla_filtro($nombreTabla,"ADJUNTAR_FACTURA_DE_COMISION_XML",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php echo $ADJUNTAR_FACTURA_DE_COMISION_XML;
 $colspan2 += 1;
 ?></td>
<?php } ?>
<?php  if($database->plantilla_filtro($nombreTabla,"CALCULO_DE_COMISION",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php echo $CALCULO_DE_COMISION;
 $colspan2 += 1;
 ?></td>
<?php } ?>
<?php  if($database->plantilla_filtro($nombreTabla,"MONTO_DE_COMISION",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php echo $row['MONTO_DE_COMISION'];
 $colspan2 += 1;
 ?></td>
<?php } ?>


<?php  if($database->plantilla_filtro($nombreTabla,"COMPROBANTE_DE_DEVOLUCION",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php echo $COMPROBANTE_DE_DEVOLUCION;
 $colspan2 += 1;
 ?></td>
<?php } ?>


<?php  if($database->plantilla_filtro($nombreTabla,"NOTA_DE_CREDITO_COMPRA",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php echo $NOTA_DE_CREDITO_COMPRA;
 $colspan2 += 1;
 ?></td>
<?php } ?>
<?php  if($database->plantilla_filtro($nombreTabla,"POLIZA_NUMERO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php echo $row['POLIZA_NUMERO'];
 $colspan2 += 1; 
 ?></td>
<?php } ?>
<?php  if($database->plantilla_filtro($nombreTabla,"NOMBRE_DEL_EJECUTIVO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php echo $row['NOMBRE_DEL_EJECUTIVO'];
 $colspan2 += 1;
 ?></td>
<?php } ?>
<?php  if($database->plantilla_filtro($nombreTabla,"NOMBRE_DEL_AYUDO",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php echo $row['NOMBRE_DEL_AYUDO'];
 $colspan2 += 1;
 ?></td>
<?php } ?>



<?php  if($database->plantilla_filtro($nombreTabla,"OBSERVACIONES_1",$altaeventos,$DEPARTAMENTO)=="si"){ ?>

<td style="
    text-align:left;

    width:700px;

    min-width:700px;

    max-width:700px;

">



    <div style="width:700px; min-width:700px; max-width:700px; white-space:normal; word-break:break-word;">

        <?php echo htmlspecialchars($row['OBSERVACIONES_1']); ?>

    </div>

</td>
<?php } ?>

<?php  if($database->plantilla_filtro($nombreTabla,"ADJUNTAR_ARCHIVO_1",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php echo $ADJUNTAR_ARCHIVO_1;
 $colspan2 += 1;
 ?></td>
<?php } ?>

<?php  
if ($database->plantilla_filtro($nombreTabla,"FECHA_DE_LLENADO",$altaeventos,$DEPARTAMENTO)=="si") {

    $fechaHora = $row['FECHA_DE_LLENADO'];
    $fecha = date('d-m-Y', strtotime($fechaHora));
    $hora  = date('H:i:s', strtotime($fechaHora));
?>
<td style="text-align:center">
    <?php echo $fecha; ?>
    <span style="color:#2542C4; font-weight:bold;">
        <?php echo $hora; ?>
    </span>
</td>
<?php 
    $colspan2 += 1;
} 
?>





<?php 

$id_relacion_bancario = $database->datos_bancarios_xml($row['RFC_PROVEEDOR'], null, $row['NOMBRE_COMERCIAL']);
$mostrarXML = ($row['STATUS_SINXML'] !== 'si');

if($database->plantilla_filtro($nombreTabla,"CSF",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<td style="text-align:center">
<?php
echo $database->DOCUMENTOSFISCALES_PAGOA($id_relacion_bancario,'CONSTANCIA DE SITUACIÓN FISCAL',' CONSTANCIA DE SITUACIÓN FISCAL');
	 $colspan2 += 1;
?>
</td>
<?php } ?>


<?php 

$id_relacion_bancario = $database->datos_bancarios_xml($row['RFC_PROVEEDOR'], null, $row['NOMBRE_COMERCIAL']);
if($database->plantilla_filtro($nombreTabla,"OPINION_CUMPLIMIENTO",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<td style="text-align:center">
<?php
echo $database->DOCUMENTOSFISCALES_PAGOA($id_relacion_bancario,'OPINIÓN DE CUMPLIMIENTO');
	 $colspan2 += 1;
?>
</td>
<?php } ?>







<?php  if($database->plantilla_filtro($nombreTabla,"NOMBRE_RECEPTOR",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
    <td style="text-align:center"><?php
        echo $mostrarXML ? $row['nombreR'] : '';
        $colspan2 += 1;
         ?></td>
<?php } ?>
<?php  if($database->plantilla_filtro($nombreTabla,"RFC_RECEPTOR",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
    <td style="text-align:center"><?php
        echo $mostrarXML ? $row['rfcR'] : '';
         $colspan2 += 1;
         ?></td>
<?php } ?>
<?php  if($database->plantilla_filtro($nombreTabla,"REGIMEN_FISCAL",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
    <td style="text-align:center"><?php
        echo $mostrarXML ? $row['regimenE'] : '';
         $colspan2 += 1;
         ?></td>
<?php } ?>
<?php  if($database->plantilla_filtro($nombreTabla,"UUID",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
    <td style="text-align:center"><?php
        echo $mostrarXML ? $row['UUID'] : '';
         $colspan2 += 1;
         ?></td>
<?php } ?>
<?php  if($database->plantilla_filtro($nombreTabla,"FOLIO",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
    <td style="text-align:center"><?php  echo $mostrarXML ? $row['folio'] : '';
         $colspan2 += 1;
         ?></td>
<?php } ?>
<?php  if($database->plantilla_filtro($nombreTabla,"SERIE",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
    <td style="text-align:center"><?php echo $mostrarXML ? $row['serie'] : '';
         $colspan2 += 1;
         ?></td>
<?php } ?>




<?php  if($database->plantilla_filtro($nombreTabla,"CLAVE_UNIDAD",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
    <td style="text-align:center"><?php echo $mostrarXML ? $row['ClaveUnidadConcepto'] : '';
         $colspan2 += 1;
         ?></td>
<?php } ?>




<?php  if($database->plantilla_filtro($nombreTabla,"CANTIDAD",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
    <td style="text-align:center"><?php echo $mostrarXML ? number_format($row['CantidadConcepto'],2,'.',',') : '';
         $colspan2 += 1;
         ?></td>
<?php } ?>




<?php  if($database->plantilla_filtro($nombreTabla,"CLAVE_PODUCTO",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
    <td style="text-align:center"><?php echo $mostrarXML ? $row['ClaveProdServConcepto'] : '';
         $colspan2 += 1;
         ?></td>
<?php } ?>




<?php  if($database->plantilla_filtro($nombreTabla,"DESCRIPCION",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
    <td style="text-align:center"><?php echo $mostrarXML ? ''. $row['DescripcionConcepto'] : '';
 $colspan2 += 1;
 ?></td>
<?php } ?>




<?php  if($database->plantilla_filtro($nombreTabla,"MonedaF",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
    <td style="text-align:center"><?php echo $mostrarXML ? $row['Moneda'] : ''; $colspan2 += 1;?></td>
<?php } ?>

<?php  if($database->plantilla_filtro($nombreTabla,"TIPO_CAMBIO",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
    <td style="text-align:center"><?php echo $mostrarXML ? number_format($row['TipoCambio'],2,'.',',') : ''; $colspan2 += 1;?></td>
<?php } ?>

<?php  if($database->plantilla_filtro($nombreTabla,"USO_CFDI",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
    <td style="text-align:center"><?php echo $mostrarXML ? $row['UsoCFDI'] : ''; $colspan2 += 1;?></td>
<?php } ?>
<?php  if($database->plantilla_filtro($nombreTabla,"metodoDePago",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
    <td style="text-align:center"><?php  echo $mostrarXML ? $row['metodoDePago'] : ''; $colspan2 += 1;?></td>
<?php } ?>
<?php  if($database->plantilla_filtro($nombreTabla,"CONDICIONES_PAGO",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
    <td style="text-align:center"><?php  echo $mostrarXML ? $row['condicionesDePago'] : ''; $colspan2 += 1;?></td>
<?php } ?>
<?php  if($database->plantilla_filtro($nombreTabla,"TIPO_COMPROBANTE",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
    <td style="text-align:center"><?php echo $mostrarXML ? $row['tipoDeComprobante'] : ''; $colspan2 += 1;?></td>
<?php } ?>
<?php  if($database->plantilla_filtro($nombreTabla,"VERSION",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
    <td style="text-align:center"><?php echo $mostrarXML ? $row['Version'] : ''; $colspan2 += 1;?></td>
<?php } ?>

<?php  if($database->plantilla_filtro($nombreTabla,"FECHA_TIMBRADO",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
    <td style="text-align:center"><?php echo $mostrarXML ? $row['fechaTimbrado'] : ''; $colspan2 += 1;?></td>
<?php } ?>






<?php  if($database->plantilla_filtro($nombreTabla,"subTotal",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
    <td style="text-align:center">$<?php 


if ($mostrarXML) {
    $subTotal123 = isset($row['subTotal'])?$row['subTotal']:'' ;
    $MONTO_FACTURA123 = isset($row['MONTO_FACTURA'])?$row['MONTO_FACTURA']:'' ;

    if ($subTotal123 > 0) {
        $MONTO_FACTURAxm = number_format($subTotal123, 2, '.', ',');
        $MONTO_FACTURAxm2 = ($subTotal123);
      
    } ELSE{

        $MONTO_FACTURAxm = number_format($MONTO_FACTURA123, 2, '.', ',');
        $MONTO_FACTURAxm2 = ($MONTO_FACTURA123);
    } 

    $subTotal12 +=$MONTO_FACTURAxm2;
    echo $MONTO_FACTURAxm;

        
        $totales2 = 'si';
}
        
    
    ?></td>
<?php } ?>






<?php  if($database->plantilla_filtro($nombreTabla,"propina",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
    <td style="text-align:center"><?php 
    if ($mostrarXML) {
        echo number_format($row['propina'] + $supropinamashospedaje ,2,'.',',');
        $propina12 += $row['propina']+ $supropinamashospedaje ;
        $totales2 = 'si';
    }
     ?></td>
<?php } ?> 

<?php  if($database->plantilla_filtro($nombreTabla,"Descuento",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
    <td style="text-align:center"><?php 
    if ($mostrarXML) {
        echo number_format($row['Descuento'],2,'.',',');
        $Descuento12 += $row['Descuento'];
        $totales2 = 'si';
    }
     ?></td>
<?php } ?>

<?php  if($database->plantilla_filtro($nombreTabla,"TOTAL_IMPUESTOS_TRASLADADOS",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
    <td style="text-align:center">$<?php 


if ($mostrarXML) {
    $TImpuestosTrasladados123 = isset($row['TImpuestosTrasladados'])?$row['TImpuestosTrasladados']:'' ;
    $IVA123 = isset($row['IVA'])?$row['IVA']:'' ;

    if ($TImpuestosTrasladados123 > 0) {
        $IVAXML = number_format($TImpuestosTrasladados123, 2, '.', ',');
        $IVAXML2 = ($TImpuestosTrasladados123);
      
    } ELSE{

        $IVAXML = number_format($IVA123, 2, '.', ',');
        $IVAXML2 = ($IVA123);
    } 

    $IVAXMLGTOTAL2 +=$IVAXML2;
    echo $IVAXML;
        
        
        $totales2 = 'si';
}
        
    
    ?></td>
<?php } ?>






<?php  if($database->plantilla_filtro($nombreTabla,"TOTAL_IMPUESTOS_RETENIDOS",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
    <td style="text-align:center"><?php
    if ($mostrarXML) {
        echo number_format($row['TImpuestosRetenidos'],2,'.',',');
        $TImpuestosRetenidos12 += $row['TImpuestosRetenidos'];
        $totales2 = 'si';
    }
    ?></td>
<?php } ?>




<?php  if($database->plantilla_filtro($nombreTabla,"TUA",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
    <td style="text-align:center"><?php echo  $mostrarXML ? number_format($row['TUA'],2,'.',',') : '';
    if ($mostrarXML) {
        $TUA12 += $row['TUA'];
        $totales2 = 'si';
    }
    ?></td>
<?php } ?>




<?php  if($database->plantilla_filtro($nombreTabla,"total",$altaeventos,$DEPARTAMENTO)=="si"){  ?>
   <td style="text-align:center" id="montoOriginal_<?php echo $row['02SUBETUFACTURAid']; ?>"><?php 

if ($mostrarXML) {
    $total123 = isset($row['totalf'])?$row['totalf']:'' ;
    $MONTO_DEPOSITAR123 = isset($row['MONTO_DEPOSITAR'])?$row['MONTO_DEPOSITAR']:'' ;

    if ($total123 > 0) {
        $porfalta = number_format($total123, 2, '.', ',');
        $porfalta2 = ($total123);
        
    } ELSE{

        $porfalta = number_format($MONTO_DEPOSITAR123, 2, '.', ',');
        $porfalta2 = ($MONTO_DEPOSITAR123);
    } 

    $totalf12  +=$porfalta2;
    echo $porfalta;
        
        
    $totales2 = 'si';
} else {
    $porfalta = '';
    $porfalta2 = 0;
}
        
    
    ?></td>
<?php } ?>

 




 

<td style="text-align:center" id="valorCalculado_<?php echo $row['02SUBETUFACTURAid']; ?>">
    <?php
     if (in_array($row['VIATICOSOPRO'], [
        'VIATICOS',
        'REEMBOLSO',
        'PAGO A PROVEEDOR CON DOS O MAS FACTURAS'
        
    ])) {
        $PorfaltaDeFacturaSUBERES2 = $database->diferenciaPorConsecutivo($row['NUMERO_CONSECUTIVO_PROVEE']);
        $valorNUEVO = $PorfaltaDeFacturaSUBERES2 ;
        echo number_format($valorNUEVO, 2, '.', ',');
		                  $PorfaltaDeFactura1 += $valorNUEVO;
				   
        

    }	
        elseif (($row['STATUS_CHECKBOX'] === 'no' || $row['STATUS_CHECKBOX'] === null) && strlen(trim($row['UUID'])) < 1) {
            $valorCalculado = $porfalta2 * 1.46;
            echo number_format($valorCalculado, 2, '.', ',');
				$PorfaltaDeFactura += $valorCalculado;
                 
                $totales2 = 'si';                  

        }
    
    ?>
</td>


<?php if ($database->variablespermisos('', 'boton_sinxml', 'ver') == 'si') { ?>

<?php
// SI NO ES "PAGOS CON UNA SOLA FACTURA" NI "PAGOAPROVE", SOLO MOSTRAR "NO APLICA"
if ($row["VIATICOSOPRO"] != "PAGOS CON UNA SOLA FACTURA" 
    && $row["VIATICOSOPRO"] != "PAGO A PROVEEDOR") {
?>
    <td style="text-align:center; color:#7a7a7a;">
        No aplica
    </td>
<?php
} else {
    // SI SÍ ES UNO DE LOS DOS, MOSTRAR CHECKBOX

    $idFila2   = (int)$row["02SUBETUFACTURAid"];
    $estaSi2   = ($row["STATUS_SINXML"] == 'si');

    $perm_guardar2   = ($database->variablespermisos('', 'boton_sinxml', 'guardar')   == 'si');
    $perm_modificar2 = ($database->variablespermisos('', 'boton_sinxml', 'modificar') == 'si');

    // Estado inicial
    $habilitado = 
        (!$estaSi2 && ($perm_guardar2 || $perm_modificar2)) ||
        ($estaSi2 && $perm_modificar2);
?>
    <td
      style="text-align:center; background:<?php echo $estaSi2 ? '#ceffcc' : '#e9d8ee'; ?>;"
      id="color_SINXML<?php echo $idFila2; ?>">

      <input
        type="checkbox"
        class="form-check-input"
        style="width:30px; <?php echo $habilitado ? 'cursor:pointer;' : 'cursor:not-allowed;'; ?>"
        id="STATUS_SINXML<?php echo $idFila2; ?>"
        name="STATUS_SINXML<?php echo $idFila2; ?>"
        value="<?php echo $idFila2; ?>"
        <?php echo $estaSi2 ? 'checked' : ''; ?>
        <?php echo $habilitado ? '' : 'disabled'; ?>
        title="<?php echo $habilitado ? '' : 'Sin permiso para modificar'; ?>"

        data-perm-guardar2="<?php echo $perm_guardar2 ? '1' : '0'; ?>"
        data-perm-modificar2="<?php echo $perm_modificar2 ? '1' : '0'; ?>"
        data-prev2="<?php echo $estaSi2 ? 'si' : 'no'; ?>"

        onclick="STATUS_SINXML(<?php echo $idFila2; ?>)"
      />
    </td>
<?php } // FIN IF VIATICOSOPRO ?>

<?php } // FIN PERMISOS VER ?>











        
<?php if($database->variablespermisos('','boton_sin','ver')=='si'){ ?>
<td style="text-align:center; background:<?php 
    if(strlen($row['UUID']) < 1) {
        if($row["STATUS_CHECKBOX"]=='si') { 
            echo '#ceffcc'; 
        } else { 
            echo '#e9d8ee'; 
        }
    } else {
        echo '#f0f0f0'; 
    }
?>" id="color_CHECKBOX<?php echo $row["02SUBETUFACTURAid"]; ?>">
    <span id="buscanumero<?php echo $row["02SUBETUFACTURAid"]; ?>">
        <?php if(strlen($row['UUID']) < 1): ?>
            <?php
            // Verificar permiso de modificación
            $permiso_modificar = $database->variablespermisos('','boton_sin','modificar') == 'si';
            $disabled = ($row["STATUS_CHECKBOX"] == 'si' && !$permiso_modificar) ? 'disabled' : '';
            ?>
            
<input type="checkbox" style="width:30PX;" class="form-check-input" 
    id="STATUS_CHECKBOX<?php echo $row["02SUBETUFACTURAid"]; ?>"  
    name="STATUS_CHECKBOX<?php echo $row["02SUBETUFacturaid"]; ?>" 
    value="<?php echo $row["02SUBETUFACTURAid"]; ?>" 
    onclick="STATUS_CHECKBOX(<?php echo $row['02SUBETUFACTURAid']; ?>, <?php echo $permiso_modificar ? 'true' : 'false'; ?>)" 
    <?php if($row["STATUS_CHECKBOX"]=='si') echo "checked"; ?>
    <?php echo $disabled; ?>
/>
        <?php else: ?>
            <span style="color:#999;">CON XML </span>
        <?php endif; ?>
    </span>
</td>
<?php } ?>


<?php if ($database->variablespermisos('', 'boton_VOBO', 'ver') == 'si') { ?>
<?php
  $idFila   = (int)$row["02SUBETUFACTURAid"];
  $estaSi   = ($row["STATUS_AUDITORIA3"] == 'si');

  $perm_guardar   = ($database->variablespermisos('', 'boton_VOBO', 'guardar')   == 'si');
  $perm_modificar = ($database->variablespermisos('', 'boton_VOBO', 'modificar') == 'si');

  // Estado inicial: habilitado solo si:
  // - está en "no" y tiene guardar o modificar
  // - está en "si" y tiene modificar
  $habilitado = (!$estaSi && ($perm_guardar || $perm_modificar)) || ($estaSi && $perm_modificar);
?>

<td
  style="text-align:center; background:<?php echo $estaSi ? '#ceffcc' : '#e9d8ee'; ?>;"
  id="color_AUDITORIA3<?php echo $idFila; ?>">

  <input
    type="checkbox"
    class="form-check-input"
    style="width:30px; <?php echo $habilitado ? 'cursor:pointer;' : 'cursor:not-allowed;'; ?>"
    id="STATUS_AUDITORIA3<?php echo $idFila; ?>"
    name="STATUS_AUDITORIA3<?php echo $idFila; ?>"
    value="<?php echo $idFila; ?>"
    <?php echo $estaSi ? 'checked' : ''; ?>
    <?php echo $habilitado ? '' : 'disabled'; ?>
    title="<?php echo $habilitado ? '' : 'Sin permiso para modificar'; ?>"

    data-perm-guardar="<?php echo $perm_guardar ? '1' : '0'; ?>"
    data-perm-modificar="<?php echo $perm_modificar ? '1' : '0'; ?>"
    data-prev="<?php echo $estaSi ? 'si' : 'no'; ?>"

    onclick="STATUS_AUDITORIA3(<?php echo $idFila; ?>)"
  />
</td>
<?php } ?>




<div id="ajax-notification" style="position:fixed; top:20px; right:20px; padding:15px; background:#4CAF50; color:white; border-radius:5px; display:none; z-index:1000;"></div>









<?php  if($database->plantilla_filtro($nombreTabla,"P_TIPO_DE_MONEDA_1",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php 

echo $P_TIPO_DE_MONEDA_1;

$explodeDatosBancarios = $database->datos_bancarios_todo($id_relacion_bancario, $row['NOMBRE_COMERCIAL']);

echo $explodeDatosBancarios['P_TIPO_DE_MONEDA_1'];
?></td>
<?php } ?>
<?php  if($database->plantilla_filtro($nombreTabla,"P_INSTITUCION_FINANCIERA_1",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php 

echo $P_INSTITUCION_FINANCIERA_1;
$explodeDatosBancarios = $database->datos_bancarios_todo($id_relacion_bancario, $row['NOMBRE_COMERCIAL']);
echo $explodeDatosBancarios['P_INSTITUCION_FINANCIERA_1'];
 ?></td>
<?php } ?>

<?php  if($database->plantilla_filtro($nombreTabla,"P_NUMERO_DE_CUENTA_DB_1",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php 

echo $P_NUMERO_DE_CUENTA_DB_1; 
$explodeDatosBancarios = $database->datos_bancarios_todo($id_relacion_bancario, $row['NOMBRE_COMERCIAL']);
echo $explodeDatosBancarios['P_NUMERO_DE_CUENTA_DB_1'];
?></td>
<?php } ?>

<?php  if($database->plantilla_filtro($nombreTabla,"P_NUMERO_CLABE_1",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php 
echo $P_NUMERO_CLABE_1; 
$explodeDatosBancarios = $database->datos_bancarios_todo($id_relacion_bancario, $row['NOMBRE_COMERCIAL']);
echo $explodeDatosBancarios['P_NUMERO_CLABE_1'];
?></td>
<?php } ?>

<?php  if($database->plantilla_filtro($nombreTabla,"P_NUMERO_IBAN_1",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php 
echo $P_NUMERO_IBAN_1;
$explodeDatosBancarios = $database->datos_bancarios_todo($id_relacion_bancario, $row['NOMBRE_COMERCIAL']);
echo $explodeDatosBancarios['P_NUMERO_IBAN_1'];
?></td>
<?php } ?>

<?php  if($database->plantilla_filtro($nombreTabla,"P_NUMERO_CUENTA_SWIFT_1",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php 

echo $P_NUMERO_CUENTA_SWIFT_1; 

$explodeDatosBancarios = $database->datos_bancarios_todo($id_relacion_bancario, $row['NOMBRE_COMERCIAL']);
echo $explodeDatosBancarios['P_NUMERO_CUENTA_SWIFT_1'];
?></td>
<?php } ?>

<?php  if($database->plantilla_filtro($nombreTabla,"FOTO_ESTADO_PROVEE",$altaeventos,$DEPARTAMENTO)=="si"){ ?><td style="text-align:center"><?php $explodeDatosBancarios = $database->datos_bancarios_todo($id_relacion_bancario, $row['NOMBRE_COMERCIAL']);
$regreso ="";
	if($explodeDatosBancarios['FOTO_ESTADO_PROVEE']==2 or $explodeDatosBancarios['FOTO_ESTADO_PROVEE']=='' or $explodeDatosBancarios['FOTO_ESTADO_PROVEE']==1)
	{
		echo $regreso ="<br>";
	}else{
		echo $regreso = "<a target='_blank'  href='includes/archivos/".$explodeDatosBancarios['FOTO_ESTADO_PROVEE']."'>ver</a><br>";
	}

?></td>
<?php } ?>








     <td>
	<?php
$VIATICOSOPRO = isset($row['VIATICOSOPRO'])?$row['VIATICOSOPRO']:'' ;
 if ($VIATICOSOPRO == "VIATICOS") : ?>
        <a href="viaticos.php?num_evento=<?php echo urlencode($row['NUMERO_EVENTO']); ?>&ID_RELACIONADO=<?php echo urlencode($row['NUMERO_CONSECUTIVO_PROVEE']); ?>&NUMERO_CONSECUTIVO_PROVEE=<?php echo urlencode($row['NUMERO_CONSECUTIVO_PROVEE']); ?>" target="_blank" rel="noopener noreferrer">
            <button style="text-align:center;width:160px"class="btn btn-info btn-xs" type="button">
                VIÁTICOS
            </button></center>
        </a>
		<?php endif; ?>
   
	<?php
$VIATICOSOPRO = isset($row['VIATICOSOPRO'])?$row['VIATICOSOPRO']:'' ;
 if ($VIATICOSOPRO == "REEMBOLSO") : ?>
        <a href="reembolsos.php?num_evento=<?php echo urlencode($row['NUMERO_EVENTO']); ?>&ID_RELACIONADO=<?php echo urlencode($row['NUMERO_CONSECUTIVO_PROVEE']); ?>&NUMERO_CONSECUTIVO_PROVEE=<?php echo urlencode($row['NUMERO_CONSECUTIVO_PROVEE']); ?>" target="_blank" rel="noopener noreferrer">
            <button style="text-align:center;width:160px"class="btn btn-info btn-xs" type="button">
                REEMBOLSO
            </button>
        </a>
		<?php endif; ?>
	<?php
$VIATICOSOPRO = isset($row['VIATICOSOPRO'])?$row['VIATICOSOPRO']:'' ;
 if ($VIATICOSOPRO == "PAGO A PROVEEDOR CON DOS O MAS FACTURAS") : ?>
        <a href="PAGOPROVEEDOR4.php?num_evento=<?php echo urlencode($row['NUMERO_EVENTO']); ?>&ID_RELACIONADO=<?php echo urlencode($row['NUMERO_CONSECUTIVO_PROVEE']); ?>&NUMERO_CONSECUTIVO_PROVEE=<?php echo urlencode($row['NUMERO_CONSECUTIVO_PROVEE']); ?>" target="_blank" rel="noopener noreferrer">
            <button style="text-align:center;width:160px"class="btn btn-info btn-xs" type="button">
                PAGO PROVEEDOR
            </button>
        </a>
		<?php endif; ?>

    </td>

	
	

<td <?php echo $fondo_existe_xml; ?>>
<?php if($database->variablespermisos('','PAGO_PROVEEDOR1','modificar')=='si'){ ?>

<input type="button" name="view" value="MODIFICAR" id="<?php echo $row["02SUBETUFACTURAid"]; ?>" class="btn btn-info btn-xs view_dataPAGOPROVEEmodifica" /><?php } ?></td>


<td><?php if($database->variablespermisos('','PAGO_PROVEEDOR1','borrar')=='si'){?>


<input type="button" name="view2" value="BORRAR" id="<?php echo $row["02SUBETUFACTURAid"]; ?>" class="btn btn-info btn-xs view_dataSBborrar" />
<?php } ?></td>	
<td>
    <input type="checkbox" 
           class="checkbox"
           data-id="<?php echo $row['02SUBETUFACTURAid'];?>" 
           style="transform: scale(1.1); cursor: pointer;" 
           onchange="
               const fila = this.closest('tr');
               const id = this.getAttribute('data-id');
               if (this.checked) {
                      fila.style.filter = 'brightness(65%) sepia(100%) saturate(200%) hue-rotate(0deg)';
                   localStorage.setItem('checkbox_' + id, 'checked');
               } else {
                   fila.style.filter = 'none';
                   localStorage.removeItem('checkbox_' + id);
               }">
</td>		
		</tr>
			<?php
			$finales++;
		}	
	?>


<tr>

<?php if($totales == 'si'){ ?>
<td style="text-align:right; padding-right:45px;" colspan="<?php echo $colspan + 2; ?>" ><strong style="font-size:16px">TOTALES</strong></td>
<?php } ?>

<?php


if($database->plantilla_filtro($nombreTabla,"MONTO_TOTAL_COTIZACION_ADEUDO",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<td style="text-align:center"><strong style="font-size:16px">$<?php echo number_format($MONTO_TOTAL_COTIZACION_ADEUDO12,2,'.',','); ?></strong></td>
<?php } ?>

<?php if($database->plantilla_filtro($nombreTabla,"MONTO_FACTURA",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<td style="text-align:center"><strong style="font-size:16px">$<?php echo number_format($MONTO_FACTURA12,2,'.',','); ?></strong></td>
<?php } ?>

<?php if($database->plantilla_filtro($nombreTabla,"IVA",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<td style="text-align:center"><strong style="font-size:16px">$<?php echo number_format($IVA12,2,'.',','); ?></strong></td>
<?php } ?>

<?php if($database->plantilla_filtro($nombreTabla,"TImpuestosRetenidosIVA",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<td style="text-align:center"><strong style="font-size:16px">$<?php echo number_format($TImpuestosRetenidosIVA12,2,'.',','); ?></strong></td>
<?php } ?> 
<?php if($database->plantilla_filtro($nombreTabla,"TImpuestosRetenidosISR",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<td style="text-align:center"><strong style="font-size:16px">$<?php echo number_format($TImpuestosRetenidosISR12,2,'.',','); ?></strong></td>
<?php } ?>



<?php if($database->plantilla_filtro($nombreTabla,"MONTO_PROPINA",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<td style="text-align:center"><strong style="font-size:16px">$<?php  echo number_format($MONTO_PROPINA12,2,'.',','); ?></strong></td>
<?php } ?>
<?php if($database->plantilla_filtro($nombreTabla,"IMPUESTO_HOSPEDAJE",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<td style="text-align:center"><strong style="font-size:16px">$<?php  echo number_format($IMPUESTO_HOSPEDAJE12,2,'.',','); ?></strong></td>
<?php } ?>

<?php if($database->plantilla_filtro($nombreTabla,"descuentos",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<td style="text-align:center"><strong style="font-size:16px">$<?php  echo number_format($descuentos12,2,'.',','); ?></strong></td>
<?php } ?>


<?php  if($database->plantilla_filtro($nombreTabla,"MONTO_DEPOSITAR",$altaeventos,$DEPARTAMENTO)=="si"){  ?>
<td style="text-align:center"><strong style="font-size:16px">$<?php echo number_format($MONTO_DEPOSITAR12,2,'.',','); ?></strong></td>
<?php } ?>

<?php  if($database->plantilla_filtro($nombreTabla,"MONTO_DEPOSITADO",$altaeventos,$DEPARTAMENTO)=="si"){  ?>
<td style="text-align:center"><strong style="font-size:16px">$<?php echo number_format($MONTO_DEPOSITADO12,2,'.',','); ?></strong></td>
<?php } ?>

<?php 


    $PENDIENTE_PAGO12_total = $MONTO_TOTAL_COTIZACION_ADEUDO12 - $MONTO_DEPOSITADO12;

 if($database->plantilla_filtro($nombreTabla,"PENDIENTE_PAGO",$altaeventos,$DEPARTAMENTO)=="si"){  ?>
<td style="text-align:center"><strong style="font-size:16px">$<?php echo number_format($PENDIENTE_PAGO12_total,2,'.',','); ?></strong></td>
<?php } ?>




</tr>		

<tr>


<?php if($totales2 == 'si'){ ?>
<td style="text-align:right; padding-right:45px;" colspan="<?php echo $colspan2+3; ?>"><strong style="font-size:16px">TOTALES XML</strong></td>
<?php } ?>





<?php if($database->plantilla_filtro($nombreTabla,"subTotal",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<td style="text-align:center"><strong style="font-size:16px">$<?php echo number_format($subTotal12,2,'.',','); ?></strong></td>
<?php } ?>
                                                             

<?php if($database->plantilla_filtro($nombreTabla,"propina",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<td style="text-align:center"><strong style="font-size:16px">$ <?php echo number_format($propina12,2,'.',','); ?></strong></td>
<?php } ?>
<?php if($database->plantilla_filtro($nombreTabla,"Descuento",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<td style="text-align:center"><strong style="font-size:16px">$<?php echo number_format($DESCUENTO,2,'.',','); ?></strong></td>
<?php } ?>

<?php  if($database->plantilla_filtro($nombreTabla,"TOTAL_IMPUESTOS_TRASLADADOS",$altaeventos,$DEPARTAMENTO)=="si"){  ?>
<td style="text-align:center" ><strong style="font-size:16px" >$<?php echo number_format($IVAXMLGTOTAL2,2,'.',','); ?></strong></td>
<?php } ?>


<?php  if($database->plantilla_filtro($nombreTabla,"TOTAL_IMPUESTOS_RETENIDOS",$altaeventos,$DEPARTAMENTO)=="si"){  ?>
<td style="text-align:center" ><strong style="font-size:16px" >$<?php echo number_format($TImpuestosRetenidos12,2,'.',','); ?></strong></td>
<?php } ?>


<?php  if($database->plantilla_filtro($nombreTabla,"TUA",$altaeventos,$DEPARTAMENTO)=="si"){ ?>
<td style="text-align:center" ><strong style="font-size:16px" >$<?php echo number_format($TUA12,2,'.',','); ?></strong></td>
<?php } ?>

<?php  if($database->plantilla_filtro($nombreTabla,"total",$altaeventos,$DEPARTAMENTO)=="si"){  ?>
<td style="text-align:center" ><strong style="font-size:16px" >$<?php echo number_format($totalf12,2,'.',','); ?></strong></td>
<?php } ?>
<?php

$PorfaltaDeFactura12 = $PorfaltaDeFactura + $PorfaltaDeFactura1;
?>
<td style="text-align:center">
  <strong style="font-size:16px" id="totalCalculado">
    $<?php echo number_format($PorfaltaDeFactura12, 2, '.', ','); ?>
  </strong>
</td>


</tr>		


		</tbody>
		</table>
		</div>
		<div class="clearfix">
			<?php 
				$inicios=$offset+1;
				$finales+=$inicios -1;
				echo '<div style="clear: both;" class="hint-text">Mostrando '.$inicios.' al '.$finales.' de '.$numrows.' registros</div>';
				echo $pagination->paginate();
			?>
        </div>
	<?php
	}
}
?>
