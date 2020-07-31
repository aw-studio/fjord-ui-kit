@foreach($locales as $locale)
    <a href="{{ Request::route()->translate($locale) }}">
        @if(isset($$locale))
            {{ $$locale }}   
        @else
            {{ strtoupper($locale) }}
        @endif
    </a>
@endforeach