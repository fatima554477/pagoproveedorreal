<?php
/**
 	--------------------------
	Autor: Sandor Matamoros
	Programer: Fatima Arellano
	Propietario: EPC
	----------------------------
 
*/

define("__ROOT1__", dirname(dirname(__FILE__)));
	include_once (__ROOT1__."/../includes/error_reporting.php");
	include_once (__ROOT1__."/../comprobaciones/class.epcinnPP.php");

	
class orders extends accesoclase {
	public $mysqli;
	public $counter;//Propiedad para almacenar el numero de registro devueltos por la consulta
	private $matchCache = [];
	private $matchAnyCache = [];
	private $tarjetaCache = [];
	private $plantillaFiltroCache = [];


	function __construct(){
		$this->mysqli = $this->db();
    }
	public function plantilla_filtro($nombreTabla, $campo, $altaeventos, $departamento) {
		$cacheKey = $nombreTabla.'|'.$campo.'|'.$altaeventos.'|'.$departamento;
		if (isset($this->plantillaFiltroCache[$cacheKey])) {
			return $this->plantillaFiltroCache[$cacheKey];
		}

		$resultado = parent::plantilla_filtro($nombreTabla, $campo, $altaeventos, $departamento);
		$this->plantillaFiltroCache[$cacheKey] = $resultado;

		return $resultado;
	}
		/*se ocupa en MATCH_BBVA.php regresa checked*/
public function validaexistematch2COMPROBACION($IpMATCHDOCUMENTOS2,$TARJETA){
		$cacheKey = $IpMATCHDOCUMENTOS2.'|'.$TARJETA;
		if (isset($this->matchCache[$cacheKey])) {
			return $this->matchCache[$cacheKey];
		}

		$conn = $this->db();
		$documento = mysqli_real_escape_string($conn, $IpMATCHDOCUMENTOS2);
		$tarjeta = mysqli_real_escape_string($conn, $TARJETA);
		$pregunta = 'select 1 from 12matchDocumentos where 
			estatus = "si" and documentoConFactura="'.$documento.'" AND tarjeta="'.$tarjeta.'" limit 1';
		$preguntaQ = mysqli_query($conn,$pregunta) or die('P1533'.mysqli_error($conn));
		$resultado = (mysqli_num_rows($preguntaQ) > 0) ? 'checked' : '';
		$this->matchCache[$cacheKey] = $resultado;

		return $resultado;
	}












	public function validaexistematch2COMPROBACIONtodos($IpMATCHDOCUMENTOS2,$TARJETA){
		if (isset($this->matchAnyCache[$IpMATCHDOCUMENTOS2])) {
			return $this->matchAnyCache[$IpMATCHDOCUMENTOS2];
		}

		$conn = $this->db();
		$documento = mysqli_real_escape_string($conn, $IpMATCHDOCUMENTOS2);
		$pregunta = 'select 1 from 12matchDocumentos where 
			estatus = "si" and documentoConFactura="'.$documento.'" AND tarjeta IN ("AMERICANE","INBURSA","TARJETABBVA") limit 1';
		$preguntaQ = mysqli_query($conn,$pregunta) or die('P1533'.mysqli_error($conn));
		$resultado = (mysqli_num_rows($preguntaQ) > 0) ? 'checked' : '';
		$this->matchAnyCache[$IpMATCHDOCUMENTOS2] = $resultado;

		return $resultado;
        }


