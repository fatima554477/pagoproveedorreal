<?php
/*
fecha sandor: 21/ABRIL/2025
fecha fatis : 05/JUNIO/2025
*/
?>

<!-- ===================== MODALES ===================== -->

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


<!-- ===================== SCRIPTS ===================== -->
<script>

/* -------------------------------------------------------
   CARGA DE ARCHIVOS (DRAG & DROP + FILE EXPLORER)
------------------------------------------------------- */
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
    url: 'ventasoperaciones/controladorVO.php',
    contentType: false,
    processData: false,
    data: form_data,
    beforeSend: function () {
      $('#1' + nombre).html('<p style="color:green;"><span class="spinner-border spinner-border-sm"></span>&nbsp;Cargando archivo...</p>');
      $('#mensajeADJUNTOCOL').html('<p style="color:green;"><span class="spinner-border spinner-border-sm"></span>&nbsp;Cargando archivo...</p>');
    },
    success: function (response) {
      var resp = $.trim(response);

      if (resp === '2') {
        $('#1' + nombre).html('<p style="color:red;">Error, archivo diferente a PDF, JPG o GIF.</p>');
        $('#' + nombre).val('');

      } else if (resp.indexOf('3^^') === 0) {
        // ⚠️ UUID duplicado — NO se toca el valor del campo para no borrar el archivo ya cargado
        var partes          = resp.split('^^');
        var numeroSolicitud = partes[1] ? $.trim(partes[1]) : '';
        var msgDuplicado    = numeroSolicitud !== ''
          ? '<p style="color:red;font-weight:600;">⚠️ UUID YA REGISTRADO — Se encuentra en la solicitud: <strong>' + numeroSolicitud + '</strong></p>'
          : '<p style="color:red;font-weight:600;">⚠️ UUID PREVIAMENTE CARGADO.</p>';
        $('#1' + nombre).html(msgDuplicado);
        // ✅ NO se hace $('#' + nombre).val('') aquí para preservar el archivo existente

      } else if (resp === '4') {
        var formatoEsperado = nombre === 'ADJUNTAR_FACTURA_XML' ? 'XML' : 'PDF';
        $('#1' + nombre).html('<p style="color:red;">ESTE ARCHIVO TIENE QUE SER EN FORMATO ' + formatoEsperado + '.</p>');
        $('#' + nombre).val('');

      } else {
        $('#' + nombre).val(response);
        $('#1' + nombre).html('<p style="color:green;">✅ ¡Archivo cargado con éxito!</p>');
        $('#mensajeADJUNTOCOL').html('<p style="color:green;">✅ ¡Actualizado!</p>');

        recargarElemento('#2ADJUNTAR_FACTURA_XML');

        if (nombre === 'ADJUNTAR_FACTURA_XML') {
          var camposXML = [
            '#RAZON_SOCIAL2', '#RFC_PROVEEDOR2', '#CONCEPTO_PROVEE2',
            '#TIPO_DE_MONEDA2', '#FECHA_DE_PAGO2', '#NUMERO_CONSECUTIVO_PROVEE2',
            '#2MONTO_FACTURA', '#2MONTO_DEPOSITAR', '#2PFORMADE_PAGO',
            '#2TImpuestosRetenidosIVA', '#2TImpuestosRetenidosISR',
            '#2descuentos', '#2IVA', '#NOMBRE_COMERCIAL2'
          ];
          camposXML.forEach(recargarElemento);
        }

        recargarElemento('#2' + nombre);
        recargarElemento('#resettabla');
      }
    }
  });
}



/* -------------------------------------------------------
   HELPER: recarga un elemento por selector
------------------------------------------------------- */
function recargarElemento(selector) {
  $(selector).load(location.href + ' ' + selector);
}


