let base;
let googlePayEnvironment
if (environmentCheckPhp == 'production') {
    base = PAYPAL_BASE_URL_PHP; // For live environment
    googlePayEnvironment = 'PRODUCTION';

} else {
    base = PAYPAL_BASE_URL_PHP; // For local environment
    googlePayEnvironment = 'TEST';
    // googlePayEnvironment = 'PRODUCTION';
}
/*
* Base request for Google Pay
*/
const baseRequest = {
    apiVersion: 2,
    apiVersionMinor: 0,
};

let paymentsClient = null;
let allowedPaymentMethods = null;
let merchantInfo = null;

/* === STEP 1: Fetch Google Pay config from PayPal SDK === */
async function getGooglePayConfig() {
    if (!allowedPaymentMethods || !merchantInfo) {
        const googlePayConfig = await paypal.Googlepay().config();
        if (!googlePayConfig || !googlePayConfig.allowedPaymentMethods) {
            console.log("Google Pay config invalid or not loaded");
        }
        allowedPaymentMethods = googlePayConfig.allowedPaymentMethods;
        merchantInfo = googlePayConfig.merchantInfo;
    }
    return { allowedPaymentMethods, merchantInfo };
}

/* === STEP 2: Build paymentDataRequest === */
async function getGooglePaymentDataRequest(subtotal) {
    const { allowedPaymentMethods, merchantInfo } = await getGooglePayConfig();
    if (!allowedPaymentMethods || !merchantInfo) {
        console.error("Google Pay config missing!");
        return null;
    }

    return Object.assign({}, baseRequest, {
        allowedPaymentMethods,
        merchantInfo,
        transactionInfo: getGoogleTransactionInfo(subtotal),
        // callbackIntents: ["PAYMENT_AUTHORIZATION"],
    });
}

/* === STEP 3: Define transaction details === */
function getGoogleTransactionInfo(subtotal) {
    return {
        displayItems: [
            { label: "Subtotal", type: "SUBTOTAL", price: subtotal },
            { label: "Tax", type: "TAX", price: "0" },
        ],
        countryCode: "GB",
        currencyCode: "GBP",
        totalPriceStatus: "FINAL",
        totalPrice: subtotal,
        totalPriceLabel: "Total",
    };
}

/* === STEP 4: Create Google Payments client === */
function getGooglePaymentsClient() {
    if (!paymentsClient) {
        paymentsClient = new google.payments.api.PaymentsClient({
            environment: googlePayEnvironment, // change to "PRODUCTION" later
            // paymentDataCallbacks: {
            // onPaymentAuthorized: onPaymentAuthorized,
            // },
        });
    }
    return paymentsClient;
}

/* === STEP 5: Handle payment authorization callback === */
function onPaymentAuthorized(paymentData) {
    return new Promise((resolve) => {
        processPayment(paymentData)
            .then(() => resolve({ transactionState: "SUCCESS" }))
            .catch(() => resolve({ transactionState: "ERROR" }));
    });
}

/* === STEP 6: Triggered only when user selects Google Pay === */
async function onGooglePaymentButtonClicked(price, orderId, payloadGooglepay, isCallFromAjax = false) {
    console.group("GooglePay Triggered");
    console.log("🔔 onGooglePaymentButtonClicked called with:", { price, orderId });
    console.trace("Call stack:");
    console.groupEnd();
    if (!isCallFromAjax)
        return;
    try {
        const subtotal = price.toString();
        const paymentsClient = getGooglePaymentsClient();
        const paymentDataRequest = await getGooglePaymentDataRequest(subtotal);

        const paymentData = await paymentsClient.loadPaymentData(paymentDataRequest);
        console.log('paymentData====>');
        console.log(paymentData);

        // Send result to backend for processing
        await processPayment(paymentData, payloadGooglepay, orderId);
    } catch (err) {
        console.error("Google Pay error:", err);
        alert("Googlepay is not available! Please try again later.");
        
    }
}

/* === STEP 7: Process the payment with PayPal APIs === */
async function processPayment(paymentData, payloadGooglepay, orderID) {
    const customOrderID = orderID;

    const final_price = $('#final_price').val();

    try {
        // Create PayPal order
        const createOrderResponse = await createGoogleOrder(payloadGooglepay, final_price, "GBP");

        if (createOrderResponse.status === 'CREATED') {
            const orderId = createOrderResponse.id;

            const { status } = await paypal.Googlepay().confirmOrder({
                orderId: orderId,
                paymentMethodData: paymentData.paymentMethodData,
            });

            if (status === "APPROVED") {
                const captureResponse = await captureGooglePayment(orderId);

                return fetch("/process-google-pay", {
                    method: "POST",
                    // method: "GET",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ customOrderID, captureResponse }),
                })
                    .then((res) => res.json())
                    .then((data) => {
                        if (data.success) {
                            window.location.href = data.redirect;
                        } else {
                            alert("Failed to update order status");
                        }
                        return data;
                    });
            }
        }
    } catch (err) {
        console.error("Payment processing failed:", err);
        throw err;
    }
}


/* === STEP 8: Create & Capture order using PayPal API === */
async function createGoogleOrder(payloadGooglepay, purchaseAmount, currencyCode) {
    const accessToken = await generateGoogleAccessToken();
    const url = `${base}/v2/checkout/orders`;

    const response = await fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${accessToken}`,
        },
        body: JSON.stringify(payloadGooglepay, null, 2),
    });
    return response.json();
}

async function captureGooglePayment(orderId) {
    const accessToken = await generateGoogleAccessToken();
    const url = `${base}/v2/checkout/orders/${orderId}/capture`;

    const response = await fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${accessToken}`,
        },
    });
    return response.json();
}

async function generateGoogleAccessToken() {
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
