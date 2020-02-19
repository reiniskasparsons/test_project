<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        if(Auth::check()){
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
        if(Auth::check()){
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
    public function logout() {
        Session::flush();
        Auth::logout();
        return Redirect('login');
    }

}
