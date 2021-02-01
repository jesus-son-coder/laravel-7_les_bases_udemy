<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CoursesController extends Controller
{
    public function courses()
    {
        $courses = Course::where('is_published',true)->get();

        return view('courses.index',[
            'courses' => $courses
        ]);
    }

    public function course($slug)
    {
        $course = Course::where('slug',$slug)->firstOrFail();
        return view('courses.show', [
            'course' => $course
        ]);
    }
}
