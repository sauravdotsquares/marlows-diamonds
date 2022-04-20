@extends('layouts.front.app')

@section('content')
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
                                <li class="nav-item" role="presentation">
                                    <a href="javascript:void(0)" class="nav-link" id="downloads-tab" data-bs-toggle="tab" data-bs-target="#downloads" type="button" role="tab" aria-controls="downloads" aria-selected="false">Downloads</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a href="javascript:void(0)" class="nav-link" id="address-tab" data-bs-toggle="tab" data-bs-target="#address" type="button" role="tab" aria-controls="address" aria-selected="false">Address</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a href="javascript:void(0)" class="nav-link" id="accountd-tab" data-bs-toggle="tab" data-bs-target="#accountd" type="button" role="tab" aria-controls="accountd" aria-selected="false">Account details</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#">Wishlist</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a href="javascript:void(0)" class="nav-link" id="auctions-tab" data-bs-toggle="tab" data-bs-target="#auctions" type="button" role="tab" aria-controls="auctions" aria-selected="false">Auctions settings</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#">Logout</a>
                                </li>
                                
                            </ul>  
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="account-main-content">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                                    <div class="account-dashboard-page">
                                        <p>Hello <strong>MarlowsDiamonds</strong> (not <strong>MarlowsDiamonds</strong>? <a href="#">Log out</a>)</p>
                                        <p>From your account dashboard you can view your <a href="#">recent orders</a>, manage your <a href="#">edit your password and account details</a>.</p>
                                    </div>
                                </div>                                    
                                <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                                    <div class="account-order-page">
                                        <div class="scrollable-table">
                                            <table border-collapse="collapse">
                                                <thead>
                                                    <tr>
                                                        <th>Order</th>
                                                        <th>Date</th>
                                                        <th>Status</th>
                                                        <th>Total</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
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
                                                    </tr>
                                                    <tr>
                                                        <td class="orderid-accoount"><a href="#">#29486</a></td>
                                                        <td><span>April 18, 2022</span></td>
                                                        <td>Cancelled</td>
                                                        <td><span>£940.00</span> for 1 item</td>
                                                        <td><a class="btn-bg-small" href="#">View</a></td>
                                                    </tr>
                                                </tbody>
                                            </table>
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
                                            <div class="col-md-6">
                                                <div class="addresbox-head">
                                                    <h3>Billing Address</h3>
                                                     <a href="#">Edit</a>   
                                                </div>
                                                <div class="addresbox-block">
                                                    <address>sketch creative<br>Pacific House<br>Wilnecote<br>B77 5PA</address>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="addresbox-head">
                                                    <h3>Shipping Address</h3>
                                                     <a href="#">Add</a>   
                                                </div>
                                                <div class="addresbox-block">
                                                    <p> You have not set up this type of address yet. </p>
                                                </div>
                                            </div>

                                        </div>

                                        <!-- Edit Address box-->
                                        <div class="editaddress-box">
                                              <h2>Edit Address</h2>      
                                              <form>    
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="checkout-form-group">
                                                            <label class="input-label">First Name <abbr class="required">*</abbr></label>
                                                            <input type="text" class="form-control" value="sketch">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="checkout-form-group">
                                                            <label class="input-label">Last Name <abbr class="required">*</abbr></label>
                                                            <input type="text" class="form-control" value="Creative">
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
                                                    <input type="text" class="form-control" value="Pacific House">
                                                    <input type="text" class="form-control" placeholder="Apartment, suite, unit, etc. (optional)">
                                                </div>
                                                <div class="checkout-form-group">
                                                    <label class="input-label">Town / City  <abbr class="required">*</abbr></label>
                                                    <input type="text" class="form-control" value="Wilnecote">
                                                </div>
                                                <div class="checkout-form-group">
                                                    <label class="input-label">County <span class="optional">(Optional)</span></label>
                                                    <input type="text" class="form-control">
                                                </div>
                                                <div class="checkout-form-group">
                                                    <label class="input-label">Postcode <abbr class="required">*</abbr></label>
                                                    <input type="text" class="form-control" value="B77 5PA">
                                                </div>
                                                <div class="checkout-form-group">
                                                    <label class="input-label">Phone  <abbr class="required">*</abbr></label>
                                                    <input type="text" class="form-control" value="0121 517 0374">
                                                </div>
                                                <div class="checkout-form-group">
                                                    <label class="input-label">Email address   <abbr class="required">*</abbr></label>
                                                    <input type="text" class="form-control" value="development@sketch-creative.com">
                                                </div>
                                                <div class="save-changes">
                                                    <button class="btn-bg-small">Save address</button>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="editaddress-box">
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
                                        </div>


                                    </div>
                                </div>
                                <div class="tab-pane fade" id="accountd" role="tabpanel" aria-labelledby="accountd-tab">
                                    <div class="account-accountd-page"> 
                                        <form>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="checkout-form-group">
                                                        <label class="input-label">First Name <abbr class="required">*</abbr></label>
                                                        <input type="text" class="form-control" value="Rajendra">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="checkout-form-group">
                                                        <label class="input-label">Last Name <abbr class="required">*</abbr></label>
                                                        <input type="text" class="form-control" value="Sharma">
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="checkout-form-group">
                                                <label class="input-label">Display name<abbr class="required">*</abbr></label>
                                                <input type="text" class="form-control" value="MarlowsDiamonds">
                                                <p><i> This will be how your name will be displayed in the account section and in reviews </i></p>
                                            </div>
                                            <div class="checkout-form-group">
                                                <label class="input-label">Email address<abbr class="required">*</abbr></label>
                                                <input type="text" class="form-control" value="marlowsadmin@yopmail.com">
                                            </div>
                                            <div class="checkout-form-group">
                                                <label class="input-label">Password change</label>
                                                <label class="input-label">Current password (leave blank to leave unchanged)</label>
                                                <input type="password" class="form-control">
                                            </div>
                                            <div class="checkout-form-group">
                                                <label class="input-label">New password (leave blank to leave unchanged)</label>
                                                <input type="password" class="form-control">
                                            </div>
                                            <div class="checkout-form-group">
                                                <label class="input-label">Confirm new password</label>
                                                <input type="password" class="form-control">
                                            </div>
                                            <div class="addressaccount-action">
                                                <button class="btn-bg-small">Save Changes</button>
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
@endsection