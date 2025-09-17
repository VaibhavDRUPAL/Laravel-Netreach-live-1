<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use anlutro\LaravelSettings\Facade as Setting;
use App\Models\FCMToken;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
    protected $maxAttempts;
    protected $decayMinutes;

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->maxAttempts = Setting::get('max_login_attempts', 3);
        $this->decayMinutes = Setting::get('lockout_delay', 2);
    }

    public function loginVerify(Request $request)
    {
        $data = User::where('vn_email', $request->input('email'))->first();

        return !empty($data) && $data['user_type'] == 1 ? intval(true) : intval(false);
    }

    public function login(Request $request)
    {
        request()->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            flash('You are locked! Too many attempts. please try ' . setting('lockout_delay') . ' mintutes later.')->warning();
            return redirect()->route('login')->withInput();
            return $this->sendLockoutResponse($request);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt(['vn_email' => $credentials['email'], 'password' => $credentials['password']], $request->remember)) {
            $user = Auth::user();
            $userStatus =  $user->status;
            $fcmToken = $request->input('fcmToken');
            if ($userStatus == 1) {
                activity('login')->causedBy(Auth::user())->log('home');

                if ($fcmToken) {
                    // Attempt to find the existing token record
                    $fcmTokenRecord = FCMToken::where('user_id', Auth::id())->first();
                    if (!$fcmTokenRecord) {
                        FCMToken::create([
                            'user_id' => Auth::id(),
                            'token' => $fcmToken,
                        ]);
                    }
                }

                return redirect()->intended(url('/home'));
            } else {
                Auth::logout();
                flash('You are temporary blocked. please contact to admin')->warning();
                return redirect()->route('login')->withInput();
            }
        } else {
            $this->incrementLoginAttempts($request);
            flash('Incorrect username or password. Please try again')->error();
            return redirect()->route('login')->withInput();
        }
    }

    public function logout(Request $request)
    {
        activity('logout')->causedBy(Auth::user())->log('logout');
        Auth::logout();
        return redirect('/login');
    }
}
