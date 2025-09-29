
<?php
/*
fecha sandor: 
fecha fatis : 05/04/2024
*/
?>



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

<div id="add_data_Modal" class="modal fade">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">

    <h4 class="modal-title">Detalles</h4>
   </div>
   <div class="modal-body" id="personal">

   </div>
   <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
   </div>
  </div>
 </div>
</div>




<div id="dataModal" class="modal fade">
 <div class="modal-dialog modal-fullscreen">
  <div class="modal-content">
   <div class="modal-header">

    <h4 class="modal-title">ACTUALIZA PAGO A PROVEEDORES</h4>
   </div>
   <div class="modal-body" id="personal_detalles">
    
   </div>
   <div class="modal-footer">
   
   <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"></button>
   
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
          <button id="btnYes" value="btnYes" class="btn confirm">SI BORRAR</button>	  
   <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
   
   </div>
  </div>
 </div>
</div>


<!--NUEVO CODIGO BORRAR-->
<div id="EFECTIVO" class="modal fade">
 <div class="modal-dialog modal-lg">
  <div class="modal-content">
   <div class="modal-header">

    <h4 class="modal-title">Detalles</h4>
   </div>
   <div class="modal-body" id="EFECTIVO">
    ¿ESTÁS SEGURO DE BORRAR ESTE REGISTRO?
   </div>
  
   <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
   
   </div>
  </div>
</div>

<!--NUEVO CODIGO BORRAR-->
<div id="dataModal4" class="modal fade">
 <div class="modal-dialog modal-lg">
  <div class="modal-content">
   <div class="modal-header">

    <h4 class="modal-title">Detalles</h4>
   </div>
   <div class="modal-body" id="personal_detalles4">
    SE HA MODIFICADO EL REGISTRO
   </div>
   <div class="modal-footer">	  
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
	            url: 'pagoproveedores/controladorPP.php',
	            contentType: false,
	            processData: false,
	            data: form_data,
 beforeSend: function() {
$('#1'+nombre).html('<p style="color:green;">Cargando archivo!</p>');
$('#mensajeADJUNTOCOL').html('<p style="color:green;">Actualizado!</p>');
    },				
	            success:function(response) {
if($.trim(response) == 2 ){
$('#1'+nombre).html('<p style="color:red;">Error, archivo diferente a PDF, JPG o GIF.</p>');
$('#'+nombre).val("");
}
else if($.trim(response) == 3 ){
	$('#1'+nombre).html('<p style="color:red;">UUID PREVIAMENTE CARGADO.</p>');
$('#'+nombre).val("");
/*nuevo inicio*/

}
else{
$('#'+nombre).val(response);
$('#1'+nombre).html('<a target="_blank" href="includes/archivos/'+$.trim(response)+'"></a>');

/*nuevo inicio*/
$("#2ADJUNTAR_FACTURA_XML").load(location.href + " #2ADJUNTAR_FACTURA_XML");
if(nombre == 'ADJUNTAR_FACTURA_XML'){
	//MONTO_FACTURA
$('#RAZON_SOCIAL2').load(location.href + ' #RAZON_SOCIAL2');
$('#RFC_PROVEEDOR2').load(location.href + ' #RFC_PROVEEDOR2');
$('#CONCEPTO_PROVEE2').load(location.href + ' #CONCEPTO_PROVEE2');
$('#TIPO_DE_MONEDA2').load(location.href + ' #TIPO_DE_MONEDA2');
$('#FECHA_DE_PAGO2').load(location.href + ' #FECHA_DE_PAGO2');
$('#NUMERO_CONSECUTIVO_PROVEE2').load(location.href + ' #NUMERO_CONSECUTIVO_PROVEE2');
$('#2MONTO_FACTURA').load(location.href + ' #2MONTO_FACTURA');
$('#2MONTO_DEPOSITAR').load(location.href + ' #2MONTO_DEPOSITAR');
$('#2PFORMADE_PAGO').load(location.href + ' #2PFORMADE_PAGO');
$('#2IVA').load(location.href + ' #2IVA');
$('#2TImpuestosRetenidosIVA').load(location.href + ' #2TImpuestosRetenidosIVA');
$('#2TImpuestosRetenidosISR').load(location.href + ' #2TImpuestosRetenidosISR');
$('#2descuentos').load(location.href + ' #2descuentos');
$('#NOMBRE_COMERCIAL2').load(location.href + ' #NOMBRE_COMERCIAL2');
}

			//$('#SUBIRFACTURAform').trigger("reset");
			$('#2'+nombre).load(location.href + ' #2'+nombre);
			$("#resettabla").load(location.href + " #resettabla");
			$.getScript(load(1));
			
			
/*nuevo final 2PFORMADE_PAGO*/

}

	            }
	        });
	    }
	}
	
	
	
