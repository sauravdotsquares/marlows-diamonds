<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayPal Apple Pay Integration</title>
    <style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .container {
        display: flex;
        flex-direction: column;
        text-align: center;
        background-color: lightgray;
        max-width: 500px;
        min-height: 15em;
        padding: 20px;
    }

    #applepay-container {
        flex-grow: 1;
    }
    </style>
</head>

<body>
    <div class="container">
        <h3>Apple Pay with PayPal Integration</h3>
        <h6>Test Transaction (Live)</h6>
        <div id="applepay-button-container"></div>
        <div id="final_price">10.00</div>
        <div><i>Use Apple Pay test cards for the sandbox environment.</i></div>
    </div>

    <?php
        // Request client token from the server-side PHP
        include('paypal-api.php');
        $clientToken = generateClientToken();
        $clientId = "AfLQcRuY8C2VcpdsSImup4E10vYi5Yi3w4gJ6d1WhqubKbHttdwpUe8RIW1pVkW0OsrXW4uNBl44RIqp"; // Hardcode or set these manually
        $merchantId = "GXEKWAEH8MFU4";
    ?>
    <script src="https://applepay.cdn-apple.com/jsapi/v1/apple-pay-sdk.js"></script>
    <!-- Include the PayPal SDK with the Apple Pay component -->
    <script
        src="https://www.paypal.com/sdk/js?components=applepay&client-id=<?= $clientId ?>&merchant-id=<?= urlencode($merchantId) ?>"
        data-client-token="<?= $clientToken ?>" data-partner-attribution-id="APPLEPAY"> console.log("In the index files");
    </script>
    <script src="app.js"></script>
</body>

</html>