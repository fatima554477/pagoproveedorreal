<?php
/*
fecha sandor: 
fecha fatis : 03/23/2026
*/
?>



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

<div id="dataModal" class="modal fade">
 <div class="modal-dialog modal-fullscreen">
  <div class="modal-content">
   <div class="modal-header">
    <h4 class="modal-title">ACTUALIZA PAGO A PROVEEDORES</h4>
   </div>
   <div class="modal-body" id="personal_detalles"></div>
   <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"></button>
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
    <button id="btnYes" value="btnYes" class="btn confirm">SI BORRAR</button>
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


function recargarElemento(selector) {
  $(selector).load(location.href + ' ' + selector);
}



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
        url: 'pagoproveedores/controladorPP.php',
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
                var partes = resp.split('^^');
                var numeroSolicitud = partes[1] ? $.trim(partes[1]) : '';
                var msgDuplicado = numeroSolicitud !== ''
                    ? '<p style="color:red;font-weight:600;">⚠️ UUID YA REGISTRADO — Se encuentra en la solicitud: <strong>' + numeroSolicitud + '</strong></p>'
                    : '<p style="color:red;font-weight:600;">⚠️ UUID PREVIAMENTE CARGADO.</p>';
                $('#1' + nombre).html(msgDuplicado);
                $('#' + nombre).val('');

            } else if (resp === '3') {
                $('#1' + nombre).html('<p style="color:red;font-weight:600;">⚠️ UUID PREVIAMENTE CARGADO.</p>');
                $('#' + nombre).val('');

            } else if (resp === '4') {
                var formatoEsperado = (nombre === 'ADJUNTAR_FACTURA_XML') ? 'XML' : 'PDF';
                $('#1' + nombre).html('<p style="color:red;">ESTE ARCHIVO TIENE QUE SER EN FORMATO ' + formatoEsperado + '.</p>');
                $('#' + nombre).val('');

            } else if (resp.indexOf('5^^') === 0) {
                $('#1' + nombre).html('<p style="color:red;font-weight:600;">⚠️ EL ARCHIVO XML ESTÁ VACÍO O NO CONTIENE INFORMACIÓN VÁLIDA. Verifica que sea un CFDI timbrado correctamente e inténtalo de nuevo.</p>');
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
                        '#2IVA', '#2TImpuestosRetenidosIVA', '#2TImpuestosRetenidosISR',
                        '#2descuentos', '#NOMBRE_COMERCIAL2'
                    ];
                    camposXML.forEach(recargarElemento);
                }

                recargarElemento('#2' + nombre);
                recargarElemento('#resettabla');
                $.getScript(load(1));
            }
        }
    });
}


function myFunction(montoapagar_id) {
    var checkBox = document.getElementById('montoapagar' + montoapagar_id);
    var montoapagar_text = checkBox.checked ? 'enter' : 'none';

    $.ajax({
        url: 'pagoproveedores/fetch_pagesPP.php',
        method: 'POST',
        data: { montoapagar_id: montoapagar_id, montoapagar_text: montoapagar_text },
        beforeSend: function () { $('#mensajemontoapagar').html('cargando'); },
        success: function () {
            recargarElemento('#montoapagartotal');
            recargarElemento('#montoapagartotal2');
        }
    });
}


function pasarpagado(pasarpagado_id) {
    var checkBox = document.getElementById('pasarpagado1a' + pasarpagado_id);
    var pasarpagado_text = checkBox.checked ? 'si' : 'no';

    $.ajax({
        url: 'pagoproveedores/controladorPP.php',
        method: 'POST',
        data: { pasarpagado_id: pasarpagado_id, pasarpagado_text: pasarpagado_text },
        beforeSend: function () { $('#pasarpagado').html('cargando'); },
        success: function (data) {
            $.getScript(load2(1));
            $('#pasarpagado').html('<span id="ACTUALIZADO">' + data + '</span>');
        }
    });
}


