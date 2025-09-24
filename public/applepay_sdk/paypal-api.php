<?php
// paypal-api.php

function generateAccessToken()
{
    if (env('APP_ENV') == 'production') {
        $clientId = "AXc2YDyTWs6VKh-EdMFo1MV1zQ7vzYzLcPTvpmYg5rHMZxSgySqtLpT-5v13dRIxG6vxvrjb1X9QvBJR";
        $appSecret = "EITsZpoj19pYPdScdV6rIaJpFzND_qJDLFlhQBqHkYNhfYv__7fHwS2ESOSj7D_40_CSfJaf1rV7FD1V";
        $base = env('PAYPAL_BASE_NEW_URL');
    } elseif (env('APP_ENV') == 'local') {
        $clientId = "AfLQcRuY8C2VcpdsSImup4E10vYi5Yi3w4gJ6d1WhqubKbHttdwpUe8RIW1pVkW0OsrXW4uNBl44RIqp";
        $appSecret = "EBzp7ErM5_MA5YOzBJxKpA4aZqtfchk5nFE8auNXEyp6UrxsCmWX-e6SlUbZOcOURs4_iuC_RSqNP3eO";
        $base = env('PAYPAL_BASE_NEW_URL');
    }



    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "$base/v1/oauth2/token");
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Basic " . base64_encode("$clientId:$appSecret")]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        throw new Exception(curl_error($ch));
    }
    curl_close($ch);

    $json = json_decode($response, true);
    // echo "sdffdsf<pre>";
    // print_r($json);
    // die;
    return $json['access_token'];
}

function createOrder()
{
    $base = env('PAYPAL_BASE_NEW_URL');
    $accessToken = generateAccessToken();
    $merchantId = "";
    $purchaseAmount = "0.05"; // Hardcoded for demonstration purposes

    $orderData = [
        "intent" => "CAPTURE",
        "purchase_units" => [
            [
                "amount" => [
                    "currency_code" => "GBP",
                    "value" => $purchaseAmount
                ],
                "payee" => [
                    "merchant_id" => $merchantId
                ]
            ]
        ]
    ];

    $ch = curl_init("$base/v2/checkout/orders");
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Bearer $accessToken"
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($orderData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        throw new Exception(curl_error($ch));
    }
    curl_close($ch);

    return json_decode($response, true);
}

function capturePayment($orderId)
{
    $base = env('PAYPAL_BASE_NEW_URL');
    $accessToken = generateAccessToken();

    $ch = curl_init("$base/v2/checkout/orders/$orderId/capture");
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Bearer $accessToken"
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        throw new Exception(curl_error($ch));
    }
    curl_close($ch);

    return json_decode($response, true);
}

function generateClientToken()
{
    $base = env('PAYPAL_BASE_NEW_URL');
    $accessToken = generateAccessToken();

    $ch = curl_init("$base/v1/identity/generate-token");
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $accessToken",
        "Accept-Language: en_US",
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        throw new Exception(curl_error($ch));
    }
    curl_close($ch);

    $json = json_decode($response, true);
    return $json['client_token'];
}
