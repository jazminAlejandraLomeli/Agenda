@props(['label', 'id'])

<div class=" mb-2">
    <div class="inline-flex">
        {{$slot}}
        <label class="text-gray-500">{{$label}}</label>
    </div>
    <p {{$attributes->merge(['id' => $id, 'class' => 'text-lg ms-10 -mt-2'])}}></p>
</div>


