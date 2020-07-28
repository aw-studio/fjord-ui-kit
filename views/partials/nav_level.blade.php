
@foreach($items as $item)

    @if((!$depth || $depth >= $loop->depth))

        @if(!$sublevel || $sublevel <= $loop->depth)
        <li>
            <a 
            class="{{ $item->route->isActive($active_class) }} {{ child_is_active($item, 'route', $active_class) }}"
            href="{{ $item->route }}"
            >
            {{ $item->title }}
            </a>
            @if($expandable && $item->children->count() > 0)
                <button class="fj-nav-list__expand">
                    <span>
                    </span>
                </button>
            @endif
            @if($item->children->count() > 0)
            <ul class="fj-nav-list__level-{{$loop->depth+1}}">
                @include('fjord-ui::partials.nav_level',['items'=>$item->children])
            </ul>
            @endif
        </li>
        @else 
            @if($item->route->isActive() || child_is_active($item, 'route'))
                @if($item->children->count() > 0)
                    @include('fjord-ui::partials.nav_level',['items'=>$item->children])
                @endif
            @endif
        @endif

    @endif

@endforeach
