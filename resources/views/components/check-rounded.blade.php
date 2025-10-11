@props(['label'])


<label class="relative group">
<input type="checkbox" {{$attributes->merge(['class' => 'hidden peer'])}}  />
    <span
        class="flex cursor-pointer items-center justify-center h-10 w-10 rounded-full border-2 font-bold text-gray-500 border-primary dark:text-white  peer-checked:bg-primary peer-checked:text-white transition duration-150 ease-out hover:ease-in">
        {{$label}}
    </span>

    <span class="absolute top-12 left-1/2 -translate-x-1/2 bg-gray-700 text-white text-xs rounded px-2 py-1 opacity-0 group-hover:opacity-100">
        {{$slot}}
      </span>
</label>
