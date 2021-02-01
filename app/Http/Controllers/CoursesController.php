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

        $recommandations = Course::where('is_published',true)
            ->where('category_id', $course->category_id)
            ->where('id','!=', $course->id)
            ->limit(3)
            ->get();

        return view('courses.show', [
            'course' => $course,
            'recommandations' => $recommandations
        ]);
    }
}
