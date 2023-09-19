<?php

namespace App\Http\Controllers\Auth;

// use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function __construct(){
        $this->middleware('guest');
    }

    public function index(){
        return view('auth.forgot-password');
    }

    public function forgotPassword(Request $request){
        $validated = $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($validated);

        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => alert(__($status))])
                    : back()->withErrors(['email' => __($status)]);
    }
}
