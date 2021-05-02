<?php namespace App\Http\Controllers\General;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use Illuminate\Http\Request;
use App\Permission;
use App\Role;
use App\User;

class RoleController extends Controller
{
    protected $user;

    public function __construct(Request $request)
    {
        $this->middleware(function ($request, $next) {

            $this->user = Auth::user();

            return $next($request);
        });
    }

    public function index()
    {
        try {
            if (! $this->user->hasPermissionTo('roles.index')){
                return redirect()->back()->with('toast_error', 'No posee permisos suficientes para acceder a esta seccion.');
            }

            if (request()->ajax())
            {
                if ($search = request()->search){

                    $roles = Role::where('name', 'LIKE', $search . '%')->orWhere('slug', 'LIKE', $search . '%')
                        ->withCount('permissions')->get()->toArray();

                } else {

                    $roles = Role::withCount('permissions')->orderBy('roles.updated_at', 'desc')->get()->toArray();
                }

                return response()->json(['roles' => $roles]);
            }

            $roles = Role::select('id', 'name')->where('slug', '!=', 'store')->where('slug', '!=', 'delivery')
                ->orderBy('roles.updated_at', 'desc')->get();
            $permissions = Permission::select('id', 'name')->get();

            return view('general.roles.index', compact('roles', 'permissions'));

        } catch (\Exception $e) {
            \Log::error('General\RoleController::index - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return redirect()->back()->with('toast_error', 'Ha ocurrido un error al cargar la pagina');
        }
    }



    public function store(RoleRequest $request)
    {
        try {
            if (! $this->user->hasPermissionTo('roles.store')){
                return redirect()->back()->with('toast_error', 'No posee permisos suficientes para acceder a esta seccion.');
            }

            $role  = Role::create([
                'name' => $request->name,
                'slug' => $request->slug
            ]);

            if (isset($request->permissions) && $request->permissions[0] == 0){

                $permissions = Permission::pluck('id');
                $role->permissions()->sync($permissions);

            }elseif (isset($request->permissions)){

                $role->permissions()->sync($request->permissions);
            }

            return redirect()->route('roles.index')->with('toast_success', 'Se ha registrado un nuevo rol!');

        } catch (\Exception $e) {
            \Log::error('General\RoleController::store - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return redirect()->back()->with('toast_error', 'Ha ocurrido un error al procesar los datos');
        }
    }


    public function show($role)
    {
        try {
            if (! $this->user->hasPermissionTo('roles.show')){
                return response()->json(['message' => 'No posee permisos suficientes para usar esta funcionalidad.'], 403);
            }

            $role = Role::where('id', $role)->with('permissions')->withCount(['permissions', 'users'])->first();

            return response()->json(['role' => $role]);

        } catch (\Exception $e) {
            \Log::error('General\RoleController::show - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return response()->json(["message" => "Ha ocurrido un error al procesar los datos"], 404);
        }
    }


    public function update(RoleRequest $request, Role $role)
    {
        try {
            if (! $this->user->hasPermissionTo('roles.update')){
                return redirect()->back()->with('toast_error', 'No posee permisos suficientes para acceder a esta seccion.');
            }

            $role->name = $request->name;
            $role->slug = $request->slug;
            $role->save();

            if (isset($request->permissions))
                $role->permissions()->sync($request->permissions);

            return redirect()->route('roles.index')->with('toast_success', "Se ha actualizado el rol `$role->name`!");

        } catch (\Exception $e) {
            \Log::error('General\RoleController::update - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return redirect()->back()->with('toast_error', 'Ha ocurrido un error al actualizar el rol!');
        }
    }


    public function destroy(Role $role)
    {
        try {
            if (! $this->user->hasPermissionTo('roles.destroy')){
                return redirect()->back()->with('toast_error', 'No posee permisos suficientes para acceder a esta seccion.');
            }

            $name = $role->name;
            $new_role = Role::where('slug', 'not_assigned')->first()->id;

            $users = User::where('role_id', $role->id)->update(['role_id' => $new_role]);

            $role->permissions()->sync([]);
            $role->delete();

            return redirect()->route('roles.index')->with('toast_success', "Se ha eliminado el rol `$name`!");

        } catch (\Exception $e) {
            \Log::error('General\RoleController::update - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return redirect()->back()->with('toast_error', 'Ha ocurrido un error al eliminar el rol!');
        }
    }
}
