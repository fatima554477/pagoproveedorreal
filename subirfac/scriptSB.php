<div id="add_data_Modal" class="modal fade">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">

    <h4 class="modal-title">Detalles</h4>
   </div>
   <div class="modal-body" id="personal_detalles2">

   </div>
   <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
   </div>
  </div>
 </div>
</div>

<div id="dataModal" class="modal fade">
 <div class="modal-dialog modal-lg">
  <div class="modal-content">
   <div class="modal-header">

    <h4 class="modal-title">Detalles</h4>
   </div>
   <div class="modal-body" id="personal_detalles">
    
   </div>
   <div class="modal-footer">
   
   <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
   
   </div>
  </div>
 </div>
</div>


<!--NUEVO CODIGO extra lage-->
<div id="dataModal4" class="modal fade">
 <div class="modal-dialog modal-fullscreen" >
  <div class="modal-content">
   <div class="modal-header">

    <h4 class="modal-title">MODIFICAR</h4>
	
   </div>
   <div class="modal-body" id="personal_detalles4" STYLE="text-align: center;">
    
   </div>
   <div class="modal-footer">
   
   <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
   
   </div>
  </div>
 </div>
</div>	

<!--NUEVO CODIGO BORRAR-->
<div id="dataModal3" class="modal fade">
 <div class="modal-dialog modal-lg">
  <div class="modal-content">
   <div class="modal-header">

    <h4 class="modal-title">Detalles</h4>
   </div>
   <div class="modal-body" id="personal_detalles3">
    ¿ESTÁS SEGURO DE BORRAR ESTE REGISTRO?
   </div>
   <div class="modal-footer">
          <span id="btnYes" class="btn confirm">SI BORRAR</span>	  
   <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
   
   </div>
  </div>
 </div>
</div>





