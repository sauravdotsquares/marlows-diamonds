@extends('layouts.front.app')
@section('content')

<style>
    .sitemap-part{
        padding: 40px;
    }
    .sitemap-part ul{
        margin: 0px 70px;
    }
</style>
<div class="category-banner" style="background-image:url({{env('APP_IMAGE_URL').'/assets/images/engagement-rings-banner.png'}})">
    <div class="container">
        <div class="category-banner-text">
            <h1>SITEMAP</h1>
        </div>
    </div>
</div>

<div class="container">
    <div class="category-banner-text-1">

        <div class="sitemap-part">
            <h2>Products</h2>
            <ul>
                @foreach ($products as $product)
                    <li><a href="{{ url('product/'. $product->slug) }}">{{ $product->title }}</a></li>
                @endforeach        
            </ul>
        </div>

        <div class="sitemap-part">
            <h2>Blogs categories</h2>
            <ul>
                @foreach ($posts_categories as $posts_category)
                    <li><a href="{{ url('/blog/category/' . $posts_category->slug ) }}">{{ $posts_category->name }}</a></li>
                @endforeach        
            </ul>
        </div>

        <div class="sitemap-part">
            <h2>Blogs</h2>
            <ul>
                @foreach ($posts as $post)
                    <li><a href="{{ url('blog/' . $post->slug) }}">{{ $post->title }}</a></li>
                @endforeach        
            </ul>
        </div>

        <div class="sitemap-part">
            <h2>Pages</h2>
            <ul>
                @foreach ($pages as $page)
                    <li><a href="{{ url( $page->slug ) }}">{{ $page->title }}</a></li>
                @endforeach    
                @foreach ($otherPages as $key => $other_page)
                    <li><a href="{{url( $other_page )}}">{{ $key }}</a></li>
                @endforeach        
            </ul>
        </div>







        


        @php
            // Remove the unwanted items from the array before looping
            $filteredCategories = array_filter($categoryUrlsList, function($category) {
                return !in_array(trim(strip_tags($category['name'])), [
                    'Engagement Rings',
                    'ETERNITY DIAMOND RINGS'
                ]);
            });
        @endphp

        <div class="sitemap-part">
            <h2>Product categories</h2>
            <ul>
                @foreach ($filteredCategories as $category)
                    @php
                        $path = parse_url($category['url'], PHP_URL_PATH);
                        $isEngagementSub = preg_match('#^/engagement-rings/[^/]+/.+#', $path);
                    @endphp

                    @if (!$isEngagementSub)
                        <li><a href="{{ url($category['url']) }}">{!! strip_tags($category['name']) !!}</a></li>
                    @endif
                @endforeach        

                {{-- Static list items --}}
                <li><a href="https://marlows-diamonds.co.uk/engagement-rings/round">Round Engagement Rings</a></li>
                <li><a href="https://marlows-diamonds.co.uk/engagement-rings/oval">Oval Engagement Rings</a></li>
                <li><a href="https://marlows-diamonds.co.uk/engagement-rings/cushion">Cushion Engagement Rings</a></li>
                <li><a href="https://marlows-diamonds.co.uk/engagement-rings/heart">Heart Engagement Rings</a></li>
                <li><a href="https://marlows-diamonds.co.uk/engagement-rings/pear">Pear Engagement Rings</a></li>
                <li><a href="https://marlows-diamonds.co.uk/engagement-rings/marquise">Marquise Engagement Rings</a></li>
                <li><a href="https://marlows-diamonds.co.uk/engagement-rings/emerald">Emerald Engagement Rings</a></li>
                <li><a href="https://marlows-diamonds.co.uk/engagement-rings/princess">Princess Engagement Rings</a></li>
            </ul>
        </div>





        





        <div class="sitemap-part">
            <h2>Other pages</h2>
            <ul>
                @foreach ($otherPages as $key => $other_page)
                    <li><a href="{{ url( $other_page ) }}">{{ $key }}</a></li>
                @endforeach        
            </ul>
        </div>


    </div>
</div>

@endsection