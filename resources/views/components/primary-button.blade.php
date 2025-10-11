<button {{ $attributes->merge(['type' => 'submit', 'class' => 'w-full md:w-auto inline-flex items-center justify-center md:justify-start px-5 py-3 bg-gray-200 dark:bg-gray-200 border border-transparent rounded-md font-semibold  text-primary dark:text-primary uppercase  hover:bg-white dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none transition ease-in-out duration-300']) }}>
    {{ $slot }}
</button>
