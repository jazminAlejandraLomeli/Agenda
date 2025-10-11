@props(['type' => 'success','title' => ''])

@php

$bgColor = [
    'info' => 'bg-blue-100 border-2 border-blue-500 dark:bg-blue-500/10 border-blue-600 dark:text-blue-400 text-blue-600 ',
    'success' => 'bg-green-500/10 border-2 border-green-600 dark:bg-green-500/10 border-green-600 text-green-700 dark:text-green-400',
    'warning' => 'bg-yellow-400/10 border-2 border-yellow-600 dark:bg-yellow-500/10 dark:text-yellow-400 text-yellow-600',
    'danger' => 'bg-red-100 border-2 border-red-500 dark:bg-red-500/10 border-red-600 dark:text-red-400 text-red-600',
];

    $classNames = $bgColor[$type] . ' p-4 mb-4 text-md rounded-lg';

@endphp

<div {{$attributes->merge(['class' => $classNames])}} role="alert">
    <span class="font-semibold">{{$title}}</span> {{$slot}}
</div>
