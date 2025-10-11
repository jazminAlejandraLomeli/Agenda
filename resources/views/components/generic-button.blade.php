<button {{$attributes->merge(['class' => 'p-2 border border-gray-300 rounded-lg text-gray-500 hover:bg-gray-300 transition duration-150 ease-out hover:ease-in','type'=>'button'])}} >
    {{$slot}}
</button>