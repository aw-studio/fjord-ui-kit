
@foreach($items as $item)

    @if((!$depth || $depth >= $loop->depth))

        @if(!$sublevel || $sublevel <= $loop->depth)
            @include('bladesmith::partials.nav_item', ['item' => $item])
        @else 
            @if($item->route->isActive() || child_is_active($item, 'route'))
                @if($item->children->count() > 0)
                    @include('bladesmith::partials.nav_level',['items'=>$item->children])
                @endif
            @endif
        @endif

    @endif

@endforeach
