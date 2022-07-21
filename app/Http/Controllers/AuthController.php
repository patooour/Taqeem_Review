<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function getlogin(){


        return view('login');
    }

    public function doRegister(Request $request){


        $rules = [
            'firstname' => 'required|min:1|max:60',
            'lastname' => 'required|min:1|max:60',
            'username' => 'required|min:4|max:100',
            'email' => 'required|email|min:4|max:125|unique:users,email',
            'password' => 'required|min:4|max:100',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withInput($request->all())
                ->withErrors($validator->errors()->all());
        }
        $user = User::select('id')->orderBy('id','DESC')->get()->value('id');

        
        $newUser = new User();
        $newUser->id = $user + 1;
        $newUser->username = $request->get('username');
        $newUser->firstname = $request->get('firstname');
        $newUser->lastname = $request->get('lastname');
        $newUser->email = $request->get('email');
        $newUser->password = bcrypt($request->get('password'));
        $newUser->save();

        $result = Auth::attempt([
            'username' => $request->get('username'),
            'password' => $request->get('password')
        ]);
        return redirect('/');
    }

    public function doLogout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function doLogin(Request $request)
    {

        $rules = [
            'email' => 'required',
            'password' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withInput($request->all())
                ->withErrors($validator->errors()->all());
        }

        $email = $request->get('email');
        $password = $request->get('password');

        $result = Auth::attempt(['email' => $email, 'password' => $password]);

        if ($result) {
            return redirect('/');
        } else {
            return redirect('/login')
                ->with(['error' => 'login failed try again']);
        }
    }
}
