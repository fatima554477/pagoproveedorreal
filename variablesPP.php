<?php 
$ROWdatoscolaborador3a = $pagoproveedores->variable_DIRECCIONP1();



$numero_evento_get = isset($_GET['num_evento'])?urldecode($_GET['num_evento']):'';
if($numero_evento_get!=''){
$NOMBRE_EVENTO_get = $pagoproveedores->buscarnombre($numero_evento_get);
}

