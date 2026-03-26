<?php

require_once __DIR__ . '/conexion.php';
require_once __DIR__ . '/scriptPHPmailer.php';
require_once __DIR__ . '/config/Load.php';

function generarCodigoUsoPromo($longitud = 10) {
    $caracteres = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
    $maxIndice = strlen($caracteres) - 1;
    $codigo = '';

    for ($i = 0; $i < $longitud; $i++) {
        $codigo .= $caracteres[random_int(0, $maxIndice)];
    }

    return $codigo;
}

function enviarMailPromo($id_uso, $estado) {
    global $conexion;

    $query = "SELECT u.mail_usuario, p.descripcion, up.codigo_uso
              FROM uso_promocion up
              INNER JOIN usuario u ON up.id_cliente = u.id_usuario
              INNER JOIN promocion p ON up.id_promocion = p.id_promocion
              WHERE up.id_uso = ?";

    $stmt = mysqli_prepare($conexion, $query);
    if (!$stmt) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, 'i', $id_uso);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $email, $descripcionPromocion, $codigoUso);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if (empty($email)) {
        return false;
    }

    $descripcionSegura = htmlspecialchars((string) $descripcionPromocion, ENT_QUOTES, 'UTF-8');

    if ($estado === 'aceptada') {
        $codigoSeguro = htmlspecialchars((string) $codigoUso, ENT_QUOTES, 'UTF-8');
        $appUrl = rtrim((string) env('APP_URL', ''), '/');
        if ($appUrl === '') {
            $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
            $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
            $appUrl = $scheme . '://' . $host;
        }
        $urlPromo = $appUrl . '/front/promociones.php';
        $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=' . rawurlencode($urlPromo);

        $asunto = 'Solicitud aprobada: codigo para usar tu promocion';
        $mensaje = "
            <p>Tu solicitud para la promocion <strong>{$descripcionSegura}</strong> fue aprobada.</p>
            <p><strong>Codigo de uso:</strong> {$codigoSeguro}</p>
            <p>Presenta este codigo al momento de usar la promocion.</p>
            <p><img src=\"{$qrUrl}\" alt=\"QR de promocion\" width=\"220\" height=\"220\"></p>
            <p>Enlace de la pagina: <a href=\"{$urlPromo}\">{$urlPromo}</a></p>
        ";

        return sendMail($email, $asunto, $mensaje);
    }

    if ($estado === 'rechazada') {
        $asunto = 'Solicitud rechazada';
        $mensaje = "
            <p>Tu solicitud para la promocion <strong>{$descripcionSegura}</strong> fue rechazada.</p>
            <p>Si necesitas mas informacion, podes comunicarte con soporte.</p>
        ";

        return sendMail($email, $asunto, $mensaje);
    }

    return false;
}
