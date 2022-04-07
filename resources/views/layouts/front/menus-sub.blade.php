<ul class="inner-submenu">
	@foreach($subs as $sub)
        
        <li class="level-one {{$sub['class_level']}}">

        	<a href="{{url($sub['href'])}}">{{$sub['text']}}
        		@if(isset($sub['children']) && count($sub['children']) > 0)
        			<i class="fa fa-angle-right" aria-hidden="true"></i>
        		@endif
        	</a>

        	@if(isset($sub['children']) && count($sub['children']) > 0)
	            @include('layouts.front.menus-sub', ['subs' => $sub['children']])
	        @endif

        </li>
    @endforeach
</ul>