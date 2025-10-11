@props(['date','hourstart','hourend'])

<div class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-3">
    <div class="md:col-span-3 mb-3 " >
        <label class="text-lg font-bold dark:text-white">Fecha</label>
        <hr class="border-primary" />
    </div>

    <div class="col-span-1 md:col-span-3">
        
        <x-group-form>
            <x-slot name="label">Fecha del evento</x-slot>
            <x-input-primary type="text" placeholder="Selecciona una fecha" id="date-start" name="date_start"
                class="cursor-pointer" value="{{ $date }}"></x-input-primary>
        </x-group-form>        
    </div>

    <div class="col-span-3 grid grid-cols-2 gap-3">
        <x-group-form class="col-span-1">
            <x-slot name="label">Hora inicio</x-slot>
            <x-input-primary type="time" id="hour-start" name="hour_start"
                value="{{ $hourstart }}" />
        </x-group-form>

        <x-group-form class="col-span-1">
            <x-slot name="label">Hora fin</x-slot>
            <x-input-primary type="time" name="hour_end" id="hour-end" value="{{ $hourend }}" />
        </x-group-form>

    </div>

</div>