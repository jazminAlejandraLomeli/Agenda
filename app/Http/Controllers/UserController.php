<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Group;
use App\Models\User;
use App\Services\PermissionsTranslatorService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function __construct(protected PermissionsTranslatorService $permissionsTranslator)
    {
        
    }

    public function index()
    {
        return view('users.users');
    }


    public function getUsers(Request $request)
    {

        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 10);
        $search = $request->input('search');

        try {

            $query = User::with(['group', 'roles'])
                ->where('status', 1)
                ->whereNot('user_name','Super')
                ->whereNot('user_name','juan.dominguez');

            if (!empty($search)) {
                $query->where('name', 'like', '%' . $search . '%');
                $query->orWhere('user_name', 'like', '%' . $search . '%');
            }

            $total = $query->count();

            $users = $query
                ->offset($offset)
                ->limit($limit)
                ->orderBy('name', 'asc')
                ->get();

            return response()->json([
                'total' => $total,
                'data' => $users
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'title' => 'Ops..!',
                'message' => 'Ha ocurrido un error al obtener los usuarios, por favor intente de nuevo.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function create()
    {

        $groups = Group::all();
        $roles = Role::all();
        $defaultPassword = env('DEFAULT_PASSWORD','Cualtos2024');

        return view('users.create-user', compact('groups', 'roles', 'defaultPassword'));
    }

    public function store(CreateUserRequest $request)
    {

        $validated = $request->validated();

        try {
            // throw new Exception('Error al crear el usuario');


            DB::transaction(function () use ($validated) {
                $role = Role::findById($validated['role']);
                $permissions = Permission::whereIn('id',$validated['permissions'])->get();

                $user = User::create([
                    'name' => $validated['name'],
                    'user_name' => $validated['user_name'],
                    'password' => bcrypt($_ENV['DEFAULT_PASSWORD']),
                    'group_id' => $validated['group'],
                ]);
                $user->assignRole($role);
                $user->givePermissionTo($permissions);
            });

            return redirect()->route('users.index')->with('success', 'Usuario creado correctamente.');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Ha ocurrido un error al crear el usuario, por favor intente de nuevo.');
        }
    }

    public function edit($id)
    {

        $user = User::with(['roles'])->findOrFail($id);
        $groups = Group::all();
        $roles = Role::all();
        
        $userPermissions = $user->getAllPermissions();
        $userPermissions = $this->permissionsTranslator->translateNamePermission($userPermissions);

        
        return view('users.update-user', compact('user', 'groups', 'roles','userPermissions'));
    }

    public function update(UpdateUserRequest $request){

        $validated = $request->validated();
        
        try{

            $user = User::findOrFail($request->id);
            $role = Role::findById($validated['role']);
            $permissions = Permission::whereIn('id',$validated['permissions'])->get();
            $user->group_id = $validated['group'];
            $user->save();
            $user->syncRoles($role);
            $user->syncPermissions($permissions);

            return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente.');


        }catch(Exception $e){
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Ha ocurrido un error al actualizar el usuario, por favor intente de nuevo.');
        }
        
    }


    public function resetPassword($id)
    {

        try {
            $a = $_ENV['DEFAULT_PASSWORD'];
            $user = User::findOrFail($id);
            $user->password = bcrypt($_ENV['DEFAULT_PASSWORD']);
            $user->save();

            return response()->noContent();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'title' => 'Ops..!',
                'message' => 'Ha ocurrido un error al resetear la contraseña del usuario, por favor intente de nuevo.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);

        try {
            if ($user->id == auth()->user()->id) {
                return response()->json([
                    'title' => 'Ops..!',
                    'message' => 'No puedes eliminar tu propio usuario.',
                ], 403);
            }

            DB::beginTransaction();
            $user->syncRoles([]);
            $user->syncPermissions([]);
            $user->update([
                'status' => 0
            ]);

            DB::commit();
                        
            return response()->noContent();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return response()->json([
                'title' => 'Ops..!',
                'message' => 'Ha ocurrido un error al eliminar el usuario, por favor intente de nuevo.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
