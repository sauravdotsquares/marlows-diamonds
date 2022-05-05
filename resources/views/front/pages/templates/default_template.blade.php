@extends('layouts.front.app')
@section('content')
<div class="category-banner" style="background-image:url({{asset('storage/'.$data->image)}})">
	<div class="container">
		<div class="category-banner-text">
			<h1>{{$data->title}}</h1>
			<p>{!!$data->subtitle!!}</p>
		</div>
	</div>
</div>

<div class="defaultpages-wrap">

	<div class="container">

	<div class="defaultpages-cols">
		
			{!!$data->description!!}
		
		
		</div>
	</div>
</div>



@endsection