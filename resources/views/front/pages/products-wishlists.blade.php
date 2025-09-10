@extends('layouts.front.app')

@section('content')
<div class="category-banner" style="background-image:url(../assets/images/wishlist-bg.jpg)">
    <div class="container">
        <div class="category-banner-text">
            <h1>WISHLIST LIST</h1>
        </div>

    </div>
</div>

<div class="wishlist-wraper">
    @if(session('wishlist'))
    <div class="container">
        <div class="wishlist-heading">
            Wishlist
        </div>
        <div class="wishlist-items-list">
            <form>
                <div class="wishlist-table-wraper">
                    <table class="wishlist-table" border-collapse="collapse">
                        <thead>
                            <tr>
                                <!-- <th class="wish-product-cb"><input type="checkbox" class="global-cb" -->
                                        <!-- title="Select all for bulk action"></th> -->
                                <!-- <th class="wish-product-remove"></th> -->
                                <th class="wish-product-thumbnail"></th>
                                <th class="wish-product-name">Product Name </th>
                                <!-- <th class="wish-product-price">Unit Price</th> -->
                                <th class="wish-product-date">Date Added</th>
                                <th class="wish-product-stock">Stock Status</th>
                                <th class="wish-product-add"></th>
                            </tr>
                        </thead>
                        <tbody>

                                @foreach(session('wishlist') as $id => $details)
                                   
                                    <tr data-id="{{ $id }}">
                                        <!-- <td class="wish-product-cb-col"><input type="checkbox" class="product-cb"></td> -->
                                        <!-- <td class="wish-product-remove-col">
                                            <button class="removew-items-td"><i class="fa fa-times"
                                                    aria-hidden="true"></i></button>
                                        </td> -->
                                        <td class="wish-product-thumbnail-col">
                                            @if(isset($details['image']) && !empty($details['image']))
                                                <a href="{{ asset('product/'.$details['titleSlug']) }}"><img src="{{env('APP_IMAGE_URL').'/storage/'.$details['image']}}" alt="{{ $details['titleName'] }}"></a>
                                            @else
                                                <a href="{{ asset('product/'.$details['titleSlug']) }}"><img src="{{env('APP_IMAGE_URL').'/storage/images/RC2019B_00003-225x225.jpg'}}" alt="{{ $details['titleName'] }}"></a>
                                            @endif
                                        </td>
                                        <td class="wish-product-name-col">
                                            <a href="{{ asset('product/'.$details['titleSlug']) }}">{{ $details['titleName'] }}</a>
                                            <!-- 
                                                {!!isset($details['name'])?$details['name']:''!!} -->
                                            <!-- 

                                            <dl class="variation">
                                                <dt class="variation-MetalColour">Metal Colour :
                                                </dt>
                                                <dd class="variation-MetalColour">18ct White Gold</dd>
                                                <dt class="variation-FingerSize">Finger Size :
                                                </dt>
                                                <dd class="variation-FingerSize">I</dd>
                                            </dl>
                                            <dl class="variation">
                                                <dt class="variation-diamond-shape">diamond-shape :
                                                </dt>
                                                <dd class="variation-diamond-shape">MARQUISE</dd>
                                                <dt class="variation-carat">carat :
                                                </dt>
                                                <dd class="variation-carat">0.30</dd>
                                                <dt class="variation-diamond-colour">diamond-colour :
                                                </dt>
                                                <dd class="variation-diamond-colour">D</dd>
                                                <dt class="variation-diamond-clarity">diamond-clarity :
                                                </dt>
                                                <dd class="variation-diamond-clarity">SI2</dd>
                                                <dt class="variation-diamond-grade">diamond-grade :
                                                </dt>
                                                <dd class="variation-diamond-grade">GD</dd>
                                                <dt class="variation-diamond-certificate">diamond-certificate :
                                                </dt>
                                                <dd class="variation-diamond-certificate">GIA</dd>
                                                <dt class="variation-diamond_type">diamond_type :
                                                </dt>
                                                <dd class="variation-diamond_type">white</dd>
                                                <dt class="variation-diamond_cost">diamond_cost :
                                                </dt>
                                                <dd class="variation-diamond_cost">362.25</dd>
                                                <dt class="variation-diamond-carat">diamond-carat :
                                                </dt>
                                                <dd class="variation-diamond-carat">0.3</dd>
                                                <dt class="variation-diamond-certificate-link">diamond-certificate-link :
                                                </dt>
                                                <dd class="variation-diamond-certificate-link">
                                                    https://diamanti.s3.amazonaws.com/certificates/5413157001.jpg</dd>
                                                <dt class="variation-diamond-stock-no">diamond-stock-no :
                                                </dt>
                                                <dd class="variation-diamond-stock-no">1954785</dd>
                                                <dt class="variation-diamond-image-link">diamond-image-link :
                                                </dt>
                                                <dd class="variation-diamond-image-link">
                                                    https://diamanti.s3.amazonaws.com/images/diamond/213262-119.jpg</dd>
                                                <dt class="variation-diamond-certificate-no">diamond-certificate-no :
                                                </dt>
                                                <dd class="variation-diamond-certificate-no">5413157001</dd>
                                            </dl> -->

                                        </td>
                                        <!-- <td class="wish-product-price-col">
                                            <span> {{config("constants.MY_CURRENCY_SYMBOL")}} {{isset($details['price'])?$details['price']:''}} </span>
                                        </td> -->
                                        <td class="wish-product-date-col">
                                            <span>{{isset($details['added_date'])?$details['added_date']:''}}</span>
                                        </td>
                                        <td class="wish-product-stock-col">
                                            <i class="fa fa-check" aria-hidden="true"></i>
                                            <span>In stock</span>
                                        </td>
                                        <td class="wish-product-add-col">
                                            <button class="btn btn-danger btn-sm remove-from-cart"><i class="fa fa-trash-o"></i></button>
                                            <!-- <td  class="product-action-col" class="actions" data-th="">
                                            </td> -->
                                            <!-- <button class="btn-bg-small">Add to Cart</button> -->
                                        </td>
                                    </tr>
                                @endforeach

                            <!-- <tr>
                                    <td class="wish-product-cb-col"><input type="checkbox" class="product-cb"></td>
                                    <td class="wish-product-remove-col">
                                        <button class="removew-items-td"><i class="fa fa-times" aria-hidden="true"></i></button>
                                    </td>
                                    <td class="wish-product-thumbnail-col">
                                        <a href="#"><img src="{{env('APP_IMAGE_URL').'/assets/images/RC2019B_00003-225x225.jpg'}}" alt="image"></a>
                                    </td>
                                    <td class="wish-product-name-col">
                                        <a href="#">BRIE | Marquise shape Halo and shoulder channel set Engagement Ring</a>

                                    <dl class="variation">
                                        <dt class="variation-MetalColour">Metal Colour :
                                        </dt>
                                        <dd class="variation-MetalColour">18ct White Gold</dd>
                                        <dt class="variation-FingerSize">Finger Size :
                                        </dt>
                                        <dd class="variation-FingerSize">I</dd>
                                    </dl>
                                    <dl class="variation">
                                        <dt class="variation-diamond-shape">diamond-shape :
                                        </dt>
                                        <dd class="variation-diamond-shape">MARQUISE</dd>
                                        <dt class="variation-carat">carat :
                                        </dt>
                                        <dd class="variation-carat">0.30</dd>
                                        <dt class="variation-diamond-colour">diamond-colour	:
                                        </dt>
                                        <dd class="variation-diamond-colour">D</dd>
                                        <dt class="variation-diamond-clarity">diamond-clarity :
                                        </dt>
                                        <dd class="variation-diamond-clarity">SI2</dd>
                                        <dt class="variation-diamond-grade">diamond-grade :
                                        </dt>
                                        <dd class="variation-diamond-grade">GD</dd>
                                        <dt class="variation-diamond-certificate">diamond-certificate :
                                        </dt>
                                        <dd class="variation-diamond-certificate">GIA</dd>
                                        <dt class="variation-diamond_type">diamond_type :
                                        </dt>
                                        <dd class="variation-diamond_type">white</dd>
                                        <dt class="variation-diamond_cost">diamond_cost :
                                        </dt>
                                        <dd class="variation-diamond_cost">362.25</dd>
                                        <dt class="variation-diamond-carat">diamond-carat :
                                        </dt>
                                        <dd class="variation-diamond-carat">0.3</dd>
                                        <dt class="variation-diamond-certificate-link">diamond-certificate-link :
                                        </dt>
                                        <dd class="variation-diamond-certificate-link">https://diamanti.s3.amazonaws.com/certificates/5413157001.jpg</dd>
                                        <dt class="variation-diamond-stock-no">diamond-stock-no :
                                        </dt>
                                        <dd class="variation-diamond-stock-no">1954785</dd>
                                        <dt class="variation-diamond-image-link">diamond-image-link :
                                        </dt>
                                        <dd class="variation-diamond-image-link">https://diamanti.s3.amazonaws.com/images/diamond/213262-119.jpg</dd>
                                        <dt class="variation-diamond-certificate-no">diamond-certificate-no :
                                        </dt>
                                        <dd class="variation-diamond-certificate-no">5413157001</dd>
                                    </dl>

                                    </td>
                                    <td class="wish-product-price-col">
                                        <span> £ 1,188.00 </span>
                                    </td>
                                    <td class="wish-product-date-col">
                                        <span>April 20, 2022</span>
                                    </td>
                                    <td class="wish-product-stock-col">
                                        <i class="fa fa-check" aria-hidden="true"></i>
                                        <span>In stock</span>
                                    </td>
                                    <td class="wish-product-add-col">
                                        <button class="btn-bg-small">Add to Cart</button>
                                    </td>
                                </tr> -->
                        </tbody>

                    </table>
                </div>
                <!-- <div class="appladd-wishlist">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="wishlist-action">
                                <select>
                                    <option>Actions</option>
                                    <option>Add to Cart</option>
                                    <option>Remove</option>
                                </select>
                                <button class="btn-bg-small">Apply Actions</button>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="wishlist-action-buttons">
                                <button class="btn-bg-small">Add Selected to Cart</button>
                                <button class="btn-bg-small">Add All to Cart</button>
                            </div>
                        </div>
                    </div>
                </div> -->
            </form>
            <!-- <div class="share-social-buttons">
                <span>Share on</span>
                <ul>
                    <li>
                        <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-whatsapp" aria-hidden="true"></i></a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-clipboard" aria-hidden="true"></i></a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-envelope" aria-hidden="true"></i></a>
                    </li>
                </ul>
            </div> -->
        </div>
    </div>
    @else
    <div class="container">
        <div class="tinv-message ">
            <div class="tinv-header">
                <h2>Wishlist</h2>
            </div>
            <p class="cart-empty woocommerce-info"> Your Wishlist is currently empty.</p>
            <div class="return-to-shop">
                <a class="btn-bg-small" href="{{ url('/diamond-engagement-rings') }}">Return To Shop</a>
            </div>
        </div>
    </div>
    @endif
</div>


@endsection

@section('js')
<script>

    $(".remove-from-cart").click(function (e) {
        e.preventDefault();

        var ele = $(this);

        if(confirm("Are you sure want to remove?")) {
            $.ajax({
                url: '{{ route("remove.from.wishlist") }}',
                method: "DELETE",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: ele.parents("tr").attr("data-id")
                },
                success: function (response) {
                    window.location.reload();
                }
            });
        }
    });

</script>
@endsection
