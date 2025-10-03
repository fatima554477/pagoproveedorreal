<?php
/**
 	--------------------------
	Autor: Sandor Matamoros
	Programer: Fatima Arellano
	Propietario: EPC
	fecha sandor: 
    fecha fatis : 05/04/2025
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

	public function datos_bancarios_xml($rfc){
		$conn = $this->db();
		$variable = "select *,02usuarios.id as iddd from 02usuarios left join 02direccionproveedor1 ON 02usuarios.id = 02direccionproveedor1.idRelacion where P_RFC_MTDP = '".$rfc."' ";
		$query = mysqli_query($conn,$variable);
		$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
		return $row['iddd'];
	}

	public function datos_bancarios_todo($idRelacion){
		$conn = $this->db();
		$variable2 = "select * from 02DATOSBANCARIOS1 where idRelacion = '".$idRelacion."' and checkbox = 'si'  ";
		$query2 = mysqli_query($conn,$variable2);
		$row2 = mysqli_fetch_array($query2, MYSQLI_ASSOC);
		return $row2;
	}

	public function DOCUMENTOSFISCALES_PAGOA($idRelacion, $documento , $documento2=FALSE){
		$conn = $this->db();
		$variable2 = "select * from 02DOCUMENTOSFISCALES where idRelacion = '".$idRelacion."' and 
		(DOCUMENTO_LEGAL = '".$documento."' OR DOCUMENTO_LEGAL = '".$documento2."' ) ORDER BY ID DESC LIMIT 1  ";
		$query2 = mysqli_query($conn,$variable2);
		$ADJUNTAR_DOCUMENTO_LEGAL = "";
		while($row2 = mysqli_fetch_array($query2, MYSQLI_ASSOC)){
			if($row2['ADJUNTAR_DOCUMENTO_LEGAL']!=2 or 
			$row2['ADJUNTAR_DOCUMENTO_LEGAL']!='' or 
			$row2['ADJUNTAR_DOCUMENTO_LEGAL']!=1)
			{
				 $ADJUNTAR_DOCUMENTO_LEGAL .= "<a target='_blank'  href='includes/archivos/".$row2['ADJUNTAR_DOCUMENTO_LEGAL']."'>ver</a><br>";
			}else{
				 $ADJUNTAR_DOCUMENTO_LEGAL .= "<br>";
			}
		}
		return $ADJUNTAR_DOCUMENTO_LEGAL;
	}

	public function countAll($sql){
		$query=$this->mysqli->query($sql);
		$count=$query->num_rows;
		return $count;
	}
	//STATUS_EVENTO,NOMBRE_CORTO_EVENTO,NOMBRE_EVENTO
	public function getData($tables3,$campos,$search){
		$offset=$search['offset'];
		$per_page=$search['per_page'];
		$tables = '02SUBETUFACTURA';
		$tables2 = '02XML';	
        $tables4 = '02DATOSBANCARIOS1';			
		//$sWhereCC ="  02XML.`idRelacion` = 02SUBETUFACTURA.id AND ";
		$sWhereCC =" ON 02SUBETUFACTURA.id = 02XML.`ultimo_id` ";
		$sWhere2="";$sWhere3="";
		
		if($search['NUMERO_CONSECUTIVO_PROVEE']!=""){
			$sWhere2.="  $tables.NUMERO_CONSECUTIVO_PROVEE LIKE '%".$search['NUMERO_CONSECUTIVO_PROVEE']."%' and ";}
		if($search['NOMBRE_COMERCIAL']!=""){
			$sWhere2.="  $tables.NOMBRE_COMERCIAL LIKE '%".$search['NOMBRE_COMERCIAL']."%' and ";}
		if($search['RAZON_SOCIAL']!=""){
			$sWhere2.="  $tables.RAZON_SOCIAL LIKE '%".$search['RAZON_SOCIAL']."%' and ";}
		if($search['RFC_PROVEEDOR']!=""){
			$sWhere2.="  $tables.RFC_PROVEEDOR = '".$search['RFC_PROVEEDOR']."' and ";}
		if($search['VIATICOSOPRO']!=""){
			$sWhere2.="  $tables.VIATICOSOPRO = '".$search['VIATICOSOPRO']."' and ";}
		if($search['NUMERO_EVENTO']!=""){
			$sWhere2.="  $tables.NUMERO_EVENTO LIKE '%".$search['NUMERO_EVENTO']."%' and ";}
		if($search['NOMBRE_EVENTO']!=""){
			$sWhere2.="  $tables.NOMBRE_EVENTO LIKE '%".$search['NOMBRE_EVENTO']."%' and ";}
		if($search['MOTIVO_GASTO']!=""){
			$sWhere2.="  $tables.MOTIVO_GASTO LIKE '%".$search['MOTIVO_GASTO']."%' and ";}
		if($search['CONCEPTO_PROVEE']!=""){
			$sWhere2.="  $tables.CONCEPTO_PROVEE LIKE '%".$search['CONCEPTO_PROVEE']."%' and ";}
		if($search['MONTO_TOTAL_COTIZACION_ADEUDO']!=""){
			$sWhere2.="  $tables.MONTO_TOTAL_COTIZACION_ADEUDO LIKE '%".$search['MONTO_TOTAL_COTIZACION_ADEUDO']."%' and ";}

		if($search['MONTO_FACTURA']!=""){
			$MONTO_FACTURA = str_replace(',','',str_replace('$','',$search['MONTO_FACTURA']));
			$sWhere2.="  $tables.MONTO_FACTURA LIKE '%".$MONTO_FACTURA."%' and ";}

		if($search['MONTO_PROPINA']!=""){
			$MONTO_PROPINA = str_replace(',','',str_replace('$','',$search['MONTO_PROPINA']));
			$sWhere2.="  $tables.MONTO_PROPINA LIKE '%".$MONTO_PROPINA ."%' and ";}

		if($search['MONTO_DEPOSITAR']!=""){
			$MONTO_DEPOSITAR = str_replace(',','',str_replace('$','',$search['MONTO_DEPOSITAR']));
			$sWhere2.="  $tables.MONTO_DEPOSITAR LIKE '%".$MONTO_DEPOSITAR."%' and ";
		}
		if($search['IVA']!=""){
			$sWhere2.="  $tables.IVA LIKE '%".$search['IVA']."%' and ";}

		if($search['IEPS']!=""){
			$sWhere2.="  $tables.IEPS LIKE '%".$search['IEPS']."%' and ";}

		if($search['MONTO_DEPOSITADO']!=""){
			$MONTO_DEPOSITADO = str_replace(',','',str_replace('$','',$search['MONTO_DEPOSITADO']));	
			$sWhere2.="  $tables.MONTO_DEPOSITADO LIKE '%".$search['MONTO_DEPOSITADO']."%' and ";}

		if($search['TIPO_DE_MONEDA']!=""){
			$sWhere2.="  $tables.TIPO_DE_MONEDA LIKE '%".$search['TIPO_DE_MONEDA']."%' and ";}
		if($search['PFORMADE_PAGO']!=""){
			$sWhere2.="  $tables.PFORMADE_PAGO LIKE '%".$search['PFORMADE_PAGO']."%' and ";}

		if($search['FECHA_DE_PAGO']!="" and $search['FECHA_DE_PAGO2a']!=""){
			$sWhere2.=" $tables.FECHA_DE_PAGO BETWEEN 
		'".$search['FECHA_DE_PAGO']."' and '".$search['FECHA_DE_PAGO2a']."'  and ";
		}elseif($search['FECHA_DE_PAGO']!=""){
			$sWhere2.=" $tables.FECHA_DE_PAGO LIKE '%".$search['FECHA_DE_PAGO']."%' and ";
		}elseif($search['FECHA_DE_PAGO2a']!=""){
			$sWhere2.=" $tables.FECHA_DE_PAGO LIKE '%".$search['FECHA_DE_PAGO2a']."%' and ";
		}

		if($search['FECHA_A_DEPOSITAR']!=""){
			$sWhere2.="  $tables.FECHA_A_DEPOSITAR LIKE '%".$search['FECHA_A_DEPOSITAR']."%' and ";}
		if($search['STATUS_DE_PAGO']!=""){
			$sWhere2.="  $tables.STATUS_DE_PAGO LIKE '%".$search['STATUS_DE_PAGO']."%' and ";}
		if($search['ACTIVO_FIJO']!=""){
			$sWhere2.="  $tables.ACTIVO_FIJO LIKE '%".$search['ACTIVO_FIJO']."%' and ";}
		if($search['GASTO_FIJO']!=""){
			$sWhere2.="  $tables.GASTO_FIJO LIKE '%".$search['GASTO_FIJO']."%' and ";}
		if($search['PAGAR_CADA']!=""){
			$sWhere2.="  $tables.PAGAR_CADA LIKE '%".$search['PAGAR_CADA']."%' and ";}
		if($search['FECHA_PPAGO']!=""){
			$sWhere2.="  $tables.FECHA_PPAGO LIKE '%".$search['FECHA_PPAGO']."%' and ";}
		if($search['FECHA_TPROGRAPAGO']!=""){
			$sWhere2.="  $tables.FECHA_TPROGRAPAGO LIKE '%".$search['FECHA_TPROGRAPAGO']."%' and ";}
		if($search['NUMERO_EVENTOFIJO']!=""){
			$sWhere2.="  $tables.NUMERO_EVENTOFIJO LIKE '%".$search['NUMERO_EVENTOFIJO']."%' and ";}
		if($search['CLASI_GENERAL']!=""){
			$sWhere2.="  $tables.CLASI_GENERAL LIKE '%".$search['CLASI_GENERAL']."%' and ";}
		if($search['SUB_GENERAL']!=""){
			$sWhere2.="  $tables.SUB_GENERAL LIKE '%".$search['SUB_GENERAL']."%' and ";}
		if($search['NUMERO_EVENTO1']!=""){
			$sWhere2.="  $tables.NUMERO_EVENTO1 = '".$search['NUMERO_EVENTO1']."' and ";}
		if($search['CLASIFICACION_GENERAL']!=""){
			$sWhere2.="  $tables.CLASIFICACION_GENERAL LIKE '%".$search['CLASIFICACION_GENERAL']."%' and ";}
		if($search['CLASIFICACION_ESPECIFICA']!=""){
			$sWhere2.="  $tables.CLASIFICACION_ESPECIFICA LIKE '%".$search['CLASIFICACION_ESPECIFICA']."%' and ";}
		if($search['PLACAS_VEHICULO']!=""){
			$sWhere2.="  $tables.PLACAS_VEHICULO LIKE '%".$search['PLACAS_VEHICULO']."%' and ";}
		if($search['MONTO_DE_COMISION']!=""){
			$sWhere2.="  $tables.MONTO_DE_COMISION = '".$search['MONTO_DE_COMISION']."' and ";}
		if($search['POLIZA_NUMERO']!=""){
			$sWhere2.="  $tables.POLIZA_NUMERO LIKE '%".$search['POLIZA_NUMERO']."%' and ";}
		if($search['NOMBRE_DEL_EJECUTIVO']!=""){
			$sWhere2.="  $tables.NOMBRE_DEL_EJECUTIVO LIKE '%".$search['NOMBRE_DEL_EJECUTIVO']."%' and ";}
		if($search['NOMBRE_DEL_AYUDO']!=""){
			$sWhere2.="  $tables.NOMBRE_DEL_AYUDO LIKE '%".$search['NOMBRE_DEL_AYUDO']."%' and ";}
		if($search['OBSERVACIONES_1']!=""){
			$sWhere2.="  $tables.OBSERVACIONES_1 LIKE '%".$search['OBSERVACIONES_1']."%' and ";}
		if($search['FECHA_DE_LLENADO']!=""){
			$sWhere2.="  $tables.FECHA_DE_LLENADO LIKE '%".$search['FECHA_DE_LLENADO']."%' and ";}
		if($search['ID_RELACIONADO']!=""){
			$sWhere2.="  $tables.ID_RELACIONADO LIKE '%".$search['ID_RELACIONADO']."%' and ";}
		if($search['hiddenpagoproveedores']!=""){
			$sWhere2.="  $tables.hiddenpagoproveedores LIKE '%".$search['hiddenpagoproveedores']."%' and ";}
		if($search['TIPO_CAMBIOP']!=""){
			$sWhere2.="  $tables.TIPO_CAMBIOP LIKE '%".$search['TIPO_CAMBIOP']."%' and ";}
		if($search['TOTAL_ENPESOS']!=""){
			$sWhere2.="  $tables.TOTAL_ENPESOS LIKE '%".$search['TOTAL_ENPESOS']."%' and ";}
		if($search['TImpuestosRetenidosIVA']!=""){
			$sWhere2.="  $tables.TImpuestosRetenidosIVA LIKE '%".$search['TImpuestosRetenidosIVA']."%' and ";}
		if($search['TImpuestosRetenidosISR']!=""){
			$sWhere2.="  $tables.TImpuestosRetenidosISR LIKE '%".$search['TImpuestosRetenidosISR']."%' and ";}
		if($search['descuentos']!=""){
			$sWhere2.="  $tables.descuentos LIKE '%".$search['descuentos']."%' and ";}

		/////////////////////////////nuevo//////////////////////////
		if($search['P_TIPO_DE_MONEDA_1']!=""){
			$sWhere2.="  $tables4.P_TIPO_DE_MONEDA_1 LIKE '%".$search['P_TIPO_DE_MONEDA_1']."%' and ";}
		if($search['P_INSTITUCION_FINANCIERA_1']!=""){
			$sWhere2.="  $tables4.P_INSTITUCION_FINANCIERA_1 LIKE '%".$search['P_INSTITUCION_FINANCIERA_1']."%' and ";}
		if($search['P_NUMERO_DE_CUENTA_DB_1']!=""){
			$sWhere2.="  $tables4.P_NUMERO_DE_CUENTA_DB_1 LIKE '%".$search['P_NUMERO_DE_CUENTA_DB_1']."%' and ";}
		if($search['P_NUMERO_CLABE_1']!=""){
			$sWhere2.="  $tables4.P_NUMERO_CLABE_1 LIKE '%".$search['P_NUMERO_CLABE_1']."%' and ";}
		if($search['P_NUMERO_IBAN_1']!=""){
			$sWhere2.="  $tables4.P_NUMERO_IBAN_1 LIKE '%".$search['P_NUMERO_IBAN_1']."%' and ";}
		if($search['P_NUMERO_CUENTA_SWIFT_1']!=""){
			$sWhere2.="  $tables4.P_NUMERO_CUENTA_SWIFT_1 LIKE '%".$search['P_NUMERO_CUENTA_SWIFT_1']."%' and ";}
		if($search['FOTO_ESTADO_PROVEE']!=""){
			$sWhere2.="  $tables4.FOTO_ESTADO_PROVEE LIKE '%".$search['FOTO_ESTADO_PROVEE']."%' and ";}
		if($search['ULTIMA_CARGA_DATOBANCA']!=""){
			$sWhere2.="  $tables4.ULTIMA_CARGA_DATOBANCA LIKE '%".$search['ULTIMA_CARGA_DATOBANCA']."%' and ";}

		if($search['UUID']!=""){
			$sWhere2.="  $tables2.UUID = '".$search['UUID']."' and ";}
		if($search['metodoDePago']!=""){
			$sWhere2.="  $tables2.metodoDePago = '".$search['metodoDePago']."' and ";}
		if($search['totalf']!=""){
			$totalf = str_replace(',','',str_replace('$','',$search['totalf']));
			$sWhere2.="  $tables2.totalf = '".$totalf."' and ";}
		if($search['serie']!=""){
			$sWhere2.="  $tables2.serie = '".$search['serie']."' and ";}
		if($search['folio']!=""){
			$sWhere2.="  $tables2.folio = '".$search['folio']."' and ";}
		if($search['regimenE']!=""){
			$sWhere2.="  $tables2.regimenE = '".$search['regimenE']."' and ";}
		if($search['UsoCFDI']!=""){
			$sWhere2.="  $tables2.UsoCFDI = '".$search['UsoCFDI']."' and ";}
		if($search['TImpuestosTrasladados']!=""){
			$TImpuestosTrasladados = str_replace(',','',str_replace('$','',$search['TImpuestosTrasladados']));
			$sWhere2.="  $tables2.TImpuestosTrasladados = ".$TImpuestosTrasladados." and ";}
		if($search['TImpuestosRetenidos']!=""){
			$TImpuestosRetenidos = str_replace(',','',str_replace('$','',$search['TImpuestosRetenidos']));
			$sWhere2.="  $tables2.TImpuestosRetenidos = ".$TImpuestosRetenidos." and ";}
		if($search['Version']!=""){
			$sWhere2.="  $tables2.Version = '".$search['Version']."' and ";}
		if($search['tipoDeComprobante']!=""){
			$sWhere2.="  $tables2.tipoDeComprobante = '".$search['tipoDeComprobante']."' and ";}
		if($search['condicionesDePago']!=""){
			$sWhere2.="  $tables2.condicionesDePago = '".$search['condicionesDePago']."' and ";}
		if($search['fechaTimbrado']!=""){
			$sWhere2.="  $tables2.fechaTimbrado = '".$search['fechaTimbrado']."' and ";}
		if($search['nombreR']!=""){
			$sWhere2.="  $tables2.nombreR = '".$search['nombreR']."' and ";}
		if($search['rfcR']!=""){
			$sWhere2.="  $tables2.rfcR = '".$search['rfcR']."' and ";}
		if($search['Moneda']!=""){
			$sWhere2.="  $tables2.Moneda = '".$search['Moneda']."' and ";}
		if($search['TipoCambio']!=""){
			$sWhere2.="  $tables2.TipoCambio = '".$search['TipoCambio']."' and ";}
		if($search['ValorUnitarioConcepto']!=""){
			$sWhere2.="  $tables2.ValorUnitarioConcepto = '".$search['ValorUnitarioConcepto']."' and ";}
		if($search['DescripcionConcepto']!=""){
			$sWhere2.="  $tables2.DescripcionConcepto like '%".$search['DescripcionConcepto']."%' and ";}
		if($search['ClaveUnidadConcepto']!=""){
			$sWhere2.="  $tables2.ClaveUnidadConcepto like '%".$search['ClaveUnidadConcepto']."%' and ";}
		if($search['ClaveProdServConcepto']!=""){
			$sWhere2.="  $tables2.ClaveProdServConcepto = '".$search['ClaveProdServConcepto']."' and ";}
		if($search['RFC_RECEPTOR']!=""){
			$sWhere2.="  $tables2.RFC_RECEPTOR = '".$search['RFC_RECEPTOR']."' and ";}
		if($search['CantidadConcepto']!=""){
			$sWhere2.="  $tables2.CantidadConcepto = '".$search['CantidadConcepto']."' and ";}
		if($search['ImporteConcepto']!=""){
			$sWhere2.="  $tables2.ImporteConcepto = '".$search['ImporteConcepto']."' and ";}
		if($search['UnidadConcepto']!=""){
			$sWhere2.="  $tables2.UnidadConcepto = '".$search['UnidadConcepto']."' and ";}
		if($search['TUA']!=""){
			$TUA = str_replace(',','',str_replace('$','',$search['TUA']));
			$sWhere2.="  $tables2.TUA = '".$TUA."' and ";}
		if($search['TuaTotalCargos']!=""){
			$TuaTotalCargos = str_replace(',','',str_replace('$','',$search['TuaTotalCargos']));
			$sWhere2.="  $tables2.TuaTotalCargos = '".$TuaTotalCargos."' and ";}
		if($search['IVAXML']!=""){
			$IVAXML = str_replace(',','',str_replace('$','',$search['IVAXML']));
			$sWhere2.="  $tables2.IVAXML = '".$IVAXML."' and ";}
		if($search['IEPSXML']!=""){
			$IEPSXML = str_replace(',','',str_replace('$','',$search['IEPSXML']));
			$sWhere2.="  $tables2.IEPSXML = '".$IEPSXML."' and ";}
		if($search['Descuento']!=""){
			$Descuento = str_replace(',','',str_replace('$','',$search['Descuento']));
			$sWhere2.="  $tables2.Descuento = '".$Descuento."' and ";}
		if($search['subTotal']!=""){
			$subTotal = str_replace(',','',str_replace('$','',$search['subTotal']));
			$sWhere2.="  $tables2.subTotal = '".$subTotal."' and ";}
		if($search['IMPUESTO_HOSPEDAJE']!=""){
			$IMPUESTO_HOSPEDAJE = str_replace(',','',str_replace('$','',$search['IMPUESTO_HOSPEDAJE']));
			$sWhere2.="  $tables2.IMPUESTO_HOSPEDAJE = '".$IMPUESTO_HOSPEDAJE."' and ";}
		if($search['propina']!=""){
			$propina = str_replace(',','',str_replace('$','',$search['propina']));
			$sWhere2.="  $tables2.propina = '".$propina."' and ";}

		if ($sWhere2 != "") {
			$sWhere22 = substr($sWhere2, 0, -4);
			$sWhere3 = ' ' . $sWhereCC . ' WHERE ( (' . $sWhere22 . ') 
				AND (02SUBETUFACTURA.ID_RELACIONADO IS NULL OR TRIM(02SUBETUFACTURA.ID_RELACIONADO) = "") ) '; 
		} else {
			$sWhere3 = ' ' . $sWhereCC . ' WHERE (02SUBETUFACTURA.ID_RELACIONADO IS NULL OR TRIM(02SUBETUFACTURA.ID_RELACIONADO) = "") '; 
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
			$sWhere3campo.="  $tables.id desc ";		
		}else{
			$sWhere3campo = substr($sWhere3campo,0,-2);
		}

		$sWhere3 .= " order by ".$sWhere3campo;

		$sql="SELECT $campos , 02SUBETUFACTURA.id as 02SUBETUFACTURAid, RFC_PROVEEDOR as RFC_PROVEEDOR1trim FROM $tables LEFT JOIN $tables2 $sWhere $sWhere3 LIMIT $offset,$per_page";
		$query=$this->mysqli->query($sql);
		$sql1="SELECT $campos , 02SUBETUFACTURA.id as 02SUBETUFACTURAid, RFC_PROVEEDOR as RFC_PROVEEDOR1trim FROM  $tables LEFT JOIN $tables2 $sWhere $sWhere3 ";
		$nums_row=$this->countAll($sql1); 
		//Set counter
		$this->setCounter($nums_row);
		return $query;
		
	}


public function obtener_rfc_a_id($valor) {
    $conn = $this->db();

    // Escapar el valor por seguridad
    $valor = mysqli_real_escape_string($conn, trim($valor));

    // 1. Buscar por RFC exacto
    $query = 'SELECT idRelacion FROM 02direccionproveedor1 WHERE P_RFC_MTDP = "'.$valor.'" LIMIT 1';
    $respuesta = mysqli_query($conn, $query);
    $fetch_array = mysqli_fetch_array($respuesta, MYSQLI_ASSOC);

    if (!empty($fetch_array['idRelacion'])) {
        return $fetch_array['idRelacion'];
    }

    // 2. Buscar por razón social (LIKE)
    $query2 = 'SELECT idRelacion FROM 02direccionproveedor1 WHERE P_NOMBRE_FISCAL_RS_EMPRESA LIKE "%'.$valor.'%" LIMIT 1';
    $respuesta2 = mysqli_query($conn, $query2);
    $fetch_array2 = mysqli_fetch_array($respuesta2, MYSQLI_ASSOC);

    if (!empty($fetch_array2['idRelacion'])) {
        return $fetch_array2['idRelacion'];
    }

    // 3. Buscar por nombre comercial (LIKE)
    $query3 = 'SELECT idRelacion FROM 02direccionproveedor1 WHERE P_NOMBRE_COMERCIAL_EMPRESA LIKE "%'.$valor.'%" LIMIT 1';
    $respuesta3 = mysqli_query($conn, $query3);
    $fetch_array3 = mysqli_fetch_array($respuesta3, MYSQLI_ASSOC);

    if (!empty($fetch_array3['idRelacion'])) {
        return $fetch_array3['idRelacion'];
    }

    // Si no encontró nada, regresar NULL o falso
    return null;
}


	public function getTotalAmaunt($rfc,$idrelacioN=false){
		//PRINT_R($idrelacioN);
		$query_OR = "";
		foreach($idrelacioN as $etiqueta => $valor){
			foreach( $valor AS $etiqueta2 => $valor2){
				$query_OR .= ' id = '. $valor2.' OR ';
			}
		}
		//ECHO $query_OR;
		$query_OR2 = substr($query_OR,0,-3);
		$ROWevento = $this->var_altaeventos();
		$conn = $this->db();		
		$NUMERO_EVENTO = isset($ROWevento["NUMERO_EVENTO"])?$ROWevento["NUMERO_EVENTO"]:"";
		$sWhere3  = ' where ( 02SUBETUFACTURA.NUMERO_EVENTO = "'.$NUMERO_EVENTO.'") and RFC_PROVEEDOR = trim("'.trim($rfc).'")  ';
		$sql1="SELECT sum(MONTO_TOTAL_COTIZACION_ADEUDO - MONTO_DEPOSITADO) as MONTO_TOTAL_COTIZACION_ADEUDO1 FROM  02SUBETUFACTURA ".$sWhere3." and (".$query_OR2.") ";
		$query = mysqli_query($conn,$sql1);
		$fetch_arrary = mysqli_fetch_array($query);
		return $fetch_arrary['MONTO_TOTAL_COTIZACION_ADEUDO1'];
	}
	
	public function ingresarTemproal($RFC_PROVEEDOR,$MONTO_TOTAL_COTIZACION_ADEUDO,$MONTO_DEPOSITADO,$idRelacion,$balance){
		$connn=$this->db();
		$queryTemporal = 'insert into 02temporalEstadoCuenta (RFC_PROVEEDOR ,MONTO_TOTAL_COTIZACION_ADEUDO, MONTO_DEPOSITADO, idRelacion, BALANCE)values("'.$RFC_PROVEEDOR.'","'.$MONTO_TOTAL_COTIZACION_ADEUDO.'","'.$MONTO_DEPOSITADO.'","'.$idRelacion.'", "'.$balance.'");';
		mysqli_query($connn,$queryTemporal);	
	}		

	public function resultadoTemproal($idRelacion,$rfc){
		$connn=$this->db();
		$queryTemporal = 'select * from 02temporalEstadoCuenta where idRelacion = "'.$idRelacion.'" and RFC_PROVEEDOR = "'.$rfc.'" ';
		$query = mysqli_query($connn,$queryTemporal);
		$fetch_arrary = mysqli_fetch_array($query);
		return $fetch_arrary['BALANCE'];
	}

	
	public function TruncateingresarTemproal(){
		$connn=$this->db();
		$queryTemporal = 'truncate table 02temporalEstadoCuenta;';
		mysqli_query($connn,$queryTemporal);	
	}





	
	
	public function ingresarTemproal2($RFC_PROVEEDOR,$MONTO_TOTAL_COTIZACION_ADEUDO,$MONTO_DEPOSITADO,$idRelacion,$balance){
		$connn=$this->db();
		$queryTemporal = 'insert into 02temporalEstadoCuenta2 (RFC_PROVEEDOR ,MONTO_TOTAL_COTIZACION_ADEUDO, MONTO_DEPOSITADO, idRelacion, BALANCE)values("'.$RFC_PROVEEDOR.'","'.$MONTO_TOTAL_COTIZACION_ADEUDO.'","'.$MONTO_DEPOSITADO.'","'.$idRelacion.'", "'.$balance.'");';
		mysqli_query($connn,$queryTemporal);	
	}		

	public function resultadoTemproal2(){
		$connn=$this->db();
		$queryTemporal = 'select * from 02temporalEstadoCuenta2 order by RFC_PROVEEDOR, id desc; ';
		return $query = mysqli_query($connn,$queryTemporal);

	}

	
	public function TruncateingresarTemproal2(){
		$connn=$this->db();
		$queryTemporal = 'truncate table 02temporalEstadoCuenta2;';
		mysqli_query($connn,$queryTemporal);	
	}










	public function getTotalAmaunt2($rfc){
		$conn = $this->db();		
		$sWhere3  = ' where RFC_PROVEEDOR = trim("'.trim($rfc).'")  ';
		$sql1="SELECT sum(MONTO_TOTAL_COTIZACION_ADEUDO - MONTO_DEPOSITADO) as MONTO_TOTAL_COTIZACION_ADEUDO1 FROM  02temporalEstadoCuenta ".$sWhere3." ";
		$query = mysqli_query($conn,$sql1);
		$fetch_arrary = mysqli_fetch_array($query);
		return $fetch_arrary['MONTO_TOTAL_COTIZACION_ADEUDO1'];
	}

	public function getTotalAmaunt2id($rfc,$idrelacioN,$idactual){
		$query_OR = "";
		//EP2
		foreach($idrelacioN as $etiqueta => $valor){
			foreach( $valor AS $etiqueta2 => $valor2){
				if($idactual!=$valor2){
					$query_OR .= ' idRelacion = '. $valor2.' OR ';
				}
			}
		}
		if($query_OR != ''){
			$query_OR2 = substr($query_OR,0,-3);
			$query_OR3 = " and (".$query_OR2.") ";
		}else{
			return 0;
		}
		$conn = $this->db();		
		$sWhere3  = ' where RFC_PROVEEDOR = trim("'.trim($rfc).'")  ';
		$sql12="SELECT sum(MONTO_DEPOSITADO) as MONTO_DEPOSITADO1 FROM  02temporalEstadoCuenta ".$sWhere3.$query_OR3." ";
		$query2 = mysqli_query($conn,$sql12);
		$fetch_arrary2 = mysqli_fetch_array($query2);
		return $fetch_arrary2['MONTO_DEPOSITADO1'];
	}

        function setCounter($counter) {
                $this->counter = $counter;
        }
        function getCounter() {
                return $this->counter;
        }

/**
 * Determina si un colaborador puede autorizar operaciones de ventas.
 *
 * El permiso se evalúa con base en la relación de 04personal → 04altaeventos → 02SUBETUFACTURA,
 * permitiendo que los colaboradores de ventas administren únicamente los eventos en los que
 * participan.
 *
 * @param string|int $idPersonal    Identificador del colaborador (idem en sesión).
 * @param string|int|null $numeroEvento Número de evento del registro a validar. Si es null, se
 *                                      valida si el colaborador cuenta con algún evento autorizado.
 * @return bool Verdadero si el colaborador tiene autorizaAUT = 'si' para el evento solicitado.
 */
