<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{

    /**
     * Route /
     * If logged in loads logged in view else login form
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        //Check if authorized
        if (Auth::check()) {
            //Load dashboard view
            return view('dashboard');
        }
        return view('auth/login');
    }

    /**
     * Route /register
     * If authorized redirects  to dashboard
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function register()
    {
        //Check if authorized
        if (Auth::check()) {
            //Redirect to dashboard
            return Redirect::to("dashboard");
        }
        return view('auth/register');
    }

    /**
     * Route /logout
     * Logs out user
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout()
    {
        Session::flush();
        Auth::logout();
        return Redirect('login');
    }

    /**
     * Route post /post-register
     * Validates user input data, registers the user
     *
     * @param Request $request
     * @return mixed
     */
    public function postRegister(Request $request)
    {
        //Check database connection, if something wrong return error
        if($this->checkDBConnection() === false) {
            die("Could not find the database. Please check your configuration.");
        }
        //Validate name, email and password
        request()->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
        //Put everything that is
        $data = $request->all();
        //Create user
        User::create([
            'name' => $data['name'],
            'email' => trim(strtolower($data['email'])),
            'password' => Hash::make($data['password'])
        ]);

        return Redirect::to("/")->withSuccess('Great! You have successfully registered!');
    }

    /**
     * Route post /post-login
     * Posts login credentials and logs in if found user, else returns error
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postLogin(Request $request)
    {
        //Validate input data
        request()->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        //Setup credentials in variable
        $credentials = $request->only('email', 'password');
        //Change email to lower string like in registration form
        $credentials['email'] = trim(strtolower($credentials['email']));
        //Attempt auth and redirect if successful
        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard');
        }
        //Returns error to login view
        return Redirect::to("login")->withError('Oops! You have entered invalid credentials.');
    }

    /**
     * Route / if logged in or /dashboard
     * Shows the RSS feed and logout option
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function dashboard()
    {
        if (Auth::check()) {
            return view('dashboard');
        }
        return Redirect::to("login");
    }


    /**
     * Check database connection, if something is wrong return false
     *
     * @return bool
     */
    public function checkDBConnection(){
        try {
            DB::connection()->getPdo();
            if(!DB::connection()->getDatabaseName()){
               return false;
            }
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }
}