       public function tarjetaComprobacion($IpMATCHDOCUMENTOS2){
               if (isset($this->tarjetaCache[$IpMATCHDOCUMENTOS2])) {
                       return $this->tarjetaCache[$IpMATCHDOCUMENTOS2];
               }

               $conn = $this->db();
               $documento = mysqli_real_escape_string($conn, $IpMATCHDOCUMENTOS2);
               $pregunta = 'select distinct tarjeta from 12matchDocumentos where
               estatus = "si" and documentoConFactura="'.$documento.'"';
               $preguntaQ = mysqli_query($conn,$pregunta) or die('P1533'.mysqli_error($conn));
               $tarjetas = array();
               while($ROWP = MYSQLI_FETCH_ARRAY($preguntaQ, MYSQLI_ASSOC)){
                       $tarjetas[] = $this->nombreTarjeta($ROWP['tarjeta']);
               }
               if(count($tarjetas) == 0){
                       $resultado = '';
               }else{
                       $resultado = implode(', ', $tarjetas);
               }

               $this->tarjetaCache[$IpMATCHDOCUMENTOS2] = $resultado;
               return $resultado;
       }

       private function nombreTarjeta($tarjeta){
               $map = array(
                       'AMERICANE' => 'AMERICAN EXPRESS',
                       'INBURSA' => 'INBURSA',
                       'TARJETABBVA' => 'BBVA'
               );
               $tarjetaUpper = strtoupper($tarjeta);
               if(isset($map[$tarjetaUpper])){
                       return $map[$tarjetaUpper];
               }
               return $tarjetaUpper;
       }
	
