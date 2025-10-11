<h5 class="flex items-center gap-2 text-gray-600 dark:text-white font-normal text-xl px-4">

    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path fill="#65a30d" d="M10.5 16.3q-.2 0-.35-.137T10 15.8V8.2q0-.225.15-.362t.35-.138q.05 0 .35.15l3.625 3.625q.125.125.175.25t.05.275t-.05.275t-.175.25L10.85 16.15q-.075.075-.162.113t-.188.037"/></svg>

    Eventos del día

    <b class="hidden sm:block"> {{ \Carbon\Carbon::now()->translatedFormat('l d \d\e F \d\e Y') }}</b>

</h5>


<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 xl:grid-cols-4 gap-4 px-3  my-3">



    <div class="relative max-w-sm p-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden group min-h-30">
        <!-- SVG flotante -->
        <svg class="absolute -top-3 -right-4 w-16 h-16 text-orange-500 opacity-30" xmlns="http://www.w3.org/2000/svg"
            width="25" height="25" viewBox="0 0 24 24">
            <path fill="#cc5500"
                d="M12.004 11.73q.667 0 1.14-.475t.472-1.143t-.476-1.14t-1.143-.472t-1.14.476t-.472 1.143t.475 1.14t1.144.472M12 19.677q2.82-2.454 4.458-4.991t1.638-4.39q0-2.744-1.737-4.53Q14.62 3.981 12 3.981T7.641 5.766t-1.737 4.53q0 1.852 1.638 4.39T12 19.677m0 1.342q-3.525-3.117-5.31-5.814q-1.786-2.697-1.786-4.909q0-3.173 2.066-5.234Q9.037 3 12 3t5.03 2.062q2.066 2.061 2.066 5.234q0 2.212-1.785 4.909q-1.786 2.697-5.311 5.814m0-10.903" />
        </svg>

        <div class="flex justify-between items-center mb-4">
            <h5 class="text-gray-700 dark:text-white font-semibold text-lg tracking-tight">
                Núm. de lugares
            </h5>

        </div>

        <div class="text-center">
            <h2
                class="text-4xl font-bold text-orange-500 dark:text-orange-400 transition-transform group-hover:scale-105">
                {{ $places_count }}
            </h2>
            <p class="mt-1 text-gray-400 dark:text-gray-300 text-sm">Registrados</p>
        </div>
    </div>

    <!-- Tarjeta 2 -->
    <div class="relative max-w-sm p-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden group min-h-30">
        <!-- SVG flotante -->
        <svg class="absolute -top-3 -right-4 w-16 h-16 text-[#1E93AB] opacity-30" xmlns="http://www.w3.org/2000/svg"
            width="25" height="25" viewBox="0 0 512 512">
            <path
                d="M255.988 32C132.285 32 32 132.298 32 256c0 123.715 100.285 224 223.988 224C379.703 480 480 379.715 480 256c0-123.702-100.297-224-224.012-224zm135.773 359.765a193.666 193.666 0 0 1-32.886 26.42l-15.946-27.62-13.856 8 15.955 27.636c-24.838 13.03-52.372 20.455-81.027 21.624V416h-16v31.825c-28.656-1.166-56.191-8.59-81.03-21.62l15.958-27.641-13.856-8-15.949 27.625a193.574 193.574 0 0 1-32.889-26.424 193.571 193.571 0 0 1-26.422-32.889l27.624-15.949-8-13.855-27.641 15.958c-13.03-24.839-20.454-52.374-21.621-81.03H96v-16H64.175c1.167-28.655 8.592-56.19 21.623-81.029l27.638 15.958 8-13.856-27.623-15.948a193.662 193.662 0 0 1 26.419-32.885 193.632 193.632 0 0 1 32.89-26.426l15.949 27.624 13.856-8-15.958-27.64C191.81 72.765 219.345 65.34 248 64.175V96h16V64.176c28.654 1.169 56.188 8.595 81.026 21.626l-15.954 27.634 13.856 8 15.945-27.618a193.672 193.672 0 0 1 32.886 26.421 193.609 193.609 0 0 1 26.424 32.887l-27.619 15.946 8 13.856 27.636-15.956c13.031 24.839 20.457 52.373 21.624 81.027H416v16h31.824c-1.167 28.655-8.592 56.189-21.622 81.028l-27.637-15.957-8 13.856 27.621 15.947a193.57 193.57 0 0 1-26.425 32.892z"
                fill="#1E93AB" />
            <path
                d="M400 241H284.268A32.136 32.136 0 0 0 272 228.292V160h-32v68.292c-9.562 5.534-16 15.866-16 27.708 0 17.673 14.327 32 32 32 11.425 0 21.444-5.992 27.106-15H400v-32z"
                fill="#1E93AB" />
        </svg>

        <div class="flex justify-between items-center mb-4">
            <h5 class="text-gray-700 dark:text-white font-semibold text-lg tracking-tight">
                Eventos de Hoy
            </h5>

        </div>

        <div class="text-center">
            <h2
                class="text-4xl font-bold text-[#1E93AB] dark:text-orange-400 transition-transform group-hover:scale-105">
                {{ $today_events }}
            </h2>
            <p class="mt-1 text-gray-400 dark:text-gray-300 text-sm">Registrados</p>
        </div>
    </div>


    <div class="col-span-2 min-h-30">
        <div class="relative  p-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden group">

            <p class="absolute -top-3 -right-1 text-8xl text-[#0284c7] opacity-30">
                {{ $now_events['count'] }}
            </p>

            </p>

            <div class="flex justify-between items-center mb-2">
                <h5 class="text-gray-700 dark:text-white font-semibold text-lg tracking-tight">
                    Eventos en tiempo real
                </h5>
            </div>

            <div class="max-h-20 overflow-y-auto text-start">
                @if (!$now_events['places']->isEmpty())
                    <ul class="list-disc p-3">
                        @foreach ($now_events['places'] as $places)
                            <li class="text-gray-500"> {{ $places['name'] }}</li>
                        @endforeach
                    </ul>
                @else
                    <div class="d-flex items-center p-6">
                        <p class="text-center text-[#0284c7] text-xl"> Sin eventos en este momento

                        </p>
                    </div>
                @endif
            </div>
        </div>

    </div>



</div>
