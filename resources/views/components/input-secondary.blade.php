<div class="mb-3 bg-secondary rounded-lg flex items-center gap-2 p-2">
    <input  {{ $attributes->merge([
        'class' => "w-full text-white rounded-lg bg-transparent border-none focus:outline-none focus:ring-0 active:outline-none focus:bg-tertiary placeholder:text-secondary-text py-3 px-3 transition duration-500 focus:ease-out focus:placeholder:text-secondary-text/30 font-semibold"
    ])}} /> 
        {{ $slot }}
</div>