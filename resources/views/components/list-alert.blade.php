@props(['type' => 'info', 'title' => '', 'subtitle' => ''])

@php
    $bgColor = [
        'info' => 'bg-blue-100 border-blue-500 dark:bg-blue-500/10 border-blue-600 dark:text-blue-400',
        'success' => 'bg-green-100 border-green-500 dark:bg-green-500/10 border-green-600 dark:text-green-400',
        'warning' => 'bg-yellow-100 border-yellow-500 dark:bg-yellow-500/10 border-yellow-600 dark:text-yellow-400',
        'danger' => 'bg-red-100 border-red-500 dark:bg-red-500/10 border-red-600 dark:text-red-400',
    ];
    $classNames = $bgColor[$type] . ' px-4 py-3 rounded relative mb-4';

@endphp

<div {{$attributes->merge(['class' => $classNames])}} role="alert">
    <strong class="font-bold">{{$title}}</strong>
    <span class="block sm:inline">{{$subtitle}}</span>
    <ul class="list-disc ms-10 mt-2">
        {{ $slot }}
    </ul>
</div>