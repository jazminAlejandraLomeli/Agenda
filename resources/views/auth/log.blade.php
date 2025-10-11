<x-guest-layout>
    
    <div class="w-full h-screen md:p-4 rounded-lg dark:bg-gray-800 shadow-lg">
        <div class="grid grid-cols-2 grid-rows-1">
            <div class="col-span-1 row-span-1 bg-primary rounded-l-lg">
                <div class="p-10 flex flex-col h-full">
                    <div class="">
                        <img src="{{ asset('img/logo-agenda.png') }}" class="" alt="Logo agenda" />
                    </div>
    
                       <form action="{{ route('login') }}" method="POST" class="h-full flex items-center grow">
                        @csrf
                        <div class="w-full max-w-md -mt-[100px]">
    
                              @if ($errors->any())
                            <div class="border-t border-b border-white-500 px-4 py-3 mb-5 animate__animated animate__fadeInDown animate__delay-1s" role="alert">
                                <p class="font-bold text-white flex items-center space-x-2">
                                   <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24"><path fill="#ffffff" d="m21.171 15.398l-5.912-9.854C14.483 4.251 13.296 3.511 12 3.511s-2.483.74-3.259 2.031l-5.912 9.856c-.786 1.309-.872 2.705-.235 3.83C3.23 20.354 4.472 21 6 21h12c1.528 0 2.77-.646 3.406-1.771s.551-2.521-.235-3.831M12 17.549c-.854 0-1.55-.695-1.55-1.549c0-.855.695-1.551 1.55-1.551s1.55.696 1.55 1.551c0 .854-.696 1.549-1.55 1.549m1.633-7.424c-.011.031-1.401 3.468-1.401 3.468c-.038.094-.13.156-.231.156s-.193-.062-.231-.156l-1.391-3.438a1.8 1.8 0 0 1-.129-.655c0-.965.785-1.75 1.75-1.75a1.752 1.752 0 0 1 1.633 2.375"/></svg>
                                    <span>Datos incorrectos</span>
                                </p>
    
                                <ul class="text-sm ">
                                    @error('user_name')
                                        <li class="text-white text-sm px-10">{{ $message }}</li>
                                    @enderror
                                    @error('password')
                                        <li class="text-white text-sm px-10">{{ $message }}</li>
                                    @enderror
                                </ul>
                            </div>
                            @endif
    
    
                            <h2 class="dark:text-white text-white text-4xl font-bold mb-10">Inicio de sesión</h2>
    
                            <x-input-secondary type="text" id="user_name" name="user_name" value="{{ old('user_name') }}"
                                autocomplete="off"
                                placeholder="Usuario">
                                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 24 24">
                                    <path fill="none" stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="1.5"
                                        d="M5 20v-1a7 7 0 0 1 7-7v0a7 7 0 0 1 7 7v1m-7-8a4 4 0 1 0 0-8a4 4 0 0 0 0 8" />
                                </svg>
                            </x-input-secondary>
    
                            <x-input-secondary type="password" id="password" name="password" value="{{ old('password') }}"
                                placeholder="Contraseña">
                                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 24 24">
                                <g fill="none">
                                    <path stroke="#ffffff" stroke-width="1.5"
                                            d="M2 12c0-3.771 0-5.657 1.172-6.828S6.229 4 10 4h4c3.771 0 5.657 0 6.828 1.172S22 8.229 22 12s0 5.657-1.172 6.828S17.771 20 14 20h-4c-3.771 0-5.657 0-6.828-1.172S2 15.771 2 12Z" />
                                        <path fill="#ffffff"
                                            d="M9 12a1 1 0 1 1-2 0a1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0a1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0a1 1 0 0 1 2 0" />
                                    </g>
                                </svg>
                            </x-input-secondary>
    
                            <x-primary-button class="mt-3">
                                Iniciar sesión
                            </x-primary-button>
    
                        </div>
                    </form>
    
    
                </div>
            </div>
            <div class="col-span-1 col-row-1  bg-hero-cualtos bg-cover rounded-r-lg w-full h-[calc(100vh-32px)]"></div>
        </div>
    </div>

    
</x-guest>
