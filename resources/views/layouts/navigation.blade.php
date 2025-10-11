<nav class="bg-primary dark:bg-primary h-[70px] w-full fixed top-0 z-10">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
        <a href="{{ route('agenda.index') }}" class="h-16 w-[135px] animate_animated animate__bounceIn">
            <img src="{{ asset('img/logo-agenda.png') }}" alt="Logo" class="w-full" />
        </a>
        <ul class="m-0 grow flex justify-center hidden md:flex">
            @if (auth()->check())


                <x-dropdown align="center" width="60">
                    <x-slot name="trigger">
                        <x-nav-link href="#" :active="request()->routeIs('agenda.index')">
                            {{ __('Agenda') }}
                            <svg class="ms-2 rotate-90" xmlns="http://www.w3.org/2000/svg" width="15" height="15"
                                viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="m14.475 12l-7.35-7.35q-.375-.375-.363-.888t.388-.887t.888-.375t.887.375l7.675 7.7q.3.3.45.675t.15.75t-.15.75t-.45.675l-7.7 7.7q-.375.375-.875.363T7.15 21.1t-.375-.888t.375-.887z" />
                            </svg>
                        </x-nav-link>
                    </x-slot>

                    <x-slot name="content">

                        <div class="w-full px-2 py-1 dark:text-gray-100">
                            <ul class="[&>li>a]:flex [&>li>a]:px-3 [&>li>a]:w-full [&>li>a]:py-2 [&>li>a]:rounded ">
                                <li>
                                    <a class="transition duration-150 ease-out hover:ease-in hover:bg-gray-200 hover:dark:bg-gray-600"
                                        href="{{ route('agenda.index') }}">
                                        <x-icon-details viewBox="0 0 512 512">
                                            <path fill="currentColor"
                                                d="M472 96h-88V40h-32v56H160V40h-32v56H40a24.03 24.03 0 0 0-24 24v336a24.03 24.03 0 0 0 24 24h432a24.03 24.03 0 0 0 24-24V120a24.03 24.03 0 0 0-24-24m-8 352H48V128h80v40h32v-40h192v40h32v-40h80Z" />
                                            <path fill="currentColor"
                                                d="M112 224h32v32h-32zm88 0h32v32h-32zm80 0h32v32h-32zm88 0h32v32h-32zm-256 72h32v32h-32zm88 0h32v32h-32zm80 0h32v32h-32zm88 0h32v32h-32zm-256 72h32v32h-32zm88 0h32v32h-32zm80 0h32v32h-32zm88 0h32v32h-32z" />
                                        </x-icon-details>
                                        <span>Inicio agenda</span>
                                    </a>
                                </li>

                                @if (auth()->check() && auth()->user()->hasRole('superadmin'))
                                    @if (auth()->user()->hasPermissionTo('reserve classroom-create event'))
                                        <li>
                                            <a class="transition duration-150 ease-out hover:ease-in hover:bg-gray-200 hover:dark:bg-gray-600"
                                                href="{{ route('agenda.create.superadmin', ['group_id' => 1]) }}">
                                                <x-icon-details viewBox="0 0 24 24">
                                                    <path fill="currentColor"
                                                        d="M17.5 21.5v-3h-3v-1h3v-3h1v3h3v1h-3v3zM5.616 19q-.691 0-1.153-.462T4 17.384V6.616q0-.691.463-1.153T5.616 5h1.769V2.77h1.077V5h5.153V2.77h1V5h1.77q.69 0 1.153.463T18 6.616v5.715q-.25-.017-.5-.017t-.5.017v-1.715H5v6.769q0 .23.192.423t.423.192h6.674q0 .25.017.5t.063.5zM5 9.615h12v-3q0-.23-.192-.423T16.384 6H5.616q-.231 0-.424.192T5 6.616zm0 0V6z" />
                                                </x-icon-details>
                                                <span>Agregar evento</span>
                                            </a>
                                        </li>

                                        <li>
                                            <a class="transition duration-150 ease-out hover:ease-in hover:bg-gray-200 hover:dark:bg-gray-600"
                                                href="{{ route('agenda.create.superadmin', ['group_id' => 2]) }}">
                                                <x-icon-details viewBox="0 0 48 48">
                                                    <g fill="none" stroke="currentColor" stroke-linejoin="round"
                                                        stroke-width="4">
                                                        <path d="M8 7h32v24H8z" />
                                                        <path stroke-linecap="round"
                                                            d="M4 7h40M15 41l9-10l9 10M16 13h16m-16 6h12m-12 6h6" />
                                                    </g>
                                                </x-icon-details>
                                                <span>Reservar aula</span>
                                            </a>
                                        </li>

                                        <li>
                                            <a class="transition duration-150 ease-out hover:ease-in hover:bg-gray-200 hover:dark:bg-gray-600"
                                                href="{{ route('agenda.confirm-classroom.index') }}">
                                                <x-icon-details viewBox="0 0 24 24">
                                                    <path fill="none" stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="M9 6h11M9 12h11M9 18h11M5 6v.01M5 12v.01M5 18v.01" />
                                                </x-icon-details>
                                                <span>Lista de reservaciones</span>
                                            </a>
                                        </li>
                                    @endif
                                @endif

                                @if (auth()->check() && auth()->user()->hasRole('admin'))
                                    @if (auth()->user()->hasPermissionTo('create event'))
                                        <li>
                                            <a class="transition duration-150 ease-out hover:ease-in hover:bg-gray-200 hover:dark:bg-gray-600"
                                                href="{{ route('agenda.create') }}">
                                                <x-icon-details viewBox="0 0 24 24">
                                                    <path fill="currentColor"
                                                        d="M17.5 21.5v-3h-3v-1h3v-3h1v3h3v1h-3v3zM5.616 19q-.691 0-1.153-.462T4 17.384V6.616q0-.691.463-1.153T5.616 5h1.769V2.77h1.077V5h5.153V2.77h1V5h1.77q.69 0 1.153.463T18 6.616v5.715q-.25-.017-.5-.017t-.5.017v-1.715H5v6.769q0 .23.192.423t.423.192h6.674q0 .25.017.5t.063.5zM5 9.615h12v-3q0-.23-.192-.423T16.384 6H5.616q-.231 0-.424.192T5 6.616zm0 0V6z" />
                                                </x-icon-details>
                                                <span>Agregar evento</span>
                                            </a>
                                        </li>
                                    @endif

                                    @if (auth()->user()->hasPermissionTo('reserve laboratory'))
                                        <li>
                                            <a class="transition duration-150 ease-out hover:ease-in hover:bg-gray-200 hover:dark:bg-gray-600"
                                                href="{{ route('agenda.create') }}">
                                                <x-icon-details viewBox="0 0 24 24">
                                                    <path fill="currentColor"
                                                        d="M17.5 21.5v-3h-3v-1h3v-3h1v3h3v1h-3v3zM5.616 19q-.691 0-1.153-.462T4 17.384V6.616q0-.691.463-1.153T5.616 5h1.769V2.77h1.077V5h5.153V2.77h1V5h1.77q.69 0 1.153.463T18 6.616v5.715q-.25-.017-.5-.017t-.5.017v-1.715H5v6.769q0 .23.192.423t.423.192h6.674q0 .25.017.5t.063.5zM5 9.615h12v-3q0-.23-.192-.423T16.384 6H5.616q-.231 0-.424.192T5 6.616zm0 0V6z" />
                                                </x-icon-details>
                                                <span>Reservar laboratorio</span>
                                            </a>
                                        </li>
                                    @endif

                                    @if (auth()->user()->hasPermissionTo('reserve classroom'))
                                        <li>
                                            <a class="transition duration-150 ease-out hover:ease-in hover:bg-gray-200 hover:dark:bg-gray-600"
                                                href="{{ route('agenda.create') }}">
                                                <x-icon-details viewBox="0 0 48 48">
                                                    <g fill="none" stroke="currentColor" stroke-linejoin="round"
                                                        stroke-width="4">
                                                        <path d="M8 7h32v24H8z" />
                                                        <path stroke-linecap="round"
                                                            d="M4 7h40M15 41l9-10l9 10M16 13h16m-16 6h12m-12 6h6" />
                                                    </g>
                                                </x-icon-details>
                                                <span>Reservar aula</span>
                                            </a>
                                        </li>
                                    @endif

                                    @if (auth()->user()->hasPermissionTo('approve reserve'))
                                        <li>
                                            <a class="transition duration-150 ease-out hover:ease-in hover:bg-gray-200 hover:dark:bg-gray-600"
                                                href="{{ route('agenda.confirm-classroom.index') }}">
                                                <x-icon-details viewBox="0 0 24 24">
                                                    <path fill="none" stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="M9 6h11M9 12h11M9 18h11M5 6v.01M5 12v.01M5 18v.01" />
                                                </x-icon-details>
                                                <span>Lista de reservaciones</span>
                                            </a>
                                        </li>
                                    @endif

                                    @if (auth()->user()->hasPermissionTo('approve laboratory'))
                                        <li>
                                            <a class="transition duration-150 ease-out hover:ease-in hover:bg-gray-200 hover:dark:bg-gray-600"
                                                href="{{ route('agenda.confirm-laboratory.index') }}">
                                                <x-icon-details viewBox="0 0 24 24">
                                                    <path fill="none" stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="M9 6h11M9 12h11M9 18h11M5 6v.01M5 12v.01M5 18v.01" />
                                                </x-icon-details>
                                                <span>Lista de reservaciones</span>
                                            </a>
                                        </li>
                                    @endif
                                @endif


                                {{-- @if (auth()->check() && auth()->user()->hasRole('superadmin'))
                                    @if (auth()->user()->hasPermissionTo('reserve classroom-create event'))
                                        
                                    @endif
                                @endif --}}

                            </ul>
                        </div>
                    </x-slot>
                </x-dropdown>

                @if (auth()->check())
                    <x-dropdown align="center" width="60">
                        <x-slot name="trigger">
                            <x-nav-link href="#" :active="request()->routeIs('agenda.statistics.events')">
                                {{ __('Estadística') }}
                                <svg class="ms-2 rotate-90" xmlns="http://www.w3.org/2000/svg" width="15"
                                    height="15" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="m14.475 12l-7.35-7.35q-.375-.375-.363-.888t.388-.887t.888-.375t.887.375l7.675 7.7q.3.3.45.675t.15.75t-.15.75t-.45.675l-7.7 7.7q-.375.375-.875.363T7.15 21.1t-.375-.888t.375-.887z" />
                                </svg>
                            </x-nav-link>
                        </x-slot>

                        <x-slot name="content">

                            <div class="w-full px-2 py-1 dark:text-gray-100">

                                @if (Auth::user()->group->type == 'Protocolo' || Auth::user()->group->type == 'Superadmin')
                                    <ul
                                        class="[&>li>a]:flex [&>li>a]:px-3 [&>li>a]:w-full [&>li>a]:py-2 [&>li>a]:rounded ">
                                        <li>
                                            <a class="transition duration-150 ease-out hover:ease-in hover:bg-gray-200 hover:dark:bg-gray-600"
                                                href="{{ route('agenda.statistics.events') }}">
                                                <x-icon-details viewBox="0 0 512 512">
                                                    <path fill="currentColor"
                                                        d="M472 96h-88V40h-32v56H160V40h-32v56H40a24.03 24.03 0 0 0-24 24v336a24.03 24.03 0 0 0 24 24h432a24.03 24.03 0 0 0 24-24V120a24.03 24.03 0 0 0-24-24m-8 352H48V128h80v40h32v-40h192v40h32v-40h80Z" />
                                                    <path fill="currentColor"
                                                        d="M112 224h32v32h-32zm88 0h32v32h-32zm80 0h32v32h-32zm88 0h32v32h-32zm-256 72h32v32h-32zm88 0h32v32h-32zm80 0h32v32h-32zm88 0h32v32h-32zm-256 72h32v32h-32zm88 0h32v32h-32zm80 0h32v32h-32zm88 0h32v32h-32z" />
                                                </x-icon-details>
                                                <span>Eventos</span>
                                            </a>
                                        </li>
                                    </ul>
                                @endif

                                @if (Auth::user()->group->type == 'CTA' || Auth::user()->group->type == 'Superadmin')
                                    <ul
                                        class="[&>li>a]:flex [&>li>a]:px-3 [&>li>a]:w-full [&>li>a]:py-2 [&>li>a]:rounded ">
                                        <li>
                                            <a class="transition duration-150 ease-out hover:ease-in hover:bg-gray-200 hover:dark:bg-gray-600"
                                                href="{{ route('agenda.statistics.classrooms') }}">
                                                <x-icon-details viewBox="0 0 48 48">
                                                    <g fill="none" stroke="currentColor" stroke-linejoin="round"
                                                        stroke-width="4">
                                                        <path d="M8 7h32v24H8z" />
                                                        <path stroke-linecap="round"
                                                            d="M4 7h40M15 41l9-10l9 10M16 13h16m-16 6h12m-12 6h6" />
                                                    </g>
                                                </x-icon-details>
                                                <span>Aulas</span>
                                            </a>
                                        </li>
                                    </ul>
                                @endif

                                @if (Auth::user()->group->type == 'CTA' || Auth::user()->group->type == 'Laboratorio')
                                    <ul
                                        class="[&>li>a]:flex [&>li>a]:px-3 [&>li>a]:w-full [&>li>a]:py-2 [&>li>a]:rounded ">
                                        <li>
                                            <a class="transition duration-150 ease-out hover:ease-in hover:bg-gray-200 hover:dark:bg-gray-600"
                                                href="{{ route('agenda.statistics.laboratory') }}">
                                                <x-icon-details viewBox="0 0 48 48">
                                                    <g fill="none" stroke="currentColor" stroke-linejoin="round"
                                                        stroke-width="4">
                                                        <path d="M8 7h32v24H8z" />
                                                        <path stroke-linecap="round"
                                                            d="M4 7h40M15 41l9-10l9 10M16 13h16m-16 6h12m-12 6h6" />
                                                    </g>
                                                </x-icon-details>
                                                <span>Laboratorios</span>
                                            </a>
                                        </li>
                                    </ul>
                                @endif

                            </div>
                        </x-slot>
                    </x-dropdown>
                @endif


                <x-nav-link :href="route('agenda.event-types.index')" :active="request()->routeIs('agenda.event-types.index') ||
                    request()->routeIs('agenda.dependencies.index') ||
                    request()->routeIs('agenda.places.index')">
                    {{ __('Administrar') }}
                </x-nav-link>

                @role('superadmin')
                    <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.index') || request()->routeIs('users.create')">
                        {{ __('Usuarios') }}
                    </x-nav-link>
                @endrole

            @endif

        </ul>

        <div>

            @if (auth()->check())
                <!-- Settings Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-dropdown align="right" width="60">
                        <x-slot name="trigger">
                            <button class="flex gap-1 items-center">

                                @php
                                    $firstLetter = substr(auth()->user()->name, 0, 1);
                                @endphp
                                <div
                                    class="w-11 h-11 rounded-full bg-secondary flex items-center justify-center text-xl font-bold text-white cursor-pointer transition ease-in-out duration-150">
                                    {{ $firstLetter }}</div>
                                <svg class="ms-2 rotate-90 dark:text-white" xmlns="http://www.w3.org/2000/svg"
                                    width="15" height="15" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="m14.475 12l-7.35-7.35q-.375-.375-.363-.888t.388-.887t.888-.375t.887.375l7.675 7.7q.3.3.45.675t.15.75t-.15.75t-.45.675l-7.7 7.7q-.375.375-.875.363T7.15 21.1t-.375-.888t.375-.887z" />
                                </svg>

                            </button>

                        </x-slot>

                        <x-slot name="content">

                            <div
                                class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out font-bold text-lg text-lg">
                                {{ auth()->user()->name }}

                            </div>
                            <hr class="border-t border-gray-200 dark:border-gray-500 mx-2" />

                            <!-- Account Management -->

                            <x-dropdown-link :href="route('agenda.profile.index')">
                                <div class="flex items-center">
                                    <x-icon-details viewBox="0 0 24 24">
                                        <g fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="1.5" color="currentColor">
                                            <path
                                                d="M2 12c0-4.243 0-6.364 1.464-7.682C4.93 3 7.286 3 12 3s7.071 0 8.535 1.318S22 7.758 22 12s0 6.364-1.465 7.682C19.072 21 16.714 21 12 21s-7.071 0-8.536-1.318S2 16.242 2 12" />
                                            <path
                                                d="M8.4 8h-.8c-.754 0-1.131 0-1.366.234C6 8.47 6 8.846 6 9.6v.8c0 .754 0 1.131.234 1.366C6.47 12 6.846 12 7.6 12h.8c.754 0 1.131 0 1.366-.234C10 11.53 10 11.154 10 10.4v-.8c0-.754 0-1.131-.234-1.366C9.53 8 9.154 8 8.4 8M6 16h4m4-8h4m-4 4h4m-4 4h4" />
                                        </g>
                                    </x-icon-details>
                                    {{ __('Mi perfil') }}
                                </div>
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    <div class="flex items-center">
                                        <x-icon-details viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M3 21v-2h2V3h10v1h4v15h2v2h-4V6h-2v15zM7 5v14zm4 8q.425 0 .713-.288T12 12t-.288-.712T11 11t-.712.288T10 12t.288.713T11 13m-4 6h6V5H7z" />
                                        </x-icon-details>
                                        {{ __('Cerrar sesión') }}
                                    </div>

                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>

                <!-- Hamburger -->
                <div class="flex items-center sm:hidden">

                    <div class="tham  tham-e-squeeze tham-w-6">
                        <div class="tham-box">
                            <div class="tham-inner bg-gray-100"></div>
                        </div>
                    </div>

                </div>
            @else
                {{-- Boton de reserva Aula Sin necesidad de iniciar seción --}}
                <div class="flex justify-center items-center">

                    @if (request()->is('agenda/guest/classrooms'))
                        <x-nav-link :href="route('agenda.guest.classrom.create', ['type_events' => 'classrooms'])" :active="false">
                            {{ _('Reservar aula') }}
                        </x-nav-link>
                    @endif

                    <x-nav-link :href="route('login')" :active="false">
                        {{ __('Iniciar sesion') }}
                    </x-nav-link>

                </div>
            @endif

            {{-- <div class="w-10 h-10 rounded-full bg-secondary flex items-center justify-center text-xl font-bold text-white hover:cursor-pointer">
                JP
            </div> --}}
        </div>
    </div>

</nav>
