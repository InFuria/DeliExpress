<?php namespace App\Http\Controllers\General;

use App\Mail\Welcome;
use App\Permission;
use App\ProductCategory;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Role;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

/**
 * Class UserController
 * Manage all the users of the system like Admin or other intern general
 * @package App\Http\Controllers\General
 */
class UserController extends Controller {

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
            if (! $this->user->hasPermissionTo('users.index')){
                return redirect()->back()->with('toast_error', 'No posee permisos suficientes para acceder a esta seccion.');
            }

            if (request()->ajax())
            {
                if ($search = request()->search){

                    $users = User::where('name', 'LIKE', $search . '%')->orWhere('username', 'LIKE', $search . '%')
                        ->with('role')->get()->toArray();

                    return response()->json(['users' => $users]);

                } else {

                    $users = User::with('role')->orderBy('users.updated_at', 'desc')->get();

                    return response()->json(['users' => $users]);
                }
            }

            $roles = Role::select('id', 'name')->where('slug', '!=', 'store')->get();
            $permissions = Permission::select('id', 'name')->get();
            $users = User::with('role')->orderBy('users.updated_at', 'desc')->get();

            return view('general.users.index', compact('users', 'roles', 'permissions'));

        } catch (\Exception $e) {
            \Log::error('General\UserController::index - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return redirect()->back()->with('toast_error', 'Ha ocurrido un error al cargar la pagina');
        }
    }

    public function store(UserRequest $request)
    {
        try {
            if (! $this->user->hasPermissionTo('users.store')){
                return redirect()->back()->with('toast_error', 'No posee permisos suficientes para acceder a esta seccion.');
            }

            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'phone' => $request->phone,
                'photo' => '',
                'status' => $request->status,
                'is_store' => false,
                'role_id' => $request->role,
                'email' => $request->email,
                'password' => ''
            ]);

            if ($request->hasFile('photo')) {
                $file = $request->photo;

                if ($file->isValid()) {
                    $name = time() . str_random(5) . '.' . $file->getClientOriginalExtension();
                    Storage::disk('public')->putFileAs('/users/', $file, $name);

                    $user->photo = $name;
                    $user->save();
                }
            }

            if (isset($request->permissions))
                $user->permissions()->sync($request->permissions);

            $user->sendEmailVerificationNotification();

            return redirect()->route('users.index')->with('toast_success', 'Se ha registrado un nuevo usuario!');

        } catch (\Exception $e) {
            \Log::error('General\UserController::store - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return redirect()->back()->with('toast_error', 'Ha ocurrido un error al procesar los datos');
        }
    }

    public function show($user)
    {
        try {
            if (! $this->user->hasPermissionTo('users.show')){
                return redirect()->back()->with('toast_error', 'No posee permisos suficientes para acceder a esta seccion.');
            }

            $user = User::where('id', $user)->with('role', 'permissions')->first();

            return response()->json(['user' => $user]);

        } catch (\Exception $e) {
            \Log::error('General\UserController::show - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return response()->json(["message" => "Ha ocurrido un error al buscar al usuario"], 404);
        }
    }

    public function update(UserRequest $request, User $user)
    {
        try {
            if (! $this->user->hasPermissionTo('users.update')){
                return redirect()->back()->with('toast_error', 'No posee permisos suficientes para acceder a esta seccion.');
            }

            $previous = app('router')->getRoutes()->match(app('request')->create(url()->previous()))->getName();
            if ($previous == "users.profile")
                $request->role = $user->role_id;

            $user->update([
                'name' => $request->name,
                'username' => $request->username,
                'status' => $request->status,
                'phone' => $request->phone,
                'role_id' => $request->role,
                'email' => $request->email
            ]);

            if ($request->hasFile('photo')) {
                $file = $request->photo;

                if ($file->isValid()) {
                    $name = time() . str_random(5) . '.' . $file->getClientOriginalExtension();
                    Storage::disk('public')->putFileAs('/users/', $file, $name);

                    Storage::disk('public')->delete('/users/' . $user->photo);

                    $user->photo = $name;
                    $user->save();
                }
            }

            if ($request->permissions && $previous != "users.profile")
                $user->permissions()->sync($request->permissions);

            return redirect()->route('users.index')->with('toast_success', "Se ha actualizado al usuario {$user->username}!");

        } catch (\Exception $e) {
            \Log::error('General\UserController::update - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return redirect()->back()->with('toast_error', 'Ha ocurrido un error al actualizar los datos');
        }
    }

    public function destroy(User $user)
    {
        try {
            if (! $this->user->hasPermissionTo('users.destroy')){
                return redirect()->back()->with('toast_error', 'No posee permisos suficientes para acceder a esta seccion.');
            }

            $user->permissions()->sync([]);
            $user->roles()->sync([]);
            $user->delete();

            return response()->json(['message' => "Se ha eliminado al usuario!"]);

        } catch (\Exception $e) {
            \Log::error('General\UserController::destroy - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return response()->json(["message" => "Ha ocurrido un error al eliminar al usuario"], 404);
        }
    }

    public function profile()
    {
        try {

            $user = $this->user;
            $roles = Role::select('id', 'name')->get();
            $permissions = Permission::select('id', 'name')->get();

            switch ($user->role->slug) {
                case 'delivery':
                    return view('general.users.profiles.delivery', compact('user', 'roles', 'permissions'));
                break;

                case 'store':
                    return view('general.users.profiles.store', compact('user', 'roles', 'permissions'));
                break;

                default;
                    return view('general.users.profiles.basic', compact('user', 'roles', 'permissions'));
                break;
            }

        } catch (\Exception $e) {
            \Log::error('General\UserController::profile - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return redirect()->back()->with('toast_error', 'Ha ocurrido un error al cargar la pagina');
        }
    }
}
