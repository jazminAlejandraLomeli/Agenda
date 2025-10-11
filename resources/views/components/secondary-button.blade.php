<button {{ $attributes->merge(['type' => 'button', 'class' =>'px-4 py-2 dark:bg-primary bg-primary text-white rounded-md flex items-center hover:bg-tertiary transition ease-in-out duration-300']) }}>
    {{ $slot }}
</button>
