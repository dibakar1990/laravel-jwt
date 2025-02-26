<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\ResponseTrait;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    use ResponseTrait;
    protected $username;

    public function __construct()
    {
        $this->username = $this->findUsername();
    }
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];
        $customMessages = [
            'username.required' => 'This field is required',
            'password.required' => 'This field is required'
        ];
        $validator = Validator::make($request->all(), $rules, $customMessages);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $credentials = [
            $this->username => $request->{$this->username},
            'password' => $request->password,
            'status' => 1,
            'role_id' => [1,2]
        ];
        
        $remember = $request->has('remember') ? true : false;
        if (Auth::guard('admin')->attempt($credentials,$remember)) {
            $user = Auth::guard('admin')->user();
            return redirect()->route('admin.dashboard');
        }
        $redirect = route('admin.login');
        return $this->error($redirect, 'The provided credentials do not match our records.');
    }

    public function findUsername()
    {
        $login = request('username');
       
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
 
        request(null)->merge([$fieldType => $login]);
 
        return $fieldType;
    }

    public function logout(){
        Session::flush();
        Auth::guard('admin')->logout();         
        return Redirect('admin/login');
    }
}
