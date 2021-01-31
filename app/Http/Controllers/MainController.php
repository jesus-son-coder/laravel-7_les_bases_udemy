<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function home()
    {
        //dd(Course::all());
        $course = Course::where('id',1)->firstOrFail();
        dd($course->category);
        return view('main.home');
    }
}
