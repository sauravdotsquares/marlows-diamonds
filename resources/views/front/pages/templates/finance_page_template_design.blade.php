@extends('layouts.front.app')
@section('css')
<style>
    .finance-sec img.deko-cart-img-represent {
    margin: 30px 0;
    width: 1000px;
    margin: auto;
    display: table;
}
</style>
@endsection
@section('content')

<div class="category-banner" style="background-image:url(https://devstaging.marlows-diamonds.co.uk/assets/images/engagement-rings-banner.png)">
    <div class="container">
        <div class="category-banner-text">
            <h1>{{$data->title}}</h1>
            <p>{!!$data->subtitle!!}</p>
        </div>
    </div>
</div>
<div class="defaultpages-wrap finance-panel">
    <div class="container">
        <div class="defaultpages-cols">

            <div class="finance-sec">
                <div class="finance-sec-weneed">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="finance-whatwe-content">
                                <h3>What you need to know</h3>
                                <p>Used responsibly, finance is a great way to spread the cost of your purchase. We've teamed up with Deko, whose secure technology lets you complete a loan application with one or more carefully selected lenders quickly and easily. Deko is a credit broker, not a lender and is authorised and regulated by the Financial Conduct Authority. Find out more about how <b>Je Marlow & Sons Ltd</b> and Deko are regulated. under the “Legal Information” section of this page. You can find out more about Deko below</p>

                                <a class="links-help" href="https://www.dekopay.com/for-customers">https://www.dekopay.com/for-customers</a>

                                <p>Deko connects you with lenders whose finance options are best suited for you and your purchase. As a customer of Je Marlow & Sons Ltd your finance application will be considered by <b>Omni Capital.</b></p>

                                <p>To spread the cost of your purchase, simply choose Deko at the checkout and select the finance option that suits you. The application form is quick and simple and includes help text throughout to assist you. You will receive a decision from your lender in just a few seconds.</p>
                            </div>
                        </div>

                        <!-- <div class="col-md-6">
                            <div class="bank-whatwe"><img class="deko-cart-img" src="/assets/images/finance-whatwe.png" alt="deko cart image"></div>
                        </div> -->
                    </div>
                </div>

                <img class="deko-cart-img" src="/assets/images/deko-finance-img_new.png" alt="">
                
                
                <p>Please be aware that finance options are a form of credit. If you fail to maintain your payments, your lender could ask a debt collector to contact you or commence legal action to recover the money you owe. A poor repayment record will affect your credit file.</p>
            </div>

            <div class="finance-sec">
                <h3>Lender Arrangements</h3>
                <p>All of Deko's lenders hold the required authorisation and permissions to provide you with credit. They need to meet high responsible lending standards, so you can rest assured that your application will be considered fairly and responsibly.</p>

                <p>Whichever lender Deko introduces you to, Deko may receive a commission from them (either a fixed fee or a fixed percentage of the amount you borrow). The lenders Deko works with pay commission at different rates, but the commission received does not influence the interest rate you pay. You will be offered the best rate available from Deko's partner lenders, based on the lenders decision policies. You have the right to know the amount of commission paid in relation to your application - if you'd like this, you can ask Deko's customer support team on <a href="support@dekopay.com">support@dekopay.com</a> or by phone on 0800 294 5891.</p>
            </div>

            <div class="finance-sec finance-eligibility">
                <h3>Check your Eligibility</h3>
                <h4>To be considered for finance, you will need to meet all of the following criteria:</h4>
                <ul>
                    <li><img class="deko-eligibility-img" src="/assets/images/atin-year.png" alt="">At least 18 years old</li>
                    <li><img class="deko-eligibility-img" src="/assets/images/gross-annual-income.png" alt="">Gross annual income of £5,000+</li>
                    <li><img class="deko-eligibility-img" src="/assets/images/uk- resident.png" alt="">UK resident (of 3 years or more)</li>
                    <li><img class="deko-eligibility-img" src="/assets/images/uk-bank-account.png" alt="">UK bank account capable of accepting Direct Debits</li>
                    <li><img class="deko-eligibility-img" src="/assets/images/country-court-judgments.png" alt="">Individual Voluntary Arrangement (“IVA”), or have any Country Court Judgments (“CCJs”)</li>
                </ul>
            </div>

            <div class="finance-sec">
                <h3>Available Finance options</h3>
                <p>We offer a range of interest-free and interest-bearing finance options to help you spread the cost of your purchase over 12 to 48 months . The value of the loan needs to be over £250 and no more than £15,000 and you can choose a deposit of up to 50% of the value of the goods.</p>
            </div>

            <div class="finance-sec">
                <h3>Understanding the numbers</h3>
                <p>Deko wants to make sure that you understand the costs, terms and key features of the finance options available to you. You will see this information as you shop and at checkout.</p>

                <p>Use our finance calculator at checkout to see how different loan values, terms and interest rates affect the total amount you need to pay and the monthly repayments. The finance calculator is for illustrative purposes only and is not a quote, or formal offer of finance. The offer you receive if you apply will be dependent on your personal circumstances and the lender's policies.</p>

                <p>It's important that you understand what this information means for you before you decide to apply for finance. The numbers and information you see when taking out finance can be overwhelming and so Deko has provided a simple guide below to help you.</p>

                <p>Here is an example of what you might see at checkout, with some handy explanations to help you understand what it all means. Please note that this is just an example, the format, layout and content of checkout finance calculators may vary.</p>
            </div>
            <div class="finance-sec">
                <img class="deko-cart-img-represent" src="/assets/images/representative_example.png" alt="deko cart image">

                <h3>Legal Information</h3>
                <p>JE Marlow and Sons Limited is a credit broker, not a lender and is authorised and regulated by the Financial Conduct Authority (FRN 916478). We do not charge you for credit broking services. We will introduce you exclusively to Omni Capital Retail finance products provided by Omni Capital Retail Finance through the Deko platform.</p>
            </div>
            <!-- @include("front.includes.dekopayformulacalculationpage") -->
            <div class="finance-sec ">
                
                <!-- <p>
                    Whichever finance option you choose to apply for, you need to be sure that you can afford to pay the deposit, and keep up with your monthly repayments. You should think about any changes to your situation that might occur during the term of the loan, which could impact on your finances - e.g. retirement, moving home, changing jobs, or any health issues which could affect your income or expenditure.
                </p>
                <p>
                    Alongside the finance calculator and on some of our promotional banners, you will also see the <b><i>representative example.</i></b>
                </p>
                <p>
                    The representative example shows the finance information that we expect to apply to more than half of accepted applications for the specific amount and repayment term.
                </p>
                <p>
                    As we mentioned earlier, the representative example is not a quote or formal offer of finance - we display this to help you understand how much a loan will cost, and so you can compare it with other products.
                </p>
                <p>
                    Whilst these numbers are there to help you understand what a loan will cost you, it's important that you understand any other potential costs in the terms and conditions of the finance option you select. For instance, you may be charged missed or late payment fees if you don't keep up with your payments.
                </p> -->
            </div>
        </div>
    </div>


    @php
    $getEngagementFaqs = getFaqByCategory(29);
    @endphp

    @if(isset($getEngagementFaqs) && sizeof($getEngagementFaqs))
    <!-- FAQ Section start here -->
    <div class="faq-section engagement-ring-faq">
        <div class="container">
            <div class="head-para-three">
                <h2 class="heading-h-three">
                    {{ isset($data->faq_title)?$data->faq_title:"Finance Decision" }}
                </h2>
                <p>Some of the most common Q&A's</p>
            </div>
            <div class="faq-list">
                <div class="accordion" id="accordionExample">
                    @foreach($getEngagementFaqs as $key => $faq)
                    <div class="accordion-item">
                        <h3 class="accordion-header" id="{{$faq->id}}">
                            @if($key == 0)
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$faq->id}}" aria-expanded="true" aria-controls="collapse{{$faq->id}}">
                                @else
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$faq->id}}" aria-expanded="true" aria-controls="collapse{{$faq->id}}">
                                    @endif
                                    {{isset($faq->title)?$faq->title:""}}
                                </button>
                        </h3>
                        @if($key == 0)
                        <div id="collapse{{$faq->id}}" class="accordion-collapse collapse show" aria-labelledby="{{$faq->id}}" data-bs-parent="#accordionExample">
                            @else
                            <div id="collapse{{$faq->id}}" class="accordion-collapse collapse" aria-labelledby="{{$faq->id}}" data-bs-parent="#accordionExample">
                                @endif
                                <div class="accordion-body">
                                    {!! isset($faq->description)?$faq->description:"" !!}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- FAQ Section End -->
    @endif

    @php
    $getEngagementFaqs = getFaqByCategory(30);
    @endphp

    @if(isset($getEngagementFaqs) && sizeof($getEngagementFaqs))
    <!-- FAQ Section start here -->
    <div class="faq-section engagement-ring-faq">
        <div class="container">
            <div class="head-para-three">
                <h2 class="heading-h-three">
                    {{ isset($data->faq_title)?$data->faq_title:"Your Loan Agreement" }}
                </h2>
                <p>Before signing your credit agreement, you will be given some important documents that include key information about your loan. It is important that you read these documents and understand the information and key terms. If you have any questions about the information in your credit agreement before you sign it, Deko’s customer support team can help - you can contact them on <a target="_self" href="support@dekopay.com">support@dekopay.com </a> or by phone on 0800 294 5891.</p>
            </div>
            <div class="faq-list">
                <div class="accordion" id="accordionExample">
                    @foreach($getEngagementFaqs as $key => $faq)
                    <div class="accordion-item">
                        <h3 class="accordion-header" id="{{$faq->id}}">
                            @if($key == 0)
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$faq->id}}" aria-expanded="true" aria-controls="collapse{{$faq->id}}">
                                @else
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$faq->id}}" aria-expanded="true" aria-controls="collapse{{$faq->id}}">
                                    @endif
                                    {{isset($faq->title)?$faq->title:""}}
                                </button>
                        </h3>
                        @if($key == 0)
                        <div id="collapse{{$faq->id}}" class="accordion-collapse collapse show" aria-labelledby="{{$faq->id}}" data-bs-parent="#accordionExample">
                            @else
                            <div id="collapse{{$faq->id}}" class="accordion-collapse collapse" aria-labelledby="{{$faq->id}}" data-bs-parent="#accordionExample">
                                @endif
                                <div class="accordion-body">
                                    {!! isset($faq->description)?$faq->description:"" !!}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- FAQ Section End -->
    @endif


    @php
    $getEngagementFaqs = getFaqByCategory(31);
    @endphp

    @if(isset($getEngagementFaqs) && sizeof($getEngagementFaqs))
    <!-- FAQ Section start here -->
    <div class="faq-section engagement-ring-faq">
        <div class="container">
            <div class="head-para-three">
                <h2 class="heading-h-three">
                    {{ isset($data->faq_title)?$data->faq_title:"Payments and Order" }}
                </h2>
            </div>
            <div class="faq-list">
                <div class="accordion" id="accordionExample">
                    @foreach($getEngagementFaqs as $key => $faq)
                    <div class="accordion-item">
                        <h3 class="accordion-header" id="{{$faq->id}}">
                            @if($key == 0)
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$faq->id}}" aria-expanded="true" aria-controls="collapse{{$faq->id}}">
                                @else
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$faq->id}}" aria-expanded="true" aria-controls="collapse{{$faq->id}}">
                                    @endif
                                    {{isset($faq->title)?$faq->title:""}}
                                </button>
                        </h3>
                        @if($key == 0)
                        <div id="collapse{{$faq->id}}" class="accordion-collapse collapse show" aria-labelledby="{{$faq->id}}" data-bs-parent="#accordionExample">
                            @else
                            <div id="collapse{{$faq->id}}" class="accordion-collapse collapse" aria-labelledby="{{$faq->id}}" data-bs-parent="#accordionExample">
                                @endif
                                <div class="accordion-body">
                                    {!! isset($faq->description)?$faq->description:"" !!}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- FAQ Section End -->

    @endif

    @php
    $getEngagementFaqs = getFaqByCategory(32);
    @endphp

    @if(isset($getEngagementFaqs) && sizeof($getEngagementFaqs))
    <!-- FAQ Section start here -->
    <div class="faq-section engagement-ring-faq">
        <div class="container">
            <div class="head-para-three">
                <h2 class="heading-h-three">
                    {{ isset($data->faq_title)?$data->faq_title:"Cancellations and Returns" }}
                </h2>
                <p>I want to return my goods and cancel my finance agreement.
                    Please see our <a href="/delivery-and-returns-policy">Delivery & Return Policy </a>. Some products cannot be cancelled, for example, made-to-order or bespoke goods, so you should check this before you complete your purchase.

                    Where you do have the right to cancel, you must do this within 14 days of entering into the finance agreement.
                    To cancel your finance agreement, please contact us (your retailer) and arrange to return your purchase or cancel the services. Once we have confirmed cancellation, we will advise your lender to cancel your finance agreement and refund any payments that have been made. If you made your purchase in-store, we will refund any deposit payment that you made. Your finance agreement can only be cancelled by your lender if your purchase is cancelled with us.</p>
            </div>
            <div class="faq-list">
                <div class="accordion" id="accordionExample">
                    @foreach($getEngagementFaqs as $key => $faq)
                    <div class="accordion-item">
                        <h3 class="accordion-header" id="{{$faq->id}}">
                            @if($key == 0)
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$faq->id}}" aria-expanded="true" aria-controls="collapse{{$faq->id}}">
                                @else
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$faq->id}}" aria-expanded="true" aria-controls="collapse{{$faq->id}}">
                                    @endif
                                    {{isset($faq->title)?$faq->title:""}}
                                </button>
                        </h3>
                        @if($key == 0)
                        <div id="collapse{{$faq->id}}" class="accordion-collapse collapse show" aria-labelledby="{{$faq->id}}" data-bs-parent="#accordionExample">
                            @else
                            <div id="collapse{{$faq->id}}" class="accordion-collapse collapse" aria-labelledby="{{$faq->id}}" data-bs-parent="#accordionExample">
                                @endif
                                <div class="accordion-body">
                                    {!! isset($faq->description)?$faq->description:"" !!}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- FAQ Section End -->

    <div class="container">
        <div class="defaultpages-cols">
            <div class="finance-sec">
                <h3>Your Personal or Financial Circumstances</h3>
                <p>It's a fact of life that things can change for any of us. If something changes in your personal, or financial circumstances, Deko and your lender will do all they can to help make it as easy as possible to submit your application and manage your loan repayments.</p>

                <p>If you're struggling at any point with your application online, or you don't understand anything, please contact Deko's customer support team at <a target="_self" href="support@dekopay.com">support@dekopay.com </a> or 0800 294 5891.</p>
                <p>If you find yourself struggling due to a change in your circumstances, please contact your lender and ask for their help.</p>
            </div>
            <div class="finance-sec">
                <h3>Use of Your Personal Data</h3>
                <p>In order to process your application, you will be asked to provide information about your personal, employment and financial situation. Deko share your personal data with their partner lenders so that they can make a decision about whether to offer you finance. Lenders perform a search with one or more Credit Reference Agencies to conduct their creditworthiness and affordability assessment to enable them to make their decision.</p>

                <p>You can find out more about how Deko uses and protects your personal data in their <a href="/privacy-policy">Privacy Policy</a> 
                <p>Your lender will let you know where you can find more information about their privacy policy.</p>
            </div>
            <div class="finance-sec">
                <h3>Still have questions?</h3>
                <p>If you still have questions about your finance application or need some help completing it, check out Deko's FAQs <a target="_self" href="https://www.dekopay.com/customer-support"> <strong>here</strong></a>.</p>

                <p>For any questions related to finance, please contact your lender. Their contact details will be provided throughout your application and on any communications you receive about your finance application.</p> 
            </div>
            <!--  -->
            <!-- <div class="finance-sec">
                <h3>Legal Information (FCA Disclaimer)</h3>
                <p>It is mandatory to display the Legal information on your Finance page and on the footer of your website.</p>
            </div> -->
            <!-- <div class="finance-sec">
                <h3>FCA Authorised</h3>
                <p><strong> V1 FCA Authorised - Single Lender through Deko</strong></p>
                <p>Sailendra,Je Marlow & Sons Ltd is a credit broker, not a lender and is authorised and regulated by the Financial Conduct Authority (FRN [Merchant FCA ID] ). We do not charge you for credit broking services. We will introduce you exclusively to Omni Capital's finance products provided by Omni Capital's through the Deko platform.</p>
                <p><strong>V2 FCA Authorised - Multiple lenders (Deko panel + non-Deko)</strong></p>
                <p>Sailendra,Je Marlow & Sons Ltd is a credit broker, not a lender and is authorised and regulated by the Financial Conduct Authority (FRN [Merchant FCA ID] ). We do not charge you for credit broking services. We will introduce you to Finance available from a number of our partner lenders.</p>
                <p><strong>V3 FCA Authorised - If you are offering finance through Deko with multiple Deko lenders</strong></p>
                <p>Sailendra,Je Marlow & Sons Ltd is a credit broker, not a lender and is authorised and regulated by the Financial Conduct Authority (FRN [Merchant FCA ID] ). We do not charge you for credit broking services. Finance is introduced through the Deko platform from a carefully selected panel of lenders. Deko is a trading name of Pay4Later Ltd, which is authorised and regulated by the Financial Conduct Authority (FRN 728646). Deko is a credit broker, not a lender and does not charge you for credit broking services. Whichever lender Deko introduces you to, Deko will typically receive a commission from them (either a fixed fee or a percentage of the amount you borrow). For your reassurance, all of the lenders Deko works with could pay commission at different rates, but the commission received does not influence the interest rate you will pay. You will be offered the best rate available from Deko's partner lenders, based on the lenders' decision policies.</p>
            </div> -->
            <!-- <div class="finance-sec">
                <h3>NON-FCA Authorised</h3>
                <p><strong> V1 Non-FCA Authorised - If you introduce only exempt products from a single Deko lender</strong></p>
                <p>Sailendra,Je Marlow & Sons Ltd is a credit broker, not a lender. We do not charge you for credit broking services. We will introduce you exclusively to Omni Capital's finance products provided by Omni Capital's through the Deko platform.</p>
                <p><strong>V2 Non-FCA Authorised - If you introduce only exempt products from multiple lenders (Deko panel + non-Deko)</strong></p>
                <p>Sailendra,Je Marlow & Sons Ltd is a credit broker, not a lender . We do not charge you for credit broking services. We will introduce you limited finance products available from a number of our partner lenders.</p>
            </div> -->
            <!-- <div class="finance-sec">
                <h3>IAR Merchant</h3>
                <p><strong> V1 IAR - Single Lender through Deko</strong></p>
                <p>Sailendra,Je Marlow & Sons Ltd is an Introducer Appointed Representative of Pay4Later Limited, trading as Deko, which is authorised and regulated by the Financial Conduct Authority (FRN 728646). Deko is a credit broker, not a lender and does not charge you for credit broking services. Deko will introduce you exclusively to Omni Capital finance products provided by Omni Capital through the Deko platform.</p>
                <p><strong>V2 IAR - Multiple lenders (Deko panel + non-Deko)</strong></p>
                <p>Sailendra,Je Marlow & Sons Ltd is an Introducer Appointed Representative of Pay4Later Limited, trading as Deko, which is authorised and regulated by the Financial Conduct Authority (FRN 728646). Deko is a credit broker, not a lender and does not charge you for credit broking services. Deko will introduce you exclusively to Omni Capital finance products provided by [Omni Capital and trading name where applicable] under this Introducer Appointed Representative arrangement. Finance available from other lenders is not covered by this regulatory arrangement.</p>
                <p><strong>V3 IAR - If you are offering finance through Deko with multiple Deko lenders</strong></p>
                <p>Sailendra,Je Marlow & Sons Ltd is an Introducer Appointed Representative of Pay4Later Limited, trading as Deko, which is authorised and regulated by the Financial Conduct Authority (FRN 728646). Deko is a credit broker, not a lender and does not charge you for credit broking services. Finance is introduced through the Deko platform from a carefully selected panel of lenders. Whichever lender Deko introduces you to, Deko will typically receive a commission from them (either a fixed fee or a fixed percentage of the amount you borrow). For your reassurance, all of the lenders Deko works with could pay commission at different rates, but the commission received does not influence the interest rate you will pay. You will be offered the best rate available from Deko's partner lenders, based on the lenders' decision policies.</p>
            </div> -->
        </div>
    </div>
</div>

@endif

@endsection

@section('js')
<?php
$url = getDekoPayFormulaURL();
?>
<script src="{{$url}}"></script>
<script>
    $(document).ready(function() {
        $('#totalOrderText1').on('blur', function() {
            $("#totalOrder").val($(this).val());
            $("#totalOrderText").text($(this).val());
        });
    });
</script>
@endsection