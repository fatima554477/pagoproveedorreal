<?php
/*
 * Autor: 
 * Programer: Fatima Arellano
 * Propietario: EPC
 * fecha sandor;
 * fecha fatima:23/03/2026


 */
?>



<!-- Modal: Detalles pequeño (14) -->
<div id="dataModal14" class="modal fade">
  <div class="modal-dialog" style="width:80% !important; max-width:100% !important;">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Detalles</h4>
      </div>
      <div class="modal-body" id="personal_detalles14"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal: Detalles secundario -->
<div id="add_data_Modal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Detalles</h4>
      </div>
      <div class="modal-body" id="personal_detalles2"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal: Personal (ID renombrado — antes duplicado) -->
<div id="add_data_Modal_personal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Detalles</h4>
      </div>
      <div class="modal-body" id="personal"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal: Fullscreen principal -->
<div id="dataModal" class="modal fade">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Detalles</h4>
      </div>
      <div class="modal-body" id="personal_detalles"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal: Confirmar borrado -->
<div id="dataModal3" class="modal fade">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Confirmación</h4>
      </div>
      <div class="modal-body" id="personal_detalles3">
        ¿ESTÁS SEGURO DE BORRAR ESTE REGISTRO?
      </div>
      <div class="modal-footer">
        <button id="btnYes" class="btn confirm">SI BORRAR</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal: EFECTIVO (ID corregido — antes body tenía mismo id que el modal) -->
<div id="modalEFECTIVO" class="modal fade">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Detalles</h4>
      </div>
      <div class="modal-body" id="bodyEFECTIVO">
        ¿ESTÁS SEGURO DE BORRAR ESTE REGISTRO?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal: Registro modificado -->
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

function upload_file(e, name) {
  e.preventDefault();
  fileobj = e.dataTransfer.files[0];
  ajax_file_upload1(fileobj, name);
}

function file_explorer(name) {
  document.getElementsByName(name)[0].click();
  document.getElementsByName(name)[0].onchange = function () {
    fileobj = document.getElementsByName(name)[0].files[0];
    ajax_file_upload1(fileobj, name);
  };
}

function ajax_file_upload1(file_obj, nombre) {
  if (!file_obj) return;

  var form_data = new FormData();
  form_data.append(nombre, file_obj);

  $.ajax({
    type: 'POST',
    url: 'comprobaciones/controladorPP.php',
    contentType: false,
    processData: false,
    data: form_data,
    beforeSend: function () {
      $('#1' + nombre).html('<p style="color:green;">Cargando archivo!</p>');
      $('#mensajeADJUNTOCOL').html('<p style="color:green;">Actualizado!</p>');
    },
    success: function (response) {
      var resp = $.trim(response);

      if (resp === '3') {
        $('#1' + nombre).html('<p style="color:red;">UUID PREVIAMENTE CARGADO.</p>');
        $('#' + nombre).val('');

      } else if (resp === 'El archivo debe estar en formato XML.') {
        $('#1' + nombre).html('<p style="color:red;">' + resp + '</p>');
        $('#' + nombre).val('');

      } else {
        $('#' + nombre).val(response);
        $('#1' + nombre).html('<a target="_blank" href="includes/archivos/' + resp + '"></a>');

        recargarElemento('#2ADJUNTAR_FACTURA_XML');

        if (nombre === 'ADJUNTAR_FACTURA_XML') {
          ['#RAZON_SOCIAL2','#RFC_PROVEEDOR2','#CONCEPTO_PROVEE2',
           '#TIPO_DE_MONEDA2','#FECHA_DE_PAGO2','#NUMERO_CONSECUTIVO_PROVEE2',
           '#2MONTO_FACTURA','#2MONTO_DEPOSITAR','#2PFORMADE_PAGO',
           '#2IVA','#2TImpuestosRetenidosIVA','#2TImpuestosRetenidosISR','#2descuentos'
          ].forEach(recargarElemento);
        }

        recargarElemento('#2' + nombre);
        recargarElemento('#resettabla');
      }
    }
  });
}



function recargarElemento(selector) {
  $(selector).load(location.href + ' ' + selector);
}



function comasainput(name) {
  var el    = document.getElementsByName(name)[0];
  var clean = el.value.replace(/,/g, '');
  el.value  = clean.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
}



function actualizarFechaDeLlenado() {
  var fechaInput = document.querySelector('input[name="FECHA_DE_LLENADO"]');
  if (!fechaInput) return;
  var now = new Date();
  var pad = function (v) { return v.toString().padStart(2, '0'); };
  fechaInput.value = pad(now.getDate()) + '-' + pad(now.getMonth() + 1) + '-' + now.getFullYear()
    + ' ' + pad(now.getHours()) + ':' + pad(now.getMinutes()) + ':' + pad(now.getSeconds());
}



function activarTarget(num) {
  var allTargets = [];
  for (var i = 1; i <= 47; i++) allTargets.push(i);
  allTargets.push('VIDEO');

  allTargets.forEach(function (t) { $('#target' + t).hide('linear'); });

  if (num !== null) {
    $('#target' + num).show('swing');
    if (num === 2 && typeof load === 'function') {
      setTimeout(function () { load(1); }, 100);
    }
  }
}


