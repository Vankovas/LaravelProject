<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
//Use Post from App
use App\Post;
use App\User;
use Auth;


class PDFMaker extends Controller
{
    public function index()
    {
        if(Auth::check()){
        $posts = Post::orderBy('created_at', 'desc')->get();
        $pdf = PDF::loadView('pdf.overview');
        return $pdf->download('overview.pdf');
        // return view('posts.index')->with('posts', $posts);
        }
        else {
            return redirect('login')->with('error',"You are not logged in!");
        }
    }
}
