@php
if($class = child_is_active($item, 'route', $active_class)) {
    $linkClass = $class;
} else {
    $linkClass = $item->route
        ? $item->route->isActive($active_class)
        : null;
}
@endphp

<li>
    <a class="{{ $linkClass }}" href="{{ $item->route }}">
        {{ $item->title }}
    </a>

    {{-- Expand button --}}
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