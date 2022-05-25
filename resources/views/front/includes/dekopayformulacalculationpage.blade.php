<div ng-controller="DekopayController" ng-init="financeOptionsCheckout()">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Finance Options</h5>
                {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
            </div>
            <div class="modal-body">
                <div class="col-lg-12">

                    <div class="finance-available-options">
                        <input type="hidden" name="preSetValue" id="preSetValue"
                            value="{{ env('DEKOPAY_MIN_AMT_EMI') }}">

                        <ul class="payments">
                            <li>
                                <p> Price : </p>
                                <p>
                                    <input type="hidden" min="10" interval="0.01" value="1026" id="totalOrder">
                                    <input id="totalOrderText1" type="text" value="1026.00">
                                </p>
                            </li>
                            <li>
                                <p> Finance Type : </p>
                                <p>
                                    <select id="terms" name="term">
                                        <option value="ONIB12-16.9" selected=""> 12 Months Credit 16.9%</option>
                                        <option value="ONIB18-16.9"> 18 Months Credit 16.9%</option>
                                        <option value="ONIB24-16.9"> 24 Months Credit 16.9%</option>
                                        <option value="ONIB36-16.9"> 36 Months Credit 16.9%</option>
                                        <option value="ONIB48-16.9"> 48 Months Credit 16.9%</option>
                                    </select>
                                </p>
                            </li>
                            <li>
                                <p>Deposit :</p>
                                <p>
                                    <select id="payed" name="percentage">
                                        <option value="10" selected="">10%</option>
                                        <option value="20">20%</option>
                                        <option value="30">30%</option>
                                        <option value="40">40%</option>
                                        <option value="50">50%</option>
                                    </select>
                                </p>
                            </li>
                        </ul>
                        <p class="deko-calculate">
                            <button id="calculatebutton" class="btn" ng-click="calculate()">Calculate</button>
                        </p>
                        <ul class="pay_details" id="OCFDefault">
                            <li class="clearfix">
                                <p> Monthly Payment </p>
                                <p class="priced"> {{ MY_CURRENCY_SYMBOL }} <span id="perMonths">83.66</span>
                                </p>
                            </li>
                            <li class="clearfix">
                                <p> Cash Price </p>
                                <p class="priced"> {{ MY_CURRENCY_SYMBOL }} <span id="cashPrices">1026.00</span>
                                </p>
                            </li>
                            <li class="clearfix">
                                <p> Deposit to Pay</p>
                                <p class="priced"> {{ MY_CURRENCY_SYMBOL }} <span id="Deposited">102.60</span>
                                </p>
                            </li>
                            <li class="clearfix">
                                <p> Loan Amount </p>
                                <p class="priced"> {{ MY_CURRENCY_SYMBOL }} <span id="loanAmt">923.40</span></p>
                            </li>
                            <li class="clearfix">
                                <p> Loan Repayment </p>
                                <p class="priced">{{ MY_CURRENCY_SYMBOL }} <span id="loanRepay">1003.90</span>
                                </p>
                            </li>
                            <li class="clearfix">
                                <p> Cost of Loan</p>
                                <p class="priced"> {{ MY_CURRENCY_SYMBOL }} <span id="costLoan">80.50</span>
                                </p>
                            </li>
                            <li class="clearfix">
                                <p> Total Amount Payable </p>
                                <p class="priced"> {{ MY_CURRENCY_SYMBOL }} <span id="totalAmt">1106.50</span>
                                </p>
                            </li>
                            <li class="clearfix">
                                <p> Number of Monthly Payments </p>
                                <p class="priced"> <span id="noTerm">12</span> </p>
                            </li>
                        </ul>
                        <p class="finance_options_provided">Finance options powered by <img
                                src="/images/Deko_landscape_colour_whiteBG200px_wide.png"
                                style="height:25px;" class="nolazy" alt="DEKO"></p>

                        <input type="hidden" id="enableId" value="OCFDefault"> <br>
                        <div>

                        </div>


                    </div>
                    <div class="finance_options_not_available" style="display: none;">
                        <p>Finance options are not available for this product due to less amount.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