<script type="text/javascript">
	
	var fileobj;
	function upload_file(e,name) {
	    e.preventDefault();
	    fileobj = e.dataTransfer.files[0];
	    ajax_file_upload1(fileobj,name);
	}
	 
	function file_explorer(name) {
	    document.getElementsByName(name)[0].click();
	    document.getElementsByName(name)[0].onchange = function() {
	        fileobj = document.getElementsByName(name)[0].files[0];
	        ajax_file_upload1(fileobj,name);
	    };
	}

	function ajax_file_upload1(file_obj,nombre) {
	    if(file_obj != undefined) {
	        var form_data = new FormData();                  
	        form_data.append(nombre, file_obj);
	        $.ajax({
	            type: 'POST',
	            url: 'subirfactura/controladorSB.php',
	            contentType: false,
	            processData: false,
	            data: form_data,
 beforeSend: function() {
$('#1'+nombre).html('<p style="color:green;"><span class="spinner-border spinner-border-sm"></span>&nbsp;Cargando archivo...</p>');

$('#mensajeADJUNTOCOL').html('<p style="color:green;"><span class="spinner-border spinner-border-sm"></span>&nbsp;Cargando archivo...</p>');

    },				
	            success:function(response) {
var resp = $.trim(response);

if(resp.indexOf('VACIO^^') === 0){

$('#1'+nombre).html('<p style="color:red;font-weight:600;">⚠️ EL ARCHIVO ESTÁ VACÍO (0 KB). Verifica que el archivo tenga contenido antes de subirlo.</p>');

$('#'+nombre).val("");
}else if(resp.indexOf('SIN_EXTENSION^^') === 0){

$('#1'+nombre).html('<p style="color:red;font-weight:600;">⚠️ EL ARCHIVO NO TIENE EXTENSIÓN RECONOCIDA. Asegúrate de que el nombre del archivo termine en .xml, .pdf, .jpg, etc.</p>');

$('#'+nombre).val("");

}else if(resp.indexOf('ERROR_SUBIDA^^') === 0){

$('#1'+nombre).html('<p style="color:red;font-weight:600;">⚠️ ERROR AL RECIBIR EL ARCHIVO EN EL SERVIDOR. Puede que sea demasiado grande o que la conexión se haya interrumpido. Intenta de nuevo.</p>');

$('#'+nombre).val("");

}else if(resp == 2){

var exts = (nombre === 'ADJUNTAR_FACTURA_XML') ? 'XML' : (nombre === 'ADJUNTAR_FACTURA_PDF') ? 'PDF' : 'PDF, JPG, PNG, DOCX, XML, XLSX, MP4, TXT u otro formato de documento';

$('#1'+nombre).html('<p style="color:red;">⚠️ FORMATO DE ARCHIVO NO PERMITIDO. Este campo acepta únicamente archivos en formato: <strong>'+exts+'</strong>.</p>');

$('#'+nombre).val("");

}else if(resp == 1){

$('#1'+nombre).html('<p style="color:red;font-weight:600;">⚠️ ERROR AL GUARDAR EL ARCHIVO EN EL SERVIDOR. Intenta de nuevo o contacta a soporte técnico.</p>');

$('#'+nombre).val("");

}else if(resp.indexOf('3^^') === 0 || resp == 3){

var partes = resp.split('^^');

var numeroSolicitud = partes[1] ? $.trim(partes[1]) : '';

var numeroEvento = partes[2] ? $.trim(partes[2]) : '';

var detalleEvento = numeroEvento !== '' ? ' — Evento: <strong>'+numeroEvento+'</strong>' : '';

var msgDuplicado = numeroSolicitud !== '' ? '<p style="color:red;font-weight:600;">⚠️ UUID YA REGISTRADO — Se encuentra en la solicitud: <strong>'+numeroSolicitud+'</strong>'+detalleEvento+'</p>' : '<p style="color:red;font-weight:600;">⚠️ UUID PREVIAMENTE CARGADO.</p>';

$('#1'+nombre).html(msgDuplicado);

$('#'+nombre).val("");

}else if(resp.indexOf('7^^^') === 0){

var partesGasto = resp.split('^^^');

var numeroGasto = partesGasto[1] ? $.trim(partesGasto[1]) : '';

var msgGasto = numeroGasto !== '' ? '<p style="color:#C82909;font-weight:600;">⚠️ UUID YA REGISTRADO EN COMPROBACIÓN DE GASTOS — CON EL ID: <strong>'+numeroGasto+'</strong></p>' : '<p style="color:#C82909;font-weight:600;">⚠️ UUID PREVIAMENTE CARGADO EN COMPROBACIÓN DE GASTOS.</p>';

$('#1'+nombre).html(msgGasto);

$('#'+nombre).val("");

}else if(resp.indexOf('5^^') === 0){

$('#1'+nombre).html('<p style="color:red;font-weight:600;">⚠️ EL ARCHIVO XML ESTÁ VACÍO O NO CONTIENE INFORMACIÓN VÁLIDA. Verifica que sea un CFDI timbrado correctamente e inténtalo de nuevo.</p>');
$('#'+nombre).val("");



}else if(resp.indexOf('6^^') === 0){



var partesReceptor = resp.split('^^');



var receptorXML = partesReceptor[1] ? $.trim(partesReceptor[1]) : '';



var msgReceptor = receptorXML !== '' ? '⚠️ EL RECEPTOR DE LA FACTURA NO ES VÁLIDO: <strong>'+receptorXML+'</strong>. Debe ser EPC, INN o EVE520.' : '⚠️ EL RECEPTOR DE LA FACTURA NO ES EPC, INN O EVE520.';



$('#1'+nombre).html('<p style="color:red;font-weight:600;">'+msgReceptor+'</p>');

$('#'+nombre).val("");
/*nuevo inicio*/

}else{
$('#'+nombre).val(resp);

$('#1'+nombre).html('<a target="_blank" href="includes/archivos/'+resp+'"></a>');


/*nuevo inicio*/
$("#2ADJUNTAR_FACTURA_XML").load(location.href + " #2ADJUNTAR_FACTURA_XML");
if(nombre == 'ADJUNTAR_FACTURA_XML'){
$('#NUMERO_EVENTO2').load(location.href + ' #NUMERO_EVENTO2');
$('#RAZON_SOCIAL2').load(location.href + ' #RAZON_SOCIAL2');
$('#RFC_PROVEEDOR2').load(location.href + ' #RFC_PROVEEDOR2');
$('#CONCEPTO_PROVEE2').load(location.href + ' #CONCEPTO_PROVEE2');
$('#TIPO_DE_MONEDA2').load(location.href + ' #TIPO_DE_MONEDA2');
$('#FECHA_DE_PAGO2').load(location.href + ' #FECHA_DE_PAGO2');
$('#NUMERO_CONSECUTIVO_PROVEE2').load(location.href + ' #NUMERO_CONSECUTIVO_PROVEE2');
$('#2MONTO_FACTURA').load(location.href + ' #2MONTO_FACTURA');
$('#2MONTO_DEPOSITAR').load(location.href + ' #2MONTO_DEPOSITAR');
$('#2PFORMADE_PAGO').load(location.href + ' #2PFORMADE_PAGO');
$('#2TImpuestosRetenidosIVA').load(location.href + ' #2TImpuestosRetenidosIVA');
$('#2TImpuestosRetenidosISR').load(location.href + ' #2TImpuestosRetenidosISR');
$('#2descuentos').load(location.href + ' #2descuentos');
$('#2IVA').load(location.href + ' #2IVA');
}
/*nuevo final*/
			//$('#SUBIRFACTURAform').trigger("reset");
			$('#2'+nombre).load(location.href + ' #2'+nombre);
			$("#resettabla").load(location.href + " #resettabla");

}
	            }
	        });
	    }
	}
   function cuentaDver(pasarDID){

    $('.only-one').on('change', function() {
        $('.only-one').not(this).prop('checked', false);  
    });

	var checkBox = document.getElementById("cuentaD"+pasarDID);
	var pasarD_text = "";
	if (checkBox.checked == true){
	pasarD_text = "si";
	}else{
	pasarD_text = "no";
	}
	
	$.ajax({
		url:'proveedores/controladorP.php',
		method:'POST',
		data:{pasarD_text:pasarD_text,pasarDID:pasarDID},
		beforeSend:function(){
			$('#mensajeDATOSBANCARIOS12').html('cargando');
		},
		success:function(data){
			$('#mensajeDATOSBANCARIOS12').html("<span id='ACTUALIZADO' >"+data+"</span>").fadeIn().delay(2000).fadeOut(); 
			$('#resetBancario1p').load(location.href + ' #resetBancario1p');
		}
	});

}
	
	function comasainput(name){
	
const numberNoCommas = (x) => {
  return x.toString().replace(/,/g, "");
}

    var total = document.getElementsByName(name)[0].value;
	 var total2 = numberNoCommas(total)
const numberWithCommas = (x) => {
  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}	
    document.getElementsByName(name)[0].value = numberWithCommas(total2);	
}


