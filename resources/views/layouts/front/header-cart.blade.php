<!-- Collect the nav links, forms, and other content for toggling -->

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

<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    @include('layouts.front.category-nav')
    <ul class="nav navbar-nav navbar-right">
        @if(auth()->check())
            <li class="visible-xs"><a href="{{ route('accounts', ['tab' => 'profile']) }}"><i class="fa fa-home"></i> My Account</a></li>
            <li class="visible-xs"><a href="{{ route('logout') }}"><i class="fa fa-sign-out"></i> Logout</a></li>
        @else
            <li class="visible-xs"><a href="{{ route('login') }}"> <i class="fa fa-lock"></i> Login</a></li>
            <li class="visible-xs"><a href="{{ route('register') }}"> <i class="fa fa-sign-in"></i> Register</a></li>
        @endif
        <li id="cart" class="menubar-cart visible-xs">
            <a href="{{ route('cart.index') }}" title="View Cart" class="awemenu-icon menu-shopping-cart">
                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                <span class="cart-number">{{ $cartCount }}</span>
            </a>
        </li>
        
        <li>
            <!-- search form -->
            <form action="{{route('search.product')}}" method="GET" class="form-inline" style="margin: 15px 0 0;">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Search..." value="{{ request()->input('q') }}">
                    <span class="input-group-btn">
                        <button type="submit" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i> Search</button>
                    </span>
                </div>
            </form>
            <!-- /.search form -->
        </li>
    </ul>
</div><!-- /.navbar-collapse -->
