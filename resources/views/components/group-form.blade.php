@props(['label'])

<div {{$attributes->merge(['class' => 'mb-5' ])}} >
    <label class="text-gray-600 dark:text-gray-100 text-md font-semibold">{{$label}}</label>
    <div class="flex border-2 dark:border-gray-600 border-gray-300 items-center rounded hover my-1 ">
        {{-- <input type="text" class="w-full border-none focus:outline-none focus:ring-0 active:outline-none"  /> --}}
        {{ $slot }}
    </div>
    <span class="text-red-500 hidden"></span>
</div>