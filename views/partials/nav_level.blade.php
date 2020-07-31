
@foreach($items as $item)

    @if((!$depth || $depth >= $loop->depth))

        @if(!$sublevel || $sublevel <= $loop->depth)
            @include('fjord-ui::partials.nav_item', ['item' => $item])
        @else 
            @if($item->route->isActive() || child_is_active($item, 'route'))
                @if($item->children->count() > 0)
                    @include('fjord-ui::partials.nav_level',['items'=>$item->children])
                @endif
            @endif
        @endif

    @endif

@endforeach
