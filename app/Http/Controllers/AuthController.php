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
     * Route post /register
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
            'email' => strtolower($data['email']),
            'password' => Hash::make($data['password'])
        ]);

        return Redirect::to("/")->withSuccess('Great! You have successfully registered!');
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