function myFunction(montoapagar_id) {
  var checkBox = document.getElementById("montoapagar"+montoapagar_id);
  var montoapagar_text = "";
  if (checkBox.checked == true){
    montoapagar_text = "enter";
  } else {
     montoapagar_text = "none";
  }
  
$.ajax({
url:'pagoproveedores/fetch_pagesPP.php',
method:'POST',
data:{montoapagar_id:montoapagar_id,montoapagar_text:montoapagar_text},
beforeSend:function(){
$('#mensajemontoapagar').html('cargando');
},
success:function(data){
//$('#resetmontoapagar').html(data);
$('#montoapagartotal').load(location.href + ' #montoapagartotal');
$('#montoapagartotal2').load(location.href + ' #montoapagartotal2');
//$('#personal_detalles').html(data);
//$('#dataModal').modal('toggle');
}
});
  
}




function pasarpagado(pasarpagado_id){


	var checkBox = document.getElementById("pasarpagado1a"+pasarpagado_id);
	var pasarpagado_text = "";
	if (checkBox.checked == true){
	pasarpagado_text = "si";
	}else{
	pasarpagado_text = "no";
	}
	  $.ajax({
		url:'pagoproveedores/controladorPP.php',
		method:'POST',
		data:{pasarpagado_id:pasarpagado_id,pasarpagado_text:pasarpagado_text},
		beforeSend:function(){
		$('#pasarpagado').html('cargando');
	},
		success:function(data){
			$.getScript(load2(1));
		$('#pasarpagado').html("<span id='ACTUALIZADO' >"+data+"</span>");
	}
	});

}

//////////////////////////////////////////////////////////////////////////////////////

