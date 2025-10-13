// ---------------------- Environment Setup ----------------------
let APPLE_PAY_BASE, PAYPAL_CLIENT_ID, PAYPAL_SECRET;

APPLE_PAY_BASE = PAYPAL_BASE_NEW_URL_PHP; // Dynamic URL for both production and sandbox in this case from .env
PAYPAL_CLIENT_ID = PAYPAL_CLIENT_ID_PHP;
PAYPAL_SECRET = PAYPAL_SECRET_PHP;

// Global variables to store order details
let applepayLastOrderId = null;
let applepayLastOrderAmount = null;

// After Place Order Ajax succeeds
function applepayAfterOrderCreated(orderId, price) {
    applepayLastOrderId = orderId;
    applepayLastOrderAmount = price;

    // Hide place order button, show Apple Pay button
    $('#already_inserted').val('order_inserted');
    $('.applepay-button-container').show();
    $('#place-order').hide();

    initializeApplePay(); // this will insert the Apple Pay button
}

// Initialize Apple Pay button
async function initializeApplePay() {
    console.log("Initializing Apple Pay button");

    if (!window.ApplePaySession) {
        console.warn("Apple Pay is not available on this device/browser.");
        alert("Apple Pay is not supported here.");
        return;
    }
    console.log("Apple Pay Session is available");

    if (!ApplePaySession.canMakePayments()) {
        console.warn("Apple Pay is not available on this device/browser.");
        alert("Apple Pay is not supported here.");
        return;
    }
    console.log("Apple Pay can make payments");

    if (!window.isSecureContext) {
        console.error("Apple Pay requires a secure context (HTTPS).");
        alert("Apple Pay only works on secure pages (HTTPS).");
        return;
    }
    console.log("Secure context confirmed");

    const buttonContainer = document.getElementById("applepay-button-container");

    if (buttonContainer && !document.getElementById("btn-appl")) {
        const button = document.createElement("button");
        button.id = "btn-appl";
        button.style = `
            appearance: -apple-pay-button;
            -apple-pay-button-type: buy;
            -apple-pay-button-style: black;
            width: 100%;
            height: 44px;
            margin-top: 10px;
        `;

        // 👇 This is the important part
        button.addEventListener("click", () => {
            if (!applepayLastOrderId || !applepayLastOrderAmount) {
                alert("Order details missing. Please try again.");
                return;
            }
            triggerApplePayViaPayPal(applepayLastOrderAmount, applepayLastOrderId, "GBP");
        });

        buttonContainer.appendChild(button);
    }
}

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

                // 2. Confirm Apple Pay payment with PayPal via backend (avoid relying on browser paypal SDK here)
                const confirmRes = await confirmPayPalOrderWithApplePay(paypalOrderId, paymentData);
                const status = confirmRes?.status;

                if (status === "APPROVED") {
                    // 3. Capture the order
                    const captureRes = await capturePayPalOrder(paypalOrderId);
                    const orderUpdatePayload = {
                        payment: paymentData,         // Apple Pay details
                        captureRes: captureRes,       // PayPal capture response
                        tokenOrdIdUpdated: orderId
                    };

                    // 4. Notify backend
                    const backendRes = await fetch("/process-apple-pay", {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify(orderUpdatePayload)
                    });
                    const backendData = await safeJson(backendRes);

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
    return safeJson(response);
}

async function capturePayPalOrder(orderId) {
    const accessToken = await generateApplePayAccessToken();
    const response = await fetch(`${APPLE_PAY_BASE}/v2/checkout/orders/${orderId}/capture`, {
        method: "POST",
        headers: { "Content-Type": "application/json", Authorization: `Bearer ${accessToken}` }
    });
    return safeJson(response);
}

async function generateApplePayAccessToken() {
    // Use the injected PAYPAL_CLIENT_ID and PAYPAL_SECRET variables (PHP should render them)
    if (!PAYPAL_CLIENT_ID || !PAYPAL_SECRET || !APPLE_PAY_BASE) {
        throw new Error('Missing PayPal credentials or base URL');
    }
    const clientCredentials = `${PAYPAL_CLIENT_ID}:${PAYPAL_SECRET}`;
    const base64Encoded = btoa(clientCredentials);

    const response = await fetch(`${APPLE_PAY_BASE}/v1/oauth2/token`, {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            Authorization: `Basic ${base64Encoded}`,
        },
        body: new URLSearchParams({ grant_type: "client_credentials" }),
    });

    const data = await safeJson(response);
    return data.access_token;
}

// Helper to POST payment confirmation to backend which should call PayPal server-side
async function confirmPayPalOrderWithApplePay(paypalOrderId, paymentMethodData) {
    try {
        const resp = await fetch('/paypal/confirm-applepay', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ orderId: paypalOrderId, paymentMethodData })
        });
        return safeJson(resp);
    } catch (err) {
        console.error('Error confirming PayPal order via backend:', err);
        return { status: 'ERROR', error: err.message };
    }
}

// Safe JSON helper that throws on non-OK responses and returns parsed JSON
async function safeJson(response) {
    let text;
    try {
        text = await response.text();
    } catch (err) {
        throw new Error('Failed to read response body: ' + err.message);
    }
    let data = null;
    try {
        data = text ? JSON.parse(text) : {};
    } catch (err) {
        // If not JSON, include raw text for debugging
        throw new Error('Invalid JSON response: ' + text);
    }
    if (!response.ok) {
        const msg = data?.message || data?.error || response.statusText || 'Request failed';
        throw new Error(msg);
    }
    return data;
}
// async function generateApplePayAccessToken() {
//     console.log("Generating PayPal access token for Apple Pay");
//     const response = await fetch('/paypal/token', { method: 'POST' });
//     const data = await response.json();
//     if (!data.access_token) console.log("Failed to generate PayPal access token");
//     return data.access_token;
// }
// ---------------------- End of applepay_checkout_code.js File ----------------------
