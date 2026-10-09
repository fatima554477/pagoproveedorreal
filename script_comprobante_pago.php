<script>
$(document).off('click.comprobantePago', '.enviar-comprobante-pago')
  .on('click.comprobantePago', '.enviar-comprobante-pago', function () {
    var $boton = $(this);
    if ($boton.prop('disabled')) return;
    var $form = $boton.closest('form');
    var $email = $form.find('[name="email_enviacomprobante"]');
    var $mensaje = $form.find('.resultado-comprobante-pago');
    if (!$email.val().trim() || !$email[0].checkValidity()) {
      $mensaje.text('Escribe y guarda un email válido antes de enviar el comprobante.');
      $email[0].reportValidity();
      return;
    }
    $boton.prop('disabled', true);
    $mensaje.text('Enviando comprobante...');
    $.ajax({
      url: 'pagoproveedores/enviar_comprobante.php',
      method: 'POST',
      dataType: 'json',
      data: {
        id: $form.find('[name="IPpagoprovee"]').val(),
        csrf: $boton.attr('data-csrf'),
        email_enviacomprobante: $email.val()
      }
    }).done(function (resultado) {
      $mensaje.text(resultado.mensaje);
    }).fail(function (xhr) {
      $mensaje.text(xhr.responseJSON && xhr.responseJSON.mensaje
        ? xhr.responseJSON.mensaje
        : 'No se pudo confirmar el envío. Comprueba el resultado antes de reintentar.');
    }).always(function () {
      $boton.prop('disabled', false);
    });
  });
</script>
