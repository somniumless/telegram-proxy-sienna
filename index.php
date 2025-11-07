<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mensaje = $_POST['mensaje'] ?? '';
    $correo = $_POST['correo'] ?? 'No disponible';
    $nombre = $_POST['nombre'] ?? 'Anónimo';
    $tipo = $_POST['tipo'] ?? 'usuario';

    if (empty($mensaje)) {
        echo "Por favor completa todos los campos.";
        exit;
    }

    $token = "8166086804:AAF1Yas5cG1zuvzNEkGm7Jg9ddZ6GcH1f84"; // tu token del bot
    $chat_id = "7799542025"; // tu chat_id
    $url = "https://api.telegram.org/bot$token/sendMessage";

    $texto = "📩 *Nuevo mensaje de Sienna*\n\n"
           . "👤 *De:* $nombre\n"
           . "📧 *Correo:* $correo\n"
           . "🏷️ *Tipo:* $tipo\n"
           . "💬 *Mensaje:*\n$mensaje";

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
    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    if ($response === false) {
        echo "❌ Error cURL: $error";
    } else {
        echo "✅ Mensaje enviado correctamente.";
    }
} else {
    echo "Método no permitido.";
}
?>

