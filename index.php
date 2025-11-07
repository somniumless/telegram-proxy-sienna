<?php
// Habilitar CORS para que tu página en otro dominio pueda hacer fetch()
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Si es una petición OPTIONS (preflight de CORS), salir sin hacer nada más
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitizar entradas
    $mensaje = trim($_POST['mensaje'] ?? '');
    $correo = trim($_POST['correo'] ?? 'No disponible');
    $nombre = trim($_POST['nombre'] ?? 'Usuario desconocido');
    $tipo = trim($_POST['tipo'] ?? 'usuario');

    // Validar campos
    if (empty($mensaje)) {
        echo "⚠️ Por favor escribe un mensaje antes de enviarlo.";
        exit;
    }

    // Token y chat_id de tu bot
    $token = "8166086804:AAF1Yas5cG1zuvzNEkGm7Jg9ddZ6GcH1f84"; 
    $chat_id = "7799542025";

    // Crear texto del mensaje
    $texto = "📩 *Nuevo mensaje de Sienna*\n\n";
    $texto .= "👤 *Nombre:* $nombre\n";
    $texto .= "📧 *Correo:* $correo\n";
    $texto .= "🔖 *Tipo de usuario:* $tipo\n";
    $texto .= "💬 *Mensaje:*\n$mensaje";

    // Enviar mensaje a Telegram
    $url = "https://api.telegram.org/bot$token/sendMessage";

    $data = [
        'chat_id' => $chat_id,
        'text' => $texto,
        'parse_mode' => 'Markdown'
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);

    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    // Respuesta al cliente (tu web)
    if ($response === false) {
        echo "❌ Error al enviar a Telegram: $error";
    } else {
        echo "✅ Mensaje enviado correctamente. Gracias por contactarnos.";
    }
} else {
    echo "❌ Método no permitido. Solo se acepta POST.";
}
?>