function mostrarMensajePago(html) {
  $('#mensajepagoproveedores')
    .stop(true, true).html(html).show().fadeIn(150).delay(2000).fadeOut(600);
}


$(document).ready(function () {


  activarTarget(1);


  var allNums = [];
  for (var n = 1; n <= 47; n++) allNums.push(n);
  allNums.push('VIDEO');

  allNums.forEach(function (num) {
    $('#mostrar' + num).on('click', function () {
      $('#target' + num).show('swing');
      if (num === 2 && typeof load === 'function') { load(1); }
    });
    $('#ocultar' + num).on('click', function () { $('#target' + num).hide('linear'); });
  });


  $('#mostrar303').off('click').on('click', function () { $('#target33').show('swing'); });


  function toggleTodos(accion) {
    allNums.forEach(function (n) {
      $('#target' + n)[accion](accion === 'show' ? 'swing' : 'linear');
    });
  }
  $('#mostrartodos, #mostrartodos2').on('click',  function () { toggleTodos('show'); });
  $('#ocultartodos, #ocultartodos2').on('click', function () { toggleTodos('hide'); });


  function limpiarFormularioPago() {
    var form = document.getElementById('pagoaproveedoresform');
    if (form) form.reset();


    ['#RAZON_SOCIAL','#CONCEPTO_PROVEE','#RFC_PROVEEDOR',
     '#TIPO_DE_MONEDA','#FECHA_DE_PAGO','#NUMERO_CONSECUTIVO_PROVEE',
     '#ADJUNTAR_FACTURA_XML','#ADJUNTAR_FACTURA_PDF',
     '#PFORMADE_PAGO','#NOMBRE_COMERCIAL',
     '#2MONTO_FACTURA','#2MONTO_DEPOSITAR','#2ADJUNTAR_FACTURA_PDF'
    ].forEach(function (id) { $(id).val(''); });


    ['#1ADJUNTAR_FACTURA_XML','#1ADJUNTAR_FACTURA_PDF',
     '#1ADJUNTAR_COTIZACION','#1CONPROBANTE_TRANSFERENCIA',
     '#1ADJUNTAR_ARCHIVO_1','#mensajeADJUNTOCOL'
    ].forEach(function (id) { $(id).html(''); });


    ['#CONCEPTO_PROVEE2','#2ADJUNTAR_FACTURA_XML','#ADJUNTAR_FACTURA_XML',
     '#ADJUNTAR_FACTURA_PDF','#1ADJUNTAR_FACTURA_PDF',
     '#IMPUESTO_HOSPEDAJE','#MONTO_PROPINA','#IVA','#NOMBRE_COMERCIAL',
     '#2ADJUNTAR_FACTURA_PDF','#2ADJUNTAR_COTIZACION',
     '#2CONPROBANTE_TRANSFERENCIA','#2ADJUNTAR_ARCHIVO_1',
     '#NUMERO_CONSECUTIVO_PROVEE2',
     '#2MONTO_FACTURA','#2MONTO_DEPOSITAR','#2IVA','#2PFORMADE_PAGO',
     '#2TImpuestosRetenidosIVA','#TImpuestosRetenidosIVA',
     '#2TImpuestosRetenidosISR','#TImpuestosRetenidosISR',
     '#2descuentos','#descuentos',
     '#RAZON_SOCIAL2','#RFC_PROVEEDOR2','#TIPO_DE_MONEDA2','#FECHA_DE_PAGO2',
     '#2COMPLEMENTOS_PAGO_PDF','#2COMPLEMENTOS_PAGO_XML',
     '#2CANCELACIONES_PDF','#2CANCELACIONES_XML',
     '#2ADJUNTAR_FACTURA_DE_COMISION_PDF','#2ADJUNTAR_FACTURA_DE_COMISION_XML',
     '#2COMPROBANTE_DE_DEVOLUCION','#2CALCULO_DE_COMISION','#2NOTA_DE_CREDITO_COMPRA'
    ].forEach(recargarElemento);
  }



  $('#enviarPAGOPROVEEDORES').off('click').on('click', function () {
    actualizarFechaDeLlenado();
    var formData = new FormData($('#pagoaproveedoresform')[0]);

    $.ajax({
      url: 'comprobaciones/controladorPP.php',
      type: 'POST',
      dataType: 'html',
      data: formData,
      cache: false,
      contentType: false,
      processData: false
    }).done(function (data) {
      if ($.trim(data) === 'Ingresado' || $.trim(data) === 'Actualizado') {


        mostrarMensajePago("<span id='ACTUALIZADO'>" + data + "</span>");


        limpiarFormularioPago();


        setTimeout(function () {
          $('#resettabla').load(location.href + ' #resettabla');
          $('#reset_totales').load(location.href + ' #reset_totales');
          if (typeof load === 'function') load(1);
        }, 300);

   
        activarTarget(2);
        var el = document.getElementById('target2');
        if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });

      } else {
        mostrarMensajePago(data);
      }
    }).fail(function () {
      mostrarMensajePago("<span id='ERROR'>Error en AJAX</span>");
      console.error('[enviarPAGOPROVEEDORES] Error en la petición.');
    });
  });







  window.pasarpagado = function (pasarpagado_id) {
    var checkBox = document.getElementById('pasarpagado1a' + pasarpagado_id);
    if (!checkBox) return;
    var text = checkBox.checked ? 'si' : 'no';

    // Llamada 1 — controladorPP de comprobaciones
    $.ajax({
      url: 'comprobaciones/controladorPP.php',
      method: 'POST',
      data: { pasarpagado_id: pasarpagado_id, pasarpagado_text: text },
      beforeSend: function () { $('#pasarpagado').html('cargando...'); },
      success: function (data) {
        $('#pasarpagado').html("<span id='ACTUALIZADO'>" + data + "</span>");
      }
    });

    // Llamada 2 — controladorPP de pagoproveedores (original tenía ambas)
    $.ajax({
      url: 'pagoproveedores/controladorPP.php',
      method: 'POST',
      data: { pasarpagado_id: pasarpagado_id, pasarpagado_text: text }
    });
  };



  $(document).on('click', '.view_dataSBborrar2', function () {
    var borra_id_sb = $(this).attr('id');
    $('#dataModal3').modal('show');

    $('#btnYes').off('click').on('click', function () {
      $.ajax({
        url: 'comprobaciones/controladorPP.php',
        method: 'POST',
        data: { borra_id_sb: borra_id_sb, borrasbdoc: 'borrasbdoc' },
        beforeSend: function () { $('#mensajepagoproveedores').html('cargando...'); },
        success: function (data) {
          $('#dataModal3').modal('hide');
          $('#mensajepagoproveedores').html("<span id='ACTUALIZADO'>" + data + "</span>");
          recargarElemento('#' + borra_id_sb);
          recargarElemento('#A' + borra_id_sb);
        }
      });
    });
  });



  $(document).on('click', '.view_dataSBborrar', function () {
    var borra_id_PAGOP = $(this).attr('id');
    $('#dataModal3').modal('show');

    $('#btnYes').off('click').on('click', function () {
      $.ajax({
        url: 'comprobaciones/controladorPP.php',
        method: 'POST',
        data: { borra_id_PAGOP: borra_id_PAGOP, borrapagoaproveedores: 'borrapagoaproveedores' },
        beforeSend: function () { $('#mensajepagoproveedores').html('cargando...'); },
        success: function (data) {
          $('#dataModal3').modal('hide');
          $('#mensajepagoproveedores').html("<span id='ACTUALIZADO'>" + data + "</span>");
          recargarElemento('#reset_totales');
          if (typeof load === 'function') load(1);
        }
      });
    });
  });


  /* ---------------------------------------------------
     VER / MODIFICAR registros
  --------------------------------------------------- */
  $(document).on('click', '.view_dataPAGOPROVEEmodifica', function () {
    var personal_id = $(this).attr('id');
    $.ajax({
      url: 'comprobaciones/VistaPreviapagoproveedor.php',
      method: 'POST',
      data: { personal_id: personal_id },
      beforeSend: function () { $('#mensajepagoproveedores').html('cargando...'); },
      success: function (data) {
        $('#personal_detalles').html(data);
        $('#dataModal').modal('toggle');
        recargarElemento('#reset_totales');
      }
    });
  });




  /* ---------------------------------------------------
     ENVIAR NUEVO
  --------------------------------------------------- */
  $('#enviar_NUEVO').on('click', function () {
    $.ajax({
      url: 'pagoproveedores/VistaPreviaNUEVOproveedor.php',
      method: 'POST',
      data: { personal_id: typeof personal_id !== 'undefined' ? personal_id : '' },
      beforeSend: function () { $('#mensajepagoproveedores').html('cargando...'); },
      success: function (data) {
        $('#personal_detalles').html(data);
        $('#dataModal').modal('toggle');
      }
    });
  });


  /* ---------------------------------------------------
     MATCH: INBURSA / BBVA / AMEX / SANTANDER — centralizados
  --------------------------------------------------- */
  function bindMatch(selector, url) {
    $(document).on('click', selector, function () {
      var personal_id = $(this).attr('id');
      $.ajax({
        url: url,
        method: 'POST',
        data: { personal_id: personal_id },
        beforeSend: function () { $('#mensajeDATOSBANCARIOS1').html('cargando...'); },
        success: function (data) {
          $('#personal_detalles14').html(data);
          $('#dataModal14').modal('toggle');
        }
      });
    });
  }

  bindMatch('.view_MATCH2filtroinbursa', 'comprobacionesVYO/VistaPreviamatchinbursa.php');
  bindMatch('.view_MATCH2filtrobbva',    'comprobacionesVYO/VistaPreviamatchBBVA.php');
  bindMatch('.view_MATCH2filtroAMEX',   'comprobacionesVYO/VistaPreviamatchAMEX.php');
  bindMatch('.view_MATCH2filtroSIVALE', 'comprobacionesVYO/VistaPreviamatchSANTANDER.php');

}); // END $(document).ready
</script>
