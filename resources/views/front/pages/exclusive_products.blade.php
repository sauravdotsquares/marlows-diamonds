@extends('layouts.front.app')

@section('content')

<div>

<div class="category-banner" style="background-image:url(https://192.168.3.151/gitProjects/marlows-diamond/public/assets/images/engagement-rings-banner.png)">
    <div class="container">
        <div class="category-banner-text">
            <h1> Exclusive to Marlows </h1>
            <p></p><p>Traditionally bought for special occasions, Exclusive to Marlows is now 
prevalent in today’s society. It marks a sign of luxury and a touch of 
elegance, our huge selection of Exclusive to Marlows will brighten up any 
collection.</p><p></p>
        </div>
    </div>
</div>
<div class="category-listing-wrap ng-scope" ng-controller="ProductController">
	<div class="container" ng-init="productCatFilters('diamond-jewellery','','')">
		<div class="category-listing-row">
			<div class="category-list-wrap">
				<!-- ngIf: display_filter --><div class="category-product-filter flexed flex-flex-wrap display_first_filter" ng-if="display_filter">
					<!-- ngIf: subCats.length>0 -->
					<!-- ngIf: subSubCats.length>0 -->
				</div><!-- end ngIf: display_filter -->

				<!-- Category listing -->
				<div class="product-grid-wrap">
					<div class="product-grid-row flexed flex-flex-wrap" id="showProductList">

						<div class="product-grid-items-item ">
							<div class="product-items-item-info">
								<div class="product-items-item-image">
									<a href="javascript:;" class="">
										<img src="{{ asset('assets/images/dummy_product.jpeg') }}" alt="">


									</a>
								</div>
								<div class="product-items-item-details">
									<div class="product-items-item-name">
										<a href="javascript:;">Exclusive to Marlows product</a>
										
										{{-- <p> <strong>Price</strong> <span>  £1790.25 - £3255 </span> </p> --}}

									</div>

								</div>
							</div>
						</div>
                        


					</div>
					<input type="hidden" name="sectionHeight" id="sectionHeight" value="2449.12" autocomplete="off">
					<input type="hidden" name="scrollFlag" id="scrollFlag" value="1" autocomplete="off">
				</div>

			</div>
		</div>
	</div>
</div>

</div>


@endsection