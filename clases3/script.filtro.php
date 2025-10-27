
<style>
/* Loader con animación */
.loader {
  border: 4px solid #f3f3f3;
  border-top: 4px solid #6a0dad; /* Morado elegante */
  border-radius: 50%;
  width: 22px;
  height: 22px;
  animation: spin 1s linear infinite;
  display: inline-block;
  vertical-align: middle;
  margin-right: 8px;
}

@keyframes spin {
  0%   { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* Texto estilizado */
.msg-actualizando {
  font-weight: bold;
  font-size: 20px;
  color: #6a0dad;
  background: #f3e9fb;
  border-radius: 6px;
  padding: 6px 12px;
  display: inline-flex;
  align-items: center;
  box-shadow: 0px 2px 6px rgba(0,0,0,0.1);
}
</style>
<script>



	function pasarpagado2(pasarpagado_id){


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
		$('#pasarpagado2').html('cargando');
	},
		success:function(data){
			load(1);
			
		var result = data.split('^');			
		$('#pasarpagado2').html("<span id='ACTUALIZADO' >"+result[0]+"</span>");
		
		
		if(pasarpagado_text=='si'){
		$('#color_pagado1a'+pasarpagado_id).css('background-color', '#ceffcc');
		}
		if(pasarpagado_text=='no'){
		$('#color_pagado1a'+pasarpagado_id).css('background-color', '#e9d8ee');
		}		
		
	}
	});
}


