<?php
echo '<pre>';
print_r($_SERVER);
die('Hello');
// server.php
require 'paypal-api.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_URI'] == '/api/orders') {
        try {
            $order = createOrder();
            echo json_encode($order);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(["error" => $e->getMessage()]);
        }
    } elseif (preg_match('/\/api\/orders\/(\w+)\/capture/', $_SERVER['REQUEST_URI'], $matches)) {
        $orderId = $matches[1];
        try {
            $captureData = capturePayment($orderId);
            echo json_encode($captureData);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(["error" => $e->getMessage()]);
        }
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_SERVER['REQUEST_URI'] == '/') {
    $clientId = "AfLQcRuY8C2VcpdsSImup4E10vYi5Yi3w4gJ6d1WhqubKbHttdwpUe8RIW1pVkW0OsrXW4uNBl44RIqp";
    $merchantId = "EBzp7ErM5_MA5YOzBJxKpA4aZqtfchk5nFE8auNXEyp6UrxsCmWX-e6SlUbZOcOURs4_iuC_RSqNP3eO";
    try {
        $clientToken = generateClientToken();
        include 'index.php';
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} elseif ($_SERVER['REQUEST_URI'] == '/check') {
    header('Content-Type: application/json');
    echo json_encode([
        "message" => "ok",
        "clientId" => "AfLQcRuY8C2VcpdsSImup4E10vYi5Yi3w4gJ6d1WhqubKbHttdwpUe8RIW1pVkW0OsrXW4uNBl44RIqp",
        "merchantId" => "EBzp7ErM5_MA5YOzBJxKpA4aZqtfchk5nFE8auNXEyp6UrxsCmWX-e6SlUbZOcOURs4_iuC_RSqNP3eO"
    ]);
}