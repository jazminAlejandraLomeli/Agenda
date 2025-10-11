<a {{$attributes->merge(['class' =>'px-4 py-2 dark:bg-blue-500/20 bg-blue-500/20 text-blue-500 dark:text-blue-500 rounded-md flex justify-center items-center hover:bg-blue-500/75 transition ease-in-out duration-300 hover:text-white', 'href'=> '#'])}}>
    {{$slot}}
</a>