<?php

namespace App\Http\Controllers\AuthDbpass;

use Session;
use App\Models\Logs; 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
// use Illuminate\Foundation\Auth\AuthenticatesUsers;
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
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:dbpass')->except('logout');
    }

     /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('authDbpass.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        
        $this->validate($request, [
            'NamaUser' => 'required|string',
            'Password' => 'required|string',
            // 'Shift'    => 'required|string'
        ]);

        $credential = [
            'NamaUser' => strtoupper($request->NamaUser),
            'Password' => strtoupper($request->Password),
            // 'Shift'    => $request->Shift,
        ];

        Log::info($credential);
        if(Auth::guard('dbpass')->attempt($credential,$request->member)){
            Log::info('Logged In');
            $request->session()->put('Shift',$request->Shift); 
            return redirect()->intended(route('beranda'));
        } else {
            Log::info('Not Logged In');
        }
        return redirect()->back()->withInput($request->only('NamaUser','Remember'));
    }

}
