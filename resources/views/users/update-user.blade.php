<x-app-layout>
    <x-slot name="header">
        <div class="flex dark:text-white items-center gap-4">

            <x-tertiary-link-button href="{{ route('users.index') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="m9.55 12l7.35 7.35q.375.375.363.875t-.388.875t-.875.375t-.875-.375l-7.7-7.675q-.3-.3-.45-.675t-.15-.75t.15-.75t.45-.675l7.7-7.7q.375-.375.888-.363t.887.388t.375.875t-.375.875z" />
                </svg>
            </x-tertiary-link-button>
            <h2 class="text-2xl font-bold">Editar usuario</h2>
        </div>
    </x-slot>

    <div class="bg-white dark:bg-gray-800 shadow max-w-7xl p-10 mx-auto mt-5 rounded">



        @if ($errors->any())
            <x-list-alert type="danger">
                <x-slot name="title">¡Ups!</x-slot>
                <x-slot name="subtitle">Algo salió mal.</x-slot>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </x-list-alert>
        @endif




        @if (session('error'))
            <x-alert type="danger">
                <x-slot name="title">¡Ups!</x-slot>
                {{ session('error') }}
            </x-alert>
        @endif



        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            <section class="border-e-2 pe-5 dark:text-white">
                <div class="mb-4">
                    <label class="text-gray-600 dark:text-gray-100 text-md font-semibold">Nombre</label>
                    <hr class="py-1" />
                    <p class="font-semibold dark:bg-gray-700 bg-gray-200 px-4 py-3 rounded">{{ $user->name }}</p>
                </div>

                <div class="mb-4">
                    <label class="text-gray-600 dark:text-gray-100 text-md font-semibold">Nombre de usuario</label>
                    <hr class="py-1" />
                    <p class="font-semibold dark:bg-gray-700 bg-gray-200 px-4 py-3 rounded">{{ $user->user_name }}</p>
                </div>
            </section>


            <form action="{{ route('users.update', ['id' => $user->id]) }}" method="POST" id="form">
                @csrf
                @method('PATCH')

                <x-group-form>
                    <x-slot name="label">Grupo</x-slot>
                    <x-select-primary name="group" id="group">
                        <option selected disabled>Selecciona un grupo</option>
                        @foreach ($groups as $group)
                            <option value="{{ $group->id }}" {{ $group->id === $user->group_id ? 'selected' : '' }}>
                                {{ strtoupper($group->type) }}</option>
                        @endforeach
                    </x-select-primary>
                </x-group-form>

                <x-group-form>
                    <x-slot name="label">Rol</x-slot>
                    <x-select-primary name="role" id="role">
                        <option selected disabled>Selecciona un rol</option>
                        @foreach ($roles as $role)
                            @if(!empty($user->roles->first()) && $role->id === $user->roles->first()->id)
                                <option value="{{ $role->id }}" selected>{{ strtoupper($role->name) }}</option>
                            @else
                                <option value="{{ $role->id }}">{{ strtoupper($role->name) }}</option>
                            @endif
                        @endforeach
                    </x-select-primary>
                </x-group-form>

                <hr class="mb-4" />

                <x-alert-permission />


                <div id="permissions"></div>


                
                <x-accordion title="Lista de permisos" class="accordionPermission">
                    <ul id="listPermission" class="m-3">
                        @foreach ($userPermissions as $userPermission)
                            <li id="{{ $userPermission->id }}" data-name="{{ $userPermission->name }}"
                                class="flex justify-between items-center p-2 bg-gray-100 dark:bg-gray-700 rounded mb-2">
                                {{ $userPermission->name }}
                                <span class="text-red-500 cursor-pointer deletePermissions">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30px" height="30px" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </x-accordion>
                <span class="text-red-500 pt-1 hidden" id="error-permissions"></span>

                <hr class="mb-4" />

                <x-group-form>
                    <x-slot name="label">Permisos sin usar</x-slot>
                    <x-select-primary name="unassigned_permissions" id="unassigned-permissions">
                        <option selected disabled>Selecciona el permiso</option>
                    </x-select-primary>
                </x-group-form>

                <hr class="mb-4" />



                <div class="flex justify-end gap-5 mt-5">
                    <x-tertiary-button>
                        Cancelar
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" class="ms-3"
                            viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="m12 13.4l2.9 2.9q.275.275.7.275t.7-.275t.275-.7t-.275-.7L13.4 12l2.9-2.9q.275-.275.275-.7t-.275-.7t-.7-.275t-.7.275L12 10.6L9.1 7.7q-.275-.275-.7-.275t-.7.275t-.275.7t.275.7l2.9 2.9l-2.9 2.9q-.275.275-.275.7t.275.7t.7.275t.7-.275zm0 8.6q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22m0-2q3.35 0 5.675-2.325T20 12t-2.325-5.675T12 4T6.325 6.325T4 12t2.325 5.675T12 20m0-8" />
                        </svg>
                    </x-tertiary-button>

                    <x-secondary-button type="submit">
                        Guardar cambios
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" class="ms-3"
                            viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="M3.548 20.938h16.9a.5.5 0 0 0 0-1h-16.9a.5.5 0 0 0 0 1M9.71 17.18a2.6 2.6 0 0 0 1.12-.65l9.54-9.54a1.75 1.75 0 0 0 0-2.47l-.94-.93a1.79 1.79 0 0 0-2.47 0l-9.54 9.53a2.5 2.5 0 0 0-.64 1.12L6.04 17a.74.74 0 0 0 .19.72a.77.77 0 0 0 .53.22Zm.41-1.36a1.47 1.47 0 0 1-.67.39l-.97.26l-1-1l.26-.97a1.5 1.5 0 0 1 .39-.67l.38-.37l1.99 1.99Zm1.09-1.08l-1.99-1.99l6.73-6.73l1.99 1.99Zm8.45-8.45L18.65 7.3l-1.99-1.99l1.01-1.02a.75.75 0 0 1 1.06 0l.93.94a.754.754 0 0 1 0 1.06" />
                        </svg>
                    </x-secondary-button>
                </div>
            </form>
        </div>
    </div>

    @vite('resources/js/update-user.js')

</x-app-layout>
