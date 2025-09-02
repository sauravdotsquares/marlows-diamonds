/*
* Define the version of the Google Pay API referenced when creating your
* configuration
*/
const baseRequest = {
  apiVersion: 2,
  apiVersionMinor: 0,
};
let paymentsClient = null,
  allowedPaymentMethods = null,
  merchantInfo = null;
/* Configure your site's support for payment methods supported by the Google Pay */
function getGoogleIsReadyToPayRequest(allowedPaymentMethods) {
  return Object.assign({}, baseRequest, {
    allowedPaymentMethods: allowedPaymentMethods,
  });
}
/* Fetch Default Config from PayPal via PayPal SDK */
async function getGooglePayConfig() {
  if (allowedPaymentMethods == null || merchantInfo == null) {
    const googlePayConfig = await paypal.Googlepay().config();
    allowedPaymentMethods = googlePayConfig.allowedPaymentMethods;
    merchantInfo = googlePayConfig.merchantInfo;
  }
  return {
    allowedPaymentMethods,
    merchantInfo,
  };
}
/* Configure support for the Google Pay API */
async function getGooglePaymentDataRequest() {
  const paymentDataRequest = Object.assign({}, baseRequest);
  const { allowedPaymentMethods, merchantInfo } = await getGooglePayConfig();
  paymentDataRequest.allowedPaymentMethods = allowedPaymentMethods;
  paymentDataRequest.transactionInfo = getGoogleTransactionInfo();
  paymentDataRequest.merchantInfo = merchantInfo;
  paymentDataRequest.callbackIntents = ["PAYMENT_AUTHORIZATION"];
  return paymentDataRequest;
}
function onPaymentAuthorized(paymentData) {
  return new Promise(function (resolve, reject) {
    processPayment(paymentData)
      .then(function (data) {
        resolve({ transactionState: "SUCCESS" });
      })
      .catch(function (errDetails) {
        resolve({ transactionState: "ERROR" });
      });
  });
}
function getGooglePaymentsClient() {
  if (paymentsClient === null) {
    paymentsClient = new google.payments.api.PaymentsClient({
      environment: "PRODUCTION",  // Change from "TEST" to "PRODUCTION"
      paymentDataCallbacks: {
        onPaymentAuthorized: onPaymentAuthorized,
      },
    });
  }
  return paymentsClient;
}
async function onGooglePayLoaded() {
  const paymentsClient = getGooglePaymentsClient();
  const { allowedPaymentMethods } = await getGooglePayConfig();
  paymentsClient
    .isReadyToPay(getGoogleIsReadyToPayRequest(allowedPaymentMethods))
    .then(function (response) {
      if (response.result) {
         addGooglePayButton();
       // console.log('Google Pay is not available.');
      }
    })
    .catch(function (err) {
      console.error(err);
    });
}
function addGooglePayButton() {
  const paymentsClient = getGooglePaymentsClient();
  const button = paymentsClient.createButton({
    onClick: onGooglePaymentButtonClicked(),
  });
  document.getElementById("container").appendChild(button);
}
function getGoogleTransactionInfo(subtotal) {
  return {
    displayItems: [
      {
        label: "Subtotal",
        type: "SUBTOTAL",
        price: subtotal,
      },
      {
        label: "Tax",
        type: "TAX",
        price: "0",
      },
    ],
    countryCode: "GB",
    currencyCode: "GBP",
    totalPriceStatus: "FINAL",
    totalPrice: subtotal,
    totalPriceLabel: "Total",
  };
}

async function onGooglePaymentButtonClicked(price,orderData) {
  const subtotal = price.toString();
  const paymentDataRequest = await getGooglePaymentDataRequest(subtotal);
  paymentDataRequest.transactionInfo = getGoogleTransactionInfo(subtotal);
  const paymentsClient = getGooglePaymentsClient();
  paymentsClient.loadPaymentData(paymentDataRequest,subtotal);
}

const base = 'https://api.paypal.com'; // For live environment

