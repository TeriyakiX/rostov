<?php

namespace App\Http\Controllers\Client;

use App\Mail\PassUpdateMail;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
class DashboardController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        return view('client.dashboard.index')->with(['user' => $user]);
    }


    public function passupdate(Request $request)
    {
        /** @var User $user */

        $user = auth()->user();
        $credentials = [
            'email' => $user->email,
            'password' => $request['old_pass'],
        ];

        if (Auth::attempt($credentials,false,false)) {

            $user->password = bcrypt($request['new_pass']);
            $user->save();
            Mail::to($user->email)->send(new PassUpdateMail($user->email));
            return redirect()->route('client.dashboard.index');
        }

        return redirect()->route('client.dashboard.index')->with('error_oldpass',true);
    }

    public function update(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();
        $user->update($request->all());

        return redirect()->route('client.dashboard.index');
    }

    public function orders(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();

        $orders = $user->orders()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        //dd($orders);

        return view('client.dashboard.orders')->with(compact('orders'));
    }
}