public function puedeAutorizarVentas($idPersonal, $numeroEvento = null) {
        if (empty($idPersonal)) {
                return false;
        }

        $conn = $this->db();
        $idPersonal = mysqli_real_escape_string($conn, trim($idPersonal));
        $numeroEvento = ($numeroEvento !== null) ? trim($numeroEvento) : null;

        static $columnaColaborador = null;
        if ($columnaColaborador === null) {
                $columnaColaborador = false;
                $posiblesColumnas = ['id', 'idPersonal', 'id_colaborador'];
                foreach ($posiblesColumnas as $columnaPosible) {
                        $sqlColumna = "SHOW COLUMNS FROM 04personal LIKE '".$columnaPosible."'";
                        $resultadoColumna = mysqli_query($conn, $sqlColumna);
                        if ($resultadoColumna && mysqli_num_rows($resultadoColumna) > 0) {
                                $columnaColaborador = $columnaPosible;
                                break;
                        }
                }
        }

        $eventFilter = '';
        if ($numeroEvento !== null && $numeroEvento !== '') {
                $numeroEvento = mysqli_real_escape_string($conn, $numeroEvento);
                $eventFilter = " AND ae.NUMERO_EVENTO = '".$numeroEvento."'";
        }

        if ($columnaColaborador) {
                $sqlPermiso = "
                        SELECT LOWER(p.autorizaAUT) AS autorizaAUT
                        FROM 04personal p
                        INNER JOIN 04altaeventos ae ON ae.id = p.idRelacion
                        WHERE p.`".$columnaColaborador."` = '".$idPersonal."'".$eventFilter."\n                                LIMIT 1";
                $resPermiso = mysqli_query($conn, $sqlPermiso);
                if ($resPermiso && ($rowPermiso = mysqli_fetch_assoc($resPermiso))) {
                        return $rowPermiso['autorizaAUT'] === 'si';
                }
        }

        // Fallback legado: valida únicamente por idRelacion cuando no se identificó la columna
        // del colaborador o no existe relación de eventos registrada.
        $sqlLegacy = "
                SELECT LOWER(p.autorizaAUT) AS autorizaAUT
                FROM 04personal p
                INNER JOIN 04altaeventos ae ON ae.id = p.idRelacion
                WHERE p.idRelacion = '".$idPersonal."'".$eventFilter."\n                        LIMIT 1";
        $resLegacy = mysqli_query($conn, $sqlLegacy);
        if ($resLegacy && ($rowLegacy = mysqli_fetch_assoc($resLegacy))) {
                return $rowLegacy['autorizaAUT'] === 'si';
        }

        return false;
}

}
?>