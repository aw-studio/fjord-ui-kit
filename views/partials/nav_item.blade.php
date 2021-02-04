@php
if($class = child_is_active($item, 'route', $active_class)) {
    $linkClass = $class;
} else {
    $linkClass = $item->route
        ? $item->route->isActive($active_class)
        : null;
}
@endphp

<li @if($item->children->count() > 0) class="lit-nav-list--has-children"@endif>
    <a class="{{ $linkClass }}" href="{{ $item->route ?? $item->url }}" target="@if($item->target_blank) _blank @endif">
        {{ $item->title }}
    </a>

    {{-- Expand button --}}
    @if($expandable && $item->children->count() > 0)
        <button class="lit-nav-list__expand">
            <span>
            </span>
        </button>
    @endif

    @if($item->children->count() > 0)
        <ul class="lit-nav-list__level-{{$loop->depth+1}}">
            @include('bladesmith::partials.nav_level',['items'=>$item->children])
        </ul>
    @endif

</li>
