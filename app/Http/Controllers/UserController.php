<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\EditUserRequest;

class UserController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $lang = setGetLang();

        if ($request->has('_token')) {
            ($request['username'] == "") ? session(['user_username' => '%']) : session(['user_username' => $request['username']]);
            ($request['name'] == "") ? session(['user_name' => '%']) : session(['user_name' => $request['name']]);
            ($request['surname'] == "") ? session(['user_surname' => '%']) : session(['user_surname' => $request['surname']]);
            ($request['email'] == "") ? session(['user_email' => '%']) : session(['user_email' => $request['email']]);
            ($request['phone'] == "") ? session(['user_phone' => '%']) : session(['user_phone' => $request['phone']]);

            session(['user_role' => $request['role']]);
            session(['user_order' => $request['order']]);
            session(['user_num_records' => $request['num_records']]);
        }

        $dates = getIntervalDates($request, 'user');
        $date_from = $dates[0];
        $date_to = $dates[1];

        $username = session('user_username', "%");
        $name = session('user_name', "%");
        $surname = session('user_surname', "%");
        $email = session('user_email', "%");
        $phone = session('user_phone', "%");
        $role = session('user_role', "%");
        $order = session('user_order', "desc");
        $num_records = session('customer_num_records', 10);
        
        if ($role == "all") {
            $role = "%";
        }
        
        if($num_records == 'all'){
            $num_records = User::count();
        }

        $data = User::where('nickname', 'like', "%" . $username . "%")
                ->where('name', 'like', "%" . $name . "%")
                ->where('surname', 'like', "%" . $surname . "%")
                ->where('email', 'like', "%" . $email . "%")
                ->where('phone', 'like', "%" . $phone . "%")
                ->where('role', 'like', "%" . $role . "%")
                ->whereBetween('created_at', [$date_from, $date_to])
                ->orderBy('created_at', $order)
                ->paginate($num_records);

        return view('users.index', compact(['lang', 'data']))
                        ->with('i', (request()->input('page', 1) - 1) * $num_records);
    }
    
    public function deleteFilters(Request $request) {
        
        session(['user_username' => '%']);
        session(['user_name' => '%']);
        session(['user_surname' => '%']);
        session(['user_email' => '%']);
        session(['user_phone' => '%']);
        session(['user_role' => '%']);
        session(['user_date_from' => ""]);
        session(['user_date_to' => ""]);
        session(['user_order' => 'asc']);
        session(['user_num_records' => 10]);
        
        $lang = $request->lang;

        return redirect()->route($lang.'_users.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user) {
        $lang = setGetLang();
        
        return view('users.edit', compact('user'), compact('lang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(EditUserRequest $request, User $user, $lang) {
        
        $user->update($request->validated());
        
        return redirect()->route($lang.'_users.index')
                        ->with('success', __('message.user')." ".$request->name." ".__('message.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user) {
        //
    }

}
