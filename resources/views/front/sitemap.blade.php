<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
 
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
   
{{-- All other pages --}}
    @foreach ($otherPages as $key => $otherPage)
        @if($key == 'homepage')
            <url>
                <loc>{{ rtrim(env('APP_ROOT_URL') .'/' .  $otherPage , '/') }}</loc>
                <lastmod>{{ now()->tz('UTC')->toAtomString() }}</lastmod>
                <priority>1.0</priority>
            </url>
        @else
            <url>
                <loc>{{ rtrim(env('APP_ROOT_URL') .'/' .  $otherPage , '/') }}</loc>
                <lastmod>{{ now()->tz('UTC')->toAtomString() }}</lastmod>
                <priority>0.8</priority>
            </url>
        @endif
    @endforeach
 
    {{-- All other pages --}}
   
    @foreach ($categoryUrlsList as $categoryUrlPages)
        @if ($loop->first)
            @continue
        @endif
        <url>
            <loc>{{ rtrim(env('APP_ROOT_URL') . $categoryUrlPages['url'], '/') }}</loc>
            <lastmod>{{ now()->tz('UTC')->toAtomString() }}</lastmod>
            <priority>1.0</priority>
        </url>
    @endforeach
 
    {{-- Products --}}
    @foreach ($products as $product)
        <url>
            <loc>{{  rtrim(env('APP_ROOT_URL') . '/product/'. $product->slug,'/') }}</loc>
            <lastmod>{{ now()->tz('UTC')->toAtomString() }}</lastmod>
            <priority>0.8</priority>
        </url>
    @endforeach
   
    {{-- Posts --}}
    @foreach ($posts as $post)
        <url>
            <loc>{{  rtrim(env('APP_ROOT_URL') . '/blog/' . $post->slug,'/') }}</loc>
            <lastmod>{{ now()->tz('UTC')->toAtomString() }}</lastmod>
            <priority>0.8</priority>
        </url>
    @endforeach
 
    {{-- pages --}}
    @foreach ($pages as $page)
        <url>
            <loc>{{ rtrim(env('APP_ROOT_URL') .'/' .  $page->slug,'/') }}</loc>
            <lastmod>{{ now()->tz('UTC')->toAtomString() }}</lastmod>
            <priority>0.8</priority>
        </url>
    @endforeach
 
    {{-- posts_category --}}
    {{-- @foreach ($posts_categories as $posts_category)
        <url>
            <loc>{{  rtrim(env('APP_ROOT_URL') . '/blog/category/' . $posts_category->slug,'/') }}</loc>
            <lastmod>{{ $posts_category->updated_at->tz('UTC')->toAtomString() }}</lastmod>
            <priority>0.7</priority>
        </url>
    @endforeach --}}
 
   
 
</urlset>