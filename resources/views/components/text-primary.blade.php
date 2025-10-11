<div class="w-full dark:bg-gray-700 dark:text-white">
    <textarea rows="3" {{$attributes->merge(['class' => 'dark:bg-gray-700 dark:text-white w-full border-none resize-none focus:outline-none focus:ring-0 active:outline-none overflow-y-auto'])}}>{{$slot}}</textarea>
</div>
<span class="text-red-500 hidden"></span>