	public function nombreCompletoPorID($id) {
    $conn = $this->db(); // tu conexión a la base de datos

    // Previene SQL injection
    $id = mysqli_real_escape_string($conn, trim($id));

    // Consulta
    $sql = "
        SELECT NOMBRE_1, NOMBRE_2, APELLIDO_PATERNO, APELLIDO_MATERNO
        FROM 01informacionpersonal
        WHERE idRelacion = '$id'
        LIMIT 1
    ";

    $nombreCompleto = 'SIN INFORMACIÓN'; // valor por defecto (gris clarito)
    
    if ($query = mysqli_query($conn, $sql)) {
        if ($row = mysqli_fetch_assoc($query)) {
            // Une los nombres con espacios y elimina dobles espacios
            $nombreCompleto = trim(
                $row['NOMBRE_1'].' '.
                $row['NOMBRE_2'].' '.
                $row['APELLIDO_PATERNO'].' '.
                $row['APELLIDO_MATERNO']
            );

            // Si por alguna razón está vacío, mantiene el texto “SIN INFORMACIÓN”
            if ($nombreCompleto == '') {
                $nombreCompleto = 'SIN INFORMACIÓN';
            }
        }
    }

    return $nombreCompleto;
}

	
	public function countAll($sql){
		$query=$this->mysqli->query($sql);
		$count=$query->num_rows;
		return $count;
	}
	//STATUS_EVENTO,NOMBRE_CORTO_EVENTO,NOMBRE_EVENTO
	public function getData($tables,$campos,$search){
		$offset=$search['offset'];
		$per_page=$search['per_page'];
		
		$tables = '07COMPROBACION';
		$tables2 = '07XML';		
		$tables5 = '04altaeventos';	        	
		$joinAltaEventos = " LEFT JOIN $tables5 ON $tables.NUMERO_EVENTO = $tables5.NUMERO_EVENTO AND $tables.NOMBRE_EVENTO = $tables5.NOMBRE_EVENTO ";
		$sWhereCC =" ON 07COMPROBACION.id = 07XML.`ultimo_id` ".$joinAltaEventos;
		$sWhere2="";$sWhere3="";
		
		
		if($search['NUMERO_CONSECUTIVO_PROVEE']!=""){
$sWhere2.="  $tables.NUMERO_CONSECUTIVO_PROVEE LIKE '%".$search['NUMERO_CONSECUTIVO_PROVEE']."%' AND ";}
if($search['RAZON_SOCIAL']!=""){
$sWhere2.="  $tables.RAZON_SOCIAL LIKE '%".$search['RAZON_SOCIAL']."%' AND ";}
if($search['RFC_PROVEEDOR']!=""){
$sWhere2.="  $tables.RFC_PROVEEDOR LIKE '%".$search['RFC_PROVEEDOR']."%' AND ";}
if($search['NUMERO_EVENTO']!=""){
$sWhere2.="  $tables.NUMERO_EVENTO LIKE '%".$search['NUMERO_EVENTO']."%' AND ";}
if($search['NOMBRE_EVENTO']!=""){
$sWhere2.="  $tables.NOMBRE_EVENTO LIKE '%".$search['NOMBRE_EVENTO']."%' AND ";}
if($search['MOTIVO_GASTO']!=""){
$sWhere2.="  $tables.MOTIVO_GASTO LIKE '%".$search['MOTIVO_GASTO']."%' AND ";}
if($search['CONCEPTO_PROVEE']!=""){
$sWhere2.="  $tables.CONCEPTO_PROVEE LIKE '%".$search['CONCEPTO_PROVEE']."%' AND ";}
if($search['MONTO_TOTAL_COTIZACION_ADEUDO']!=""){
$sWhere2.="  $tables.MONTO_TOTAL_COTIZACION_ADEUDO LIKE '%".$search['MONTO_TOTAL_COTIZACION_ADEUDO']."%' AND ";}


				if($search['FECHA_INICIO_EVENTO']!=""){
			$sWhere2.="  $tables5.FECHA_INICIO_EVENTO LIKE '%".$search['FECHA_INICIO_EVENTO']."%' and ";}
			
		if($search['FECHA_FINAL_EVENTO']!=""){
			$sWhere2.="  $tables5.FECHA_FINAL_EVENTO LIKE '%".$search['FECHA_FINAL_EVENTO']."%' and ";}	
if($search['MONTO_FACTURA']!=""){
$sWhere2.="  $tables.MONTO_FACTURA LIKE '%".$search['MONTO_FACTURA']."%' AND ";}
if($search['MONTO_PROPINA']!=""){
$sWhere2.="  $tables.MONTO_PROPINA LIKE '%".$search['MONTO_PROPINA']."%' AND ";}
if($search['MONTO_DEPOSITAR']!=""){
$sWhere2.="  $tables.MONTO_DEPOSITAR LIKE '%".$search['MONTO_DEPOSITAR']."%' AND ";}
if($search['TIPO_DE_MONEDA']!=""){
$sWhere2.="  $tables.TIPO_DE_MONEDA LIKE '%".$search['TIPO_DE_MONEDA']."%' AND ";}
if($search['PFORMADE_PAGO']!=""){
$sWhere2.="  $tables.PFORMADE_PAGO LIKE '%".$search['PFORMADE_PAGO']."%' AND ";}


if($search['FECHA_A_DEPOSITAR_DESDE']!="" && $search['FECHA_A_DEPOSITAR_HASTA']!=""){
    $sWhere2.="  $tables.FECHA_A_DEPOSITAR BETWEEN '".$search['FECHA_A_DEPOSITAR_DESDE']."' AND '".$search['FECHA_A_DEPOSITAR_HASTA']."' AND ";
} elseif($search['FECHA_A_DEPOSITAR_DESDE']!=""){
    $sWhere2.="  $tables.FECHA_A_DEPOSITAR >= '".$search['FECHA_A_DEPOSITAR_DESDE']."' AND ";
} elseif($search['FECHA_A_DEPOSITAR_HASTA']!=""){
    $sWhere2.="  $tables.FECHA_A_DEPOSITAR <= '".$search['FECHA_A_DEPOSITAR_HASTA']."' AND ";
}



if($search['STATUS_DE_PAGO']!=""){
$sWhere2.="  $tables.STATUS_DE_PAGO LIKE '%".$search['STATUS_DE_PAGO']."%' AND ";}

if($search['BANCO_ORIGEN']!=""){
$sWhere2.="  $tables.BANCO_ORIGEN LIKE '%".$search['BANCO_ORIGEN']."%' AND ";}

if($search['NOMBRE_COMERCIAL']!=""){
$sWhere2.="  $tables.NOMBRE_COMERCIAL LIKE '%".$search['NOMBRE_COMERCIAL']."%' AND ";}

if($search['EJECUTIVOTARJETA']!=""){
$ejecutivoTarjeta = strtoupper($search['EJECUTIVOTARJETA']);
$ejecutivoTarjetaEscapado = $this->mysqli->real_escape_string($ejecutivoTarjeta);

$busquedaNombre = "SELECT idRelacion FROM 01informacionpersonal WHERE UPPER(CONCAT_WS(' ', NOMBRE_1, NOMBRE_2, APELLIDO_PATERNO, APELLIDO_MATERNO)) LIKE '%".$ejecutivoTarjetaEscapado."%'";

$sWhere2.="  (UPPER($tables.EJECUTIVOTARJETA) LIKE '%".$ejecutivoTarjetaEscapado."%' OR $tables.EJECUTIVOTARJETA IN (".$busquedaNombre.")) OR ";}

if($search['ACTIVO_FIJO']!=""){
$sWhere2.="  $tables.ACTIVO_FIJO LIKE '%".$search['ACTIVO_FIJO']."%' AND ";}
if($search['GASTO_FIJO']!=""){
$sWhere2.="  $tables.GASTO_FIJO LIKE '%".$search['GASTO_FIJO']."%' AND ";}
if($search['PAGAR_CADA']!=""){
$sWhere2.="  $tables.PAGAR_CADA LIKE '%".$search['PAGAR_CADA']."%' AND ";}
if($search['FECHA_PPAGO']!=""){
$sWhere2.="  $tables.FECHA_PPAGO LIKE '%".$search['FECHA_PPAGO']."%' AND ";}
if($search['FECHA_TPROGRAPAGO']!=""){
$sWhere2.="  $tables.FECHA_TPROGRAPAGO LIKE '%".$search['FECHA_TPROGRAPAGO']."%' AND ";}
if($search['NUMERO_EVENTOFIJO']!=""){
$sWhere2.="  $tables.NUMERO_EVENTOFIJO LIKE '%".$search['NUMERO_EVENTOFIJO']."%' AND ";}
if($search['CLASI_GENERAL']!=""){
$sWhere2.="  $tables.CLASI_GENERAL LIKE '%".$search['CLASI_GENERAL']."%' AND ";}
if($search['SUB_GENERAL']!=""){
$sWhere2.="  $tables.SUB_GENERAL LIKE '%".$search['SUB_GENERAL']."%' AND ";}
if($search['MONTO_DE_COMISION']!=""){
$sWhere2.="  $tables.MONTO_DE_COMISION LIKE '%".$search['MONTO_DE_COMISION']."%' AND ";}
if($search['POLIZA_NUMERO']!=""){
$sWhere2.="  $tables.POLIZA_NUMERO LIKE '%".$search['POLIZA_NUMERO']."%' AND ";}
if($search['NOMBRE_DEL_EJECUTIVO']!=""){
$sWhere2.="  $tables.NOMBRE_DEL_EJECUTIVO LIKE '%".$search['NOMBRE_DEL_EJECUTIVO']."%' AND ";}
if($search['NOMBRE_DEL_AYUDO']!=""){
$sWhere2.="  $tables.NOMBRE_DEL_AYUDO LIKE '%".$search['NOMBRE_DEL_AYUDO']."%' AND ";}
if($search['OBSERVACIONES_1']!=""){
$sWhere2.="  $tables.OBSERVACIONES_1 LIKE '%".$search['OBSERVACIONES_1']."%' AND ";}
if($search['FECHA_DE_LLENADO']!=""){
$sWhere2.="  $tables.FECHA_DE_LLENADO LIKE '%".$search['FECHA_DE_LLENADO']."%' AND ";}
if($search['hiddenpagoproveedores']!=""){
$sWhere2.="  $tables.hiddenpagoproveedores LIKE '%".$search['hiddenpagoproveedores']."%' AND ";}
if($search['ADJUNTAR_COTIZACION']!=""){
$sWhere2.="  $tables.ADJUNTAR_COTIZACION LIKE '%".$search['ADJUNTAR_COTIZACION']."%' AND ";}

if($search['TIPO_CAMBIOP']!=""){
$sWhere2.="  $tables.TIPO_CAMBIOP LIKE '%".$search['TIPO_CAMBIOP']."%' AND ";}
if($search['TOTAL_ENPESOS']!=""){
$sWhere2.="  $tables.TOTAL_ENPESOS LIKE '%".$search['TOTAL_ENPESOS']."%' AND ";}

if($search['IVA']!=""){
$sWhere2.="  $tables.IVA LIKE '%".$search['IVA']."%' AND ";}

if($search['TImpuestosRetenidosIVA']!=""){
$sWhere2.="  $tables.TImpuestosRetenidosIVA LIKE '%".$search['TImpuestosRetenidosIVA']."%' AND ";}

if($search['TImpuestosRetenidosISR']!=""){
$sWhere2.="  $tables.TImpuestosRetenidosISR LIKE '%".$search['TImpuestosRetenidosISR']."%' AND ";}

if($search['descuentos']!=""){
$sWhere2.="  $tables.descuentos LIKE '%".$search['descuentos']."%' AND ";}


if($search['UUID']!=""){
$sWhere2.="  $tables2.UUID = '".$search['UUID']."' AND ";}

if($search['metodoDePago']!=""){
$sWhere2.="  $tables2.metodoDePago = '".$search['metodoDePago']."' AND ";}

if($search['total']!=""){
$totalf = str_replace(',','',str_replace('$','',$search['total']));
$sWhere2.="  $tables2.total = '".$totalf."' AND ";}

if($search['serie']!=""){
$sWhere2.="  $tables2.serie = '".$search['serie']."' AND ";}

if($search['folio']!=""){
$sWhere2.="  $tables2.folio = '".$search['folio']."' AND ";}

if($search['regimenE']!=""){
$sWhere2.="  $tables2.regimenE = '".$search['regimenE']."' AND ";}

if($search['UsoCFDI']!=""){
$sWhere2.="  $tables2.UsoCFDI = '".$search['UsoCFDI']."' AND ";}

if($search['TImpuestosTrasladados']!=""){
$TImpuestosTrasladados = str_replace(',','',str_replace('$','',$search['TImpuestosTrasladados']));
$sWhere2.="  $tables2.TImpuestosTrasladados = ".$TImpuestosTrasladados." AND ";}

if($search['TImpuestosRetenidos']!=""){
$TImpuestosRetenidos = str_replace(',','',str_replace('$','',$search['TImpuestosRetenidos']));
$sWhere2.="  $tables2.TImpuestosRetenidos = ".$TImpuestosRetenidos." AND ";}

if($search['Version']!=""){
$sWhere2.="  $tables2.Version = '".$search['Version']."' AND ";}

if($search['tipoDeComprobante']!=""){
$sWhere2.="  $tables2.tipoDeComprobante = '".$search['tipoDeComprobante']."' AND ";}

if($search['condicionesDePago']!=""){
$sWhere2.="  $tables2.condicionesDePago = '".$search['condicionesDePago']."' AND ";}

if($search['fechaTimbrado']!=""){
$sWhere2.="  $tables2.fechaTimbrado = '".$search['fechaTimbrado']."' AND ";}

if($search['nombreR']!=""){
$sWhere2.="  $tables2.nombreR = '".$search['nombreR']."' AND ";}

if($search['rfcR']!=""){
$sWhere2.="  $tables2.rfcR = '".$search['rfcR']."' AND ";}

if($search['Moneda']!=""){
$sWhere2.="  $tables2.Moneda = '".$search['Moneda']."' AND ";}

if($search['TipoCambio']!=""){
$sWhere2.="  $tables2.TipoCambio = '".$search['TipoCambio']."' AND ";}

if($search['ValorUnitarioConcepto']!=""){
$sWhere2.="  $tables2.ValorUnitarioConcepto = '".$search['ValorUnitarioConcepto']."' AND ";}

if($search['Cantidad']!=""){
$sWhere2.="  $tables2.Cantidad like '%".$search['Cantidad']."%' AND ";}

if($search['ClaveUnidad']!=""){
$sWhere2.="  $tables2.ClaveUnidad like '%".$search['ClaveUnidad']."%' AND ";}

if($search['ClaveProdServ']!=""){
$sWhere2.="  $tables2.ClaveProdServ = '".$search['ClaveProdServ']."' AND ";}

if($search['RFC_RECEPTOR']!=""){
$sWhere2.="  $tables2.RFC_RECEPTOR = '".$search['RFC_RECEPTOR']."' AND ";}

if($search['CantidadConcepto']!=""){
$sWhere2.="  $tables2.CantidadConcepto = '".$search['CantidadConcepto']."' AND ";}

if($search['ImporteConcepto']!=""){
$sWhere2.="  $tables2.ImporteConcepto = '".$search['ImporteConcepto']."' AND ";}

if($search['UnidadConcepto']!=""){
$sWhere2.="  $tables2.UnidadConcepto = '".$search['UnidadConcepto']."' AND ";}

if($search['TUA']!=""){
	$TUA = str_replace(',','',str_replace('$','',$search['TUA']));
$sWhere2.="  $tables2.TUA = '".$TUA."' AND ";}

if($search['TuaTotalCargos']!=""){
	$TuaTotalCargos = str_replace(',','',str_replace('$','',$search['TuaTotalCargos']));
$sWhere2.="  $tables2.TuaTotalCargos = '".$TuaTotalCargos."' AND ";}

if($search['Descuento']!=""){
	$Descuento = str_replace(',','',str_replace('$','',$search['Descuento']));
$sWhere2.="  $tables2.Descuento = '".$Descuento."' AND ";}

if($search['subTotal']!=""){
	$subTotal = str_replace(',','',str_replace('$','',$search['subTotal']));
$sWhere2.="  $tables2.subTotal = '".$subTotal."' AND ";}

if($search['IMPUESTO_HOSPEDAJE']!=""){
	$IMPUESTO_HOSPEDAJE = str_replace(',','',str_replace('$','',$search['IMPUESTO_HOSPEDAJE']));
$sWhere2.="  $tables2.IMPUESTO_HOSPEDAJE = '".$IMPUESTO_HOSPEDAJE."' AND ";}

if($search['propina']!=""){
	$propina = str_replace(',','',str_replace('$','',$search['propina']));
$sWhere2.="  $tables2.propina = '".$propina."' AND ";}







IF($sWhere2!=""){
			$sWhere22 = substr($sWhere2,0,-4);
			$sWhere3  = ' ('.$sWhere22.') ';
			$sWhere3  = ' '.$sWhereCC.' where ( ('.$sWhere3.') ) ';			
		}ELSE{
			//$sWhereCC = substr($sWhereCC,0,-4);			
		$sWhere3  = ' '.$sWhereCC.' ';
		}
		$sWhere3campo.=" $tables.id desc ";		
$sWhere3 .= " order by ".$sWhere3campo;


 $sql = "SELECT $campos, 07COMPROBACION.id as 07COMPROBACIONid 
        FROM $tables LEFT JOIN $tables2 $sWhere $sWhere3 
        LIMIT $offset,$per_page";
    $query = $this->mysqli->query($sql);

  
   $sqlCount = "SELECT COUNT(*) as total 
             FROM $tables LEFT JOIN $tables2 $sWhere3";
    $resultCount = $this->mysqli->query($sqlCount);
    $rowCount = $resultCount->fetch_assoc();
    $this->setCounter($rowCount['total']);

    return $query;
}
	function setCounter($counter) {
		$this->counter = $counter;
	}
	function getCounter() {
		return $this->counter;
	}
	
