<?php
// 🔹 test.php — Verifica conexión al bot de Telegram
header("Content-Type: text/plain");

$token = "8166086804:AAF1Yas5cG1zuvzNEkGm7Jg9ddZ6GcH1f84";
$chat_id = "7799542025";

$url = "https://api.telegram.org/bot$token/sendMessage";
$data = [
    'chat_id' => $chat_id,
    'text' => "🔔 Test exitoso desde Render proxy (" . date('Y-m-d H:i:s') . ")"
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
    echo "❌ Error al conectar con Telegram: $error";
} else {
    echo "✅ Mensaje enviado, respuesta de Telegram:\n$response";
}
?>
