<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       
    }

    public function showLoginForm()
    {
     
        return view('auth.login');
    }

    // protected function hasTooManyLoginAttempts(Request $request)
    // {
    //     return $this->limiter()->tooManyAttempts(
    //         $this->throttleKey($request), 2, 2
    //     );
    // }

    protected function validateLogin(Request $request)
    {
        
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
    }

    protected function attemptLogin(Request $request)
    {
     
     
        return Auth::guard('web')->attempt(
            $this->credentials($request,$request->boolean('remember')), 
        );
    }

    protected function credentials(Request $request)
    {
       
        return [
            
            'email' => $request->email,
            'password' => $request->password,
            'status' => 1,
            'role_id' => 3,
        ];
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return $this->loggedOut($request) ?: redirect('/login');
    }

    /**
     * The user has logged out of the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        Log::info('User logout successful.');
    }

    /**
     * Get the path the user should be redirected to when they are authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @return string|null
     */
    
    protected function sendFailedLoginResponse(Request $request)
    {
        return redirect()->back()->with([
            'error' => 'The provided credentials do not match our records.'
        ], 406);
    }

    protected function authenticated(Request $request, $user)
    {
       
        return redirect('/home');
    }
}
