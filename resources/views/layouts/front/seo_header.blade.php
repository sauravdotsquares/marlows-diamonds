@inject('header_settings', 'App\Models\Settings')

  <!-- for hreflang keywords for all suggested country Start -->
  <link rel="alternate" href="https://marlowsdiamonds.com/" hreflang="x-default" />
  <link rel="alternate" href="https://marlows-diamonds.co.uk/" hreflang="en-gb" />

{{-- OG Canonical --}}
<link rel="canonical" href="{{request()->fullUrl()}}" />
@if(isset($productListingData['previous_url']) && !empty($productListingData['previous_url']))
  <link rel="prev" href="{{$productListingData['previous_url']}}" />
@endif
@if(isset($productListingData['next_url']) && !empty($productListingData['next_url']))
  <link rel="next" href="{{$productListingData['next_url']}}" />
@endif

{{-- OG Tags --}}
<meta property="og:locale" content="en_GB" />
<meta property="og:type" content="article" />
<meta property="og:title" content="{!! isset($data->meta_title)?$data->meta_title:'' !!}" />
<meta property="og:description" content="{!! isset($data->meta_description)?$data->meta_description:'' !!}" />
<meta property="og:url" content="{{url()->current()}}" />
<meta property="og:site_name" content="{!! config('app.name') !!}" />
<meta property="og:image" content="{{asset('images/'.$header_settings->get_options('logo'))}}" />
<meta property="og:image:width" content="120" />
<meta property="og:image:height" content="120" />
<meta property="og:image:type" content="image/jpeg" />

{{-- Twitter Tags --}}
<meta name="twitter:card" content="Summary" />
<meta name="twitter:site" content="@marlowsdiamonds" />
<meta name="twitter:url" content="{{url()->current()}}" />
<meta name="twitter:title" content="{!! isset($data->meta_title)?$data->meta_title:'' !!}" />
<meta name="twitter:description" content="{!! isset($data->meta_description)?$data->meta_description:'' !!}" />

<script type="application/ld+json">
    {
      "@context": "http://schema.org",
      "@type": "Organization",
      "name": "Marlows Diamonds",
      "url": "https://marlows-diamonds.co.uk",
      "logo": "https://marlows-diamonds.co.uk/logo.png",
      "description": "Marlows Diamonds offers a wide range of exquisite diamond jewelry, engagement rings, and luxury watches.",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "123 Diamond Street",
        "addressLocality": "London",
        "postalCode": "SW1A 1AA",
        "addressCountry": "United Kingdom"
      },
      "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "+44 20 1234 5678",
        "contactType": "customer service"
      },
      "sameAs": [
        "https://www.facebook.com/marlowsdiamonds",
        "https://twitter.com/marlowsdiamonds",
        "https://www.instagram.com/marlowsdiamonds/",
        "https://www.pinterest.co.uk/marlowsdiamondsuk/"
      ]
    }
</script>
<script type="application/ld+json">
    {
      "@context": "http://schema.org",
      "@type": "WebSite",
      "name": "Marlows Diamonds",
      "url": "https://marlows-diamonds.co.uk",
      "description": "Explore a stunning collection of diamond jewelry, engagement rings, and luxury watches at Marlows Diamonds.",
      "potentialAction": {
        "@type": "SearchAction",
        "target": "https://marlows-diamonds.co.uk/search?q={search_term_string}",
        "query-input": "required name=search_term_string"
      },
      "sameAs": [
        "https://www.facebook.com/marlowsdiamonds",
        "https://twitter.com/marlowsdiamonds",
        "https://www.instagram.com/marlowsdiamonds/",
        "https://www.pinterest.co.uk/marlowsdiamondsuk/"
      ]
      
    }
</script>