<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\UserResetPassword;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetpassMail;

class LoginController extends Controller
{
    /**
     * Show login form.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function loginForm(Request $request)
    {
        return view('auth.login');
    }
    public function forgotForm()
    {
        return view('auth.forgot');
    }

    public function forgot(Request $request)
    {

        $data = $request->validate([
           'email' => ['required'],
        ]);

        if($user = User::where('email',$data['email'])->first()){
            $reset_pass = new UserResetPassword();
            $reset_pass->code = bcrypt(Carbon::now());
            $reset_pass->user_id = $user->id;
            $reset_pass->save();
            
            Mail::to($data['email'])->send(new ResetpassMail($reset_pass->code));
        }
        return redirect()->route('auth.login')->with('forgot_success',true);
    }

    public function resetPassForm(Request $request)
    {

        if($reset_pass = UserResetPassword::where('code',$request->get('code'))->first()){
            $data['code'] = $request->get('code');
            return view('auth.reset',$data);
        }
        return redirect()->route('auth.login')->with('error_code',true);
    }

    public function resetPass(Request $request)
    {


        $data = $request->validate([
            'password' => ['required'],
        ]);

        if($reset_pass = UserResetPassword::where('code',$request['code'])->first()){
            $user = User::find($reset_pass->user_id);
            $user->password = bcrypt($data['password']);
            $user->save();
            return redirect()->route('auth.login')->with('reset_success',true);
        }
        return redirect()->route('auth.login');
    }
    /**
     * Handle an authentication attempt.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, true)) {
            $request->session()->regenerate();

            /** @var User $authUser */
            $authUser = auth()->user();

            if($authUser->hasRole('admin')) {
                return redirect()->route('admin.dashboard.index');
            } elseif($authUser->hasRole('client')) {
                return redirect()->route('client.dashboard.index');
            } else {
                return redirect()->route('index.home');
            }
        }

        return redirect()
            ->back()
            ->withInput([
                'email' => $request->email
            ])->withErrors([
                'email' => __('auth.failed')
            ]);
    }

    /**
     * Handle logout action.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }


    /**
     * Handle logout action.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