//////////////////////////////////////////////////////////////////////////////////////

// Función reutilizable para todos los inputs
function formatearNumeros(input) {
    input.value = input.value
        .replace(/\D/g, '') // Eliminar no números
        .replace(/(\d{2})(?=\d)/g, '$1 '); // Formatear cada 2 dígitos
}

// Aplicar a todos los inputs con la clase 'formato-numero'
document.querySelectorAll('.formato-numero').forEach(input => {
    input.addEventListener('input', function(e) {
        formatearNumeros(e.target);
    });
});




function comasainput(name){
	
const numberNoCommas = (x) => {
  return x.toString().replace(/,/g, "");
}

    var total = document.getElementsByName(name)[0].value;
	 var total2 = numberNoCommas(total)
const numberWithCommas = (x) => {
  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}	
    document.getElementsByName(name)[0].value = numberWithCommas(total2);	
}

function comasainput2(name){
	
	const numberNoCommas = (x) => {
		return x.toString().replace(/,/g, "");
	}	
	var total = document.getElementsByName(name)[0].value;
	var total2 = numberNoCommas(total);
	
			var NUMERO_EVENTO=$("#NUMERO_EVENTO").val();
			
	
			
var parametros = {
			"action":"total_menos_dep",
			"numero_evento2a":NUMERO_EVENTO,
			"total_menos_depositado":total2
};

	const numberWithCommas = (x) => {
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}
	document.getElementsByName(name)[0].value = numberWithCommas(total2);	
			$("#loader").fadeIn('slow');
			$.ajax({
             url:"subirfactura/controladorSB.php",
				type: 'POST',				
				data: parametros,
				 beforeSend: function(objeto){
				$("#loader").html("Cargando...");
			  },
				success:function(data){
	document.getElementsByName('PENDIENTE_PAGO')[0].value = numberWithCommas(data);
				}
			})
		}


	
