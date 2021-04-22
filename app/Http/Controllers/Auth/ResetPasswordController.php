<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\Welcome;
use App\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect general after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get the password reset validation error messages.
     *
     * @return array
     */
    protected function validationErrorMessages()
    {
        return [
            'token.required' => 'Error de validacion. Contacte a Soporte',
            'email.required'    => 'El campo email es obligatorio.',
            'email.email'    => 'El formato de email no es valido.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min'      => 'La contraseña debe tener como minimo 6 caracteres.'
        ];
    }

    /**
     * Get the response for a successful password reset.
     * @param Request $request
     * @param $response
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function sendResetResponse(Request $request, $response)
    {
        return redirect($this->redirectPath())
            ->with('toast_success', 'Se ha actualizado su contraseña.');
    }

    /**
     * Get the response for a failed password reset.
     * @param Request $request
     * @param $response
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendResetFailedResponse(Request $request, $response)
    {
        return redirect()->back()
            ->withInput($request->only('email'))
            ->with('toast_error', 'Ocurrio un error al actualizar su contraseña.');
    }

    /**
     * @param $user
     * @param $message
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public static function showFormToAssignPassword($user, $message)
    {
        return view('auth.passwords.assign', ['id' => $user->id])->with('toast_success', $message);
    }

    protected function assignPassword(Request $request, User $user)
    {
        try {

            if (isset($user->password) && $user->password == ''){

                $request->validate(
                    [
                        'password' => 'required|confirmed|min:6'
                    ],
                    [
                        'password.required'  => 'La contraseña es obligatoria',
                        'password.confirmed' => 'Las contraseñas no coinciden.',
                        'password.min'       => 'La contraseña debe tener como minimo 6 caracteres.'
                    ]
                );

                $user->password = Hash::make($request->password);
                $user->setRememberToken(Str::random(60));
                $user->save();

                $this->guard()->login($user);

                Mail::to($user->email)->send(new Welcome($request));

                return redirect()->to('/')->with('toast_success', 'Bienvenido! Se ha actualizado su contraseña.');

            } else {

                return redirect()->back()->with('toast_error', 'El usuario ya cuenta con una contraseña asignada');
            }

        } catch (\Exception $e) {
            \Log::error('ResetPasswordController::assignPassword - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return response()->json(["message" => "Ha ocurrido un error al procesar la asignacion de contraseña."], 404);
        }
    }
}
