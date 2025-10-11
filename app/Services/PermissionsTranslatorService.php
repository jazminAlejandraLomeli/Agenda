<?php 
namespace App\Services;
class PermissionsTranslatorService
{

    protected $permissionsName = [
        'reserve classroom|create event' => 'Crear un evento y reservar una aula',
        'create event' => 'Crear evento',
        'update event' => 'Actualizar evento',
        'update reserve classroom' => 'Actualizar reservación de aula',
        'delete event' => 'Eliminar evento',
        'delete reserve classroom' => 'Eliminar una reservación de aula',
        'reserve classroom' => 'Reservar una aula',
        'view event type' => 'Acceder a la intefaz tipos de eventos',
        'view dependency' => 'Acceder a la intefaz dependencias',
        'view place' => 'Acceder a la interfaz de lugares',
        'view user' => 'Acceder a la intefaz de usuarios',
        'create event type' => 'Crear un tipo de evento',
        'create dependency' => 'Crear una dependencia',
        'create place' => 'Crear un lugar',
        'update event type' => 'Actualizar tipo de evento',
        'update dependency' => 'Actualizar dependencia',
        'update place' => 'Actualizar lugar',
        'create user' => 'Crear usuario',
        'reset password' => 'Resetear la contraseña',
        'update user' => 'Actualizar usuario',
        'delete user' => 'Eliminar usuario',
        'approve reserve' => 'Aprobar reserva',
    ];

    public function translateNamePermission($permissions){

        $permissionsConverted = $permissions->map(function($permission){
    
            return (object)[
                'id'=> $permission->id,
                'name' => isset($this->permissionsName[$permission->name]) ? $this->permissionsName[$permission->name] : 'Permiso desconocido'
            ];
        });

        return $permissionsConverted;
    }
}