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
     */
    public function verify(Request $request)
    {
        $user = User::find($request->route('id'));

        if ($user->markEmailAsVerified())
            event(new Verified($user));

        if ($user->hasVerifiedEmail()) {

            Auth::login($user);

            Mail::to('eli_gimenez@outlook.com')->send(new Welcome($request));

            return redirect($this->redirectPath())->with('verified', true)->with('toast_success', 'Su cuenta ha sido verificada');
        }

        return redirect()->to('login')->with('toast_error', 'Ha ocurrido un problema con la verificacion.');
    }







}
