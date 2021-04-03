<?php namespace App\Http\Controllers\General;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Role;
use App\User;

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
            /*if (! $this->user->hasAnyRole(['admin', 'manager'])){
                return redirect()->back()->with('No posee permisos suficientes para acceder a esta seccion.');
            }*/

            $users = User::with('roles')->get()->sortBy('roles.id', SORT_REGULAR);

            return view('general.users.index', compact('users'));

        } catch (\Exception $e) {
            \Log::error('General\UserController::index - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return redirect()->back()->with('error', 'Ha ocurrido un error al cargar la pagina');
        }
    }


    public function create()
    {
        try {
            /*if (! $this->user->hasAnyRole(['admin', 'manager'])){
                return redirect()->back()->with('No posee permisos suficientes para acceder a esta seccion.');
            }*/

            $roles = Role::pluck('name', 'id');

            return view('users.create', compact('roles'));

        } catch (\Exception $e) {
            \Log::error('General\UserController::create - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return redirect()->back()->with('error', 'Ha ocurrido un error al cargar la pagina');
        }
    }


    public function store(UserRequest $request)
    {
        try {


        } catch (\Exception $e) {
            \Log::error('General\UserController::store - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return redirect()->back()->with('error', 'Ha ocurrido un error al procesar los datos');
        }
    }

    public function show(User $user)
    {
        try {


        } catch (\Exception $e) {
            \Log::error('General\UserController::show - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return redirect()->back()->with('error', 'Ha ocurrido un error al cargar la pagina');
        }
    }

    public function edit(User $user)
    {
        try {


        } catch (\Exception $e) {
            \Log::error('General\UserController::edit - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return redirect()->back()->with('error', 'Ha ocurrido un error al cargar la pagina');
        }
    }


    public function update(UserRequest $request)
    {
        try {


        } catch (\Exception $e) {
            \Log::error('General\UserController::update - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return redirect()->back()->with('error', 'Ha ocurrido un error al procesar los datos');
        }
    }


    public function profile(User $user)
    {
        try {


        } catch (\Exception $e) {
            \Log::error('General\UserController::profile - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return redirect()->back()->with('error', 'Ha ocurrido un error al cargar la pagina');
        }
    }
}
