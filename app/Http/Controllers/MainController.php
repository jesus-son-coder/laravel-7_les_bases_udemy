<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function home()
    {
        dd(Course::all());
        return view('main.home');
    }
}