	        /**
         * Obtiene los números de evento para los que un colaborador puede
         * autorizar operaciones de ventas.
         *
         * La autorización se determina cuando el colaborador tiene
         * `autorizaAUT = 'si'` en la tabla 04personal y el evento asociado
         * pertenece a 04altaeventos.
         *
         * @param string|int $idPersonal Identificador del colaborador (idem en sesión).
         * @return string[] Lista de números de evento (normalizados en mayúsculas).
         */
        public function puedeAutorizarVentas($idPersonal) {
                if (empty($idPersonal)) {
                        return [];
                }

                $conn = $this->db();
                if (!$conn) {
                        return [];
                }

                $idPersonal = mysqli_real_escape_string($conn, trim((string) $idPersonal));

                $columnasIdentificador = $this->columnasIdentificadorPersonal($conn);
                if (empty($columnasIdentificador)) {
                        return [];
                }

                $condicionesIdentificador = [];
                foreach ($columnasIdentificador as $columna) {
                        $condicionesIdentificador[] = "`p`.`".$columna."` = '".$idPersonal."'";
                }

                $sql = "
                        SELECT DISTINCT ae.NUMERO_EVENTO
                        FROM 04personal AS p
                        INNER JOIN 04altaeventos AS ae ON ae.id = p.idRelacion
                        WHERE (".implode(' OR ', $condicionesIdentificador).")
                          AND LOWER(p.autorizaAUT) = 'si'
                          AND ae.NUMERO_EVENTO IS NOT NULL
                          AND ae.NUMERO_EVENTO <> ''";

                $resultado = mysqli_query($conn, $sql);
                if (!$resultado) {
                        return [];
                }

                $eventosAutorizados = [];
                while ($row = mysqli_fetch_assoc($resultado)) {
                        $eventoNormalizado = strtoupper(trim((string) $row['NUMERO_EVENTO']));
                        if ($eventoNormalizado !== '') {
                                $eventosAutorizados[$eventoNormalizado] = true;
                        }
                }
                mysqli_free_result($resultado);

                return array_keys($eventosAutorizados);
        }

