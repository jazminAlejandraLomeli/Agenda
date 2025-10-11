@props(['label', 'id'])

<section class="mb-4">
    <div class="inline-flex">
        {{ $slot }}
        <label class="text-gray-500">{{ $label }}</label>
    </div>

    <div class="border border-gray-300 dark:border-gray-700 rounded-lg p-4">
        <p {{$attributes->merge(['id' => $id, 'class' => 'text-lg'])}}></p>
    </div>
</section>
