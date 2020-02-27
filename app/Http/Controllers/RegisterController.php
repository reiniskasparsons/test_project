<?php

namespace App\Http\Controllers;

use App\Http\Helpers\DBConnectionHelper;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class RegisterController extends Controller
{

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
     * Route post /post-register
     * Validates user input data, registers the user
     *
     * @param Request $request
     * @return mixed
     */
    public function postRegister(Request $request)
    {
        //Check database connection, if something wrong return error
        if(DBConnectionHelper::checkDBConnection() === false) {
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
     * Route /check-email
     * Checks if user exists
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkEmailAvailability(Request $request){
        //get email and trim and set it to lowerstring for check
        $email = trim(strtolower($request->post('email')));
        //Try and find the user
        $user  = User::where('email', $email)->first();
        //If user found sets to true not send user with variables to view else set it to false since laravel sets it to null
        if($user) {
            $user = true;
        }else {
            $user = false;
        }
        //Return json response for view
        return response()->json(['user'=> $user], 200);
    }
}


