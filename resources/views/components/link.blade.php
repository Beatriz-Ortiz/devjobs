@php
    $classes = "text-xs text-gray-600 hover:text-gray-900";
@endphp
{{-- attributes toma todos los atributos que se le pasen en la etiqueta HTML --}}
{{-- Aquellos definidos en el propio blade deben incluirse dentro del metodo merge como un Array --}}
<a {{ $attributes->merge(['classes' => $classes]) }}>
    {{ $slot }}
</a>
