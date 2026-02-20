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
	include_once (__ROOT1__."/../pagoproveedores/class.epcinnPP.php");

	
	class orders extends accesoclase {
	public $mysqli;
	public $counter;//Propiedad para almacenar el numero de registro devueltos por la consulta

	function __construct(){
		$this->mysqli = $this->db();
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
		
		$sWhere=" ";
		$sWhere2="";$sWhere3="";if($search['NUMERO_CONSECUTIVO_PROVEE']!=""){
$sWhere2.="  $tables.NUMERO_CONSECUTIVO_PROVEE LIKE '%".$search['NUMERO_CONSECUTIVO_PROVEE']."%' OR ";}
if($search['NOMBRE_COMERCIAL']!=""){
$sWhere2.="  $tables.NOMBRE_COMERCIAL LIKE '%".$search['NOMBRE_COMERCIAL']."%' OR ";}
if($search['RAZON_SOCIAL']!=""){
$sWhere2.="  $tables.RAZON_SOCIAL LIKE '%".$search['RAZON_SOCIAL']."%' OR ";}
if($search['RFC_PROVEEDOR']!=""){
$sWhere2.="  $tables.RFC_PROVEEDOR LIKE '%".$search['RFC_PROVEEDOR']."%' OR ";}
if($search['NUMERO_EVENTO']!=""){
$sWhere2.="  $tables.NUMERO_EVENTO LIKE '%".$search['NUMERO_EVENTO']."%' OR ";}
if($search['NOMBRE_EVENTO']!=""){
$sWhere2.="  $tables.NOMBRE_EVENTO LIKE '%".$search['NOMBRE_EVENTO']."%' OR ";}
if($search['MOTIVO_GASTO']!=""){
$sWhere2.="  $tables.MOTIVO_GASTO LIKE '%".$search['MOTIVO_GASTO']."%' OR ";}
if($search['CONCEPTO_PROVEE']!=""){
$sWhere2.="  $tables.CONCEPTO_PROVEE LIKE '%".$search['CONCEPTO_PROVEE']."%' OR ";}
if($search['MONTO_TOTAL_COTIZACION_ADEUDO']!=""){
$sWhere2.="  $tables.MONTO_TOTAL_COTIZACION_ADEUDO LIKE '%".$search['MONTO_TOTAL_COTIZACION_ADEUDO']."%' OR ";}

if($search['MONTO_FACTURA']!=""){
$MONTO_FACTURA = str_replace(',','',str_replace('$','',$search['MONTO_FACTURA']));
$sWhere2.="  $tables.MONTO_FACTURA LIKE '%".$MONTO_FACTURA."%' OR ";}

if($search['MONTO_PROPINA']!=""){
$MONTO_PROPINA = str_replace(',','',str_replace('$','',$search['MONTO_PROPINA']));
$sWhere2.="  $tables.MONTO_PROPINA LIKE '%".$MONTO_PROPINA ."%' OR ";}

if($search['MONTO_DEPOSITAR']!=""){
$MONTO_DEPOSITAR = str_replace(',','',str_replace('$','',$search['MONTO_DEPOSITAR']));
$sWhere2.="  $tables.MONTO_DEPOSITAR LIKE '%".$MONTO_DEPOSITAR."%' OR ";}
if($search['MONTO_DEPOSITADO']!=""){
$sWhere2.="  $tables.MONTO_DEPOSITADO LIKE '%".$search['MONTO_DEPOSITADO']."%' OR ";}
if($search['TIPO_DE_MONEDA']!=""){
$sWhere2.="  $tables.TIPO_DE_MONEDA LIKE '%".$search['TIPO_DE_MONEDA']."%' OR ";}
if($search['PFORMADE_PAGO']!=""){
$sWhere2.="  $tables.PFORMADE_PAGO LIKE '%".$search['PFORMADE_PAGO']."%' OR ";}
if($search['FECHA_DE_PAGO']!=""){
$sWhere2.="  $tables.FECHA_DE_PAGO LIKE '%".$search['FECHA_DE_PAGO']."%' OR ";}
if($search['FECHA_A_DEPOSITAR']!=""){
$sWhere2.="  $tables.FECHA_A_DEPOSITAR LIKE '%".$search['FECHA_A_DEPOSITAR']."%' OR ";}
if($search['STATUS_DE_PAGO']!=""){
$sWhere2.="  $tables.STATUS_DE_PAGO LIKE '%".$search['STATUS_DE_PAGO']."%' OR ";}
if($search['ACTIVO_FIJO']!=""){
$sWhere2.="  $tables.ACTIVO_FIJO LIKE '%".$search['ACTIVO_FIJO']."%' OR ";}
if($search['GASTO_FIJO']!=""){
$sWhere2.="  $tables.GASTO_FIJO LIKE '%".$search['GASTO_FIJO']."%' OR ";}
if($search['PAGAR_CADA']!=""){
$sWhere2.="  $tables.PAGAR_CADA LIKE '%".$search['PAGAR_CADA']."%' OR ";}
if($search['FECHA_PPAGO']!=""){
$sWhere2.="  $tables.FECHA_PPAGO LIKE '%".$search['FECHA_PPAGO']."%' OR ";}
if($search['FECHA_TPROGRAPAGO']!=""){
$sWhere2.="  $tables.FECHA_TPROGRAPAGO LIKE '%".$search['FECHA_TPROGRAPAGO']."%' OR ";}
if($search['NUMERO_EVENTOFIJO']!=""){
$sWhere2.="  $tables.NUMERO_EVENTOFIJO LIKE '%".$search['NUMERO_EVENTOFIJO']."%' OR ";}
if($search['CLASI_GENERAL']!=""){
$sWhere2.="  $tables.CLASI_GENERAL LIKE '%".$search['CLASI_GENERAL']."%' OR ";}
if($search['SUB_GENERAL']!=""){
$sWhere2.="  $tables.SUB_GENERAL LIKE '%".$search['SUB_GENERAL']."%' OR ";}
if($search['NUMERO_EVENTO1']!=""){
$sWhere2.="  $tables.NUMERO_EVENTO1 LIKE '%".$search['NUMERO_EVENTO1']."%' OR ";}
if($search['CLASIFICACION_GENERAL']!=""){
$sWhere2.="  $tables.CLASIFICACION_GENERAL LIKE '%".$search['CLASIFICACION_GENERAL']."%' OR ";}
if($search['CLASIFICACION_ESPECIFICA']!=""){
$sWhere2.="  $tables.CLASIFICACION_ESPECIFICA LIKE '%".$search['CLASIFICACION_ESPECIFICA']."%' OR ";}
if($search['PLACAS_VEHICULO']!=""){
$sWhere2.="  $tables.PLACAS_VEHICULO LIKE '%".$search['PLACAS_VEHICULO']."%' OR ";}
if($search['MONTO_DE_COMISION']!=""){
$sWhere2.="  $tables.MONTO_DE_COMISION LIKE '%".$search['MONTO_DE_COMISION']."%' OR ";}
if($search['POLIZA_NUMERO']!=""){
$sWhere2.="  $tables.POLIZA_NUMERO LIKE '%".$search['POLIZA_NUMERO']."%' OR ";}
if($search['NOMBRE_DEL_EJECUTIVO']!=""){
$sWhere2.="  $tables.NOMBRE_DEL_EJECUTIVO LIKE '%".$search['NOMBRE_DEL_EJECUTIVO']."%' OR ";}
if($search['OBSERVACIONES_1']!=""){
$sWhere2.="  $tables.OBSERVACIONES_1 LIKE '%".$search['OBSERVACIONES_1']."%' OR ";}
if($search['FECHA_DE_LLENADO']!=""){
$sWhere2.="  $tables.FECHA_DE_LLENADO LIKE '%".$search['FECHA_DE_LLENADO']."%' OR ";}
if($search['hiddenpagoproveedores']!=""){
$sWhere2.="  $tables.hiddenpagoproveedores LIKE '%".$search['hiddenpagoproveedores']."%' OR ";}

IF($sWhere2!=""){
				$sWhere22 = substr($sWhere2,0,-3);
			$sWhere3  = ' where ( '.$sWhere22.' ) ';
		}ELSE{
		$sWhere3  = '';	
		}
		
		$sWhere3campo ="";
if($search['RAZON_SOCIAL_orden']=="asc"){
		$sWhere3campo .=" $tables.RAZON_SOCIAL asc, ";
}
if($search['RAZON_SOCIAL_orden']=="desc"){
		$sWhere3campo.=" $tables.RAZON_SOCIAL desc, ";
}
if($search['RFC_PROVEEDOR_orden']=="asc"){
		$sWhere3campo .=" $tables.RFC_PROVEEDOR asc, ";
}
if($search['RFC_PROVEEDOR_orden']=="desc"){
		$sWhere3campo.=" $tables.RFC_PROVEEDOR desc, ";
}

if($search['MONTO_FACTURA_orden']=="desc"){
		$sWhere3campo.=" $tables.MONTO_FACTURA desc, ";
}
if($search['MONTO_FACTURA_orden']=="asc"){
		$sWhere3campo.=" $tables.MONTO_FACTURA asc, ";
}

if($search['FECHA_DE_PAGO_orden']=="desc"){
		$sWhere3campo.=" $tables.FECHA_DE_PAGO desc, ";
}
if($search['FECHA_DE_PAGO_orden']=="asc"){
		$sWhere3campo.=" $tables.FECHA_DE_PAGO asc, ";
}
if($search['NUMERO_EVENTO_orden']=="desc"){
		$sWhere3campo.=" $tables.NUMERO_EVENTO desc, ";
}
if($search['NUMERO_EVENTO_orden']=="asc"){
		$sWhere3campo.=" $tables.NUMERO_EVENTO asc, ";
}
if($sWhere3campo == ""){
		$sWhere3campo.=" $tables.id desc ";		
}else{
		$sWhere3campo = substr($sWhere3campo,0,-2);
}
$sWhere3 .= " order by ".$sWhere3campo;

		$sql="SELECT $campos FROM  $tables $sWhere $sWhere3 LIMIT $offset,$per_page";
		
		$query=$this->mysqli->query($sql);
		$sql1="SELECT $campos FROM  $tables $sWhere $sWhere3 ";
		$nums_row=$this->countAll($sql1);
		//Set counter
		$this->setCounter($nums_row);
		return $query;
	}
	function setCounter($counter) {
		$this->counter = $counter;
	}
	function getCounter() {
		return $this->counter;
	}
}
?>
