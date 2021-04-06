<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\Welcome;
use App\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect general after verification.
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
        //$this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * Mark the authenticated user's email address as verified.
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function verify(Request $request)
    {
        try {
            $user = User::find($request->route('id'));

            if ($user->markEmailAsVerified())
                event(new Verified($user));

            if ($user->hasVerifiedEmail()) {

                Auth::login($user);

                if (isset($user->password) && $user->password != "")
                {
                    Mail::to($user->email)->send(new Welcome($request));
                    return redirect($this->redirectPath())->with('verified', true)->with('toast_success', 'Su cuenta ha sido verificada');
                }

                Auth::logout();

                // Se redirecciona al usuario a que ingrese su nueva contraseña
                return ResetPasswordController::showFormToAssignPassword($user, 'Su cuenta ha sido verificada. Por favor defina una contraseña.');
            }

        } catch (\Exception $e) {
            \Log::error('VerificationController::verify - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return redirect()->back()->with('toast_error', 'Ha ocurrido un problema con la verificacion.');
        }
    }







}
