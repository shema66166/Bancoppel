<?php
// Cargar el archivo de configuración JSON
$config = json_decode(file_get_contents("botconfig.json"), true);

// Verificar que los datos de configuración están presentes
if (!$config || !isset($config["token"]) || !isset($config["chat_id"])) {
    die("Error: No se ha encontrado el token o chat_id en el archivo de configuración.");
}

$token = $config["token"];
$chat_id = $config["chat_id"];

// Mensaje a enviar
$message = "¡Hola, este es un mensaje de prueba desde el bot!";

// URL de la API de Telegram para enviar mensajes
$url = "https://api.telegram.org/bot$token/sendMessage";

// Inicializar cURL
$ch = curl_init();

// Configuración de cURL para enviar la solicitud POST
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, [
    'chat_id' => $chat_id,
    'text' => $message
]);

// Ejecutar la solicitud cURL y obtener la respuesta
$response = curl_exec($ch);

// Manejo de errores
if ($response === false) {
    echo 'Error en cURL: ' . curl_error($ch);
    exit();
}

// Comprobar el código de estado HTTP
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
if ($httpCode != 200) {
    echo "Error HTTP $httpCode: " . $response;
    exit();
}

// Cerrar cURL
curl_close($ch);

// Mostrar el resultado de la solicitud
echo "Mensaje enviado correctamente: " . $response;
?>

