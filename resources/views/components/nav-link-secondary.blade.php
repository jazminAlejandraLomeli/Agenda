@props(['active'])

@php
$classes = ($active ?? false)
            ? 'px-6 py-3 relative after:absolute after:w-full after:h-[3px] after:-bottom-[12px] after:left-0 after:dark:bg-primary after:bg-primary hover:bg-primary/20 hover:dark:bg-primary/20 rounded-md transition duration-300 ease-in-out'
            : 'px-6 py-3 hover:dark:bg-primary/20 hover:bg-primary/20 rounded-md transition duration-300 ease-in-out';
@endphp

<li class="flex mx-1">
    <a {{ $attributes->merge(['class' => $classes]) }}>{{$slot}}</a>
</li>


