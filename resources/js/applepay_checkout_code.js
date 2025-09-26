// ---------------------- Environment Setup ----------------------
let APPLE_PAY_BASE, PAYPAL_CLIENT_ID, PAYPAL_SECRET;

APPLE_PAY_BASE = PAYPAL_BASE_URL_PHP; // Dynamic URL for both production and sandbox in this case from .env
PAYPAL_CLIENT_ID = PAYPAL_CLIENT_ID_PHP;
PAYPAL_SECRET = PAYPAL_SECRET_PHP;

// ---------------------- Apple Pay Trigger ----------------------
async function triggerApplePayViaPayPal(price, orderId, currency = "GBP") {
    console.group("Apple Pay Triggered");
    console.log("Order ID:", orderId, "Price:", price, "Environment:", environmentCheckPhp);
    console.groupEnd();

    try {
        const cleanPrice = parseFloat(String(price).replace(/,/g, "").trim());
        if (isNaN(cleanPrice) || cleanPrice <= 0) throw new Error("Invalid price: " + price);

        if (!window.ApplePaySession || !ApplePaySession.canMakePayments()) {
            console.warn("Apple Pay is not available on this device/browser.");
            alert("Apple Pay is not supported here.");
            return;
        }

        const amountStr = cleanPrice.toFixed(2);

        // --- Build PayPal Apple Pay payload ---
        const payload = {
            intent: "CAPTURE",
            purchase_units: [{
                reference_id: String(orderId),
                amount: { currency_code: currency, value: amountStr }
            }],
            application_context: { shipping_preference: "NO_SHIPPING" }
        };

        // --- Create PayPal order ---
        const createOrderResponse = await createPayPalOrder(payload);
        if (!createOrderResponse?.id) throw new Error("Failed to create PayPal order for Apple Pay");
        const paypalOrderId = createOrderResponse.id;

        // --- Apple Pay Request ---
        const request = {
            countryCode: "GB",
            currencyCode: currency,
            merchantCapabilities: ["supports3DS"],
            supportedNetworks: ["visa", "masterCard", "amex", "discover"],
            total: { label: "Marlows Diamond", amount: amountStr, type: "final" }
        };

        const session = new ApplePaySession(3, request);

        // --- Merchant Validation ---
        session.onvalidatemerchant = async (event) => {
            try {
                const validateRes = await fetch("/applepay/validate-merchant", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.content || ""
                    },
                    body: JSON.stringify({ validationUrl: event.validationURL })
                });
                const merchantSession = await validateRes.json();
                session.completeMerchantValidation(merchantSession);
            } catch (err) {
                console.error("Merchant validation failed", err);
                session.abort();
            }
        };

        // --- Payment Authorization ---
        session.onpaymentauthorized = async (event) => {
            try {
                const paymentData = event.payment;

                const { status } = await paypal.Applepay().confirmOrder({
                    orderId: paypalOrderId,
                    paymentMethodData: paymentData
                });

                if (status === "APPROVED") {
                    const captureRes = await capturePayPalOrder(paypalOrderId);

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
    const accessToken = await generatePayPalAccessToken();
    const response = await fetch(`${APPLE_PAY_BASE}/v2/checkout/orders`, {
        method: "POST",
        headers: { "Content-Type": "application/json", Authorization: `Bearer ${accessToken}` },
        body: JSON.stringify(payload)
    });
    return response.json();
}

async function capturePayPalOrder(orderId) {
    const accessToken = await generatePayPalAccessToken();
    const response = await fetch(`${APPLE_PAY_BASE}/v2/checkout/orders/${orderId}/capture`, {
        method: "POST",
        headers: { "Content-Type": "application/json", Authorization: `Bearer ${accessToken}` }
    });
    return response.json();
}

async function generatePayPalAccessToken() {
    const creds = `${PAYPAL_CLIENT_ID}:${PAYPAL_SECRET}`;
    const base64Creds = btoa(creds);

    const response = await fetch(`${APPLE_PAY_BASE}/v1/oauth2/token`, {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded", Authorization: `Basic ${base64Creds}` },
        body: new URLSearchParams({ grant_type: "client_credentials" })
    });
    const data = await response.json();
    if (!data.access_token) throw new Error("Failed to generate PayPal access token");
    return data.access_token;
}
// ---------------------- End of applepay_checkout_code.js File ----------------------