/* -------------------------------------------------------
   FORMATEO DE MONTOS CON COMAS
------------------------------------------------------- */
function comasainput(name) {
  const numberNoCommas  = (x) => x.toString().replace(/,/g, '');
  const numberWithCommas = (x) => {
    const num = parseFloat(x);
    if (isNaN(num)) return '';
    return num.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
  };

  const inputElement = document.getElementsByName(name)[0];

  inputElement.addEventListener('keydown', function (e) {
    const keyCode = e.keyCode || e.which;
    const isNumberKey =
      (keyCode >= 48 && keyCode <= 57)  ||
      (keyCode >= 96 && keyCode <= 105) ||
      keyCode === 46 || keyCode === 8;

    if (isNumberKey) {
      setTimeout(() => {
        const originalValue    = inputElement.value;
        const originalCursorPos = inputElement.selectionStart;
        const countCommasBefore = originalValue.slice(0, originalCursorPos).split(',').length - 1;

        const numericValue   = numberNoCommas(originalValue);
        const formattedValue = numberWithCommas(numericValue);
        inputElement.value   = formattedValue;

        let newCursorPos = originalCursorPos - countCommasBefore;
        let i = 0, charsPassed = 0;
        while (charsPassed < newCursorPos && i < formattedValue.length) {
          if (formattedValue[i] !== ',') charsPassed++;
          i++;
        }
        inputElement.setSelectionRange(i, i);
      }, 0);
    }
  });
}


/* -------------------------------------------------------
   SHOW/HIDE TARGETS — CENTRALIZADO (targets 1..15 + VIDEO)
------------------------------------------------------- */
function activarTarget(num) {
  var allTargets = [];
  for (var i = 1; i <= 15; i++) allTargets.push(i);
  allTargets.push('VIDEO');

  allTargets.forEach(function (t) { $('#target' + t).hide('linear'); });

  if (num !== null) {
    $('#target' + num).show('swing');
    if (num === 2 && typeof load === 'function') {
      setTimeout(function () { load(1); }, 100);
    }
  }
}


