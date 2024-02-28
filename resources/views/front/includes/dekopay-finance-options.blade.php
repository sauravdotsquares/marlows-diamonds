<style>
    .modal-footer {
        justify-content: flex-start;
    }
    .financeoptionprocess{
        max-width:1000px;
    }
.financeoptionprocess .modal-body h5 {color: #000;margin: 0 0 10px;font-weight: bold;}
.financeoptionprocess .col-md-6:first-child {border-right: 1px solid #e4e4e4;}

    @media(max-width:1199px){
    .financeoptionprocess {max-width: 95%;}
    }
    @media(max-width:767px){
.financeoptionprocess .col-md-6:nth-child(1) { order: 2;}
.financeoptionprocess .col-md-6:first-child {border-bottom: none; border-right:none;}
    }
</style>
<div class="modal fade" id="financeAvailableModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" ng-controller="DekopayController">
    <div class="modal-dialog modal-lg financeoptionprocess">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Finance Options</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="modal-title" id="exampleModalLabel">Example</h5>
                    <img src="{{ asset('/assets/images/representativeexample.png') }}" class="nolazy" alt="DEKO"></p>
                </div>
                <div class="col-md-6">
                    <div>
                        <h5 class="modal-title" id="exampleModalLabel">Calculator</h5>
                    </div>
                    <div class="finance-available-options">
                        <input type="hidden" name="preSetValue" id="preSetValue" value="{{env('DEKOPAY_MIN_AMT_EMI')}}">
      
                    <ul class="payments">
                        <li><p> Price : </p>
                            <p>
                                <input type="hidden" min="10" interval="0.01" value="1026" id="totalOrder">
                                <span id="totalOrderText" data-val="324.00">1026.00</span>
                            </p>
                        </li>
                        <li>
                            <p> Finance Type : </p>
                            <p>
                                <select id="terms" name="term">
                                      <option value="ONIB12-22.9" selected="ONIB12-22.9"> 12 Months Promotional Credit (22.9%)</option>
                                      <option value="ONIB24-22.9"> 24 Months Promotional Credit (22.9%)</option>
                                      <option value="ONIB36-22.9"> 36 Months Promotional Credit (22.9%)</option>
                                      <option value="ONIB48-22.9"> 48 Months Promotional Credit (22.9%)</option>
                                      <!-- <option value="ONIB48-22.9"> 48 Months Promotional Credit (22.9%)</option> -->
                                </select>
                            </p>
                        </li>
                        <li><p>Deposit :</p>
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
                        <li class="clearfix"> <p> Monthly Payment </p><p class="priced">  £   <span id="perMonths">83.66</span>  </p> </li>
                        <li class="clearfix"> <p> Cash Price </p> <p class="priced">   £  <span id="cashPrices">1026.00</span> </p> </li>
                        <li class="clearfix"> <p> Deposit to Pay</p><p class="priced">  £   <span id="Deposited">102.60</span>   </p> </li>
                        <li class="clearfix"> <p> Loan Amount </p><p class="priced">  £    <span id="loanAmt">923.40</span></p> </li>
                        <li class="clearfix"> <p> Loan Repayment </p><p class="priced">£  <span id="loanRepay">1003.90</span>  </p> </li>
                        <li class="clearfix"> <p> Cost of Loan</p> <p class="priced">   £  <span id="costLoan">80.50</span>  </p> </li>
                        <li class="clearfix"> <p> Total Amount Payable </p> <p class="priced"> £   <span id="totalAmt">1106.50</span>    </p> </li>
                        <li class="clearfix"> <p> Number of Monthly Payments </p> <p class="priced"> <span id="noTerm">12</span>  </p></li>
                    </ul>
                    
      
                    <input type="hidden" id="enableId" value="OCFDefault"> <br>
                    <div>
                    </div>
      
      
                    </div>
                    <div class="finance_options_not_available" style="display: none;">
                        <p>Finance options are not available for this product due to less amount.</p>
                    </div>
      
                    
                </div>

            </div>
            <p class="finance_options_provided">Finance options powered by <img src="{{ env('APP_IMAGE_URL').'/images/Deko_landscape_colour_whiteBG200px_wide.png' }}" style="height:25px;" class="nolazy" alt="DEKO"></p>
        </div>
        <div class="modal-footer">
            <h5>Disclosures:</h5>
            <p>
                Deko is a credit broker, not a lender and does not charge you for credit broking services, Only available to UK residents over 18, subject to terms and conditions.
            </p>
            <p>
                Credit subject to status. Missed or late payments may result in additional fees or interest and will affect your credit file and yur ability to obtain credit in the future.
            </p>
        </div>
      </div>
    </div>
  </div>
