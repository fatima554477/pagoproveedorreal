<script>
$(document).off('click.comprobantePago', '.enviar-comprobante-pago')
  .on('click.comprobantePago', '.enviar-comprobante-pago', function () {
    var $boton = $(this);
    if ($boton.prop('disabled')) return;
    var $form = $boton.closest('form');
    var $email = $form.find('[name="email_enviacomprobante"]');
    var $mensaje = $form.find('.resultado-comprobante-pago');
    if (!$email.val().trim() || !$email[0].checkValidity()) {
      $mensaje.text('Escribe correos válidos separados por comas para enviar el comprobante.');
      $email[0].reportValidity();
      return;
    }
    $boton.prop('disabled', true);
    var guardarAntes = $boton.attr('data-guardar-antes') === '1';
    var emailEnvio = $email.val();
    var idRegistro = $form.find('[name="IPpagoprovee"]').val();
    var $guardar = $form.find('#clickPAGOP');
    var guardarDeshabilitado = $guardar.prop('disabled');
    if (guardarAntes) $guardar.prop('disabled', true);
    function finalizar() {
      $boton.prop('disabled', false);
      if (guardarAntes) $guardar.prop('disabled', guardarDeshabilitado);
    }
    function enviar() {
    $mensaje.text(guardarAntes ? 'Datos guardados. Enviando comprobante...' : 'Enviando comprobante...');
    $.ajax({
      url: 'pagoproveedores/enviar_comprobante.php',
      method: 'POST',
      dataType: 'json',
      data: {
        id: idRegistro,
        csrf: $boton.attr('data-csrf'),
        email_enviacomprobante: emailEnvio
      }
    }).done(function (resultado) {
      if (resultado.ok === true) {
        $mensaje.text((guardarAntes ? 'DATOS GUARDADOS. ' : '') + 'CORREO ENVIADO.')
          .wrapInner('<span id="ACTUALIZADO"></span>');
      } else {
        $mensaje.text((guardarAntes ? 'Datos guardados. ' : '') + resultado.mensaje);
      }
    }).fail(function (xhr) {
      $mensaje.text((guardarAntes ? 'Datos guardados. ' : '') + (xhr.responseJSON && xhr.responseJSON.mensaje
        ? xhr.responseJSON.mensaje
        : 'No se pudo confirmar el envío. Comprueba el resultado antes de reintentar.'));
    }).always(finalizar);
    }
    if (guardarAntes) {
      $mensaje.text('Guardando datos...');
      $.ajax({
        url: 'pagoproveedores/controladorPP.php',
        method: 'POST',
        dataType: 'text',
        data: $form.serialize()
      }).done(function (respuesta) {
        if ($.trim(respuesta) !== 'Actualizado') {
          $mensaje.text('No se confirmó el guardado. No se envió el comprobante. ' + $.trim(respuesta));
          finalizar();
          return;
        }
        if (typeof load === 'function') load(1);
        enviar();
      }).fail(function () {
        $mensaje.text('No se pudo confirmar el guardado. No se envió el comprobante.');
        finalizar();
      });
    } else {
      enviar();
    }
  });
</script>
