<?php

namespace App\Http\Controllers;

use App\Http\Managers\VideoManager;
use App\Models\Course;
use App\Models\Section;
use Cocur\Slugify\Slugify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CurriculumController extends Controller
{
    protected $videoManager;

    public function __construct(VideoManager $videoManager)
    {
        $this->videoManager = $videoManager;
    }

    public function index($id)
    {
        $course = Course::find($id);

        return view('instructor.curriculum.index',[
            'course' => $course
        ]);
    }

    public function create($id)
    {
        $course = Course::find($id);
        return view('instructor.curriculum.create', [
            'course' => $course
        ]);
    }

    public function store(Request $request, $id)
    {
        $course = Course::find($id);

        $section = new Section();
        $section->name = $request->input('section_name');

        $slugify = new Slugify();
        $section->slug = $slugify->slugify($section->name);

        $section->course_id = $id;

        // Traitement de la video :
        // ------------------------
        $video = $request->file('section_video');
        $videoFile = $this->videoManager->videoStorage($video);
        $section->video = $videoFile;

        // Calcul du Temps de la video :
        // -----------------------------
        $playtime = $this->videoManager->getVideoDuration($videoFile);
        $section->playtime_seconds = $playtime;

        $section->save();

        return redirect()->route('instructor.curriculum.index', $course->id);

    }
}