async function processPayment(payment) {
    const tokenOrdIdUpdated = $('#tokenOrdId').val();
    const final_price = $('#final_price').val();
      // Retrieve transaction info
   const { currencyCode, subtotal } = getGoogleTransactionInfo();

    try {
      
        const purchaseAmount = final_price; // Replace with dynamic amount as needed
        const currency = "GBP"; // Set the appropriate currency

        // Step 1: Create the PayPal order
        const createOrderResponse = await createGoogleOrder(purchaseAmount, currency);

        if (createOrderResponse.status === 'CREATED') {
            const orderId = createOrderResponse.id;
            console.log(orderId,"orderId")

            // Step 2: Confirm the order with Google Pay
            const { status } = await paypal.Googlepay().confirmOrder({
                orderId: orderId,
                paymentMethodData: payment.paymentMethodData,
            });

            const captureResponse = await captureGooglePayment(orderId);
            // Step 3: Capture the payment if approved
            if (status === "APPROVED") {
                console.log(captureResponse);
                return fetch("/process-apple-pay", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ payment,tokenOrdIdUpdated,captureResponse }),
                })
                .then((response) => response.json())  // Parse JSON from the response
                .then((data) => {
                    // Log the parsed data (response body) here
                    if (data.success) {
                      window.location.href = data.redirect;
                    } else {
                        alert('Failed to update order status:', data);
                    }
                    return data;  // Return the data if needed later
                })
                .catch((error) => {
                    // Handle any errors that occur during the fetch
                    console.error("Error during fetch:", error);
                });
              return { transactionState: "SUCCESS" };
            }else if(status === "PAYER_ACTION_REQUIRED"){
                console.log(" ===== Confirm Payment Completed Payer Action Required ===== ");
                paypal
                  .Googlepay()
                  .initiatePayerAction({ orderId: id })
                  .then(async () => {
                    /*
                    * CAPTURE THE ORDER
                    */
                    console.log(" ===== Payer Action Completed ===== ");
                    const captureResponse = await captureGooglePayment(orderId);
                    console.log(" ===== Order Capture Completed ===== ");
                    return fetch("/process-apple-pay", {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ payment,tokenOrdIdUpdated,captureResponse }),
                    })
                    .then((response) => response.json())  // Parse JSON from the response
                    .then((data) => {
                        // Log the parsed data (response body) here
                        if (data.success) {
                          window.location.href = data.redirect;
                        } else {
                          alert('Failed to update order status:' + JSON.stringify(data,null,2));
                        }
                        return data;  // Return the data if needed later
                    })
                    .catch((error) => {
                        // Handle any errors that occur during the fetch
                        console.error("Error during fetch:", error);
                        alert('Error during fetch:' + error);
                    });
                  });
            } else {
                console.error("Payment failed during confirmation with PayPal.");
                return { transactionState: "ERROR" };
            }
        } else {
            console.error("Failed to create PayPal order:", createOrderResponse);
            return { transactionState: "ERROR" };
        }
    } catch (err) {
        console.error("Error during payment processing:", err);
        return {
            transactionState: "ERROR",
            error: { message: err.message },
        };
    }
}


// Function to create an order using PayPal API
async function createGoogleOrder(purchaseAmount, currencyCode) {
    const accessToken = await generateGoogleAccessToken(); // Get your PayPal access token
    const url = `${base}/v2/checkout/orders`; // API endpoint for creating orders

    const response = await fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${accessToken}`,
        },
        body: JSON.stringify({
            intent: "CAPTURE",
            purchase_units: [
                {
                    amount: {
                        currency_code: currencyCode,
                        value: purchaseAmount,
                    },
                },
            ],
        }),
    });

    const data = await response.json();
    return data;  // Return the response from PayPal's order creation
}

// Function to capture payment for a given order using PayPal API
async function captureGooglePayment(orderId) {
    const accessToken = await generateGoogleAccessToken(); // Get your PayPal access token
    const url = `${base}/v2/checkout/orders/${orderId}/capture`; // API endpoint for capturing payments

    const response = await fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${accessToken}`,
        },
    });

    const data = await response.json();
    return data;  // Return the response after capturing the payment
}

// Function to generate an access token for PayPal
async function generateGoogleAccessToken() {

    // Base64 encode client credentials (if not done previously)
    const clientId = "AXc2YDyTWs6VKh-EdMFo1MV1zQ7vzYzLcPTvpmYg5rHMZxSgySqtLpT-5v13dRIxG6vxvrjb1X9QvBJR";  // Replace with your actual PayPal Client ID
    const clientSecret = "EITsZpoj19pYPdScdV6rIaJpFzND_qJDLFlhQBqHkYNhfYv__7fHwS2ESOSj7D_40_CSfJaf1rV7FD1V";  // Replace with your actual PayPal Client Secret
    const clientCredentials = `${clientId}:${clientSecret}`;
    const base64EncodedClientCredentials = btoa(clientCredentials);  // Base64 encode the credentials
    // const base64EncodedClientCredentials = 'QWZMUWNSdVk4QzJWY3Bkc1NJbXVwNEUxMHZZaTVZaTN3NGdKNmQxV2hxdWJLYkh0dGR3cFVlOFJJVzFwVmtXME9zclhXNHVOQmw0NFJJcXA6RUJ6cDdFck01X01BNVlPekJKeEtwQTRhWnF0ZmNoazVuRkU4YXVOWEV5cDZVcnhzQ21XWC1lNlNsVWJaT2NPVVJzNF9pdUNfUlNxTlAzZU8=';  // encode token

    // Make a request to PayPal to get an access token
    const response = await fetch(`${base}/v1/oauth2/token`, {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            Authorization: `Basic ${base64EncodedClientCredentials}`,  // Use the Base64 encoded client credentials
        },
        body: new URLSearchParams({
            grant_type: "client_credentials",
        }),
    });

    const data = await response.json();
    return data.access_token;  // Return the access token
}