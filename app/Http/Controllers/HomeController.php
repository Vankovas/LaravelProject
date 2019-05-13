<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->type == "admin") {
            return view('home')->with('posts', Post::orderBy('updated_at', 'ASC')->get());
        } else {
            $user_id = auth()->user()->id;
            $user = User::find($user_id);
            return view('home')->with('posts', $user->posts);
        }
    }
}
