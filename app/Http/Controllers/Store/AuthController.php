<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Role;
use App\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:store')->except('logout');
    }

    public function showFormRegister ()
    {
        try{
            return view('stores.auth.register');

        } catch (\Exception $e){
            \Log::error('Store\AuthController::showFormRegister - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return redirect()->back()->with('error', 'Ha ocurrido un error al cargar la pagina');
        }
    }

    public function register (Request $request)
    {
        try{

            $user =  Store::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return redirect()->route('stores.login')->with('message', 'Se ha creado correctamente el usuario');

        } catch (\Exception $e){
            \Log::error('Store\AuthController::register - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return redirect()->back()->with('error', 'Ha ocurrido un error al procesar los datos');
        }
    }


    public function showFormLogin ()
    {
        try{
            return view('stores.auth.login');

        } catch (\Exception $e){
            \Log::error('Store\AuthController::showFormLogin - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return redirect()->back()->with('error', 'Ha ocurrido un error al cargar la pagina');
        }
    }

    public function login (Request $request)
    {
        try{

            $email = $request->input('email');
            $password = $request->input('password');

            $dataAttempt = array(
                'email' => Input::get('email'),
                'password' => Input::get('password')
            );

            if (auth()->guard('store')->attempt(['email' => $email, 'password' => $password], true))
            {
                dd('holis');
                return redirect()->route('stores.dashboard')->with('success', 'Bienvenido/a!');
            }
            else
            {
                return redirect()->route('stores.login')->with('error', 'Credenciales no validas.')->withInput();
            }

        } catch (\Exception $e){
            \Log::error('Store\AuthController::login - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return redirect()->back()->with('error', 'Ha ocurrido un error al procesar los datos');
        }
    }

    public function logout ()
    {
        auth()->guard('store')->logout();

        return redirect()->route('stores.login')->with('message', 'Cerrar sesión con éxito !');
    }
}
