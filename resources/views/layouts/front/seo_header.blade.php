@inject('header_settings', 'App\Models\Settings')

{{-- OG Canonical --}}
<link rel="canonical" href="{{url()->current()}}" />

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
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "Marlow`s Diamonds",
      "url": "{{url()->current()}}",
      "logo": "{{asset('images/'.$header_settings->get_options('logo'))}}",
     "sameAs": [
        "https://www.facebook.com/MarlowsDiamonds/",
        "https://www.instagram.com/marlows_diamonds/"
      ]
    
    }
</script>