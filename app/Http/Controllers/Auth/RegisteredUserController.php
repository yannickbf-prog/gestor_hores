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
use App\Http\Requests\CreateUserRequest;

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
    public function store(CreateUserRequest $request,$lang)
    {
        
        App::setLocale($lang);
        
        $user = User::create($request->validated());

        event(new Registered($user));

        //Auth::login($user);

        return redirect(route($lang.'_users.index'))
                ->with('success', __('message.user')." ".$request->nickname." ".__('message.created') ); 
    }
}
