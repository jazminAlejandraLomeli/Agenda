<div >

    <div class="flex space-x-3 items-end">
        
        <x-group-form class="w-full">
            <x-slot name="label">Nombre del evento</x-slot>
            <x-input-primary type="text" id="titleEvent" name="title" value="{{ old('title') }}"></x-input-primary>
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" class="mx-2"
                viewBox="0 0 48 48">
                <g fill="none" stroke="#CD5700" stroke-linejoin="round" stroke-width="4">
                    <path
                        d="M5 19h38v21a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2zM5 9a2 2 0 0 1 2-2h34a2 2 0 0 1 2 2v10H5z" />
                    <path stroke-linecap="round" d="M16 4v8m16-8v8m-4 22h6m-20 0h6m8-8h6m-20 0h6" />
                </g>
            </svg>
        </x-group-form>
    
        <x-tertiary-button class="mb-6" id="complete-title">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12.5 21H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v5m-4-9v4M8 3v4m-4 4h16m-4 8h6m-3-3v6"/></svg>
            {{-- <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24"><path fill="currentColor" d="M5.616 21q-.691 0-1.153-.462T4 19.385V6.615q0-.69.463-1.152T5.616 5h1.769V2.77h1.077V5h7.154V2.77h1V5h1.769q.69 0 1.153.463T20 6.616v12.769q0 .69-.462 1.153T18.384 21zm0-1h12.769q.23 0 .423-.192t.192-.424v-8.768H5v8.769q0 .23.192.423t.423.192M5 9.615h14v-3q0-.23-.192-.423T18.384 6H5.616q-.231 0-.424.192T5 6.616zm0 0V6zM7.5 13.5v-1h9v1zm0 4v-1h6v1z"/></svg> --}}
            {{-- <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 512 512">
                <path fill="currentColor" fill-rule="evenodd"
                    d="M426.667 320v64h64v42.667h-64v64H384v-64h-64V384h64v-64zm-176-85.333c60.31 0 109.485 49.03 111.906 110.451l.094 4.749v12.8H320v-12.8c0-38.933-29.192-70.302-65.425-72.42l-3.908-.113H176c-36.708 0-67.166 30.026-69.223 68.392l-.11 4.141V384h192v42.667H64v-76.8c0-62.033 47.668-112.614 107.383-115.104l4.617-.096zm-37.334-192c41.238 0 74.667 33.43 74.667 74.667c0 39.862-31.238 72.429-70.57 74.556l-4.097.11c-41.237 0-74.666-33.43-74.666-74.666c0-39.863 31.238-72.43 70.57-74.557zm0 42.667c-17.673 0-32 14.327-32 32s14.327 32 32 32s32-14.327 32-32s-14.327-32-32-32" />
            </svg> --}}
        </x-tertiary-button>
    </div>
    
</div>

@include('modals.complete-title-event')