<a {{$attributes->merge(['class' =>'px-4 py-2 dark:bg-red-500/20 bg-red-500/20 text-red-500 dark:text-red-500 rounded-md flex justify-center items-center hover:bg-red-500/75 transition ease-in-out duration-300 hover:text-white', 'href'=> '#'])}}>
    {{$slot}}
</a>