function comasainput(name) {
    const numberNoCommas   = (x) => x.toString().replace(/,/g, '');
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
                const originalValue     = inputElement.value;
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


function comasainput2(name) { comasainput(name); }



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


function guardarYIrATarget2() {
    activarTarget(2);
    var el = document.getElementById('target2');
    if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
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
        allNums.forEach(function (n) {
            $('#target' + n)[accion](accion === 'show' ? 'swing' : 'linear');
        });
    }
    $('#mostrartodos').on('click', function () { toggleTodos('show'); });
    $('#ocultartodos').on('click', function () { toggleTodos('hide'); });

    $('#dataModal').on('hidden.bs.modal', function () {
        $('#target2').show('swing');
        var el = document.getElementById('target2');
        if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });

 
    $('#dataModal3').on('hidden.bs.modal', function () {
        $('#btnYes').off('click');
    });


    function limpiarFormularioPP() {
        var form = document.getElementById('pagoaproveedoresform');
        if (form) form.reset();

        var camposVacios = [
            '#RAZON_SOCIAL2', '#RFC_PROVEEDOR2', '#CONCEPTO_PROVEE2',
            '#TIPO_DE_MONEDA2', '#FECHA_DE_PAGO2', '#NUMERO_CONSECUTIVO_PROVEE2',
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


    $('#enviarPAGOPROVEEDORES').on('click', function () {
        var formData = new FormData($('#pagoaproveedoresform')[0]);

        $.ajax({
            url: 'pagoproveedores/controladorPP.php',
            type: 'POST',
            dataType: 'html',
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        }).done(function (data) {
            var respuesta = $.trim(data).replace(/[\r\n\t]/g, '');
            if (respuesta.indexOf('Ingresado') !== -1 || respuesta.indexOf('Actualizado') !== -1) {
                $('#mensajepagoproveedores').html('<span id="ACTUALIZADO">Ingresado</span>').fadeIn().delay(3000).fadeOut();
                limpiarFormularioPP();
                recargarElemento('#resettabla');
                setTimeout(function () { guardarYIrATarget2(); }, 600);
            } else {
                $('#mensajepagoproveedores').html('<span style="color:red;">' + data + '</span>');
            }
        }).fail(function (xhr) {
            console.error('[enviarPAGOPROVEEDORES] Error en la petición.', xhr.responseText);
        });
    });


    $(document).on('click', '.view_dataSBborrar2', function () {
        var borra_id_sb = $(this).attr('id');
        $('#dataModal3').modal('show');

        $('#btnYes').off('click').on('click', function () {
            $.ajax({
                url: 'pagoproveedores/controladorPP.php',
                method: 'POST',
                data: { borra_id_sb: borra_id_sb, borrasbdoc: 'borrasbdoc' },
                beforeSend: function () { $('#mensajepagoproveedores').html('cargando...'); },
                success: function (data) {
                    $('#dataModal3').modal('hide');
                    $('#mensajepagoproveedores').html('<span id="ACTUALIZADO">' + data + '</span>');
                    recargarElemento('#' + borra_id_sb);
                    recargarElemento('#A' + borra_id_sb);
                }
            });
        });
    });


    /* ---------------------------------------------------
     
    --------------------------------------------------- */
    $(document).on('click', '.view_dataSBborrar', function () {
        var borra_id_PAGOP = $(this).attr('id');
        $('#dataModal3').modal('show');

        $('#btnYes').off('click').on('click', function () {
            $.ajax({
                url: 'pagoproveedores/controladorPP.php',
                method: 'POST',
                data: { borra_id_PAGOP: borra_id_PAGOP, borrapagoaproveedores: 'borrapagoaproveedores' },
                beforeSend: function () { $('#mensajepagoproveedores').html('cargando...'); },
                success: function (data) {
                    $('#dataModal3').modal('hide');
                    $('#mensajepagoproveedores').html('<span id="ACTUALIZADO">' + data + '</span>');
                    if (typeof load === 'function') { load(1); }
                }
            });
        });
    });


    $(document).on('click', '.view_dataPAGOPROVEEmodifica', function () {
        var personal_id = $(this).attr('id');
        $.ajax({
            url: 'pagoproveedores/VistaPreviapagoproveedor.php',
            method: 'POST',
            data: { personal_id: personal_id },
            beforeSend: function () { $('#mensajepagoproveedores').html('cargando...'); },
            success: function (data) {
                $('#personal_detalles').html(data);
                $('#dataModal').modal('toggle');
            }
        });
    });




</script>
