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
            <h1>Blogs categories</h1>
            <ul>
                @foreach ($posts_categories as $posts_category)
                    <li><a href="{{ url('/blog/category/' . $posts_category->slug ) }}">{{ $posts_category->name }}</a></li>
                @endforeach        
            </ul>
        </div>

        <div class="sitemap-part">
            <h1>Blogs</h1>
            <ul>
                @foreach ($posts as $post)
                    <li><a href="{{ url('blog/' . $post->slug) }}">{{ $post->title }}</a></li>
                @endforeach        
            </ul>
        </div>

        <div class="sitemap-part">
            <h1>Pages</h1>
            <ul>
                @foreach ($pages as $page)
                    <li><a href="{{ url( $page->slug ) }}">{{ $page->title }}</a></li>
                @endforeach    
                @foreach ($otherPages as $key => $other_page)
                    <li><a href="{{url( $other_page )}}">{{ $key }}</a></li>
                @endforeach        
            </ul>
        </div>

        <div class="sitemap-part">
            <h1>Product categories</h1>
            <ul>
                @foreach ($categoryUrlsList as  $category)
                    <li><a href="{{ url($category['url']) }}">{!! strip_tags($category['name']) !!}</a></li>
                @endforeach        
            </ul>
        </div>


    </div>
</div>

@endsection