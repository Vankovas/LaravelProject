<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//TestClass
use App\Exports\UsersExport;
//Imports
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Auth;

class ExcelController extends Controller
{
//Excel Export
    public function export()
    {
        if (Auth::check()) {
            if (auth()->user()->type == "admin") {
                return Excel::download(new UsersExport, 'users.xlsx');
            } else {
                return redirect('login')->with('error', "You are not an admin :)");
            }
        } else {
            return redirect('login')->with('error', "You are not logged in!");
        }
    }
}