        /**
         * Obtiene las columnas disponibles para identificar a un colaborador en 04personal.
         *
         * @param mysqli $conn Conexión activa a la base de datos.
         * @return string[]
         */
        private function columnasIdentificadorPersonal($conn) {
                static $columnasCache = null;

                if ($columnasCache !== null) {
                        return $columnasCache;
                }

                $columnasPosibles = ['idem', 'idPersonal', 'IDEM', 'ID_PERSONAL'];
                $columnasDisponibles = [];

                foreach ($columnasPosibles as $columna) {
                        if ($this->columnaExisteEnTabla($conn, '04personal', $columna)) {
                                $columnasDisponibles[] = $columna;
                        }
                }

                $columnasCache = $columnasDisponibles;
                return $columnasCache;
        }

        /**
         * Verifica si una columna existe en una tabla de la base de datos activa.
         *
         * @param mysqli $conn Conexión activa a la base de datos.
         * @param string $tabla Nombre de la tabla.
         * @param string $columna Nombre de la columna.
         * @return bool
         */
        private function columnaExisteEnTabla($conn, $tabla, $columna) {
                if (!$conn || $tabla === '' || $columna === '') {
                        return false;
                }

                $tablaLimpia = str_replace('`', '``', $tabla);
                $columnaLimpia = mysqli_real_escape_string($conn, $columna);
                $sql = "SHOW COLUMNS FROM `".$tablaLimpia."` LIKE '".$columnaLimpia."'";
                $resultado = mysqli_query($conn, $sql);
                if ($resultado) {
                        $existe = mysqli_num_rows($resultado) > 0;
                        mysqli_free_result($resultado);
                        return $existe;
                }

                return false;
        }
	
	
	
	
	
	
	
	
}
?>
