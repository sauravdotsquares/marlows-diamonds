<?php
    use App\Models\SitemapUrls;
    SitemapUrls::deleteRecordByUrl(request()->path());
    $pageRedirect = pageRedirects(request()->path());
    if($pageRedirect){
        header("Location: $pageRedirect", true, 301);
        exit();
    }
?>
@extends('layouts.front.error_page')
@section('content')
@section('css')
    <style>
        .error {  color: #e74c3c !important; }
        .head-para-three p.second-para{padding-bottom: 25px;}
        .head-para-three video#video{width: 80%; object-fit: inherit;} 
    </style>
    <link rel="stylesheet" href="{{ asset('assets/vendors/toastr/build/toastr.min.css') }}">
@endsection

    <?php
        // SitemapUrls::deleteRecordByUrl(request()->path());
        // $pageRedirect = pageRedirects(request()->path());
        // if($pageRedirect){
        //     header("Location: $pageRedirect", true, 301);
        //     exit();
        // }
    ?>
    <!-- Not found data -->
    <div class="home-main-banner">
        <div class="main-banner-wraper">
            <div class="container">
                <div class="main-banner-col">
                    {{-- <p  style="color: #8e2e65; font-size: 25px;padding: 20px 0px;" ><strong>Ooopsasfsd , we cannot find what you are looking for.</strong></p>
                --}}
                <center><a href="{{url('/')}}"><img src="{{ asset('assets\images/404image.png') }}"></a></center>
                </div>
            </div>
        </div>
    </div>

@endsection
