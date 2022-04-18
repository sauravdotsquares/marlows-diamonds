@extends('layouts.front.app')

@section('css')
<style>
        .thumbnail {
            position: relative;
            padding: 0px;
            margin-bottom: 20px;
        }
        .thumbnail img {
            width: 80%;
        }
        .thumbnail .caption{
            margin: 7px;
        }
        .main-section{
            background-color: #F8F8F8;
        }
        .dropdown{
            float:right;
            padding-right: 30px;
        }
        .btn{
            border:0px;
            margin:10px 0px;
            box-shadow:none !important;
        }
        .dropdown .dropdown-menu{
            padding:20px;
            top:30px !important;
            width:350px !important;
            left:-110px !important;
            box-shadow:0px 5px 30px black;
        }
        .total-header-section{
            border-bottom:1px solid #d2d2d2;
        }
        .total-section p{
            margin-bottom:20px;
        }
        .cart-detail{
            padding:15px 0px;
        }
        .cart-detail-img img{
            width:100%;
            height:100%;
            padding-left:15px;
        }
        .cart-detail-product p{
            margin:0px;
            color:#000;
            font-weight:500;
        }
        .cart-detail .price{
            font-size:12px;
            margin-right:10px;
            font-weight:500;
        }
        .cart-detail .count{
            color:#C2C2DC;
        }
        .checkout{
            border-top:1px solid #d2d2d2;
            padding-top: 15px;
        }
        .checkout .btn-primary{
            border-radius:50px;
            height:50px;
        }
        .dropdown-menu:before{
            content: " ";
            position:absolute;
            top:-20px;
            right:50px;
            border:10px solid transparent;
            border-bottom-color:#fff;
        }
    </style>
@endsection

