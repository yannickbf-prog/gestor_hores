<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App;
use App\Http\Requests\CreateCustomerRequest;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $lang = setGetLang();
        
        return view('auth.register', compact('lang'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request,$lang)
    {
        
        
        
        
        App::setLocale($lang);
        
        $request->validate([
            'nickname' => 'required|unique:users|max:20',
            'name' => 'required|string|max:50',
            'surname' => 'required|string|max:100',
            'email' => 'required|string|email|max:50|unique:users',
            'phone' => 'unique:users|numeric||min:100000000||max:100000000000000|nullable',
            'description' => 'max:400',
            'password' => 'required|string|min:8',
            'role' => 'required'
        ]);

        $user = User::create([
            'nickname' => $request->nickname,
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        event(new Registered($user));

        //Auth::login($user);

        return redirect(route($lang.'_users.index'))
                ->with('success', __('message.user')." ".$request->nickname." ".__('message.created') ); 
    }
}
