// ---------------------- Environment Setup ----------------------
let APPLE_PAY_BASE, PAYPAL_CLIENT_ID, PAYPAL_SECRET;

APPLE_PAY_BASE = PAYPAL_BASE_NEW_URL_PHP; // Dynamic URL for both production and sandbox in this case from .env
PAYPAL_CLIENT_ID = PAYPAL_CLIENT_ID_PHP;
PAYPAL_SECRET = PAYPAL_SECRET_PHP;

// Global variables to store order details
let applepayLastOrderId = null;
let applepayLastOrderAmount = null;

// After Place Order Ajax succeeds


// ---------------------- Apple Pay Trigger ----------------------
async function triggerApplePayViaPayPal(price, orderId, currency = "GBP") {
    console.group("Apple Pay Triggered");
    console.log("Order ID:", orderId, "Price:", price, "Environment:", environmentCheckPhp);
    console.groupEnd();

    try {
        const cleanPrice = parseFloat(String(price).replace(/,/g, "").trim());
        if (isNaN(cleanPrice) || cleanPrice <= 0) throw new Error("Invalid price: " + price);

        const amountStr = cleanPrice.toFixed(2);

        // --- Apple Pay Request ---
        const request = {
            countryCode: "GB",
            currencyCode: currency,
            merchantCapabilities: ["supports3DS", "supportsCredit", "supportsDebit"],
            supportedNetworks: ["visa", "masterCard", "amex", "discover"],
            total: { label: "Marlows Diamond", amount: amountStr, type: "final" }
        };

        const session = new ApplePaySession(3, request);

        // --- Merchant Validation ---
        session.onvalidatemerchant = async (event) => {
            try {
                const accessToken = await generateApplePayAccessToken();
                const validateRes = await fetch(`${APPLE_PAY_BASE}/v1/apple-pay/validate-payment`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        Authorization: `Bearer ${accessToken}`,
                    },
                    body: JSON.stringify({
                        validationUrl: event.validationURL,
                        displayName: "Marlow's Diamonds"
                    })
                });

                const merchantSession = await validateRes.json();
                session.completeMerchantValidation(merchantSession);
                console.log("Merchant validation successful");
            } catch (err) {
                console.error("Merchant validation failed", err);
                session.abort();
            }
        };

        // --- Payment Authorization ---
        session.onpaymentauthorized = async (event) => {
            try {
                const paymentData = event.payment;

                // 1. Create PayPal order AFTER Apple validation
                const payload = {
                    intent: "CAPTURE",
                    purchase_units: [{
                        amount: { currency_code: currency, value: amountStr }
                    }]
                };
                console.log("Creating PayPal Order:", payload);

                const createOrderResponse = await createPayPalOrder(payload);
                if (!createOrderResponse?.id) {
                    throw new Error("Failed to create PayPal order");
                }
                const paypalOrderId = createOrderResponse.id;

                // 2. Confirm Apple Pay payment with PayPal
                const { status } = await paypal.Applepay().confirmOrder({
                    orderId: paypalOrderId,
                    paymentMethodData: paymentData
                });

                if (status === "APPROVED") {
                    // 3. Capture the order
                    const captureRes = await capturePayPalOrder(paypalOrderId);
                    const payload = {
                        payment: payment,         // Apple Pay details (your existing object)
                        captureRes: captureRes,   // PayPal capture response
                        tokenOrdIdUpdated: orderId
                    };
                    const paymentPayload = {
                        paymentMethod: paymentData.payment.token.paymentMethod.displayName,
                        token: paymentData.payment.token.transactionIdentifier,
                        billingAddress: paymentData.payment.billingContact,
                        countryCode: paymentData.payment.billingContact.countryCode,
                        tokenOrdIdUp: orderId
                    };

                    // 4. Notify backend
                    const backendRes = await fetch("/process-apple-pay", {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ orderId, captureRes })
                    });
                    const backendData = await backendRes.json();

                    if (backendData.success) {
                        session.completePayment(ApplePaySession.STATUS_SUCCESS);
                        window.location.href = backendData.redirect || "/payment/success";
                    } else {
                        session.completePayment(ApplePaySession.STATUS_FAILURE);
                        alert("Failed to update order: " + (backendData.message || ""));
                    }
                } else {
                    session.completePayment(ApplePaySession.STATUS_FAILURE);
                    alert("Apple Pay transaction was not approved");
                }
            } catch (err) {
                console.error("Apple Pay processing error:", err);
                session.completePayment(ApplePaySession.STATUS_FAILURE);
            }
        };

        session.begin();
    } catch (err) {
        console.error("Apple Pay trigger error:", err);
        alert("Unable to start Apple Pay: " + err.message);
    }
}


// ---------------------- PayPal Helper Functions ----------------------
async function createPayPalOrder(payload) {
    const accessToken = await generateApplePayAccessToken();
    console.log("Generated Access Token:", accessToken);
    const response = await fetch(`${APPLE_PAY_BASE}/v2/checkout/orders`, {
        method: "POST",
        headers: { "Content-Type": "application/json", Authorization: `Bearer ${accessToken}` },
        body: JSON.stringify(payload)
    });
    return response.json();
}

async function capturePayPalOrder(orderId) {
    const accessToken = await generateApplePayAccessToken();
    const response = await fetch(`${APPLE_PAY_BASE}/v2/checkout/orders/${orderId}/capture`, {
        method: "POST",
        headers: { "Content-Type": "application/json", Authorization: `Bearer ${accessToken}` }
    });
    return response.json();
}

async function generateApplePayAccessToken() {
    const clientCredentials = `${PAYPAL_CLIENT_ID_PHP}:${PAYPAL_SECRET_PHP}`;
    const base64Encoded = btoa(clientCredentials);

    const response = await fetch(`${base}/v1/oauth2/token`, {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            Authorization: `Basic ${base64Encoded}`,
        },
        body: new URLSearchParams({ grant_type: "client_credentials" }),
    });

    const data = await response.json();
    return data.access_token;
}
// async function generateApplePayAccessToken() {
//     console.log("Generating PayPal access token for Apple Pay");
//     const response = await fetch('/paypal/token', { method: 'POST' });
//     const data = await response.json();
//     if (!data.access_token) console.log("Failed to generate PayPal access token");
//     return data.access_token;
// }
// ---------------------- End of applepay_checkout_code.js File ----------------------
