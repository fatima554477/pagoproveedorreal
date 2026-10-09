<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    echo json_encode(array('ok' => false, 'mensaje' => 'Usa el botón ENVIAR COMPROBANTE.'));
    exit;
}
if (empty($_SESSION['logeado']) || empty($_SESSION['idem'])) {
    http_response_code(401);
    echo json_encode(array('ok' => false, 'mensaje' => 'Tu sesión ha terminado. Inicia sesión nuevamente.'));
    exit;
}
$token = isset($_POST['csrf']) ? $_POST['csrf'] : null;
if (!is_string($token) || empty($_SESSION['csrf_comprobante_pago']) ||
    !hash_equals($_SESSION['csrf_comprobante_pago'], $token)) {
    http_response_code(403);
    echo json_encode(array('ok' => false, 'mensaje' => 'Recarga el formulario antes de enviar el comprobante.'));
    exit;
}
$id = isset($_POST['id']) ? filter_var($_POST['id'], FILTER_VALIDATE_INT, array('options' => array('min_range' => 1))) : false;
if ($id === false) {
    http_response_code(400);
    echo json_encode(array('ok' => false, 'mensaje' => 'Selecciona un registro guardado.'));
    exit;
}

try {
    require_once __DIR__.'/class.epcinnPP.php';
    $conexion = new colaboradores();
    $emailFormulario = isset($_POST['email_enviacomprobante']) ? $_POST['email_enviacomprobante'] : null;
    $resultado = ComprobantePagoEmail::enviarGuardado(
        $conexion->db(), $id, dirname(__DIR__).'/includes/archivos', $emailFormulario
    );
    echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
} catch (Exception $error) {
    http_response_code(500);
    echo json_encode(array('ok' => false, 'mensaje' => 'No se pudo enviar el comprobante. Revisa la conexión y la configuración SMTP de la empresa.'));
} catch (Throwable $error) {
    http_response_code(500);
    echo json_encode(array('ok' => false, 'mensaje' => 'No se pudo enviar el comprobante. Revisa la conexión y la configuración SMTP de la empresa.'));
}