function comasainput(name) {
    const numberNoCommas = (x) => {
        return x.toString().replace(/,/g, "");
    }

    const numberWithCommas = (x) => {
        //return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
		const num = parseFloat(x);
		if (isNaN(num)) return '';
		return num.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    const inputElement = document.getElementsByName(name)[0];

    inputElement.addEventListener("keydown", function (e) {
        const key = e.key;
        const keyCode = e.keyCode || e.which;

        // Detectar si la tecla es numérica (teclado principal o numpad)
        const isNumberKey = 
		(keyCode >= 48 && keyCode <= 57) || 
		(keyCode >= 96 && keyCode <= 105) ||
		(keyCode === 46) ||
		(keyCode === 8 );



        if (isNumberKey) {
            setTimeout(() => {
                const originalValue = inputElement.value;
                const originalCursorPos = inputElement.selectionStart;

                const countCommasBefore = originalValue.slice(0, originalCursorPos).split(',').length - 1;

                const numericValue = numberNoCommas(originalValue);
                const formattedValue = numberWithCommas(numericValue);

                inputElement.value = formattedValue;

                let newCursorPos = originalCursorPos - countCommasBefore;
                let i = 0, charsPassed = 0;
                while (charsPassed < newCursorPos && i < formattedValue.length) {
                    if (formattedValue[i] !== ',') {
                        charsPassed++;
                    }
                    i++;
                }

                inputElement.setSelectionRange(i, i);
            }, 0);
        }
    });
}

function comasainput2(name){
    const numberNoCommas = (x) => {
        return x.toString().replace(/,/g, "");
    }

    const numberWithCommas = (x) => {
        //return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
		const num = parseFloat(x);
		if (isNaN(num)) return '';
		return num.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    const inputElement = document.getElementsByName(name)[0];

    inputElement.addEventListener("keydown", function (e) {
        const key = e.key;
        const keyCode = e.keyCode || e.which;

        // Detectar si la tecla es numérica (teclado principal o numpad)
        const isNumberKey = 
		(keyCode >= 48 && keyCode <= 57) || 
		(keyCode >= 96 && keyCode <= 105) ||
		(keyCode === 46) ||
		(keyCode === 8 );



        if (isNumberKey) {
            setTimeout(() => {
                const originalValue = inputElement.value;
                const originalCursorPos = inputElement.selectionStart;

                const countCommasBefore = originalValue.slice(0, originalCursorPos).split(',').length - 1;

                const numericValue = numberNoCommas(originalValue);
                const formattedValue = numberWithCommas(numericValue);

                inputElement.value = formattedValue;

                let newCursorPos = originalCursorPos - countCommasBefore;
                let i = 0, charsPassed = 0;
                while (charsPassed < newCursorPos && i < formattedValue.length) {
                    if (formattedValue[i] !== ',') {
                        charsPassed++;
                    }
                    i++;
                }

                inputElement.setSelectionRange(i, i);
            }, 0);
        }
    });
}

////////////////////////////////////////////////////////////////////////////////


$(document).ready(function(){





	
$("#enviarPAGOPROVEEDORES").click(function(){
	/*nuevo script pbajar archivos y datos*/
const formData = new FormData($('#pagoaproveedoresform')[0]);

$.ajax({
    url: 'pagoproveedores/controladorPP.php',
    type: 'POST',
    dataType: 'html',
    data: formData,
    cache: false,
    contentType: false,
    processData: false
}).done(function(data) {
		if($.trim(data)=='Ingresado' || $.trim(data)=='Actualizado'){
			$("#pagoaproveedoresform")[0].reset(); //resetea formulario

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
			$("#CONCEPTO_PROVEE2").load(location.href + " #CONCEPTO_PROVEE2");
			$("#2ADJUNTAR_FACTURA_XML").load(location.href + " #2ADJUNTAR_FACTURA_XML");
			$("#ADJUNTAR_FACTURA_XML").load(location.href + " #ADJUNTAR_FACTURA_XML");
			$("#1ADJUNTAR_FACTURA_XML").load(location.href + " #1ADJUNTAR_FACTURA_XML");
			$("#ADJUNTAR_FACTURA_PDF").load(location.href + " #ADJUNTAR_FACTURA_PDF");
			$("#1ADJUNTAR_FACTURA_PDF").load(location.href + " #1ADJUNTAR_FACTURA_PDF");
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
			$('#TImpuestosRetenidos').load(location.href + ' #TImpuestosRetenidos');
			$('#2TImpuestosRetenidos').load(location.href + ' #2TImpuestosRetenidos');

			$('#NOMBRE_COMERCIAL').empty().trigger("change");

			$("#mensajepagoproveedores").html("<span id='ACTUALIZADO' >"+data+"</span>").delay(2000).fadeOut();
            $('#resettabla').load(location.href + ' #resettabla');	


			$.getScript(load(1));
	

			
			}else{
			$("#mensajepagoproveedores").html(data).delay(3000).fadeOut();
		}
})
.fail(function() {
    console.log("detect error");
});
});





//SCRIPT PARA BORRAR FOTOGRAFIA BORRAR
$(document).on('click', '.view_dataSBborrar2', function(){
var borra_id_sb = $(this).attr('id');
var borrasbdoc = 'borrasbdoc';
$('#personal_detalles3').html();
$('#dataModal3').modal('show');
$('#btnYes').click(function() {
$.ajax({
url:'pagoproveedores/controladorPP.php',
method:'POST',
data:{borra_id_sb:borra_id_sb,borrasbdoc:borrasbdoc},
beforeSend:function(){
$('#mensajepagoproveedores').html('cargando');
},
success:function(data){
$('#dataModal3').modal('hide');
$('#mensajepagoproveedores').html("<span id='ACTUALIZADO' >"+data+"</span>");
$('#'+borra_id_sb).load(location.href + ' #'+borra_id_sb);
$('#A'+borra_id_sb).load(location.href + ' #A'+borra_id_sb);
}
});
});
});



//SCRIPT PARA BORRAR view_dataSBborrar
$(document).on('click', '.view_dataSBborrar', function(){
var borra_id_PAGOP = $(this).attr('id');
var borrapagoaproveedores = 'borrapagoaproveedores';
$('#personal_detalles3').html();
$('#dataModal3').modal('show');
$('#btnYes').click(function() {
$.ajax({
url:'pagoproveedores/controladorPP.php',
method:'POST',
data:{borra_id_PAGOP:borra_id_PAGOP,borrapagoaproveedores:borrapagoaproveedores},
beforeSend:function(){
$('#mensajepagoproveedores').html('cargando');
},
success:function(data){
$('#dataModal3').modal('hide');
$('#mensajepagoproveedores').html("<span id='ACTUALIZADO' >"+data+"</span>");
//$('#resetSB').load(location.href + ' #resetSB');
//$("#results").load("pagoproveedores/fetch_pagesPP.php");
			$.getScript(load(1));
		
}
});
});
});







//NOMBRE DEL BOTÓN
$(document).on('click', '.view_dataPAGOPROVEEmodifica', function(){
var personal_id = $(this).attr('id');
$.ajax({
url:'pagoproveedores/VistaPreviapagoproveedor.php',
method:'POST',
data:{personal_id:personal_id},
beforeSend:function(){
$('#mensajepagoproveedores').html('cargando');
},
success:function(data){
$('#personal_detalles').html(data);
$('#dataModal').modal('toggle');
}
});
});










//NOMBRE DEL BOTÓN
/*$(document).on('click', '.SOLICITADO', function(){
var SOLICITADO = 'SOLICITADO';
$.ajax({
url:'pagoproveedores/fetch_pagesPP.php',
method:'POST',
data:{SOLICITADO:SOLICITADO},
beforeSend:function(){
$('#mensajeSUBIRFACTURA').html('cargando');
},
success:function(data){
//$('#personal_detalles4').html(data);
//$('#dataModal4').modal('toggle');
//$("#results").load("pagoproveedores/fetch_pagesPP.php");
			$.getScript(load(1));
}
});
});



//NOMBRE DEL BOTÓN
$(document).on('click', '.APROBADO', function(){
var APROBADO = 'APROBADO';
$.ajax({
url:'pagoproveedores/fetch_pagesPP.php',
method:'POST',
data:{APROBADO:APROBADO},
beforeSend:function(){
$('#mensajeSUBIRFACTURA').html('cargando');
},
success:function(data){
//$('#personal_detalles4').html(data);
//$('#dataModal4').modal('toggle');
//$("#results").load("pagoproveedores/fetch_pagesPP.php");
			$.getScript(load(1));
}
});
});


//NOMBRE DEL BOTÓN
$(document).on('click', '.RECHAZADO', function(){
var RECHAZADO = 'RECHAZADO';
$.ajax({
url:'pagoproveedores/fetch_pagesPP.php',
method:'POST',
data:{RECHAZADO:RECHAZADO},
beforeSend:function(){
$('#mensajeSUBIRFACTURA').html('cargando');
},
success:function(data){
//$('#personal_detalles4').html(data);
//$('#dataModal4').modal('toggle');
//$("#results").load("pagoproveedores/fetch_pagesPP.php");
			$.getScript(load(1));
}
});
});

//NOMBRE DEL BOTÓN
$(document).on('click', '.PAGADO', function(){
var PAGADO = 'PAGADO';
$.ajax({
url:'pagoproveedores/fetch_pagesPP.php',
method:'POST',
data:{PAGADO:PAGADO},
beforeSend:function(){
$('#mensajeSUBIRFACTURA').html('cargando');
},
success:function(data){
//$('#personal_detalles4').html(data);
//$('#dataModal4').modal('toggle');
//$("#results").load("pagoproveedores/fetch_pagesPP.php");
			$.getScript(load(1));
}
});
});


//NOMBRE DEL BOTÓN
$(document).on('click', '.BORRAR', function(){
var BORRAR = 'BORRAR';
$.ajax({
url:'pagoproveedores/fetch_pagesPP.php',
method:'POST',
data:{BORRAR:BORRAR},
beforeSend:function(){
$('#mensajeSUBIRFACTURA').html('cargando');
},
success:function(data){
//$('#personal_detalles4').html(data);
//$('#dataModal4').modal('toggle');
//$("#results").load("pagoproveedores/fetch_pagesPP.php");
			$.getScript(load(1));
}
});
});


*/













     //DATOS resettodo //

$("#enviarDATOSBANCARIOS1").click(function(){
	/*nuevo script pbajar archivos y datos*/
const formData = new FormData($('#DATOSBANCARIOS1form')[0]);

$.ajax({
    url: 'pagoproveedores/controladorPP.php',
    type: 'POST',
    dataType: 'html',
    data: formData,
    cache: false,
    contentType: false,
    processData: false
}).done(function(data) {
		if($.trim(data)=='Ingresado' || $.trim(data)=='Actualizado'){	
		
			$("#mensajeDATOSBANCARIOS1").html("<span id='ACTUALIZADO' >"+data+"</span>");
$('#resetBancario1p').load(location.href + ' #resetBancario1p');			
			}else{
			$("#mensajeDATOSBANCARIOS1").html(data);
		}
})
.fail(function() {
    console.log("detect error");
});
});





$(document).on('click', '.view_dataNUEVO', function(){
var personal_id = $(this).attr('id');
$.ajax({
url:'pagoproveedores/VistaPreviaDatosBancario1.php',
method:'POST',
data:{personal_id:personal_id},
beforeSend:function(){
$('#mensajepagoproveedores').html('cargando');
},
success:function(data){
$('#personal_detalles2').html(data);
$('#dataModal').modal('toggle');
}
});
});



















$(document).on('click', '.view_data_bancario1p_modifica', function(){
var personal_id = $(this).attr('id');
$.ajax({
url:'pagoproveedores/VistaPreviaDatosBancario1.php',
method:'POST',
data:{personal_id:personal_id},
beforeSend:function(){
$('#mensajeDATOSBANCARIOS1').html('cargando');
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
url:'pagoproveedores/controladorPP.php',
method:'POST',
data:{borra_id_bancaP:borra_id_bancaP,borra_datos_bancario1:borra_datos_bancario1},
beforeSend:function(){
$('#mensajeREFERENCIAS').html('cargando');
},
success:function(data){
$('#dataModal3').modal('hide');
$('#mensajeDATOSBANCARIOS1').html("<span id='ACTUALIZADO' >"+data+"</span>");
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
url:'pagoproveedores/controladorPP.php',
method:'POST',
dataType: 'html',

data: dataString+{DAbancaPRO_ENVIAR_IMAIL:DAbancaPRO_ENVIAR_IMAIL},


beforeSend:function(){
$('#mensajeDATOSBANCARIOS1').html('cargando');
},
success:function(data){
$('#mensajeDATOSBANCARIOS1').html("<span id='ACTUALIZADO' >"+data+"</span>");

}
});
});


$("#enviar_NUEVO").click(function(){

const formData = new FormData($('#pagoaproveedoresform')[0]);
$.ajax({
url:'pagoproveedores/VistaPreviaNUEVOproveedor.php',
method:'POST',
data:{personal_id:personal_id},
beforeSend:function(){
$('#mensajepagoproveedores').html('cargando');
},
success:function(data){
$('#personal_detalles').html(data);
$('#dataModal').modal('toggle');
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