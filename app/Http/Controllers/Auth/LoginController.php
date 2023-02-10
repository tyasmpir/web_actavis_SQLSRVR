<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Hashing\BcryptHasher;

use Auth;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //session(['url.intended' => url()->previous()]);
        //$this->redirectTo = session()->get('url.intended');
        $this->middleware('guest')->except('logout');
    }

    public function username(){
        return 'username';
    }

    protected function authenticated(Request $request)
    {
        // Ambil Username Session
        $username = $request->input('username');
        $id = Auth::id();
        // Set Session Username & ID
        Session::put('userid', $id);
        //$request->session()->put('username', $username);

        $user = DB::table('users')
                    ->join('roles','users.role_user','roles.role_code')
                    ->where('users.id','=',$id)
                    // ->where('active','=','yes')
                    ->first();

        $cekAktif = DB::table('users')
            ->where('username','=',$username)
            ->first();

        if(!is_null($user)){
            if ($cekAktif->active == 'No') {
                Auth::logout();
                return redirect()->back()->with(['error'=>'Username tidak aktif.']);
            }
            else{
                Session::put('username',$user->username);
                Session::put('menu_access', $user->menu_access);
                Session::put('name', $user->name);
                Session::put('department', $user->dept_user);
                Session::put('role', $user->role_user);
            }
        } else {
            return redirect()->back()->with(['error'=>'Username salah / tidak terdaftar']);
            //dd($request->all());
        }
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $previous_session = Auth::User()->session_id;
        if ($previous_session) {
            \Session::getHandler()->destroy($previous_session);
        }

        Auth::user()->session_id = \Session::getId();
        
        Auth::user()->save();
        $this->clearLoginAttempts($request);
        // session_destroy();
        // dd(session()->all());
        return $this->authenticated($request, $this->guard()->user())
                ?: redirect()->intended($this->redirectPath());
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        // dd($request->all());
        $data = DB::table('users')
                    ->where('username','=',$request->username)
                    ->get();
     
        if(count($data) == 0){
            return redirect()->back()->with(['error'=>'Username salah / tidak terdaftar']);
        } else {

            $cekAktif = DB::table('users')
                    ->where('username','=',$request->username)
                    ->first();

            if ($cekAktif->active != 'Yes') {
                return redirect()->back()->with(['error'=>'Username tidak aktif.']);
            }
        }

        $hasher = app('hash');

        $users = DB::table("users")
                    ->select('id','password')
                    ->where("users.username",$request->username)
                    ->first();

        if(!$hasher->check($request->password,$users->password))
        {   
            return redirect()->back()->with(['error'=>'Password salah']);
        }
    }

}
