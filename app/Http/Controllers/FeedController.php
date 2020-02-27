<?php

namespace App\Http\Controllers;

use App\Http\Helpers\FeedHelper;
use App\Models\Feed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class FeedController extends Controller
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
            $feed  = simplexml_load_file(env('RSS_FEED', "https://www.theregister.co.uk/software/headlines.atom"));
            $topCommonWords = FeedHelper::getCommonWords($feed);
            return view('dashboard', ['feed' => $feed, 'topWords' => $topCommonWords]);
        }
        return view('auth/login');
    }

    /**
     * Route / if logged in or /dashboard
     * Shows the RSS feed and logout option
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function dashboard(Request $request)
    {
        if (Auth::check()) {
            $feed  = simplexml_load_file(env('RSS_FEED', "https://www.theregister.co.uk/software/headlines.atom"));
            $topCommonWords = FeedHelper::getCommonWords($feed);
            return view('dashboard', ['feed' => $feed, 'topWords' => $topCommonWords]);
        }
        return Redirect::to("login");
    }
}


