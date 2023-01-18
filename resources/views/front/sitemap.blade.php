<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    
    {{-- Products --}}
    @foreach ($products as $product)
        <url>
            <loc>{{ url('product/'. $product->slug) }}</loc>
            <lastmod>{{ $product->updated_at->tz('UTC')->toAtomString() }}</lastmod>
            <priority>0.8</priority>
        </url>
    @endforeach
    
    {{-- Posts --}}
    @foreach ($posts as $post)
        <url>
            <loc>{{ url('blog/' . $post->slug) }}</loc>
            <lastmod>{{ $post->updated_at->tz('UTC')->toAtomString() }}</lastmod>
            <priority>0.8</priority>
        </url>
    @endforeach

    {{-- posts_category --}}
    @foreach ($posts_categories as $posts_category)
        <url>
            <loc>{{ url('/blog/category/' . $posts_category->slug ) }}</loc>
            <lastmod>{{ $posts_category->updated_at->tz('UTC')->toAtomString() }}</lastmod>
            <priority>0.8</priority>
        </url>
    @endforeach

    {{-- pages --}}
    @foreach ($pages as $page)
        <url>
            <loc>{{ url( $page->slug ) }}</loc>
            <lastmod>{{ $page->updated_at->tz('UTC')->toAtomString() }}</lastmod>
            <priority>0.8</priority>
        </url>
    @endforeach

    {{-- All other pages --}}
    @foreach ($otherPages as $otherPage)
        <url>
            <loc>{{ url( $otherPage ) }}</loc>
            <lastmod>{{ now()->tz('UTC')->toAtomString() }}</lastmod>
            <priority>0.8</priority>
        </url>
    @endforeach

</urlset>