@section('content')
<div id="Content">
    <div class="content_wrapper clearfix">
        <div class="sections_group">
            <div class="entry-content" itemprop="mainContentOfPage">
                <div class="section the_content has_content">
                    <div class="section_wrapper">
                        <div class="the_content_wrapper">
                            <div class="woocommerce">
                                <div class="woocommerce-notices-wrapper"></div>
                                <div class="woocommerce-notices-wrapper"></div>
                                <form name="checkout" method="post" class="checkout woocommerce-checkout"
                                    action="https://www.marlows-diamonds.co.uk/checkout/" enctype="multipart/form-data"
                                    novalidate="novalidate">
                                    <div class="col2-set" id="customer_details">
                                        <div class="col-1">
                                            <div class="woocommerce-billing-fields">
                                                <h3>Billing details</h3>
                                                <div class="woocommerce-billing-fields__field-wrapper">
                                                    <p class="form-row form-row-first validate-required"
                                                        id="billing_first_name_field" data-priority="10"><label
                                                            for="billing_first_name" class="">First name&nbsp;<abbr
                                                                class="required" title="required">*</abbr></label><span
                                                            class="woocommerce-input-wrapper"><input type="text"
                                                                class="input-text " name="billing_first_name"
                                                                id="billing_first_name" placeholder="" value="sketch"
                                                                autocomplete="given-name"></span></p>
                                                    <p class="form-row form-row-last validate-required"
                                                        id="billing_last_name_field" data-priority="20"><label
                                                            for="billing_last_name" class="">Last name&nbsp;<abbr
                                                                class="required" title="required">*</abbr></label><span
                                                            class="woocommerce-input-wrapper"><input type="text"
                                                                class="input-text " name="billing_last_name"
                                                                id="billing_last_name" placeholder="" value="creative"
                                                                autocomplete="family-name"></span></p>
                                                    <p class="form-row form-row-wide" id="billing_company_field"
                                                        data-priority="30"><label for="billing_company" class="">Company
                                                            name&nbsp;<span
                                                                class="optional">(optional)</span></label><span
                                                            class="woocommerce-input-wrapper"><input type="text"
                                                                class="input-text " name="billing_company"
                                                                id="billing_company" placeholder="" value=""
                                                                autocomplete="organization"></span></p>
                                                    <p class="form-row form-row-wide address-field update_totals_on_change validate-required"
                                                        id="billing_country_field" data-priority="40"><label
                                                            for="billing_country" class="">Country/Region&nbsp;<abbr
                                                                class="required" title="required">*</abbr></label><span
                                                            class="woocommerce-input-wrapper">
                                                            <select
                                                                name="billing_country" id="billing_country"
                                                                class="country_to_state country_select select2-hidden-accessible"
                                                                autocomplete="country"
                                                                data-placeholder="Select a country / region…"
                                                                data-label="Country/Region" tabindex="-1"
                                                                aria-hidden="true">
                                                                <option value="">Select a country / region…</option>
                                                                <option value="AF">Afghanistan</option>
                                                                <option value="AX">Åland Islands</option>
                                                                <option value="AL">Albania</option>
                                                                <option value="DZ">Algeria</option>
                                                                <option value="AS">American Samoa</option>
                                                                <option value="AD">Andorra</option>
                                                                <option value="AO">Angola</option>
                                                                <option value="AI">Anguilla</option>
                                                                <option value="AQ">Antarctica</option>
                                                                <option value="AG">Antigua and Barbuda</option>
                                                                <option value="AR">Argentina</option>
                                                                <option value="AM">Armenia</option>
                                                                <option value="AW">Aruba</option>
                                                                <option value="AU">Australia</option>
                                                                <option value="AT">Austria</option>
                                                                <option value="AZ">Azerbaijan</option>
                                                                <option value="BS">Bahamas</option>
                                                                <option value="BH">Bahrain</option>
                                                                <option value="BD">Bangladesh</option>
                                                                <option value="BB">Barbados</option>
                                                                <option value="BY">Belarus</option>
                                                                <option value="PW">Belau</option>
                                                                <option value="BE">Belgium</option>
                                                                <option value="BZ">Belize</option>
                                                                <option value="BJ">Benin</option>
                                                                <option value="BM">Bermuda</option>
                                                                <option value="BT">Bhutan</option>
                                                                <option value="BO">Bolivia</option>
                                                                <option value="BQ">Bonaire, Saint Eustatius and Saba
                                                                </option>
                                                                <option value="BA">Bosnia and Herzegovina</option>
                                                                <option value="BW">Botswana</option>
                                                                <option value="BV">Bouvet Island</option>
                                                                <option value="BR">Brazil</option>
                                                                <option value="IO">British Indian Ocean Territory
                                                                </option>
                                                                <option value="BN">Brunei</option>
                                                                <option value="BG">Bulgaria</option>
                                                                <option value="BF">Burkina Faso</option>
                                                                <option value="BI">Burundi</option>
                                                                <option value="KH">Cambodia</option>
                                                                <option value="CM">Cameroon</option>
                                                                <option value="CA">Canada</option>
                                                                <option value="CV">Cape Verde</option>
                                                                <option value="KY">Cayman Islands</option>
                                                                <option value="CF">Central African Republic</option>
                                                                <option value="TD">Chad</option>
                                                                <option value="CL">Chile</option>
                                                                <option value="CN">China</option>
                                                                <option value="CX">Christmas Island</option>
                                                                <option value="CC">Cocos (Keeling) Islands</option>
                                                                <option value="CO">Colombia</option>
                                                                <option value="KM">Comoros</option>
                                                                <option value="CG">Congo (Brazzaville)</option>
                                                                <option value="CD">Congo (Kinshasa)</option>
                                                                <option value="CK">Cook Islands</option>
                                                                <option value="CR">Costa Rica</option>
                                                                <option value="HR">Croatia</option>
                                                                <option value="CU">Cuba</option>
                                                                <option value="CW">Curaçao</option>
                                                                <option value="CY">Cyprus</option>
                                                                <option value="CZ">Czech Republic</option>
                                                                <option value="DK">Denmark</option>
                                                                <option value="DJ">Djibouti</option>
                                                                <option value="DM">Dominica</option>
                                                                <option value="DO">Dominican Republic</option>
                                                                <option value="EC">Ecuador</option>
                                                                <option value="EG">Egypt</option>
                                                                <option value="SV">El Salvador</option>
                                                                <option value="GQ">Equatorial Guinea</option>
                                                                <option value="ER">Eritrea</option>
                                                                <option value="EE">Estonia</option>
                                                                <option value="ET">Ethiopia</option>
                                                                <option value="FK">Falkland Islands</option>
                                                                <option value="FO">Faroe Islands</option>
                                                                <option value="FJ">Fiji</option>
                                                                <option value="FI">Finland</option>
                                                                <option value="FR">France</option>
                                                                <option value="GF">French Guiana</option>
                                                                <option value="PF">French Polynesia</option>
                                                                <option value="TF">French Southern Territories</option>
                                                                <option value="GA">Gabon</option>
                                                                <option value="GM">Gambia</option>
                                                                <option value="GE">Georgia</option>
                                                                <option value="DE">Germany</option>
                                                                <option value="GH">Ghana</option>
                                                                <option value="GI">Gibraltar</option>
                                                                <option value="GR">Greece</option>
                                                                <option value="GL">Greenland</option>
                                                                <option value="GD">Grenada</option>
                                                                <option value="GP">Guadeloupe</option>
                                                                <option value="GU">Guam</option>
                                                                <option value="GT">Guatemala</option>
                                                                <option value="GG">Guernsey</option>
                                                                <option value="GN">Guinea</option>
                                                                <option value="GW">Guinea-Bissau</option>
                                                                <option value="GY">Guyana</option>
                                                                <option value="HT">Haiti</option>
                                                                <option value="HM">Heard Island and McDonald Islands
                                                                </option>
                                                                <option value="HN">Honduras</option>
                                                                <option value="HK">Hong Kong</option>
                                                                <option value="HU">Hungary</option>
                                                                <option value="IS">Iceland</option>
                                                                <option value="IN">India</option>
                                                                <option value="ID">Indonesia</option>
                                                                <option value="IR">Iran</option>
                                                                <option value="IQ">Iraq</option>
                                                                <option value="IE">Ireland</option>
                                                                <option value="IM">Isle of Man</option>
                                                                <option value="IL">Israel</option>
                                                                <option value="IT">Italy</option>
                                                                <option value="CI">Ivory Coast</option>
                                                                <option value="JM">Jamaica</option>
                                                                <option value="JP">Japan</option>
                                                                <option value="JE">Jersey</option>
                                                                <option value="JO">Jordan</option>
                                                                <option value="KZ">Kazakhstan</option>
                                                                <option value="KE">Kenya</option>
                                                                <option value="KI">Kiribati</option>
                                                                <option value="KW">Kuwait</option>
                                                                <option value="KG">Kyrgyzstan</option>
                                                                <option value="LA">Laos</option>
                                                                <option value="LV">Latvia</option>
                                                                <option value="LB">Lebanon</option>
                                                                <option value="LS">Lesotho</option>
                                                                <option value="LR">Liberia</option>
                                                                <option value="LY">Libya</option>
                                                                <option value="LI">Liechtenstein</option>
                                                                <option value="LT">Lithuania</option>
                                                                <option value="LU">Luxembourg</option>
                                                                <option value="MO">Macao</option>
                                                                <option value="MG">Madagascar</option>
                                                                <option value="MW">Malawi</option>
                                                                <option value="MY">Malaysia</option>
                                                                <option value="MV">Maldives</option>
                                                                <option value="ML">Mali</option>
                                                                <option value="MT">Malta</option>
                                                                <option value="MH">Marshall Islands</option>
                                                                <option value="MQ">Martinique</option>
                                                                <option value="MR">Mauritania</option>
                                                                <option value="MU">Mauritius</option>
                                                                <option value="YT">Mayotte</option>
                                                                <option value="MX">Mexico</option>
                                                                <option value="FM">Micronesia</option>
                                                                <option value="MD">Moldova</option>
                                                                <option value="MC">Monaco</option>
                                                                <option value="MN">Mongolia</option>
                                                                <option value="ME">Montenegro</option>
                                                                <option value="MS">Montserrat</option>
                                                                <option value="MA">Morocco</option>
                                                                <option value="MZ">Mozambique</option>
                                                                <option value="MM">Myanmar</option>
                                                                <option value="NA">Namibia</option>
                                                                <option value="NR">Nauru</option>
                                                                <option value="NP">Nepal</option>
                                                                <option value="NL">Netherlands</option>
                                                                <option value="NC">New Caledonia</option>
                                                                <option value="NZ">New Zealand</option>
                                                                <option value="NI">Nicaragua</option>
                                                                <option value="NE">Niger</option>
                                                                <option value="NG">Nigeria</option>
                                                                <option value="NU">Niue</option>
                                                                <option value="NF">Norfolk Island</option>
                                                                <option value="KP">North Korea</option>
                                                                <option value="MK">North Macedonia</option>
                                                                <option value="MP">Northern Mariana Islands</option>
                                                                <option value="NO">Norway</option>
                                                                <option value="OM">Oman</option>
                                                                <option value="PK">Pakistan</option>
                                                                <option value="PS">Palestinian Territory</option>
                                                                <option value="PA">Panama</option>
                                                                <option value="PG">Papua New Guinea</option>
                                                                <option value="PY">Paraguay</option>
                                                                <option value="PE">Peru</option>
                                                                <option value="PH">Philippines</option>
                                                                <option value="PN">Pitcairn</option>
                                                                <option value="PL">Poland</option>
                                                                <option value="PT">Portugal</option>
                                                                <option value="PR">Puerto Rico</option>
                                                                <option value="QA">Qatar</option>
                                                                <option value="RE">Reunion</option>
                                                                <option value="RO">Romania</option>
                                                                <option value="RU">Russia</option>
                                                                <option value="RW">Rwanda</option>
                                                                <option value="ST">São Tomé and Príncipe</option>
                                                                <option value="BL">Saint Barthélemy</option>
                                                                <option value="SH">Saint Helena</option>
                                                                <option value="KN">Saint Kitts and Nevis</option>
                                                                <option value="LC">Saint Lucia</option>
                                                                <option value="SX">Saint Martin (Dutch part)</option>
                                                                <option value="MF">Saint Martin (French part)</option>
                                                                <option value="PM">Saint Pierre and Miquelon</option>
                                                                <option value="VC">Saint Vincent and the Grenadines
                                                                </option>
                                                                <option value="WS">Samoa</option>
                                                                <option value="SM">San Marino</option>
                                                                <option value="SA">Saudi Arabia</option>
                                                                <option value="SN">Senegal</option>
                                                                <option value="RS">Serbia</option>
                                                                <option value="SC">Seychelles</option>
                                                                <option value="SL">Sierra Leone</option>
                                                                <option value="SG">Singapore</option>
                                                                <option value="SK">Slovakia</option>
                                                                <option value="SI">Slovenia</option>
                                                                <option value="SB">Solomon Islands</option>
                                                                <option value="SO">Somalia</option>
                                                                <option value="ZA">South Africa</option>
                                                                <option value="GS">South Georgia/Sandwich Islands
                                                                </option>
                                                                <option value="KR">South Korea</option>
                                                                <option value="SS">South Sudan</option>
                                                                <option value="ES">Spain</option>
                                                                <option value="LK">Sri Lanka</option>
                                                                <option value="SD">Sudan</option>
                                                                <option value="SR">Suriname</option>
                                                                <option value="SJ">Svalbard and Jan Mayen</option>
                                                                <option value="SZ">Swaziland</option>
                                                                <option value="SE">Sweden</option>
                                                                <option value="CH">Switzerland</option>
                                                                <option value="SY">Syria</option>
                                                                <option value="TW">Taiwan</option>
                                                                <option value="TJ">Tajikistan</option>
                                                                <option value="TZ">Tanzania</option>
                                                                <option value="TH">Thailand</option>
                                                                <option value="TL">Timor-Leste</option>
                                                                <option value="TG">Togo</option>
                                                                <option value="TK">Tokelau</option>
                                                                <option value="TO">Tonga</option>
                                                                <option value="TT">Trinidad and Tobago</option>
                                                                <option value="TN">Tunisia</option>
                                                                <option value="TR">Turkey</option>
                                                                <option value="TM">Turkmenistan</option>
                                                                <option value="TC">Turks and Caicos Islands</option>
                                                                <option value="TV">Tuvalu</option>
                                                                <option value="UG">Uganda</option>
                                                                <option value="UA">Ukraine</option>
                                                                <option value="AE">United Arab Emirates</option>
                                                                <option value="GB" selected="selected">United Kingdom
                                                                    (UK)</option>
                                                                <option value="US">United States (US)</option>
                                                                <option value="UM">United States (US) Minor Outlying
                                                                    Islands</option>
                                                                <option value="UY">Uruguay</option>
                                                                <option value="UZ">Uzbekistan</option>
                                                                <option value="VU">Vanuatu</option>
                                                                <option value="VA">Vatican</option>
                                                                <option value="VE">Venezuela</option>
                                                                <option value="VN">Vietnam</option>
                                                                <option value="VG">Virgin Islands (British)</option>
                                                                <option value="VI">Virgin Islands (US)</option>
                                                                <option value="WF">Wallis and Futuna</option>
                                                                <option value="EH">Western Sahara</option>
                                                                <option value="YE">Yemen</option>
                                                                <option value="ZM">Zambia</option>
                                                                <option value="ZW">Zimbabwe</option>
                                                            </select><span
                                                                class="select2 select2-container select2-container--default"
                                                                dir="ltr" style="width: 100%;"><span
                                                                    class="selection"><span
                                                                        class="select2-selection select2-selection--single"
                                                                        aria-haspopup="true" aria-expanded="false"
                                                                        tabindex="0" aria-label="Country/Region"
                                                                        role="combobox"><span
                                                                            class="select2-selection__rendered"
                                                                            id="select2-billing_country-container"
                                                                            role="textbox" aria-readonly="true"
                                                                            title="United Kingdom (UK)">United Kingdom
                                                                            (UK)</span><span
                                                                            class="select2-selection__arrow"
                                                                            role="presentation"><b
                                                                                role="presentation"></b></span></span></span><span
                                                                    class="dropdown-wrapper"
                                                                    aria-hidden="true"></span></span><noscript><button
                                                                    type="submit"
                                                                    name="woocommerce_checkout_update_totals"
                                                                    value="Update country/region">Update
                                                                    country/region</button></noscript></span></p>
                                                    <p class="form-row address-field validate-required form-row-wide"
                                                        id="billing_address_1_field" data-priority="50"><label
                                                            for="billing_address_1" class="">Street address&nbsp;<abbr
                                                                class="required" title="required">*</abbr></label><span
                                                            class="woocommerce-input-wrapper"><input type="text"
                                                                class="input-text " name="billing_address_1"
                                                                id="billing_address_1"
                                                                placeholder="House number and street name"
                                                                value="Pacific House" autocomplete="address-line1"
                                                                data-placeholder="House number and street name"></span>
                                                    </p>
                                                    <p class="form-row address-field form-row-wide"
                                                        id="billing_address_2_field" data-priority="60"><label
                                                            for="billing_address_2" class="screen-reader-text">Flat,
                                                            suite, unit, etc.&nbsp;<span
                                                                class="optional">(optional)</span></label><span
                                                            class="woocommerce-input-wrapper"><input type="text"
                                                                class="input-text " name="billing_address_2"
                                                                id="billing_address_2"
                                                                placeholder="Apartment, suite, unit, etc. (optional)"
                                                                value="" autocomplete="address-line2"
                                                                data-placeholder="Apartment, suite, unit, etc. (optional)"></span>
                                                    </p>
                                                    <p class="form-row address-field validate-required form-row-wide"
                                                        id="billing_city_field" data-priority="70"
                                                        data-o_class="form-row form-row-wide address-field validate-required">
                                                        <label for="billing_city" class="">Town / City&nbsp;<abbr
                                                                class="required" title="required">*</abbr></label><span
                                                            class="woocommerce-input-wrapper"><input type="text"
                                                                class="input-text " name="billing_city"
                                                                id="billing_city" placeholder="" value="Wilnecote"
                                                                autocomplete="address-level2"></span>
                                                    </p>
                                                    <p class="form-row address-field validate-state form-row-wide"
                                                        id="billing_state_field" data-priority="80"
                                                        data-o_class="form-row form-row-wide address-field validate-state">
                                                        <label for="billing_state" class="">County&nbsp;<span
                                                                class="optional">(optional)</span></label><span
                                                            class="woocommerce-input-wrapper"><input type="text"
                                                                class="input-text " value="" placeholder=""
                                                                name="billing_state" id="billing_state"
                                                                autocomplete="address-level1"
                                                                data-input-classes=""></span>
                                                    </p>
                                                    <p class="form-row address-field validate-required validate-postcode form-row-wide"
                                                        id="billing_postcode_field" data-priority="90"
                                                        data-o_class="form-row form-row-wide address-field validate-required validate-postcode">
                                                        <label for="billing_postcode" class="">Postcode&nbsp;<abbr
                                                                class="required" title="required">*</abbr></label><span
                                                            class="woocommerce-input-wrapper"><input type="text"
                                                                class="input-text " name="billing_postcode"
                                                                id="billing_postcode" placeholder="" value="B77 5PA"
                                                                autocomplete="postal-code"></span>
                                                    </p>
                                                    <p class="form-row form-row-wide validate-required validate-phone"
                                                        id="billing_phone_field" data-priority="100"><label
                                                            for="billing_phone" class="">Phone&nbsp;<abbr
                                                                class="required" title="required">*</abbr></label><span
                                                            class="woocommerce-input-wrapper"><input type="tel"
                                                                class="input-text " name="billing_phone"
                                                                id="billing_phone" placeholder="" value="0121 517 0374"
                                                                autocomplete="tel"></span></p>
                                                    <p class="form-row form-row-wide validate-required validate-email"
                                                        id="billing_email_field" data-priority="110"><label
                                                            for="billing_email" class="">Email address&nbsp;<abbr
                                                                class="required" title="required">*</abbr></label><span
                                                            class="woocommerce-input-wrapper"><input type="email"
                                                                class="input-text " name="billing_email"
                                                                id="billing_email" placeholder=""
                                                                value="development@sketch-creative.com"
                                                                autocomplete="email"></span></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="woocommerce-shipping-fields">
                                            </div>
                                            <div class="woocommerce-additional-fields">
                                                <h3>Additional information</h3>
                                                <div class="woocommerce-additional-fields__field-wrapper">
                                                    <p class="form-row notes" id="order_comments_field"
                                                        data-priority=""><label for="order_comments" class="">Order
                                                            notes&nbsp;<span
                                                                class="optional">(optional)</span></label><span
                                                            class="woocommerce-input-wrapper"><textarea
                                                                name="order_comments" class="input-text "
                                                                id="order_comments"
                                                                placeholder="Notes about your order, e.g. special notes for delivery."
                                                                rows="2" cols="5"></textarea></span></p>
                                                </div>
                                                <input type="hidden" name="payPro" id="payPro"
                                                    value="ONIB12-16.9"><input type="hidden" name="payPer" id="payPer"
                                                    value="10">
                                            </div>
                                        </div>
                                    </div>
                                    <h3 id="order_review_heading">Your order</h3>
                                    <table id="cart" class="table table-hover table-condensed">
                                        <thead>
                                            <tr>
                                                <th style="width:50%">Product</th>
                                                <th style="width:10%">Price</th>
                                                <th style="width:8%">Quantity</th>
                                                <th style="width:22%" class="text-center">Subtotal</th>
                                                <th style="width:10%"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $total = 0 @endphp
                                            @if(session('cart'))
                                            @foreach(session('cart') as $id => $details)
                                            @php $total += $details['price'] * $details['quantity'] @endphp
                                            <tr data-id="{{ $id }}">
                                                <td data-th="Product">
                                                    <div class="row">
                                                        <div class="col-sm-3 hidden-xs"><img src="{{ asset('storage/'.$details['image']) }}" width="100"
                                                                height="100" class="img-responsive" /></div>
                                                        <div class="col-sm-9">
                                                            <h4 class="nomargin">{!! $details['name'] !!}</h4>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td data-th="Price">${{ $details['price'] }}</td>
                                                <td data-th="Quantity">
                                                    <input type="number" value="{{ $details['quantity'] }}" class="form-control quantity update-cart" />
                                                </td>
                                                <td data-th="Subtotal" class="text-center">{{MY_CURRENCY_SYMBOL}}{{ $details['price'] * $details['quantity'] }}</td>
                                                <td class="actions" data-th="">
                                                    <button class="btn btn-danger btn-sm remove-from-cart"><i class="fa fa-trash-o"></i></button>
                                                </td>
                                            </tr>
                                            @endforeach
                                            @endif
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="5" class="text-right">
                                                    <h3><strong>Sub Total {{MY_CURRENCY_SYMBOL}}{{ $total }}</strong></h3>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" class="text-right">
                                                    <h3><strong>Total {{MY_CURRENCY_SYMBOL}}{{ $total }}</strong></h3>
                                                </td>
                                            </tr>
                                            <tr>
                                               
                                            </tr>
                                        </tfoot>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="section section-page-footer">
                    <div class="section_wrapper clearfix">
                        <div class="column one page-pager">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
@endsection