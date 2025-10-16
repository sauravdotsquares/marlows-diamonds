// ---------------------- Environment Setup ----------------------
let APPLE_PAY_BASE, PAYPAL_CLIENT_ID, PAYPAL_SECRET;

APPLE_PAY_BASE = PAYPAL_BASE_NEW_URL_PHP; // Dynamic URL for both production and sandbox in this case from .env
PAYPAL_CLIENT_ID = PAYPAL_CLIENT_ID_PHP;
PAYPAL_SECRET = PAYPAL_SECRET_PHP;

// Global variables to store order details
let applepayLastOrderId = null;
let applepayLastOrderAmount = null;

function hideApplePayLoader() {
    try {
        if (typeof $ !== 'undefined' && $('#loader-overlay').length) {
            $('#loader-overlay').hide();
        }
    } catch (e) {}
}

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
    // if (!isRegionSupported()) {
    //     console.warn("Apple Pay is not supported in your region.");
    //     alert("Apple Pay is not supported in your region.");
    //     return;
    // }
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

        alert("Starting Apple Pay for £" + amountStr + " (" + currency + ")");

        const session = new ApplePaySession(3, request);
        let apValidated = false;
        let apAuthorized = false;
        let apCancelled = false;

        // --- Merchant Validation ---
        session.onvalidatemerchant = async (event) => {
            alert("Validating Apple Pay merchant…");
            console.log("Apple Pay merchant validation started", { validationURL: event.validationURL });
            try {
                // Prefer PayPal SDK helper if available
                if (window.paypal && paypal.Applepay) {
                    const applepay = paypal.Applepay();
                    try {
                        // Initialize SDK config first (required by some environments)
                        await applepay.config();
                    } catch (e) {
                        console.warn("paypal.Applepay().config() failed, falling back to REST", e);
                    }
                    const payload = await applepay.validateMerchant({ validationUrl: event.validationURL });
                    if (payload && payload.merchantSession) {
                        session.completeMerchantValidation(payload.merchantSession);
                        console.log("Merchant validation successful via PayPal SDK");
                        apValidated = true;
                        alert("Merchant validated (PayPal SDK)");
                        return;
                    }
                    console.warn("PayPal SDK validateMerchant returned unexpected payload", payload);
                    try { alert("PayPal validateMerchant unexpected payload: " + JSON.stringify(payload)); } catch(_) { alert("PayPal validateMerchant unexpected payload"); }
                }

                // Fallback: direct call to PayPal validate endpoint
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

                if (!validateRes.ok) {
                    const text = await validateRes.text();
                    console.error("Merchant validation HTTP error", validateRes.status, text);
                    alert("Merchant validation failed (HTTP " + validateRes.status + " " + text + "). Check domain association / credentials.");
                    session.abort();
                    hideApplePayLoader();
                    return;
                }

                const merchantSession = await validateRes.json();
                if (!merchantSession || typeof merchantSession !== "object") {
                    console.error("Invalid merchant session payload", merchantSession);
                    alert("Merchant validation failed (bad payload).");
                    session.abort();
                    hideApplePayLoader();
                    return;
                }
                session.completeMerchantValidation(merchantSession);
                console.log("Merchant validation successful via REST");
                apValidated = true;
                alert("Merchant validated (REST)");
            } catch (err) {
                console.error("Merchant validation failed", err);
                alert("Apple Pay validation failed: " + (err && err.message ? err.message : err));
                session.abort();
                hideApplePayLoader();
            }
        };

        // --- Payment Authorization ---
        session.onpaymentauthorized = async (event) => {
            try {
                const paymentData = event.payment;
                apAuthorized = true;
                alert("Payment authorized. Creating PayPal order…");

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
                    alert("Failed to create PayPal order.");
                    throw new Error("Failed to create PayPal order");
                }
                const paypalOrderId = createOrderResponse.id;

                // 2. Confirm Apple Pay payment with PayPal
                if (!window.paypal || !paypal.Applepay) {
                    alert("PayPal Applepay SDK not available.");
                    throw new Error("PayPal Applepay SDK not available");
                }
                const { status } = await paypal.Applepay().confirmOrder({
                    orderId: paypalOrderId,
                    token: paymentData.token,
                    billingContact: paymentData.billingContact,
                    shippingContact: paymentData.shippingContact
                });

                if (status === "APPROVED") {
                    // 3. Capture the order
                    const captureRes = await capturePayPalOrder(paypalOrderId);
                    // 4. Notify backend
                    const backendRes = await fetch("/handle-apple-pay", {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({
                            payment: paymentData,
                            captureRes,
                            tokenOrdIdUpdated: orderId
                        })
                    });
                    if (!backendRes.ok) {
                        const text = await backendRes.text();
                        alert("Order update failed (" + backendRes.status + "): " + text);
                        throw new Error("Backend update failed");
                    }
                    const backendData = await backendRes.json();

                    if (backendData.success) {
                        session.completePayment(ApplePaySession.STATUS_SUCCESS);
                        hideApplePayLoader();
                        window.location.href = backendData.redirect || "/payment/success";
                    } else {
                        session.completePayment(ApplePaySession.STATUS_FAILURE);
                        alert("Failed to update order: " + (backendData.message || ""));
                        hideApplePayLoader();
                    }
                } else {
                    session.completePayment(ApplePaySession.STATUS_FAILURE);
                    alert("Apple Pay not approved (status=" + status + ")");
                    hideApplePayLoader();
                }
            } catch (err) {
                console.error("Apple Pay processing error:", err);
                try { session.completePayment(ApplePaySession.STATUS_FAILURE); } catch(e) {}
                alert("Apple Pay failed to authorize or capture. See console for details.");
                hideApplePayLoader();
            }
        };

        session.oncancel = () => {
            apCancelled = true;
            alert("Apple Pay cancelled.");
            console.log("Apple Pay sheet cancelled by user");
            hideApplePayLoader();
        };

        session.begin();

        // Watchdog: if neither validated nor cancelled/authorized within 10s, alert probable cause
        setTimeout(() => {
            if (!apValidated && !apCancelled && !apAuthorized) {
                alert("Apple Pay closed before validation. Ensure HTTPS, domain association, and valid PayPal credentials.");
                hideApplePayLoader();
            }
        }, 10000);
    } catch (err) {
        console.error("Apple Pay trigger error:", err);
        alert("Unable to start Apple Pay: " + err.message);
        hideApplePayLoader();
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

    const response = await fetch(`${APPLE_PAY_BASE}/v1/oauth2/token`, {
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
function isRegionSupported() {
    // List of Apple Pay supported country codes (ISO 3166-1 alpha-2)
    const supportedRegions = [
        'US', 'GB', 'CA', 'AU', 'JP', 'SG', 'CH', 'FR', 'DE', 'IT', 'ES',
        'SE', 'RU', 'NZ', 'BR', 'MX', 'HK', 'DK', 'FI', 'NO', 'AE', 'SA',
        'IE', 'NL', 'BE', 'AT', 'PL', 'CZ', 'PT', 'LU', 'KR', 'TW', 'MY',
        // Add other countries Apple Pay supports as needed
    ];

    // Attempt to detect user's country via browser language or geo
    const region = (navigator.language || navigator.userLanguage || '').split('-')[1];
    if (!region) return false;

    return supportedRegions.includes(region.toUpperCase());
}
// async function generateApplePayAccessToken() {
//     console.log("Generating PayPal access token for Apple Pay");
//     const response = await fetch('/paypal/token', { method: 'POST' });
//     const data = await response.json();
//     if (!data.access_token) console.log("Failed to generate PayPal access token");
//     return data.access_token;
// }
// ---------------------- End of applepay_checkout_code.js File ----------------------
