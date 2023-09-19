<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    public function __construct(){
        $this->middleware('guest');
    }

    public function index(Request $request){
        return view('auth.reset-password', [
            'token' => $request->token ?? '',
            'email' => $request->email ?? ''
        ]);
    }

    public function resetPassword(Request $request){
        $validated = $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => password_rules(),
            'password_confirmation' => password_confirmation_rules()
        ]);

        $status = Password::reset(
            $validated,
            function ($user, $password) {
                $user->forceFill([
                    'password' => $password
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status',alert(__($status)))
                    : back()->withErrors(['email' => [__($status)]]);
    }
}
