<?php
/**
Instagram App ID :: 411374437721698
Instagram App Secret :: 077ffd93cd335b2e4b44e7cbed753839
Long Access Token :: EAAFfuY6jhPYBOzo1EThZBhUPwbuxmXwxSWk8ZB3ArLPY9m3uchgONeP8KDOQKmEMRJfKsupU88L82ZB8yzKqQHrOIjJySU07MX9VvuuQK9vZCZAguwZCO6u2FWMZAc8qGvkq5TL4EZB4jBFiXFJXmPDy07M7l2ZCFwwHoZCIMF8ZABoaISS84cIdrKvgxknVjcKlikyYzVx3IKO
*/

print_r($_GET);
die('tttt');

// Assuming you have the user's access token
$userAccessToken = 'EAAFfuY6jhPYBO3uTCCbcxMHmlDoe4x2cutesbbBrFHwXLV2WTYmBfhzGflZBcqP9KoLEs71PtZAQTWWH5bZAg4TO5dF0L0JX4EyWriib6zEvfbgyZCYnKbMJZBcsWJbohxNms32IY0Sasy7vZBdUulTzYtb9SOyU2FI4ex5kw2LlUNgxYcERO9EkSnVwJ3Tuy3xgTnfLLNK02l3q8tZBf9YS48uSTehZAZAMQ6M9eDGsVVW34L9s8fHbRmDkERB2eoG0ZD';

// Instagram API endpoint to get information about the current user
$endpoint = "https://graph.instagram.com/v14.0/me?fields=id&access_token={$userAccessToken}";

$ch = curl_init($endpoint);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

curl_close($ch);

$data = json_decode($response, true);
var_dump($data);
if ($data && isset($data['id'])) {
    $user_id = $data['id'];

    // Now you have the user_id
    echo "User ID: $user_id\n";
} else {
    echo "Failed to fetch user information.\n";
}

die;

// Instagram API endpoint for user's media
$endpoint = "https://graph.instagram.com/v12.0/{user-id}/media?fields=id,caption,media_type,media_url,thumbnail_url,permalink,timestamp&access_token={access-token}";

// Replace {user-id} and {access-token} with your actual values

$ch = curl_init($endpoint);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

curl_close($ch);

$data = json_decode($response, true);
var_dump($data);

if ($data && isset($data['data'])) {
    $posts = $data['data'];

    foreach ($posts as $post) {
        // Access post data (e.g., $post['media_url'], $post['caption'], etc.)
        echo "Post ID: {$post['id']}\n";
        echo "Caption: {$post['caption']}\n";
        echo "Media Type: {$post['media_type']}\n";
        echo "Media URL: {$post['media_url']}\n";
        echo "Thumbnail URL: {$post['thumbnail_url']}\n";
        echo "Permalink: {$post['permalink']}\n";
        echo "Timestamp: {$post['timestamp']}\n\n";
    }
} else {
    echo "dd Failed to fetch Instagram posts.\n";
}

die('hjh'); 















// Replace these with your actual values
$appId = '411374437721698';
$appSecret = '077ffd93cd335b2e4b44e7cbed753839';
$redirectUri = 'https://marlows-diamonds.co.uk/callback.php';
$authorizationCode = 'authorization-code'; // This should be obtained from the callback URL

// Step 1: Exchange Authorization Code for User Access Token
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
print_r($data);
if ($data && isset($data['access_token'])) {
    $userAccessToken = $data['access_token'];

    // Step 2: Fetch Instagram Posts using User Access Token
    $userIdEndpoint = "https://graph.instagram.com/v12.0/me?fields=id&access_token={$userAccessToken}";

    $ch = curl_init($userIdEndpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $userData = json_decode($response, true);

    if ($userData && isset($userData['id'])) {
        $userId = $userData['id'];

        // Use the obtained user ID to get media (posts)
        $postsEndpoint = "https://graph.instagram.com/v12.0/{$userId}/media?fields=id,caption,media_type,media_url,thumbnail_url,permalink,timestamp&access_token={$userAccessToken}";

        $ch = curl_init($postsEndpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        $postsData = json_decode($response, true);

        if ($postsData && isset($postsData['data'])) {
            $posts = $postsData['data'];

            foreach ($posts as $post) {
                // Access post data here
                // ...
            }
        } else {
            echo "Failed to fetch Instagram posts.\n";
        }
    } else {
        echo "Failed to get user ID.\n";
    }
} else {
    echo "Failed to exchange authorization code for a user access token.\n";
}
