<?php

namespace App\Http\Controllers;

use App\Models\Feed;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
    public function login()
    {
        //Check if authorized
        if (Auth::check()) {
            return redirect('/');
        }
        return view('auth/login');
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

}


