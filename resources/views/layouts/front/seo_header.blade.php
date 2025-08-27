{{-- @inject('header_settings', 'App\Models\Settings') --}}
<?php 
  $getURLWithParameter = str_replace(Request::root(), '', request()->fullUrl());
?>
<link rel="canonical" href="{{ request()->url() }}" />
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
@yield('dynamic_og_image')
<meta property="og:image:width" content="120" />
<meta property="og:image:height" content="120" />
<meta property="og:image:type" content="image/jpeg" />

{{-- Twitter Tags --}}
<meta name="twitter:card" content="Summary" />
<meta name="twitter:site" content="@marlowsdiamonds" />
<meta name="twitter:url" content="{{url()->current()}}" />
<meta name="twitter:title" content="{!! isset($data->meta_title)?$data->meta_title:'' !!}" />
<meta name="twitter:description" content="{!! isset($data->meta_description)?$data->meta_description:'' !!}" />

@if(env('APP_ENV')=='production')
    <!-- Meta Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '1238805530482186');
        fbq('track', 'PageView');
    </script>
    <noscript>
        <img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=1238805530482186&ev=PageView&noscript=1" alt="facebook"/>
    </noscript>
    <!-- End Meta Pixel Code -->
@endif
<script type="text/javascript" src="https://dynamic.criteo.com/js/ld/ld.js?a=119681" async="true"></script>
<script type="application/ld+json">
    {
      "@context": "http://schema.org",
      "@type": "Organization",
      "name": "Marlows Diamonds",
      "url": "https://marlows-diamonds.co.uk",
      "logo": "{{env('APP_IMAGE_URL').'/images/logo/'.$header_settings['logo']}}",
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


{{-- Breadcrumb schema starts from here --}}
@php
$baseURL = url('/');
$currentURL = url()->current();

$parsedUrl = parse_url($currentURL);
$path = isset($parsedUrl['path']) ? trim($parsedUrl['path'], '/') : '';

$pathSegments = explode('/', $path);
$breadcrumbs = [];

$breadcrumbs[] = [
    '@type' => 'ListItem',
    'position' => 1,
    'name' => 'Home',
    'item' => $baseURL
];

$fullPath = $baseURL;
$isProductPage = in_array('product', $pathSegments);

if (!empty($pathSegments[0])) {
    foreach ($pathSegments as $index => $segment) {

      // Convert URL segment into a readable format
      $formattedName = ucwords(str_replace('-', ' ', $segment));

      // Apply condition for "Engagement Rings"
      if ($formattedName === 'Engagement Rings') {
          $formattedName = 'Diamond Engagement Rings';
          $segment = 'diamond-engagement-rings'; // Updated URL slug
      }


         // Fix subsequent segments to not include "diamond-" in the URL
          if ($index > 0 && strpos($fullPath, 'diamond-engagement-rings') !== false) {
              $fullPath = str_replace('diamond-engagement-rings', 'engagement-rings', $fullPath);
          }


        $fullPath .= '/' . $segment;
        // Skip "Product" breadcrumb on product detail pages
        if ($isProductPage && $segment === 'product' && $index < count($pathSegments) - 1) {
            continue;
        }

        $breadcrumbs[] = [
            '@type' => 'ListItem',
            'position' => count($breadcrumbs) + 1,
            'name' => $formattedName,
            'item' => $fullPath
        ];
    }
}
@endphp

<script type="application/ld+json">
{
  "@context": "https://schema.org/",
  "@type": "BreadcrumbList",
  "itemListElement": {!! json_encode($breadcrumbs, JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT) !!}
}
</script>