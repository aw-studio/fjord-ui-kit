@foreach($locales as $locale)
    <a href="{{ Request::route()->translate($locale) }}" class="locale locale-{{ $locale }} {{ $active($locale, 'locale-active') }}">
        @if(isset($$locale))
            {{ $$locale }}   
        @else
            {{ strtoupper($locale) }}
        @endif
    </a>
@endforeach

<x-style>
.locale.locale-active {
    font-weight: bold;
}
</x-style>