////////////////////////////////////////////////////////////////////////////////////////
function nombrecomercial(){
var RAZON_SOCIAL1 = $( "#RAZON_SOCIAL option:selected" ).val();
var RAZON_SOCIAL2 = $( "#RAZON_SOCIAL option:selected" ).text();
$.ajax({
url:"subirfactura/controladorSB.php",
method:'POST',
data:{RAZON_SOCIAL1:RAZON_SOCIAL1,RAZON_SOCIAL2:RAZON_SOCIAL2},
beforeSend:function(){
//$('#mensajeMENSAJERIA').html('cargando');
},
success:function(data){
                //var result = data.split();
				//getElementById
                $('#P_NOMBRE_COMERCIAL_EMPRESA').val(data);

		

//$("#mensajeMENSAJERIA").html("<span id='ACTUALIZADO' >"+data+"</span>");
		
}
});
}

   
$(document).ready(function(){
	
	

$(document).keydown(function(event) {
  if (event.keyCode == 27) {
	$('#dataModal').modal('hide');
	$('#add_data_Modal').modal('hide');		
	$('#dataModal4').modal('hide');
	$('#dataModal3').modal('hide');			
  }
});

$("#enviarSUBIRFACTURA").click(function(){
const scrollPositionBeforeSubmit = $(window).scrollTop();
const restoreScroll = () => {
    $(window).scrollTop(scrollPositionBeforeSubmit);
};
const numeroEventoInput = $('input[name="NUMERO_EVENTO"]');
const numeroEventoSanitizado = numeroEventoInput.val().replace(/\s+/g, '').trim();
numeroEventoInput.val(numeroEventoSanitizado);
const numeroEvento = numeroEventoSanitizado;
const prefijosNumeroEvento = ["EPC", "INN", "EVE"];

if (prefijosNumeroEvento.includes(numeroEvento.toUpperCase())) {
        $("#mensajeSUBIRFACTURA").html("<span style='color:red;'>FAVOR DE COMPLETAR EL NÚMERO DE EVENTO AGREGANDO EL NÚMERO CORRESPONDIENTE DESPUÉS DE LAS INICIALES DE LA EMPRESA.</span>").fadeIn().delay(3000).fadeOut();
        numeroEventoInput.focus();
        return;
}

const formData = new FormData($('#SUBIRFACTURAform')[0]);

$.ajax({
   url:"subirfactura/controladorSB.php",
    type: 'POST',
    dataType: 'html',
    data: formData,
    cache: false,
    contentType: false,
    processData: false
}).done(function(data) {

		if($.trim(data)=='Ingresado' || $.trim(data)=='Actualizado'){
			
			/*nuevo inicio*/

	        $("#SUBIRFACTURAform")[0].reset(); //resetea formulario
			$("#RAZON_SOCIAL").val(''); //borra valores vienen de PHP
			$("#CONCEPTO_PROVEE").val(''); //borra valores vienen de PHP
			$("#RFC_PROVEEDOR").val(''); //borra valores vienen de PHP
			$("#TIPO_DE_MONEDA").val(''); //borra valores vienen de PHP
			$("#FECHA_DE_PAGO").val(''); //borra valores vienen de PHP
			$("#NUMERO_CONSECUTIVO_PROVEE").val(''); //borra valores vienen de PHP
			$("#ADJUNTAR_FACTURA_XML").val(''); //borra valores vienen de PHP
			$("#2MONTO_FACTURA").val(''); //borra valores vienen de PHP
			$("#2MONTO_DEPOSITAR").val(''); //borra valores vienen de PHP
			$("#PFORMADE_PAGO").val(''); //borra valores vienen de PHP
			$("#2ADJUNTAR_FACTURA_PDF").val(''); //borra valores vienen de PHP
			$("#2TImpuestosRetenidos").val(''); //borra valores vienen de PHP
			
			/*reset multi imagen*/
			$("#2ADJUNTAR_FACTURA_XML").load(location.href + " #2ADJUNTAR_FACTURA_XML");
			$("#ADJUNTAR_FACTURA_XML").load(location.href + " #ADJUNTAR_FACTURA_XML");
			$("#1ADJUNTAR_FACTURA_XML").load(location.href + " #1ADJUNTAR_FACTURA_XML");
			$("#ADJUNTAR_FACTURA_PDF").load(location.href + " #ADJUNTAR_FACTURA_PDF");
			$("#1ADJUNTAR_FACTURA_PDF").load(location.href + " #1ADJUNTAR_FACTURA_PDF");
			$("#1ADJUNTAR_COTIZACION").load(location.href + " #1ADJUNTAR_COTIZACION");
			$("#1COMPROBANTE_DE_DEVOLUCION").load(location.href + " #1COMPROBANTE_DE_DEVOLUCION");
			$("#1CONPROBANTE_TRANSFERENCIA").load(location.href + " #1CONPROBANTE_TRANSFERENCIA");
			$("#1ADJUNTAR_ARCHIVO_1").load(location.href + " #1ADJUNTAR_ARCHIVO_1");
			$("#2COMPROBANTE_DE_DEVOLUCION").load(location.href + " #2COMPROBANTE_DE_DEVOLUCION");
			$("#IMPUESTO_HOSPEDAJE").load(location.href + " #IMPUESTO_HOSPEDAJE");
			$("#MONTO_PROPINA").load(location.href + " #MONTO_PROPINA");

			$("#IVA").load(location.href + " #IVA");
			$("#A").load(location.href + " #A");
			$("#2ADJUNTAR_FACTURA_PDF").load(location.href + " #2ADJUNTAR_FACTURA_PDF");
			$("#2ADJUNTAR_COTIZACION").load(location.href + " #2ADJUNTAR_COTIZACION");
			$("#2CONPROBANTE_TRANSFERENCIA").load(location.href + " #2CONPROBANTE_TRANSFERENCIA");
			$("#2ADJUNTAR_ARCHIVO_1").load(location.href + " #2ADJUNTAR_ARCHIVO_1");
			$('#NUMERO_CONSECUTIVO_PROVEE2').load(location.href + ' #NUMERO_CONSECUTIVO_PROVEE2');
			$('#2MONTO_FACTURA').load(location.href + ' #2MONTO_FACTURA');
			$('#2MONTO_DEPOSITAR').load(location.href + ' #2MONTO_DEPOSITAR');
			$('#2IVA').load(location.href + ' #2IVA');
			$('#2TImpuestosRetenidosIVA').load(location.href + ' #2TImpuestosRetenidosIVA');
			$('#TImpuestosRetenidosIVA').load(location.href + ' #TImpuestosRetenidosIVA');
			$('#2TImpuestosRetenidosISR').load(location.href + ' #2TImpuestosRetenidosISR');
			$('#TImpuestosRetenidosISR').load(location.href + ' #TImpuestosRetenidosISR');
			$('#2descuentos').load(location.href + ' #2descuentos');
			$('#descuentos').load(location.href + ' #descuentos');
			$('#NUMERO_EVENTO2').load(location.href + ' #NUMERO_EVENTO2');
			
			
			$("#mensajeSUBIRFACTURA").html("<span id='ACTUALIZADO' >"+data+"</span>").fadeIn().delay(3000).fadeOut();
            $('#resettabla').load(location.href + ' #resettabla');
			
			
			$.getScript(load(1));
			}else{
			$("#mensajeSUBIRFACTURA").html(data).fadeIn().delay(5000).fadeOut();
		}
})
.fail(function() {
    console.log("detect error");
});
});



//SCRIPT PARA BORRAR FOTOGRAFIA
$(document).on('click', '.view_dataSBborrar2', function(){
var borra_id_sb = $(this).attr('id');
var borrasbdoc = 'borrasbdoc';
$('#personal_detalles3').html();
$('#dataModal3').modal('show');
$('#btnYes').click(function() {
$.ajax({
url:'subirfactura/controladorSB.php',
method:'POST',
data:{borra_id_sb:borra_id_sb,borrasbdoc:borrasbdoc},
beforeSend:function(){
$('#mensajeSUBIRFACTURA').html('cargando');
},
success:function(data){
$('#dataModal3').modal('hide');
$('#mensajeSUBIRFACTURA').html("<span id='ACTUALIZADO' >"+data+"</span>");
$('#'+borra_id_sb).load(location.href + ' #'+borra_id_sb);
$('#A'+borra_id_sb).load(location.href + ' #A'+borra_id_sb);
}
});
});
});



//SCRIPT PARA BORRAR view_dataSBborrar
$(document).on('click', '.view_dataSBborrar', function(){
var borra_id_sb = $(this).attr('id');
var borrasb = 'borrasb';
$('#personal_detalles3').html();
$('#dataModal3').modal('show');
$('#btnYes').click(function() {
$.ajax({
url:'subirfactura/controladorSB.php',
method:'POST',
data:{borra_id_sb:borra_id_sb,borrasb:borrasb},
beforeSend:function(){
$('#mensajeSUBIRFACTURA').html('cargando');
},
success:function(data){
$('#dataModal3').modal('hide');
$('#mensajeSUBIRFACTURA').html("<span id='ACTUALIZADO' >"+data+"</span>");
//$('#resetSB').load(location.href + ' #resetSB');
	$("#results").load("subirfactura/fetch_pagesSF.php");
}
});
});
});







//NOMBRE DEL BOTÓN
$(document).on('click', '.view_dataSUBEFACTURAmodifica', function(){
var personal_id = $(this).attr('id');
$.ajax({
url:'subirfactura/VistaPreviaSubeFactura.php',
method:'POST',
data:{personal_id:personal_id},
beforeSend:function(){
$('#mensajeSUBIRFACTURA').html('cargando');
},
success:function(data){
$('#personal_detalles4').html(data);
$('#dataModal4').modal('toggle');
}
});
});





//NOMBRE DEL BOTÓN
$(document).on('click', '.SOLICITADO', function(){
var SOLICITADO = 'SOLICITADO';
$.ajax({
url:'subirfactura/fetch_pagesSF.php',
method:'POST',
data:{SOLICITADO:SOLICITADO},
beforeSend:function(){
$('#mensajeSUBIRFACTURA').html('cargando');
},
success:function(data){
//$('#personal_detalles4').html(data);
//$('#dataModal4').modal('toggle');
	$("#results").load("subirfactura/fetch_pagesSF.php");
}
});
});



//NOMBRE DEL BOTÓN
$(document).on('click', '.APROBADO', function(){
var APROBADO = 'APROBADO';
$.ajax({
url:'subirfactura/fetch_pagesSF.php',
method:'POST',
data:{APROBADO:APROBADO},
beforeSend:function(){
$('#mensajeSUBIRFACTURA').html('cargando');
},
success:function(data){
//$('#personal_detalles4').html(data);
//$('#dataModal4').modal('toggle');
	$("#results").load("subirfactura/fetch_pagesSF.php");
}
});
});


//NOMBRE DEL BOTÓN
$(document).on('click', '.RECHAZADO', function(){
var RECHAZADO = 'RECHAZADO';
$.ajax({
url:'subirfactura/fetch_pagesSF.php',
method:'POST',
data:{RECHAZADO:RECHAZADO},
beforeSend:function(){
$('#mensajeSUBIRFACTURA').html('cargando');
},
success:function(data){
//$('#personal_detalles4').html(data);
//$('#dataModal4').modal('toggle');
	$("#results").load("subirfactura/fetch_pagesSF.php");
}
});
});



//NOMBRE DEL BOTÓN
$(document).on('click', '.BORRAR', function(){
var BORRAR = 'BORRAR';
$.ajax({
url:'subirfactura/fetch_pagesSF.php',
method:'POST',
data:{BORRAR:BORRAR},
beforeSend:function(){
$('#mensajeSUBIRFACTURA').html('cargando');
},
success:function(data){
//$('#personal_detalles4').html(data);
//$('#dataModal4').modal('toggle');
	$("#results").load("subirfactura/fetch_pagesSF.php");
}
});
});


$("#clickbuscar").click(function(){
const formData = new FormData($('#buscaform')[0]);

$.ajax({
    url: 'subirfactura/fetch_pagesSF.php',
    type: 'POST',
    dataType: 'html',
    data: formData,
    cache: false,
    contentType: false,
    processData: false
})
.done(function(data) {
				
	$("#results").load("subirfactura/fetch_pagesSF.php");

})
.fail(function() {
    console.log("detect error");
});
});









     //DATOS BACANRIOS //

$("#enviarDATOSBANCARIOS1").click(function(){
	/*nuevo script pbajar archivos y datos*/
const formData = new FormData($('#DATOSBANCARIOS1form')[0]);

$.ajax({
    url: 'proveedores/controladorP.php',
    type: 'POST',
    dataType: 'html',
    data: formData,
    cache: false,
    contentType: false,
    processData: false
}).done(function(data) {
	 $('#DATOSBANCARIOS1form')[0].reset(); 
		if($.trim(data)=='Ingresado' || $.trim(data)=='Actualizado'){	
		
			$("#mensajeDATOSBANCARIOS1").html("<span id='ACTUALIZADO' >"+data+"</span>").fadeIn().delay(2000).fadeOut(); 
$('#resetBancario1p').load(location.href + ' #resetBancario1p');			
			}else{
			$("#mensajeDATOSBANCARIOS1").html(data);
		}
})
.fail(function() {
    console.log("detect error");
});
});



$(document).on('click', '.view_data_bancario1p_modifica', function(){
var personal_id = $(this).attr('id');
$.ajax({
url:'proveedores/VistaPreviaDatosBancario1.php',
method:'POST',
data:{personal_id:personal_id},
beforeSend:function(){
$('#mensajeDATOSBANCARIOS1').html('CARGANDO');
},
success:function(data){
$('#personal_detalles').html(data);
$('#dataModal').modal('toggle');
}
});
});


$(document).on('click', '.view_databancario1borrar', function(){
var borra_id_bancaP = $(this).attr('id');
var borra_datos_bancario1 = 'borra_datos_bancario1';
$('#personal_detalles3').html();
$('#dataModal3').modal('show');
$('#btnYes').click(function() {
$.ajax({
url:'proveedores/controladorP.php',
method:'POST',
data:{borra_id_bancaP:borra_id_bancaP,borra_datos_bancario1:borra_datos_bancario1},
beforeSend:function(){
$('#mensajeREFERENCIAS').html('CARGANDO');
},
success:function(data){
$('#dataModal3').modal('hide');
$('#mensajeDATOSBANCARIOS1').html("<span id='ACTUALIZADO' >"+data+"</span>").fadeIn().delay(2000).fadeOut(); 
$('#resetBancario1p').load(location.href + ' #resetBancario1p');
}
});
});
});


//SCRIPT enviar EMAIL
$(document).on('click', '#enviar_email_bancarios', function(){
var DAbancaPRO_ENVIAR_IMAIL = $('#DAbancaPRO_ENVIAR_IMAIL').val();


        var myCheckboxes = new Array();
        $("input:checked").each(function() {
           myCheckboxes.push($(this).val());
        });
var dataString = $("#form_emai_DATOSBpro").serialize();  



$.ajax({
url:'proveedores/controladorP.php',
method:'POST',
dataType: 'html',

data: dataString+{DAbancaPRO_ENVIAR_IMAIL:DAbancaPRO_ENVIAR_IMAIL},


beforeSend:function(){
$('#mensajeDATOSBANCARIOS1').html('CARGANDO');
},
success:function(data){
$('#mensajeDATOSBANCARIOS1').html("<span id='ACTUALIZADO' >"+data+"</span>").fadeIn().delay(2000).fadeOut(); 

}
});
});





///////////////////////////////////////////////////////////////



$("#GUARDAR_NOTAS").click(function(){
const formData = new FormData($('#NOTASform')[0]);

$.ajax({
url: 'INFORMACION/controladorIF.php',
    type: 'POST',
    dataType: 'html',
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
	
	 beforeSend:function(){  
    $('#mensajeNOTAS').html('cargando'); 
    },    
   success:function(data){
	
		$("#reset_NOTAS").load(location.href + " #reset_NOTAS");	
			$("#mensajeNOTAS").html("<span id='ACTUALIZADO' >"+data+"</span>");

   }
   
})
});


$(document).on('click', '.view_NOTAS', function(){
  //$('#dataModal').modal();
  var personal_id = $(this).attr("id");
  $.ajax({
url: 'INFORMACION/controladorIF.php',
   method:"POST",
   data:{personal_id:personal_id},
    beforeSend:function(){  
    $('#mensajeNOTAS').html('CARGANDO'); 
    },    
   success:function(data){
    $('#personal_detalles').html(data);
    $('#dataModal').modal('show');
   }
  });
 })



$(document).on('click', '.view_dataNOTASborrar', function(){

  var borra_notas = $(this).attr("id");
  var borra_NOTAS = "borra_NOTAS";

  //AGREGAR
    $('#personal_detalles3').html();
    $('#dataModal3').modal('show');
  $('#btnYes').click(function() {
  //AGREGAR

  
  $.ajax({
url: 'INFORMACION/controladorIF.php',
   method:"POST",
   data:{borra_notas:borra_notas,borra_NOTAS:borra_NOTAS},
   
    beforeSend:function(){  
    $('#mensajeNOTAS').html('CARGANDO'); 
    },    
   success:function(data){
	   			$('#dataModal3').modal('hide');	   
			$("#mensajeNOTAS").html("<span id='ACTUALIZADO' >"+data+"</span>");			
			$("#reset_NOTAS").load(location.href + " #reset_NOTAS");
   }
  });
  
    //AGREGAR	
	});
  //AGREGAR	 
  
 });		

/////////////////////SCRIPT enviar EMAIL//////
$(document).on('click', '#BUTTON_NOTAS', function(){
var EMAIL_NOTAS = $('#EMAIL_NOTAS').val();


        var myCheckboxes = new Array();
        $("input:checked").each(function() {
           myCheckboxes.push($(this).val());
        });
var dataString = $("#form_emil_NOTAS").serialize();

$.ajax({
url: 'INFORMACION/controladorIF.php',
method:'POST',
dataType: 'html',

data: dataString+{EMAIL_NOTAS:EMAIL_NOTAS},


beforeSend:function(){
$('#mensajeNOTAS').html('cargando');
},
success:function(data){
$('#mensajeNOTAS').html("<span id='ACTUALIZADO' >"+data+"</span>");

}
});
});


  //////////////////NUEVO DOCUMENTO//////////////////////////////////////////////////////////////////////////


$(document).on('click', '.view_dataNUEVOdocumento', function(){
  //$('#dataModal').modal();
  var personal_id = $(this).attr("id");
  $.ajax({
   url:"proveedores/VistaPreviaNUEVODOCU.php",
   method:"POST",
   data:{personal_id:personal_id},
    beforeSend:function(){  
    $('#mensajeDOCUnuevo').html('CARGANDO'); 
    },    
   success:function(data){
    $('#personal_detalles').html(data);
    $('#dataModal').modal('show');
   }
  });
 });

$(document).on('click', '.view_databorraNUEVOdocumento', function(){

  var borra_id_NUEVOD = $(this).attr("id");
  var BORRARNUEVOFISCAL = "BORRARNUEVOFISCAL";

  //AGREGAR
    $('#personal_detalles3').html();
    $('#dataModal3').modal('show');
  $('#btnYes').click(function() {
  //AGREGAR

  
  $.ajax({
   url:"subirfactura/controladorSB.php",
   method:"POST",
   data:{borra_id_NUEVOD:borra_id_NUEVOD,BORRARNUEVOFISCAL:BORRARNUEVOFISCAL},
   
    beforeSend:function(){  
    $('#mensajeDOCUnuevo').html('CARGANDO'); 
    },    
   success:function(data){
	   			$('#dataModal3').modal('hide');	   
			$("#mensajeDOCUnuevo").html("<span id='ACTUALIZADO' >"+data+"</span>").fadeIn().delay(2000).fadeOut(); 			
			$("#reseteateNUEVO").load(location.href + " #reseteateNUEVO");
   }
  });
  
    //AGREGAR	
	});
  //AGREGAR	 
  
 });


$("#enviarNUEVOdocu").click(function(){

const formData = new FormData($('#DOCUMENTONUEVOform')[0]);

$.ajax({
   url:"subirfactura/controladorSB.php",
    type: 'POST',
    dataType: 'html',
    data: formData,
    cache: false,
    contentType: false,
    processData: false
}).done(function(data) {

		if($.trim(data)=='Ingresado' || $.trim(data)=='Actualizado'){	

			$("#documentoslegales1a12").load(location.href + " #documentoslegales1a12");
			$("#reseteateNUEVO").load(location.href + " #reseteateNUEVO");			
			$("#mensajeDOCUnuevo").html("<span id='ACTUALIZADO' >"+data+"</span>").fadeIn().delay(2000).fadeOut(); 
			}else{
			$("#mensajeDOCUnuevo").html(data);
		}
})
.fail(function() {
    console.log("detect error");
});
});



//*DOCUMENTOS FISCALES DEL PROVEEDOR*/ //////////////////////////////////////////////////////////////////





$(document).on('click', '.view_datadocufiscalmodifica', function(){

  var personal_id = $(this).attr("id");
  $.ajax({
   url:"proveedores/VistaPreviaDOCUMENTOfiscal.php",
   method:"POST",
   data:{personal_id:personal_id},
    beforeSend:function(){  
    $('#mensajeDOCUFISCAL').html('CARGANDO'); 
    },    
   success:function(data){
    $('#personal_detalles').html(data);
    $('#dataModal').modal('show');
   }
  });
 });

$(document).on('click', '.view_datadocufiscalborrar', function(){
 
  var borra_id_FISCAL = $(this).attr("id");
  var borradocufiscal = "borradocufiscal";


    $('#personal_detalles3').html();
    $('#dataModal3').modal('show');
  $('#btnYes').click(function() {
  //AGREGAR

  
  $.ajax({
   url:"subirfactura/controladorSB.php",
   method:"POST",
   data:{borra_id_FISCAL:borra_id_FISCAL,borradocufiscal:borradocufiscal},
   
    beforeSend:function(){  
    $('#mensajeDOCUFISCAL').html('CARGANDO'); 
    },    
   success:function(data){
	   			$('#dataModal3').modal('hide');	   
			$("#mensajeDOCUFISCAL").html("<span id='ACTUALIZADO' >"+data+"</span>").fadeIn().delay(2000).fadeOut(); 			
			$("#resetedocufiscal").load(location.href + " #resetedocufiscal");
   }
  });
    //AGREGAR	
	});
  //AGREGAR	 
  
 });



$("#enviarDOCUMENTOSFISCALES").click(function(){
	/*nuevo script pbajar archivos y datos*/
const formData = new FormData($('#DOCUFISCALform')[0]);

$.ajax({
   url:"subirfactura/controladorSB.php",
    type: 'POST',
    dataType: 'html',
    data: formData,
    cache: false,
    contentType: false,
    processData: false
}).done(function(data) {

		if($.trim(data)=='Ingresado' || $.trim(data)=='Actualizado'){	
			$("#DOCUFISCALform")[0].reset();
			$("#resetedocufiscal").load(location.href + " #resetedocufiscal");
			$("#mensajeDOCUFISCAL").html("<span id='ACTUALIZADO' >"+data+"</span>").fadeIn().delay(2000).fadeOut(); 
			}else{
			$("#mensajeDOCUFISCAL").html(data).fadeIn().delay(2000).fadeOut(); 
		}
})
.fail(function() {
    console.log("detect error");
});
});

//SCRIPT enviar EMAIL //
$(document).on('click', '#enviar_email_DOCUFISCAL', function(){
var ENVIAR_EMAIL_DOCUFISCAL = $('#ENVIAR_EMAIL_DOCUFISCAL').val();


        var myCheckboxes = new Array();
        $("input:checked").each(function() {
           myCheckboxes.push($(this).val());
        });
var dataString = $("#form_emai_docuFISCAL").serialize();



$.ajax({
url:'subirfactura/controladorSB.php',
method:'POST',
dataType: 'html',

data: dataString+{ENVIAR_EMAIL_DOCUFISCAL:ENVIAR_EMAIL_DOCUFISCAL},


beforeSend:function(){
$('#mensajeDOCUFISCAL').html('CARGANDO');
},
success:function(data){
$('#mensajeDOCUFISCAL').html("<span id='ACTUALIZADO' >"+data+"</span>").fadeIn().delay(2000).fadeOut(); 

}
});
});












			$('#target1').hide("linear");
			$('#target2').hide("linear");
			$('#target3').hide("linear");
			$('#target4').hide("linear");
			$('#target5').hide("linear");
			$('#target6').hide("linear");
			$('#target7').hide("linear");
			$('#target8').hide("linear");
			$('#target9').hide("linear");
			$('#target10').hide("linear");
			$('#target11').hide("linear");
			$('#target12').hide("linear");
			$('#target13').hide("linear");
			$('#target14').hide("linear");
			$('#target15').hide("linear");
			$('#targetVIDEO').hide("linear");
			
			$("#mostrar1").click(function(){
				$('#target1').show("swing");
		 	});
			$("#ocultar1").click(function(){
				$('#target1').hide("linear");
			});
			$("#mostrar2").click(function(){
				$('#target2').show("swing");
		 	});
			$("#ocultar2").click(function(){
				$('#target2').hide("linear");
			});
			$("#mostrar3").click(function(){
				$('#target3').show("swing");
		 	});
			$("#ocultar3").click(function(){
				$('#target3').hide("linear");
			});
			$("#mostrar4").click(function(){
				$('#target4').show("swing");
		 	});
			$("#ocultar4").click(function(){
				$('#target4').hide("linear");
			});
			$("#mostrar5").click(function(){
				$('#target5').show("swing");
		 	});
			$("#ocultar5").click(function(){
				$('#target5').hide("linear");
			});
			$("#mostrar6").click(function(){
				$('#target6').show("swing");
		 	});
			$("#ocultar6").click(function(){
				$('#target6').hide("linear");
			});
			$("#mostrar7").click(function(){
				$('#target7').show("swing");
		 	});
			$("#ocultar7").click(function(){
				$('#target7').hide("linear");
			});
			$("#mostrar8").click(function(){
				$('#target8').show("swing");
		 	});
			$("#ocultar8").click(function(){
				$('#target8').hide("linear");
			});
			$("#mostrar9").click(function(){
				$('#target9').show("swing");
		 	});
			$("#ocultar9").click(function(){
				$('#target9').hide("linear");
			});
			$("#mostrar10").click(function(){
				$('#target10').show("swing");
		 	});
			$("#ocultar10").click(function(){
				$('#target10').hide("linear");
			});
			$("#mostrar11").click(function(){
				$('#target11').show("swing");
		 	});
			$("#ocultar11").click(function(){
				$('#target11').hide("linear");
			});
			$("#mostrar12").click(function(){
				$('#target12').show("swing");
		 	});
			$("#ocultar12").click(function(){
				$('#target12').hide("linear");
			});
			$("#mostrar13").click(function(){
				$('#target13').show("swing");
		 	});
			$("#ocultar13").click(function(){
				$('#target13').hide("linear");
			});

			$("#mostrar14").click(function(){
				$('#target14').show("swing");
		 	});
			$("#ocultar14").click(function(){
				$('#target14').hide("linear");
			});
			
			$("#mostrar15").click(function(){
				$('#target15').show("swing");
		 	});
			$("#ocultar15").click(function(){
				$('#target15').hide("linear");
			});




			$("#mostrarVIDEO").click(function(){
				$('#targetVIDEO').show("swing");
		 	});
			$("#ocultarVIDEO").click(function(){
				$('#targetVIDEO').hide("linear");
			});

			$("#mostrartodos").click(function(){
				$('#target1').show("swing");
				$('#target2').show("swing");
				$('#target3').show("swing");
				$('#target4').show("swing");
				$('#target5').show("swing");
				$('#target6').show("swing");
				$('#target7').show("swing");
				$('#target8').show("swing");
				$('#target9').show("swing");
				$('#target10').show("swing");
				$('#target11').show("swing");
				$('#target12').show("swing");
				$('#target13').show("swing");
				$('#target14').show("swing");
				$('#target15').show("swing");
				$('#targetVIDEO').show("swing");
		 	});
			
			$("#ocultartodos").click(function(){
				$('#target1').hide("linear");
				$('#target2').hide("linear");	
				$('#target3').hide("linear");
				$('#target4').hide("linear");
				$('#target5').hide("linear");
				$('#target6').hide("linear");
				$('#target7').hide("linear");
				$('#target8').hide("linear");
				$('#target9').hide("linear");
				$('#target10').hide("linear");
				$('#target11').hide("linear");
				$('#target12').hide("linear");
				$('#target13').hide("linear");
				$('#target14').hide("linear");
				$('#target15').hide("linear");
				$('#targetVIDEO').hide("linear");
			});

		});
	</script>