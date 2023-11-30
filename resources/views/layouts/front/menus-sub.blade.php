<ul class="inner-submenu">
	@foreach($subs as $keyAdd => $sub)
		@if($count == 1)
			@if($keyAdd == 0)
				@if($sub['title'] == 'main')
					<li class="level-one level-1">
						<a class="submenu-heading" href="{{url($sub['href'])}}">
							{{$sub['text']}}
						</a>
					</li>
				@endif
			<ul>
				<li class="level-one level-1">
					<h4>By Style</h4>
				</li>
			@endif
				
				@if($sub['title'] == 'style')
					<li class="level-one level-1">
						<a href="{{url($sub['href'])}}">
							{{$sub['text']}}
							<i class="diamond-icon diamond-shape_{{str_replace(' ','-',strtolower($sub['text']))}}"></i>
						</a>
					</li>
				@endif
			@if($keyAdd == 5)
				</ul>
			<ul>
				<li class="level-one level-1">
					<h4 class="shapestyledesign-section">By Shape</h4>
				</li>
				@endif
				@if($sub['title'] == 'shape')
					<li class="level-one level-1">
						<a href="{{url($sub['href'])}}">
							{{$sub['text']}}
							<i class="diamond-icon diamond-shape_{{strtolower($sub['text'])}}"></i>
						</a>
					</li>
				@endif
				@if($keyAdd == 12)
			</ul>
			@endif
		@else
			<li class="level-one {{$sub['class_level']}}">
				<span>
					<a href="{{url($sub['href'])}}">
						{!!$sub['text']!!}
					</a>
					@if(isset($sub['children']) && count($sub['children']) > 0)
						<i class="fa fa-angle-right {{$sub['class_level']}}" aria-hidden="true"></i>
					@endif
				</span>
				@if(isset($sub['children']) && count($sub['children']) > 0)
					@include('layouts.front.menus-sub', ['subs' => $sub['children']])
				@endif
			</li>
		@endif
	@endforeach
</ul>
