@foreach($routes as $locale => $route)
    <a href="{{ $route }}">{{ strtoupper($locale) }}</a>
@endforeach