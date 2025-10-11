<div class="md:ms-5 col-span-1 md:col-span-1">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <x-group-form class="cols-span-1">
            <x-slot name="label">Numero de participantes</x-slot>
            <x-input-primary type="number" name="num_participants"></x-input-primary>
        </x-group-form>

        <x-group-form class="cols-span-1">
            <x-slot name="label">Semestre</x-slot>
            <x-select-primary name="semester">
                <option value="" selected disabled>Seleccione una opción</option>
                @if (!$semesters->isEmpty())
                    @foreach ($semesters as $semester)
                        <option value="{{ $semester->id }}">{{ $semester->name }}</option>
                    @endforeach
                @endif
            </x-select-primary>
        </x-group-form>
    </div>

    <x-group-form>
        <x-slot name="label">Lugar</x-slot>
        <x-select-primary name="place" id="place">
            <option value="">Seleccione una opción</option>
            @if (!$places->isEmpty())
                @foreach ($places as $place)
                    <option value="{{ $place->id }}">{{ $place->name }}</option>
                @endforeach
            @endif
        </x-select-primary>
    </x-group-form>

    <div class="grid grid-cols-1 md:grid-cols-3 ">
        <div class="md:col-span-3 mb-3 dark:text-white" >
            <label class="text-lg font-bold">Fecha</label>
            <hr class="border-primary" />
        </div>
        <div class="col-span-3">
            <x-group-form>
                <x-slot name="label">Fecha de la reservación</x-slot>
                <x-input-primary type="text" placeholder="Selecciona una fecha" id="date-start" name="date_start"
                    class="cursor-pointer"></x-input-primary>
            </x-group-form>    
        </div>
    
    
        <div class="col-span-3 grid grid-cols-2 gap-3">
            <x-group-form class="col-span-1 ">
                <x-slot name="label">Hora inicio (24/horas)</x-slot>
                <x-input-primary type="time" id="hour-start" name="hour_start" value="{{ $manageHour->currentHour }}" />
            </x-group-form>
        
            <x-group-form class="col-span-1">
                <x-slot name="label">Hora fin (24/horas)</x-slot>
                <x-input-primary type="time" name="hour_end" id="hour-end" value="{{ $manageHour->hourLater }}" />
            </x-group-form>
        </div>
    
    </div>
    
            
</div>