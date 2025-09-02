<?php
$authorizationCode = $_GET['code'];
$tokenExchangeUrl = "https://graph.facebook.com/v12.0/oauth/access_token";
$tokenExchangeParams = [
    'client_id' => $appId,
    'client_secret' => $appSecret,
    'redirect_uri' => $redirectUri,
    'code' => $authorizationCode,
];

$ch = curl_init($tokenExchangeUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $tokenExchangeParams);

$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);

if ($data && isset($data['access_token'])) {
    $userAccessToken = $data['access_token'];
    // Use $userAccessToken to make requests to the Facebook Graph API
} else {
    // Handle error
}
