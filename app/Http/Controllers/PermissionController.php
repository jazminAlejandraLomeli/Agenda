<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Services\PermissionsTranslatorService;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{

    public function __construct(protected PermissionsTranslatorService $permissionsTranslator)
    {
        
    }

    public function getPermissionByRole($role, $group = null)
    {

        $validated = Validator::make(
            ['role' => $role, 'group' => $group],
            [
                'role' => 'required|exists:roles,id',
                'group' => 'nullable|required_if:role,2|exists:groups,id'
            ],
            [
                'role.required' => 'El role es requerido',
                'role.exists' => 'El rol no existe',
                'group.required_if' => 'El grupo es requerido si el rol es admin',
                'group.exists' => 'El grupo no existe'

            ]
        );

        if ($validated->fails()) {
            Log::error('Error en la validación de los datos para obtener los permisos');
            return response()->json([
                'title' => 'Oops...!',
                'msg' => 'Ha ocurrido un error',
                'error' => $validated->errors()
            ]);
        }

        try {

            $roleBD = Role::find($role);

            if ($roleBD->name == 'superadmin') {
                $permissions = Permission::whereNot('name','delete user')->select('id', 'name')->orderBy('name', 'asc')->get();

                $permissionsConverted = $this->permissionsTranslator->translateNamePermission($permissions);

                return response()->json([
                    'title' => 'Éxito',
                    'permissions' => $permissionsConverted
                ]);
            }

            // Initialize the array with permissions by group
            $permissionsData = [
                'Protocolo' => [
                    'create event',
                    'create event type',
                    'create dependency',
                    'create place',
                    'update event type',
                    'update dependency',
                    'update place',
                    'update event',
                    'view event type',
                    'view dependency',
                    'view place',
                ],
                'CTA' => [
                    'reserve classroom',
                    'create event type',
                    'create dependency',
                    'create place',
                    'update reserve classroom',
                    'delete reserve classroom',
                    'update event type',
                    'update dependency',
                    'update place',
                    'view event type',
                    'view dependency',
                    'view place',
                    'approve reserve'
                ]
            ];

            $groupBD = Group::find($group);

            if ($groupBD->type !== 'Superadmin') {

                $permissions = Permission::whereIn('name', $permissionsData[$groupBD->type])->select('id', 'name')->orderBy('name', 'asc')->get();
                $permissionsConverted = $this->permissionsTranslator->translateNamePermission($permissions);


                return response()->json([
                    'title' => 'Éxito',
                    'permissions' => $permissionsConverted
                ]);
            }

            return response()->json([
                'title' => 'Éxito',
                'permissions' => []
            ]);
        } catch (Exception $e) {
            Log::error('Error al obtener los permisos que estan ligados del role -' . $e . '-');
            return response()->json([
                'title' => 'Ops..!',
                'message' => 'Ha ocurrido un error al obtener los permisos ligados al role, por favor intente de nuevo.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
