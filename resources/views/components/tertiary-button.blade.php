<button {{ $attributes->merge(['type' => 'button', 'class' =>'px-4 py-2 dark:bg-primary/20 bg-primary/20 text-primary dark:text-primary rounded-md flex justify-center items-center hover:bg-primary/75 transition ease-in-out duration-300 hover:text-white']) }}>
    {{ $slot }}
</button>