function STATUS_CHECKBOX(CHECKBOX_id, permisoModificar) {
    var checkBox = document.getElementById("STATUS_CHECKBOX" + CHECKBOX_id);
    var CHECKBOX_text = checkBox.checked ? "si" : "no";

    // Cambiar color visual inmediato (optimista)
    var newColor = checkBox.checked ? '#ceffcc' : '#e9d8ee';
    $('#color_CHECKBOX' + CHECKBOX_id).css('background-color', newColor);

    let monto = $('#montoOriginal_' + CHECKBOX_id).text().replace(/,/g, '');
    
    // Bloqueo inmediato si se activa sin permiso
    if (checkBox.checked && !permisoModificar) {
        setTimeout(() => {
            checkBox.disabled = true;
        }, 100);
    }

    // Actualizar el valor calculado en la interfaz inmediatamente
    if (checkBox.checked) {
        $('#valorCalculado_' + CHECKBOX_id).text('');
    } else {
        if (!isNaN(monto)) {
            let resultado = monto * 1.46;
            let resultadoFormateado = resultado.toLocaleString('es-MX', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
            $('#valorCalculado_' + CHECKBOX_id).text('$' + resultadoFormateado);
        } else {
            $('#valorCalculado_' + CHECKBOX_id).text('NaN');
        }
    }

    // Enviar actualización al servidor
    $.ajax({
        url: 'pagoproveedores/controladorPP.php',
        method: 'POST',
        data: { 
            CHECKBOX_id: CHECKBOX_id,
            CHECKBOX_text: CHECKBOX_text 
        },
        beforeSend: function() {
            $('#ajax-notification')
                .html('<div class="loader"></div> ⏳ ACTUALIZANDO...')
                .fadeIn();
        },
        success: function(data) {
            var result = data.split('^'); // ejemplo de retorno: "ok^si" o "ok^no"

            // Mostrar notificación de éxito
            $('#ajax-notification')
                .html("✅ ACTUALIZADO")
                .delay(1000)
                .fadeOut();

            // Validar respuesta del servidor
            if (result[1] === 'si') {
                $('#color_CHECKBOX' + CHECKBOX_id).css('background-color', '#ceffcc');
                $('#valorCalculado_' + CHECKBOX_id).text('');
                
                // Bloquear después de confirmación si no hay permiso
                if (!permisoModificar) {
                    checkBox.disabled = true;
                }
            } else if (result[1] === 'no') {
                $('#color_CHECKBOX' + CHECKBOX_id).css('background-color', '#e9d8ee');
                
                if (!isNaN(monto)) {
                    let resultado = monto * 1.46;
                    let resultadoFormateado = resultado.toLocaleString('es-MX', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                    $('#valorCalculado_' + CHECKBOX_id).text('$' + resultadoFormateado);
                } else {
                    $('#valorCalculado_' + CHECKBOX_id).text('NaN');
                }
                
                // Re-habilitar si falló el guardado
                checkBox.disabled = false;
            }
        },
        error: function() {
            // Revertir el cambio si ocurre un error
            checkBox.checked = !checkBox.checked;
            let originalColor = checkBox.checked ? '#ceffcc' : '#e9d8ee';
            $('#color_CHECKBOX' + CHECKBOX_id).css('background-color', originalColor);
            
            // Re-habilitar en caso de error
            checkBox.disabled = false;

            $('#ajax-notification')
                .html("❌ Error al actualizar")
                .delay(2000)
                .fadeOut();
        }
    });
    recalcularTotal();
}


function recalcularTotal() {
    let total = 0;

    $('[id^=valorCalculado_]').each(function() {
        let texto = $(this).text().replace(/[$,]/g, ''); // quitar $ y ,
        let valor = parseFloat(texto);
        if (!isNaN(valor)) {
            total += valor;
        }
    });

    let totalFormateado = total.toLocaleString('es-MX', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
    $('#totalCalculado').text('$' + totalFormateado);
}






	function STATUS_RESPONSABLE_EVENTO(RESPONSABLE_EVENTO_id){


	var checkBox = document.getElementById("STATUS_RESPONSABLE_EVENTO"+RESPONSABLE_EVENTO_id);
	var RESPONSABLE_text = "";
	if (checkBox.checked == true){
	RESPONSABLE_text = "si";
	}else{
	RESPONSABLE_text = "no";
	}
	  $.ajax({
		url:'pagoproveedores/controladorPP.php',
		method:'POST',
		data:{RESPONSABLE_EVENTO_id:RESPONSABLE_EVENTO_id,RESPONSABLE_text:RESPONSABLE_text},
		beforeSend:function(){
		$('#pasarpagado2').html('cargando');
	},
		success:function(data){
		var result = data.split('^');				
		$('#pasarpagado2').html("<span id='ACTUALIZADO' >"+result[0]+"</span>");
		load(1);
		
		if(result[1]=='si'){
		$('#color_RESPONSABLE_EVENTO'+RESPONSABLE_EVENTO_id).css('background-color', '#ceffcc');
		}
		if(result[1]=='no'){
		$('#color_RESPONSABLE_EVENTO'+RESPONSABLE_EVENTO_id).css('background-color', '#e9d8ee');
		}
		
	}
	});
}






	function STATUS_AUDITORIA1(AUDITORIA1_id){


	var checkBox = document.getElementById("STATUS_AUDITORIA1"+AUDITORIA1_id);
	var AUDITORIA1_text = "";
	if (checkBox.checked == true){
	AUDITORIA1_text = "si";
	}else{
	AUDITORIA1_text = "no";
	}

	  $.ajax({
		url:'pagoproveedores/controladorPP.php',
		method:'POST',
		data:{AUDITORIA1_id:AUDITORIA1_id,AUDITORIA1_text:AUDITORIA1_text},
		beforeSend:function(){
		$('#STATUS_AUDITORIA1').html('cargando');
	},
		success:function(data){
		var result = data.split('^');				
		$('#STATUS_AUDITORIA1').html("ACTUALIZADO").fadeIn().delay(1000).fadeOut();
		load(1);
		

		if(result[1]=='si'){
		$('#color_AUDITORIA1'+AUDITORIA1_id).css('background-color', '#ceffcc');
		}
		if(result[1]=='no'){
		$('#color_AUDITORIA1'+AUDITORIA1_id).css('background-color', '#e9d8ee');
		}
	   	
		
	}
	});
}











	function STATUS_AUDITORIA2(AUDITORIA2_id){
	

	var checkBox = document.getElementById("STATUS_AUDITORIA2"+AUDITORIA2_id);
	var AUDITORIA2_text = "";
	if (checkBox.checked == true){
	AUDITORIA2_text = "si";
	}else{
	AUDITORIA2_text = "no";
	}
	  $.ajax({
		url:'pagoproveedores/controladorPP.php',
		method:'POST',
		data:{AUDITORIA2_id:AUDITORIA2_id,AUDITORIA2_text:AUDITORIA2_text},
		beforeSend:function(){
		$('#pasarpagado2').html('cargando');
	},
		success:function(data){
		var result = data.split('^');				
		$('#pasarpagado2').html("Cargando...").fadeIn().delay(500).fadeOut();
		load(1);

		if(result[1]=='si'){
		$('#color_AUDITORIA2'+AUDITORIA2_id).css('background-color', '#ceffcc');
		}
		if(result[1]=='no'){
		$('#color_AUDITORIA2'+AUDITORIA2_id).css('background-color', '#e9d8ee');
		}		
		
	}
	});
}



	function STATUS_FINANZAS(FINANZAS_id){


	var checkBox = document.getElementById("STATUS_FINANZAS"+FINANZAS_id);
	var FINANZAS_text = "";
	if (checkBox.checked == true){
	FINANZAS_text = "si";
	}else{
	FINANZAS_text = "no";
	}
	  $.ajax({
		url:'pagoproveedores/controladorPP.php',
		method:'POST',
		data:{FINANZAS_id:FINANZAS_id,FINANZAS_text:FINANZAS_text},
		beforeSend:function(){
		$('#pasarpagado2').html('cargando');
	},
		success:function(data){
		var result = data.split('^');				
		$('#pasarpagado2').html("Cargando...").fadeIn().delay(500).fadeOut();
		load(1);
		
		if(result[1]=='si'){
		$('#color_FINANZAS'+FINANZAS_id).css('background-color', '#ceffcc');
		}
		if(result[1]=='no'){
		$('#color_FINANZAS'+FINANZAS_id).css('background-color', '#e9d8ee');
		}		
		
	}
	});
}

	function STATUS_VENTAS(VENTAS_id){
	

	var checkBox = document.getElementById("STATUS_VENTAS"+VENTAS_id);
	var VENTAS_text = "";
	if (checkBox.checked == true){
	VENTAS_text = "si";
	}else{
	VENTAS_text = "no";
	}
	  $.ajax({
		url:'pagoproveedores/controladorPP.php',
		method:'POST',
		data:{VENTAS_id:VENTAS_id,VENTAS_text:VENTAS_text},
		beforeSend:function(){
		$('#pasarpagado2').html('cargando');
	},
		success:function(data){
		var result = data.split('^');				
		$('#pasarpagado2').html("Cargando...").fadeIn().delay(500).fadeOut();
		load(1);
		
		if(result[1]=='si'){
		$('#color_VENTAS'+VENTAS_id).css('background-color', '#ceffcc');
		}
		if(result[1]=='no'){
		$('#color_VENTAS'+VENTAS_id).css('background-color', '#e9d8ee');
		}		
		
	}
	});
}



function LIMPIAR(){

 $("#UUID").val("");
 $("#metodoDePago").val("");
 $("#totalf").val("");
 $("#serie").val("");
 $("#folio").val("");
 $("#regimenE").val("");
 $("#UsoCFDI").val("");
 $("#TImpuestosTrasladados").val("");
 $("#TImpuestosRetenidos").val("");
 $("#Version").val("");
 $("#tipoDeComprobante").val("");
 $("#condicionesDePago").val("");
 $("#fechaTimbrado").val("");
 $("#nombreR").val("");
 $("#rfcR").val("");
 $("#Moneda").val("");
 $("#TipoCambio").val("");
 $("#ValorUnitarioConcepto").val("");
 $("#DescripcionConcepto").val("");
 $("#ClaveUnidadConcepto").val("");
 $("#ClaveProdServConcepto").val("");
 $("#CantidadConcepto").val("");
 $("#ImporteConcepto").val("");
 $("#UnidadConcepto").val("");
 $("#TUA").val("");
 $("#TuaTotalCargos").val("");
 $("#Descuento").val("");
 $("#ID_RELACIONADO").val("");
  $("#IVA").val("");
 $("#IEPS").val("");
$("#NUMERO_CONSECUTIVO_PROVEE_2").val("");
$("#NOMBRE_COMERCIAL_2").val("");
$("#RAZON_SOCIAL_2").val("");
$("#RFC_PROVEEDOR_2").val("");
$("#NUMERO_EVENTO_2").val("");
$("#NOMBRE_EVENTO_2").val("");
$("#MOTIVO_GASTO_2").val("");
$("#CONCEPTO_PROVEE_2").val("");
$("#MONTO_TOTAL_COTIZACION_ADEUDO_2").val("");
$("#MONTO_FACTURA_2").val("");
$("#MONTO_PROPINA_2").val("");
$("#MONTO_DEPOSITAR_2").val("");
$("#TIPO_DE_MONEDA_2").val("");
$("#PFORMADE_PAGO_2").val("");
$("#ID_RELACIONADO_2").val("");

$("#FECHA_DE_PAGO").val("");
$("#FECHA_DE_PAGO2a").val("");

$("#FECHA_A_DEPOSITAR_2").val("");
 $("#STATUS_DE_PAGO_2").val("");
 $("#ACTIVO_FIJO_2").val("");
 $("#GASTO_FIJO_2").val("");
 $("#PAGAR_CADA_2").val("");
 $("#FECHA_PPAGO_2").val("");
 $("#FECHA_TPROGRAPAGO_2").val("");
 $("#NUMERO_EVENTOFIJO_2").val("");
 $("#CLASI_GENERAL_2").val("");
 $("#SUB_GENERAL_2").val("");
 $("#MONTO_DEPOSITADO_2").val("");
 $("#NUMERO_EVENTO1_2").val("");
 $("#CLASIFICACION_GENERAL_2").val("");
 $("#CLASIFICACION_ESPECIFICA_2").val("");
 $("#PLACAS_VEHICULO_2").val("");
 $("#MONTO_DE_COMISION_2").val("");
 $("#POLIZA_NUMERO_2").val("");
 $("#NOMBRE_DEL_EJECUTIVO_2").val("");
 $("#NOMBRE_DEL_AYUDO_2").val("");
 $("#OBSERVACIONES_2").val("");
 $("#FECHA_DE_LLENADO_2").val("");
 $("#subTotal11").val("");
 $("#TIPO_CAMBIOP").val("");
 $("#TOTAL_ENPESOS").val("");
 $("#IMPUESTO_HOSPEDAJE").val("");
 $("#propina").val("");
  $("#IVAXML").val("");
 $("#IEPSXML").val("");
 /////////////////tarjeta///////////////////
  $("#P_TIPO_DE_MONEDA_1").val("");
  $("#P_INSTITUCION_FINANCIERA_1").val("");
  $("#P_NUMERO_DE_CUENTA_DB_1").val("");
  $("#P_NUMERO_CLABE_1").val("");
  $("#P_NUMERO_IBAN_1").val("");
  $("#P_NUMERO_CUENTA_SWIFT_1").val("");
  $("#FOTO_ESTADO_PROVEE").val("");
  $("#ULTIMA_CARGA_DATOBANCA").val("");
  $("#TImpuestosRetenidos").val("");

 
 
}


        $(function() {
                const triggerSearch = () => load(1);

                $('#target5').on('keydown', 'thead input, thead select', function(event) {
                        if (event.key === 'Enter' || event.which === 13) {
                                event.preventDefault();
                                triggerSearch();
                        }
                });

                load(1);
        });
		
		
		
		function load(page){
			var query=$("#NOMBRE_EVENTO").val();
			var DEPARTAMENTO2=$("#DEPARTAMENTO2WE").val();
			
			
			
			var NUMERO_CONSECUTIVO_PROVEE=$("#NUMERO_CONSECUTIVO_PROVEE_2").val();
var NOMBRE_COMERCIAL=$("#NOMBRE_COMERCIAL_2").val();
var VIATICOSOPRO=$("#VIATICOSOPRO_2").val();
var RAZON_SOCIAL=$("#RAZON_SOCIAL_2").val();
var RFC_PROVEEDOR=$("#RFC_PROVEEDOR_2").val();
var NUMERO_EVENTO=$("#NUMERO_EVENTO_2").val();
var NOMBRE_EVENTO=$("#NOMBRE_EVENTO_2").val();
var MOTIVO_GASTO=$("#MOTIVO_GASTO_2").val();
var CONCEPTO_PROVEE=$("#CONCEPTO_PROVEE_2").val();
var MONTO_TOTAL_COTIZACION_ADEUDO=$("#MONTO_TOTAL_COTIZACION_ADEUDO_2").val();
var MONTO_FACTURA=$("#MONTO_FACTURA_2").val();
var MONTO_PROPINA=$("#MONTO_PROPINA_2").val();
var MONTO_DEPOSITAR=$("#MONTO_DEPOSITAR_2").val();
var MONTO_DEPOSITADO=$("#MONTO_DEPOSITADO_2").val();
var TIPO_DE_MONEDA=$("#TIPO_DE_MONEDA_2").val();
var PFORMADE_PAGO=$("#PFORMADE_PAGO_2").val();

var FECHA_DE_PAGO=$("#FECHA_DE_PAGO").val();
var FECHA_DE_PAGO2a=$("#FECHA_DE_PAGO2a").val();

var FECHA_A_DEPOSITAR=$("#FECHA_A_DEPOSITAR_2").val();
var STATUS_DE_PAGO=$("#STATUS_DE_PAGO_2").val();
var ACTIVO_FIJO=$("#ACTIVO_FIJO_2").val();
var GASTO_FIJO=$("#GASTO_FIJO_2").val();
var PAGAR_CADA=$("#PAGAR_CADA_2").val();
var FECHA_PPAGO=$("#FECHA_PPAGO_2").val();
var FECHA_TPROGRAPAGO=$("#FECHA_TPROGRAPAGO_2").val();
var NUMERO_EVENTOFIJO=$("#NUMERO_EVENTOFIJO_2").val();
var CLASI_GENERAL=$("#CLASI_GENERAL_2").val();
var SUB_GENERAL=$("#SUB_GENERAL_2").val();
var NUMERO_EVENTO1=$("#NUMERO_EVENTO1_2").val();
var CLASIFICACION_GENERAL=$("#CLASIFICACION_GENERAL_2").val();
var CLASIFICACION_ESPECIFICA=$("#CLASIFICACION_ESPECIFICA_2").val();
var PLACAS_VEHICULO=$("#PLACAS_VEHICULO_2").val();
var MONTO_DE_COMISION=$("#MONTO_DE_COMISION_2").val();
var POLIZA_NUMERO=$("#POLIZA_NUMERO_2").val();
var NOMBRE_DEL_EJECUTIVO=$("#NOMBRE_DEL_EJECUTIVO_2").val();
var NOMBRE_DEL_AYUDO=$("#NOMBRE_DEL_AYUDO_2").val();
var OBSERVACIONES_2=$("#OBSERVACIONES_1_2").val();
var FECHA_DE_LLENADO=$("#FECHA_DE_LLENADO_2").val();
var hiddenpagoproveedores=$("#hiddenpagoproveedores_2").val();
var RAZON_SOCIAL_orden=$("#RAZON_SOCIAL_orden").val();
var RFC_PROVEEDOR_orden=$("#RFC_PROVEEDOR_orden").val();
var MONTO_FACTURA_orden=$("#MONTO_FACTURA_orden").val();
var TIPO_CAMBIOP=$("#TIPO_CAMBIOP").val();
var TOTAL_ENPESOS=$("#TOTAL_ENPESOS").val();
var IMPUESTO_HOSPEDAJE=$("#IMPUESTO_HOSPEDAJE").val();
var ID_RELACIONADO=$("#ID_RELACIONADO").val();
var IVA=$("#IVA_1").val();
var IEPS=$("#IEPS").val();
var FECHA_DE_PAGO=$("#FECHA_DE_PAGO").val();
var FECHA_DE_PAGO2a=$("#FECHA_DE_PAGO2a").val();
var TImpuestosRetenidosIVA=$("#TImpuestosRetenidosIVA_3").val();
var TImpuestosRetenidosISR=$("#TImpuestosRetenidosISR_3").val();
var descuentos=$("#descuentos_3").val();

var NUMERO_EVENTO_orden=$("#NUMERO_EVENTO_orden").val();

var UUID=$("#UUID_1").val();
var metodoDePago=$("#metodoDePago_1").val();
var totalf=$("#totalf_1").val();
var serie=$("#serie_1").val();
var folio=$("#folio_1").val();
var regimenE=$("#regimenE_1").val();
var UsoCFDI=$("#UsoCFDI_1").val();
var TImpuestosTrasladados=$("#TImpuestosTrasladados_1").val();
var TImpuestosRetenidos=$("#TImpuestosRetenidos_1").val();
var Version=$("#Version_1").val();
var tipoDeComprobante=$("#tipoDeComprobante_1").val();
var condicionesDePago=$("#condicionesDePago_1").val();
var fechaTimbrado=$("#fechaTimbrado_1").val();
var nombreR=$("#nombreR_1").val();
var rfcR=$("#rfcR_1").val();
var Moneda=$("#Moneda_1").val();
var TipoCambio=$("#TipoCambio_1").val();
var ValorUnitarioConcepto=$("#ValorUnitarioConcepto_1").val();
var DescripcionConcepto=$("#DescripcionConcepto_1").val();
var ClaveUnidadConcepto=$("#ClaveUnidadConcepto_1").val();
var ClaveProdServConcepto=$("#ClaveProdServConcepto_1").val();
var CantidadConcepto=$("#CantidadConcepto_1").val();
var ImporteConcepto=$("#ImporteConcepto_1").val();
var UnidadConcepto=$("#UnidadConcepto_1").val();
var TUA=$("#TUA_1").val();
var TuaTotalCargos=$("#TuaTotalCargos_1").val();
var Descuento=$("#Descuento_1").val();
var subTotal=$("#subTotal11").val();
var propina=$("#propina_1").val();
var IVAXML=$("#IVAXML_1").val();
var IEPSXML=$("#IEPSXML_1").val();
var P_TIPO_DE_MONEDA_1=$("#P_TIPO_DE_MONEDA_1").val();
var P_INSTITUCION_FINANCIERA_1=$("#P_INSTITUCION_FINANCIERA_1").val();
var P_NUMERO_DE_CUENTA_DB_1=$("#P_NUMERO_DE_CUENTA_DB_1").val();
var P_NUMERO_CLABE_1=$("#P_NUMERO_CLABE_1").val();
var P_NUMERO_IBAN_1=$("#P_NUMERO_IBAN_1").val();
var P_NUMERO_CUENTA_SWIFT_1=$("#P_NUMERO_CUENTA_SWIFT_2").val();
var FOTO_ESTADO_PROVEE=$("#FOTO_ESTADO_PROVEE").val();
var ULTIMA_CARGA_DATOBANCA=$("#ULTIMA_CARGA_DATOBANCA").val();


/*termina copiar y pegar*/
			
			var per_page=$("#per_page").val();
			var parametros = {
			"action":"ajax",
			"page":page,
			'query':query,
			'per_page':per_page,

/*inicia copiar y pegar*/'NUMERO_CONSECUTIVO_PROVEE':NUMERO_CONSECUTIVO_PROVEE,
'NOMBRE_COMERCIAL':NOMBRE_COMERCIAL,
'VIATICOSOPRO':VIATICOSOPRO,
'RAZON_SOCIAL':RAZON_SOCIAL,
'RFC_PROVEEDOR':RFC_PROVEEDOR,
'NUMERO_EVENTO':NUMERO_EVENTO,
'NOMBRE_EVENTO':NOMBRE_EVENTO,
'MOTIVO_GASTO':MOTIVO_GASTO,
'CONCEPTO_PROVEE':CONCEPTO_PROVEE,
'MONTO_TOTAL_COTIZACION_ADEUDO':MONTO_TOTAL_COTIZACION_ADEUDO,
'MONTO_FACTURA':MONTO_FACTURA,
'MONTO_PROPINA':MONTO_PROPINA,
'MONTO_DEPOSITAR':MONTO_DEPOSITAR,
'TIPO_DE_MONEDA':TIPO_DE_MONEDA,
'PFORMADE_PAGO':PFORMADE_PAGO,

'FECHA_DE_PAGO':FECHA_DE_PAGO,
'FECHA_DE_PAGO2a':FECHA_DE_PAGO2a,

'FECHA_A_DEPOSITAR':FECHA_A_DEPOSITAR,
'STATUS_DE_PAGO':STATUS_DE_PAGO,
'ACTIVO_FIJO':ACTIVO_FIJO,
'GASTO_FIJO':GASTO_FIJO,
'PAGAR_CADA':PAGAR_CADA,
'FECHA_PPAGO':FECHA_PPAGO,
'FECHA_TPROGRAPAGO':FECHA_TPROGRAPAGO,
'NUMERO_EVENTOFIJO':NUMERO_EVENTOFIJO,
'CLASI_GENERAL':CLASI_GENERAL,
'SUB_GENERAL':SUB_GENERAL,
'MONTO_DEPOSITADO':MONTO_DEPOSITADO,
'NUMERO_EVENTO1':NUMERO_EVENTO1,
'CLASIFICACION_GENERAL':CLASIFICACION_GENERAL,
'CLASIFICACION_ESPECIFICA':CLASIFICACION_ESPECIFICA,
'PLACAS_VEHICULO':PLACAS_VEHICULO,
'MONTO_DE_COMISION':MONTO_DE_COMISION,
'POLIZA_NUMERO':POLIZA_NUMERO,
'NOMBRE_DEL_EJECUTIVO':NOMBRE_DEL_EJECUTIVO,
'OBSERVACIONES_2':OBSERVACIONES_2,
'FECHA_DE_LLENADO':FECHA_DE_LLENADO,
'hiddenpagoproveedores':hiddenpagoproveedores,
'RAZON_SOCIAL_orden':RAZON_SOCIAL_orden,
'RFC_PROVEEDOR_orden':RFC_PROVEEDOR_orden,
'MONTO_FACTURA_orden':MONTO_FACTURA_orden,

'FECHA_DE_PAGO':FECHA_DE_PAGO,
'FECHA_DE_PAGO2a':FECHA_DE_PAGO2a,

'NUMERO_EVENTO_orden':NUMERO_EVENTO_orden,
'TIPO_CAMBIOP':TIPO_CAMBIOP,
'TOTAL_ENPESOS':TOTAL_ENPESOS,
'IMPUESTO_HOSPEDAJE':IMPUESTO_HOSPEDAJE,
'ID_RELACIONADO':ID_RELACIONADO,
'IEPS':IEPS,
'IVA':IVA,
'TImpuestosRetenidosIVA_3':TImpuestosRetenidosIVA,
'TImpuestosRetenidosISR_3':TImpuestosRetenidosISR,
'descuentos_3':descuentos,


'UUID':UUID,
'metodoDePago':metodoDePago,
'totalf':totalf,
'serie':serie,
'folio':folio,
'regimenE':regimenE,
'UsoCFDI':UsoCFDI,
'TImpuestosTrasladados':TImpuestosTrasladados,
'TImpuestosRetenidos':TImpuestosRetenidos,
'Version':Version,
'tipoDeComprobante':tipoDeComprobante,
'condicionesDePago':condicionesDePago,
'fechaTimbrado':fechaTimbrado,
'nombreR':nombreR,
'rfcR':rfcR,
'Moneda':Moneda,
'TipoCambio':TipoCambio,
'ValorUnitarioConcepto':ValorUnitarioConcepto,
'DescripcionConcepto':DescripcionConcepto,
'ClaveUnidadConcepto':ClaveUnidadConcepto,
'ClaveProdServConcepto':ClaveProdServConcepto,
'CantidadConcepto':CantidadConcepto,
'ImporteConcepto':ImporteConcepto,
'UnidadConcepto':UnidadConcepto,
'TUA':TUA,
'TuaTotalCargos':TuaTotalCargos,
'Descuento':Descuento,
'subTotal':subTotal,
'propina':propina,

'P_TIPO_DE_MONEDA_1':P_TIPO_DE_MONEDA_1,
'P_INSTITUCION_FINANCIERA_1':P_INSTITUCION_FINANCIERA_1,
'P_NUMERO_DE_CUENTA_DB_1':P_NUMERO_DE_CUENTA_DB_1,
'P_NUMERO_CLABE_1':P_NUMERO_CLABE_1,
'P_NUMERO_IBAN_1':P_NUMERO_IBAN_1,
'P_NUMERO_CUENTA_SWIFT_1':P_NUMERO_CUENTA_SWIFT_1,
'FOTO_ESTADO_PROVEE':FOTO_ESTADO_PROVEE,
'ULTIMA_CARGA_DATOBANCA':ULTIMA_CARGA_DATOBANCA,
'TImpuestosRetenidos_3':TImpuestosRetenidos,
/*termina copiar y pegar*/

			'DEPARTAMENTO2':DEPARTAMENTO2
			};
			$("#loader2").fadeIn('slow');
    $.ajax({
        url: 'pagoproveedores/clases3/controlador_filtro.php', 
        type: 'POST',
        data: parametros,
beforeSend: function(objeto){
  $("#loader2").html(
    '<div class="msg-actualizando">' +
      '<span class="loader2"></span> ⏳ ACTUALIZADO...' +
    '</div>'
  ).fadeIn();

  // Quitar el mensaje después de 3 segundos
  setTimeout(function(){
    $("#loader2").fadeOut("slow", function(){
      $(this).html(""); // limpia el contenido después de ocultarlo
    });
  }, 1000);
},
			  
			  
			  
        success: function (data) {
			
				
		
            $(".datos_ajax2").html(data).fadeIn('slow');
          $('.checkbox').each(function() {
    const id = $(this).data('id');
    if (localStorage.getItem('checkbox_' + id) === 'checked') {
        this.checked = true;
        this.closest('tr').style.filter = 'brightness(65%) sepia(100%) saturate(200%) hue-rotate(0deg)';
    }
});

}
});
}



	
		
	</script>
