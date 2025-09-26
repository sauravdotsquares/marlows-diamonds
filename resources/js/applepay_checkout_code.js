async function triggerApplePayViaPayPal(price, merchantOrderId, currency = "GBP") {
    try {
        // ✅ Step 1: Check if Apple Pay is supported
        if (window.ApplePaySession && ApplePaySession.canMakePayments()) {
            console.log("Apple Pay is available");
        } else {
            console.error("Apple Pay is not available on this device/browser.");
            alert("Apple Pay is not supported here.");
            return;
        }

        // ✅ Step 2: Create PayPal order on server
        const createRes = await fetch("/paypal/create-order", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.content || ""
            },
            body: JSON.stringify({
                merchant_order_id: merchantOrderId,
                amount: price,
                currency: currency
            })
        });

        const orderData = await createRes.json();
        if (!orderData.id) throw new Error("PayPal order creation failed.");
        const paypalOrderId = orderData.id;

        // ✅ Step 3: Build Apple Pay request
        const request = {
            countryCode: "GB",
            currencyCode: currency,
            merchantCapabilities: ["supports3DS", "supportsCredit", "supportsDebit"],
            supportedNetworks: ["visa", "masterCard", "amex", "discover"],
            total: {
                label: "Marlows Diamond",
                amount: price.toFixed(2).toString(),
                type: "final"
            }
        };

        const session = new ApplePaySession(3, request);

        // ✅ Step 4: Merchant validation (Apple requires HTTPS call)
        session.onvalidatemerchant = async (event) => {
            console.log("Merchant validation:", event.validationURL);
            try {
                const validateRes = await fetch("/applepay/validate-merchant", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.content || ""
                    },
                    body: JSON.stringify({
                        validationUrl: event.validationURL
                    })
                });
                const merchantSession = await validateRes.json();
                session.completeMerchantValidation(merchantSession);
            } catch (err) {
                console.error("Merchant validation failed", err);
                session.abort();
            }
        };

        // ✅ Step 5: Handle payment authorization
        session.onpaymentauthorized = async (event) => {
            try {
                const paymentData = event.payment;

                // Capture PayPal order
                const captureRes = await fetch("/paypal/capture-order", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.content || ""
                    },
                    body: JSON.stringify({
                        paypal_order_id: paypalOrderId,
                        merchant_order_id: merchantOrderId,
                        applepay_payment: paymentData // optional: save raw Apple Pay response
                    })
                });

                const captureResult = await captureRes.json();

                if (captureResult.success) {
                    session.completePayment(ApplePaySession.STATUS_SUCCESS);
                    window.location.href = "/payment/success";
                } else {
                    session.completePayment(ApplePaySession.STATUS_FAILURE);
                    alert("Payment failed: " + (captureResult.message || ""));
                }
            } catch (err) {
                console.error("Capture error:", err);
                session.completePayment(ApplePaySession.STATUS_FAILURE);
            }
        };

        // ✅ Step 6: Start Apple Pay sheet
        session.begin();

    } catch (err) {
        console.error("Apple Pay trigger error:", err);
        alert("Unable to start Apple Pay.");
    }
}