$(document).ready(function () {

  activarTarget(1);

  var allNums = [];
  for (var n = 1; n <= 15; n++) allNums.push(n);
  allNums.push('VIDEO');

  allNums.forEach(function (num) {
    $('#mostrar' + num).on('click', function () {
      $('#target' + num).show('swing');
      if (num === 2 && typeof load === 'function') { load(1); }
    });
    $('#ocultar' + num).on('click', function () { $('#target' + num).hide('linear'); });
  });

  function toggleTodos(accion) {
    allNums.forEach(function (n) { $('#target' + n)[accion](accion === 'show' ? 'swing' : 'linear'); });
  }
  $('#mostrartodos,  #mostrartodos2').on('click', function () { toggleTodos('show'); });
  $('#ocultartodos, #ocultartodos2').on('click', function () { toggleTodos('hide'); });


  /* ---------------------------------------------------
     HELPER: limpia el formulario de ventas operaciones
  --------------------------------------------------- */
  function limpiarFormularioVO() {
    var form = document.getElementById('ventasoperacionesform');
    if (form) form.reset();

    var camposVacios = [
      '#RAZON_SOCIAL2', '#CONCEPTO_PROVEE', '#RFC_PROVEEDOR2',
      '#TIPO_DE_MONEDA', '#FECHA_DE_PAGO', '#NUMERO_CONSECUTIVO_PROVEE',
      '#ADJUNTAR_FACTURA_XML', '#2MONTO_FACTURA', '#2MONTO_DEPOSITAR',
      '#2ADJUNTAR_FACTURA_PDF', '#2TImpuestosRetenidos'
    ];
    camposVacios.forEach(function (id) { $(id).val(''); });

    $('#NOMBRE_COMERCIAL').empty().trigger('change');

    var elementosRecargar = [
      '#2ADJUNTAR_FACTURA_XML', '#ADJUNTAR_FACTURA_XML', '#1ADJUNTAR_FACTURA_XML',
      '#ADJUNTAR_FACTURA_PDF',  '#1ADJUNTAR_FACTURA_PDF',
      '#1ADJUNTAR_COTIZACION',  '#1COMPROBANTE_DE_DEVOLUCION',
      '#1CONPROBANTE_TRANSFERENCIA', '#1ADJUNTAR_ARCHIVO_1',
      '#2COMPROBANTE_DE_DEVOLUCION',
      '#IMPUESTO_HOSPEDAJE', '#MONTO_PROPINA', '#IVA',
      '#2ADJUNTAR_FACTURA_PDF', '#2ADJUNTAR_COTIZACION',
      '#2CONPROBANTE_TRANSFERENCIA', '#2ADJUNTAR_ARCHIVO_1',
      '#NUMERO_CONSECUTIVO_PROVEE2',
      '#2MONTO_FACTURA', '#2MONTO_DEPOSITAR', '#2IVA', '#2PFORMADE_PAGO',
      '#2TImpuestosRetenidosIVA', '#TImpuestosRetenidosIVA',
      '#2TImpuestosRetenidosISR', '#TImpuestosRetenidosISR',
      '#2descuentos', '#descuentos',
      '#RAZON_SOCIAL2', '#RFC_PROVEEDOR2',
      '#TIPO_DE_MONEDA2', '#FECHA_DE_PAGO2', '#CONCEPTO_PROVEE2',
      '#NOMBRE_COMERCIAL2'
    ];
    elementosRecargar.forEach(recargarElemento);
  }


  /* ---------------------------------------------------
     ENVIAR VENTAS OPERACIONES
  --------------------------------------------------- */
  $('#enviarVENTASOPERACIONES').on('click', function () {
    var formData = new FormData($('#ventasoperacionesform')[0]);

    $.ajax({
      url: 'ventasoperaciones/controladorVO.php',
      type: 'POST',
      dataType: 'html',
      data: formData,
      cache: false,
      contentType: false,
      processData: false
    }).done(function (data) {
      if ($.trim(data) === 'Ingresado' || $.trim(data) === 'Actualizado') {
        $('#mensajeventasoperaciones').html('<span id="ACTUALIZADO">' + data + '</span>').fadeIn().delay(3000).fadeOut();
        limpiarFormularioVO();
        recargarElemento('#resettabla');
        recargarElemento('#reset_totales');
        activarTarget(2);
        var el = document.getElementById('target2');
        if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
      } else {
        $('#mensajeventasoperaciones').html(data).fadeIn().delay(3000).fadeOut();
      }
    }).fail(function () {
      console.error('[enviarVENTASOPERACIONES] Error en la petición AJAX.');
    });
  });


  /* ---------------------------------------------------
     BORRAR DOCUMENTO (SBborrar2)
  --------------------------------------------------- */
  $(document).on('click', '.view_dataSBborrar2', function () {
    var borra_id_sb = $(this).attr('id');
    $('#dataModal3').modal('show');

    $('#btnYes').off('click').on('click', function () {
      $.ajax({
        url: 'ventasoperaciones/controladorVO.php',
        method: 'POST',
        data: { borra_id_sb: borra_id_sb, borrasbdoc: 'borrasbdoc' },
        beforeSend: function () { $('#mensajeventasoperaciones').html('cargando...'); },
        success: function (data) {
          $('#dataModal3').modal('hide');
          $('#mensajeventasoperaciones').html('<span id="ACTUALIZADO">' + data + '</span>');
          $('#' + borra_id_sb).load(location.href + ' #' + borra_id_sb);
          $('#A' + borra_id_sb).load(location.href + ' #A' + borra_id_sb);
          if (typeof load === 'function') load(1);
        }
      });
    });
  });


  /* ---------------------------------------------------
     BORRAR VENTAS OPERACIONES
  --------------------------------------------------- */
  $(document).on('click', '.view_dataBORRAVENTASOPERACIONES', function () {
    var borra_id_VO = $(this).attr('id');
    $('#dataModal3').modal('show');

    $('#btnYes').off('click').on('click', function () {
      $.ajax({
        url: 'ventasoperaciones/controladorVO.php',
        method: 'POST',
        data: { borra_id_VO: borra_id_VO, borraventasoperaciones: 'borraventasoperaciones' },
        beforeSend: function () { $('#mensajeventasoperaciones').html('cargando...'); },
        success: function (data) {
          $('#dataModal3').modal('hide');
          $('#mensajeventasoperaciones').html('<span id="ACTUALIZADO">' + data + '</span>');
          if (typeof load === 'function') load(1);
          recargarElemento('#reset_totales');
        }
      });
    });
  });


  /* ---------------------------------------------------
     VER / MODIFICAR REGISTROS (modales de detalle)
  --------------------------------------------------- */
  function bindVistaPrevia(selector, url) {
    $(document).on('click', selector, function () {
      var personal_id = $(this).attr('id');
      $.ajax({
        url: url,
        method: 'POST',
        data: { personal_id: personal_id },
        beforeSend: function () { $('#mensajeventasoperaciones').html('cargando...'); },
        success: function (data) {
          $('#personal_detalles').html(data);
          $('#dataModal').modal('toggle');
          recargarElemento('#reset_totales');
        }
      });
    });
  }

  bindVistaPrevia('.view_dataVENTASOPERACIONES', 'pagoproveedores/VistaPreviapagoproveedorVENTAS.php');
  bindVistaPrevia('.view_dataSUBIRF',             'pagoproveedores/VistaPreviapagoproveedor3.php');
  bindVistaPrevia('.view_dataSUBIRCOMP',          'pagoproveedores/VistaPreviapagoproveedorU.php');


  /* ---------------------------------------------------
     DATOS BANCARIOS 1
  --------------------------------------------------- */
  $('#enviarDATOSBANCARIOS1').on('click', function () {
    var formData = new FormData($('#DATOSBANCARIOS1form')[0]);

    $.ajax({
      url: 'ventasoperaciones/controladorVO.php',
      type: 'POST',
      dataType: 'html',
      data: formData,
      cache: false,
      contentType: false,
      processData: false
    }).done(function (data) {
      if ($.trim(data) === 'Ingresado' || $.trim(data) === 'Actualizado') {
        $('#mensajeDATOSBANCARIOS1').html('<span id="ACTUALIZADO">' + data + '</span>');
        recargarElemento('#resetBancario1p');
      } else {
        $('#mensajeDATOSBANCARIOS1').html(data);
      }
    }).fail(function () {
      console.error('[enviarDATOSBANCARIOS1] Error en la petición.');
    });
  });

  $(document).on('click', '.view_data_bancario1p_modifica', function () {
    var personal_id = $(this).attr('id');
    $.ajax({
      url: 'pagoproveedores/VistaPreviaDatosBancario1.php',
      method: 'POST',
      data: { personal_id: personal_id },
      beforeSend: function () { $('#mensajeDATOSBANCARIOS1').html('cargando...'); },
      success: function (data) {
        $('#personal_detalles').html(data);
        $('#dataModal').modal('toggle');
      }
    });
  });

  $(document).on('click', '.view_databancario1borrar', function () {
    var borra_id_bancaP = $(this).attr('id');
    $('#dataModal3').modal('show');

    $('#btnYes').off('click').on('click', function () {
      $.ajax({
        url: 'ventasoperaciones/controladorVO.php',
        method: 'POST',
        data: { borra_id_bancaP: borra_id_bancaP, borra_datos_bancario1: 'borra_datos_bancario1' },
        beforeSend: function () { $('#mensajeREFERENCIAS').html('cargando...'); },
        success: function (data) {
          $('#dataModal3').modal('hide');
          $('#mensajeDATOSBANCARIOS1').html('<span id="ACTUALIZADO">' + data + '</span>');
          recargarElemento('#resetBancario1p');
        }
      });
    });
  });


  /* ---------------------------------------------------
     ENVIAR EMAIL BANCARIOS
  --------------------------------------------------- */
  $(document).on('click', '#enviar_email_bancarios', function () {
    var DAbancaPRO_ENVIAR_IMAIL = $('#DAbancaPRO_ENVIAR_IMAIL').val();
    var dataString = $('#form_emai_DATOSBpro').serialize();

    $.ajax({
      url: 'ventasoperaciones/controladorVO.php',
      method: 'POST',
      dataType: 'html',
      data: dataString + '&DAbancaPRO_ENVIAR_IMAIL=' + encodeURIComponent(DAbancaPRO_ENVIAR_IMAIL),
      beforeSend: function () { $('#mensajeDATOSBANCARIOS1').html('cargando...'); },
      success: function (data) {
        $('#mensajeDATOSBANCARIOS1').html('<span id="ACTUALIZADO">' + data + '</span>');
      }
    });
  });

}); // END $(document).ready
</script>
