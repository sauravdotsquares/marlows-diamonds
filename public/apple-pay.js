alert("js file")   
document.addEventListener("DOMContentLoaded", function() {
  const finalPriceInput = document.getElementById("final_price");

  if (finalPriceInput) {
    const finalPrice = parseFloat(finalPriceInput.value);
    
  } else {
    console.error("Element with ID 'final_price' not found.");
  }
});



   //start
async function onClick() {
  const paymentRequest = {
    countryCode:"GB",
    currencyCode: "GBP",
    merchantCapabilities:["supports3DS", "supportsCredit", "supportsDebit"],
    supportedNetworks:["masterCard", "discover", "visa", "amex"],
    requiredBillingContactFields: ["name", "phone", "email", "postalAddress"],
    requiredShippingContactFields: [],
    total: {
      label: "Marlows Diamonds",
      amount: "10.00",
      type: "final",
    },
  };

  // eslint-disable-next-line no-undef
  let session = new ApplePaySession(4, paymentRequest);

  
  const applepay = paypal.Applepay();
  const config = await applepay.config();
  session.onvalidatemerchant = async (event) => {
    try {
      const payload = await applepay.validateMerchant({
        validationUrl: event.validationURL,
      });

  
      session.completeMerchantValidation(payload.merchantSession);
    } catch (err) {
      console.error("Error during merchant validationvv:", err);
      session.abort();
    }
  };

  session.onpaymentmethodselected = () => {
    session.completePaymentMethodSelection({
      newTotal: paymentRequest.total,
    });
  };

  session.onpaymentauthorized = async (event) => {
    try {
      /* Create Order on the Server Side */
      const orderResponse = await fetch(`/api/orders`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
      });

      if (!orderResponse.ok) {
        throw new Error("error creating order");
      }

      const orderID = await orderResponse.json();
      let id = orderID.id;
      /**
       * Confirm Payment
       */
      await applepay.confirmOrder({
        orderId: id,
        token: event.payment.token,
        billingContact: event.payment.billingContact,
        shippingContact: event.payment.shippingContact,
      });

      

      /*
       * Capture order (must currently be made on server)
       */
      await fetch(`/api/orders/${id}/capture`, {
        method: "POST",
      });

      session.completePayment({
        status: window.ApplePaySession.STATUS_SUCCESS,
      });
    } catch (err) {
      session.completePayment({
        status: window.ApplePaySession.STATUS_FAILURE,
      });
    }
  };

  session.oncancel = () => {
    console.log("Apple Pay Cancelled !!");
  };

  session.begin();
}
//end




const PURCHASE_AMOUNT = "1000";
const CURRENCY_CODE = "GBP"; // Adjust as needed
const APPLE_PAY_LABEL = "My Store";
const BASE_URL = "https://api.paypal.com"; // Use PayPal's sandbox URL or production URL based on your environment

// Initialize Apple Pay
async function initializeApplePay() {
  // Check if Apple Pay is supported
  if (!window.ApplePaySession) {
    console.error("This device does not support Apple Pay");
    return;
  }

  if (!ApplePaySession.canMakePayments()) {
    console.error("This device is not capable of making Apple Pay payments");
    return;
  }

  const buttonContainer = document.getElementById("applepay-button-container");

    // Check if the button container exists
    if (buttonContainer) {
        // Check if the Apple Pay button already exists
        if (!document.getElementById("btn-appl")) {
            // Create and style the Apple Pay button
            const button = document.createElement("button");
            button.id = "btn-appl";  // Set the ID to prevent duplicates
            button.type="buy";
            button.locale="en";
            button.buttonstyle="black";
            button.style = `
                appearance: -apple-pay-button;
                -apple-pay-button-type: buy;
                -apple-pay-button-style: black;
                width: 100%;
                height: 44px;
                margin-top: 10px;
            `;

            // Add event listener for button click
            button.addEventListener("click", () => onClick());

            // Append the button to the container
            buttonContainer.appendChild(button);
        }
    } else {
        console.warn("Apple Pay button container not found.");
    }



// //start
// async function onClick() {
//   console.log('onclick')
//   console.log({ merchantCapabilities, currencyCode, supportedNetworks });

//   const paymentRequest = {
//     countryCode,
//     currencyCode: "GBP",
//     merchantCapabilities,
//     supportedNetworks,
//     requiredBillingContactFields: ["name", "phone", "email", "postalAddress"],
//     requiredShippingContactFields: [],
//     total: {
//       label: "Demo (Card is not charged)",
//       amount: "10.00",
//       type: "final",
//     },
//   };

//   // eslint-disable-next-line no-undef
//   let session = new ApplePaySession(4, paymentRequest);

//   session.onvalidatemerchant = (event) => {
//     applepay
//       .validateMerchant({
//         validationUrl: event.validationURL,
//       })
//       .then((payload) => {
//         session.completeMerchantValidation(payload.merchantSession);
//       })
//       .catch((err) => {
//         console.error(err);
//         session.abort();
//       });
//   };

//   session.onpaymentmethodselected = () => {
//     session.completePaymentMethodSelection({
//       newTotal: paymentRequest.total,
//     });
//   };

//   session.onpaymentauthorized = async (event) => {
//     try {
//       /* Create Order on the Server Side */
//       const orderResponse = await fetch(`/api/orders`, {
//         method: "POST",
//         headers: {
//           "Content-Type": "application/json",
//         },
//       });
//       if (!orderResponse.ok) {
//         throw new Error("error creating order");
//       }

//       console.log('orderResponse', orderResponse)

//       const orderID = await orderResponse.json();
//       let id = orderID.id;
//       console.log({ id });
//       /**
//        * Confirm Payment
//        */
//       await applepay.confirmOrder({
//         orderId: id,
//         token: event.payment.token,
//         billingContact: event.payment.billingContact,
//         shippingContact: event.payment.shippingContact,
//       });

      

//       /*
//        * Capture order (must currently be made on server)
//        */
//       await fetch(`/api/orders/${id}/capture`, {
//         method: "POST",
//       });

//       session.completePayment({
//         status: window.ApplePaySession.STATUS_SUCCESS,
//       });
//     } catch (err) {
//       console.error(err);
//       session.completePayment({
//         status: window.ApplePaySession.STATUS_FAILURE,
//       });
//     }
//   };

//   session.oncancel = () => {
//     console.log("Apple Pay Cancelled !!");
//   };

//   session.begin();
// }
// //end











  // // Render Apple Pay button
  // document.getElementById("applepay-button-container").innerHTML =
  //   '<apple-pay-button id="btn-appl" buttonstyle="black" type="buy" locale="en"></apple-pay-button>';

  // // Add event listener to button for payment session
  // document.getElementById('btn-appl').addEventListener('click', function() {
  //   startApplePaySession();
  // });
}

