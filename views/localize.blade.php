@foreach($locales as $locale)
    <a href="{{ Request::route()->translate($locale) }}" class="locale locale-{{ $locale }}">
        @if(isset($$locale))
            {{ $$locale }}   
        @else
            {{ strtoupper($locale) }}
        @endif
    </a>
@endforeach