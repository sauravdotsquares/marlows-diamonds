@extends('layouts.front.app')

@section('content')
    <?php
        // echo "<pre>";
        // print_r($getUserDetails->getCustomerAddressFunction->first_name);
        // // print_r($getUserDetails->getCustomerAddressFunction->last_name);
        // die;
        if(isset($getUserDetails->getCustomerAddressFunction) && !empty($getUserDetails->getCustomerAddressFunction->first_name)){
            $firstName = $getUserDetails->getCustomerAddressFunction->first_name;
            $lastName = isset($getUserDetails->getCustomerAddressFunction->last_name)?$getUserDetails->getCustomerAddressFunction->last_name:'';
            $fullName = $firstName. " " . $lastName;
        }else{
            $fullName = isset($getUserDetails->username)?$getUserDetails->username:'No Name';
        }

    ?>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <li style="color:red;">{{$error}}</li>
        @endforeach
    @endif

    <div class="my-account-wrap">
        <div class="container">
            <div class="accounts-heading text-center">
                <h1>ACCOUNT INFORMATION</h1>
                <h2>CONTACT US FOR QUALITY DIAMOND ENGAGEMENT RINGS</h2>
            </div>
            <div class="account-dashboard">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="account-sidebar">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a href="javascript:void(0)" class="nav-link active" id="dashboard-tab" data-bs-toggle="tab" data-bs-target="#dashboard" type="button" role="tab" aria-controls="dashboard" aria-selected="true">Dsashboard</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a href="javascript:void(0)" class="nav-link" id="orders-tab" data-bs-toggle="tab" data-bs-target="#orders" type="button" role="tab" aria-controls="orders" aria-selected="false">Orders</a>
                                </li>
                                <!-- <li class="nav-item" role="presentation">
                                    <a href="javascript:void(0)" class="nav-link" id="downloads-tab" data-bs-toggle="tab" data-bs-target="#downloads" type="button" role="tab" aria-controls="downloads" aria-selected="false">Downloads</a>
                                </li> -->
                                <li class="nav-item" role="presentation">
                                    <a href="javascript:void(0)" class="nav-link" id="address-tab" data-bs-toggle="tab" data-bs-target="#address" type="button" role="tab" aria-controls="address" aria-selected="false">Address</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a href="javascript:void(0)" class="nav-link" id="accountd-tab" data-bs-toggle="tab" data-bs-target="#accountd" type="button" role="tab" aria-controls="accountd" aria-selected="false">Account details</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('products.wishlist')}}">Wishlist</a>
                                </li>
                                <!-- <li class="nav-item" role="presentation">
                                    <a href="javascript:void(0)" class="nav-link" id="auctions-tab" data-bs-toggle="tab" data-bs-target="#auctions" type="button" role="tab" aria-controls="auctions" aria-selected="false">Auctions settings</a>
                                </li> -->
                                <li class="nav-item">
                                    <a href="{{route('logout-customer')}}">Logout</a>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="account-main-content">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                                    <div class="account-dashboard-page">
                                        <p>Hello <strong>{{$fullName}}</strong> (not <strong>{{$fullName}}</strong>? <a href="{{route('logout-customer')}}">Log out</a>)</p>
                                        <!-- <p>From your account dashboard you can view your <a href="javascript:void(0);" >recent orders</a>, manage your <a href="javascript:void(0);">edit your password and account details</a>.</p> -->
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                                    <div class="account-order-page">
                                        <div class="scrollable-table">
                                            <table id="orderDataTable" border-collapse="collapse">
                                                <thead>
                                                    <tr>
                                                        <th>Order</th>
                                                        <th>Date</th>
                                                        <th>Status</th>
                                                        <th>Total</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="updateOrderDesign">
                                                    <!-- <tr>
                                                        <td class="orderid-accoount"><a href="#">#29486</a></td>
                                                        <td><span>April 18, 2022</span></td>
                                                        <td>Cancelled</td>
                                                        <td><span>£940.00</span> for 1 item</td>
                                                        <td><a class="btn-bg-small" href="#">View</a></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="orderid-accoount"><a href="#">#29486</a></td>
                                                        <td><span>April 18, 2022</span></td>
                                                        <td>Cancelled</td>
                                                        <td><span>£940.00</span> for 1 item</td>
                                                        <td><a class="btn-bg-small" href="#">View</a></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="orderid-accoount"><a href="#">#29486</a></td>
                                                        <td><span>April 18, 2022</span></td>
                                                        <td>Cancelled</td>
                                                        <td><span>£940.00</span> for 1 item</td>
                                                        <td><a class="btn-bg-small" href="#">View</a></td>
                                                    </tr> -->
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- order view-->
                                        <div class="vieworderd-list ">
                                            <p> Order <strong>#29526</strong> was placed on <strong>May 2, 2022</strong> and is currently <strong>Cancelled.</strong></p>
                                            <div class="view-order-details">
                                                <h4>Order details</h4>
                                                <div class="vieworderd-table">
                                                    <table border-collapse="collapse">
                                                        <thead>
                                                            <tr>
                                                                <th>Product</th>
                                                                <th>Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <a class="order-pr-name" href="#">ABBIE | Marquise shape solitaire Diamond Engagement Ring</a>
                                                                    <strong class="product-quantity">×1</strong>
                                                                    <ul class="wc-item-meta">
                                                                        <li><strong class="wc-item-meta-label">Metal Colour:</strong> <p>18ct White Gold</p></li>
                                                                        <li><strong class="wc-item-meta-label">Finger Size:</strong> <p>I</p></li>
                                                                    </ul>
                                                                </td>
                                                                <td> £388.80</td>
                                                            </tr>
                                                        </tbody>
                                                        <tfoot>
                                                        <tr>
                                                        <th scope="row">Subtotal:</th>
                                                        <td><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">£</span>388.80</span></td>
                                                        </tr>
                                                        <tr>
                                                        <th scope="row">Payment method:</th>
                                                        <td>PayPal</td>
                                                        </tr>
                                                        <tr>
                                                        <th scope="row">Total:</th>
                                                        <td><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">£</span>389.00</span> <small class="includes_tax">(includes <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">£</span>64.80</span> VAT)</small></td>
                                                        </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="view-order-billing-details">
                                                <h4>Billing address</h4>
                                                <div class="woocommerce-customer-details">
                                                    <address>
                                                        sketch creative<br>Pacific House<br>Wilnecote<br>B77 5PA
                                                                <p class="woocommerce-customer-details--phone">0121 517 0374</p>

                                                                <p class="woocommerce-customer-details--email">development@sketch-creative.com</p>
                                                        </address>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                                <div class="tab-pane fade" id="downloads" role="tabpanel" aria-labelledby="downloads-tab">
                                    <div class="account-downloads-page">
                                        <p>No downloads available yet. </p>
                                        <a class="btn-bg-small" href="#">Browse Products</a>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
                                    <div class="account-address-page">
                                        <p> The following addresses will be used on the checkout page by default.</p>
                                        <div class="addresbox row">
                                            <div class="col-md-12">
                                                <div class="addresbox-head">

                                                     <a href="javascript:void(0);" id="showBillingAddress">Edit</a>
                                                     <a href="javascript:void(0);" id="hideBillingAddress" style="display:none;">Show</a>
                                                </div>
                                                <div class="addresbox-block">
                                                    <h3>Billing Address</h3>
                                                    <address>{{isset($getUserDetails->getCustomerAddressFunction->street_address_l1)?$getUserDetails->getCustomerAddressFunction->street_address_l1:''}}<br>{{isset($getUserDetails->getCustomerAddressFunction->street_address_l2)?$getUserDetails->getCustomerAddressFunction->street_address_l2:''}}<br>{{isset($getUserDetails->getCustomerAddressFunction->state)?$getUserDetails->getCustomerAddressFunction->state:''}} {{isset($getUserDetails->getCustomerAddressFunction->state)?$getUserDetails->getCustomerAddressFunction->state:''}}<br>{{isset($getUserDetails->getCustomerAddressFunction->state)?$getUserDetails->getCustomerAddressFunction->state:''}} {{isset($getUserDetails->getCustomerAddressFunction->country_name)?$getUserDetails->getCustomerAddressFunction->country_name:''}} {{isset($getUserDetails->getCustomerAddressFunction->pin_code)?$getUserDetails->getCustomerAddressFunction->pin_code:''}}</address>
                                                </div>
                                            </div>
                                            <!-- <div class="col-md-6">
                                                <div class="addresbox-head">
                                                    <h3>Shipping Address</h3>
                                                     <a href="#">Add</a>
                                                </div>
                                                <div class="addresbox-block">
                                                    <p> You have not set up this type of address yet. </p>
                                                </div>
                                            </div> -->
                                        </div>

                                        <!-- Edit Address box-->
                                        <div class="editaddress-box" style="display:none;">
                                              <h2>Edit Address</h2>
                                              <form action="{{route('users.customer.address')}}" method="POST">
                                                  @csrf
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="checkout-form-group">
                                                            <label class="input-label">First Name <abbr class="required">*</abbr></label>
                                                            <input type="text" name="first_name" class="form-control" value="{{isset($getUserDetails->getCustomerAddressFunction->first_name)?$getUserDetails->getCustomerAddressFunction->first_name:''}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="checkout-form-group">
                                                            <label class="input-label">Last Name <abbr class="required">*</abbr></label>
                                                            <input type="text" name="last_name" class="form-control" value="{{isset($getUserDetails->getCustomerAddressFunction->first_name)?$getUserDetails->getCustomerAddressFunction->first_name:''}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="checkout-form-group">
                                                    <label class="input-label">Company name<span class="optional">(Optional)</span></label>
                                                    <input type="text" name="company_name" class="form-control" value="{{isset($getUserDetails->getCustomerAddressFunction->company_name)?$getUserDetails->getCustomerAddressFunction->company_name:''}}">
                                                </div>
                                                <div class="checkout-form-group">
                                                    <label class="input-label">Country/Region <abbr class="required">*</abbr></label>
                                                    <select name="country_id" class="form-control">
                                                        @foreach($getCountries as $key => $country)
                                                            @if(isset($getUsersDetails->getCustomerAddressFunction->country_id) && $getUsersDetails->getCustomerAddressFunction->country_id == $country->shortname)
                                                                <option value="{{$country->shortname}}" selected>{{$country->name}}</option>
                                                            @else
                                                                <option value="{{$country->shortname}}">{{$country->name}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="checkout-form-group">
                                                    <label class="input-label">Street address  <abbr class="required">*</abbr></label>
                                                    <input type="text" class="form-control" name="street_address_l1" value="{{isset($getUserDetails->getCustomerAddressFunction->street_address_l1)?$getUserDetails->getCustomerAddressFunction->street_address_l1:''}}">
                                                    <input type="text" class="form-control" name="street_address_l2" value="{{isset($getUserDetails->getCustomerAddressFunction->street_address_l2)?$getUserDetails->getCustomerAddressFunction->street_address_l2:''}}" placeholder="Apartment, suite, unit, etc. (optional)">
                                                </div>
                                                <div class="checkout-form-group">
                                                    <label class="input-label">Town / City  <abbr class="required">*</abbr></label>
                                                    <input type="text" class="form-control" name="town_city" value="{{isset($getUserDetails->getCustomerAddressFunction->town_city)?$getUserDetails->getCustomerAddressFunction->town_city:''}}">
                                                </div>
                                                <div class="checkout-form-group">
                                                    <label class="input-label">State <span class="optional">(Optional)</span></label>
                                                    <input type="text" class="form-control" name="state" value="{{isset($getUserDetails->getCustomerAddressFunction->state)?$getUserDetails->getCustomerAddressFunction->state:''}}">
                                                </div>
                                                <div class="checkout-form-group">
                                                    <label class="input-label">Postcode <abbr class="required">*</abbr></label>
                                                    <input type="text" class="form-control" name="pin_code" value="{{isset($getUserDetails->getCustomerAddressFunction->pin_code)?$getUserDetails->getCustomerAddressFunction->pin_code:''}}">
                                                </div>
                                                <div class="checkout-form-group">
                                                    <label class="input-label">Phone  <abbr class="required">*</abbr></label>
                                                    <input type="text" class="form-control" name="mobile" value="{{isset($getUserDetails->getCustomerAddressFunction->mobile)?$getUserDetails->getCustomerAddressFunction->mobile:''}}">
                                                </div>
                                                <div class="checkout-form-group">
                                                    <label class="input-label">Email address   <abbr class="required">*</abbr></label>
                                                    <input type="text" class="form-control" name="email" value="{{isset($getUserDetails->getCustomerAddressFunction->email)?$getUserDetails->getCustomerAddressFunction->email:''}}">
                                                </div>
                                                <div class="checkout-form-group">
                                                    <label class="input-label">Other Notes <abbr class="required">*</abbr></label>
                                                    <textarea name="order_notes" class="form-control" id="order_notes" cols="30" rows="10">{{isset($getUserDetails->getCustomerAddressFunction->order_notes)?$getUserDetails->getCustomerAddressFunction->order_notes:''}}</textarea>
                                                </div>
                                                <div class="save-changes">
                                                    <button class="btn-bg-small" type="submit">Save address</button>
                                                </div>
                                            </form>
                                        </div>

                                        <!-- <div class="editaddress-box">
                                              <h2>Shipping address</h2>
                                              <form>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="checkout-form-group">
                                                            <label class="input-label">First Name <abbr class="required">*</abbr></label>
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="checkout-form-group">
                                                            <label class="input-label">Last Name <abbr class="required">*</abbr></label>
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="checkout-form-group">
                                                    <label class="input-label">Company name<span class="optional">(Optional)</span></label>
                                                    <input type="text" class="form-control">
                                                </div>
                                                <div class="checkout-form-group">
                                                    <label class="input-label">Country/Region <abbr class="required">*</abbr></label>
                                                    <select class="form-control">
                                                        <option>India</option>
                                                        <option>UK</option>
                                                    </select>
                                                </div>
                                                <div class="checkout-form-group">
                                                    <label class="input-label">Street address  <abbr class="required">*</abbr></label>
                                                    <input type="text" class="form-control" placeholder="House number and street name">
                                                    <input type="text" class="form-control" placeholder="Apartment, suite, unit, etc. (optional)">
                                                </div>
                                                <div class="checkout-form-group">
                                                    <label class="input-label">Town / City  <abbr class="required">*</abbr></label>
                                                    <input type="text" class="form-control">
                                                </div>
                                                <div class="checkout-form-group">
                                                    <label class="input-label">County <span class="optional">(Optional)</span></label>
                                                    <input type="text" class="form-control">
                                                </div>
                                                <div class="checkout-form-group">
                                                    <label class="input-label">Postcode <abbr class="required">*</abbr></label>
                                                    <input type="text" class="form-control">
                                                </div>

                                                <div class="save-changes">
                                                    <button class="btn-bg-small">Save address</button>
                                                </div>
                                            </form>
                                        </div> -->


                                    </div>
                                </div>
                                <div class="tab-pane fade" id="accountd" role="tabpanel" aria-labelledby="accountd-tab">
                                    <div class="account-accountd-page">
                                        <form action="{{route('update.customer.account.details')}}" method="POST">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="checkout-form-group">
                                                        <label class="input-label">Name <abbr class="required">*</abbr></label>
                                                        <input type="text" class="form-control" name="name" value="{{isset($getUserDetails->name)?$getUserDetails->name:''}}">
                                                    </div>
                                                </div>
                                                <!-- <div class="col-md-6">
                                                    <div class="checkout-form-group">
                                                        <label class="input-label">Last Name <abbr class="required">*</abbr></label>
                                                        <input type="text" class="form-control" value="Sharma">
                                                    </div>
                                                </div> -->
                                            </div>
                                            <div class="checkout-form-group">
                                                <label class="input-label">Display name<abbr class="required">*</abbr></label>
                                                <input type="text" class="form-control" name="nicename" value="{{isset($getUserDetails->nicename)?$getUserDetails->nicename:''}}">
                                                <p><i> This will be how your name will be displayed in the account section and in reviews </i></p>
                                            </div>
                                            <div class="checkout-form-group">
                                                <label class="input-label">Email address<abbr class="required">*</abbr></label>
                                                <input type="text" class="form-control" disable readonly name="email" value="{{isset($getUserDetails->email)?$getUserDetails->email:''}}">
                                            </div>
                                            <div class="checkout-form-group">
                                                <label class="input-label">Username<abbr class="required">*</abbr></label>
                                                <input type="text" readonly="readonly" disabled class="form-control" name="username" value="{{isset($getUserDetails->username)?$getUserDetails->username:''}}">
                                            </div>
                                            <div class="checkout-form-group">
                                                <label class="input-label">Password change</label>
                                                <label class="input-label">Current password (leave blank to leave unchanged)</label>
                                                <input type="password" name="old_password" class="form-control">
                                            </div>
                                            <div class="checkout-form-group">
                                                <label class="input-label">New password (leave blank to leave unchanged)</label>
                                                <input type="password" name="new_password" class="form-control">
                                            </div>
                                            <div class="checkout-form-group">
                                                <label class="input-label">Confirm new password</label>
                                                <input type="password" name="confirm_password" class="form-control">
                                            </div>
                                            <div class="addressaccount-action">
                                                <button class="btn-bg-small" type="submit">Save Changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="auctions" role="tabpanel" aria-labelledby="auctions-tab">
                                    <div class="account-aacutions-page">
                                        <div class="getmail">
                                            <input type="checkbox"><label>Get email notification for my auctions ending soon (optional)</label>
                                        </div>
                                        <div class="save-btn">
                                            <button class="btn-bg-small">Save Changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection

@section('js')
<!-- <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script> -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function(){



        $('#showBillingAddress').on('click',function(){
            $('.addresbox-block').hide();
            $(this).hide();
            $('#hideBillingAddress').show();
            $('.editaddress-box').show();
        });
        $('#hideBillingAddress').on('click',function(){
            $('.editaddress-box').hide();
            $('.addresbox-block').show();
            $(this).hide();
            $('#showBillingAddress').show();
        });

        getOrderList();

    });

    function getOrderList(){
        console.log("Checking list");
        $.ajax({
            type: 'POST',
            url: '{{route("get.order.details")}}',
            data: {
                '_token': "{{csrf_token()}}",
            },
            success: function (res) {
                // console.log(res);
                $('#updateOrderDesign').append(res.html);
                $('#orderDataTable').DataTable();
                // return false;
                // if (res) {
                //     $("#categories").append('<option value="">Select Category</option>' + res);
                // }
            }
        });
    }
</script>


@endsection