// Start Apple Pay Session
async function startApplePaySession() {
  const paymentRequest = {
    countryCode: 'GB', // Adjust as per your region
    supportedNetworks: ['visa', 'masterCard', 'amex'],
    merchantCapabilities: ['supports3DS'],
    currencyCode: CURRENCY_CODE,
    total: {
      label: APPLE_PAY_LABEL,
      amount: PURCHASE_AMOUNT,
    },
  };

  const session = new ApplePaySession(3, paymentRequest);

  session.onvalidatemerchant = async (event) => {
    // Merchant validation
    try {
      const validationURL = event.validationURL;
      const merchantSession = await validateMerchant(validationURL);
      session.completeMerchantValidation(merchantSession);
    } catch (error) {
      session.abort();
      console.log("Merchant validation failed:", error);
    }
  };

  session.onpaymentauthorized = async (event) => {
    // Handle payment authorization
    const payment = event.payment;
    console.log('Payment authorized:', payment);

    try {
      const orderData = await createOrder(); // Create an order
      if (orderData && orderData.id) {
        const captureData = await capturePayment(orderData.id); // Capture the payment for the order
        session.completePayment(ApplePaySession.STATUS_SUCCESS);

        
        
      } else {
        session.completePayment(ApplePaySession.STATUS_FAILURE);
        console.error("Failed to create PayPal order.");
      }
    } catch (error) {
      console.error("Payment capture failed:", error);
      session.completePayment(ApplePaySession.STATUS_FAILURE);
    }
  };

  session.begin();
}

// Merchant validation
async function validateMerchant(validationURL) {
  const accessToken = await generateAccessToken();
  const response = await fetch(`${BASE_URL}/v1/apple-pay/validate-payment`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      Authorization: `Bearer ${accessToken}`,
    },
    body: JSON.stringify({
      validationUrl: validationURL,
      displayName: APPLE_PAY_LABEL,
    }),
  });
  

  if (!response.ok) {
    throw new Error("Merchant validation failed");
  }

  const merchantSession = await response.json();
  return merchantSession;
}


// Create an order
async function createOrder() {
  const accessToken = await generateAccessToken();
  const url = `${BASE_URL}/v2/checkout/orders`;
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
            currency_code: CURRENCY_CODE,
            value: PURCHASE_AMOUNT,
          },
        },
      ],
    }),
  });
  const data = await response.json();
  return data;
}

// Capture payment for an order
async function capturePayment(orderId) {
  const accessToken = await generateAccessToken();
  const url = `${BASE_URL}/v2/checkout/orders/${orderId}/capture`;
  const response = await fetch(url, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      Authorization: `Bearer ${accessToken}`,
    },
  });
  const data = await response.json();
  return data;
}

// Generate access token
async function generateAccessToken() {
  const clientId = "AXc2YDyTWs6VKh-EdMFo1MV1zQ7vzYzLcPTvpmYg5rHMZxSgySqtLpT-5v13dRIxG6vxvrjb1X9QvBJR";  // Replace with your PayPal client ID
  const secret = "EITsZpoj19pYPdScdV6rIaJpFzND_qJDLFlhQBqHkYNhfYv__7fHwS2ESOSj7D_40_CSfJaf1rV7FD1V"; // Replace with your PayPal secret
  const response = await fetch(`${BASE_URL}/v1/oauth2/token`, {
    method: "POST",
    headers: {
      "Authorization": `Basic ${btoa(clientId + ":" + secret)}`,
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: "grant_type=client_credentials",
  });
  const data = await response.json();
  return data.access_token;
}

// Initialize Apple Pay when the DOM is fully loaded
document.addEventListener("DOMContentLoaded", initializeApplePay);