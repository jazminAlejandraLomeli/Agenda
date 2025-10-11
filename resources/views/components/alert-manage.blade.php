@props([
    'type' => null, // Tipo de alerta (e.g., warning, error, success)
    'title' => 'Advertencia', // Título del mensaje
    'message' => '', // Mensaje de alerta
])

@php
switch ($type) {
    case 'warning':
        $classes = "hidden bg-yellow-100 border-t-4 border-yellow-500 rounded-b text-yellow-900 px-4 py-3 shadow-md animate__animated animate__fadeInDown animate__delay-0.5s";
        $iconcolor = "fill-current h-6 w-6 text-yellow-500 mr-4";
        break;

    case 'error':
        $classes = "hidden bg-red-100 border-t-4 border-red-500 rounded-b text-red-900 px-4 py-3 shadow-md animate__animated animate__fadeInDown animate__delay-0.5s";
        $iconcolor = "fill-current h-6 w-6 text-red-500 mr-4";
        break;

    case 'success':
        $classes = "hidden bg-green-100 border-t-4 border-green-500 rounded-b text-green-900 px-4 py-3 shadow-md animate__animated animate__fadeInDown animate__delay-0.5s";
        $iconcolor = "fill-current h-6 w-6 text-green-500 mr-4";
        break;

    default:
        $classes = "hidden bg-gray-100 border-t-4 border-gray-500 rounded-b text-gray-900 px-4 py-3 shadow-md animate__animated animate__fadeInDown animate__delay-0.5s";
        $iconcolor = "fill-current h-6 w-6 text-gray-500 mr-4";
        break;
}
@endphp

<div {{ $attributes->merge(['class' => $classes]) }} role="alert">
    <div class="flex">
        <div class="py-1 pe-2">
            {{-- Aquí se muestra el contenido dinámico del slot --}}
              {{ $slot }}
        </div>
        <div>
            <p class="font-bold title-alert">{{ $title }}</p>
            <p class="text-sm text-alert">{{ $message }}</p>
        </div>
    </div>
</div>
