<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

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
    protected $redirectAfterLogout = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function login(Request $request)
    {
        // dd($request->all());
        $data =  DB::table('vessels')
        ->leftJoin('vessel_details', 'vessels.unique_id', '=', 'vessel_details.id')
        ->select('vessels.*')
        ->get();
        $user_details = DB::table('users')->where('email',$request->email)->first();
        // dd($user_details); 
        if($user_details){
            $request->session()->put('fname', $user_details->first_name);
            $request->session()->put('lname', $user_details->last_name);
            $request->session()->put('email', $user_details->email);
            $request->session()->put('is_ship', $user_details->is_ship);
            $request->session()->put('creator_id', $user_details->creator_id);
            $request->session()->put('id', $user_details->id);
        }  
        
        // dd('id',session('id'));
        // $request->session()->put('vessels',$data);
        //  dd(session('fname'));
        // Log::info('is_ship '.print_r(session('is_ship'),true));
        // dd(session('is_ship'));
        //$v = session('vessels')[0];
        // dd($v);
        //$request->session()->put('selected',$v);
        Log::info('login');
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            Log::info('attempt login if');
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
         $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }


    /**
     * Logout, Clear Session, and Return.
     *
     * @return void
     */
    public function logout()
    {
        // $user = Auth::user();
        // Log::info('User Logged Out. ', [$user]);
        Auth::logout();
        Session::flush();

        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');
    }
}
