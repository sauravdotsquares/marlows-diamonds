<nav class="nav-navbars">

    <ul class="static-megamenu">

        @if (!empty($navbars))

            @foreach ($navbars as $keyCount => $navbarItem)
                <li class="level-zero submenu {{ $navbarItem['class_level'] }}">
                    <span>
                        <a href="{{ url($navbarItem['href']) }}">
                            {!! $navbarItem['text'] !!}
                        </a>
                        @if (isset($navbarItem['children']) && count($navbarItem['children']) > 0)
                            <i class="fa fa-angle-down {{ $navbarItem['class_level'] }}" aria-hidden="true"></i>
                        @endif

                    </span>
                    @if (isset($navbarItem['children']) && count($navbarItem['children']) > 0)
                        @include('layouts.front.menus-sub', [
                            'subs' => $navbarItem['children'],
                            'count' => $keyCount,
                            'titlename' => $navbarItem['title'],
                        ])
                    @endif
                </li>
            @endforeach

        @endif
    </ul>
</nav>
