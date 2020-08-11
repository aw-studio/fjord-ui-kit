@foreach($locales as $locale)
    @if($wrapper)
        <{{ $wrapper }} class="locale locale-{{ $locale }} {{ $active($locale, $activeClass) }}">
    @endif

    <a 
        href="{{ Request::route()->translate($locale) }}" 
        class="
        @if(!$wrapper)
            locale locale-{{ $locale }} {{ $active($locale, $activeClass) }}
        @endif
        "
        >
        @if(isset($$locale))
            {{ $$locale }}   
        @else
            {{ strtoupper($locale) }}
        @endif
    </a>

    @if($wrapper)
        </{{ $wrapper }}>
    @endif
@endforeach

<x-style>
.locale.locale-active {
    font-weight: bold;
}
</x-style>