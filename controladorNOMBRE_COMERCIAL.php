<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    }

define('__ROOT1__', dirname(dirname(__FILE__)));
include_once (__ROOT1__."/includes/error_reporting.php");
include_once (__ROOT1__."/pagoproveedores/class.epcinnPP.php");
$nombre_proveedor  = NEW accesoclase();
$BUSCA_NOMBRE_COMERCIAL = isset($_POST["BUSCA_NOMBRE_COMERCIAL"])?$_POST["BUSCA_NOMBRE_COMERCIAL"]:"";
if($BUSCA_NOMBRE_COMERCIAL==true){
	$json = $nombre_proveedor->buscarNOMBRECOMERCIAL($BUSCA_NOMBRE_COMERCIAL);
	echo json_encode($json);	
}

$action = isset($_POST["action"])?$_POST["action"]:"";
$idget = isset($_POST["NOMBRE_COMERCIAL"])?$_POST["NOMBRE_COMERCIAL"]:"no";
if($action=='NOMBRE_COMERCIAL'){
	$conn = $nombre_proveedor->db();
	if($idget!='no'){
		$_SESSION['idPROV'] = $idget;
	}else{
		$_SESSION['idPROV'] = "";
	}
	$queryActualiza = "update 02SUBETUFACTURADOCTOS 
	set idRelacion = '".$idget."'
	where idRelacionU = '".$_SESSION['idempermiso']."' and 
	idTemporal = 'si' ";
	$arrayquery = mysqli_query($conn,$queryActualiza);
	
	$json = $nombre_proveedor->buscarrasonsocial($idget);
	echo $json;
}
exit;
?>