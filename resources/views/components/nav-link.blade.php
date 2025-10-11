@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center text-white dark:text-gray-200 transition duration-300 ease-in-out px-3 py-2 bg-tertiary rounded font-semibold hover:bg-white hover:text-primary '
            : 'flex items-center text-white dark:text-gray-200 transition duration-300 ease-in-out px-3 py-2 rounded font-semibold hover:bg-white hover:text-primary';
@endphp

<li class="flex mx-2">
    <a {{ $attributes->merge(['class' => $classes]) }}>{{$slot}}</a>
</li>


