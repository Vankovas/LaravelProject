<?php

namespace App\Exports;

use App\Post;
use App\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
//Exporting user's posts
//        if (Auth::check()) {
//            $posts = Post::orderBy('created_at', 'desc')->get();
//            $user = Auth::user();
//            return $user->posts;
//
//        } else {
//
//        }
        return User::all();
    }
}
