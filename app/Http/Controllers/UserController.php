<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function __construct()
    {
        // pengecakn auth
        $this->middleware('auth');
        // pengecekan hak akses
        $this->middleware(function ($request, $next) {
            if (Gate::allows('manage-users')) return $next($request);
            abort(403, 'Anda tidak memiliki cukup hak akses');
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $filterKeyword = $request->get('keyword');
        $status        = $request->get('status');
        if ($status) {
            $users = User::where('status', $status)->paginate(10);
        } else {
            $users = User::paginate(10);
        }
        if ($filterKeyword) {
            if ($status) {
                $users = User::where('email', 'LIKE', "%$filterKeyword%")->where('status', $status)->paginate(10);
            } else {
                $users = User::where('email', 'LIKE', "%$filterKeyword%")->paginate(10);
            }
        }
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'name' => 'required|min:5|max:100',
            'username' => 'required|min:5|max:20|unique:users',
            'roles' => 'required',
            'phone' => 'required|digits_between:10,15',
            'address' => 'required|min:20|max:200',
            'avatar' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ]);

        $user = new User;
        $user->name     = $request->get('name');
        $user->username = $request->get('username');
        $user->roles    = json_encode($request->get('roles'));
        $user->address  = $request->get('address');
        $user->phone    = $request->get('phone');
        $user->email    = $request->get('email');
        $user->password = \Hash::make($request->get('password'));
        if ($request->file('avatar')) {
            $file = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $file;
        }
        $user->save();
        return redirect()->route('users.create')->with('status', 'User successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validation = $request->validate([
            'name' => 'required|min:5|max:100',
            'status' => 'required',
            'roles' => 'required',
            'phone' => 'required|digits_between:10,15',
            'address' => 'required|min:20|max:200'
        ]);

        $user->name     = $request->get('name');
        $user->status   = $request->get('status');
        $user->roles    = json_encode($request->get('roles'));
        $user->address  = $request->get('address');
        $user->phone    = $request->get('phone');
        if ($request->file('avatar')) {
            if ($user->avatar && file_exists(storage_path('app/public/' . $user->avatar))) {
                \Storage::delete('public/' . $user->avatar);
            }
            $file = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $file;
        }
        $user->save();
        return redirect()->route('users.edit', [$user->id])->with('status', 'User successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->avatar && file_exists(storage_path('app/public/' . $user->avatar))) {
            \Storage::delete('public/' . $user->avatar);
        }
        $user->delete();
        return redirect()->route('users.index')->with('status', 'User successfully deleted');
    }

    public function setting()
    {
        $id = \Auth::user()->id;
        $user =  User::findOrFail($id);
        return view('users.setting', compact('user'));
    }

    public function updateSetting(Request $request)
    {
        $validation = $request->validate([
            'name' => 'required|min:5|max:100',
            'phone' => 'required|digits_between:10,15',
            'address' => 'required|min:20|max:200'
        ]);

        $id = \Auth::user()->id;
        $user =  User::findOrFail($id);

        $user->name     = $request->get('name');
        $user->address  = $request->get('address');
        $user->phone    = $request->get('phone');
        if ($request->file('avatar')) {
            if ($user->avatar && file_exists(storage_path('app/public/' . $user->avatar))) {
                \Storage::delete('public/' . $user->avatar);
            }
            $file = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $file;
        }
        $user->save();
        return redirect()->route('users.setting')->with('status', 'Setting successfully updated');
    }

    public function password()
    {
        return view('users.password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!\Hash::check($value, \Auth::user()->password)) {
                        $fail('Old Password didn\'t match');
                    }
                }
            ],
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required',
        ]);

        $id = \Auth::user()->id;
        $user = User::findOrFail($id);
        $user->password = \Hash::make($request->get('password'));
        $user->save();

        return redirect()->route('users.password')->with('status', 'Password successfully updated');
    }
}
