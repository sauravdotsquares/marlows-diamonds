<li class="cc_payment_methods via_deko_payment" ng-controller="DekopayController" ng-init="financeOptionsCheckout()">
    <input type="radio" name="payment_type" required="required" value="dekopay">
    <label class="deko_label">
        Dekopay
        <img src="{{asset('')}}assets/images/dek_one.png" alt="deko">
    </label>
    <div class="payment-box-main-drop deko-pay-box " style="display:none;">
        <div class="finance-available-options">
            <input type="hidden" value="{{ $totalAmount }}" id="totalOrder">
            <input type="hidden" value="ONIB12-16.9" id="default_code">
            <input type="hidden" value="10" id="default_perc">
            <input type="hidden" value="{{env('DEKOPAY_API_KEY')}}" id="myapi">
            <input type="hidden" value="{{env('DEKOPAY_MODE')}}" id="url_check">
            <input type="hidden" name="preSetValue" id="preSetValue" value="{{env('DEKOPAY_MIN_AMT_EMI')}}">

            <input type="hidden" name="payPro" id="payPro" value="ONIB12-16.9">
            <input type="hidden" name="payPer" id="payPer" value="10">
            <p>Pay securely by Credit or Debit card or internet banking through Dekopay
                Secure Servers.</p>
            <div class="deko_finance">
                <img src="../assets/images/Deko_square_colour_whiteBG200px_wide.png"
                    alt="deko">
                <span> Finance Options </span>
            </div>
            <div class="payment-cc-details-box">
                <div class="payment-cc-details-inner">
                    <div class="payment-cc-details-label">
                        Price :
                    </div>
                    <div class="payment-cc-details-values">
                        {{MY_CURRENCY_SYMBOL}} <span id="totalP">{{ $totalAmount }}</span>
                    </div>
                </div>
                <div class="payment-cc-details-inner">
                    <div class="payment-cc-details-label">
                        Term :
                    </div>
                    <div class="payment-cc-details-values">
                    <select id="terms" name="term" ng-model="term" ng-change="dekoInit()">
                        <option value="ONIB12-16.9" ng-selected="ONIB12-16.9"> 12  Months Credit 16.9%</option>
                        <option value="ONIB18-16.9"> 18  Months Credit 16.9%</option>
                        <option value="ONIB24-16.9"> 24 Months Credit 16.9%</option>
                        <option value="ONIB36-16.9"> 36 Months Credit 16.9%</option>
                        <option value="ONIB48-16.9"> 48 Months Credit 16.9%</option>
                    </select>

                    </div>
                </div>
                <div class="payment-cc-details-inner">
                    <div class="payment-cc-details-label">
                        Deposit :
                    </div>
                    <div class="payment-cc-details-values">

                        <select id="payed" name="percentage" ng-model="percentage"  ng-change="dekoInit()">
                            <option value="10" ng-selected="10">10%</option>
                            <option value="20">20%</option>
                            <option value="30">30%</option>
                            <option value="40">40%</option>
                            <option value="50">50%</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="cc_pay_details">
                <div class="cc_pay_details_inner">
                    <div class="cc_pay_details_label">
                        Monthly Payment
                    </div>
                    <div class="cc_pay_details_values">
                        £ <span id="perMonths">  </span>
                    </div>
                </div>
                <div class="cc_pay_details_inner">
                    <div class="cc_pay_details_label">
                        Cash Price
                    </div>
                    <div class="cc_pay_details_values">
                        £ <span id="cashPrices"> </span>
                    </div>
                </div>
                <div class="cc_pay_details_inner">
                    <div class="cc_pay_details_label">
                        Deposit to Pay
                    </div>
                    <div class="cc_pay_details_values">
                        £ <span id="Deposited"> </span>
                    </div>
                </div>
                <div class="cc_pay_details_inner">
                    <div class="cc_pay_details_label">
                        Loan Amount
                    </div>
                    <div class="cc_pay_details_values">
                        £ <span id="loanAmt"> </span>
                    </div>
                </div>
                <div class="cc_pay_details_inner">
                    <div class="cc_pay_details_label">
                        Loan Repayment
                    </div>
                    <div class="cc_pay_details_values">
                        £ <span id="loanRepay"> </span>
                    </div>
                </div>
                <div class="cc_pay_details_inner">
                    <div class="cc_pay_details_label">
                        Cost of Loan
                    </div>
                    <div class="cc_pay_details_values">
                        £ <span id="costLoan"> </span>
                    </div>
                </div>
                <div class="cc_pay_details_inner">
                    <div class="cc_pay_details_label">
                        Total Amount Payable
                    </div>
                    <div class="cc_pay_details_values">
                        £ <span id="totalAmt"> </span>
                    </div>
                </div>
                <div class="cc_pay_details_inner">
                    <div class="cc_pay_details_label">
                        Number of Monthly Payments
                    </div>
                    <div class="cc_pay_details_values">
                        <span id="noTerm"> </span>
                    </div>
                </div>
            </div>
            <input type="hidden" id="enableId" value="OCFDefault">
            <div class="cc_how_apply">
                <strong>HOW TO APPLY</strong>
                <span>Choose Dekopay as your payment method and place your order.</span>
                <span>Finance is only available to permanent UK residents aged between 18
                    and 80, subject to status, terms and conditions apply. For more details
                    about Dekopay please see <a href="{{asset('terms')}}">Terms of Service</a> | <a
                        href="{{asset('privacy-policy')}}">Privacy Policy</a> | <a href="{{asset('faq')}}">FAQ.</a></span>
            </div>
        </div>
        <div class="finance_options_not_available" style="display: none;">
            <p>Finance options are not available due to less amount.</p>
        </div>
    </div>
</li>
